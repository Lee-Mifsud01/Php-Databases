<?php
header('Content-Type: application/json');
include_once '../includes/dbh.php';

$data = json_decode(file_get_contents("php://input"), true);
$token = $data['token'] ?? null;

if (!$token) {
  http_response_code(401);
  echo json_encode(["message" => "Token required."]);
  exit();
}

// Find user and check admin
$query = mysqli_query($conn, "SELECT isAdmin FROM user WHERE token = '$token' LIMIT 1");
$user = mysqli_fetch_assoc($query);

if (!$user || $user['isAdmin'] != 1) {
  http_response_code(403);
  echo json_encode(["message" => "Unauthorized. Admin access required."]);
  exit();
}

// Get all users
$result = mysqli_query($conn, "SELECT userID, username, email, pressingID, countryID FROM user");
$users = [];

while ($row = mysqli_fetch_assoc($result)) {
  $users[] = $row;
}

echo json_encode($users);
?>
