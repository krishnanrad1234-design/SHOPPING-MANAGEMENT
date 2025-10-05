<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $mobile = htmlspecialchars($_POST['mobile']);
    $purchase_date = $_POST['purchase_date'];
    $item_name = htmlspecialchars($_POST['item_name']);
    $item_id = intval($_POST['item_id']);
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);
    $total_price = floatval($_POST['total_price']);

    // OPTIONAL: Save to DB (if you want to keep a record)
    /*
    $stmt = $conn->prepare("INSERT INTO purchases (name, mobile, purchase_date, item_id, item_name, price, quantity, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssisdid", $name, $mobile, $purchase_date, $item_id, $item_name, $price, $quantity, $total_price);
    $stmt->execute();

    // Reduce stock in products table
    $conn->query("UPDATE products SET qty = qty - $quantity WHERE id = $item_id");
    */

    // Format price
    $priceFormatted = number_format($price, 2);
    $totalFormatted = number_format($total_price, 2);
} else {
    echo "Invalid request!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase Bill</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f4f4;
            padding: 20px;
            text-align: center;
        }
        .bill-container {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 0 10px #ccc;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        table {
            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }
        td {
            padding: 8px 0;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
        .value {
            color: #111;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
            padding-top: 10px;
        }
        .print-btn {
            margin-top: 20px;
            padding: 10px 15px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="bill-container">
    <h2>🧾 Purchase Bill</h2>
    <table>
        <tr><td class="label">Customer Name:</td><td class="value"><?= $name ?></td></tr>
        <tr><td class="label">Mobile Number:</td><td class="value"><?= $mobile ?></td></tr>
        <tr><td class="label">Purchase Date:</td><td class="value"><?= $purchase_date ?></td></tr>
        <tr><td class="label">Item Name:</td><td class="value"><?= $item_name ?></td></tr>
        <tr><td class="label">Item ID:</td><td class="value"><?= $item_id ?></td></tr>
        <tr><td class="label">Price per Item:</td><td class="value">₹<?= $priceFormatted ?></td></tr>
        <tr><td class="label">Purchased Quantity:</td><td class="value"><?= $quantity ?></td></tr>
        <tr><td class="label total">Total Amount:</td><td class="value total">₹<?= $totalFormatted ?></td></tr>
    </table>

    <button class="print-btn" onclick="window.print()">🖨️ Print Bill</button>
</div>

</body>
</html>
