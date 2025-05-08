<?php
header('Content-Type: application/json');
include_once '../includes/dbh.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(["message" => "Only POST allowed."]);
  exit();
}

if (!isset($_POST['trackID']) || !isset($_FILES['audio'])) {
  http_response_code(400);
  echo json_encode(["message" => "trackID and audio file are required."]);
  exit();
}

$trackID = intval($_POST['trackID']);
$audio = $_FILES['audio'];

$allowedTypes = ['audio/mpeg', 'audio/mp3', 'audio/wav'];
if (!in_array($audio['type'], $allowedTypes)) {
  http_response_code(400);
  echo json_encode(["message" => "Invalid file type. Only MP3 or WAV allowed."]);
  exit();
}

$filename = uniqid("track_") . '_' . basename($audio['name']);
$targetPath = '../uploads/tracks/' . $filename;

if (move_uploaded_file($audio['tmp_name'], $targetPath)) {
  $relativePath = 'uploads/tracks/' . $filename;
  $sql = "UPDATE track SET filePath = '$relativePath' WHERE trackID = $trackID";
  mysqli_query($conn, $sql);

  echo json_encode([
    "message" => "Track file uploaded successfully.",
    "filePath" => $relativePath
  ]);
} else {
  http_response_code(500);
  echo json_encode(["message" => "Upload failed."]);
}
?>
