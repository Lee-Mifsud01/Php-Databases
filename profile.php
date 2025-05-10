<?php
session_start();

if (!isset($_SESSION['userID'])) {
  header("Location: login.php");
  exit();
}

include 'includes/dbh.php';
include 'includes/header.php';
include 'includes/topbar.php';

$userID = $_SESSION['userID'];

// Get user details (username, email, country name)
$userQuery = mysqli_query($conn, "
  SELECT u.username, u.email, c.name AS country
  FROM user u
  LEFT JOIN country c ON u.countryID = c.countryID
  WHERE u.userID = $userID
  LIMIT 1
");

if (!$userQuery || mysqli_num_rows($userQuery) === 0) {
  echo "<p>User not found.</p>";
  exit();
}

$user = mysqli_fetch_assoc($userQuery);
?>

<div class="homepage">
  <section class="section">
    <h2>👤 Profile</h2>
    <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>Country:</strong> <?php echo htmlspecialchars($user['country'] ?? 'N/A'); ?></p>
  </section>

  <section class="section">
    <h3>🏅 Badges</h3>
    <?php
    $badgeQuery = mysqli_query($conn, "
      SELECT ab.pressingID, a.title AS album_title
      FROM albumbadge ab
      JOIN album a ON ab.albumID = a.albumID
      WHERE ab.userID = $userID
    ");

    if (mysqli_num_rows($badgeQuery) > 0) {
      echo "<ul>";
      while ($badge = mysqli_fetch_assoc($badgeQuery)) {
        echo "<li>🏅 Badge " . htmlspecialchars($badge['pressingID']) . " — from album <strong>" . htmlspecialchars($badge['album_title']) . "</strong></li>";
      }
      echo "</ul>";
    } else {
      echo "<p>No badges earned yet.</p>";
    }
    ?>
  </section>
</div>

</div> 
</div> 
</body>
</html>
