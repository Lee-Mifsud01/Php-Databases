<?php
header('Content-Type: application/json');
include_once '../includes/dbh.php';

$userID = isset($_GET['userID']) ? intval($_GET['userID']) : 0;

if ($userID <= 0) {
  http_response_code(400);
  echo json_encode(["message" => "Valid userID is required."]);
  exit();
}

$sql = "SELECT username, email, pressingID, countryID FROM user WHERE userID = $userID LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
  echo json_encode($row);
} else {
  http_response_code(404);
  echo json_encode(["message" => "User not found."]);
}
?>
