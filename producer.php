<?php

/**
 * Procuder produces a message.
 * It sends it to the broker.
 * Broker receives it in the "exchange" place
 * where it decides which queue the message have to be dropped in.
 */

require './vendor/autoload.php';

$connection = new \PhpAmqpLib\Connection\AMQPStreamConnection($host = 'localhost', $port = 5672, $user = 'guest', $password = 'guest');
$channel = $connection->channel();

$channel->queue_declare($queue = 'default', $passive = false, $durable = false, $exclusive = false, $autoDelete = false);

$body = 'My message body';
$message = new \PhpAmqpLib\Message\AMQPMessage($body);
$channel->basic_publish($message, '', $queue);

printf("Message sent: '%s'\n", $body);

$channel->close();
$connection->close();
