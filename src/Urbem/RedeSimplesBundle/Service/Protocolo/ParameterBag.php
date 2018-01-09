<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo;

class ParameterBag implements ParameterBagInterface
{
    const ENDPOINT_FETCH = 'endpoint.fetch';
    const ENDPOINT_POST = 'endpoint.post';
    const ENDPOINT_STATUS = 'endpoint.status';
    const ENDPOINT_TOKEN = 'endpoint.token';
    const CACHE_KEY = 'cache_key';

    protected $parameters = [];

    /**
     * ParameterBag constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    /**
     * @param $name
     * @return mixed the parameter
     */
    public function get($name)
    {
        if (false === is_string($name) && false === is_integer($name)) {
            throw new \InvalidArgumentException(sprintf(
                '$name needs to be string or integer but %s was given',
                true === is_object($name) ? get_class($name) : gettype($name)
            ));
        }

        $found = null;
        $first = true;

        foreach (explode('.', $name) as $parameter) {
            if (true === $first) {
                $found = $this->parameters;
                $first = false;
            }

            if (false === is_array($found)) {
                throw new \InvalidArgumentException(sprintf(
                    '%s expected to be an array but %s was given on %s',
                    $parameter,
                    true === is_object($found) ? get_class($found) : gettype($found),
                    $name
                ));
            }

            if (false === array_key_exists($parameter, $found)) {
                throw new \InvalidArgumentException(sprintf(
                    '%s (%s) not found on %s',
                    $parameter,
                    $name,
                    implode(', ', array_keys($found))
                ));
            }

            $found = $found[$parameter];
        }

        return $found;
    }

    /**
     * @param $name
     * @param $value
     */
    public function set($name, $value)
    {
        $this->parameters[$name] = $value;
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return true === array_key_exists($key, $this->parameters);
    }
}
