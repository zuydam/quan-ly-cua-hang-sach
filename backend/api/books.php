<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

require_once '../services/BookService.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

try {
    $bookService = new BookService();
    
    switch ($method) {
        case 'GET':
            if (isset($_GET['search'])) {
                $books = $bookService->searchBooks($_GET['search']);
            } elseif (isset($_GET['id'])) {
                $books = $bookService->getBookById($_GET['id']);
            } elseif (isset($_GET['low_stock'])) {
                $threshold = isset($_GET['threshold']) ? (int)$_GET['threshold'] : 5;
                $books = $bookService->getLowStockBooks($threshold);
            } else {
                $books = $bookService->getAllBooks();
            }
            echo json_encode($books);
            break;
            
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            if (!$data) {
                throw new Exception("Dữ liệu không hợp lệ");
            }
            
            $result = $bookService->createBook($data);
            echo json_encode($result);
            break;
            
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            if (!$data || !isset($data->BookID)) {
                throw new Exception("Thiếu ID sách để cập nhật");
            }
            
            $result = $bookService->updateBook($data);
            echo json_encode($result);
            break;
            
        case 'DELETE':
            $data = json_decode(file_get_contents("php://input"));
            if (!$data || !isset($data->BookID)) {
                throw new Exception("Thiếu ID sách để xóa");
            }
            $result = $bookService->deleteBook($data->BookID);
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
