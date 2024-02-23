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
        // Decode the received JSON message
        $data = json_decode($msg, true);
        $action = $data['action'] ?? '';

        switch ($action) {
            case 'fetchInitialData':
                // Fetch the initial data from the database
                $initialData = $this->fetchUpdatedDataFromDatabase();
                // Send the initial data back to the client
                $from->send(json_encode([
                    'type' => 'initialData', // Indicate the type of data being sent
                    'data' => $initialData // The actual word list data
                ]));
                break;
            default:
                // If the action is not 'fetchInitialData', process other actions
                if (!empty($action)) {
                    // Perform the action by updating the database
                    $this->performAction($action, $data);
                    // After action is performed, handle the event by fetching updated data and broadcasting
                    $this->handleEvent(['action' => $action]);
                } else {
                    // Handle case where action is not recognized or is missing
                    $from->send(json_encode(['error' => 'Invalid action']));
                }
                break;
        }
    }
    private function performAction($action, $data)
    {
        // Initialize variables to avoid undefined variable errors
        $word = $data['word'] ?? '';
        $newWord = $data['newWord'] ?? ''; // Only used in the 'rename' action

        error_log("displaying datas before switch : " . print_r($data, true));

        switch ($action) {
            case 'add':
                $stmt = $this->dbConnection->prepare("INSERT INTO word_count (word, count) VALUES (?, 1) ON DUPLICATE KEY UPDATE count = count + 1");
                $stmt->bind_param("s", $word);
                break;

            case 'remove':
                $stmt = $this->dbConnection->prepare("DELETE FROM word_count WHERE word = ?");
                $stmt->bind_param("s", $word);
                break;

            case 'increment':
                $stmt = $this->dbConnection->prepare("UPDATE word_count SET count = count + 1 WHERE word = ?");
                $stmt->bind_param("s", $word);
                break;

            case 'decrement':
                $stmt = $this->dbConnection->prepare("UPDATE word_count SET count = count - 1 WHERE word = ?");
                $stmt->bind_param("s", $word);
                break;

            case 'rename':
                $stmt = $this->dbConnection->prepare("UPDATE word_count SET word = ? WHERE word = ?");
                $stmt->bind_param("ss", $newWord, $word); // Note the double "s" for two string parameters
                break;

            default:
                $this->broadcast(['error' => 'Invalid action']);
                return; // Exit the method early if the action is invalid
        }

        // Check if the statement was prepared successfully
        if ($stmt === false) {
            error_log("Prepare failed: " . $this->dbConnection->error);
            return;
        }

        // Execute the prepared statement and check for success
        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
        } else {
            error_log("Executed with success !!");

        }

        // Close the statement
        $stmt->close();
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
        // error_log('Fetched data from database: ' . print_r($data, true));
        return $data;
    }
}
