<?php

namespace RealTime\WordCounter;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class WordCounter implements MessageComponentInterface
{
    protected $clients;
    protected $wordcounterClients;
    protected $dbConnection; // Property to hold the database connection

    public function __construct($dbConnection)
    {
        $this->wordcounterClients = new \SplObjectStorage;
        $this->dbConnection = $dbConnection; // Store the database connection
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Parse the query string from the connection URL
        $queryParams = [];
        parse_str(parse_url($conn->httpRequest->getUri(), PHP_URL_QUERY), $queryParams);

        // error_log('queryparams : ' . print_r($queryParams, true));

        // Check if the 'service' query parameter is set to 'wordcounter'
        if (isset($queryParams['service']) && $queryParams['service'] === 'wordcounter') {
            $this->wordcounterClients->attach($conn); // It's a wordcounter connection
        }

        // Broadcast the current number of active users
        $this->broadcastActiveUsers();


        $connectionId = $conn->resourceId;
        error_log("[Word Counter] New connection opened: " . $connectionId); // Log the opening of a new connection
    }

    public function onClose(ConnectionInterface $conn)
    {
        $connectionId = $conn->resourceId;

        $this->wordcounterClients->detach($conn);
        error_log("[Word Counter] Connection removed: " . $connectionId);

        // Broadcast the current number of active users
        $this->broadcastActiveUsers();

        // Close the connection
        $conn->close();

        error_log("[Word Counter] Connection closed: " . $connectionId);
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        // Decode the received JSON message
        $data = json_decode($msg, true);
        $action = $data['action'] ?? '';

        switch ($action) {
            case 'word_fetchInitialData':
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

        // error_log("displaying datas before switch : " . print_r($data, true));

        switch ($action) {
            case 'word_add':
                $stmt = $this->dbConnection->prepare("INSERT INTO word_count (word, count) VALUES (?, 1) ON DUPLICATE KEY UPDATE count = count + 1");
                $stmt->bind_param("s", $word);
                break;

            case 'word_remove':
                $stmt = $this->dbConnection->prepare("DELETE FROM word_count WHERE word = ?");
                $stmt->bind_param("s", $word);
                break;

            case 'word_increment':
                $stmt = $this->dbConnection->prepare("UPDATE word_count SET count = count + 1 WHERE word = ?");
                $stmt->bind_param("s", $word);
                break;

            case 'word_decrement':
                $stmt = $this->dbConnection->prepare("UPDATE word_count SET count = count - 1 WHERE word = ?");
                $stmt->bind_param("s", $word);
                break;

            case 'word_rename':
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
        error_log('Attempting to broadcast to ' . count($this->wordcounterClients) . ' clients');
        if (count($this->wordcounterClients) > 0) {
            foreach ($this->wordcounterClients as $client) {
                $client->send(json_encode($data));
            }
        } else {
            error_log('Confirmed: No clients to broadcast to.');
        }
    }


    public function handleEvent($eventData)
    {
        // error_log('handleEvent called with eventData: ' . print_r($eventData, true));

        // Assuming eventData contains the necessary information about the action
        // and the word(s) affected, you can customize the response based on the action
        $action = $eventData['action'];

        // For actions that affect the whole list, fetch and broadcast the updated list
        if (in_array($action, ['word_add', 'word_remove', 'word_increment', 'word_decrement', 'word_rename'])) {
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
    private function broadcastActiveUsers()
    {
        $activeUsers = count($this->wordcounterClients);
        foreach ($this->wordcounterClients as $client) {
            $client->send(json_encode(['type' => 'activeUsers', 'count' => $activeUsers]));
        }
    }
}
