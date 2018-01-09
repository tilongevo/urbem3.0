<?php

namespace Urbem\CoreBundle\Helper;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

class UploadHelper
{
    private $file;

    private $path;

    private $defaultPath;

    private $debug;

    private $basePath = 'var/datafiles/';

    public function __construct($debug = false)
    {
        $this->defaultPath = __DIR__ . "/../../../../{$this->basePath}" ;
        $this->debug = $debug;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     * @return UploadHelper
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     * @return UploadHelper
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @param string $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }


    /**
     * Manages the copying of the file to the relevant place on the server
     */
    public function executeUpload($name = null)
    {
        $retorno = array();
        try {
            $now = date('YmdHms');
            // dump($this->getPath());
            $caminho_final = $this->getCaminhoFinal();
            //TODO FILTRAR POR mimeType image/png
            // we use the original file name here but you should
            // sanitize it at least to avoid any security issues

            if (! is_null($name)) {
                $new_name = $name . '.jpg';
            } else {
                $new_name = $now . '_'.$this->getFile()->getClientOriginalName();
            }
            // move takes the target directory and target filename as params
            $this->getFile()->move(
                $caminho_final,
                $new_name
            );

            // set the path property to the filename where you've saved the file
            $this->filename = $this->getFile()->getClientOriginalName();
            // clean up the file property as you won't need it anymore
            $this->setFile(null);

            $retorno = array(
                'message'   => 'Upload do arquivo realizado com sucesso',
                'status'    => 'SUCCESS',
                'name'      =>  $new_name,
            );

            $retorno;
        } catch (\Exception $e) {
            $retorno = array(
                'message'   => 'Falha ao fazer o upload do arquivo',
                'status'    => 'FAILURE',
                'name'      =>  ' ',
            );
        }
        return $retorno;
    }

    public function getCaminhoFinal()
    {
        //Caminho padrao -> root/var/datafiles/<bundle>/<sub-modulo>/<seu-mundo>.jpg|mp3|xxx

        $path = trim($this->defaultPath . $this->path);
        $this->chmodRecursive($path);
        return $path;
    }

    protected function chmodRecursive($startDir)
    {
        $dirPerms = 0775;
        $filePerms = 0644;

        $str = "";
        $files = array();
        if (!file_exists($startDir)) {
            mkdir($startDir, 0777, true);
        }

        if (!is_dir($startDir)) {
            return;
        }

        $fh = opendir($startDir);
        while (($file = readdir($fh)) !== false) {
            // skip hidden files and dirs and recursing if necessary
            if (strpos($file, '.')=== 0) {
                continue;
            }

            $filepath = $startDir . '/' . $file;

            if (is_dir($filepath)) {
                //$newname = sanitize_file_name($filepath);
                $str = "chmod {$filepath} To {$dirPerms}\n";
                chmod($filepath, $dirPerms);
                chmod_recursive($filepath);
                continue;
            }
            ////$newname = sanitize_file_name($filepath);
            $str = "chmod {$filepath} tp {$filePerms}\n";
            chmod($filepath, $filePerms);
        }
        closedir($fh);
        if ($this->debug) {
            echo $str;
        }
    }
}
