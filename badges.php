<?php
include 'includes/dbh.php';
include 'includes/header.php';
include 'includes/topbar.php';
?>

<div class="main-content">
  <h1>Album Badges</h1>
  <div class="badge-grid">
    <?php
    $sql = "
      SELECT ab.pressingID, a.title AS album_title, ar.name AS artist_name
      FROM albumbadge ab
      JOIN album a ON ab.albumID = a.albumID
      JOIN artist ar ON a.artistID = ar.artistID
    ";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="badge-card">';
        echo '<div class="badge-cover">ALBUM COVER WHICH THE BADGE IS FOR</div>';
        echo '<div class="badge-info">';
        echo '<p><strong>Badge Number</strong> ' . $row['pressingID'] . '</p>';
        echo '<p><strong>Album:</strong> ' . htmlspecialchars($row['album_title']) . '</p>';
        echo '<p><strong>Artist:</strong> ' . htmlspecialchars($row['artist_name']) . '</p>';
        echo '</div>';
        echo '</div>';
      }
    } else {
      echo '<p>No album badges found.</p>';
    }
    ?>
  </div>
</div>
</div>
