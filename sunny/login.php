<?php
// login.php
session_start();
include "db.php";

$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $pass = $_POST['pass'];

    $sql = "SELECT serial, name, id, pass FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($user = $result->fetch_assoc()) {
        if (password_verify($pass, $user['pass'])) {
            $_SESSION['serial'] = $user['serial'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['user_id'] = $user['id']; // the custom 'id' value
            header("Location: index.php");
            exit;
        } else {
            $msg = "Invalid credentials.";
        }
    } else {
        $msg = "Invalid credentials.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login - Sunny Cafe</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Login</h2>
  <?php if($msg) echo "<p style='color:red;'>$msg</p>"; ?>
  <form method="POST">
    Email: <br><input type="email" name="email" required><br>
    Password: <br><input type="password" name="pass" required><br><br>
    <button type="submit">Login</button>
  </form>
  <p>Don't have an account? <a href="register.php">Register</a></p>
</body>
</html>
