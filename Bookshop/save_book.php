<?php
$conn = new mysqli("localhost", "root", "", "bookshop");

$title = $_POST['title'];
$author = $_POST['author'];
$genre = $_POST['genre'];
$best = isset($_POST['best']) ? 1 : 0;

$sql = "INSERT INTO books (title, author, genre, best) 
        VALUES ('$title', '$author', '$genre', $best)";
$conn->query($sql);
$conn->close();

header("Location: view.php");
exit;
?>
