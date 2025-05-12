<?php
session_start();
include 'dbh.php';

$userID = $_SESSION['userID'] ?? null;

if (!$userID) {
  header("Location: ../login.php");
  exit();
}

// Update country
if (isset($_POST['countryID']) && !empty($_POST['countryID'])) {
  $countryID = intval($_POST['countryID']);
  $stmt = $conn->prepare("UPDATE user SET countryID = ? WHERE userID = ?");
  $stmt->bind_param("ii", $countryID, $userID);
  $stmt->execute();
  $stmt->close();
}

// Update region
if (isset($_POST['regionID']) && !empty($_POST['regionID'])) {
  $regionID = intval($_POST['regionID']);
  $stmt = $conn->prepare("UPDATE user SET regionID = ? WHERE userID = ?");
  $stmt->bind_param("ii", $regionID, $userID);
  $stmt->execute();
  $stmt->close();
}

header("Location: ../profile.php?updated=1");
exit();
