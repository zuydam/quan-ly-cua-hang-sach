-- Database schema update for QLS system
-- Adding promotion and payment functionality

USE QLS;

-- 1. Create Promotions table
CREATE TABLE Promotions (
    PromotionID INT PRIMARY KEY AUTO_INCREMENT,
    PromotionCode VARCHAR(20) UNIQUE NOT NULL,
    PromotionName VARCHAR(100) NOT NULL,
    Description TEXT,
    DiscountType ENUM('percentage', 'fixed_amount') NOT NULL,
    DiscountValue DECIMAL(10,2) NOT NULL,
    MinimumOrderAmount DECIMAL(10,2) DEFAULT 0,
    MaximumDiscount DECIMAL(10,2) DEFAULT NULL,
    StartDate DATE NOT NULL,
    EndDate DATE NOT NULL,
    IsActive BOOLEAN DEFAULT TRUE,
    UsageLimit INT DEFAULT NULL,
    UsedCount INT DEFAULT 0,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CHECK (DiscountValue > 0),
    CHECK (EndDate >= StartDate),
    CHECK (UsageLimit IS NULL OR UsageLimit > 0),
    CHECK (UsedCount >= 0)
);

-- 2. Create PromotionTypes table to define promotion categories
CREATE TABLE PromotionTypes (
    TypeID INT PRIMARY KEY AUTO_INCREMENT,
    TypeName VARCHAR(50) NOT NULL,
    Description TEXT
);

-- 3. Create PromotionTargets table to link promotions with targets (products, customers, etc.)
CREATE TABLE PromotionTargets (
    TargetID INT PRIMARY KEY AUTO_INCREMENT,
    PromotionID INT NOT NULL,
    TargetType ENUM('product', 'customer', 'category', 'all') NOT NULL,
    TargetID_Value INT DEFAULT NULL, -- BookID for products, CustomerID for customers, etc.
    FOREIGN KEY (PromotionID) REFERENCES Promotions(PromotionID) ON DELETE CASCADE
);

-- 4. Create PaymentMethods table
CREATE TABLE PaymentMethods (
    PaymentMethodID INT PRIMARY KEY AUTO_INCREMENT,
    MethodName VARCHAR(50) NOT NULL,
    Description TEXT,
    IsActive BOOLEAN DEFAULT TRUE,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 5. Update Orders table to include payment information
ALTER TABLE Orders 
ADD COLUMN PaymentMethodID INT DEFAULT NULL,
ADD COLUMN PromotionID INT DEFAULT NULL,
ADD COLUMN DiscountAmount DECIMAL(10,2) DEFAULT 0,
ADD COLUMN SubTotal DECIMAL(10,2) DEFAULT 0,
ADD COLUMN PaymentStatus ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
ADD COLUMN PaymentDate TIMESTAMP NULL,
ADD COLUMN TransactionID VARCHAR(100) DEFAULT NULL,
ADD FOREIGN KEY (PaymentMethodID) REFERENCES PaymentMethods(PaymentMethodID),
ADD FOREIGN KEY (PromotionID) REFERENCES Promotions(PromotionID);

-- 6. Create PromotionUsage table to track promotion usage
CREATE TABLE PromotionUsage (
    UsageID INT PRIMARY KEY AUTO_INCREMENT,
    PromotionID INT NOT NULL,
    OrderID INT NOT NULL,
    CustomerID INT NOT NULL,
    DiscountAmount DECIMAL(10,2) NOT NULL,
    UsedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (PromotionID) REFERENCES Promotions(PromotionID),
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID),
    FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID)
);

-- Insert default promotion types
INSERT INTO PromotionTypes (TypeName, Description) VALUES
('Product Discount', 'Discount applied to specific products'),
('Customer Discount', 'Discount applied to specific customers'),
('Category Discount', 'Discount applied to product categories'),
('Order Discount', 'Discount applied to entire order'),
('New Customer', 'Discount for new customers'),
('Loyalty', 'Discount for loyal customers'),
('Seasonal', 'Seasonal promotions'),
('Flash Sale', 'Limited time promotions');

-- Insert default payment methods
INSERT INTO PaymentMethods (MethodName, Description) VALUES
('Cash', 'Thanh toán tiền mặt'),
('Bank Transfer', 'Chuyển khoản ngân hàng'),
('Credit Card', 'Thanh toán bằng thẻ tín dụng'),
('E-wallet', 'Ví điện tử'),
('COD', 'Thanh toán khi nhận hàng');

-- Insert sample promotions
INSERT INTO Promotions (PromotionCode, PromotionName, Description, DiscountType, DiscountValue, MinimumOrderAmount, StartDate, EndDate, UsageLimit) VALUES
('WELCOME10', 'Giảm giá 10% cho khách hàng mới', 'Áp dụng cho đơn hàng đầu tiên', 'percentage', 10.00, 100000, '2024-01-01', '2024-12-31', 100),
('SAVE20', 'Giảm giá 20,000đ cho đơn hàng từ 200,000đ', 'Áp dụng cho tất cả khách hàng', 'fixed_amount', 20000.00, 200000, '2024-01-01', '2024-12-31', 50),
('BOOKSALE', 'Giảm giá 15% cho sách văn học', 'Áp dụng cho sách văn học', 'percentage', 15.00, 50000, '2024-01-01', '2024-12-31', 200),
('LOYALTY5', 'Giảm giá 5% cho khách hàng thân thiết', 'Áp dụng cho khách hàng có từ 3 đơn hàng trở lên', 'percentage', 5.00, 0, '2024-01-01', '2024-12-31', NULL);

-- Insert promotion targets
INSERT INTO PromotionTargets (PromotionID, TargetType, TargetID_Value) VALUES
(1, 'customer', NULL), -- WELCOME10 for all customers
(2, 'all', NULL), -- SAVE20 for all orders
(3, 'category', NULL), -- BOOKSALE for literature category (will be handled in application logic)
(4, 'customer', NULL); -- LOYALTY5 for loyal customers

-- Update existing orders to have default values
UPDATE Orders SET 
    SubTotal = TotalAmount,
    PaymentMethodID = 1, -- Default to Cash
    PaymentStatus = 'paid',
    PaymentDate = OrderDate
WHERE PaymentMethodID IS NULL;

-- Create indexes for better performance
CREATE INDEX idx_promotions_active ON Promotions(IsActive, StartDate, EndDate);
CREATE INDEX idx_promotions_code ON Promotions(PromotionCode);
CREATE INDEX idx_orders_payment ON Orders(PaymentStatus, PaymentMethodID);
CREATE INDEX idx_promotion_usage ON PromotionUsage(PromotionID, CustomerID);


