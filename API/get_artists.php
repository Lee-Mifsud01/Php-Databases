<?php
header('Content-Type: application/json');
include '../includes/dbh.php';

$sql = "SELECT artistID, name FROM artist";
$result = mysqli_query($conn, $sql);

$artists = [];

while ($row = mysqli_fetch_assoc($result)) {
    $artists[] = $row;
}

echo json_encode($artists);
?>
