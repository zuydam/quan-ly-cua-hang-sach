<?php
require_once 'backend/config/database.php';

try {
    $db = new Database();
    
    // Check if the new columns exist
    $result = $db->query("DESCRIBE Books");
    echo "Books table structure:\n";
    while ($row = $result->fetch_assoc()) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
    
    // Check current books data
    $books = $db->query("SELECT BookID, Title, Stock, InputQuantity, OutputQuantity FROM Books LIMIT 5");
    echo "\nCurrent books data:\n";
    while ($row = $books->fetch_assoc()) {
        echo "BookID: " . $row['BookID'] . ", Title: " . $row['Title'] . 
             ", Stock: " . $row['Stock'] . 
             ", InputQuantity: " . $row['InputQuantity'] . 
             ", OutputQuantity: " . $row['OutputQuantity'] . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>





