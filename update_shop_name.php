<?php
session_start();
include("db.php"); // Adjust as per your database connection file

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);

    if (!empty($name) && $id > 0) {
        try {
            $sql = "UPDATE shop_names SET name = :name WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            header("Location: manage_shop_names.php?success=2");
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Invalid data.";
    }
} else {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($id > 0) {
        try {
            $sql = "SELECT * FROM shop_names WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $shop = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        header("Location: manage_shop_names.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Shop Name</title>
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
        .create-form input {
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
    <a href="manage_shop_names.php" class="back-button">Go Back</a>
    <h2>Update Shop Name</h2>
    <div class="create-form">
        <form action="update_shop_name.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($shop['id']); ?>">
            <label for="name">Shop Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($shop['name']); ?>" required>
            <input type="submit" value="Update Shop Name">
        </form>
    </div>
</div>

</body>
</html>
