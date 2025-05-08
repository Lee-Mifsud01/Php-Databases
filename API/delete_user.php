<?php
header('Content-Type: application/json');
include_once '../includes/dbh.php';

$data = json_decode(file_get_contents("php://input"), true);

// Get token from body
$token = $data['token'] ?? null;

if (!$token) {
  http_response_code(401);
  echo json_encode(["message" => "Token required."]);
  exit();
}

// Find the user by token
$userQuery = mysqli_query($conn, "SELECT userID FROM user WHERE token = '$token' LIMIT 1");
if (!$user = mysqli_fetch_assoc($userQuery)) {
  http_response_code(403);
  echo json_encode(["message" => "Invalid token."]);
  exit();
}

$userID = $user['userID'];

// Delete the user
$delete = mysqli_query($conn, "DELETE FROM user WHERE userID = $userID");

if ($delete) {
  echo json_encode(["message" => "User deleted successfully."]);
} else {
  http_response_code(500);
  echo json_encode(["message" => "Failed to delete user."]);
}
?>
