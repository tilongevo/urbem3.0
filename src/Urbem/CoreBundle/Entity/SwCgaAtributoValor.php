<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwCgaAtributoValor
 */
class SwCgaAtributoValor
{
    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwAtributoCgm
     */
    private $fkSwAtributoCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCga
     */
    private $fkSwCga;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return SwCgaAtributoValor
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return SwCgaAtributoValor
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return SwCgaAtributoValor
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return SwCgaAtributoValor
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
     * Set fkSwAtributoCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwAtributoCgm $fkSwAtributoCgm
     * @return SwCgaAtributoValor
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

    /**
     * ManyToOne (inverse side)
     * Set fkSwCga
     *
     * @param \Urbem\CoreBundle\Entity\SwCga $fkSwCga
     * @return SwCgaAtributoValor
     */
    public function setFkSwCga(\Urbem\CoreBundle\Entity\SwCga $fkSwCga)
    {
        $this->numcgm = $fkSwCga->getNumcgm();
        $this->timestamp = $fkSwCga->getTimestamp();
        $this->fkSwCga = $fkSwCga;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCga
     *
     * @return \Urbem\CoreBundle\Entity\SwCga
     */
    public function getFkSwCga()
    {
        return $this->fkSwCga;
    }
}
