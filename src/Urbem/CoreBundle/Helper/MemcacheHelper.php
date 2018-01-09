<?php
namespace Urbem\CoreBundle\Helper;

use Lsw\MemcacheBundle\Cache\AntiDogPileMemcache;

class MemcacheHelper
{
    private $memcache;

    public function __construct(AntiDogPileMemcache $memcache)
    {
        $this->memcache = $memcache;
    }

    public function set($name, $data, $flag = 0, $timeToLive = 86400)
    {
        return $this->memcache->set($name, $data, $flag, $timeToLive);
    }

    public function get($name)
    {
        return $this->memcache->get($name);
    }
}
