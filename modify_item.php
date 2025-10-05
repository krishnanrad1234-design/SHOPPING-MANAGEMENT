<?php
session_start();
include 'database.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET['item_id'])) {
    $old_item_id = $_GET['item_id'];
    $result = $conn->query("SELECT * FROM products WHERE item_id = '$old_item_id'");
    $item = $result->fetch_assoc();

    if (!$item) {
        echo "<p style='color:red;'>Item not found!</p>";
        exit();
    }
} else {
    header("Location: item_master.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_item'])) {
    $new_item_id = $_POST['item_id'];
    $new_item_name = $_POST['item_name'];
    $new_qty = $_POST['qty'];
    $new_price = $_POST['price'];

    $check = $conn->query("SELECT * FROM products WHERE item_id = '$new_item_id' AND item_id != '$old_item_id'");

    if ($check->num_rows > 0) {
        echo "<p style='color:red;'>Error: Item ID already exists!</p>";
    } else {

        $conn->query("DELETE FROM products WHERE item_id = '$old_item_id'");
        $insert_sql = "INSERT INTO products (item_id, item_name, qty, price) VALUES ('$new_item_id', '$new_item_name', '$new_qty', '$new_price')";
        
        if ($conn->query($insert_sql) === TRUE) {
            echo "<p style='color:green;'>Item updated successfully!</p>";
            header("Location: item_master.php");
            exit();
        } else {
            echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Item</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        .container {
            background: white;
            padding: 20px;
            margin: 20px auto;
            border-radius: 5px;
            width: 350px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            text-align: left;
            margin-top: 10px;
        }
        input {
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        button {
            margin-top: 10px;
            padding: 8px;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Modify Item</h2>
        <form method="post">
            <label>Item ID:</label>
            <input type="number" name="item_id" value="<?php echo $item['item_id']; ?>" required>
            
            <label>Item Name:</label>
            <input type="text" name="item_name" value="<?php echo $item['item_name']; ?>" required>
            
            <label>Quantity:</label>
            <input type="number" name="qty" value="<?php echo $item['qty']; ?>" required>
            
            <label>Price:</label>
            <input type="number" step="0.01" name="price" value="<?php echo $item['price']; ?>" required>
            
            <button type="submit" name="update_item">Update Item</button>
        </form>
        <button onclick="window.location.href='item_master.php'">Back</button>
    </div>

</body>
</html>

