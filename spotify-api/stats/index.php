<?php
// Redirect if not logged in
// include('../login_redirect.php');

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

// Ensure this matches the Redirect URI registered in your Spotify Developer Dashboard and points to your callback.php
$redirect_uri = urlencode('https://lepetitpaco.com/spotify-api/stats/callback.php'); // Replace with your actual Redirect URI

$scope = urlencode('user-top-read');
$auth_url = "https://accounts.spotify.com/authorize?client_id={$spotify_client_id}&response_type=code&redirect_uri={$redirect_uri}&scope={$scope}";

header('Location: '. $auth_url);
exit;

?>