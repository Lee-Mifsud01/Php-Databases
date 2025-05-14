<?php
session_start();

if (empty($_SESSION['userID'])) {
  header('Location: login.php');
  exit();
}

include 'includes/dbh.php';

$userID = intval($_SESSION['userID']);
$newSubID = isset($_POST['subscriptionID']) ? intval($_POST['subscriptionID']) : 0;

if ($newSubID === 0) {
  header('Location: subscriptions.php?error=invalid');
  exit();
}

$checkSub = mysqli_query($conn, "SELECT subscriptionID FROM subscription WHERE subscriptionID = $newSubID");
if (mysqli_num_rows($checkSub) === 0) {
  header('Location: subscriptions.php?error=notfound');
  exit();
}

$updateQuery = "UPDATE user SET subscriptionID = $newSubID WHERE userID = $userID";
if (mysqli_query($conn, $updateQuery)) {
  header('Location: subscriptions.php?success=1');
  exit();
} else {
  header('Location: subscriptions.php?error=updatefail');
  exit();
}
?>
