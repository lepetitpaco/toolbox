<?php

namespace RealTime\App; // Use the appropriate namespace for your project

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use RealTime\WordCounter\WordCounter;
use RealTime\Soundboard\Soundboard;

class CombinedHandler implements MessageComponentInterface {
    protected $wordCounter;
    protected $soundboard;

    public function __construct($dbConnection) {
        $this->wordCounter = new WordCounter($dbConnection);
        $this->soundboard = new Soundboard($dbConnection);
    }

    public function onOpen(ConnectionInterface $conn) {
        // Delegate to both handlers if needed
        $this->wordCounter->onOpen($conn);
        $this->soundboard->onOpen($conn);
    }

    public function onClose(ConnectionInterface $conn) {
        // Delegate to both handlers if needed
        $this->wordCounter->onClose($conn);
        $this->soundboard->onClose($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
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

    public function onError(ConnectionInterface $conn, \Exception $e) {
        // Delegate to both handlers if needed
        $this->wordCounter->onError($conn, $e);
        $this->soundboard->onError($conn, $e);
    }
}
