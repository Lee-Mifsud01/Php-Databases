<?php
require_once "dbh.php";
require_once "functions.php";

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $admin = 0;

    // Basic validation
    if (empty($username) || empty($email) || empty($password) || empty($confirm)) {
        header("Location: ../register.php?error=emptyfields");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../register.php?error=invalidemail");
        exit();
    }

    if ($password !== $confirm) {
        header("Location: ../register.php?error=passwordmismatch");
        exit();
    }

    // Check if user or email already exists
    $checkSql = "SELECT * FROM user WHERE username=? OR email=?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $checkSql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        header("Location: ../register.php?error=usertaken");
        exit();
    }

    // password hashing and insert
    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
    $insertSql = "INSERT INTO user (username, email, password, admin) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $insertSql);
    mysqli_stmt_bind_param($stmt, "sssi", $username, $email, $hashedPwd, $admin);
    mysqli_stmt_execute($stmt);

    header("Location: ../login.php");
    exit();
}
