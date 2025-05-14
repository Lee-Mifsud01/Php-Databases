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

// Handle profile picture upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
  $file = $_FILES['avatar'];

  if ($file['error'] === 0 && in_array($file['type'], ['image/jpeg', 'image/png'])) {
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newFileName = uniqid("pfp_", true) . "." . $ext;
    $uploadPath = "uploads/" . $newFileName;

    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
      $stmt = $conn->prepare("SELECT u.imageID, i.url FROM user u LEFT JOIN image i ON u.imageID = i.imageID WHERE u.userID = ?");
      $stmt->bind_param("i", $userID);
      $stmt->execute();
      $stmt->bind_result($oldImageID, $oldUrl);
      $stmt->fetch();
      $stmt->close();

      $insert = $conn->prepare("INSERT INTO image (url) VALUES (?)");
      $insert->bind_param("s", $uploadPath);
      $insert->execute();
      $newImageID = $insert->insert_id;
      $insert->close();

      $update = $conn->prepare("UPDATE user SET imageID = ? WHERE userID = ?");
      $update->bind_param("ii", $newImageID, $userID);
      $update->execute();
      $update->close();

      if (!empty($oldUrl) && file_exists($oldUrl)) {
        unlink($oldUrl);
      }

      header("Location: profile.php?success=1");
      exit();
    }
  }
}

// Fetch user info with country and region
$userQuery = mysqli_query($conn, "
  SELECT u.username, u.email, c.name AS country, r.regionName AS region
  FROM user u
  LEFT JOIN country c ON u.countryID = c.countryID
  LEFT JOIN region r ON u.regionID = r.regionID
  WHERE u.userID = $userID
  LIMIT 1
");

$countryQuery = "SELECT countryID, name FROM country ORDER BY name ASC";
$countryResult = mysqli_query($conn, $countryQuery);

$regionQuery = "SELECT regionID, regionName FROM region ORDER BY regionName ASC";
$regionResult = mysqli_query($conn, $regionQuery);

if (!$userQuery || mysqli_num_rows($userQuery) === 0) {
  echo "<p>User not found.</p>";
  exit();
}

$user = mysqli_fetch_assoc($userQuery);
?>

<div class="indexpage">
  <section class="section">
    <h2>👤 Profile</h2>

    <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Country:</strong> <?= htmlspecialchars($user['country'] ?? 'N/A') ?></p>
    <p><strong>Region:</strong> <?= htmlspecialchars($user['region'] ?? 'N/A') ?></p>

    <form method="POST" action="includes/profile-inc.php">
      <select name="countryID" id="country">
        <option value="">-- Update Country --</option>
        <?php mysqli_data_seek($countryResult, 0); // Reset pointer ?>
        <?php while ($row = mysqli_fetch_assoc($countryResult)) : ?>
          <option value="<?= $row['countryID']; ?>"><?= htmlspecialchars($row['name']); ?></option>
        <?php endwhile; ?>
      </select>

      <select name="regionID" id="region">
        <option value="">-- Update Region --</option>
        <?php while ($row = mysqli_fetch_assoc($regionResult)) : ?>
          <option value="<?= $row['regionID']; ?>"><?= htmlspecialchars($row['regionName']); ?></option>
        <?php endwhile; ?>
      </select>

      <button type="submit">Update</button>
    </form>

    <h3>Change Profile Picture</h3>
    <form method="POST" enctype="multipart/form-data">
      <input type="file" name="avatar" accept="image/png, image/jpeg" required>
      <button type="submit">Upload</button>
    </form>

    <?php if (isset($_GET['success'])): ?>
      <p style="color: green;">Profile picture updated!</p>
    <?php endif; ?>
  </section>

  <section class="section">
    <h3>Badges</h3>
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

</body>
</html>
