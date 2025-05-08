<?php
header('Content-Type: application/json');
$headers = getallheaders();
$token = isset($headers['Authorization']) ? $headers['Authorization'] : '';
include_once '../includes/dbh.php';

// Read token from header
$headers = getallheaders();
$token = isset($headers['Authorization']) ? $headers['Authorization'] : '';

if (!$token) {
  http_response_code(401);
  echo json_encode(["message" => "Token required."]);
  exit();
}

// Find user by token
$sql = "UPDATE user SET token = NULL WHERE token = '$token'";
$result = mysqli_query($conn, $sql);

if (mysqli_affected_rows($conn) > 0) {
  echo json_encode(["message" => "Logout successful."]);
} else {
  http_response_code(403);
  echo json_encode(["message" => "Invalid token or already logged out."]);
}
?>
