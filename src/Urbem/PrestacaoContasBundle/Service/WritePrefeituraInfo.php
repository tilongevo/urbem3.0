<?php

namespace Urbem\PrestacaoContasBundle\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

/**
 * Class WritePrefeituraInfo
 *
 * @package Urbem\PrestacaoContasBundle\Service
 */
class WritePrefeituraInfo
{
    private $parameterFilePath;

    private $fileSystem;

    /**
     * WritePrefeituraInfo constructor.
     *
     * @param            $parameterFilePath
     * @param Filesystem $filesystem
     */
    public function __construct($parameterFilePath, Filesystem $filesystem)
    {
        $this->parameterFilePath = $parameterFilePath;
        $this->fileSystem = $filesystem;
    }

    /**
     * @return bool
     */
    public function exists()
    {
        if (!$this->fileSystem->exists($this->parameterFilePath)) {
            $content = [];
            $content["uf"] = "NI";
            $content["nome"] = "Prefeitura NI";
            $content["email"] = "suporte@cnm.org.br";
            $content["email_assunto"] = "Portal da Transparencia";

            $dir = explode("/", $this->parameterFilePath);
            array_pop($dir);

            $this->fileSystem->mkdir(implode("/", $dir), 0777);
            return file_put_contents($this->parameterFilePath, Yaml::dump($content));
        }

        return true;
    }

    /**
     * @return mixed
     */
    private function getFileContents()
    {
        return Yaml::parse(file_get_contents($this->parameterFilePath));
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function write($key, $value)
    {
        if ($this->exists()) {
            $content = $this->getFileContents();

            $content[$key] = $value;

            file_put_contents($this->parameterFilePath, Yaml::dump($content));
        }
        return $this;
    }
}
