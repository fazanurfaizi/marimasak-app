<?php

namespace App\Websocket;

use Redis;
use Predis\Client;
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\WampServerInterface;

class Pusher implements WampServerInterface {

    public function __construct($loop) {
        $redis_host = config('database.redis.default.host');
        $redis_port = config('database.redis.default.port');
        try {
            $client = new Client([
                'scheme' => 'tcp',
                'host'   => $redis_host,
                'port'   => $redis_port,
                'read_write_timeout' => 0
            ]);
            $pubsub = $client->pubSubLoop();
            $pubsub->subscribe('WampMessage');
            foreach ($pubsub as $message) {
                switch ($message->kind) {
                    case 'subscribe':
                        echo "Subscribed to {$message->channel}", PHP_EOL;
                        break;

                    case 'message':
                        $payload = json_decode($event->payload, true);
                        $message = json_encode($payload['data']['message']);
                        $client->publish('WampMessage', $payload);
                        Chat::getInstance()->broadcast($message);
                        break;
                }
            }
        }
        catch (Exception $e) {
            die ($e->getMessage());
        }
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
