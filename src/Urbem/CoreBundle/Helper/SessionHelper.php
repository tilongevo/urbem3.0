<?php

namespace Urbem\CoreBundle\Helper;
use Symfony\Component\HttpFoundation\Session\Session;

class SessionHelper
{
    public static function get($parameter) {
        $session = new Session();
        session_status() === PHP_SESSION_NONE ? $session->start() : null;

        return $session->get($parameter);
    }
}