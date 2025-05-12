<?php
session_start();
if (empty($_SESSION['userID'])) {
  header('Location: login.php');
  exit();
}

require_once __DIR__ . '/includes/dbh.php';
include  __DIR__ . '/includes/header.php';
include  __DIR__ . '/includes/topbar.php';

// 2) Pull username, email, and the country name
$sql = "
  SELECT
    u.username,
    u.email,
    COALESCE(c.name, 'N/A') AS country
  FROM `user` AS u
  LEFT JOIN `country` AS c
    ON u.countryID = c.countryID
  WHERE u.userID = ?
  LIMIT 1
";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $_SESSION['userID']);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows === 0) {
  echo '<p>User not found.</p>';
  exit();
}

$user = $result->fetch_assoc();
$stmt->close();
?>

<div class="homepage">
  <section class="section">
    <h2>👤 Account</h2>
    <div class="list">
      <div class="list-item">
        <strong>Username:</strong>
        <?= htmlspecialchars($user['username']) ?>
      </div>
      <div class="list-item">
        <strong>Email:</strong>
        <?= htmlspecialchars($user['email']) ?>
      </div>
      <div class="list-item">
        <strong>Country:</strong>
        <?= htmlspecialchars($user['country']) ?>
      </div>
    </div>
  </section>
</div>

</div><!-- .main-content -->
</div><!-- .wrapper -->
</body>
</html>
