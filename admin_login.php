<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $admin_user = "admin";
    $admin_pass = "admin123";

    if ($username === $admin_user && $password === $admin_pass) {
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php"); 
        exit();
    } else {
        $error = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
body {
    font-family: Arial, sans-serif;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100vh; 
    background-image: url(''); 
    background-size: 95%; 
    background-position: 95% 55%; 
    background-attachment: fixed; 
    margin: 0;
    overflow: hidden;
    text-align: center;
}

.header {
    font-size: 36px; /* Increase font size */
    font-weight: bold;
    background-color: #007bff; /* Add background color */
    color: white; /* Text color */
    padding: 20px;
    width: 100%; /* Full width of the screen */
    text-align: center; /* Center text */
    position: absolute; /* Fix the header at the top */
    top: 0; /* Position at the top */
    left: 0; /* Align to the left */
}

.sub-title {
    font-size: 18px;
    color: #555;
    margin-bottom: 20px;
}

.login-container {
    background: rgba(255, 255, 255, 0.8); 
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    width: 300px;
    text-align: center;
    margin: 0 auto; 
    margin-top: 80px; /* Adjusted margin to avoid overlap with header */
}

h2 {
    margin-bottom: 20px;
}

.error-message {
    color: red;
    margin-bottom: 15px;
}

label {
    display: block;
    text-align: left;
    margin-top: 10px;
}

input {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    width: 100%;
    padding: 10px;
    margin-top: 20px;
    border: none;
    background: #007bff;
    color: white;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background: #0056b3;
}


      </style>
</head>
<body>

   <div class="header"></div>
   <div class="header">Shopping Management System</div>

    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (isset($error)) { echo "<p class='error-message'>$error</p>"; } ?>
        <form method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>
