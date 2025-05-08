<?php
header('Content-Type: application/json');
include_once '../includes/dbh.php';

$data = json_decode(file_get_contents("php://input"), true);

$token = $data['token'] ?? null;
$userIDToDelete = $data['userID'] ?? null;

if (!$token || !$userIDToDelete) {
  http_response_code(400);
  echo json_encode(["message" => "Token and userID are required."]);
  exit();
}

// Check if token belongs to an admin
$query = mysqli_query($conn, "SELECT isAdmin FROM user WHERE token = '$token' LIMIT 1");
$user = mysqli_fetch_assoc($query);

if (!$user || $user['isAdmin'] != 1) {
  http_response_code(403);
  echo json_encode(["message" => "Unauthorized. Admin access required."]);
  exit();
}

// Prevent admin from deleting themselves
$selfCheck = mysqli_query($conn, "SELECT userID FROM user WHERE token = '$token'");
$self = mysqli_fetch_assoc($selfCheck);
if ($self && $self['userID'] == $userIDToDelete) {
  http_response_code(403);
  echo json_encode(["message" => "Admins cannot delete their own account."]);
  exit();
}

// Delete user
$delete = mysqli_query($conn, "DELETE FROM user WHERE userID = $userIDToDelete");

if ($delete) {
  echo json_encode(["message" => "User deleted successfully."]);
} else {
  http_response_code(500);
  echo json_encode(["message" => "Failed to delete user."]);
}
?>
