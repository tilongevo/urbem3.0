<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwNormaCopiaDigitalNorma
 */
class SwNormaCopiaDigitalNorma
{
    /**
     * PK
     * @var integer
     */
    private $codCopia;

    /**
     * @var string
     */
    private $arquivo;


    /**
     * Set codCopia
     *
     * @param integer $codCopia
     * @return SwNormaCopiaDigitalNorma
     */
    public function setCodCopia($codCopia)
    {
        $this->codCopia = $codCopia;
        return $this;
    }

    /**
     * Get codCopia
     *
     * @return integer
     */
    public function getCodCopia()
    {
        return $this->codCopia;
    }

    /**
     * Set arquivo
     *
     * @param string $arquivo
     * @return SwNormaCopiaDigitalNorma
     */
    public function setArquivo($arquivo = null)
    {
        $this->arquivo = $arquivo;
        return $this;
    }

    /**
     * Get arquivo
     *
     * @return string
     */
    public function getArquivo()
    {
        return $this->arquivo;
    }
}
