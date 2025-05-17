<?php
// 🛍️Individual Product Page
session_start();
// Ensure the user is logged in
if (empty($_SESSION['userID'])) {
  header('Location: login.php');
  exit();
}

include 'includes/dbh.php';
include 'includes/header.php';
include 'includes/topbar.php';

// Get the product ID from URL (sanitize as integer)
$productID = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product details along with artist name
$query = mysqli_query($conn, "
  SELECT p.name, p.price, p.description, a.name AS artist_name
  FROM product p
  JOIN artist a ON p.artistID = a.artistID
  WHERE p.productID = $productID
  LIMIT 1
");

// Show error if no product found
if (!$query || mysqli_num_rows($query) === 0) {
  echo "<div class='main-content'><p>Product not found.</p></div>";
  exit();
}

// Fetch result into associative array
$product = mysqli_fetch_assoc($query);
?>

<!-- Display Product Info -->
<div class="main-content">
  <h2><?= htmlspecialchars($product['name']) ?></h2>
  <p><strong>By:</strong> <?= htmlspecialchars($product['artist_name']) ?></p>
  <p><strong>Price:</strong> $<?= number_format($product['price'], 2) ?></p>
  <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>

  <button class="purchase-btn">Buy Now</button>
</div>

</div> 
</div> 
</body>
</html>
