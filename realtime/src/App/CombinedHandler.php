<?php

namespace RealTime\App; // Use the appropriate namespace for your project

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use RealTime\WordCounter\WordCounter;
use RealTime\Soundboard\Soundboard;

class CombinedHandler implements MessageComponentInterface
{
    protected $wordCounter;
    protected $soundboard;

    public function __construct($dbConnection, $dbHost, $dbUser, $dbPass, $dbName)
    {
        $this->wordCounter = new WordCounter($dbConnection, $dbHost, $dbUser, $dbPass, $dbName);
        $this->soundboard = new Soundboard($dbConnection);
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Parse the query string from the connection URL
        $queryParams = [];
        parse_str(parse_url($conn->httpRequest->getUri(), PHP_URL_QUERY), $queryParams);

        // Check the 'service' query parameter to determine which handler to use
        if (isset($queryParams['service'])) {
            switch ($queryParams['service']) {
                case 'wordcounter':
                    $this->wordCounter->onOpen($conn);
                    break;
                case 'soundboard':
                    $this->soundboard->onOpen($conn);
                    break;
                default:
                    // Optionally handle unknown services or simply log and ignore
                    error_log("Unknown service type: " . $queryParams['service']);
                    break;
            }
        } else {
            // If no service is specified, you might choose to close the connection,
            // log a warning, or handle it in a default manner
            error_log("No service specified for connection");
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // Parse the query string from the connection URL
        $queryParams = [];
        parse_str(parse_url($conn->httpRequest->getUri(), PHP_URL_QUERY), $queryParams);

        // Check the 'service' query parameter to determine which handler to use
        if (isset($queryParams['service'])) {
            switch ($queryParams['service']) {
                case 'wordcounter':
                    $this->wordCounter->onClose($conn);
                    break;
                case 'soundboard':
                    $this->soundboard->onClose($conn);
                    break;
                default:
                    // Optionally handle unknown services or simply log and ignore
                    error_log("Unknown service type: " . $queryParams['service']);
                    break;
            }
        } else {
            // If no service is specified, you might choose to close the connection,
            // log a warning, or handle it in a default manner
            error_log("No service specified for connection");
        }
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);
        $action = $data['action'] ?? '';

        error_log("[Combined Handler] \$action: " . $action);

        // Route based on action
        if (strpos($action, 'word_') === 0) {
            error_log("[Combined Handler] word_ prefix");
            $this->wordCounter->onMessage($from, $msg);
        } elseif (strpos($action, 'sound_') === 0) {
            error_log("[Combined Handler] sound_ prefix");
            $this->soundboard->onMessage($from, $msg);
        } else {
            // Handle unknown action or implement a default action
            $from->send(json_encode(['error' => 'Unknown action']));
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        // Delegate to both handlers if needed
        $this->wordCounter->onError($conn, $e);
        $this->soundboard->onError($conn, $e);
    }
}
