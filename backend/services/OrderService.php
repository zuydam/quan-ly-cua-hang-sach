<?php
require_once '../config/database.php';
require_once 'PromotionService.php';
require_once 'PaymentService.php';

class OrderService {
    private $db;
    private $promotionService;
    private $paymentService;

    public function __construct() {
        $this->db = new Database();
        $this->promotionService = new PromotionService();
        $this->paymentService = new PaymentService();
    }

    public function getAllOrders() {
        try {
            $sql = "SELECT o.*, c.Name as CustomerName, c.Email as CustomerEmail,
                           COUNT(od.BookID) as TotalItems,
                           pm.MethodName as PaymentMethodName,
                           p.PromotionCode, p.PromotionName
                    FROM Orders o
                    LEFT JOIN Customers c ON o.CustomerID = c.CustomerID
                    LEFT JOIN OrderDetails od ON o.OrderID = od.OrderID
                    LEFT JOIN PaymentMethods pm ON o.PaymentMethodID = pm.PaymentMethodID
                    LEFT JOIN Promotions p ON o.PromotionID = p.PromotionID
                    GROUP BY o.OrderID
                    ORDER BY o.OrderDate DESC";
            $result = $this->db->query($sql);
            
            $orders = [];
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
            return $orders;
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy danh sách đơn hàng: " . $e->getMessage());
        }
    }

    public function getOrderById($orderId) {
        try {
            $stmt = $this->db->prepare("SELECT o.*, c.Name as CustomerName, c.Email as CustomerEmail
                                       FROM Orders o
                                       LEFT JOIN Customers c ON o.CustomerID = c.CustomerID
                                       WHERE o.OrderID = ?");
            $stmt->bind_param("i", $orderId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy thông tin đơn hàng: " . $e->getMessage());
        }
    }

    public function getOrderDetails($orderId) {
        try {
            $stmt = $this->db->prepare("SELECT od.*, b.Title, b.Author, b.Price as BookPrice
                                       FROM OrderDetails od
                                       LEFT JOIN Books b ON od.BookID = b.BookID
                                       WHERE od.OrderID = ?");
            $stmt->bind_param("i", $orderId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $details = [];
            while ($row = $result->fetch_assoc()) {
                $details[] = $row;
            }
            return $details;
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy chi tiết đơn hàng: " . $e->getMessage());
        }
    }

    public function createOrder($orderData) {
        try {
            $this->validateOrderData($orderData);
            
            // Calculate subtotal from items
            $subTotal = 0;
            foreach ($orderData->items as $item) {
                $subTotal += $item->Quantity * $item->Price;
            }
            
            // Handle promotion if provided
            $discountAmount = 0;
            $promotionID = null;
            if (!empty($orderData->PromotionCode)) {
                $promotionValidation = $this->promotionService->validatePromotion(
                    $orderData->PromotionCode, 
                    $orderData->CustomerID, 
                    $subTotal, 
                    $orderData->items
                );
                
                if ($promotionValidation['valid']) {
                    $promotion = $promotionValidation['promotion'];
                    $discountAmount = $this->promotionService->calculateDiscount($promotion, $subTotal, $orderData->items);
                    $promotionID = $promotion['PromotionID'];
                } else {
                    throw new Exception($promotionValidation['message']);
                }
            }
            
            // Calculate final total
            $finalTotal = $subTotal - $discountAmount;
            
            // Validate payment method
            if (!empty($orderData->PaymentMethodID)) {
                if (!$this->paymentService->validatePaymentMethod($orderData->PaymentMethodID)) {
                    throw new Exception("Phương thức thanh toán không hợp lệ");
                }
            }
            
            // Bắt đầu transaction
            $this->db->getConnection()->begin_transaction();
            
            try {
                // Tạo đơn hàng với thông tin mới
                $stmt = $this->db->prepare("INSERT INTO Orders (CustomerID, OrderDate, SubTotal, DiscountAmount, TotalAmount, PaymentMethodID, PromotionID, PaymentStatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $paymentStatus = !empty($orderData->PaymentMethodID) ? 'pending' : 'pending';
                $stmt->bind_param("isddiiis", 
                    $orderData->CustomerID, 
                    $orderData->OrderDate, 
                    $subTotal,
                    $discountAmount,
                    $finalTotal,
                    $orderData->PaymentMethodID,
                    $promotionID,
                    $paymentStatus
                );
                
                if (!$stmt->execute()) {
                    throw new Exception("Lỗi khi tạo đơn hàng: " . $stmt->error);
                }
                
                $orderId = $stmt->insert_id;
                
                // Thêm chi tiết đơn hàng
                foreach ($orderData->items as $item) {
                    // Kiểm tra tồn kho
                    $stockStmt = $this->db->prepare("SELECT Stock, InputQuantity, OutputQuantity FROM Books WHERE BookID = ?");
                    $stockStmt->bind_param("i", $item->BookID);
                    $stockStmt->execute();
                    $stockResult = $stockStmt->get_result();
                    $bookStock = $stockResult->fetch_assoc();
                    
                    if (!$bookStock || $bookStock['Stock'] < $item->Quantity) {
                        throw new Exception("Sách ID {$item->BookID} không đủ tồn kho");
                    }
                    
                    // Thêm chi tiết đơn hàng
                    $detailStmt = $this->db->prepare("INSERT INTO OrderDetails (OrderID, BookID, Quantity, Price) VALUES (?, ?, ?, ?)");
                    $detailStmt->bind_param("iiid", $orderId, $item->BookID, $item->Quantity, $item->Price);
                    
                    if (!$detailStmt->execute()) {
                        throw new Exception("Lỗi khi thêm chi tiết đơn hàng: " . $detailStmt->error);
                    }
                    
                    // Cập nhật OutputQuantity và Stock
                    $newOutputQuantity = $bookStock['OutputQuantity'] + $item->Quantity;
                    $newStock = $bookStock['InputQuantity'] - $newOutputQuantity;
                    
                    $updateStockStmt = $this->db->prepare("UPDATE Books SET OutputQuantity = ?, Stock = ? WHERE BookID = ?");
                    $updateStockStmt->bind_param("iii", $newOutputQuantity, $newStock, $item->BookID);
                    
                    if (!$updateStockStmt->execute()) {
                        throw new Exception("Lỗi khi cập nhật tồn kho: " . $updateStockStmt->error);
                    }
                }
                
                // Record promotion usage if promotion was applied
                if ($promotionID) {
                    $this->promotionService->recordPromotionUsage($promotionID, $orderId, $orderData->CustomerID, $discountAmount);
                }
                
                // Process payment if payment method is provided
                if (!empty($orderData->PaymentMethodID)) {
                    $transactionID = $this->paymentService->generateTransactionID($orderId);
                    $paymentResult = $this->paymentService->processPayment($orderId, $orderData->PaymentMethodID, $finalTotal, $transactionID);
                    
                    if (!$paymentResult['success']) {
                        throw new Exception($paymentResult['message']);
                    }
                }
                
                // Commit transaction
                $this->db->getConnection()->commit();
                
                return ["status" => "success", "message" => "Tạo đơn hàng thành công", "orderId" => $orderId];
                
            } catch (Exception $e) {
                // Rollback transaction
                $this->db->getConnection()->rollback();
                throw $e;
            }
            
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateOrder($orderData) {
        try {
            if (!isset($orderData->OrderID)) {
                throw new Exception("Thiếu ID đơn hàng để cập nhật");
            }
            
            $this->validateOrderData($orderData);
            
            $stmt = $this->db->prepare("UPDATE Orders SET CustomerID=?, OrderDate=?, TotalAmount=? WHERE OrderID=?");
            $stmt->bind_param("isdi", 
                $orderData->CustomerID, 
                $orderData->OrderDate, 
                $orderData->TotalAmount, 
                $orderData->OrderID
            );
            
            if (!$stmt->execute()) {
                throw new Exception("Lỗi khi cập nhật đơn hàng: " . $stmt->error);
            }
            
            return ["status" => "success", "message" => "Cập nhật đơn hàng thành công"];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function deleteOrder($orderId) {
        try {
            // Bắt đầu transaction
            $this->db->getConnection()->begin_transaction();
            
            try {
                // Lấy chi tiết đơn hàng để hoàn trả tồn kho
                $stmt = $this->db->prepare("SELECT BookID, Quantity FROM OrderDetails WHERE OrderID = ?");
                $stmt->bind_param("i", $orderId);
                $stmt->execute();
                $result = $stmt->get_result();
                
                while ($row = $result->fetch_assoc()) {
                    // Lấy thông tin sách hiện tại
                    $bookStmt = $this->db->prepare("SELECT InputQuantity, OutputQuantity FROM Books WHERE BookID = ?");
                    $bookStmt->bind_param("i", $row['BookID']);
                    $bookStmt->execute();
                    $bookResult = $bookStmt->get_result();
                    $bookData = $bookResult->fetch_assoc();
                    
                    if ($bookData) {
                        // Hoàn trả OutputQuantity và tính lại Stock
                        $newOutputQuantity = $bookData['OutputQuantity'] - $row['Quantity'];
                        $newStock = $bookData['InputQuantity'] - $newOutputQuantity;
                        
                        $updateStockStmt = $this->db->prepare("UPDATE Books SET OutputQuantity = ?, Stock = ? WHERE BookID = ?");
                        $updateStockStmt->bind_param("iii", $newOutputQuantity, $newStock, $row['BookID']);
                        $updateStockStmt->execute();
                    }
                }
                
                // Xóa chi tiết đơn hàng
                $stmt = $this->db->prepare("DELETE FROM OrderDetails WHERE OrderID = ?");
                $stmt->bind_param("i", $orderId);
                $stmt->execute();
                
                // Xóa đơn hàng
                $stmt = $this->db->prepare("DELETE FROM Orders WHERE OrderID = ?");
                $stmt->bind_param("i", $orderId);
                
                if (!$stmt->execute()) {
                    throw new Exception("Lỗi khi xóa đơn hàng: " . $stmt->error);
                }
                
                if ($stmt->affected_rows === 0) {
                    throw new Exception("Không tìm thấy đơn hàng để xóa");
                }
                
                // Commit transaction
                $this->db->getConnection()->commit();
                
                return ["status" => "success", "message" => "Xóa đơn hàng thành công"];
                
            } catch (Exception $e) {
                // Rollback transaction
                $this->db->getConnection()->rollback();
                throw $e;
            }
            
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getOrdersByDateRange($startDate, $endDate) {
        try {
            $stmt = $this->db->prepare("SELECT o.*, c.Name as CustomerName,
                                              COUNT(od.BookID) as TotalItems
                                       FROM Orders o
                                       LEFT JOIN Customers c ON o.CustomerID = c.CustomerID
                                       LEFT JOIN OrderDetails od ON o.OrderID = od.OrderID
                                       WHERE o.OrderDate BETWEEN ? AND ?
                                       GROUP BY o.OrderID
                                       ORDER BY o.OrderDate DESC");
            $stmt->bind_param("ss", $startDate, $endDate);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $orders = [];
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
            return $orders;
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy đơn hàng theo khoảng thời gian: " . $e->getMessage());
        }
    }

    public function getOrderStatistics() {
        try {
            $sql = "SELECT 
                        COUNT(*) as TotalOrders,
                        COALESCE(SUM(TotalAmount), 0) as TotalRevenue,
                        AVG(TotalAmount) as AverageOrderValue,
                        COUNT(DISTINCT CustomerID) as UniqueCustomers
                    FROM Orders";
            $result = $this->db->query($sql);
            return $result->fetch_assoc();
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy thống kê đơn hàng: " . $e->getMessage());
        }
    }

    private function validateOrderData($orderData) {
        if (empty($orderData->CustomerID)) {
            throw new Exception("Vui lòng chọn khách hàng");
        }
        if (empty($orderData->OrderDate)) {
            throw new Exception("Ngày đặt hàng không được để trống");
        }
        if (!is_numeric($orderData->TotalAmount) || $orderData->TotalAmount <= 0) {
            throw new Exception("Tổng tiền phải là số dương");
        }
        if (empty($orderData->items) || !is_array($orderData->items)) {
            throw new Exception("Đơn hàng phải có ít nhất một sản phẩm");
        }
        
        foreach ($orderData->items as $item) {
            if (empty($item->BookID)) {
                throw new Exception("Thiếu thông tin sách");
            }
            if (!is_numeric($item->Quantity) || $item->Quantity <= 0) {
                throw new Exception("Số lượng phải là số dương");
            }
            if (!is_numeric($item->Price) || $item->Price <= 0) {
                throw new Exception("Giá phải là số dương");
            }
        }
    }

    public function __destruct() {
        $this->db->closeConnection();
    }
}
?>

