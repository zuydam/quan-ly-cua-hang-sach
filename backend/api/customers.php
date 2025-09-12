<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

require_once '../services/CustomerService.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

try {
    $customerService = new CustomerService();
    
    switch ($method) {
        case 'GET':
            if (isset($_GET['search'])) {
                $customers = $customerService->searchCustomers($_GET['search']);
            } elseif (isset($_GET['id'])) {
                $customers = $customerService->getCustomerById($_GET['id']);
            } elseif (isset($_GET['top'])) {
                $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
                $customers = $customerService->getTopCustomers($limit);
            } elseif (isset($_GET['orders'])) {
                $customerId = $_GET['orders'];
                $customers = $customerService->getCustomerOrders($customerId);
            } else {
                $customers = $customerService->getAllCustomers();
            }
            echo json_encode($customers);
            break;
            
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            if (!$data) {
                throw new Exception("Dữ liệu không hợp lệ");
            }
            
            $result = $customerService->createCustomer($data);
            echo json_encode($result);
            break;
            
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            if (!$data || !isset($data->CustomerID)) {
                throw new Exception("Thiếu ID khách hàng để cập nhật");
            }
            
            $result = $customerService->updateCustomer($data);
            echo json_encode($result);
            break;
            
        case 'DELETE':
            $data = json_decode(file_get_contents("php://input"));
            if (!$data || !isset($data->CustomerID)) {
                throw new Exception("Thiếu ID khách hàng để xóa");
            }
            $result = $customerService->deleteCustomer($data->CustomerID);
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
