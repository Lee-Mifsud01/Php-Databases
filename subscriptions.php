<?php
session_start();

include 'includes/dbh.php';
include 'includes/header.php';
include 'includes/topbar.php';

$userID = $_SESSION['userID'];

// Get the user's current subscription ID
$userSubQuery = mysqli_query($conn, "SELECT subscriptionID FROM user WHERE userID = $userID");
$userSubRow = mysqli_fetch_assoc($userSubQuery);
$currentSubID = $userSubRow ? $userSubRow['subscriptionID'] : null;

// Fetch all available subscriptions
$subsQuery = mysqli_query($conn, "SELECT subscriptionID, name, description FROM subscription");
?>

<div class="indexpage">
  <section class="section">
    <h2>Subscriptions</h2>
    <div class="grid">
      <?php
      if (mysqli_num_rows($subsQuery) > 0) {
        while ($sub = mysqli_fetch_assoc($subsQuery)) {
          $isCurrent = ($sub['subscriptionID'] == $currentSubID);
          echo '<div class="card">';
          echo '<h3>' . htmlspecialchars($sub['name']) . '</h3>';
          echo '<p>' . nl2br(htmlspecialchars($sub['description'])) . '</p>';
          echo '<button class="' . ($isCurrent ? 'current-btn' : 'purchase-btn') . '">';
          echo $isCurrent ? 'Current' : 'Purchase';
          echo '</button>';
          echo '</div>';
        }
      } else {
        echo "<p>No subscriptions found.</p>";
      }
      ?>
    </div>
  </section>
</div>

</div> 
</div> 
</body>
</html>
