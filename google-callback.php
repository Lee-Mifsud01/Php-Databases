<?php
session_start();
if (empty($_SESSION['userID'])) {
  header('Location: login.php');
  exit();
}

// 1) Autoload and load .env
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// 2) Include your DB connection
include __DIR__ . '/includes/dbh.php';

// 3) Configure Google Client
$client = new Google\Client();
$client->setClientId(   getenv('GOOGLE_CLIENT_ID')    );
$client->setClientSecret(getenv('GOOGLE_CLIENT_SECRET'));
$client->setRedirectUri('http://localhost:8888/php-databases/google-callback.php');
$client->addScope('email');
$client->addScope('profile');

// 4) If no code, redirect to login
if (!isset($_GET['code'])) {
    header('Location: login.php');
    exit;
}

// 5) Exchange code for token
$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
if (isset($token['error'])) {
    exit('OAuth Error: ' . htmlspecialchars($token['error_description']));
}
$client->setAccessToken($token['access_token']);

// 6) Fetch user info
$oauth2 = new Google\Service\Oauth2($client);
$userInfo = $oauth2->userinfo->get();

// 7) Check if this googleID exists
$stmt = $conn->prepare("SELECT userID FROM `user` WHERE googleID = ?");
$stmt->bind_param('s', $userInfo->id);
$stmt->execute();
$stmt->bind_result($userID);
$found = $stmt->fetch();
$stmt->close();

if ($found) {
    // 8a) Existing user: log them in
    $_SESSION['userID'] = $userID;
} else {
    // 8b) New user: insert into DB
    $insert = $conn->prepare("
        INSERT INTO `user` (username, email, googleID, countryID, pressingID)
        VALUES (?, ?, ?, 1, 1)
    ");
    $insert->bind_param(
        'sss',
        $userInfo->name,
        $userInfo->email,
        $userInfo->id
    );
    $insert->execute();
    $_SESSION['userID'] = $insert->insert_id;
    $insert->close();
}

// 9) Redirect back to your indexpage (or account page)
header('Location: index.php');
exit;
