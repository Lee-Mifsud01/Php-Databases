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
    $accessToken = "BQCgvghutlLbKEwFg9fYa7BsIwJkjKfDsxV1bMxowvwhNC_cCA90tbfKqB0YResQx1ZbHT2GCRgt48ogqKqGddGbwOlnafrDS22MOBs7FM_UUQNsmCmPqmuXhi2gT8Q3xwuLAjIK7IK5aEQ73l5nwfpc-XCI-4csQye4_KOK-1Y9d8YwmQdAMCmjVn4YwalJ3Mb30qnIME3HXhxpeRc2zW2DeMAFMKdGtkeHtVSQHiHfJHbULs_og5l2wog";// Replace this with your valid token

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

  <?php else: ?>
    <p>Artist not found.</p>
  <?php endif; ?>
</div>

</div> 
</div> 
</body>
</html>
