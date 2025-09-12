<?php
require_once __DIR__ . '/../config/database.php';

class PromotionService {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Get all active promotions
    public function getActivePromotions() {
        $query = "SELECT p.*, pt.TypeName 
                  FROM Promotions p 
                  LEFT JOIN PromotionTypes pt ON p.PromotionID = pt.TypeID 
                  WHERE p.IsActive = 1 
                  AND p.StartDate <= CURDATE() 
                  AND p.EndDate >= CURDATE()
                  AND (p.UsageLimit IS NULL OR p.UsedCount < p.UsageLimit)
                  ORDER BY p.CreatedAt DESC";
        
        return $this->db->query($query);
    }

    // Get promotion by code
    public function getPromotionByCode($promotionCode) {
        $query = "SELECT p.*, pt.TypeName 
                  FROM Promotions p 
                  LEFT JOIN PromotionTypes pt ON p.PromotionID = pt.TypeID 
                  WHERE p.PromotionCode = ? 
                  AND p.IsActive = 1 
                  AND p.StartDate <= CURDATE() 
                  AND p.EndDate >= CURDATE()
                  AND (p.UsageLimit IS NULL OR p.UsedCount < p.UsageLimit)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $promotionCode);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Validate promotion for a specific order
    public function validatePromotion($promotionCode, $customerID, $orderAmount, $orderItems = []) {
        $promotion = $this->getPromotionByCode($promotionCode);
        
        if (!$promotion) {
            return ['valid' => false, 'message' => 'Mã khuyến mãi không hợp lệ hoặc đã hết hạn'];
        }

        // Check minimum order amount
        if ($orderAmount < $promotion['MinimumOrderAmount']) {
            return [
                'valid' => false, 
                'message' => 'Đơn hàng phải có giá trị tối thiểu ' . number_format($promotion['MinimumOrderAmount']) . 'đ'
            ];
        }

        // Check if customer has already used this promotion
        $usageQuery = "SELECT COUNT(*) as usage_count FROM PromotionUsage 
                       WHERE PromotionID = ? AND CustomerID = ?";
        $stmt = $this->db->prepare($usageQuery);
        $stmt->bind_param("ii", $promotion['PromotionID'], $customerID);
        $stmt->execute();
        $usage = $stmt->get_result()->fetch_assoc();

        if ($usage['usage_count'] > 0) {
            return ['valid' => false, 'message' => 'Bạn đã sử dụng mã khuyến mãi này'];
        }

        // Check promotion targets
        $targets = $this->getPromotionTargets($promotion['PromotionID']);
        $isValidTarget = $this->validatePromotionTargets($targets, $customerID, $orderItems);

        if (!$isValidTarget) {
            return ['valid' => false, 'message' => 'Mã khuyến mãi không áp dụng cho đơn hàng này'];
        }

        return ['valid' => true, 'promotion' => $promotion];
    }

    // Calculate discount amount
    public function calculateDiscount($promotion, $orderAmount, $orderItems = []) {
        $discountAmount = 0;

        if ($promotion['DiscountType'] === 'percentage') {
            $discountAmount = $orderAmount * ($promotion['DiscountValue'] / 100);
            
            // Apply maximum discount limit if set
            if ($promotion['MaximumDiscount'] && $discountAmount > $promotion['MaximumDiscount']) {
                $discountAmount = $promotion['MaximumDiscount'];
            }
        } else { // fixed_amount
            $discountAmount = $promotion['DiscountValue'];
        }

        return min($discountAmount, $orderAmount); // Discount cannot exceed order amount
    }

    // Record promotion usage
    public function recordPromotionUsage($promotionID, $orderID, $customerID, $discountAmount) {
        // Update promotion usage count
        $updateQuery = "UPDATE Promotions SET UsedCount = UsedCount + 1 WHERE PromotionID = ?";
        $stmt = $this->db->prepare($updateQuery);
        $stmt->bind_param("i", $promotionID);
        $stmt->execute();

        // Record usage
        $usageQuery = "INSERT INTO PromotionUsage (PromotionID, OrderID, CustomerID, DiscountAmount) 
                       VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($usageQuery);
        $stmt->bind_param("iiid", $promotionID, $orderID, $customerID, $discountAmount);
        return $stmt->execute();
    }

    // Get promotion targets
    private function getPromotionTargets($promotionID) {
        $query = "SELECT * FROM PromotionTargets WHERE PromotionID = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $promotionID);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Validate promotion targets
    private function validatePromotionTargets($targets, $customerID, $orderItems) {
        foreach ($targets as $target) {
            switch ($target['TargetType']) {
                case 'all':
                    return true; // Applies to all orders
                
                case 'customer':
                    if ($target['TargetID_Value'] && $target['TargetID_Value'] != $customerID) {
                        return false;
                    }
                    break;
                
                case 'product':
                    if ($target['TargetID_Value']) {
                        $hasTargetProduct = false;
                        foreach ($orderItems as $item) {
                            if ($item['BookID'] == $target['TargetID_Value']) {
                                $hasTargetProduct = true;
                                break;
                            }
                        }
                        if (!$hasTargetProduct) {
                            return false;
                        }
                    }
                    break;
                
                case 'category':
                    // This would need to be implemented based on your category logic
                    // For now, we'll assume it's valid
                    break;
            }
        }
        return true;
    }

    // Get customer's promotion usage history
    public function getCustomerPromotionHistory($customerID) {
        $query = "SELECT pu.*, p.PromotionCode, p.PromotionName, o.OrderDate 
                  FROM PromotionUsage pu 
                  JOIN Promotions p ON pu.PromotionID = p.PromotionID 
                  JOIN Orders o ON pu.OrderID = o.OrderID 
                  WHERE pu.CustomerID = ? 
                  ORDER BY pu.UsedAt DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $customerID);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Check if customer is eligible for new customer promotion
    public function isNewCustomer($customerID) {
        $query = "SELECT COUNT(*) as order_count FROM Orders WHERE CustomerID = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $customerID);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['order_count'] == 0;
    }

    // Check if customer is eligible for loyalty promotion
    public function isLoyalCustomer($customerID) {
        $query = "SELECT COUNT(*) as order_count FROM Orders WHERE CustomerID = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $customerID);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['order_count'] >= 3;
    }

    // Get all promotions for management
    public function getAllPromotions($search = '') {
        $query = "SELECT p.*, 
                         COALESCE(p.UsageLimit, '∞') as UsageLimitDisplay,
                         COALESCE(p.UsedCount, 0) as UsedCount
                  FROM Promotions p 
                  WHERE 1=1";
        
        if (!empty($search)) {
            $query .= " AND (p.PromotionCode LIKE ? OR p.PromotionName LIKE ? OR p.Description LIKE ?)";
            $searchTerm = "%$search%";
        }
        
        $query .= " ORDER BY p.CreatedAt DESC";
        
        if (!empty($search)) {
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
            $stmt->execute();
            return $stmt->get_result();
        } else {
            return $this->db->query($query);
        }
    }

    // Create new promotion
    public function createPromotion($promotionData) {
        $this->validatePromotionData($promotionData, false);
        
        $query = "INSERT INTO Promotions (
                    PromotionCode, PromotionName, Description, DiscountType, 
                    DiscountValue, MinimumOrderAmount, MaximumDiscount, 
                    StartDate, EndDate, IsActive, UsageLimit
                  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssssddddssi", 
            $promotionData['PromotionCode'],
            $promotionData['PromotionName'],
            $promotionData['Description'],
            $promotionData['DiscountType'],
            $promotionData['DiscountValue'],
            $promotionData['MinimumOrderAmount'],
            $promotionData['MaximumDiscount'],
            $promotionData['StartDate'],
            $promotionData['EndDate'],
            $promotionData['IsActive'],
            $promotionData['UsageLimit']
        );
        
        if (!$stmt->execute()) {
            throw new Exception("Lỗi khi tạo khuyến mãi: " . $stmt->error);
        }
        
        $promotionID = $stmt->insert_id;
        
        // Add promotion target if specified
        if (isset($promotionData['TargetType']) && $promotionData['TargetType'] !== 'all') {
            $this->addPromotionTarget($promotionID, $promotionData['TargetType'], null);
        }
        
        return $promotionID;
    }

    // Update existing promotion
    public function updatePromotion($promotionID, $promotionData) {
        error_log("Updating promotion ID: $promotionID with data: " . json_encode($promotionData));
        $this->validatePromotionData($promotionData, true, $promotionID);
        
        $query = "UPDATE Promotions SET 
                    PromotionCode = ?, PromotionName = ?, Description = ?, 
                    DiscountType = ?, DiscountValue = ?, MinimumOrderAmount = ?, 
                    MaximumDiscount = ?, StartDate = ?, EndDate = ?, 
                    IsActive = ?, UsageLimit = ?, UpdatedAt = CURRENT_TIMESTAMP
                  WHERE PromotionID = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssssddddssii", 
            $promotionData['PromotionCode'],
            $promotionData['PromotionName'],
            $promotionData['Description'],
            $promotionData['DiscountType'],
            $promotionData['DiscountValue'],
            $promotionData['MinimumOrderAmount'],
            $promotionData['MaximumDiscount'],
            $promotionData['StartDate'],
            $promotionData['EndDate'],
            $promotionData['IsActive'],
            $promotionData['UsageLimit'],
            $promotionID
        );
        
        if (!$stmt->execute()) {
            throw new Exception("Lỗi khi cập nhật khuyến mãi: " . $stmt->error);
        }
        
        // Update promotion targets
        if (isset($promotionData['TargetType'])) {
            $targetIDValue = isset($promotionData['TargetIDValue']) ? $promotionData['TargetIDValue'] : null;
            $this->updatePromotionTargets($promotionID, $promotionData['TargetType'], $targetIDValue);
        }
    }

    // Delete promotion
    public function deletePromotion($promotionID) {
        // Check if promotion is being used in orders
        $usageQuery = "SELECT COUNT(*) as usage_count FROM PromotionUsage WHERE PromotionID = ?";
        $stmt = $this->db->prepare($usageQuery);
        $stmt->bind_param("i", $promotionID);
        $stmt->execute();
        $usage = $stmt->get_result()->fetch_assoc();
        
        if ($usage['usage_count'] > 0) {
            throw new Exception("Không thể xóa khuyến mãi đã được sử dụng trong đơn hàng");
        }
        
        // Delete promotion targets first
        $deleteTargetsQuery = "DELETE FROM PromotionTargets WHERE PromotionID = ?";
        $stmt = $this->db->prepare($deleteTargetsQuery);
        $stmt->bind_param("i", $promotionID);
        $stmt->execute();
        
        // Delete promotion
        $deleteQuery = "DELETE FROM Promotions WHERE PromotionID = ?";
        $stmt = $this->db->prepare($deleteQuery);
        $stmt->bind_param("i", $promotionID);
        
        if (!$stmt->execute()) {
            throw new Exception("Lỗi khi xóa khuyến mãi: " . $stmt->error);
        }
    }

    // Validate promotion data
    private function validatePromotionData($data, $isUpdate = false, $promotionID = null) {
        error_log("Validating promotion data: " . json_encode($data));
        
        if (empty($data['PromotionCode'])) {
            throw new Exception("Mã khuyến mãi không được để trống");
        }
        
        if (empty($data['PromotionName'])) {
            throw new Exception("Tên khuyến mãi không được để trống");
        }
        
        if (empty($data['DiscountType']) || !in_array($data['DiscountType'], ['percentage', 'fixed_amount'])) {
            throw new Exception("Loại giảm giá không hợp lệ");
        }
        
        if (empty($data['DiscountValue']) || $data['DiscountValue'] <= 0) {
            throw new Exception("Giá trị giảm giá phải lớn hơn 0");
        }
        
        if ($data['DiscountType'] === 'percentage' && $data['DiscountValue'] > 100) {
            throw new Exception("Giảm giá phần trăm không được vượt quá 100%");
        }
        
        if (empty($data['StartDate']) || empty($data['EndDate'])) {
            throw new Exception("Ngày bắt đầu và kết thúc không được để trống");
        }
        
        // Validate date format (YYYY-MM-DD)
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['StartDate'])) {
            throw new Exception("Định dạng ngày bắt đầu không hợp lệ. Vui lòng sử dụng định dạng YYYY-MM-DD");
        }
        
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['EndDate'])) {
            throw new Exception("Định dạng ngày kết thúc không hợp lệ. Vui lòng sử dụng định dạng YYYY-MM-DD");
        }
        
        // Validate that dates are valid
        if (!strtotime($data['StartDate'])) {
            throw new Exception("Ngày bắt đầu không hợp lệ");
        }
        
        if (!strtotime($data['EndDate'])) {
            throw new Exception("Ngày kết thúc không hợp lệ");
        }
        
        if (strtotime($data['EndDate']) <= strtotime($data['StartDate'])) {
            throw new Exception("Ngày kết thúc phải sau ngày bắt đầu");
        }
        
        // Check if promotion code already exists (skip for update if same promotion)
        $existingQuery = "SELECT PromotionID FROM Promotions WHERE PromotionCode = ?";
        $stmt = $this->db->prepare($existingQuery);
        $stmt->bind_param("s", $data['PromotionCode']);
        $stmt->execute();
        $existing = $stmt->get_result()->fetch_assoc();
        
        if ($existing && (!$isUpdate || $existing['PromotionID'] != $promotionID)) {
            throw new Exception("Mã khuyến mãi đã tồn tại");
        }
    }

    // Add promotion target
    private function addPromotionTarget($promotionID, $targetType, $targetIDValue) {
        $query = "INSERT INTO PromotionTargets (PromotionID, TargetType, TargetID_Value) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("isi", $promotionID, $targetType, $targetIDValue);
        $stmt->execute();
    }

    // Update promotion targets
    private function updatePromotionTargets($promotionID, $targetType, $targetIDValue) {
        // Delete existing targets
        $deleteQuery = "DELETE FROM PromotionTargets WHERE PromotionID = ?";
        $stmt = $this->db->prepare($deleteQuery);
        $stmt->bind_param("i", $promotionID);
        $stmt->execute();
        
        // Add new target
        if ($targetType !== 'all') {
            $this->addPromotionTarget($promotionID, $targetType, $targetIDValue);
        }
    }
}
?>
