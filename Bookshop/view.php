<?php
$conn = new mysqli("localhost", "root", "", "bookshop");
$result = $conn->query("SELECT * FROM books");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Books</title>
    
</head>
<body>
    <h2>Book List</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Best Seller</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['author']) ?></td>
            <td><?= htmlspecialchars($row['genre']) ?></td>
            <td><?= $row['best'] ? '✔️' : '❌' ?></td>
            <td>
                <a href="delete.php?id=<?= $row['id'] ?>">Delete</a> | 
                <a href="update.php?id=<?= $row['id'] ?>">Update</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="book.php">Add New Book</a>
</body>
</html>
