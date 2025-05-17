<?php
// Cancel User's Subscription Script
session_start();
// Ensure user is logged in
if (empty($_SESSION['userID'])) {
  header('Location: login.php');
  exit();
}

include 'includes/dbh.php';

// Get current user's ID
$userID = intval($_SESSION['userID']);
$cancel = mysqli_prepare($conn, "UPDATE user SET subscriptionID = NULL WHERE userID = ?");
mysqli_stmt_bind_param($cancel, "i", $userID);

// Attempt to execute cancellation
if (mysqli_stmt_execute($cancel)) {
  // If successful, redirect with a success message
  header("Location: subscriptions.php?success=cancelled");
  exit();
} else {
  // If something goes wrong, redirect with error
  header("Location: subscriptions.php?error=cancelfail");
  exit();
}
?>
