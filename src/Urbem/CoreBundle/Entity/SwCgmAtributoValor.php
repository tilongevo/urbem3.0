<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwCgmAtributoValor
 */
class SwCgmAtributoValor
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwAtributoCgm
     */
    private $fkSwAtributoCgm;


    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return SwCgmAtributoValor
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return SwCgmAtributoValor
     */
    public function setCodAtributo($codAtributo)
    {
        $this->codAtributo = $codAtributo;
        return $this;
    }

    /**
     * Get codAtributo
     *
     * @return integer
     */
    public function getCodAtributo()
    {
        return $this->codAtributo;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return SwCgmAtributoValor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return SwCgmAtributoValor
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwAtributoCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwAtributoCgm $fkSwAtributoCgm
     * @return SwCgmAtributoValor
     */
    public function setFkSwAtributoCgm(\Urbem\CoreBundle\Entity\SwAtributoCgm $fkSwAtributoCgm)
    {
        $this->codAtributo = $fkSwAtributoCgm->getCodAtributo();
        $this->fkSwAtributoCgm = $fkSwAtributoCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwAtributoCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwAtributoCgm
     */
    public function getFkSwAtributoCgm()
    {
        return $this->fkSwAtributoCgm;
    }
}
