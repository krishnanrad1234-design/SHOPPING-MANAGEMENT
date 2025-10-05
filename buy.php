<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_id = intval($_POST['item_id']);
    $item_name = htmlspecialchars($_POST['item_name']);
    $price = floatval($_POST['price']);
    $purchase_date = date("Y-m-d");
    $result = $conn->query("SELECT qty FROM products WHERE id = '$item_id'");
    $row = $result->fetch_assoc();
    $available_qty = $row ? $row['qty'] : 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buy Item</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
            text-align: center;
        }
        .container {
            background: white;
            padding: 20px;
            max-width: 500px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
        h2 {
            color: #333;
        }
        label {
            display: block;
            margin-top: 10px;
            text-align: left;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        span#total {
            font-size: 18px;
            color: #007bff;
            font-weight: bold;
        }
        button {
            margin-top: 15px;
            padding: 10px;
            background: #28a745;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        #stockError {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>

    <script>
        function calculateTotal() {
            const qtyInput = document.getElementById("qty");
            const qty = parseInt(qtyInput.value);
            const price = parseFloat(document.getElementById("price").value);
            const available = parseInt(document.getElementById("available_qty").value);
            const totalSpan = document.getElementById("total");
            const totalPriceInput = document.getElementById("total_price");
            const errorMsg = document.getElementById("stockError");
            const submitBtn = document.getElementById("submitBtn");

            if (isNaN(qty) || qty <= 0) {
                totalSpan.innerText = "0.00";
                totalPriceInput.value = "";
                errorMsg.style.display = "none";
                submitBtn.disabled = true;
                return;
            }

            if (qty > available) {
                errorMsg.style.display = "block";
                errorMsg.innerText = "❌ Not enough stock available. Max available: " + available;
                totalSpan.innerText = "0.00";
                totalPriceInput.value = "";
                submitBtn.disabled = true;
            } else {
                const total = qty * price;
                totalSpan.innerText = total.toFixed(2);
                totalPriceInput.value = total.toFixed(2);
                errorMsg.style.display = "none";
                submitBtn.disabled = false;
            }
        }
    </script>
</head>
<body>

<div class="container">
    <h2>Purchase Item</h2>
    <form action="confirm_purchase.php" method="post">
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Mobile Number:</label>
        <input type="text" name="mobile" pattern="[0-9]{10}" title="Enter 10-digit mobile number" required>

        <label>Purchase Date:</label>
        <input type="text" name="purchase_date" value="<?= $purchase_date ?>" readonly>

        <label>Item Name:</label>
        <input type="text" name="item_name" value="<?= $item_name ?>" readonly>

        <label>Item ID:</label>
        <input type="text" name="item_id" value="<?= $item_id ?>" readonly>

        <label>Available Stock:</label>
        <input type="text" value="<?= $available_qty ?>" readonly>

        <label>Price per Item:</label>
        <input type="text" id="price" name="price" value="<?= $price ?>" readonly>

        <label>Quantity:</label>
        <input type="number" id="qty" name="quantity" min="1" max="<?= $available_qty ?>" onchange="calculateTotal()" oninput="calculateTotal()" required>

        <p id="stockError" style="display: none;"></p>

        <label>Total Amount:</label>
        <span id="total">0.00</span>
        <input type="hidden" id="total_price" name="total_price">

        <input type="hidden" id="available_qty" value="<?= $available_qty ?>">

        <button type="submit" id="submitBtn" disabled>Confirm Purchase</button>
    </form>
</div>

</body>
</html>
