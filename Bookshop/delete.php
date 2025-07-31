<?php
if (!isset($_GET['id'])) {
    die("ID not provided.");
}

$conn = new mysqli("localhost", "root", "", "bookshop");

$id = (int)$_GET['id'];

$stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$stmt->close();
$conn->close();

header("Location: view.php");
exit;
?>
