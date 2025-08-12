<?php
// index.php
session_start();
$loggedIn = isset($_SESSION['serial']);
$userSerial = $_SESSION['serial'] ?? null;
include "db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Lab2 - Sunny Cafe</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
</head>
<body>
  <nav style="display:flex; place-items:center; justify-content:space-between;">
    <h1 style="color:white;font-weight:200;">Sunny Cafe</h1>

    <?php if ($loggedIn): ?>
      <div style="color:aliceblue;">
        Serial: <strong><?php echo htmlspecialchars($userSerial); ?></strong>
        &nbsp; | &nbsp;
        <a href="orders.php" style="color:aliceblue;">My Orders</a>
        &nbsp; | &nbsp;
        <a href="logout.php" style="color:aliceblue;">Logout</a>
      </div>
    <?php else: ?>
      <div>
        <a href="login.php" style="color: aliceblue; margin-right:10px;">Login</a>
        <a href="register.php" style="color: aliceblue;">Register</a>
      </div>
    <?php endif; ?>

    <div style="color: aliceblue;">
      <i class="fa-solid fa-cart-shopping" id="cartIcon" onclick="toggleCart()">
        <sub id="cartCount">0</sub>
      </i>
    </div>
  </nav>

  <div class="main-banner">
    <button class="offer-button">Button</button>
  </div>

  <div class="card-container"></div>

  <div id="cartSidebar" class="cart-sidebar">
    <h2>Your Cart</h2>
    <div id="cartItems"></div>
    <div id="cartTotal"><strong>Total: ৳</strong></div>
    <div style="margin-top:10px;">
      <button id="checkoutBtn" onclick="checkout()">Checkout</button>
      <button onclick="closeCart()">Close</button>
    </div>
  </div>

  <footer>Thank you very much</footer>

  <!-- pass session info to JS -->
  <script>
    const IS_LOGGED_IN = <?php echo json_encode($loggedIn); ?>;
    const USER_SERIAL = <?php echo json_encode($userSerial); ?>;
  </script>

  <script src="index.js"></script>
</body>
</html>
