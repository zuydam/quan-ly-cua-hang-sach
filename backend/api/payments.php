<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once '../services/PaymentService.php';

$paymentService = new PaymentService();

try {
    $method = $_SERVER['REQUEST_METHOD'];
    
    switch ($method) {
        case 'GET':
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'methods':
                        $methods = $paymentService->getActivePaymentMethods();
                        $result = [];
                        while ($row = $methods->fetch_assoc()) {
                            $result[] = $row;
                        }
                        echo json_encode(['status' => 'success', 'data' => $result]);
                        break;
                        
                    case 'statistics':
                        $startDate = isset($_GET['startDate']) ? $_GET['startDate'] : null;
                        $endDate = isset($_GET['endDate']) ? $_GET['endDate'] : null;
                        $statistics = $paymentService->getPaymentStatistics($startDate, $endDate);
                        echo json_encode(['status' => 'success', 'data' => $statistics]);
                        break;
                        
                    case 'usage':
                        $usage = $paymentService->getPaymentMethodUsage();
                        echo json_encode(['status' => 'success', 'data' => $usage]);
                        break;
                        
                    case 'orders':
                        if (!isset($_GET['status'])) {
                            throw new Exception('Thiếu trạng thái thanh toán');
                        }
                        $orders = $paymentService->getOrdersByPaymentStatus($_GET['status']);
                        echo json_encode(['status' => 'success', 'data' => $orders]);
                        break;
                        
                    default:
                        throw new Exception('Hành động không hợp lệ');
                }
            } else {
                // Get all active payment methods
                $methods = $paymentService->getActivePaymentMethods();
                $result = [];
                while ($row = $methods->fetch_assoc()) {
                    $result[] = $row;
                }
                echo json_encode(['status' => 'success', 'data' => $result]);
            }
            break;
            
        case 'POST':
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($input['action'])) {
                throw new Exception('Thiếu hành động');
            }
            
            switch ($input['action']) {
                case 'process':
                    if (!isset($input['orderId']) || !isset($input['paymentMethodId']) || !isset($input['amount'])) {
                        throw new Exception('Thiếu thông tin cần thiết');
                    }
                    
                    $transactionID = isset($input['transactionId']) ? $input['transactionId'] : null;
                    $result = $paymentService->processPayment(
                        $input['orderId'],
                        $input['paymentMethodId'],
                        $input['amount'],
                        $transactionID
                    );
                    
                    echo json_encode($result);
                    break;
                    
                case 'update_status':
                    if (!isset($input['orderId']) || !isset($input['status'])) {
                        throw new Exception('Thiếu thông tin cần thiết');
                    }
                    
                    $transactionID = isset($input['transactionId']) ? $input['transactionId'] : null;
                    $success = $paymentService->updatePaymentStatus($input['orderId'], $input['status'], $transactionID);
                    
                    if ($success) {
                        echo json_encode(['status' => 'success', 'message' => 'Cập nhật trạng thái thanh toán thành công']);
                    } else {
                        throw new Exception('Lỗi khi cập nhật trạng thái thanh toán');
                    }
                    break;
                    
                default:
                    throw new Exception('Hành động không hợp lệ');
            }
            break;
            
        default:
            throw new Exception('Phương thức không được hỗ trợ');
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>


