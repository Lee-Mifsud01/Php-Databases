<?php
include 'includes/dbh.php';
include 'includes/header.php';
include 'includes/topbar.php';
?>

<div class="main-content">
  <h2>Artist Merchandise</h2>
  <div class="grid">
    <?php
    // Fetch merch products
    $sql = "
    SELECT p.name
    FROM product p
    JOIN producttype pt ON p.productTypeID = pt.productTypeID
    WHERE pt.wearableID IS NOT NULL
  ";
  
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="card">';
        echo '<div class="card-img">🛍️</div>';
        echo '<p>' . htmlspecialchars($row['name']) . '</p>';
        echo '</div>';
      }
    } else {
      echo '<p>No merchandise available.</p>';
    }
    ?>
  </div>
</div>
