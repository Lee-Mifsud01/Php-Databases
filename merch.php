<?php
include 'includes/dbh.php';
include 'includes/header.php';
include 'includes/topbar.php';

$artistID = isset($_GET['artist']) ? intval($_GET['artist']) : 0;
?>
<link rel="stylesheet" href="style.css">

<div class="main-content">
  
  <h2>Artist Merchandise</h2>
  <div class="grid">
    <?php
    $sql = "
      SELECT p.productID, p.name, p.price, p.description
      FROM product p
      JOIN producttype pt ON p.productTypeID = pt.productTypeID
      WHERE pt.wearableID IS NOT NULL
      AND p.artistID = $artistID
    ";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="card">';
        echo '<div class="card-img">🛍️</div>';
        echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
        echo '<p><strong>$' . number_format($row['price'], 2) . '</strong></p>';
        echo '<p>' . nl2br(htmlspecialchars($row['description'])) . '</p>';
        
        // Button container
        echo '<div class="card-buttons">';
        echo '<a href="#" class="purchase-btn">Buy</a>';
        echo '<a href="product.php?id=' . $row['productID'] . '" class="btn-more">More Info</a>';
        echo '</div>';
        echo '</div>'; // end .card
      }
    } else {
      echo '<p>No merchandise available for this artist.</p>';
    }
    ?>
  </div>
</div>

</div> 
</div> 
</body>
</html>
