<?php
require_once '../config/database.php';

class DashboardService {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getDashboardStatistics() {
        try {
            // Thống kê tổng quan
            $overview = $this->getOverviewStatistics();
            
            // Thống kê theo tháng
            $monthlyStats = $this->getMonthlyStatistics();
            
            // Top sách bán chạy
            $topBooks = $this->getTopSellingBooks();
            
            // Top khách hàng
            $topCustomers = $this->getTopCustomers();
            
            // Sách tồn kho thấp
            $lowStockBooks = $this->getLowStockBooks();
            
            // Thống kê theo thể loại
            $genreStats = $this->getGenreStatistics();
            
            // Thống kê nhà cung cấp
            $supplierStats = $this->getSupplierStatistics();
            
            // Giá trị tồn kho
            $inventoryStats = $this->getInventoryStatistics();
            
            // Thống kê tăng trưởng khách hàng
            $customerGrowth = $this->getCustomerGrowthStatistics();
            
            // Thống kê xu hướng bán hàng
            $salesTrends = $this->getSalesTrends();
            
            // Thống kê đơn hàng theo trạng thái
            $orderStatusStats = $this->getOrderStatusStatistics();
            
            // Thống kê sách mới
            $newBooksStats = $this->getNewBooksStatistics();
            
            // Thống kê doanh thu theo thời gian
            $revenueStats = $this->getRevenueStatistics();

            return [
                'overview' => $overview,
                'monthlyStats' => $monthlyStats,
                'topBooks' => $topBooks,
                'topCustomers' => $topCustomers,
                'lowStockBooks' => $lowStockBooks,
                'genreStats' => $genreStats,
                'supplierStats' => $supplierStats,
                'inventoryStats' => $inventoryStats,
                'customerGrowth' => $customerGrowth,
                'salesTrends' => $salesTrends,
                'orderStatusStats' => $orderStatusStats,
                'newBooksStats' => $newBooksStats,
                'revenueStats' => $revenueStats
            ];
        } catch (Exception $e) {
            // Trả về dữ liệu mặc định thay vì lỗi
            return $this->getDefaultDashboardData();
        }
    }

    private function getDefaultDashboardData() {
        return [
            'overview' => [
                'TotalBooks' => 0,
                'TotalCustomers' => 0,
                'TotalOrders' => 0,
                'TotalSuppliers' => 0,
                'TotalRevenue' => 0,
                'TotalStock' => 0,
                'LowStockBooks' => 0,
                'ActiveCustomers' => 0,
                'InventoryValue' => 0,
                'OrdersThisMonth' => 0,
                'RevenueThisMonth' => 0
            ],
            'monthlyStats' => [],
            'topBooks' => [],
            'topCustomers' => [],
            'lowStockBooks' => [],
            'genreStats' => [],
            'supplierStats' => [],
            'inventoryStats' => [
                'TotalBooks' => 0,
                'TotalStock' => 0,
                'TotalValue' => 0,
                'AveragePrice' => 0,
                'LowStockCount' => 0,
                'OutOfStockCount' => 0,
                'HighStockCount' => 0,
                'LowStockValue' => 0
            ],
            'customerGrowth' => [],
            'salesTrends' => [],
            'orderStatusStats' => [
                ['Status' => 'Tổng đơn hàng', 'Count' => 0, 'TotalValue' => 0],
                ['Status' => 'Đơn hàng tháng này', 'Count' => 0, 'TotalValue' => 0],
                ['Status' => 'Đơn hàng tuần này', 'Count' => 0, 'TotalValue' => 0],
                ['Status' => 'Đơn hàng hôm nay', 'Count' => 0, 'TotalValue' => 0]
            ],
            'newBooksStats' => [
                'TotalNewBooks' => 0,
                'TotalStock' => 0,
                'TotalValue' => 0,
                'AveragePrice' => 0,
                'AvailableBooks' => 0,
                'OutOfStockBooks' => 0
            ],
            'revenueStats' => [
                'weekly' => [],
                'monthly' => [],
                'yearly' => [],
                'summary' => [
                    'ThisWeekRevenue' => 0,
                    'ThisMonthRevenue' => 0,
                    'ThisYearRevenue' => 0,
                    'ThisWeekOrders' => 0,
                    'ThisMonthOrders' => 0,
                    'ThisYearOrders' => 0,
                    'AverageOrderValue' => 0,
                    'HighestOrderValue' => 0
                ]
            ]
        ];
    }

    private function getOverviewStatistics() {
        try {
            $sql = "SELECT 
                        (SELECT COUNT(*) FROM Books) as TotalBooks,
                        (SELECT COUNT(*) FROM Customers) as TotalCustomers,
                        (SELECT COUNT(*) FROM Orders) as TotalOrders,
                        (SELECT COUNT(*) FROM Suppliers) as TotalSuppliers,
                        (SELECT COALESCE(SUM(TotalAmount), 0) FROM Orders) as TotalRevenue,
                        (SELECT COALESCE(SUM(Stock), 0) FROM Books) as TotalStock,
                        (SELECT COUNT(*) FROM Books WHERE Stock <= 5) as LowStockBooks,
                        (SELECT COUNT(DISTINCT CustomerID) FROM Orders) as ActiveCustomers,
                        (SELECT COALESCE(SUM(Stock * Price), 0) FROM Books) as InventoryValue,
                        (SELECT COUNT(*) FROM Orders WHERE OrderDate >= DATE_SUB(NOW(), INTERVAL 30 DAY)) as OrdersThisMonth,
                        (SELECT COALESCE(SUM(TotalAmount), 0) FROM Orders WHERE OrderDate >= DATE_SUB(NOW(), INTERVAL 30 DAY)) as RevenueThisMonth";
            
            $result = $this->db->query($sql);
            return $result->fetch_assoc();
        } catch (Exception $e) {
            // Trả về dữ liệu mặc định
            return [
                'TotalBooks' => 0,
                'TotalCustomers' => 0,
                'TotalOrders' => 0,
                'TotalSuppliers' => 0,
                'TotalRevenue' => 0,
                'TotalStock' => 0,
                'LowStockBooks' => 0,
                'ActiveCustomers' => 0,
                'InventoryValue' => 0,
                'OrdersThisMonth' => 0,
                'RevenueThisMonth' => 0
            ];
        }
    }

    private function getMonthlyStatistics() {
        try {
            $sql = "SELECT 
                        DATE_FORMAT(OrderDate, '%Y-%m') as Month,
                        COUNT(*) as OrderCount,
                        COALESCE(SUM(TotalAmount), 0) as Revenue,
                        COUNT(DISTINCT CustomerID) as UniqueCustomers
                    FROM Orders 
                    WHERE OrderDate >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
                    GROUP BY DATE_FORMAT(OrderDate, '%Y-%m')
                    ORDER BY Month DESC
                    LIMIT 12";
            
            $result = $this->db->query($sql);
            $monthlyStats = [];
            while ($row = $result->fetch_assoc()) {
                $monthlyStats[] = $row;
            }
            return $monthlyStats;
        } catch (Exception $e) {
            return [];
        }
    }

    private function getTopSellingBooks() {
        try {
            $sql = "SELECT 
                        b.BookID,
                        b.Title,
                        b.Author,
                        b.Genre,
                        b.Price,
                        COALESCE(SUM(od.Quantity), 0) as TotalSold,
                        COALESCE(SUM(od.Quantity * od.Price), 0) as TotalRevenue
                    FROM Books b
                    LEFT JOIN OrderDetails od ON b.BookID = od.BookID
                    GROUP BY b.BookID
                    ORDER BY TotalSold DESC, TotalRevenue DESC
                    LIMIT 10";
            
            $result = $this->db->query($sql);
            $topBooks = [];
            while ($row = $result->fetch_assoc()) {
                $topBooks[] = $row;
            }
            return $topBooks;
        } catch (Exception $e) {
            return [];
        }
    }

    private function getTopCustomers() {
        try {
            $sql = "SELECT 
                        c.CustomerID,
                        c.Name,
                        c.Email,
                        COUNT(o.OrderID) as OrderCount,
                        COALESCE(SUM(o.TotalAmount), 0) as TotalSpent,
                        MAX(o.OrderDate) as LastOrderDate
                    FROM Customers c
                    LEFT JOIN Orders o ON c.CustomerID = o.CustomerID
                    GROUP BY c.CustomerID
                    ORDER BY TotalSpent DESC, OrderCount DESC
                    LIMIT 10";
            
            $result = $this->db->query($sql);
            $topCustomers = [];
            while ($row = $result->fetch_assoc()) {
                $topCustomers[] = $row;
            }
            return $topCustomers;
        } catch (Exception $e) {
            return [];
        }
    }

    private function getLowStockBooks() {
        try {
            $sql = "SELECT 
                        b.BookID,
                        b.Title,
                        b.Author,
                        b.Genre,
                        b.Price,
                        b.Stock,
                        s.Name as SupplierName
                    FROM Books b
                    LEFT JOIN Suppliers s ON b.SupplierID = s.SupplierID
                    WHERE b.Stock <= 5
                    ORDER BY b.Stock ASC
                    LIMIT 10";
            
            $result = $this->db->query($sql);
            $lowStockBooks = [];
            while ($row = $result->fetch_assoc()) {
                $lowStockBooks[] = $row;
            }
            return $lowStockBooks;
        } catch (Exception $e) {
            return [];
        }
    }

    private function getGenreStatistics() {
        try {
            $sql = "SELECT 
                        b.Genre,
                        COUNT(b.BookID) as BookCount,
                        COALESCE(SUM(b.Stock), 0) as TotalStock,
                        COALESCE(SUM(od.Quantity), 0) as TotalSold,
                        COALESCE(SUM(od.Quantity * od.Price), 0) as TotalRevenue
                    FROM Books b
                    LEFT JOIN OrderDetails od ON b.BookID = od.BookID
                    GROUP BY b.Genre
                    ORDER BY TotalRevenue DESC, TotalSold DESC";
            
            $result = $this->db->query($sql);
            $genreStats = [];
            while ($row = $result->fetch_assoc()) {
                $genreStats[] = $row;
            }
            return $genreStats;
        } catch (Exception $e) {
            return [];
        }
    }

    private function getSupplierStatistics() {
        try {
            $sql = "SELECT 
                        s.SupplierID,
                        s.Name as SupplierName,
                        s.Address,
                        s.Phone,
                        COUNT(b.BookID) as BookCount,
                        COALESCE(SUM(b.Stock), 0) as TotalStock,
                        COALESCE(SUM(b.Stock * b.Price), 0) as InventoryValue,
                        COALESCE(SUM(od.Quantity), 0) as TotalSold,
                        COALESCE(SUM(od.Quantity * od.Price), 0) as TotalRevenue
                    FROM Suppliers s
                    LEFT JOIN Books b ON s.SupplierID = b.SupplierID
                    LEFT JOIN OrderDetails od ON b.BookID = od.BookID
                    GROUP BY s.SupplierID
                    ORDER BY TotalRevenue DESC, BookCount DESC";
            
            $result = $this->db->query($sql);
            $supplierStats = [];
            while ($row = $result->fetch_assoc()) {
                $supplierStats[] = $row;
            }
            return $supplierStats;
        } catch (Exception $e) {
            return [];
        }
    }

    private function getInventoryStatistics() {
        try {
            $sql = "SELECT 
                        COUNT(*) as TotalBooks,
                        COALESCE(SUM(Stock), 0) as TotalStock,
                        COALESCE(SUM(Stock * Price), 0) as TotalValue,
                        COALESCE(AVG(Price), 0) as AveragePrice,
                        COUNT(CASE WHEN Stock <= 5 THEN 1 END) as LowStockCount,
                        COUNT(CASE WHEN Stock = 0 THEN 1 END) as OutOfStockCount,
                        COUNT(CASE WHEN Stock > 20 THEN 1 END) as HighStockCount,
                        COALESCE(SUM(CASE WHEN Stock <= 5 THEN Stock * Price ELSE 0 END), 0) as LowStockValue
                    FROM Books";
            
            $result = $this->db->query($sql);
            return $result->fetch_assoc();
        } catch (Exception $e) {
            return [
                'TotalBooks' => 0,
                'TotalStock' => 0,
                'TotalValue' => 0,
                'AveragePrice' => 0,
                'LowStockCount' => 0,
                'OutOfStockCount' => 0,
                'HighStockCount' => 0,
                'LowStockValue' => 0
            ];
        }
    }

    private function getCustomerGrowthStatistics() {
        try {
            $sql = "SELECT 
                        DATE_FORMAT(OrderDate, '%Y-%m') as Month,
                        COUNT(DISTINCT CustomerID) as NewCustomers,
                        COUNT(*) as TotalOrders,
                        COALESCE(SUM(TotalAmount), 0) as TotalRevenue
                    FROM Orders 
                    WHERE OrderDate >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
                    GROUP BY DATE_FORMAT(OrderDate, '%Y-%m')
                    ORDER BY Month DESC";
            
            $result = $this->db->query($sql);
            $customerGrowth = [];
            while ($row = $result->fetch_assoc()) {
                $customerGrowth[] = $row;
            }
            return $customerGrowth;
        } catch (Exception $e) {
            return [];
        }
    }

    private function getSalesTrends() {
        try {
            $sql = "SELECT 
                        DATE_FORMAT(OrderDate, '%Y-%m-%d') as Date,
                        COUNT(*) as DailyOrders,
                        COALESCE(SUM(TotalAmount), 0) as DailyRevenue,
                        COUNT(DISTINCT CustomerID) as DailyCustomers,
                        COALESCE(AVG(TotalAmount), 0) as AverageOrderValue
                    FROM Orders 
                    WHERE OrderDate >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                    GROUP BY DATE_FORMAT(OrderDate, '%Y-%m-%d')
                    ORDER BY Date DESC
                    LIMIT 30";
            
            $result = $this->db->query($sql);
            $salesTrends = [];
            while ($row = $result->fetch_assoc()) {
                $salesTrends[] = $row;
            }
            return $salesTrends;
        } catch (Exception $e) {
            return [];
        }
    }

    private function getOrderStatusStatistics() {
        try {
            $sql = "SELECT 
                        'Tổng đơn hàng' as Status,
                        COUNT(*) as Count,
                        COALESCE(SUM(TotalAmount), 0) as TotalValue
                    FROM Orders
                    UNION ALL
                    SELECT 
                        'Đơn hàng tháng này' as Status,
                        COUNT(*) as Count,
                        COALESCE(SUM(TotalAmount), 0) as TotalValue
                    FROM Orders 
                    WHERE OrderDate >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                    UNION ALL
                    SELECT 
                        'Đơn hàng tuần này' as Status,
                        COUNT(*) as Count,
                        COALESCE(SUM(TotalAmount), 0) as TotalValue
                    FROM Orders 
                    WHERE OrderDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                    UNION ALL
                    SELECT 
                        'Đơn hàng hôm nay' as Status,
                        COUNT(*) as Count,
                        COALESCE(SUM(TotalAmount), 0) as TotalValue
                    FROM Orders 
                    WHERE DATE(OrderDate) = CURDATE()";
            
            $result = $this->db->query($sql);
            $orderStatusStats = [];
            while ($row = $result->fetch_assoc()) {
                $orderStatusStats[] = $row;
            }
            return $orderStatusStats;
        } catch (Exception $e) {
            return [
                ['Status' => 'Tổng đơn hàng', 'Count' => 0, 'TotalValue' => 0],
                ['Status' => 'Đơn hàng tháng này', 'Count' => 0, 'TotalValue' => 0],
                ['Status' => 'Đơn hàng tuần này', 'Count' => 0, 'TotalValue' => 0],
                ['Status' => 'Đơn hàng hôm nay', 'Count' => 0, 'TotalValue' => 0]
            ];
        }
    }

    private function getNewBooksStatistics() {
        try {
            $sql = "SELECT 
                        COUNT(*) as TotalNewBooks,
                        COALESCE(SUM(Stock), 0) as TotalStock,
                        COALESCE(SUM(Stock * Price), 0) as TotalValue,
                        COALESCE(AVG(Price), 0) as AveragePrice,
                        COUNT(CASE WHEN Stock > 0 THEN 1 END) as AvailableBooks,
                        COUNT(CASE WHEN Stock = 0 THEN 1 END) as OutOfStockBooks
                    FROM Books 
                    WHERE BookID > (SELECT MAX(BookID) - 10 FROM Books)";
            
            $result = $this->db->query($sql);
            return $result->fetch_assoc();
        } catch (Exception $e) {
            return [
                'TotalNewBooks' => 0,
                'TotalStock' => 0,
                'TotalValue' => 0,
                'AveragePrice' => 0,
                'AvailableBooks' => 0,
                'OutOfStockBooks' => 0
            ];
        }
    }

    public function getRecentOrders($limit = 10) {
        try {
            $sql = "SELECT 
                        o.OrderID,
                        o.OrderDate,
                        o.TotalAmount,
                        c.Name as CustomerName,
                        c.Email as CustomerEmail,
                        COUNT(od.BookID) as ItemCount
                    FROM Orders o
                    LEFT JOIN Customers c ON o.CustomerID = c.CustomerID
                    LEFT JOIN OrderDetails od ON o.OrderID = od.OrderID
                    GROUP BY o.OrderID
                    ORDER BY o.OrderDate DESC
                    LIMIT ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("i", $limit);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $recentOrders = [];
            while ($row = $result->fetch_assoc()) {
                $recentOrders[] = $row;
            }
            return $recentOrders;
        } catch (Exception $e) {
            return [];
        }
    }

    public function getSalesChartData($period = 'month') {
        try {
            $dateFormat = $period === 'month' ? '%Y-%m' : '%Y-%m-%d';
            $interval = $period === 'month' ? '12 MONTH' : '30 DAY';
            
            $sql = "SELECT 
                        DATE_FORMAT(OrderDate, ?) as Period,
                        COUNT(*) as OrderCount,
                        COALESCE(SUM(TotalAmount), 0) as Revenue,
                        COUNT(DISTINCT CustomerID) as UniqueCustomers
                    FROM Orders 
                    WHERE OrderDate >= DATE_SUB(NOW(), INTERVAL ?)
                    GROUP BY DATE_FORMAT(OrderDate, ?)
                    ORDER BY Period DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sss", $dateFormat, $interval, $dateFormat);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $chartData = [];
            while ($row = $result->fetch_assoc()) {
                $chartData[] = $row;
            }
            return $chartData;
        } catch (Exception $e) {
            return [];
        }
    }

    private function getRevenueStatistics() {
        try {
            // Doanh thu theo tuần (4 tuần gần nhất)
            $weeklyRevenue = $this->getWeeklyRevenue();
            
            // Doanh thu theo tháng (12 tháng gần nhất)
            $monthlyRevenue = $this->getMonthlyRevenue();
            
            // Doanh thu theo năm (5 năm gần nhất)
            $yearlyRevenue = $this->getYearlyRevenue();
            
            // Thống kê tổng hợp
            $summary = $this->getRevenueSummary();
            
            return [
                'weekly' => $weeklyRevenue,
                'monthly' => $monthlyRevenue,
                'yearly' => $yearlyRevenue,
                'summary' => $summary
            ];
        } catch (Exception $e) {
            return [
                'weekly' => [],
                'monthly' => [],
                'yearly' => [],
                'summary' => [
                    'ThisWeekRevenue' => 0,
                    'ThisMonthRevenue' => 0,
                    'ThisYearRevenue' => 0,
                    'ThisWeekOrders' => 0,
                    'ThisMonthOrders' => 0,
                    'ThisYearOrders' => 0,
                    'AverageOrderValue' => 0,
                    'HighestOrderValue' => 0
                ]
            ];
        }
    }

    private function getWeeklyRevenue() {
        try {
            $sql = "SELECT 
                        YEARWEEK(OrderDate, 1) as WeekNumber,
                        DATE_FORMAT(MIN(OrderDate), '%Y-%m-%d') as WeekStart,
                        DATE_FORMAT(MAX(OrderDate), '%Y-%m-%d') as WeekEnd,
                        COUNT(*) as OrderCount,
                        COALESCE(SUM(TotalAmount), 0) as Revenue,
                        COUNT(DISTINCT CustomerID) as UniqueCustomers
                    FROM Orders 
                    WHERE OrderDate >= DATE_SUB(NOW(), INTERVAL 4 WEEK)
                    GROUP BY YEARWEEK(OrderDate, 1)
                    ORDER BY WeekNumber DESC
                    LIMIT 4";
            
            $result = $this->db->query($sql);
            $weeklyData = [];
            while ($row = $result->fetch_assoc()) {
                $weeklyData[] = $row;
            }
            return $weeklyData;
        } catch (Exception $e) {
            return [];
        }
    }

    private function getMonthlyRevenue() {
        try {
            $sql = "SELECT 
                        DATE_FORMAT(OrderDate, '%Y-%m') as Month,
                        DATE_FORMAT(OrderDate, '%Y') as Year,
                        DATE_FORMAT(OrderDate, '%m') as MonthNumber,
                        COUNT(*) as OrderCount,
                        COALESCE(SUM(TotalAmount), 0) as Revenue,
                        COUNT(DISTINCT CustomerID) as UniqueCustomers
                    FROM Orders 
                    WHERE OrderDate >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
                    GROUP BY DATE_FORMAT(OrderDate, '%Y-%m')
                    ORDER BY Month DESC
                    LIMIT 12";
            
            $result = $this->db->query($sql);
            $monthlyData = [];
            while ($row = $result->fetch_assoc()) {
                $monthlyData[] = $row;
            }
            return $monthlyData;
        } catch (Exception $e) {
            return [];
        }
    }

    private function getYearlyRevenue() {
        try {
            $sql = "SELECT 
                        YEAR(OrderDate) as Year,
                        COUNT(*) as OrderCount,
                        COALESCE(SUM(TotalAmount), 0) as Revenue,
                        COUNT(DISTINCT CustomerID) as UniqueCustomers
                    FROM Orders 
                    GROUP BY YEAR(OrderDate)
                    ORDER BY Year DESC
                    LIMIT 5";
            
            $result = $this->db->query($sql);
            $yearlyData = [];
            while ($row = $result->fetch_assoc()) {
                $yearlyData[] = $row;
            }
            return $yearlyData;
        } catch (Exception $e) {
            return [];
        }
    }

    private function getRevenueSummary() {
        try {
            $sql = "SELECT 
                        COALESCE(SUM(CASE WHEN OrderDate >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN TotalAmount ELSE 0 END), 0) as ThisWeekRevenue,
                        COALESCE(SUM(CASE WHEN OrderDate >= DATE_SUB(NOW(), INTERVAL 30 DAY) THEN TotalAmount ELSE 0 END), 0) as ThisMonthRevenue,
                        COALESCE(SUM(CASE WHEN OrderDate >= DATE_SUB(NOW(), INTERVAL 365 DAY) THEN TotalAmount ELSE 0 END), 0) as ThisYearRevenue,
                        COALESCE(SUM(CASE WHEN OrderDate >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 ELSE 0 END), 0) as ThisWeekOrders,
                        COALESCE(SUM(CASE WHEN OrderDate >= DATE_SUB(NOW(), INTERVAL 30 DAY) THEN 1 ELSE 0 END), 0) as ThisMonthOrders,
                        COALESCE(SUM(CASE WHEN OrderDate >= DATE_SUB(NOW(), INTERVAL 365 DAY) THEN 1 ELSE 0 END), 0) as ThisYearOrders,
                        COALESCE(AVG(TotalAmount), 0) as AverageOrderValue,
                        COALESCE(MAX(TotalAmount), 0) as HighestOrderValue
                    FROM Orders";
            
            $result = $this->db->query($sql);
            return $result->fetch_assoc();
        } catch (Exception $e) {
            return [
                'ThisWeekRevenue' => 0,
                'ThisMonthRevenue' => 0,
                'ThisYearRevenue' => 0,
                'ThisWeekOrders' => 0,
                'ThisMonthOrders' => 0,
                'ThisYearOrders' => 0,
                'AverageOrderValue' => 0,
                'HighestOrderValue' => 0
            ];
        }
    }

    public function __destruct() {
        $this->db->closeConnection();
    }
}
?>
