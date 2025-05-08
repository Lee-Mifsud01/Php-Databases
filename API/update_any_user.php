<?php
header('Content-Type: application/json');
include_once '../includes/dbh.php';

$data = json_decode(file_get_contents("php://input"), true);

$token = $data['token'] ?? null;
$userID = $data['userID'] ?? null;

if (!$token || !$userID) {
  http_response_code(400);
  echo json_encode(["message" => "Token and userID are required."]);
  exit();
}

// Verify token belongs to an admin
$adminQuery = mysqli_query($conn, "SELECT isAdmin FROM user WHERE token = '$token' LIMIT 1");
$admin = mysqli_fetch_assoc($adminQuery);

if (!$admin || $admin['isAdmin'] != 1) {
  http_response_code(403);
  echo json_encode(["message" => "Unauthorized. Admin access required."]);
  exit();
}

// Build the update query
$fields = [];
if (isset($data['username'])) $fields[] = "username = '" . mysqli_real_escape_string($conn, $data['username']) . "'";
if (isset($data['email'])) $fields[] = "email = '" . mysqli_real_escape_string($conn, $data['email']) . "'";
if (isset($data['pressingID'])) $fields[] = "pressingID = " . intval($data['pressingID']);
if (isset($data['countryID']))  $fields[] = "countryID = " . intval($data['countryID']);
if (isset($data['isAdmin']))    $fields[] = "isAdmin = " . intval($data['isAdmin']);

if (empty($fields)) {
  http_response_code(400);
  echo json_encode(["message" => "No update fields provided."]);
  exit();
}

$sql = "UPDATE user SET " . implode(', ', $fields) . " WHERE userID = " . intval($userID);
$update = mysqli_query($conn, $sql);

if ($update) {
  echo json_encode(["message" => "User updated successfully."]);
} else {
  http_response_code(500);
  echo json_encode(["message" => "User update failed."]);
}
?>
