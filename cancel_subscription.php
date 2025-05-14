<?php
session_start();

if (empty($_SESSION['userID'])) {
  header('Location: login.php');
  exit();
}

include 'includes/dbh.php';

$userID = intval($_SESSION['userID']);

$cancelQuery = "UPDATE user SET subscriptionID = NULL WHERE userID = $userID";

if (mysqli_query($conn, $cancelQuery)) {
  header('Location: subscriptions.php?success=cancelled');
  exit();
} else {
  header('Location: subscriptions.php?error=cancelfail');
  exit();
}
?>
