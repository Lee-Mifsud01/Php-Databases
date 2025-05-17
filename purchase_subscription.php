<?php
// Session & Security Handling
session_start();

// Redirect user to login if not authenticated
if (empty($_SESSION['userID'])) {
  header('Location: login.php');
  exit();
}

include 'includes/dbh.php';

// Get current user ID from session
$userID = intval($_SESSION['userID']);
// Get new subscription ID from POST request
$newSubID = isset($_POST['subscriptionID']) ? intval($_POST['subscriptionID']) : 0;

if ($newSubID === 0) {
  // If no subscription selected or invalid input, redirect
  header('Location: subscriptions.php?error=invalid');
  exit();
}

// Check if the selected subscription exists
$checkSub = mysqli_query($conn, "SELECT subscriptionID FROM subscription WHERE subscriptionID = $newSubID");
if (mysqli_num_rows($checkSub) === 0) {
  // If no subscription found with this ID, redirect with error
  header('Location: subscriptions.php?error=notfound');
  exit();
}

//  Perform the update
$updateQuery = "UPDATE user SET subscriptionID = $newSubID WHERE userID = $userID";
// Run update query and redirect based on result
if (mysqli_query($conn, $updateQuery)) {
  // Success: show confirmation
  header('Location: subscriptions.php?success=1');
  exit();
} else {
  // Failure: show failure
  header('Location: subscriptions.php?error=updatefail');
  exit();
}
?>
