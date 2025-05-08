<?php
header('Content-Type: application/json');
include '../includes/dbh.php';

$albumID = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM album WHERE albumID = $albumID LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode($row);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Album not found."]);
}
?>
