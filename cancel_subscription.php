<?php
session_start();
if (empty($_SESSION['userID'])) {
  header('Location: login.php');
  exit();
}

include 'includes/dbh.php';

$userID = intval($_SESSION['userID']);
$cancel = mysqli_prepare($conn, "UPDATE user SET subscriptionID = NULL WHERE userID = ?");
mysqli_stmt_bind_param($cancel, "i", $userID);

if (mysqli_stmt_execute($cancel)) {
  header("Location: subscriptions.php?success=cancelled");
  exit();
} else {
  header("Location: subscriptions.php?error=cancelfail");
  exit();
}
?>
