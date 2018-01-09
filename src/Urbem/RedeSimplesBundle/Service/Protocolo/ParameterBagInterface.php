<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo;

interface ParameterBagInterface
{
    /**
     * @param $name
     */
    public function get($name);

    /**
     * @param $name
     * @param $value
     */
    public function set($name, $value);

    /**
     * @param $key
     * @return boolean
     */
    public function has($key);
}
