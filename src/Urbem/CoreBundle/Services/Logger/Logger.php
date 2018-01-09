<?php

namespace Urbem\CoreBundle\Services\Logger;

use Psr\Log;

class Logger extends Log\AbstractLogger
{
    const FORM = 'form_data';
    const RESPONSE = 'response_data';
    const REQUEST = 'request_data';
    const JSON_DATA = 'data';
    const ENTITY = 'entity';
    const ROUTE = 'route';
    const CLIENT_ADDRESS = 'client_address';
    const MSG = 'msg';
    const WHO_ID = 'who_id';
    const WHO_NAME = 'who_name';
    const WHO_EMAIL = 'who_email';
    const WHOSE_COMPANY_ID = "whose_company_id";
    const WHOSE_COMPANY_NAME = "whose_company";

    public function log($level, $message, array $context = array())
    {
        $context = $this->flatten($context);
        $fullMessage = $this->interpolate($message, $context);
        return $this->register($level, $fullMessage, $context);
    }

    private function interpolate($message, array $context = array())
    {
        $replace = array();
        foreach ($context as $key => $val) {
            $replace['{' . $key . '}'] = $val;
        }

        return strtr($message, $replace);
    }

    public function flatten($context = [])
    {
        $flattened = [];

        foreach ($context as $key => $value) {
            if (is_scalar($value) || is_null($value)) {
                $value = utf8_encode($value);
            } elseif (is_array($value) || $value instanceof \Traversable) {
                $value = json_encode($this->flatten($value));
            } elseif (is_object($value)) {
                $value = json_encode($value);
            } elseif (is_resource($value)) {
                $value = get_resource_type($value);
            }

            $flattened[utf8_encode($key)] = $value;
        }

        return $flattened;
    }

    public function register($level, $message, array $context = array())
    {
        //extend to implement this method
    }
}
