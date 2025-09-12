-- Migration script to add InputQuantity and OutputQuantity fields to Books table
-- This will help track stock more accurately by separating input and output quantities

-- Add new columns to Books table
ALTER TABLE Books 
ADD COLUMN InputQuantity INT DEFAULT 0 CHECK (InputQuantity >= 0),
ADD COLUMN OutputQuantity INT DEFAULT 0 CHECK (OutputQuantity >= 0);

-- Update existing records to set InputQuantity = Stock and OutputQuantity = 0
-- This assumes all current stock came from input and no output has occurred yet
UPDATE Books SET InputQuantity = Stock, OutputQuantity = 0 WHERE InputQuantity IS NULL OR OutputQuantity IS NULL;

-- Add a computed column or trigger to maintain Stock = InputQuantity - OutputQuantity
-- For now, we'll handle this in the application logic
-- You can also add a trigger if needed:
/*
DELIMITER //
CREATE TRIGGER update_stock_on_quantity_change
BEFORE UPDATE ON Books
FOR EACH ROW
BEGIN
    SET NEW.Stock = NEW.InputQuantity - NEW.OutputQuantity;
END//
DELIMITER ;
*/





