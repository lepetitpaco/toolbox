<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load environment variables and configurations
require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../../config/lepetitpaco.com.config.php';
$dotenv = Dotenv\Dotenv::createImmutable(getEnvFilePath());
$dotenv->load();

$spotify_client_id = $_ENV['SPOTIFY_CLIENT_ID'];
$spotify_client_secret = $_ENV['SPOTIFY_CLIENT_SECRET'];

// Spotify has redirected back with a code, now request an access token
if (isset($_GET['code'])) {
    $authorizationCode = $_GET['code'];
    $url = 'https://accounts.spotify.com/api/token';

    $redirect_uri = 'https://lepetitpaco.com/spotify-api/stats/callback.php'; // Adjusted to match the authorization request

    $data = [
        'grant_type' => 'authorization_code',
        'code' => $authorizationCode,
        'redirect_uri' => $redirect_uri,
        'client_id' => $spotify_client_id,
        'client_secret' => $spotify_client_secret,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    if (!$response) {
        die("Error exchanging code for token: " . curl_error($ch));
    }

    $responseData = json_decode($response, true);
    if (isset($responseData['access_token'])) {
        $access_token = $responseData['access_token'];

        // Store the access token in the session, or use it directly to make API requests
        // For example:
        // $_SESSION['spotify_access_token'] = $access_token;

        // Redirect to another page or display a success message
        echo "Access token received successfully.";
        session_start();
        $_SESSION['spotify_access_token'] = $access_token;
        header('Location: https://lepetitpaco.com/spotify-api/stats/alltime.php');
        exit;
        

        // Optionally, redirect or perform API requests here
    } else {
        die("Failed to receive access token.");
    }

    curl_close($ch);
} else {
    echo "Authorization code not found. Please make sure you're coming from Spotify's authorization screen.";
}
