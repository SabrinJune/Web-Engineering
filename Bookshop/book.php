<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
    <!-- Include the CSS block here -->
</head>
<body>
    <h2 class="center">Add a New Book</h2>
    <form method="POST" action="save_book.php">
        <label>Title:</label>
        <input type="text" name="title" required>

        <label>Author:</label>
        <input type="text" name="author" required>

        <label>Genre:</label>
        <select name="genre" required>
            <option value="Fiction">Fiction</option>
            <option value="Non-fiction">Non-fiction</option>
            <option value="Science">Science</option>
            <option value="History">History</option>
        </select>

        <label>
            <input type="checkbox" name="best"> Best Seller?
        </label><br><br>

        <input type="submit" value="Submit">
    </form>
    <br>
    <div class="center"><a href="view.php">View All Books</a></div>
</body>
</html>

