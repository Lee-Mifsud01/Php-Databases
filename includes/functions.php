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

        header("location: ../index.php");
        exit();
    }

    //Function to delete user
function deleteUser($conn, $deleteID) {
    //Delete from dependent tables first
    $tables = ['albumbadge', 'payment', 'playlist'];
    foreach ($tables as $table) {
        $stmt = $conn->prepare("DELETE FROM $table WHERE userID = ?");
        if (!$stmt) {
            echo "<p style='color:red;'>Error preparing DELETE from $table</p>";
            return false;
        }
        $stmt->bind_param("i", $deleteID);
        $stmt->execute();
        $stmt->close();
    }

    
    $stmt = $conn->prepare("DELETE FROM user WHERE userID = ?");
    if (!$stmt) {
        echo "<p style='color:red;'>Error preparing DELETE from user</p>";
        return false;
    }
    $stmt->bind_param("i", $deleteID);
    $stmt->execute();
    $stmt->close();
    return true;
}



if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $deleteID = (int) $_GET['delete'];

    if ($deleteID == $userID) {
        echo "<p style='color:red;'>You cannot delete yourself.</p>";
    } else {
        if (deleteUser($conn, $deleteID)) {
            // Redirect to avoid resubmission
            header("Location: admin.php");
            exit();
        } else {
            echo "<p style='color:red;'>Failed to delete user.</p>";
        }
    }
}


// Function to get the currently playing track
function getCurrentlyPlaying(): ?array {
    $token = ensureSpotifyToken();
    if (!$token) {
        return null;
    }

    $ch = curl_init('https://api.spotify.com/v1/me/player/currently-playing');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => [
            "Authorization: Bearer $token",
        ],
    ]);
    $resp = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($code !== 200) {
        return null; // Handle errors or no track playing
    }

    $data = json_decode($resp, true);
    if (empty($data['item'])) {
        return null; // No track playing
    }

    $item = $data['item'];
    $artists = array_map(fn($a) => $a['name'], $item['artists']);
    $img = end($item['album']['images'])['url'];

    return [
        'track_name'  => $item['name'],
        'artists'     => implode(', ', $artists),
        'album_image' => $img,
    ];
}

// Function to ensure we have a valid Spotify token (refresh if needed)
function ensureSpotifyToken(): string {
    // Check if the token exists or if it is expired
    if (empty($_SESSION['BQD-FIeuIT5__g2IJXr5sfGZhZ8uGUfKt_BxNN2AMSt3_n9A8WR-hYFBUMkaES4dL3D-cu0D_JVTVwLzGWxGcnDp4Cgap12VsWhN3s2kjlzCSP26VuVX0BqsrDtJy3oy_Z3cRTWzfSyuAqNxEpdaPDSugLosfXkfAGOyvGq7y9XMDE53CgmAmHT6TIhIdG5orWcdozklRU8VQb9s1EcioO-QnQSt9ffvFdrat399oUuDq3xoLVOPP3cVRuM']) || time() >= ($_SESSION['spotify_token_expires'] ?? 0)) {
        // Refresh the token if expired or not available
        if (empty($_SESSION['AQAIVIJHyXzMbsaokqkF4mPh8DU-c5HMeESYwQ9eENKSZNU0x2Pu_JMUTjhgN63FmOs9wfn1CSqWcZXj5Yz8-_tIhpf3KgeGdDF4ok_RQSulPgnTHlGnvPtApdQKE3reiJ8'])) {
            return ''; // No refresh token to refresh the access token
        }

        // Prepare client credentials
        $clientId = '477236a2dcd14d22b77da8db52f2b077D'; // Replace with your actual Spotify client ID
        $clientSecret = '9500a9368925432ca4d5c3e0d3b86de8'; // Replace with your actual Spotify client secret
        $refreshToken = $_SESSION['AQAIVIJHyXzMbsaokqkF4mPh8DU-c5HMeESYwQ9eENKSZNU0x2Pu_JMUTjhgN63FmOs9wfn1CSqWcZXj5Yz8-_tIhpf3KgeGdDF4ok_RQSulPgnTHlGnvPtApdQKE3reiJ8'];

        // Make a request to refresh the token
        $ch = curl_init('https://accounts.spotify.com/api/token');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Basic ' . base64_encode("$clientId:$clientSecret"),
                'Content-Type: application/x-www-form-urlencoded',
            ],
            CURLOPT_POSTFIELDS => http_build_query([
                'grant_type' => 'refresh_token',
                'refresh_token' => $refreshToken,
            ]),
        ]);
        $response = curl_exec($ch);
        curl_close($ch);

        // Decode the response
        $data = json_decode($response, true);
        if (isset($data['access_token'])) {
            // Store the new access token and expiration time in session
            $_SESSION['9500a9368925432ca4d5c3e0d3b86de8'] = $data['9500a9368925432ca4d5c3e0d3b86de8'];
            $_SESSION[3600] = time() + $data['expires_in'];
            return $_SESSION['spotify_access_token'];
        } else {
            return ''; // Failed to refresh token
        }
    }

    return $_SESSION['spotify_access_token']; // Return the existing access token
}


?>