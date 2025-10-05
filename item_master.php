<?php
session_start();
include 'database.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_item'])) {
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $qty = $_POST['qty'];
    $price = $_POST['price'];

    $check = $conn->query("SELECT * FROM products WHERE item_id = '$item_id'");
    if ($check->num_rows > 0) {
        echo "<p style='color:red;'>Error: Item ID already exists!</p>";
    } else {
        $sql = "INSERT INTO products (item_id, item_name, qty, price) VALUES ('$item_id', '$item_name', '$qty', '$price')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<p style='color:green;'>Item added successfully!</p>";
            header("Location: item_master.php");
            exit();
        } else {
            echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
        }
    }
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $conn->query("DELETE FROM products WHERE item_id = $delete_id");
    header("Location: item_master.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Master</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            text-align: center;
        }
        .container {
            background: white;
            padding: 20px;
            margin: 20px auto;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2, h3 {
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            text-align: left;
            margin-top: 10px;
            font-weight: bold;
        }
        input {
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin-top: 10px;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Item Master - Add New Item</h2>
        <form method="post">
            <label>Item ID:</label>
            <input type="number" name="item_id" required>
            
            <label>Item Name:</label>
            <input type="text" name="item_name" required>
            
            <label>Quantity:</label>
            <input type="number" name="qty" required>
            
            <label>Price:</label>
            <input type="number" step="0.01" name="price" required>
            
            <button type="submit" name="add_item">Add Item</button>
        </form>
    </div>

    <h3>Product List</h3>
    <table>
        <tr>
            <th>Item ID</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM products ORDER BY item_id ASC"); 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['item_id']}</td>
                    <td>{$row['item_name']}</td>
                    <td>{$row['qty']}</td>
                    <td>{$row['price']}</td>
                    <td>
                        <a href='modify_item.php?item_id={$row['item_id']}'><button>Modify</button></a>
                        <a href='item_master.php?delete_id={$row['item_id']}' onclick='return confirm(\"Are you sure to Delete the item?\");'><button style='background: red;'>Delete</button></a>
                    </td>
                </tr>";
        }
        ?>
    </table>

    <br>
    <button onclick="window.location.href='dashboard.php'">Exit</button>

</body>
</html>
