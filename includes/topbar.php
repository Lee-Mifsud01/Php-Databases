<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//  Get the access token 
$accessToken = "BQDoLpF49OjQ4I80i1tlOuvlDetNcRgYijlsUoPhDZRzuHdlNMjVS9Mnyr7nxZJ20zmAdVD2eZ-1RmkCD0rk8fKT4HxabtLheTkKH3OMYqTTTPsv5KaRLHN9iGhuJlEmLeW8wOUmBtvGIO2EB80HZAdFmjNw5OgcQCTbCvSROJBsbhRTIT4MV21eKQgKAsKg7ZiL-0pCVBEbIQ0IWyZpARkGW8Erz-uqrbwU9wuLcg3ElosWsh-UX6-Wd2I"; // Always replace with the currentaccess token

// Set up the Spotify API URL for the "currently playing" track
$url = "https://api.spotify.com/v1/me/player/currently-playing";

//  Make the API request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $accessToken"
]);

$response = curl_exec($ch);
curl_close($ch);

// Decode the response
$currentTrackData = json_decode($response, true);

//  Check if there's a track playing
if (isset($currentTrackData['item'])) {
    $trackName = $currentTrackData['item']['name'];
    $trackArtists = implode(', ', array_map(fn($artist) => $artist['name'], $currentTrackData['item']['artists']));
    $albumImage = $currentTrackData['item']['album']['images'][0]['url'];
} else {
    // No track is currently playing
    $trackName = null;
    $trackArtists = null;
    $albumImage = null;
}

include_once __DIR__ . '/functions.php';  // this file contains getCurrentlyPlaying() and ensureSpotifyToken()
include_once __DIR__ . '/dbh.php'; 

// Get the currently playing track from Spotify (or null if no track is playing)
$current = getCurrentlyPlaying();

// Avatar lookup: default then override if user has one
$userID    = $_SESSION['userID'] ?? null;
$avatarUrl = 'images/avatar-placeholder.jpg';

if ($userID) {
    $stmt = $conn->prepare("
        SELECT i.url
          FROM `user` AS u
          LEFT JOIN `image` AS i
            ON u.imageID = i.imageID
         WHERE u.userID = ?
           AND i.url IS NOT NULL
         LIMIT 1
    ");
    $stmt->bind_param('i', $userID);
    $stmt->execute();
    $stmt->bind_result($dbUrl);
    if ($stmt->fetch()) {
        $avatarUrl = $dbUrl;
    }
    $stmt->close();
}
?>

<div class="topbar">
  <!-- Left controls -->
  <div class="topbar-left">
   <!-- HTML -->
<button class="circle-btn" aria-label="Previous track">
  <img class="topbtns" src="images/previous-track.webp" alt="previous track icon">
</button>

<button class="circle-btn" aria-label="Play/Pause">
  <img class="topbtns" src="images/playicon.png" alt="play track icon">
</button>

<button class="circle-btn" aria-label="Next track">
  <img class="topbtns" src="images/next-track.png" alt="next track icon">
</button>
</div>

  <!-- currently playing -->
  <div class="track-display">
  <?php if ($trackName): ?>
    <h2>Currently Playing: <?= htmlspecialchars($trackName) ?></h2>
    
    <!--  album image links to spotify -->
    <a href="https://open.spotify.com/track/<?= htmlspecialchars($currentTrackData['item']['id']) ?>" target="_blank">
      <img src="<?= htmlspecialchars($albumImage) ?>" alt="Album Image" width="100">
    </a>
    
  <?php else: ?>
    <p>No track is currently playing.</p>
  <?php endif; ?>


  <!--volume + profile -->
  <div class="topbar-right">
    <input type="range" min="0" max="100" value="70" aria-label="Volume" id="slider">

    <div class="profile-dropdown" tabindex="0" aria-haspopup="true">
      <button class="circle-btn avatar-btn" aria-label="User menu">
        <img
          src="<?= htmlspecialchars($avatarUrl) ?>"
          alt="Avatar"
          class="avatar-img"
        >
      </button>
      <div class="dropdown-menu" role="menu">
        <?php if ($userID): ?>
          <a href="account.php"       role="menuitem">Account</a>
          <a href="profile.php"       role="menuitem">Profile</a>
          <a href="subscriptions.php" role="menuitem">Subscription</a>
          <a href="settings.php"      role="menuitem">Settings</a>
          <a href="includes/logout-inc.php" role="menuitem">Log Out</a>
        <?php else: ?>
          <a href="login.php"         role="menuitem">Login</a>
          <a href="register.php"      role="menuitem">Register</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
        </div>
