<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

require_once '../services/SupplierService.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

try {
    $supplierService = new SupplierService();
    
    switch ($method) {
        case 'GET':
            if (isset($_GET['search'])) {
                $suppliers = $supplierService->searchSuppliers($_GET['search']);
            } elseif (isset($_GET['id'])) {
                $suppliers = $supplierService->getSupplierById($_GET['id']);
            } elseif (isset($_GET['books'])) {
                $supplierId = $_GET['books'];
                $suppliers = $supplierService->getSupplierBooks($supplierId);
            } elseif (isset($_GET['top'])) {
                $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
                $suppliers = $supplierService->getTopSuppliers($limit);
            } elseif (isset($_GET['statistics'])) {
                $suppliers = $supplierService->getSupplierStatistics();
            } else {
                $suppliers = $supplierService->getAllSuppliers();
            }
            echo json_encode($suppliers);
            break;
            
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            if (!$data) {
                throw new Exception("Dữ liệu không hợp lệ");
            }
            
            $result = $supplierService->createSupplier($data);
            echo json_encode($result);
            break;
            
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            if (!$data || !isset($data->SupplierID)) {
                throw new Exception("Thiếu ID nhà cung cấp để cập nhật");
            }
            $result = $supplierService->updateSupplier($data);
            echo json_encode($result);
            break;
            
        case 'DELETE':
            $data = json_decode(file_get_contents("php://input"));
            if (!$data || !isset($data->SupplierID)) {
                throw new Exception("Thiếu ID nhà cung cấp để xóa");
            }
            $result = $supplierService->deleteSupplier($data->SupplierID);
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
