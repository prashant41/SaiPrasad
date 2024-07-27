<?php
include("db.php");
session_start();
if(!isset($_SESSION["username"])){
    header("Location:login.php");
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
        /* Basic CSS for navigation */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #002147;
            overflow: hidden;
        }
        nav a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        nav a:hover {
            background-color: #ddd;
            color: black;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <script>
            function confirmLogout() {
                return confirm('Are you sure you want to log out?');
            }
    </script>
</head>
<body>
    <nav>
        <a href="order_form.php">Order Form</a>
        <a href="display_orders.php">Display Orders</a>
        <a href="admin_filter.php">Filter Orders</a>
        <a href="manage_users.php">Manage</a>
        <a href="report.php">Report</a>
        <a href="raw_materials.php">Raw Material Data</a>
        <a href="logout.php" onclick="return confirm('Are you sure you want to log out?');">Log Out</a>
        <!-- Add more links sas needed -->
    </nav>
        <div style="padding: 20px;">
        <!-- Admin dashboard content will go here -->
        <h1>Welcome to Admin Dashboard</h1>
        <h2>Hello <?php print $_SESSION["username"]; ?>, welcome back!!!</h2>
        <p>This is where you check your orders, and more.</p>
        </div>
     
        

</body>
</html>
