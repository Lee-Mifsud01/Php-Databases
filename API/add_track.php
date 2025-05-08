<?php
header('Content-Type: application/json');
include_once '../includes/dbh.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(["message" => "Only POST method allowed."]);
  exit();
}

$data = json_decode(file_get_contents("php://input"), true);

// Validate required fields
if (!isset($data['trackID'], $data['title'], $data['albumID'])) {
  http_response_code(400);
  echo json_encode(["message" => "trackID, title, and albumID are required."]);
  exit();
}

$trackID = intval($data['trackID']);
$title = mysqli_real_escape_string($conn, $data['title']);
$albumID = intval($data['albumID']);

$duration = isset($data['duration']) ? intval($data['duration']) : 0;

$sql = "INSERT INTO track (trackID, title, albumID)
        VALUES ($trackID, '$title', $albumID)";

if (mysqli_query($conn, $sql)) {
  echo json_encode([
    "message" => "Track added successfully.",
    "trackID" => $trackID
  ]);
} else {
  http_response_code(500);
  echo json_encode([
    "message" => "Failed to add track.",
    "error" => mysqli_error($conn)
  ]);
}
?>
