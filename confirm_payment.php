<?php
//  PROCESS USER SUBSCRIPTION PAYMENT
session_start();

//  Check that the user is logged in and required POST data exists
if (empty($_SESSION['userID']) || !isset($_POST['subscriptionID'], $_POST['method'])) {
  header('Location: subscriptions.php?error=nopayment');
  exit();
}

include 'includes/dbh.php';

$userID = intval($_SESSION['userID']);
$subID = intval($_POST['subscriptionID']);
$method = mysqli_real_escape_string($conn, $_POST['method']);
$price = floatval($_POST['finalPrice']);
$currency = mysqli_real_escape_string($conn, $_POST['currency']);

// Insert payment log
$insertPayment = mysqli_prepare($conn, "
  INSERT INTO payments (userID, subscriptionID, amount, currency, method, paymentDate)
  VALUES (?, ?, ?, ?, ?, NOW())
");
mysqli_stmt_bind_param($insertPayment, "iidss", $userID, $subID, $price, $currency, $method);
mysqli_stmt_execute($insertPayment);

// Get the new payment ID
$paymentID = mysqli_insert_id($conn);

// Update subscription
$update = mysqli_prepare($conn, "UPDATE user SET subscriptionID = ? WHERE userID = ?");
mysqli_stmt_bind_param($update, "ii", $subID, $userID);
if (mysqli_stmt_execute($update)) {
  header("Location: payment_receipt.php?id=$paymentID");
  exit();
} else {
  header("Location: subscriptions.php?error=updatefail");
  exit();
}
?>
