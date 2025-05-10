<?php
$accessToken =  "BQBQQaWygKrylu7gMsp0eRk4n6cQTaa5Nf_VQws9WwWw9QmkXNDCbCT-6j1cE2wzgGFuDu6W7d7zuA5RIW7IVCNzvotScO-drziP9qiygydMazxAgH0kars6fMebzvJPrxKC1EaADLg7kcrzdUYeUBhks_95VV8x7q3BTUwlaqyJAUYjmzDSnnmygDzEsTyx3thWQUyu_WTJjNJNdSH26IcpKIKh3NpDE6vdF_Za0Tk"; // access token
$artistName = 'Drake'; 

// 1. Build Spotify API request
$query = urlencode($artistName);
$url = "https://api.spotify.com/v1/search?q={$query}&type=artist&limit=1";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $accessToken"
]);

// 2. Get and decode response
$response = curl_exec($ch);
curl_close($ch);
$data = json_decode($response, true);

// 3. Output artist name and image
if (!empty($data['artists']['items'][0])) {
    $artist = $data['artists']['items'][0];
    $name = $artist['name'];
    $image = $artist['images'][0]['url'];

    echo "<h2>$name</h2>";
    echo "<img src='$image' alt='Image of $name' width='300'>";
} else {
    echo "<p>No artist found.</p>";
}
?>
