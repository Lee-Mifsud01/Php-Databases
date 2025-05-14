<?php
session_start();
include 'includes/dbh.php';
include 'includes/header.php';
include 'includes/topbar.php';

// Step 1: Get artist ID from URL
$artistID = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Step 2: Get artist name from your local DB
$artistQuery = mysqli_query($conn, "SELECT name FROM artist WHERE artistID = $artistID LIMIT 1");
$artistRow = mysqli_fetch_assoc($artistQuery);
$localArtistName = $artistRow['name'] ?? null;

$spotifyArtist = null;

// Step 3: If we have a local artist, use Spotify API
if ($localArtistName) {
    $accessToken = "BQB3l98QkIdPKn07ITuitBFbk7Rq_17XPPQ89sWM7OcXlIAIGj1oK0cxaXtAXFgxly734B6jXScuulZhvhY0BL-Rho9Swtedn8qKtDoFerqD2j3RwYaVTgziOhXDkYRTHh0lAHaPwwl1dLVBGHZ1NY_6RKNSO7Rp_9q4Gw4ktmg7lUuOBkVolge6L0SOZjRDIXJwIm7shEQCq8SXsIMw2yAp1jZTyAuCfUEeVZpuGyWF-FLy5CsvHjoTuu8"; // Replace with fresh token
    $query = urlencode($localArtistName);
    $url = "https://api.spotify.com/v1/search?q={$query}&type=artist&limit=1";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $accessToken"
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $spotifyData = json_decode($response, true);
    $spotifyArtist = $spotifyData['artists']['items'][0] ?? null;
}
?>

<div class="main-content">
  <?php if ($localArtistName): ?>
    <h2><?= htmlspecialchars($localArtistName) ?></h2>

    <?php if ($spotifyArtist): ?>
      <img src="<?= $spotifyArtist['images'][0]['url'] ?>" alt="Artist Image" width="300">
      <p><strong>Genres:</strong> <?= implode(', ', $spotifyArtist['genres']) ?></p>
      <p><strong>Followers:</strong> <?= number_format($spotifyArtist['followers']['total']) ?></p>
      <p><a href="<?= $spotifyArtist['external_urls']['spotify'] ?>" target="_blank">View on Spotify</a></p>
    <?php else: ?>
      <p>Spotify data not available.</p>
    <?php endif; ?>

    <hr>
    <h3>Merchandise</h3>
    <div class="grid">
      <?php
      $sql = "
        SELECT 
          p.productID, p.name, p.price, p.description,
          w.material AS wearableMaterial, w.size AS wearableSize,
          v.size AS vinylSize, v.edition AS vinylEdition,
          c.size AS cdSize, c.edition AS cdEdition,
          o.size AS otherSize, o.material AS otherMaterial, o.edition AS otherEdition
        FROM product p
        JOIN producttype pt ON p.productTypeID = pt.productTypeID
        LEFT JOIN wearable w ON pt.wearableID = w.wearableID
        LEFT JOIN vinyl v ON pt.vinylID = v.vinylID
        LEFT JOIN cd c ON pt.cdID = c.cdID
        LEFT JOIN otherproduct o ON pt.otherProductID = o.otherProductID
        WHERE p.artistID = $artistID
      ";

      $result = mysqli_query($conn, $sql);

      if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<div class="card">';
          echo '<div class="card-img">🛍️</div>';
          echo '<h4>' . htmlspecialchars($row['name'] ?? 'Unnamed Product') . '</h4>';
          echo '<p><strong>$' . number_format($row['price'], 2) . '</strong></p>';
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
        echo '<p>No merchandise found for this artist.</p>';
      }
      ?>
    </div>
  <?php else: ?>
    <p>Artist not found.</p>
  <?php endif; ?>
</div>
</body>
</html>
