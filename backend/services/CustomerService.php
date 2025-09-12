<?php
require_once '../config/database.php';

class CustomerService {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllCustomers() {
        try {
            $sql = "SELECT c.*, 
                           COUNT(o.OrderID) as TotalOrders,
                           COALESCE(SUM(o.TotalAmount), 0) as TotalSpent
                    FROM Customers c
                    LEFT JOIN Orders o ON c.CustomerID = o.CustomerID
                    GROUP BY c.CustomerID
                    ORDER BY c.CustomerID DESC";
            $result = $this->db->query($sql);
            
            $customers = [];
            while ($row = $result->fetch_assoc()) {
                $customers[] = $row;
            }
            return $customers;
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy danh sách khách hàng: " . $e->getMessage());
        }
    }

    public function getCustomerById($customerId) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM Customers WHERE CustomerID = ?");
            $stmt->bind_param("i", $customerId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy thông tin khách hàng: " . $e->getMessage());
        }
    }

    public function searchCustomers($query) {
        try {
            $searchTerm = "%$query%";
            $stmt = $this->db->prepare("SELECT c.*, 
                                              COUNT(o.OrderID) as TotalOrders,
                                              COALESCE(SUM(o.TotalAmount), 0) as TotalSpent
                                       FROM Customers c
                                       LEFT JOIN Orders o ON c.CustomerID = o.CustomerID
                                       WHERE c.Name LIKE ? OR c.Email LIKE ? OR c.Phone LIKE ?
                                       GROUP BY c.CustomerID
                                       ORDER BY c.CustomerID DESC");
            $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $customers = [];
            while ($row = $result->fetch_assoc()) {
                $customers[] = $row;
            }
            return $customers;
        } catch (Exception $e) {
            throw new Exception("Lỗi khi tìm kiếm khách hàng: " . $e->getMessage());
        }
    }

    public function createCustomer($customerData) {
        try {
            $this->validateCustomerData($customerData);
            
            // Kiểm tra email đã tồn tại chưa
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM Customers WHERE Email = ?");
            $stmt->bind_param("s", $customerData->Email);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            if ($row['count'] > 0) {
                throw new Exception("Email đã tồn tại trong hệ thống");
            }
            
            $stmt = $this->db->prepare("INSERT INTO Customers (Name, Email, Phone) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", 
                $customerData->Name, 
                $customerData->Email, 
                $customerData->Phone
            );
            
            if (!$stmt->execute()) {
                throw new Exception("Lỗi khi thêm khách hàng: " . $stmt->error);
            }
            
            return ["status" => "success", "message" => "Thêm khách hàng thành công", "id" => $stmt->insert_id];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateCustomer($customerData) {
        try {
            $this->validateCustomerData($customerData);
            
            if (!isset($customerData->CustomerID)) {
                throw new Exception("Thiếu ID khách hàng để cập nhật");
            }
            
            // Kiểm tra email đã tồn tại chưa (trừ khách hàng hiện tại)
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM Customers WHERE Email = ? AND CustomerID != ?");
            $stmt->bind_param("si", $customerData->Email, $customerData->CustomerID);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            if ($row['count'] > 0) {
                throw new Exception("Email đã tồn tại trong hệ thống");
            }
            
            $stmt = $this->db->prepare("UPDATE Customers SET Name=?, Email=?, Phone=? WHERE CustomerID=?");
            $stmt->bind_param("sssi", 
                $customerData->Name, 
                $customerData->Email, 
                $customerData->Phone, 
                $customerData->CustomerID
            );
            
            if (!$stmt->execute()) {
                throw new Exception("Lỗi khi cập nhật khách hàng: " . $stmt->error);
            }
            
            return ["status" => "success", "message" => "Cập nhật khách hàng thành công"];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function deleteCustomer($customerId) {
        try {
            // Kiểm tra xem khách hàng có đơn hàng nào không
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM Orders WHERE CustomerID = ?");
            $stmt->bind_param("i", $customerId);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            if ($row['count'] > 0) {
                throw new Exception("Không thể xóa khách hàng vì đã có đơn hàng");
            }
            
            $stmt = $this->db->prepare("DELETE FROM Customers WHERE CustomerID = ?");
            $stmt->bind_param("i", $customerId);
            
            if (!$stmt->execute()) {
                throw new Exception("Lỗi khi xóa khách hàng: " . $stmt->error);
            }
            
            if ($stmt->affected_rows === 0) {
                throw new Exception("Không tìm thấy khách hàng để xóa");
            }
            
            return ["status" => "success", "message" => "Xóa khách hàng thành công"];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getCustomerOrders($customerId) {
        try {
            $stmt = $this->db->prepare("SELECT o.*, 
                                              COUNT(od.BookID) as TotalItems
                                       FROM Orders o
                                       LEFT JOIN OrderDetails od ON o.OrderID = od.OrderID
                                       WHERE o.CustomerID = ?
                                       GROUP BY o.OrderID
                                       ORDER BY o.OrderDate DESC");
            $stmt->bind_param("i", $customerId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $orders = [];
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
            return $orders;
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy đơn hàng của khách hàng: " . $e->getMessage());
        }
    }

    public function getTopCustomers($limit = 10) {
        try {
            $stmt = $this->db->prepare("SELECT c.*, 
                                              COUNT(o.OrderID) as TotalOrders,
                                              COALESCE(SUM(o.TotalAmount), 0) as TotalSpent
                                       FROM Customers c
                                       LEFT JOIN Orders o ON c.CustomerID = o.CustomerID
                                       GROUP BY c.CustomerID
                                       ORDER BY TotalSpent DESC
                                       LIMIT ?");
            $stmt->bind_param("i", $limit);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $customers = [];
            while ($row = $result->fetch_assoc()) {
                $customers[] = $row;
            }
            return $customers;
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy top khách hàng: " . $e->getMessage());
        }
    }

    private function validateCustomerData($customerData) {
        if (empty($customerData->Name)) {
            throw new Exception("Tên khách hàng không được để trống");
        }
        if (empty($customerData->Email)) {
            throw new Exception("Email không được để trống");
        }
        if (!filter_var($customerData->Email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email không hợp lệ");
        }
        if (empty($customerData->Phone)) {
            throw new Exception("Số điện thoại không được để trống");
        }
        if (!preg_match("/^[0-9]{10,11}$/", $customerData->Phone)) {
            throw new Exception("Số điện thoại không hợp lệ");
        }
    }

    public function __destruct() {
        $this->db->closeConnection();
    }
}
?>






