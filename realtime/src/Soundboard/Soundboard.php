<?php
namespace RealTime\Soundboard;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Soundboard implements MessageComponentInterface
{
    protected $clients;
    protected $soundboardClients;
    protected $dbConnection; // Property to hold the database connection

    public function __construct($dbConnection)
    {
        $this->soundboardClients = new \SplObjectStorage;
        $this->dbConnection = $dbConnection; // Store the database connection
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Parse the query string from the connection URL
        $queryParams = [];
        parse_str(parse_url($conn->httpRequest->getUri(), PHP_URL_QUERY), $queryParams);

        // error_log('queryparams : ' . print_r($queryParams, true));

        // Check if the 'service' query parameter is set to 'soundboard'
        if (isset($queryParams['service']) && $queryParams['service'] === 'soundboard') {
            $this->soundboardClients->attach($conn); // It's a soundboard connection
        }

        // Broadcast the current number of active users
        $this->broadcastActiveUsers();

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
        error_log("[Soundboard] New connection opened: " . $connectionId); // Log the opening of a new connection
    }

    public function onClose(ConnectionInterface $conn)
    {
        $connectionId = $conn->resourceId;

        $this->soundboardClients->detach($conn);

        $this->broadcastActiveUsers();

        error_log("[Soundboard] Connection removed: " . $connectionId);

        // Close the connection
        $conn->close();

        error_log("[Soundboard] Connection closed: " . $connectionId);
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
        // error_log("Decoded action: " . $data['action']); // Log the decoded action

        // Ensure $data['action'] is checked to determine the correct course of action
        if (isset($data['action']) && $data['action'] === 'sound_play' && isset($data['sound_file'])) {
            // Call the method to play the sound with the correct sound file name
            $this->playSound($data['sound_file']);
        }
    }

    private function playSound($soundFile)
    {
        // Loop through all connected clients and send the sound play action
        foreach ($this->soundboardClients as $client) {
            // Construct the message with the sound file to be played
            $message = [
                'action' => 'sound_play',
                'sound_file' => $soundFile
            ];
            error_log("Sending sound play to client."); // Log sending message
            $client->send(json_encode($message));
        }
    }
    private function broadcastActiveUsers()
    {
        $activeUsers = count($this->soundboardClients);
        foreach ($this->soundboardClients as $client) {
            $client->send(json_encode(['type' => 'activeUsers', 'count' => $activeUsers]));
        }
    }


}
