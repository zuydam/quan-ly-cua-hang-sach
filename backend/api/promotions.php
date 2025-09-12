<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once '../services/PromotionService.php';

$promotionService = new PromotionService();

try {
    $method = $_SERVER['REQUEST_METHOD'];
    
    switch ($method) {
        case 'GET':
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'active':
                        $promotions = $promotionService->getActivePromotions();
                        $result = [];
                        while ($row = $promotions->fetch_assoc()) {
                            $result[] = $row;
                        }
                        echo json_encode(['status' => 'success', 'promotions' => $result]);
                        break;
                        
                    case 'validate':
                        if (!isset($_GET['code']) || !isset($_GET['customerId']) || !isset($_GET['amount'])) {
                            throw new Exception('Thiếu thông tin cần thiết');
                        }
                        
                        $orderItems = isset($_GET['items']) ? json_decode($_GET['items'], true) : [];
                        $validation = $promotionService->validatePromotion(
                            $_GET['code'],
                            $_GET['customerId'],
                            $_GET['amount'],
                            $orderItems
                        );
                        
                        echo json_encode($validation);
                        break;
                        
                    case 'history':
                        if (!isset($_GET['customerId'])) {
                            throw new Exception('Thiếu ID khách hàng');
                        }
                        
                        $history = $promotionService->getCustomerPromotionHistory($_GET['customerId']);
                        echo json_encode(['status' => 'success', 'data' => $history]);
                        break;
                        
                    default:
                        throw new Exception('Hành động không hợp lệ');
                }
            } else {
                // Get all promotions (for management)
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $promotions = $promotionService->getAllPromotions($search);
                $result = [];
                while ($row = $promotions->fetch_assoc()) {
                    $result[] = $row;
                }
                echo json_encode(['status' => 'success', 'promotions' => $result]);
            }
            break;
            
        case 'POST':
            $input = json_decode(file_get_contents('php://input'), true);
            
            // Create new promotion
            $result = $promotionService->createPromotion($input);
            echo json_encode(['status' => 'success', 'message' => 'Tạo khuyến mãi thành công', 'promotionId' => $result]);
            break;
            
        case 'PUT':
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($input['PromotionID'])) {
                throw new Exception('Thiếu ID khuyến mãi');
            }
            
            // Log input data for debugging
            error_log("Update promotion input: " . json_encode($input));
            
            // Update existing promotion
            $promotionService->updatePromotion($input['PromotionID'], $input);
            echo json_encode(['status' => 'success', 'message' => 'Cập nhật khuyến mãi thành công']);
            break;
            
        case 'DELETE':
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($input['PromotionID'])) {
                throw new Exception('Thiếu ID khuyến mãi');
            }
            
            // Delete promotion
            $promotionService->deletePromotion($input['PromotionID']);
            echo json_encode(['status' => 'success', 'message' => 'Xóa khuyến mãi thành công']);
            break;
            
        default:
            throw new Exception('Phương thức không được hỗ trợ');
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
