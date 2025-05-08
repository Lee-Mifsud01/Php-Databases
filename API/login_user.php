<?php
header('Content-Type: application/json');
include_once '../includes/dbh.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(["message" => "Only POST method allowed."]);
  exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['username_email'], $data['password'])) {
  http_response_code(400);
  echo json_encode(["message" => "username_email and password are required."]);
  exit();
}

$input = mysqli_real_escape_string($conn, $data['username_email']);
$password = $data['password'];

$sql = "SELECT * FROM user WHERE username = '$input' OR email = '$input' LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($user = mysqli_fetch_assoc($result)) {
  // Verify password 
  if ($password === $user['password']) { 
    // Generate secure token
    $token = bin2hex(random_bytes(32));
  
    // Store token in DB
    $update = "UPDATE user SET token = '$token' WHERE userID = " . $user['userID'];
    mysqli_query($conn, $update);
  
    echo json_encode([
      "message" => "Login successful",
      "userID" => $user['userID'],
      "username" => $user['username'],
      "token" => $token
    ]);
  }
   else {
    http_response_code(401);
    echo json_encode(["message" => "Incorrect password."]);
  }
} else {
  http_response_code(404);
  echo json_encode(["message" => "User not found."]);
}
?>
