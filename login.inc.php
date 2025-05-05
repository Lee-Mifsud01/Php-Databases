<?php
session_start();
include 'includes/dbh.php';

if (isset($_POST['login'])) {
    $input = mysqli_real_escape_string($conn, $_POST['username_email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE username='$input' OR email='$input' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['userid'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: home.php");
        exit();
    } else {
        header("Location: login.php?error=invalidlogin");
        exit();
    }
}
?>
