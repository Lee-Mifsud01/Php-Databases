<?php
$accessToken =  "BQCpvPdsnHBnaP7W35CNHIYurfIFx6PaO2I4rg_rnLuCuXz-3t12hGV5Cb2PhAdtwQ3340j-2JlXskPbaZ5Fh0tTbXTFrHrhnCLsfuyS58JhhokhoeSA-mZT6THks2zNmTpUbqfJRoE"; // Paste your real token here
$artistName = 'Drake'; // You can make this dynamic later with $_GET['q']

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
