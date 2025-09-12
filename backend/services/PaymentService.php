<?php
require_once __DIR__ . '/../config/database.php';

class PaymentService {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Get all active payment methods
    public function getActivePaymentMethods() {
        $query = "SELECT * FROM PaymentMethods WHERE IsActive = 1 ORDER BY PaymentMethodID";
        return $this->db->query($query);
    }

    // Get payment method by ID
    public function getPaymentMethodById($paymentMethodID) {
        $query = "SELECT * FROM PaymentMethods WHERE PaymentMethodID = ? AND IsActive = 1";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $paymentMethodID);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Process payment
    public function processPayment($orderID, $paymentMethodID, $amount, $transactionID = null) {
        try {
            $this->db->beginTransaction();

            // Update order payment status
            $updateQuery = "UPDATE Orders SET 
                           PaymentMethodID = ?, 
                           PaymentStatus = 'paid', 
                           PaymentDate = NOW(),
                           TransactionID = ?
                           WHERE OrderID = ?";
            
            $stmt = $this->db->prepare($updateQuery);
            $stmt->bind_param("isi", $paymentMethodID, $transactionID, $orderID);
            $stmt->execute();

            // Log payment transaction (you might want to create a separate table for this)
            $this->logPaymentTransaction($orderID, $paymentMethodID, $amount, $transactionID);

            $this->db->commit();
            return ['success' => true, 'message' => 'Thanh toán thành công'];
        } catch (Exception $e) {
            $this->db->rollback();
            return ['success' => false, 'message' => 'Lỗi thanh toán: ' . $e->getMessage()];
        }
    }

    // Log payment transaction
    private function logPaymentTransaction($orderID, $paymentMethodID, $amount, $transactionID) {
        // This is a placeholder for payment transaction logging
        // You might want to create a separate PaymentTransactions table
        error_log("Payment processed: OrderID=$orderID, MethodID=$paymentMethodID, Amount=$amount, TransactionID=$transactionID");
    }

    // Update payment status
    public function updatePaymentStatus($orderID, $status, $transactionID = null) {
        $query = "UPDATE Orders SET 
                  PaymentStatus = ?, 
                  PaymentDate = CASE WHEN ? = 'paid' THEN NOW() ELSE PaymentDate END,
                  TransactionID = ?
                  WHERE OrderID = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sssi", $status, $status, $transactionID, $orderID);
        return $stmt->execute();
    }

    // Get payment statistics
    public function getPaymentStatistics($startDate = null, $endDate = null) {
        $whereClause = "";
        $params = [];
        $types = "";

        if ($startDate && $endDate) {
            $whereClause = "WHERE o.OrderDate BETWEEN ? AND ?";
            $params = [$startDate, $endDate];
            $types = "ss";
        }

        $query = "SELECT 
                    pm.MethodName,
                    COUNT(o.OrderID) as order_count,
                    SUM(o.TotalAmount) as total_amount,
                    AVG(o.TotalAmount) as avg_amount
                  FROM Orders o
                  JOIN PaymentMethods pm ON o.PaymentMethodID = pm.PaymentMethodID
                  $whereClause
                  GROUP BY pm.PaymentMethodID, pm.MethodName
                  ORDER BY total_amount DESC";

        if (!empty($params)) {
            $stmt = $this->db->prepare($query);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } else {
            return $this->db->query($query);
        }
    }

    // Get orders by payment status
    public function getOrdersByPaymentStatus($status) {
        $query = "SELECT o.*, c.Name as CustomerName, pm.MethodName 
                  FROM Orders o
                  JOIN Customers c ON o.CustomerID = c.CustomerID
                  LEFT JOIN PaymentMethods pm ON o.PaymentMethodID = pm.PaymentMethodID
                  WHERE o.PaymentStatus = ?
                  ORDER BY o.OrderDate DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $status);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Validate payment method
    public function validatePaymentMethod($paymentMethodID) {
        $paymentMethod = $this->getPaymentMethodById($paymentMethodID);
        return $paymentMethod !== null;
    }

    // Generate transaction ID for online payments
    public function generateTransactionID($orderID) {
        $timestamp = time();
        $random = rand(1000, 9999);
        return "TXN_{$orderID}_{$timestamp}_{$random}";
    }

    // Get payment method usage statistics
    public function getPaymentMethodUsage() {
        $query = "SELECT 
                    pm.MethodName,
                    COUNT(o.OrderID) as usage_count,
                    SUM(o.TotalAmount) as total_revenue
                  FROM PaymentMethods pm
                  LEFT JOIN Orders o ON pm.PaymentMethodID = o.PaymentMethodID 
                    AND o.PaymentStatus = 'paid'
                  WHERE pm.IsActive = 1
                  GROUP BY pm.PaymentMethodID, pm.MethodName
                  ORDER BY usage_count DESC";
        
        return $this->db->query($query);
    }
}
?>


