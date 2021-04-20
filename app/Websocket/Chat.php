<?php

namespace App\Websocket;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Illuminate\Support\Facades\Redis;
use stdClass;
use Exception;
use SplObjectStorage;

class Chat implements MessageComponentInterface {

    protected $clients;
    private static $instance;

    public function __construct() {
        $this->clients = new SplObjectStorage;
        self::$instance = $this;
    }

    public static function getInstance() {
        return self::$instance;
    }

    public function broadcast($message) {
        foreach ($this->clients as $client) {
            $client->send($message);
            Log::v('S', $client, "sending message \"{$message}\"");
        }
    }

    public function onOpen(ConnectionInterface $conn) {
        try {
            // Store the new connection to send messages to later
            $this->clients->attach($conn);
            $conn->send('welcome');
            Log::v('S', $conn, 'welcome');

            $request = (array)$conn->WebSocket->request;
            $request = (array)array_get($request, "\0*\0headers");
            $request = (array)array_get($request, "\0*\0headers.user-agent");
            $request = array_get($request, "\0*\0values.0");
            $request = (empty($request)) ? 'unknown' : $request;
            Log::v('R', $conn, "new client({$conn->resourceId}) on {$conn->remoteAddress}({$request})");
        } catch (Exception $e) {
            Log::e($e);
        }
    }

    public function onMessage(ConnectionInterface $from, $message) {
        try {
            Log::v('R', $from, "receiving message \"{$message}\"");
            $numRecv = count($this->clients) - 1;
            foreach ($this->clients as $client) {
                if ($from !== $client) {
                    // The sender is not the receiver, send to each client connected
                    $client->send($message);
                    Log::v('S', $client, "sending message \"{$message}\"");
                }
            }
        } catch (Exception $e) {
            Log::e($e);
        }
    }

    public function onClose(ConnectionInterface $conn) {
        try {
            $this->clients->detach($conn);
            Log::v('R', $conn, 'close', "Client({$conn->resourceId}) has disconnected");
        } catch (Exception $e) {
            Log::e($e);
        }
    }

    public function onError(ConnectionInterface $conn, Exception $e) {
        Log::e($e);
        $conn->close();
    }

}
