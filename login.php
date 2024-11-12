<?php
// Файл: login.php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $mysqli->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $hash);
    $stmt->fetch();

    if (password_verify($password, $hash)) {
        $_SESSION['user_id'] = $id;
        header("Location: products.php");
        exit();
    } else {
        echo "Invalid credentials";
    }
    $stmt->close();
}
?>

<form method="post" action="login.php">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
