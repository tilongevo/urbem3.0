<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo\Cache;

class FileCache implements CacheInterface
{
    /**
     * @var string
     */
    protected $dir;

    public function __construct($dir)
    {
        $this->dir = rtrim($dir, '/\\') . DIRECTORY_SEPARATOR;

        if (false === is_dir($this->dir)) {
            mkdir($this->dir, 0775, true);
        }
    }

    /**
     * @param $key
     * @return string $this->dir.$key.cache
     */
    protected function getFileName($key)
    {
        return sprintf('%s%s.cache', $this->dir, $key);
    }

    /**
     * @param string|integer $key
     *
     * @return boolean
     */
    public function has($key)
    {
        return true === file_exists($this->getFileName($key));
    }

    /**
     * @param string|integer $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return file_get_contents($this->getFileName($key));
    }

    /**
     * @param string|integer $key
     * @param string $value
     */
    public function set($key, $value)
    {
        file_put_contents($this->getFileName($key), $value);
    }

    /**
     * @param string|integer $key
     */
    public function remove($key)
    {
        unlink($this->getFileName($key));
    }
}