<?php
header('Content-Type: application/json');
include_once '../includes/dbh.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(["message" => "Only POST allowed."]);
  exit();
}

if (!isset($_POST['albumID']) || !isset($_FILES['image'])) {
  http_response_code(400);
  echo json_encode(["message" => "albumID and image file are required."]);
  exit();
}

$albumID = intval($_POST['albumID']);
$image = $_FILES['image'];

// Basic validation
$allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
if (!in_array($image['type'], $allowedTypes)) {
  http_response_code(400);
  echo json_encode(["message" => "Invalid file type."]);
  exit();
}

// Set upload path
$filename = uniqid("album_") . '_' . basename($image['name']);
$targetPath = '../uploads/' . $filename;

if (move_uploaded_file($image['tmp_name'], $targetPath)) {
  // Save to DB
  $relativePath = 'uploads/' . $filename;
  $sql = "UPDATE album SET imagePath = '$relativePath' WHERE albumID = $albumID";
  mysqli_query($conn, $sql);

  echo json_encode([
    "message" => "Image uploaded successfully.",
    "imagePath" => $relativePath
  ]);
} else {
  http_response_code(500);
  echo json_encode(["message" => "Upload failed."]);
}
?>
