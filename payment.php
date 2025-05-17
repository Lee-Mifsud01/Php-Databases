<?php
// Payment Plan Confirmation
session_start();
// Ensure user is logged in and selected a plan
if (empty($_SESSION['userID']) || !isset($_POST['subscriptionID'])) {
  header('Location: subscriptions.php?error=noplan');
  exit();
}

include 'includes/dbh.php';

//Retrieve user and selected plan info
$userID = intval($_SESSION['userID']);
$subID = intval($_POST['subscriptionID']);

// Get user's country
$userQuery = mysqli_query($conn, "SELECT country FROM user WHERE userID = $userID");
$user = mysqli_fetch_assoc($userQuery);
$country = $user['country'] ?? 'MT';

// Get subscription details
$subQuery = mysqli_query($conn, "SELECT name, price, description FROM subscription WHERE subscriptionID = $subID");
$sub = mysqli_fetch_assoc($subQuery);

// Exit if subscription ID is invalid
if (!$sub) {
  echo "Invalid subscription ID.";
  exit();
}

// Currency symbol + conversion
$currency = match ($country) {
  'US' => '$',
  'GB' => '£',
  default => '€',
};

// Convert base price to local currency
$convertedPrice = match ($country) {
  'US' => round($sub['price'] * 1.08, 2), // USD conversion
  'GB' => round($sub['price'] * 0.86, 2), // GBP conversion
  default => $sub['price'], // EUR or others
};
?>

<!--  Payment UI (HTML Section) -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="login-body">
  <div class="login-container">
    <h2>Confirm Your Plan</h2>
    <!-- Display selected subscription details -->
    <p><strong><?= htmlspecialchars($sub['name']) ?></strong></p>
    <p><?= htmlspecialchars($sub['description']) ?></p>
    <p><strong>Price:</strong> <?= $currency . number_format($convertedPrice, 2) ?></p>

    <!-- Submit payment form -->
    <form method="POST" action="confirm_payment.php">
      <input type="hidden" name="subscriptionID" value="<?= $subID ?>">
      <input type="hidden" name="finalPrice" value="<?= $convertedPrice ?>">
      <input type="hidden" name="currency" value="<?= $currency ?>">

      <label for="method">Payment Method:</label>
      <select name="method" required>
        <option value="credit">Credit Card</option>
        <option value="paypal">PayPal</option>
        <option value="apple">Apple Pay</option>
      </select>

      <button type="submit">Pay Now</button>
    </form>

    <a href="subscriptions.php">← Back to Subscriptions</a>
  </div>
</body>
</html>
