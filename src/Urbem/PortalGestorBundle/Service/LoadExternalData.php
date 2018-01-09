<?php

namespace Urbem\PortalGestorBundle\Service;

/**
 * Class LoadExternalData
 * @package Urbem\PortalGestorBundle\Service
 */
class LoadExternalData
{
    /**
     * @var
     */
    private $parameterFilePath;

    /**
     * @var int
     */
    private $daysDeleteFile = 7;

    /**
     * LoadExternalData constructor.
     * @param $parameterFilePath
     */
    public function __construct($parameterFilePath)
    {
        $this->parameterFilePath = $parameterFilePath;
    }

    public function setDaysDeleteFile($days) {
        $this->daysDeleteFile = $days;
    }

    /**
     * @param $filename
     */
    private function deleteOldFile($filename) {
        if (!file_exists($filename)) {
            return;
        }

        $datetime1 = new \DateTime(date("Y-m-d", filemtime($filename)));
        $datetime2 = new \DateTime(date("Y-m-d"));

        if ($datetime1->diff($datetime2)->days >= $this->daysDeleteFile) {
            unlink($filename);
        }
    }

    /**
     * @param $url
     * @param $storageFileName
     * @return mixed|null
     */
    protected function getDataExternalSite($url, $storageFileName) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        curl_close($ch);

        if ($curl_errno) {
            return null;
        }

        if ($storageFileName) {
            file_put_contents($storageFileName, $content);
        }

        return $content;
    }

    /**
     * @param $storageFileName
     * @return null|string
     */
    protected function getContentFile($storageFileName) {
        $this->deleteOldFile($storageFileName);
        return file_exists($storageFileName) ? file_get_contents($storageFileName) : null;
    }

    /**
     * @param $url
     * @param $storageFileName
     * @return array
     */
    public function getContentExternalData($url, $storageFileName) {
        $storageFileName = $this->parameterFilePath . DIRECTORY_SEPARATOR . $storageFileName;
        if (!$content = $this->getContentFile($storageFileName)) {
            $content = $this->getDataExternalSite($url, $storageFileName);
        }

        return $this->getContentDOMXPath($content);
    }

    /**
     * @param $content
     * @return array
     */
    protected function getContentDOMXPath($content) {
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = false;

        libxml_use_internal_errors(true);
        $dom->loadHTML($content);

        return [$dom, new \DOMXPath($dom)];
    }
}