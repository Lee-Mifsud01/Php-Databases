<?php
session_start();
if (empty($_SESSION['userID'])) {
  header('Location: login.php');
  exit();
}

include 'includes/dbh.php';
include 'includes/header.php';
include 'includes/topbar.php';

// Get selected artist from query string
$artistID = isset($_GET['artist']) ? intval($_GET['artist']) : 0;

// Fetch all artists for the dropdown
$artistOptions = mysqli_query($conn, "SELECT artistID, name FROM artist ORDER BY name");
?>
<link rel="stylesheet" href="style.css">

<div class="main-content">
  <h2>All Merchandise</h2>

  <!-- Filter Dropdown -->
  <form method="GET" action="">
    <label for="artist">Filter by Artist:</label>
    <select name="artist" id="artist" onchange="this.form.submit()">
      <option value="0">-- All Artists --</option>
      <?php while ($artist = mysqli_fetch_assoc($artistOptions)): ?>
        <option value="<?= $artist['artistID'] ?>" <?= ($artistID == $artist['artistID']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($artist['name']) ?>
        </option>
      <?php endwhile; ?>
    </select>
  </form>

  <div class="grid">
    <?php
    $sql = "
      SELECT 
        p.productID, p.name, p.price, p.description,
        a.name AS artistName,
        w.material AS wearableMaterial, w.size AS wearableSize,
        v.size AS vinylSize, v.edition AS vinylEdition,
        c.size AS cdSize, c.edition AS cdEdition,
        o.size AS otherSize, o.material AS otherMaterial, o.edition AS otherEdition
      FROM product p
      JOIN artist a ON p.artistID = a.artistID
      JOIN producttype pt ON p.productTypeID = pt.productTypeID
      LEFT JOIN wearable w ON pt.wearableID = w.wearableID
      LEFT JOIN vinyl v ON pt.vinylID = v.vinylID
      LEFT JOIN cd c ON pt.cdID = c.cdID
      LEFT JOIN otherproduct o ON pt.otherProductID = o.otherProductID
    ";

    if ($artistID > 0) {
      $sql .= " WHERE p.artistID = $artistID";
    }

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="card">';
        echo '<div class="card-img">🛍️</div>';
        echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
        echo '<p><strong>Artist:</strong> ' . htmlspecialchars($row['artistName']) . '</p>';
        echo '<p><strong>Price:</strong> $' . number_format($row['price'], 2) . '</p>';
        echo '<p>' . nl2br(htmlspecialchars($row['description'] ?? '')) . '</p>';

        // Wearable
        if (!empty($row['wearableMaterial']) || !empty($row['wearableSize'])) {
          echo '<p><strong>Material:</strong> ' . htmlspecialchars($row['wearableMaterial']) . '</p>';
          echo '<p><strong>Size:</strong> ' . htmlspecialchars($row['wearableSize']) . '</p>';
        }

        // Vinyl
        if (!empty($row['vinylSize']) || !empty($row['vinylEdition'])) {
          echo '<p><strong>Vinyl Size:</strong> ' . htmlspecialchars($row['vinylSize']) . '</p>';
          echo '<p><strong>Edition:</strong> ' . htmlspecialchars($row['vinylEdition']) . '</p>';
        }

        // CD
        if (!empty($row['cdSize']) || !empty($row['cdEdition'])) {
          echo '<p><strong>CD Size:</strong> ' . htmlspecialchars($row['cdSize']) . '</p>';
          echo '<p><strong>Edition:</strong> ' . htmlspecialchars($row['cdEdition']) . '</p>';
        }

        // Other Product
        if (!empty($row['otherMaterial']) || !empty($row['otherSize']) || !empty($row['otherEdition'])) {
          echo '<p><strong>Material:</strong> ' . htmlspecialchars($row['otherMaterial']) . '</p>';
          echo '<p><strong>Size:</strong> ' . htmlspecialchars($row['otherSize']) . '</p>';
          echo '<p><strong>Edition:</strong> ' . htmlspecialchars($row['otherEdition']) . '</p>';
        }

        echo '<div class="card-buttons">';
        echo '<a href="#" class="purchase-btn">Buy</a>';
        echo '<a href="product.php?id=' . $row['productID'] . '" class="btn-more">More Info</a>';
        echo '</div>';
        echo '</div>'; // end card
      }
    } else {
      echo '<p>No merchandise found.</p>';
    }
    ?>
  </div>
</div>

</body>
</html>
