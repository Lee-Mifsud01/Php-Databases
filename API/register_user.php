<?php
header('Content-Type: application/json');
include_once '../includes/dbh.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(["message" => "Only POST method allowed."]);
  exit();
}

$data = json_decode(file_get_contents("php://input"), true);

// Required fields
if (!isset($data['userID'], $data['username'], $data['email'], $data['password'])) {
  http_response_code(400);
  echo json_encode(["message" => "userID, username, email, and password are required."]);
  exit();
}

$userID = intval($data['userID']);
$username = mysqli_real_escape_string($conn, $data['username']);
$email = mysqli_real_escape_string($conn, $data['email']);
$password = mysqli_real_escape_string($conn, $data['password']); 
$pressingID = isset($data['pressingID']) ? intval($data['pressingID']) : "NULL";
$countryID = isset($data['countryID']) ? intval($data['countryID']) : "NULL";

// Check if user or email already exists
$check = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' OR email = '$email'");
if (mysqli_num_rows($check) > 0) {
  http_response_code(409); // Conflict
  echo json_encode(["message" => "Username or email already exists."]);
  exit();
}

// Insert user
$sql = "INSERT INTO user (userID, username, email, password, pressingID, countryID)
        VALUES ($userID, '$username', '$email', '$password', $pressingID, $countryID)";

if (mysqli_query($conn, $sql)) {
  echo json_encode([
    "message" => "User registered successfully.",
    "userID" => $userID
  ]);
} else {
  http_response_code(500);
  echo json_encode(["message" => "Registration failed.", "error" => mysqli_error($conn)]);
}
?>
