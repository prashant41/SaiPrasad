<?php
session_start();
include("db.php"); // Adjust as per your database connection file

// Check if the user is logged in as admin
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php"); // Redirect unauthorized users
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate the input for delete confirmation
    if (isset($_POST["confirmation"]) && $_POST["confirmation"] === "delete") {
        // Truncate the orders table
        $sql = "TRUNCATE TABLE orders";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute();
            header("Location: display_orders.php?message=All+orders+deleted");
            exit();
        } catch (Exception $e) {
            echo "Error deleting all orders: " . $e->getMessage();
        }
    } else {
        echo "Confirmation mismatch. Please enter 'delete' to confirm deletion.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete All Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
        }
        input[type="text"], input[type="submit"] {
            padding: 8px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #f44336; /* Red */
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #d32f2f; /* Darker red */
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Delete All Orders</h2>
    <form method="post">
        <label for="confirmation">Type 'delete' to confirm:</label>
        <input type="text" id="confirmation" name="confirmation">
        <br>
        <input type="submit" value="Delete All Orders">
    </form>
</div>
</body>
</html>
