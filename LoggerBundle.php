<?php


namespace CashierLogger\LoggerBundle;


use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\HttpFoundation\Response;

class LoggerBundle
{
    public function test()
    {
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'rabbitmq', 'rabbitmq');
        $channel = $connection->channel();

        $channel->queue_declare('log', false, true, false, false);

        $msg = new AMQPMessage('Hello World!',
            ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]
        );

        $channel->basic_publish($msg, '', 'log');

        $channel->close();
        $connection->close();
    }
}