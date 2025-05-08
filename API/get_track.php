<?php
header('Content-Type: application/json');
include '../includes/dbh.php';

$albumID = isset($_GET['albumID']) ? intval($_GET['albumID']) : 0;

$sql = "SELECT trackID, title FROM track WHERE albumID = $albumID";
$result = mysqli_query($conn, $sql);

$tracks = [];

while ($row = mysqli_fetch_assoc($result)) {
    $tracks[] = $row;
}

echo json_encode($tracks);
?>
