<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

require_once '../services/DashboardService.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

try {
    $dashboardService = new DashboardService();
    
    switch ($method) {
        case 'GET':
            if (isset($_GET['type'])) {
                switch ($_GET['type']) {
                    case 'overview':
                        $data = $dashboardService->getDashboardStatistics();
                        echo json_encode($data);
                        break;
                    case 'recent_orders':
                        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
                        $data = $dashboardService->getRecentOrders($limit);
                        echo json_encode($data);
                        break;
                    case 'sales_chart':
                        $period = isset($_GET['period']) ? $_GET['period'] : 'month';
                        $data = $dashboardService->getSalesChartData($period);
                        echo json_encode($data);
                        break;
                    default:
                        http_response_code(400);
                        echo json_encode(["error" => "Loại thống kê không hợp lệ"]);
                        break;
                }
            } else {
                // Trả về tất cả thống kê dashboard
                $data = $dashboardService->getDashboardStatistics();
                echo json_encode($data);
            }
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



