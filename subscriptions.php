<?php
session_start();
if (empty($_SESSION['userID'])) {
  header('Location: login.php');
  exit();
}

include 'includes/dbh.php';
include 'includes/header.php';
include 'includes/topbar.php';

$userID = $_SESSION['userID'];

// Get current subscription ID
$userSubQuery = mysqli_query($conn, "SELECT subscriptionID FROM user WHERE userID = $userID");
$userSubRow = mysqli_fetch_assoc($userSubQuery);
$currentSubID = $userSubRow ? $userSubRow['subscriptionID'] : null;

// Get all subscriptions
$subsQuery = mysqli_query($conn, "SELECT subscriptionID, name, price, description, subscriptionType FROM subscription");
?>

<div class="indexpage">
  <section class="section">
    <h2>Subscriptions</h2>

    <?php
    if (isset($_GET['success'])) {
      if ($_GET['success'] == 1) {
        echo '<div class="alert success"> Subscription updated successfully.</div>';
      } elseif ($_GET['success'] == 'cancelled') {
        echo '<div class="alert success"> Subscription cancelled.</div>';
      }
    } elseif (isset($_GET['error'])) {
      echo '<div class="alert error"> Something went wrong. Please try again.</div>';
    }
    ?>

    <div class="grid">
      <?php
      if (mysqli_num_rows($subsQuery) > 0) {
        while ($sub = mysqli_fetch_assoc($subsQuery)) {
          $isCurrent = ($sub['subscriptionID'] == $currentSubID);
          echo '<div class="card">';
          echo '<h3>' . htmlspecialchars($sub['name']) . '</h3>';
          echo '<p><strong>Price:</strong> €' . number_format($sub['price'], 2) . '</p>';
          echo '<p><strong>Type:</strong> ' . htmlspecialchars($sub['subscriptionType']) . '</p>';
          echo '<p>' . nl2br(htmlspecialchars($sub['description'])) . '</p>';

          if ($isCurrent) {
            echo '<button class="current-btn" disabled>✔ Active Plan</button>';
            echo '<form method="POST" action="cancel_subscription.php">';
            echo '<button type="submit" class="cancel-btn">Cancel</button>';
            echo '</form>';
          } else {
            echo '<form method="POST" action="purchase_subscription.php">';
            echo '<input type="hidden" name="subscriptionID" value="' . htmlspecialchars($sub['subscriptionID']) . '">';
            echo '<button type="submit" class="purchase-btn">Purchase</button>';
            echo '</form>';
          }

          echo '</div>';
        }
      } else {
        echo "<p>No subscriptions available.</p>";
      }
      ?>
    </div>
  </section>
</div>

</body>
</html>
