<?php

namespace Urbem\CoreBundle\Services;

use Psr\Log;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Urbem\CoreBundle\Services\Logger;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Urbem\PrestacaoContasBundle\Service\Prefeitura\Info;
use Gelf;
use Urbem\CoreBundle\Entity\Administracao\Usuario;

class ThunderaLoggerService extends Logger\Logger
{
    public static $loggerInstance;
    public static $security;
    public static $session;
    public static $route;
    public static $request;
    public static $info;

    public function __construct(
        ContainerInterface $container,
        Info $info,
        TokenStorage $security,
        Router $route,
        RequestStack $request
    ) {
        if (!$container->hasParameter('log_api_host') || !$container->hasParameter('log_api_port')) {
            return;
        }

        self::$loggerInstance = Logger\Thundera::getInstance(
            $container->getParameter('log_api_host'),
            $container->getParameter('log_api_port')
        );
        self::$security = $security;
        self::$session = $container->get('session');
        self::$route = $route;
        self::$request = $request;
        self::$info = $info;
    }

    public static function send($data, $shortMessage = null, $entity = null)
    {
        $message = new Gelf\Message();
        $message->setShortMessage($shortMessage);
        self::setUser($message);
        self::setHost($message);

        if (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR'])) {
            $message->setAdditional(Logger\Logger::CLIENT_ADDRESS, $_SERVER['REMOTE_ADDR']);
        }

        $router = self::$route;
        if (!empty($router)) {
            $route = $router->getContext()->getPathInfo();
            $message->setAdditional(Logger\Logger::ROUTE, $route);
        }

        $request = self::$request;
        if (!empty($request)) {
            $request = $request->getCurrentRequest();
            $requestData = json_encode($request->attributes->all(), true);
            if (!empty($requestData)) {
                $message->setAdditional(Logger\Logger::REQUEST, $requestData);
            }
        }

        $prefecture = self::$info;
        if (!empty($prefecture)) {
            $prefectureName = $prefecture->getNomePrefeitura();
            if (!empty($prefectureName)) {
                $message->setAdditional(Logger\Logger::WHOSE_COMPANY_NAME, $prefectureName);
                $message->setShortMessage($prefectureName);
            }
        }

        if (!empty($data)) {
            if (is_array($data)) {
                foreach ($data as $key => $value) {
                    if (empty($value)) {
                        continue;
                    }

                    $message->setAdditional(".{$key}", is_array($value) ? json_encode($value, true) : $value);
                }
            } else {
                $message->setAdditional(Logger\Logger::MSG, $data);
            }
        }

        if ($entity) {
            $message->setAdditional(Logger\Logger::ENTITY, $entity);
        }

        $message->setLevel(\Psr\Log\LogLevel::DEBUG);

        self::$loggerInstance->send($message);

        return $message;
    }

    private static function setUser(Gelf\Message $message)
    {
        if (!self::$security->getToken()) {
            return false;
        }

        $user = self::$security->getToken()->getUser();
        if ($user instanceof Usuario) {
            $message->setAdditional(Logger\Logger::WHO_ID, "{$user->getId()}");
            $message->setAdditional(Logger\Logger::WHO_NAME, $user->getUsername());
            $message->setAdditional(Logger\Logger::WHO_EMAIL, $user->getEmail());
        }

        return $message;
    }

    private static function setHost(Gelf\Message $message)
    {
        if (isset($_SERVER["HTTP_HOST"]) && !empty($_SERVER["HTTP_HOST"])) {
            $message->setHost($_SERVER['HTTP_HOST']);
        }

        return $message;
    }

    public static function sendToCommands($data = array(), $host = '', $shortMessage = null, $entity = null)
    {
        $message = new Gelf\Message();
        $message->setShortMessage($shortMessage);
        $message->setHost($host);
        $message->setAdditional(Logger\Logger::WHO_NAME, 'System');
        $message->setLevel(\Psr\Log\LogLevel::DEBUG);

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $message->setAdditional($key, $value);
            }
        }

        if ($entity) {
            $message->setAdditional(Logger\Logger::ENTITY, $entity);
        }

        self::$loggerInstance->send($message);
    }

    public function register($level, $message, array $context = array())
    {
        $grayLogMessage = new Gelf\Message();
        $grayLogMessage->setAdditional(Logger\Logger::JSON_DATA, json_encode($context));
        self::setUser($grayLogMessage);
        self::setHost($grayLogMessage);
        $grayLogMessage->setLevel($level);
        $grayLogMessage->setShortMessage($message);
        self::$loggerInstance->send($grayLogMessage);

        return $grayLogMessage;
    }
}

