<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];
    $total_price = $_POST['total_price'];

    $result = $conn->query("SELECT * FROM products WHERE id = '$item_id'");
    $product = $result->fetch_assoc();

    if ($product['qty'] >= $quantity) {
        echo "<h2>Order Summary</h2>";
        echo "<p><strong>Item Name:</strong> $item_name</p>";
        echo "<p><strong>Quantity:</strong> $quantity</p>";
        echo "<p><strong>Total Price:</strong> " . number_format($total_price, 2) . "</p>";

        $new_qty = $product['qty'] - $quantity;
        $conn->query("UPDATE products SET qty = '$new_qty' WHERE id = '$item_id'");

        echo "<p style='color:green;'>Order placed successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: Not enough stock available!</p>";
    }
    
    echo "<br><a href='shopping.php'><button>Continue Shopping</button></a>";
}
?>
