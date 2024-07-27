<?php
session_start();
include("db.php"); // Adjust as per your database connection file

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Prepare and execute the delete statement
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);

    // Redirect to manage users page after deletion
    header("Location: manage_users.php");
    exit();
} else {
    echo "Invalid user ID.";
}
?>
