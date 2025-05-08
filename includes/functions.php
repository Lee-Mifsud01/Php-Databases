<?php

    // Login Validtation
    function emptyLoginInput($username, $password){
        $result = false;

        if (empty($username) || empty($password)){
            $result = true;
        }

        return $result;
    }

    function userExists($conn, $username){
        $sql = "SELECT username FROM user WHERE username = ? OR email = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("location: ../profile.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $username, $username);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        if($row = mysqli_fetch_assoc($result)){
            return true;
        }
        else{
            return false;
        }
    }

    function loadUserByUsernameOrEmail($conn, $input){
        $sql = "SELECT * FROM user WHERE username = ? OR email = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("location: ../login.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $input, $input);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($result)){
            return $row;
        }
        else{
            return false;
        }
    }


    // Login Function
    function login($conn, $username, $password){
        if (!userExists($conn, $username)){
            header("location: ../login.php?error=incorrectlogin");
            exit();
        }

        $user = loadUserByUsernameOrEmail($conn, $username);
        $dbPassword = $user["password"];
        $checkedPassword = password_verify($password, $dbPassword);

        if (!$checkedPassword){
            header("location: ../login.php?error=incorrectlogin");
            exit();
        }

        session_start();
        $_SESSION["username"] = $username;
        $_SESSION["userID"] = $user["userID"];

        header("location: ../home.php");
        exit();
    }


?>