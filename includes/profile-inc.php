<?php
session_start();
require_once 'dbh.php'; 

if (isset($_POST['countryID'], $_SESSION['userID'])) {
    $userID = $_SESSION['userID'];
    $countryID = intval($_POST['countryID']);

    $sql = "UPDATE user SET countryID = ? WHERE userID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $countryID, $userID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: ../profile.php?update=success");
    exit();
} else {
    header("Location: ../profile.php?update=failed");
    exit();
}