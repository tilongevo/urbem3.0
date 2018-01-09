<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * OrdemAlfabetica
 */
class OrdemAlfabetica
{
    /**
     * PK
     * @var integer
     */
    private $numLetra;

    /**
     * @var string
     */
    private $letra;


    /**
     * Set numLetra
     *
     * @param integer $numLetra
     * @return OrdemAlfabetica
     */
    public function setNumLetra($numLetra)
    {
        $this->numLetra = $numLetra;
        return $this;
    }

    /**
     * Get numLetra
     *
     * @return integer
     */
    public function getNumLetra()
    {
        return $this->numLetra;
    }

    /**
     * Set letra
     *
     * @param string $letra
     * @return OrdemAlfabetica
     */
    public function setLetra($letra)
    {
        $this->letra = $letra;
        return $this;
    }

    /**
     * Get letra
     *
     * @return string
     */
    public function getLetra()
    {
        return $this->letra;
    }
}
