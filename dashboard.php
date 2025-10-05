<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #28a685;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .dashboard-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 350px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        p {
            font-size: 18px;
            color: #555;
            margin-bottom: 20px;
        }
        button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            background: #007bff;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: #0056b3;
        }
button.shopping-btn:hover {
    background: #218838; /* Darker green for the shopping button on hover */
}
    </style>
</head>
<body>

    <div class="dashboard-container">
        <h2>Admin Dashboard</h2>
        <p>Welcome, <?php echo $_SESSION['admin']; ?>!</p>

        <button onclick="window.location.href='item_master.php'">Item Master</button>
        <button onclick="window.location.href='shopping.php'">Shopping</button>
        <button onclick="window.location.href='sales.php'">Sales</button>
        <button onclick="window.location.href='report.php'">Report</button>
        <button onclick="window.location.href='logout.php'" style="background: #dc3545;">Exit</button>
    </div>

</body>
</html>
