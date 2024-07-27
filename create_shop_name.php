<?php
session_start();
include("db.php"); // Adjust as per your database connection file

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);

    if (!empty($name)) {
        try {
            $sql = "INSERT INTO shop_names (name) VALUES (:name)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            header("Location: manage_shop_names.php?success=1");
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Shop name cannot be empty.";
    }
} else {
    header("Location: manage_shop_names.php");
    exit();
}
