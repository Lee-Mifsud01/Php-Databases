<?php
// includes/spotify.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Refresh our Spotify access token if it’s expired.
 */
function ensureSpotifyToken(): string {
    // If we don’t have one yet, or it’s expired:
    if (
      empty($_SESSION['spotify_access_token']) ||
      time() >= ($_SESSION['spotify_token_expires'] ?? 0)
    ) {
        // 1) Prepare credentials
        $clientId     = getenv('SPOTIFY_CLIENT_ID');
        $clientSecret = getenv('SPOTIFY_CLIENT_SECRET');
        $refreshToken = $_SESSION['spotify_refresh_token'] ?? '';

        // 2) Make the POST to refresh
        $ch = curl_init('https://accounts.spotify.com/api/token');
        curl_setopt_array($ch, [
          CURLOPT_POST           => true,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_HTTPHEADER     => [
            'Authorization: Basic '.base64_encode("$clientId:$clientSecret"),
            'Content-Type: application/x-www-form-urlencoded',
          ],
          CURLOPT_POSTFIELDS     => http_build_query([
            'grant_type'    => 'refresh_token',
            'refresh_token' => $refreshToken,
          ]),
        ]);
        $resp = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($resp, true);
        if (isset($data['access_token'])) {
            $_SESSION['spotify_access_token']  = $data['access_token'];
            // expires_in is in seconds from now
            $_SESSION['spotify_token_expires'] = time() + $data['expires_in'];
        } else {
      
            return '';
        }
    }

    return $_SESSION['spotify_access_token'];
}

/**
 * Fetch the currently playing track, or null if none.
 */
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
      // 204 means no content (not playing), anything else is an error
      return null;
    }

    $data = json_decode($resp, true);
    if (empty($data['item'])) {
      return null;
    }

    $item = $data['item'];
    // collect artist names
    $artists = array_map(fn($a)=>$a['name'], $item['artists']);
    // pick the smallest album image
    $img = end($item['album']['images'])['url'];

    return [
      'track_name'  => $item['name'],
      'artists'     => implode(', ', $artists),
      'album_image' => $img,
    ];
}
