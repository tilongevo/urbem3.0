<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo\Cache;

use Doctrine\Common\Collections\ArrayCollection;

class ArrayCollectionCache implements CacheInterface
{
    /**
     * @var ArrayCollection
     */
    protected $cache;

    public function __construct()
    {
        $this->cache = new ArrayCollection();
    }

    /**
     * @param string|integer $key
     *
     * @return boolean
     */
    public function has($key)
    {
        return true === $this->cache->containsKey($key);
    }

    /**
     * @param string|integer $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return $this->cache->get($key);
    }

    /**
     * @param string|integer $key
     * @param string $value
     */
    public function set($key, $value)
    {
        $this->cache->set($key, $value);
    }

    /**
     * @param string|integer $key
     */
    public function remove($key)
    {
        $this->cache->remove($key);
    }
}
