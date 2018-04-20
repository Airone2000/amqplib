<?php

require './vendor/autoload.php';

$connection = new \PhpAmqpLib\Connection\AMQPStreamConnection($host = 'localhost', $port = 5672, $user = 'guest', $password = 'guest');
$channel = $connection->channel();

$channel->queue_declare($queue = 'default', $passive = false, $durable = false, $exclusive = false, $autoDelete = false);

echo "Waiting for message ...\n";

$callback = function(\PhpAmqpLib\Message\AMQPMessage $message){
    printf("Incoming message: '%s'\n", $message->body);
};

$channel->basic_consume($queue, '', false, true, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}