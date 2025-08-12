<?php
// orders.php
session_start();
if (!isset($_SESSION['serial'])) {
    header("Location: login.php");
    exit;
}
include "db.php";
$serial = $_SESSION['serial'];

$sql = "SELECT item, amount, date, status FROM orders WHERE serial=? ORDER BY date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $serial);
$stmt->execute();
$res = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
  <title>My Orders</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>My Orders (Serial: <?php echo htmlspecialchars($serial); ?>)</h2>
  <table border="1" cellpadding="8" cellspacing="0">
    <tr>
      <th>Date</th><th>Item</th><th>Amount (৳)</th><th>Status</th>
    </tr>
    <?php while ($row = $res->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($row['date']); ?></td>
        <td><?php echo htmlspecialchars($row['item']); ?></td>
        <td><?php echo number_format($row['amount'], 2); ?></td>
        <td><?php echo htmlspecialchars($row['status']); ?></td>
      </tr>
    <?php endwhile; ?>
  </table>
  <p><a href="index.php">Back to Home</a></p>
</body>
</html>
