<?php
header('Content-Type: application/json');
include_once '../includes/dbh.php'; 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405); 
  echo json_encode(["message" => "Only POST requests are allowed."]);
  exit();
}

$data = json_decode(file_get_contents("php://input"), true);

// Validate input
if (!isset($data['artistID'], $data['name']) || empty(trim($data['name']))) {
  http_response_code(400); 
  echo json_encode(["message" => "artistID and name are required."]);
  exit();
}

$artistID = intval($data['artistID']);
$name = mysqli_real_escape_string($conn, $data['name']);

// Insert into artist table
$sql = "INSERT INTO artist (artistID, name) VALUES ($artistID, '$name')";

if (mysqli_query($conn, $sql)) {
  echo json_encode([
    "message" => "Artist added successfully.",
    "artistID" => $artistID,
    "name" => $name
  ]);
} else {
  http_response_code(500); 
  echo json_encode([
    "message" => "Failed to add artist.",
    "error" => mysqli_error($conn)
  ]);
}
?>
