<?php
header('Content-Type: application/json');
include_once '../includes/dbh.php';

// Get token from headers
$data = json_decode(file_get_contents("php://input"), true);

// Accept token from body
$token = $data['token'] ?? null;

if (!$token) {
  http_response_code(401);
  echo json_encode(["message" => "Token required."]);
  exit();
}


if (!$token) {
  http_response_code(401);
  echo json_encode(["message" => "Token required."]);
  exit();
}

// Check if token exists
$userQuery = mysqli_query($conn, "SELECT userID FROM user WHERE token = '$token' LIMIT 1");
if (!$user = mysqli_fetch_assoc($userQuery)) {
  http_response_code(403);
  echo json_encode(["message" => "Invalid token."]);
  exit();
}

$userID = $user['userID'];
$data = json_decode(file_get_contents("php://input"), true);

$fields = [];
if (isset($data['username'])) $fields[] = "username = '" . mysqli_real_escape_string($conn, $data['username']) . "'";
if (isset($data['email']))    $fields[] = "email = '" . mysqli_real_escape_string($conn, $data['email']) . "'";
if (isset($data['pressingID'])) $fields[] = "pressingID = " . intval($data['pressingID']);
if (isset($data['countryID']))  $fields[] = "countryID = " . intval($data['countryID']);

if (empty($fields)) {
  http_response_code(400);
  echo json_encode(["message" => "No fields to update."]);
  exit();
}

$updateSql = "UPDATE user SET " . implode(', ', $fields) . " WHERE userID = $userID";
if (mysqli_query($conn, $updateSql)) {
  echo json_encode(["message" => "Profile updated successfully."]);
} else {
  http_response_code(500);
  echo json_encode(["message" => "Update failed.", "error" => mysqli_error($conn)]);
}
?>
