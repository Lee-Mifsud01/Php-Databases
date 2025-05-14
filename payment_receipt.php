<?php
session_start();
if (empty($_SESSION['userID'])) {
  header('Location: login.php');
  exit();
}

include 'includes/dbh.php';

$userID = $_SESSION['userID'];

// Get latest payment for user
$receiptQuery = mysqli_query($conn, "
  SELECT p.*, s.name AS planName, s.description 
  FROM payments p
  JOIN subscription s ON s.subscriptionID = p.subscriptionID
  WHERE p.userID = $userID
  ORDER BY p.paymentDate DESC
  LIMIT 1
");

if (!$receiptQuery || mysqli_num_rows($receiptQuery) === 0) {
  echo "No recent payments found.";
  exit();
}

$receipt = mysqli_fetch_assoc($receiptQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment Receipt</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="login-body">
  <div class="login-container">
    <h2>Payment Receipt</h2>
    <p><strong>Plan:</strong> <?= htmlspecialchars($receipt['planName']) ?></p>
    <p><strong>Description:</strong> <?= htmlspecialchars($receipt['description']) ?></p>
    <p><strong>Amount Paid:</strong> <?= htmlspecialchars($receipt['currency']) . number_format($receipt['amount'], 2) ?></p>
    <p><strong>Payment Method:</strong> <?= ucfirst(htmlspecialchars($receipt['method'])) ?></p>
    <p><strong>Date:</strong> <?= date('Y-m-d H:i:s', strtotime($receipt['paymentDate'])) ?></p>
    <p><strong>Transaction ID:</strong> <?= str_pad($receipt['paymentID'], 8, '0', STR_PAD_LEFT) ?></p>

    <a href="subscriptions.php">← Back to Subscriptions</a>
  </div>
</body>
</html>
