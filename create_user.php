<?php
session_start();
include("db.php"); // Adjust as per your database connection file

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $phone = $_POST['phone'];

    // Only allow 'admin' or 'user' as valid roles
    if (!in_array($role, ['admin', 'client'])) {
        echo "Invalid role value.";
        exit();
    }

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Insert user details into database
        $sql = "INSERT INTO users (username, email, password, role, phone) VALUES (:username, :email, :password, :role, :phone)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $hashed_password,
            'role' => $role,
            'phone' => $phone
        ]);

        // Redirect to manage users page after creation
        header("Location: manage_users.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>