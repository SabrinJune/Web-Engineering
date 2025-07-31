<?php
$conn = new mysqli("localhost", "root", "", "bookshop");

// Part 1: Handle form submission (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $best_seller = isset($_POST['best']) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE books SET title = ?, author = ?, genre = ?, best = ? WHERE id = ?");
    $stmt->bind_param("sssii", $title, $author, $genre, $best, $id);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    header("Location: view.php");
    exit;
}

// Part 2: Load book data for editing (GET)
if (!isset($_GET['id'])) {
    die("Book ID not provided.");
}

$id = (int)$_GET['id'];
$result = $conn->query("SELECT * FROM books WHERE id = $id");

if ($result->num_rows === 0) {
    die("Book not found.");
}

$book = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Book</title>
</head>
<body>
    <h2>Update Book</h2>
    <form method="POST" action="update.php">
        <input type="hidden" name="id" value="<?= $book['id'] ?>">

        <label>Title:</label><br>
        <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required><br><br>

        <label>Author:</label><br>
        <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required><br><br>

        <label>Genre:</label><br>
        <select name="genre" required>
            <?php
            $genres = ["Fiction", "Non-fiction", "Science", "History"];
            foreach ($genres as $g) {
                $selected = ($book['genre'] === $g) ? "selected" : "";
                echo "<option value=\"$g\" $selected>$g</option>";
            }
            ?>
        </select><br><br>

        <label>
            <input type="checkbox" name="best" <?= $book['best'] ? "checked" : "" ?>>
            Best Seller?
        </label><br><br>

        <input type="submit" value="Update Book">
    </form>
    <br>
    <a href="view.php">Cancel</a>
</body>
</html>
