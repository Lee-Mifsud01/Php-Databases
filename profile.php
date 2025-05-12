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

// Fetch all countries from the 'country' table
$countryQuery = "SELECT countryID, name FROM country ORDER BY name ASC";
$countryResult = mysqli_query($conn, $countryQuery);

// Check if the user data query was successful and returned a user
if (!$userQuery || mysqli_num_rows($userQuery) === 0) {
  echo "<p>User not found.</p>";
  exit();
}

// Fetch the user data as an associative array
$user = mysqli_fetch_assoc($userQuery);
?>

<div class="indexpage">
<!-- Profile Section -->
  <section class="section">
    <h2>👤 Profile</h2>

    <!-- Display basic user details -->
    <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>Country:</strong> <?php echo htmlspecialchars($user['country'] ?? 'N/A'); ?></p>

    <!-- Country update form -->
    <form method="POST" action="includes/profile-inc.php">
      <select name="countryID" id="country">
        <option value="">-- Update Country --</option>

        <!-- Loop through all countries and place them in the dropdown list -->
        <?php while ($row = mysqli_fetch_assoc($countryResult)) : ?>
          <option value="<?= $row['countryID']; ?>"
            <?= (isset($user['countryID']) && $user['countryID'] == $row['countryID']) ? 'selected' : ''; ?>>
            <?= htmlspecialchars($row['name']); ?>
          </option>
        <?php endwhile; ?>
      </select>
      <button type="submit">Update</button>
    </form>
  </section>

  <!-- Badges Section -->
  <section class="section">
    <h3>🏅 Badges</h3>
    <?php
    // Get all badges earned by user
    $badgeQuery = mysqli_query($conn, "
      SELECT ab.pressingID, a.title AS album_title
      FROM albumbadge ab
      JOIN album a ON ab.albumID = a.albumID
      WHERE ab.userID = $userID
    ");

    // If user has badges they are listed
    if (mysqli_num_rows($badgeQuery) > 0) {
      echo "<ul>";
      while ($badge = mysqli_fetch_assoc($badgeQuery)) {
        echo "<li>🏅 Badge " . htmlspecialchars($badge['pressingID']) . " — from album <strong>" . htmlspecialchars($badge['album_title']) . "</strong></li>";
      }
      echo "</ul>";
    } else {
      // If no badges are earned
      echo "<p>No badges earned yet.</p>";
    }
    ?>
  </section>
</div>

</body>
</html>
