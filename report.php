<?php
include 'database.php';

$sales_report = $conn->query("SELECT purchase_date, item_name, SUM(quantity) AS total_qty, SUM(total_price) AS total_sales FROM sales GROUP BY purchase_date, item_name ORDER BY purchase_date DESC");

$total_sales_result = $conn->query("SELECT SUM(total_price) AS total_sales_amount FROM sales");
$total_sales_row = $total_sales_result->fetch_assoc();
$total_sales_amount = $total_sales_row['total_sales_amount'];

$stock_report = $conn->query("SELECT * FROM products ORDER BY item_id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales & Stock Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 20px;
            margin: auto;
            width: 90%;
            max-width: 800px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .total-row {
            font-weight: bold;
            background-color: #28a745; /* Green background */
            color: black; /* Dark text */
        }
        button {
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Sales Report (Date-wise)</h2>
    <table>
        <tr>
            <th>Purchase Date</th>
            <th>Item Name</th>
            <th>Total Quantity Sold</th>
            <th>Total Sales Amount</th>
        </tr>
        <?php
        while ($row = $sales_report->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['purchase_date']}</td>
                    <td>{$row['item_name']}</td>
                    <td>{$row['total_qty']}</td>
                    <td>" . number_format($row['total_sales'], 2) . "</td>
                </tr>";
        }
        ?>
        <tr class="total-row">
            <td colspan="3">Total Sales:</td>
            <td><?php echo number_format($total_sales_amount, 2); ?></td>
        </tr>
    </table>

    <h2>Stock Report</h2>
    <table>
        <tr>
            <th>Item ID</th>
            <th>Item Name</th>
            <th>Available Stock</th>
            <th>Price (Each)</th>
        </tr>
        <?php
        while ($row = $stock_report->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['item_id']}</td>
                    <td>{$row['item_name']}</td>
                    <td>{$row['qty']}</td>
                    <td>" . number_format($row['price'], 2) . "</td>
                </tr>";
        }
        ?>
    </table>

    <br>
    <a href="dashboard.php"><button>Back to Dashboard</button></a>
</div>

</body>
</html>
