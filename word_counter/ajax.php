<?php

// Start output buffering to prevent unintended output
ob_start();

// Enable PHP debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load environment variables
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../../config/config.php';
$dotenv = Dotenv\Dotenv::createImmutable(getEnvFilePath());
$dotenv->load();

use WordCounter\WordCounter;

// db creds
$dbHost = $_ENV['DBHOST'];
$dbUser = $_ENV['DBUSER'];
$dbPass = $_ENV['DBPASS'];
$dbName = $_ENV['DBNAME'];

// Establish a database connection
$connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

// Check if the connection was successful
if (!$connection) {
    ob_end_clean(); // Clean the output buffer
    die("Database connection failed: " . mysqli_connect_error());
}

// Utility function to send JSON responses
function sendJson($data, $statusCode = 200)
{
    ob_end_clean(); // Clean the output buffer before sending the response
    header('Content-Type: application/json');
    http_response_code($statusCode);
    echo json_encode($data);
}

// Main request handler
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Fetch and return word counts
        $query = "SELECT word, count FROM word_count ORDER BY word ASC";
        $result = mysqli_query($connection, $query);
        $wordData = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $wordData[] = $row;
        }
        sendJson($wordData);
        break;

    case 'POST':
        // Extract the action type from the POST request.
        $action = $_POST['action'] ?? '';

        // Sanitize the input word to prevent SQL injection.
        $word = mysqli_real_escape_string($connection, $_POST['word'] ?? '');

        // Handle different actions: add, remove, increment, decrement, rename.
        switch ($action) {
            case 'add':
                // Add a new word or increment its count if it already exists.
                $query = "INSERT INTO word_count (word, count) VALUES ('$word', 1) ON DUPLICATE KEY UPDATE count = count + 1";
                break;

            case 'remove':
                // Remove a word from the count.
                $query = "DELETE FROM word_count WHERE word = '$word'";
                break;

            case 'increment':
            case 'decrement':
                // Increment or decrement the word count.
                $modification = ($action === 'increment') ? "+ 1" : "- 1";
                $query = "UPDATE word_count SET count = count $modification WHERE word = '$word'";
                break;

            case 'rename':
                // Rename an existing word.
                $newWord = mysqli_real_escape_string($connection, $_POST['newWord'] ?? '');
                $oldWord =  $_POST['oldWord'];

                $query = "UPDATE word_count SET word = '$newWord' WHERE word = '$oldWord'";
                break;

            default:
                // Handle invalid actions.
                sendJson(['error' => 'Invalid action'], 400);
                exit; // Exit the switch-case block.
        }

        // Execute the constructed query.
        mysqli_query($connection, $query);

        // For add, increment, and decrement actions, fetch the updated count.
        if (in_array($action, ['add', 'remove', 'rename', 'increment', 'decrement'])) {
            $currentCountQuery = "SELECT count FROM word_count WHERE word = '$word'";
            $currentCountResult = mysqli_query($connection, $currentCountQuery);
            $row = mysqli_fetch_assoc($currentCountResult);
            $currentCount = $row['count'] ?? 0;
            // Optionally, send back the updated count.
            sendJson(['message' => "Word $action successfully", 'type' => 'update', 'action' => $action, 'word' => $word, 'count' => $currentCount]);
        } else {
            // For remove and rename actions, just confirm the action was successful.
            sendJson(['message' => "Word $action successfully", 'type' => 'update', 'action' => $action]);
        }

        break;

    default:
        // Method not supported
        sendJson(['error' => 'Method not supported'], 405);
}

