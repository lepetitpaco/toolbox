<?php

namespace WordCounter;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class WordCounter implements MessageComponentInterface
{


    protected $clients;
    protected $dbConnection; // Property to hold the database connection

    public function __construct($dbConnection)
    {
        $this->clients = new \SplObjectStorage;
        $this->dbConnection = $dbConnection; // Store the database connection
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Add the new connection to the clients storage
        $this->clients->attach($conn);

        $connectionId = $conn->resourceId;
        error_log("New connection opened: " . $connectionId); // Log the opening of a new connection

        $stmt = $this->dbConnection->prepare("INSERT INTO websocket_connections (connection_id) VALUES (?)");
        if (!$stmt) {
            error_log("Prepare statement failed: " . $this->dbConnection->error); // Log prepare statement failure
        } else {
            $stmt->bind_param("s", $connectionId);
            if (!$stmt->execute()) {
                error_log("Execution failed: " . $stmt->error); // Log execution failure
            } else {
                error_log("Inserted new connection into the database: " . $connectionId); // Log successful insertion into the database
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $connectionId = $conn->resourceId;

        $this->clients->detach($conn);
        error_log("Connection removed: " . $connectionId);

        // Remove the connection from the database
        $stmt = $this->dbConnection->prepare("DELETE FROM websocket_connections WHERE connection_id = ?");
        $stmt->bind_param("s", $connectionId);
        if (!$stmt->execute()) {
            error_log("Error deleting connection from the database: " . $stmt->error);
        }

        // Close the connection
        $conn->close();

        error_log("Connection closed: " . $connectionId);
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);
        error_log('Message received: ' . $msg);

        if (isset($data['action'])) {
            switch ($data['action']) {
                case 'add':
                    // Broadcast a message without inserting into the database
                    $word = $data['word']; // Assuming 'word' is passed in the message
                    $this->broadcast(['message' => "Word added: $word", 'data' => $data]);
                    break;
                case 'remove':
                    // Broadcast a message without removing from the database
                    $word = $data['word']; // Assuming 'word' is passed in the message
                    $this->broadcast(['message' => "Word removed: $word", 'data' => $data]);
                    break;
                case 'increment':
                    // Broadcast a message without updating count in the database
                    $word = $data['word']; // Assuming 'word' is passed in the message
                    $this->broadcast(['message' => "Word count incremented for: $word", 'data' => $data]);
                    break;
                case 'decrement':
                    // Broadcast a message without updating count in the database
                    $word = $data['word']; // Assuming 'word' is passed in the message
                    $this->broadcast(['message' => "Word count decremented for: $word", 'data' => $data]);
                    break;
                case 'rename':
                    // Broadcast a message without updating count in the database
                    $oldWord = $data['oldWord']; // Assuming 'oldWord' is passed in the message
                    $newWord = $data['newWord']; // Assuming 'newWord' is passed in the message
                    $this->broadcast(['message' => "Word renamed from '$oldWord' to '$newWord'", 'data' => $data]);
                    break;
                default:
                    error_log("Invalid action: " . $data['action']);
                    $this->broadcast(['error' => 'Invalid action']);
                    break;
            }
        }
    }


    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
        error_log('Error on connection: ' . $e->getMessage());
    }

    public function broadcast($data)
    {
        error_log('Attempting to broadcast to ' . count($this->clients) . ' clients');
        if (count($this->clients) > 0) {
            foreach ($this->clients as $client) {
                $client->send(json_encode($data));
            }
        } else {
            error_log('Confirmed: No clients to broadcast to.');
        }
    }


    public function handleEvent($eventData)
    {
        error_log('handleEvent called with eventData: ' . print_r($eventData, true));

        // Assuming eventData contains the necessary information about the action
        // and the word(s) affected, you can customize the response based on the action
        $action = $eventData['action'];

        // For actions that affect the whole list, fetch and broadcast the updated list
        if (in_array($action, ['add', 'remove', 'increment', 'decrement', 'rename'])) {
            $updatedData = $this->fetchUpdatedDataFromDatabase();
            $this->broadcast([
                'type' => 'update', // Indicate this is an update message
                'data' => $updatedData // The updated word list or details
            ]);
        }
    }

    private function fetchUpdatedDataFromDatabase()
    {
        $query = "SELECT word, count FROM word_count ORDER BY word ASC";
        $result = $this->dbConnection->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        error_log('Fetched data from database: ' . print_r($data, true));
        return $data;
    }
}
