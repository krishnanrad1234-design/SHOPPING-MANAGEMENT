<?php
include 'database.php';

$result = $conn->query("SELECT * FROM sales ORDER BY purchase_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Records</title>
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
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        button {
            margin-top: 20px;
            padding: 10px 15px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #0056b3;
        }
        a {
            text-decoration: none;
        }
        @media (max-width: 600px) {
            table {
                font-size: 14px;
            }
            th, td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Sales Records</h2>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Buyer Name</th>
                    <th>Mobile Number</th>
                    <th>Purchase Date</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Price Per Item</th>
                    <th>Total Amount</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['mobile']) ?></td>
                        <td><?= date("d-M-Y", strtotime($row['purchase_date'])) ?></td>
                        <td><?= htmlspecialchars($row['item_name']) ?></td>
                        <td><?= htmlspecialchars($row['quantity']) ?></td>
                        <td><?= number_format($row['total_price'] / $row['quantity'], 2) ?></td>
                        <td><?= number_format($row['total_price'], 2) ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No sales records found.</p>
        <?php endif; ?>
        <a href="dashboard.php"><button>Back to Dashboard</button></a>
    </div>

</body>
</html>
