<?php
header('Content-Type: application/json');
include_once '../includes/dbh.php';

$artistID = isset($_GET['artistID']) ? intval($_GET['artistID']) : 0;

if ($artistID <= 0) {
  http_response_code(400);
  echo json_encode(["message" => "Valid artistID is required."]);
  exit();
}

$sql = "SELECT albumID, title, releaseDate FROM album WHERE artistID = $artistID";
$result = mysqli_query($conn, $sql);

$albums = [];

while ($row = mysqli_fetch_assoc($result)) {
  $albums[] = $row;
}

if (count($albums) > 0) {
  echo json_encode($albums);
} else {
  echo json_encode(["message" => "No albums found for this artist."]);
}
?>
