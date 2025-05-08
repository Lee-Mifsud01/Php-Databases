<?php
header('Content-Type: application/json');
include_once '../includes/dbh.php';

$albumID = isset($_GET['albumID']) ? intval($_GET['albumID']) : 0;

if ($albumID <= 0) {
  http_response_code(400);
  echo json_encode(["message" => "Valid albumID is required."]);
  exit();
}

$sql = "SELECT trackID, title FROM track WHERE albumID = $albumID";
$result = mysqli_query($conn, $sql);

$tracks = [];

while ($row = mysqli_fetch_assoc($result)) {
  $tracks[] = $row;
}

if (count($tracks) > 0) {
  echo json_encode($tracks);
} else {
  echo json_encode(["message" => "No tracks found for this album."]);
}
?>
