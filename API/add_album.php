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
if (!isset($data['albumID'], $data['title'], $data['releaseDate'], $data['artistID'])) {
  http_response_code(400);
  echo json_encode(["message" => "albumID, title, releaseDate, and artistID are required."]);
  exit();
}

$albumID = intval($data['albumID']);
$title = mysqli_real_escape_string($conn, $data['title']);
$releaseDate = mysqli_real_escape_string($conn, $data['releaseDate']);
$artistID = intval($data['artistID']);

//  genreID 
$genreID = isset($data['genreID']) ? intval($data['genreID']) : "NULL";

$sql = "INSERT INTO album (albumID, title, releaseDate, artistID, genreID)
        VALUES ($albumID, '$title', '$releaseDate', $artistID, $genreID)";

if (mysqli_query($conn, $sql)) {
  echo json_encode([
    "message" => "Album added successfully.",
    "albumID" => $albumID
  ]);
} else {
  http_response_code(500);
  echo json_encode([
    "message" => "Failed to add album.",
    "error" => mysqli_error($conn)
  ]);
}
?>
