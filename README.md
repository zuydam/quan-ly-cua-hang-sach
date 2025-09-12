# Hệ thống Quản lý Sách (QLS) - Book Management System

## Tổng quan (Overview)

Hệ thống Quản lý Sách (QLS) là một ứng dụng web hoàn chỉnh được xây dựng theo kiến trúc service-oriented, cung cấp các chức năng quản lý toàn diện cho cửa hàng sách. Hệ thống bao gồm quản lý sách, khách hàng, đơn hàng, nhà cung cấp và dashboard thống kê.

## Kiến trúc hệ thống (System Architecture)

### Backend (PHP)
- **Framework**: PHP thuần với kiến trúc Service-Oriented
- **Database**: MySQL
- **API**: RESTful API với JSON responses
- **Cấu trúc thư mục**:
  ```
  backend/
  ├── config/
  │   └── database.php          # Cấu hình kết nối database
  ├── services/
  │   ├── BookService.php       # Logic nghiệp vụ quản lý sách
  │   ├── CustomerService.php   # Logic nghiệp vụ quản lý khách hàng
  │   ├── OrderService.php      # Logic nghiệp vụ quản lý đơn hàng
  │   ├── SupplierService.php   # Logic nghiệp vụ quản lý nhà cung cấp
  │   └── DashboardService.php  # Logic nghiệp vụ thống kê dashboard
  ├── api/
  │   ├── books.php            # API endpoint cho sách
  │   ├── customers.php        # API endpoint cho khách hàng
  │   ├── orders.php           # API endpoint cho đơn hàng
  │   ├── suppliers.php        # API endpoint cho nhà cung cấp
  │   └── dashboard.php        # API endpoint cho dashboard
  └── [legacy files]           # Các file cũ (redirect to new API)
  ```

### Frontend (Vue.js 3)
- **Framework**: Vue.js 3 với Composition API
- **Styling**: Tailwind CSS
- **Routing**: Vue Router
- **Build Tool**: Vite
- **Cấu trúc thư mục**:
  ```
  fontend/
  ├── src/
  │   ├── Dashboard.vue         # Trang dashboard chính
  │   ├── Books.vue            # Quản lý sách
  │   ├── Customers.vue        # Quản lý khách hàng
  │   ├── Orders.vue           # Quản lý đơn hàng
  │   ├── OrderDetails.vue     # Chi tiết đơn hàng
  │   ├── Supplier.vue         # Quản lý nhà cung cấp
  │   ├── router/
  │   │   └── index.js         # Cấu hình routing
  │   └── main.js              # Entry point
  ├── package.json
  └── vite.config.js
  ```

## Cơ sở dữ liệu (Database Schema)

### Bảng Books
```sql
CREATE TABLE Books (
    BookID int primary key auto_increment,
    Title varchar(100),
    Author varchar(100),
    Genre varchar(100),
    Price decimal(10,2),
    Stock int check(Stock >=0),
    SupplierID int,
    foreign key (SupplierID) references Suppliers(SupplierID)
);
```

### Bảng Customers
```sql
CREATE TABLE Customers (
    CustomerID int primary key auto_increment,
    Name varchar(50),
    Email varchar(100),
    Phone varchar(10)
);
```

### Bảng Orders
```sql
CREATE TABLE Orders (
    OrderID int primary key auto_increment,
    CustomerID int,
    OrderDate date,
    TotalAmount decimal(10,2),
    foreign key (CustomerID) references Customers(CustomerID)
);
```

### Bảng OrderDetails
```sql
CREATE TABLE OrderDetails(
    OrderID int,
    BookID int,
    Quantity int check (Quantity > 0),
    Price decimal(10,2),
    primary key(OrderID, BookID),
    foreign key (OrderID) references Orders(OrderID),
    foreign key(BookID) references Books(BookID)
);
```

### Bảng Suppliers
```sql
CREATE TABLE Suppliers (
    SupplierID int primary key auto_increment,
    Name varchar(100),
    Address text,
    Phone varchar(10)
);
```

## Tính năng chính (Main Features)

### 1. Dashboard
- **Thống kê tổng quan**: Tổng số sách, khách hàng, đơn hàng, doanh thu
- **Top sách bán chạy**: Hiển thị 10 sách bán chạy nhất
- **Sách tồn kho thấp**: Cảnh báo sách sắp hết hàng
- **Đơn hàng gần đây**: Hiển thị 5 đơn hàng mới nhất
- **Top khách hàng**: Khách hàng chi tiêu nhiều nhất
- **Thống kê theo thể loại**: Phân tích doanh thu theo thể loại sách

### 2. Quản lý Sách
- **CRUD operations**: Thêm, sửa, xóa, xem sách
- **Tìm kiếm**: Tìm kiếm theo tên, tác giả, thể loại
- **Quản lý tồn kho**: Theo dõi số lượng tồn kho
- **Liên kết nhà cung cấp**: Mỗi sách được liên kết với nhà cung cấp

### 3. Quản lý Khách hàng
- **CRUD operations**: Thêm, sửa, xóa, xem khách hàng
- **Tìm kiếm**: Tìm kiếm theo tên, email, số điện thoại
- **Thống kê**: Hiển thị số đơn hàng và tổng chi tiêu
- **Validation**: Kiểm tra email và số điện thoại hợp lệ

### 4. Quản lý Đơn hàng
- **Tạo đơn hàng**: Với kiểm tra tồn kho tự động
- **Chi tiết đơn hàng**: Quản lý từng sản phẩm trong đơn hàng
- **Cập nhật tồn kho**: Tự động cập nhật khi tạo/xóa đơn hàng
- **Thống kê**: Theo dõi doanh thu và số lượng đơn hàng

### 5. Quản lý Nhà cung cấp
- **CRUD operations**: Thêm, sửa, xóa, xem nhà cung cấp
- **Liên kết sách**: Hiển thị sách của từng nhà cung cấp
- **Thống kê**: Số lượng sách và tổng tồn kho

## Cài đặt và Chạy (Installation & Setup)

### Yêu cầu hệ thống (Requirements)
- PHP 7.4+
- MySQL 5.7+
- Node.js 16+
- XAMPP/WAMP/LAMP

### Bước 1: Cài đặt Database
```sql
-- Tạo database
CREATE DATABASE QLS;
USE QLS;

-- Chạy các câu lệnh CREATE TABLE và INSERT từ file SQL đã cung cấp
```

### Bước 2: Cấu hình Backend
1. Copy thư mục `backend` vào thư mục web server (htdocs cho XAMPP)
2. Cập nhật thông tin database trong `backend/config/database.php`:
   ```php
   private $host = "localhost:3307";
   private $username = "root";
   private $password = "14092004";
   private $database = "QLS";
   ```

### Bước 3: Cài đặt Frontend
```bash
cd fontend
npm install
npm run dev
```

### Bước 4: Truy cập ứng dụng
- Frontend: http://localhost:5173
- Backend API: http://localhost/qls/backend/api/

## API Endpoints

### Books API
- `GET /api/books.php` - Lấy danh sách sách
- `GET /api/books.php?search=keyword` - Tìm kiếm sách
- `GET /api/books.php?low_stock=1` - Sách tồn kho thấp
- `POST /api/books.php` - Thêm/sửa sách
- `DELETE /api/books.php` - Xóa sách

### Customers API
- `GET /api/customers.php` - Lấy danh sách khách hàng
- `GET /api/customers.php?search=keyword` - Tìm kiếm khách hàng
- `GET /api/customers.php?top=1` - Top khách hàng
- `POST /api/customers.php` - Thêm/sửa khách hàng
- `DELETE /api/customers.php` - Xóa khách hàng

### Orders API
- `GET /api/orders.php` - Lấy danh sách đơn hàng
- `GET /api/orders.php?details=orderId` - Chi tiết đơn hàng
- `POST /api/orders.php` - Tạo/sửa đơn hàng
- `DELETE /api/orders.php` - Xóa đơn hàng

### Dashboard API
- `GET /api/dashboard.php` - Thống kê tổng quan
- `GET /api/dashboard.php?type=recent_orders` - Đơn hàng gần đây
- `GET /api/dashboard.php?type=sales_chart` - Dữ liệu biểu đồ

## Tính năng bảo mật (Security Features)

1. **Input Validation**: Kiểm tra dữ liệu đầu vào
2. **SQL Injection Prevention**: Sử dụng Prepared Statements
3. **CORS Configuration**: Cấu hình CORS cho API
4. **Error Handling**: Xử lý lỗi an toàn
5. **Data Integrity**: Ràng buộc khóa ngoại và kiểm tra logic nghiệp vụ

## Tính năng nâng cao (Advanced Features)

1. **Transaction Management**: Quản lý giao dịch khi tạo đơn hàng
2. **Stock Management**: Tự động cập nhật tồn kho
3. **Search Functionality**: Tìm kiếm đa tiêu chí
4. **Responsive Design**: Giao diện responsive với Tailwind CSS
5. **Real-time Statistics**: Thống kê thời gian thực

## Cấu trúc Service Layer

### BookService
- `getAllBooks()`: Lấy tất cả sách
- `getBookById($id)`: Lấy sách theo ID
- `searchBooks($query)`: Tìm kiếm sách
- `createBook($data)`: Tạo sách mới
- `updateBook($data)`: Cập nhật sách
- `deleteBook($id)`: Xóa sách
- `getLowStockBooks($threshold)`: Sách tồn kho thấp

### CustomerService
- `getAllCustomers()`: Lấy tất cả khách hàng
- `searchCustomers($query)`: Tìm kiếm khách hàng
- `createCustomer($data)`: Tạo khách hàng mới
- `updateCustomer($data)`: Cập nhật khách hàng
- `deleteCustomer($id)`: Xóa khách hàng
- `getTopCustomers($limit)`: Top khách hàng

### OrderService
- `getAllOrders()`: Lấy tất cả đơn hàng
- `createOrder($data)`: Tạo đơn hàng mới (với transaction)
- `updateOrder($data)`: Cập nhật đơn hàng
- `deleteOrder($id)`: Xóa đơn hàng (hoàn trả tồn kho)
- `getOrderDetails($id)`: Chi tiết đơn hàng

## Hướng dẫn sử dụng (Usage Guide)

### Quản lý Sách
1. Truy cập trang "Quản lý sách"
2. Sử dụng nút "Thêm sách" để tạo sách mới
3. Nhập đầy đủ thông tin: tên, tác giả, thể loại, giá, số lượng, nhà cung cấp
4. Sử dụng chức năng tìm kiếm để lọc sách
5. Click "Sửa" hoặc "Xóa" để thao tác với sách

### Quản lý Khách hàng
1. Truy cập trang "Khách hàng"
2. Thêm khách hàng mới với thông tin đầy đủ
3. Xem thống kê đơn hàng và chi tiêu của từng khách hàng
4. Tìm kiếm khách hàng theo tên, email, số điện thoại

### Tạo Đơn hàng
1. Truy cập trang "Đơn hàng"
2. Chọn khách hàng và ngày đặt hàng
3. Thêm sách vào đơn hàng với số lượng
4. Hệ thống tự động kiểm tra tồn kho và tính tổng tiền
5. Lưu đơn hàng (tự động cập nhật tồn kho)

### Dashboard
1. Truy cập trang chủ để xem dashboard
2. Theo dõi các chỉ số quan trọng
3. Xem top sách bán chạy và khách hàng VIP
4. Kiểm tra sách tồn kho thấp để nhập hàng

## Troubleshooting

### Lỗi kết nối database
- Kiểm tra thông tin kết nối trong `database.php`
- Đảm bảo MySQL service đang chạy
- Kiểm tra port và credentials

### Lỗi API
- Kiểm tra đường dẫn API trong frontend
- Đảm bảo backend đang chạy trên web server
- Kiểm tra CORS configuration

### Lỗi frontend
- Chạy `npm install` để cài đặt dependencies
- Kiểm tra console browser để xem lỗi JavaScript
- Đảm bảo Vite dev server đang chạy

## Đóng góp (Contributing)

1. Fork repository
2. Tạo feature branch
3. Commit changes
4. Push to branch
5. Tạo Pull Request

## License

MIT License - Xem file LICENSE để biết thêm chi tiết.

## Liên hệ (Contact)

- Email: support@qls.com
- Website: https://qls.com
- Documentation: https://docs.qls.com






