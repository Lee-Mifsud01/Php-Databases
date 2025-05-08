<?php
header('Content-Type: application/json');
include_once '../includes/dbh.php';

$data = json_decode(file_get_contents("php://input"), true);

// Get token and required fields
$token = $data['token'] ?? null;
$currentPassword = $data['current_password'] ?? null;
$newPassword = $data['new_password'] ?? null;

if (!$token || !$currentPassword || !$newPassword) {
  http_response_code(400);
  echo json_encode(["message" => "Token, current_password, and new_password are required."]);
  exit();
}

// Authenticate via token
$query = mysqli_query($conn, "SELECT userID, password FROM user WHERE token = '$token' LIMIT 1");
if (!$user = mysqli_fetch_assoc($query)) {
  http_response_code(403);
  echo json_encode(["message" => "Invalid token."]);
  exit();
}

// Check current password
if ($currentPassword !== $user['password']) {
  http_response_code(401);
  echo json_encode(["message" => "Incorrect current password."]);
  exit();
}

// Update new password 
$update = mysqli_query($conn, "UPDATE user SET password = '$newPassword' WHERE userID = {$user['userID']}");

if ($update) {
  echo json_encode(["message" => "Password updated successfully."]);
} else {
  http_response_code(500);
  echo json_encode(["message" => "Password update failed."]);
}
?>
