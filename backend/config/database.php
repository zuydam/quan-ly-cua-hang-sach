<?php
class Database {
    private $host = "localhost:3307";
    private $username = "root";
    private $password = "14092004";
    private $database = "QLS";
    private $connection;

    public function __construct() {
        try {
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
            $this->connection->set_charset("utf8mb4");
            
            if ($this->connection->connect_error) {
                throw new Exception("Kết nối thất bại: " . $this->connection->connect_error);
            }
        } catch (Exception $e) {
            die(json_encode(["error" => $e->getMessage()]));
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function closeConnection() {
        if ($this->connection) {
            $this->connection->close();
        }
    }

    public function query($sql) {
        $result = $this->connection->query($sql);
        if (!$result) {
            throw new Exception("Lỗi truy vấn: " . $this->connection->error);
        }
        return $result;
    }

    public function prepare($sql) {
        $stmt = $this->connection->prepare($sql);
        if (!$stmt) {
            throw new Exception("Lỗi chuẩn bị truy vấn: " . $this->connection->error);
        }
        return $stmt;
    }
}
?>






