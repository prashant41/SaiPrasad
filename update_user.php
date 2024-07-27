<?php
session_start();
include("db.php"); // Adjust as per your database connection file

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Fetch user details for the form
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        echo "User not found.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $phone = $_POST['phone'];

    // Only allow 'admin' or 'client' as valid roles
    if (!in_array($role, ['admin', 'client'])) {
        echo "Invalid role value.";
        exit();
    }

    try {
        // Update user details
        $sql = "UPDATE users SET username = :username, email = :email, role = :role, phone = :phone WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'role' => $role,
            'phone' => $phone,
            'id' => $id
        ]);

        // Redirect to manage users page after update
        header("Location: manage_users.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 500px;
            position: relative;
        }
        .back-button {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 10px 15px;
            background-color: #4CAF50; /* Green */
            color: white;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
        }
        h2 {
            text-align: center;
            color: #002147; /* Dark blue */
            margin-top: 0;
        }
        .create-form {
            width: 100%;
        }
        .create-form label {
            display: block;
            margin-top: 10px;
        }
        .create-form input, .create-form select {
            padding: 8px;
            margin: 5px 0;
            width: 100%;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .create-form input[type="submit"] {
            background-color: #4CAF50; /* Green */
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="manage_users.php" class="back-button">Go Back</a>
    <h2>Update User</h2>
    <div class="create-form">
        <form action="update_user.php?id=<?php echo htmlspecialchars($id); ?>" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                <option value="client" <?php echo $user['role'] === 'client' ? 'selected' : ''; ?>>Client</option>
            </select>
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            <input type="submit" value="Update User">
        </form>
    </div>
</div>

</body>
</html>
