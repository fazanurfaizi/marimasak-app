<?php

namespace App\Websocket;

use Ratchet\ConnectionInterface;
use Ratchet\Wamp\WampServerInterface;

class Pusher implements WampServerInterface {

    public function __construct($loop) {
        $redis_host = config('database.redis.default.host');
        $redis_port = config('database.redis.default.port');
        $client = new \Predis\Async\Client('tcp://127.0.0.1:6379', $loop);
        $client->connect(function($client) use ($loop) {
            $logger = null;
            $client->pubSubLoop('WampMessage', function($event) use ($logger) {
                $payload = json_decode($event->payload, true);
                $message = json_encode($payload['data']['message']);
                Chat::getInstance()->broadcast($message);
            });
            Log::v(' ', $loop, 'Connectted to Redis.');
        });

        $client->getEventLoop()->run();
    }

    public function onOpen(ConnectionInterface $conn)
    {
    }

    public function onClose(ConnectionInterface $conn)
    {
    }

    public function onSubscribe(ConnectionInterface $conn, $topic)
    {
    }

    public function onUnSubscribe(ConnectionInterface $conn, $topic)
    {
    }

    public function onCall(ConnectionInterface $conn, $id, $topic, array $params)
    {
    }

    public function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible)
    {
        // $topic->broadcast($event);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
    }

}
