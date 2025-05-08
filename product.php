<?php
session_start();
include 'includes/dbh.php';
include 'includes/header.php';
include 'includes/topbar.php';

$productID = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = mysqli_query($conn, "
  SELECT p.name, p.price, p.description, a.name AS artist_name
  FROM product p
  JOIN artist a ON p.artistID = a.artistID
  WHERE p.productID = $productID
  LIMIT 1
");

if (!$query || mysqli_num_rows($query) === 0) {
  echo "<div class='main-content'><p>Product not found.</p></div>";
  exit();
}

$product = mysqli_fetch_assoc($query);
?>

<div class="main-content">
  <h2><?= htmlspecialchars($product['name']) ?></h2>
  <p><strong>By:</strong> <?= htmlspecialchars($product['artist_name']) ?></p>
  <p><strong>Price:</strong> $<?= number_format($product['price'], 2) ?></p>
  <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>

  <button class="purchase-btn">Buy Now</button>
</div>

</div> <!-- .main-content -->
</div> <!-- .wrapper -->
</body>
</html>
