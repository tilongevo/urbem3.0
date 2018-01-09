<?php

namespace Urbem\CoreBundle\Helper;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;

class LoadFileHelper
{
    private $defaultPath;

    private $fileName;

    private $module;

    private $bundle;

    private $isDownload = false;

    /**
     * LoadFileHelper constructor.
     *
     * @param string       $defaultPath
     */
    public function __construct($defaultPath)
    {
        $this->defaultPath = $defaultPath;
    }


    /**
     * Get the value of File
     *
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set the value of File
     *
     * @param mixed $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * Get the value of Module
     *
     * @return mixed
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Set the value of Module
     *
     * @param mixed $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * Get the value of Bundle
     *
     * @return mixed
     */
    public function getBundle()
    {
        return $this->bundle;
    }

    /**
     * Set the value of Bundle
     *
     * @param mixed $bundle
     */
    public function setBundle($bundle)
    {
        $this->bundle = $bundle;
    }

    /**
     * Get the value of Is Download
     *
     * @return mixed
     */
    public function getIsDownload()
    {
        return $this->isDownload;
    }

    /**
     * Set the value of Is Download
     *
     * @param mixed $isDownload
     */
    public function setIsDownload($isDownload)
    {
        $this->isDownload = $isDownload;
    }

    private function getFilePath()
    {
        $fileName = implode(DIRECTORY_SEPARATOR, [
            $this->defaultPath,
            $this->bundle,
            $this->module,
            $this->fileName
        ]);

        if (!file_exists($fileName)) {
            throw new \Exception("Arquivo ".$this->getFileName()." não encontrado!");
        }

        return $fileName;
    }

    /**
     * @return Response
     */
    public function getFile()
    {
        $fileName = $this->getFilePath();

        // Generate response
        $response = new Response();

        // Set headers
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', mime_content_type($fileName));

        if ($this->getIsDownload()) {
            $response->headers->set('Content-Disposition', 'attachment; filename="' . basename($fileName) . '";');
        }

        $response->headers->set('Content-length', filesize($fileName));

        // Send headers before outputting anything
        $response->sendHeaders();
        $response->setContent(file_get_contents($fileName));
        $response->send();

        return $response;
    }
}
