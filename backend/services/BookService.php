<?php
require_once '../config/database.php';

class BookService {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllBooks() {
        try {
            $sql = "SELECT b.BookID, b.Title, b.Author, b.Genre, b.Price, b.Stock, b.InputQuantity, b.OutputQuantity, b.SupplierID, s.Name as SupplierName
                    FROM Books b
                    LEFT JOIN Suppliers s ON b.SupplierID = s.SupplierID
                    ORDER BY b.BookID DESC";
            $result = $this->db->query($sql);
            
            $books = [];
            while ($row = $result->fetch_assoc()) {
                $books[] = $row;
            }
            return $books;
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy danh sách sách: " . $e->getMessage());
        }
    }

    public function getBookById($bookId) {
        try {
            $stmt = $this->db->prepare("SELECT b.*, s.Name as SupplierName 
                                       FROM Books b 
                                       LEFT JOIN Suppliers s ON b.SupplierID = s.SupplierID 
                                       WHERE b.BookID = ?");
            $stmt->bind_param("i", $bookId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy thông tin sách: " . $e->getMessage());
        }
    }

    public function searchBooks($query) {
        try {
            $searchTerm = "%$query%";
            $stmt = $this->db->prepare("SELECT b.BookID, b.Title, b.Author, b.Genre, b.Price, b.Stock, b.InputQuantity, b.OutputQuantity, b.SupplierID, s.Name as SupplierName
                                       FROM Books b
                                       LEFT JOIN Suppliers s ON b.SupplierID = s.SupplierID
                                       WHERE b.Title LIKE ? OR b.Author LIKE ? OR b.Genre LIKE ?
                                       ORDER BY b.BookID DESC");
            $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $books = [];
            while ($row = $result->fetch_assoc()) {
                $books[] = $row;
            }
            return $books;
        } catch (Exception $e) {
            throw new Exception("Lỗi khi tìm kiếm sách: " . $e->getMessage());
        }
    }

    public function createBook($bookData) {
        try {
            $this->validateBookData($bookData);
            
            // Calculate stock from input and output quantities
            $inputQuantity = isset($bookData->InputQuantity) ? $bookData->InputQuantity : $bookData->Stock;
            $outputQuantity = isset($bookData->OutputQuantity) ? $bookData->OutputQuantity : 0;
            $calculatedStock = $inputQuantity - $outputQuantity;
            
            $stmt = $this->db->prepare("INSERT INTO Books (Title, Author, Genre, Price, Stock, InputQuantity, OutputQuantity, SupplierID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssdiiii", 
                $bookData->Title, 
                $bookData->Author, 
                $bookData->Genre, 
                $bookData->Price, 
                $calculatedStock, 
                $inputQuantity, 
                $outputQuantity, 
                $bookData->SupplierID
            );
            
            if (!$stmt->execute()) {
                throw new Exception("Lỗi khi thêm sách: " . $stmt->error);
            }
            
            return ["status" => "success", "message" => "Thêm sách thành công", "id" => $stmt->insert_id];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateBook($bookData) {
        try {
            $this->validateBookData($bookData);
            
            if (!isset($bookData->BookID)) {
                throw new Exception("Thiếu ID sách để cập nhật");
            }
            
            // Calculate stock from input and output quantities
            $inputQuantity = isset($bookData->InputQuantity) ? $bookData->InputQuantity : $bookData->Stock;
            $outputQuantity = isset($bookData->OutputQuantity) ? $bookData->OutputQuantity : 0;
            $calculatedStock = $inputQuantity - $outputQuantity;
            
            $stmt = $this->db->prepare("UPDATE Books SET Title=?, Author=?, Genre=?, Price=?, Stock=?, InputQuantity=?, OutputQuantity=?, SupplierID=? WHERE BookID=?");
            $stmt->bind_param("sssdiiiii", 
                $bookData->Title, 
                $bookData->Author, 
                $bookData->Genre, 
                $bookData->Price, 
                $calculatedStock, 
                $inputQuantity, 
                $outputQuantity, 
                $bookData->SupplierID, 
                $bookData->BookID
            );
            
            if (!$stmt->execute()) {
                throw new Exception("Lỗi khi cập nhật sách: " . $stmt->error);
            }
            
            return ["status" => "success", "message" => "Cập nhật sách thành công"];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function deleteBook($bookId) {
        try {
            // Kiểm tra xem sách có trong đơn hàng nào không
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM OrderDetails WHERE BookID = ?");
            $stmt->bind_param("i", $bookId);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            if ($row['count'] > 0) {
                throw new Exception("Không thể xóa sách vì đã có trong đơn hàng");
            }
            
            $stmt = $this->db->prepare("DELETE FROM Books WHERE BookID = ?");
            $stmt->bind_param("i", $bookId);
            
            if (!$stmt->execute()) {
                throw new Exception("Lỗi khi xóa sách: " . $stmt->error);
            }
            
            if ($stmt->affected_rows === 0) {
                throw new Exception("Không tìm thấy sách để xóa");
            }
            
            return ["status" => "success", "message" => "Xóa sách thành công"];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateStock($bookId, $quantity) {
        try {
            $stmt = $this->db->prepare("UPDATE Books SET Stock = Stock + ? WHERE BookID = ?");
            $stmt->bind_param("ii", $quantity, $bookId);
            
            if (!$stmt->execute()) {
                throw new Exception("Lỗi khi cập nhật tồn kho: " . $stmt->error);
            }
            
            return ["status" => "success", "message" => "Cập nhật tồn kho thành công"];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getLowStockBooks($threshold = 5) {
        try {
            $stmt = $this->db->prepare("SELECT b.BookID, b.Title, b.Author, b.Genre, b.Price, b.Stock, b.InputQuantity, b.OutputQuantity, b.SupplierID, s.Name as SupplierName 
                                       FROM Books b 
                                       LEFT JOIN Suppliers s ON b.SupplierID = s.SupplierID 
                                       WHERE b.Stock <= ? 
                                       ORDER BY b.Stock ASC");
            $stmt->bind_param("i", $threshold);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $books = [];
            while ($row = $result->fetch_assoc()) {
                $books[] = $row;
            }
            return $books;
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy sách tồn kho thấp: " . $e->getMessage());
        }
    }

    private function validateBookData($bookData) {
        if (empty($bookData->Title)) {
            throw new Exception("Tên sách không được để trống");
        }
        if (empty($bookData->Author)) {
            throw new Exception("Tác giả không được để trống");
        }
        if (empty($bookData->Genre)) {
            throw new Exception("Thể loại không được để trống");
        }
        if (!is_numeric($bookData->Price) || $bookData->Price <= 0) {
            throw new Exception("Giá sách phải là số dương");
        }
        
        // Validate stock-related fields
        if (isset($bookData->InputQuantity) && (!is_numeric($bookData->InputQuantity) || $bookData->InputQuantity < 0)) {
            throw new Exception("Số lượng nhập vào phải là số không âm");
        }
        if (isset($bookData->OutputQuantity) && (!is_numeric($bookData->OutputQuantity) || $bookData->OutputQuantity < 0)) {
            throw new Exception("Số lượng xuất ra phải là số không âm");
        }
        
        // If using legacy Stock field, validate it
        if (isset($bookData->Stock) && (!is_numeric($bookData->Stock) || $bookData->Stock < 0)) {
            throw new Exception("Số lượng tồn kho phải là số không âm");
        }
        
        if (empty($bookData->SupplierID)) {
            throw new Exception("Vui lòng chọn nhà cung cấp");
        }
    }

    public function __destruct() {
        $this->db->closeConnection();
    }
}
?>

