<?php
session_start();
include "db.php";

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $user_id = trim($_POST['id']); 
    $email = trim($_POST['email']);
    $birth = $_POST['birth'];
    $pass_plain = $_POST['pass'];

    // Generate serial: YYYY + last 2 digits of ID
    $birthYear = date('Y', strtotime($birth));
    $lastTwoID = substr($user_id, -2);
    $serial = $birthYear . $lastTwoID; // 6 digits total

    if (strlen($pass_plain) < 9) {
        $message = "Password must be at least 9 characters.";
    } elseif (!preg_match('/@diu\.edu\.bd$/', $email)) {
        $message = "Only DIU email addresses allowed (must end with @diu.edu.bd).";
    } elseif (!preg_match('/^\d{6}$/', $serial)) {
        $message = "Serial format error. Please check your birth date and ID.";
    } else {
        // Check if serial, email, or ID already exists
        $checkSql = "SELECT serial FROM users WHERE email=? OR id=? OR serial=?";
        $stmt = $conn->prepare($checkSql);
        $stmt->bind_param("sss", $email, $user_id, $serial);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $message = "Email, ID, or Serial already registered.";
        } else {
            $hash = password_hash($pass_plain, PASSWORD_DEFAULT);
            $insert = "INSERT INTO users (id, name, email, birth, pass, serial) VALUES (?,?,?,?,?,?)";
            $ins = $conn->prepare($insert);
            $ins->bind_param("ssssss", $user_id, $name, $email, $birth, $hash, $serial);
            if ($ins->execute()) {
                header("Location: login.php");
                exit;
            } else {
                $message = "Error during registration: " . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register - Sunny Cafe</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Register</h2>
  <?php if($message) echo "<p style='color:red;'>$message</p>"; ?>
  <form method="POST">
    Full name: <br><input type="text" name="name" required><br>
    Your ID (e.g. student id): <br><input type="text" name="id" required><br>
    DIU Email: <br><input type="email" name="email" required><br>
    Birth date: <br><input type="date" name="birth" required><br>
    Password (min 9 chars): <br><input type="password" name="pass" minlength="9" required><br><br>
    <button type="submit">Register</button>
  </form>
  <p>Already registered? <a href="login.php">Login</a></p>
</body>
</html>
