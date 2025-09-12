<?php
require_once '../config/database.php';

class SupplierService {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllSuppliers() {
        try {
            $sql = "SELECT s.*, 
                           COUNT(b.BookID) as TotalBooks,
                           COALESCE(SUM(b.Stock), 0) as TotalStock
                    FROM Suppliers s
                    LEFT JOIN Books b ON s.SupplierID = b.SupplierID
                    GROUP BY s.SupplierID
                    ORDER BY s.SupplierID DESC";
            $result = $this->db->query($sql);
            
            $suppliers = [];
            while ($row = $result->fetch_assoc()) {
                $suppliers[] = $row;
            }
            return $suppliers;
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy danh sách nhà cung cấp: " . $e->getMessage());
        }
    }

    public function getSupplierById($supplierId) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM Suppliers WHERE SupplierID = ?");
            $stmt->bind_param("i", $supplierId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy thông tin nhà cung cấp: " . $e->getMessage());
        }
    }

    public function searchSuppliers($query) {
        try {
            $searchTerm = "%$query%";
            $stmt = $this->db->prepare("SELECT s.*, 
                                              COUNT(b.BookID) as TotalBooks,
                                              COALESCE(SUM(b.Stock), 0) as TotalStock
                                       FROM Suppliers s
                                       LEFT JOIN Books b ON s.SupplierID = b.SupplierID
                                       WHERE s.Name LIKE ? OR s.Address LIKE ? OR s.Phone LIKE ?
                                       GROUP BY s.SupplierID
                                       ORDER BY s.SupplierID DESC");
            $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $suppliers = [];
            while ($row = $result->fetch_assoc()) {
                $suppliers[] = $row;
            }
            return $suppliers;
        } catch (Exception $e) {
            throw new Exception("Lỗi khi tìm kiếm nhà cung cấp: " . $e->getMessage());
        }
    }

    public function createSupplier($supplierData) {
        try {
            $this->validateSupplierData($supplierData);
            
            // Kiểm tra số điện thoại đã tồn tại chưa
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM Suppliers WHERE Phone = ?");
            $stmt->bind_param("s", $supplierData->Phone);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            if ($row['count'] > 0) {
                throw new Exception("Số điện thoại đã tồn tại trong hệ thống");
            }
            
            $stmt = $this->db->prepare("INSERT INTO Suppliers (Name, Address, Phone) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", 
                $supplierData->Name, 
                $supplierData->Address, 
                $supplierData->Phone
            );
            
            if (!$stmt->execute()) {
                throw new Exception("Lỗi khi thêm nhà cung cấp: " . $stmt->error);
            }
            
            return ["status" => "success", "message" => "Thêm nhà cung cấp thành công", "id" => $stmt->insert_id];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateSupplier($supplierData) {
        try {
            $this->validateSupplierData($supplierData);
            
            if (!isset($supplierData->SupplierID)) {
                throw new Exception("Thiếu ID nhà cung cấp để cập nhật");
            }
            
            // Kiểm tra số điện thoại đã tồn tại chưa (trừ nhà cung cấp hiện tại)
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM Suppliers WHERE Phone = ? AND SupplierID != ?");
            $stmt->bind_param("si", $supplierData->Phone, $supplierData->SupplierID);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            if ($row['count'] > 0) {
                throw new Exception("Số điện thoại đã tồn tại trong hệ thống");
            }
            
            $stmt = $this->db->prepare("UPDATE Suppliers SET Name=?, Address=?, Phone=? WHERE SupplierID=?");
            $stmt->bind_param("sssi", 
                $supplierData->Name, 
                $supplierData->Address, 
                $supplierData->Phone, 
                $supplierData->SupplierID
            );
            
            if (!$stmt->execute()) {
                throw new Exception("Lỗi khi cập nhật nhà cung cấp: " . $stmt->error);
            }
            
            return ["status" => "success", "message" => "Cập nhật nhà cung cấp thành công"];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function deleteSupplier($supplierId) {
        try {
            // Kiểm tra xem nhà cung cấp có sách nào không
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM Books WHERE SupplierID = ?");
            $stmt->bind_param("i", $supplierId);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            if ($row['count'] > 0) {
                throw new Exception("Không thể xóa nhà cung cấp vì đã có sách liên quan");
            }
            
            $stmt = $this->db->prepare("DELETE FROM Suppliers WHERE SupplierID = ?");
            $stmt->bind_param("i", $supplierId);
            
            if (!$stmt->execute()) {
                throw new Exception("Lỗi khi xóa nhà cung cấp: " . $stmt->error);
            }
            
            if ($stmt->affected_rows === 0) {
                throw new Exception("Không tìm thấy nhà cung cấp để xóa");
            }
            
            return ["status" => "success", "message" => "Xóa nhà cung cấp thành công"];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getSupplierBooks($supplierId) {
        try {
            $stmt = $this->db->prepare("SELECT b.*, s.Name as SupplierName
                                       FROM Books b
                                       LEFT JOIN Suppliers s ON b.SupplierID = s.SupplierID
                                       WHERE b.SupplierID = ?
                                       ORDER BY b.BookID DESC");
            $stmt->bind_param("i", $supplierId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $books = [];
            while ($row = $result->fetch_assoc()) {
                $books[] = $row;
            }
            return $books;
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy sách của nhà cung cấp: " . $e->getMessage());
        }
    }

    public function getTopSuppliers($limit = 5) {
        try {
            $stmt = $this->db->prepare("SELECT s.*, 
                                              COUNT(b.BookID) as TotalBooks,
                                              COALESCE(SUM(b.Stock), 0) as TotalStock
                                       FROM Suppliers s
                                       LEFT JOIN Books b ON s.SupplierID = b.SupplierID
                                       GROUP BY s.SupplierID
                                       ORDER BY TotalBooks DESC, TotalStock DESC
                                       LIMIT ?");
            $stmt->bind_param("i", $limit);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $suppliers = [];
            while ($row = $result->fetch_assoc()) {
                $suppliers[] = $row;
            }
            return $suppliers;
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy top nhà cung cấp: " . $e->getMessage());
        }
    }

    public function getSupplierStatistics() {
        try {
            $sql = "SELECT 
                        COUNT(*) as TotalSuppliers,
                        COUNT(CASE WHEN b.BookID IS NOT NULL THEN 1 END) as ActiveSuppliers,
                        COALESCE(SUM(b.Stock), 0) as TotalStock
                    FROM Suppliers s
                    LEFT JOIN Books b ON s.SupplierID = b.SupplierID";
            $result = $this->db->query($sql);
            return $result->fetch_assoc();
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy thống kê nhà cung cấp: " . $e->getMessage());
        }
    }

    private function validateSupplierData($supplierData) {
        if (empty($supplierData->Name)) {
            throw new Exception("Tên nhà cung cấp không được để trống");
        }
        if (empty($supplierData->Address)) {
            throw new Exception("Địa chỉ không được để trống");
        }
        if (empty($supplierData->Phone)) {
            throw new Exception("Số điện thoại không được để trống");
        }
        if (!preg_match("/^[0-9]{10,11}$/", $supplierData->Phone)) {
            throw new Exception("Số điện thoại không hợp lệ");
        }
    }

    public function __destruct() {
        $this->db->closeConnection();
    }
}
?>
