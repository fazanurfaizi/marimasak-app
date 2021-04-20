<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Server\EchoServer;
use React\EventLoop\Factory as ReactFactory;
use React\Socket\Server as ReactServer;
use App\Websocket\Chat;
use App\Websocket\Log;
use App\Websocket\Pusher;

class WsChatCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websocket:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start Websocket Service.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $port = 9000;
        $uri = '127.0.0.1:9000';
        $loop = ReactFactory::create();

        $websocket = new ReactServer('127.0.0.1:8080', $loop);
        $echo = new WsServer(new EchoServer);
        $echo->enableKeepAlive($loop, 120);

        $pusher = new Pusher($loop);

        $webServer = new IoServer(
            new HttpServer(
                new WsServer(
                    new Chat($pusher)
                )
            ),
            $websocket
        );

        Log::v(' ', $loop, "Starting Websocket Service on port : " . $port);
        $loop->run();
    }
}
