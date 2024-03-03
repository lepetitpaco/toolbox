<?php
// Redirect if not logged in
// include('../login_redirect.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Load environment variables and configurations
require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../../config/lepetitpaco.com.config.php';
$dotenv = Dotenv\Dotenv::createImmutable(getEnvFilePath());
$dotenv->load();

$spotify_client_id = $_ENV['SPOTIFY_CLIENT_ID'];
$spotify_client_secret = $_ENV['SPOTIFY_CLIENT_SECRET'];

$api_url = "https://api.spotify.com/v1/me/top/tracks?time_range=long_term&limit=50";



$access_token = $_SESSION['spotify_access_token'];


// Initialize cURL session
$ch = curl_init();

// Use the access token to fetch top tracks
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_HTTPGET, true); // Use GET request
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer {$access_token}",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Enable SSL verification

// var_dump("Requesting top tracks...");

// Execute the request
$api_response = curl_exec($ch);
if (!$api_response) {
    $error = curl_error($ch);
    curl_close($ch); // Clean up
    // var_dump("Error fetching top tracks: " . $error);
    throw new Exception("Error fetching top tracks: " . $error);
}

$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ($http_status != 200) {
    // var_dump("Received HTTP status $http_status. Response: " . $api_response);
    throw new Exception("HTTP request failed with status $http_status");
}

// var_dump("Top tracks fetched successfully.");

// Decode the response
$top_tracks = json_decode($api_response, true);

// Close cURL session
curl_close($ch);

if (isset($top_tracks['items']) && !empty($top_tracks['items'])) {
    echo "<h2>Top Tracks</h2>";
    echo "<ul>";
    foreach ($top_tracks['items'] as $track) {
        $trackName = htmlspecialchars($track['name']);
        $artistNames = array_map(function($artist) { return htmlspecialchars($artist['name']); }, $track['artists']);
        $artists = implode(", ", $artistNames);
        echo "<li>{$trackName} by {$artists}</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No top tracks found.</p>";
}
