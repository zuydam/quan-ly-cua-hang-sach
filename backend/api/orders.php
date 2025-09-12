<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

require_once '../services/OrderService.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

try {
    $orderService = new OrderService();
    
    switch ($method) {
        case 'GET':
            if (isset($_GET['id'])) {
                $orders = $orderService->getOrderById($_GET['id']);
            } elseif (isset($_GET['details'])) {
                $orderId = $_GET['details'];
                $orders = $orderService->getOrderDetails($orderId);
            } elseif (isset($_GET['date_range'])) {
                $startDate = $_GET['start_date'];
                $endDate = $_GET['end_date'];
                $orders = $orderService->getOrdersByDateRange($startDate, $endDate);
            } elseif (isset($_GET['statistics'])) {
                $orders = $orderService->getOrderStatistics();
            } else {
                $orders = $orderService->getAllOrders();
            }
            echo json_encode($orders);
            break;
            
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            if (!$data) {
                throw new Exception("Dữ liệu không hợp lệ");
            }
            
            if (isset($data->OrderID)) {
                $result = $orderService->updateOrder($data);
            } else {
                $result = $orderService->createOrder($data);
            }
            echo json_encode($result);
            break;
            
        case 'DELETE':
            $data = json_decode(file_get_contents("php://input"));
            if (!$data || !isset($data->OrderID)) {
                throw new Exception("Thiếu ID đơn hàng để xóa");
            }
            $result = $orderService->deleteOrder($data->OrderID);
            echo json_encode($result);
            break;
            
        default:
            http_response_code(405);
            echo json_encode(["error" => "Phương thức không được hỗ trợ"]);
            break;
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "error" => $e->getMessage(),
        "status" => "error"
    ]);
}
?>






