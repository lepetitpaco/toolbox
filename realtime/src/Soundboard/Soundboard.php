<?php
namespace RealTime\Soundboard;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Soundboard implements MessageComponentInterface
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

        // Prepare the list of sound files
        $soundFiles = scandir(dirname(__FILE__) . '/../../soundboard/sounds/');
        $soundFiles = array_values(array_diff($soundFiles, ['.', '..'])); // Remove . and .. entries

        // Send the list of sound files to the client
        $message = [
            'action' => 'sound_init_sounds',
            'sounds' => $soundFiles
        ];
        $conn->send(json_encode($message));

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
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        error_log("An error has occurred: " . $e->getMessage());
        $conn->close();
    }
    public function onMessage(ConnectionInterface $from, $msg)
    {
        error_log("Received message: " . $msg); // Log the received message
        $data = json_decode($msg, true);
        error_log("Decoded action: " . $data['action']); // Log the decoded action
    
        // Ensure $data['action'] is checked to determine the correct course of action
        if (isset($data['action']) && $data['action'] === 'sound_play' && isset($data['sound_file'])) {
            // Call the method to play the sound with the correct sound file name
            $this->playSound($data['sound_file']);
        }
    }
    
    private function playSound($soundFile)
    {
        // Loop through all connected clients and send the sound play action
        foreach ($this->clients as $client) {
            // Construct the message with the sound file to be played
            $message = [
                'action' => 'sound_play',
                'sound_file' => $soundFile
            ];
            error_log("Sending sound play to client."); // Log sending message
            $client->send(json_encode($message));
        }
    }
    

}
