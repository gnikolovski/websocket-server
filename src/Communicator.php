<?php

namespace App;

use Ratchet\MessageComponentInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Ratchet\ConnectionInterface;

class Communicator implements MessageComponentInterface {

    protected $clients;
    protected $log;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->log = new Logger('general');
        $this->log->pushHandler(new StreamHandler('server.log', Logger::DEBUG));
    }

    public function onOpen(ConnectionInterface $connection) {
        $this->clients->attach($connection);

        $log_entry = sprintf('New client connection! ID: %s, IP: %s',
            $connection->resourceId, $connection->remoteAddress);

        $this->log->info($log_entry);
    }

    public function onMessage(ConnectionInterface $from, $message) {
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($message);

                $log_entry = sprintf('Client (ID: %s, IP: %s) sent message: %s',
                    $client->resourceId, $client->remoteAddress, $message);

                $this->log->info($log_entry);
            }
        }
    }

    public function onClose(ConnectionInterface $connection) {
        $this->clients->detach($connection);

        $log_entry = sprintf('Client (ID: %s, IP: %s) has disconnected',
            $connection->resourceId, $connection->remoteAddress);

        $this->log->info($log_entry);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $log_entry = sprintf('An error has occurred: %s', $e->getMessage());

        $this->log->error($log_entry);

        $conn->close();
    }

}
