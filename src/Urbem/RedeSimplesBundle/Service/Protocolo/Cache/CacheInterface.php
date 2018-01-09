<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo\Cache;

interface CacheInterface
{
    /**
     * @param string|integer $key
     *
     * @return boolean
     */
    public function has($key);

    /**
     * @param string|integer $key
     *
     * @return mixed
     */
    public function get($key);

    /**
     * @param string|integer $key
     * @param string $value
     */
    public function set($key, $value);

    /**
     * @param string|integer $key
     */
    public function remove($key);
}