<?php

namespace Urbem\CoreBundle\Services\Logger;

use Gelf\Logger as GelfLogger;
use Gelf\Transport\UdpTransport;
use Gelf\Publisher;

class Thundera extends GelfLogger
{
    protected static $_publisher;
    protected static $_instance;
    protected static $_graylogServer;
    protected static $_graylogPort;

    public static function getInstance($graylogServer, $graylogPort) {

        self::$_graylogServer = $graylogServer;
        self::$_graylogPort = $graylogPort;

        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct()
    {
        $transport = new UdpTransport(self::$_graylogServer, self::$_graylogPort, UdpTransport::CHUNK_SIZE_LAN);

        self::$_publisher = new Publisher();
        self::$_publisher->addTransport($transport);

        parent::__construct(self::$_publisher);
    }

    public static function send($message)
    {
        self::$_publisher->publish($message);
    }
}
