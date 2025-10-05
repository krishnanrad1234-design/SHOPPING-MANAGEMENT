<?php
include 'database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping</title>
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
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
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
            padding: 8px 12px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        button:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Available Products</h2>

        <?php
        $result = $conn->query("SELECT * FROM products ORDER BY id ASC");

        if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Item Name</th>
                    <th>Stock</th>
                    <th>Price (Each)</th>
                    <th>Buy</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= intval($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['item_name']) ?></td>
                        <td><?= intval($row['qty']) ?></td>
                        <td><?= number_format($row['price'], 2) ?></td>
                        <td>
                            <form action="buy.php" method="post">
                                <input type="hidden" name="item_id" value="<?= intval($row['id']) ?>">
                                <input type="hidden" name="item_name" value="<?= htmlspecialchars($row['item_name']) ?>">
                                <input type="hidden" name="price" value="<?= number_format($row['price'], 2) ?>">
                                <button type="submit" <?= $row['qty'] <= 0 ? 'disabled' : '' ?>>Buy</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No products available.</p>
        <?php endif; ?>

    </div>

</body>
</html>
