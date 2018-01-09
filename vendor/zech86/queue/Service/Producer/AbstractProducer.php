<?php

namespace Zechim\QueueBundle\Service\Producer;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

abstract class AbstractProducer
{
    /**
     * @var array
     */
    protected $parameters;

    /**
     * @var AMQPChannel
     */
    protected $channel;

    /**
     * @var AMQPStreamConnection
     */
    protected $connection;

    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return AMQPChannel
     */
    private function getChannel()
    {
        if (null !== $this->channel) {
            return $this->channel;
        }

        $this->channel = $this->createConnection()->channel();

        return $this->channel;
    }

    /**
     * @param $exchangeName
     * @param $routingKey
     * @return AMQPChannel
     */
    private function createExchange($exchangeName, $routingKey)
    {
        $channel = $this->getChannel();
        $channel->exchange_declare(
            $exchangeName,
            'x-delayed-message',
            false,  /* passive, create if exchange doesn't exist */
            true,   /* durable, persist through server reboots */
            false,  /* autodelete */
            false,  /* internal */
            false,  /* nowait */
            [
                'x-delayed-type' => ['S', 'direct']
            ]
        );

        $channel->queue_declare($routingKey, false, true, false, false);
        $channel->queue_bind($routingKey, $exchangeName, $routingKey);

        return $channel;
    }

    /**
     * @return AMQPStreamConnection
     */
    private function createConnection()
    {
        if (null !== $this->connection) {
            return $this->connection;
        }

        return $this->connection = new AMQPStreamConnection(
            $this->parameters['host'],
            $this->parameters['port'],
            $this->parameters['user'],
            $this->parameters['password']
        );
    }

    protected function close()
    {
        if (null !== $this->channel) {
            $this->channel->close();
            $this->channel = null;
        }

        if (null !== $this->connection) {
            $this->connection->close();
            $this->connection = null;
        }
    }

    /**
     * @param array $message
     * @param \DateInterval|null $interval
     */
    protected function doPublish(array $message, \DateInterval $interval = null)
    {
        $interval = null === $interval ? new \DateInterval('PT0S') : $interval;
        $interval = ((($interval->y * 365.25 + $interval->m * 30 + $interval->d) * 24 + $interval->h) * 60 + $interval->i)*60 + $interval->s;
        $interval = (int) $interval * 1000;

        $message = new AMQPMessage(
            json_encode($message),
            [
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
                'content_type' => 'application/json',
                'application_headers' => new AMQPTable(['x-delay' => $interval])
            ]
        );

        $exchange = $this->parameters['exchange'];
        $routingKey = $this->parameters['routing_key'];

        $this->createExchange($exchange, $routingKey)->basic_publish($message, $exchange, $routingKey);
        $this->close();
    }

    abstract function publish($name, array $options = [], \DateInterval $interval = null);
}
