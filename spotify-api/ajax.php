<?php
// Redirect if not logged in
// include('../login_redirect.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load environment variables and configurations
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../../config/lepetitpaco.com.config.php';
$dotenv = Dotenv\Dotenv::createImmutable(getEnvFilePath());
$dotenv->load();

// Spotify API credentials from environment
$spotify_client_id = $_ENV['SPOTIFY_CLIENT_ID'];
$spotify_client_secret = $_ENV['SPOTIFY_CLIENT_SECRET'];


// Function to fetch user's playlists
function fetchUserPlaylists($spotify_client_id, $spotify_client_secret, $spotify_default_user)
{
    $user_id = $_GET['id'] ?? $spotify_default_user;
    $api_url = "https://api.spotify.com/v1/users/" . $user_id . "/playlists";

    // Initialize cURL session
    $ch = curl_init();
    $auth = base64_encode($spotify_client_id . ':' . $spotify_client_secret);
    $auth_url = 'https://accounts.spotify.com/api/token';

    // Set cURL options for the authentication request
    curl_setopt($ch, CURLOPT_URL, $auth_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['grant_type' => 'client_credentials']));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Basic {$auth}",
        "Content-Type: application/x-www-form-urlencoded"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute authentication request
    $auth_response = curl_exec($ch);
    if (!$auth_response) {
        curl_close($ch); // Clean up
        throw new Exception("Error fetching access token: " . curl_error($ch));
    }

    $access_token = json_decode($auth_response, true)['access_token'];
    if (!$access_token) {
        curl_close($ch); // Clean up
        throw new Exception("Failed to obtain access token");
    }

    // Prepare for fetching playlists with the obtained access token
    $playlists_infos = [];
    $next_url = $api_url . "?limit=50";

    do {
        // Set cURL options for fetching playlists
        curl_setopt($ch, CURLOPT_URL, $next_url);
        curl_setopt($ch, CURLOPT_POST, false); // Switch to GET request
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer {$access_token}",
            "Content-Type: application/json",
            "User-Agent: YourApp/1.0" // Example User-Agent; adjust as needed
        ]);

        $api_response = curl_exec($ch);
        if (!$api_response) {
            curl_close($ch); // Clean up
            throw new Exception("Error fetching playlists: " . curl_error($ch));
        }

        $playlists = json_decode($api_response, true);
        $playlists_infos = array_merge($playlists_infos, $playlists['items']);
        $next_url = $playlists['next'];
    } while ($next_url);

    // Close cURL session
    curl_close($ch);

    return $playlists_infos;
}

// Function to fetch playlist songs
function fetchPlaylistSongs($playlist_id, $spotify_client_id, $spotify_client_secret)
{
    // Initialize cURL session
    $ch = curl_init();
    $auth = base64_encode($spotify_client_id . ':' . $spotify_client_secret);
    $auth_url = 'https://accounts.spotify.com/api/token';

    // Set cURL options for the authentication request
    curl_setopt($ch, CURLOPT_URL, $auth_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['grant_type' => 'client_credentials']));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Basic {$auth}",
        "Content-Type: application/x-www-form-urlencoded"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute authentication request
    $auth_response = curl_exec($ch);
    if (!$auth_response) {
        throw new Exception("Error fetching access token: " . curl_error($ch));
    }

    $access_token = json_decode($auth_response, true)['access_token'];
    if (!$access_token) {
        throw new Exception("Failed to obtain access token");
    }

    // Set up headers and execute request for playlist songs
    $api_url = "https://api.spotify.com/v1/playlists/{$playlist_id}/tracks";
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_POST, false); // Switch to GET request
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer {$access_token}",
        "Content-Type: application/json",
        "User-Agent: YourApp/1.0" // Example User-Agent; adjust as needed
    ]);

    $response = curl_exec($ch);
    if (!$response) {
        throw new Exception("Error fetching playlist songs: " . curl_error($ch));
    }

    // Close cURL session
    curl_close($ch);

    return json_decode($response, true);
}

function fetchUserProfile($user_id, $spotify_client_id, $spotify_client_secret)
{
    // Initialize cURL session for authentication
    $ch = curl_init();
    $auth = base64_encode($spotify_client_id . ':' . $spotify_client_secret);
    $auth_url = 'https://accounts.spotify.com/api/token';

    // Set cURL options for the authentication request
    curl_setopt($ch, CURLOPT_URL, $auth_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['grant_type' => 'client_credentials']));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Basic {$auth}",
        "Content-Type: application/x-www-form-urlencoded"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute authentication request
    $auth_response = curl_exec($ch);
    if (!$auth_response) {
        curl_close($ch); // Clean up
        throw new Exception("Error fetching access token: " . curl_error($ch));
    }

    $access_token = json_decode($auth_response, true)['access_token'];
    if (!$access_token) {
        curl_close($ch); // Clean up
        throw new Exception("Failed to obtain access token");
    }

    // Set up the request for user profile
    $api_url = "https://api.spotify.com/v1/users/{$user_id}";
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer {$access_token}",
        "Content-Type: application/json"
    ]);

    // Execute request for user profile
    $profile_response = curl_exec($ch);
    if (!$profile_response) {
        curl_close($ch); // Clean up
        throw new Exception("Error fetching user profile: " . curl_error($ch));
    }

    // Close cURL session
    curl_close($ch);

    return json_decode($profile_response, true);
}


// Main execution block
try {
    if (isset($_GET['action']) && $_GET['action'] == 'fetchUserProfile' && isset($_GET['id'])) {
        // Fetching user profile
        $user_id = $_GET['id'];
        $userProfile = fetchUserProfile($user_id, $spotify_client_id, $spotify_client_secret);
        header('Content-Type: application/json');
        echo json_encode($userProfile);
    } elseif (isset($_GET['playlist_id'])) {
        // Fetching songs for a specific playlist
        $playlist_id = $_GET['playlist_id'];
        $songs = fetchPlaylistSongs($playlist_id, $spotify_client_id, $spotify_client_secret);
        header('Content-Type: application/json');
        echo json_encode($songs);
    } else {
        // Fetching user playlists, use provided username (user ID) if available
        $user_id = isset($_GET['id']) ? $_GET['id'] : $_ENV['SPOTIFY_DEFAULT_USER'];

        $playlists = fetchUserPlaylists($spotify_client_id, $spotify_client_secret, $user_id); // Adjust function to accept $user_id directly
        header('Content-Type: application/json');
        echo json_encode($playlists);
    }
} catch (Exception $e) {
    // Handle errors
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => $e->getMessage()]);
}