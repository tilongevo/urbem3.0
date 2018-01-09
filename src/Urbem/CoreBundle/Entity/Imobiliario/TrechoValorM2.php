<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * TrechoValorM2
 */
class TrechoValorM2
{
    /**
     * PK
     * @var integer
     */
    private $codLogradouro;

    /**
     * PK
     * @var integer
     */
    private $codTrecho;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var \DateTime
     */
    private $dtVigencia;

    /**
     * @var integer
     */
    private $valorM2Territorial;

    /**
     * @var integer
     */
    private $valorM2Predial;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Trecho
     */
    private $fkImobiliarioTrecho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codLogradouro
     *
     * @param integer $codLogradouro
     * @return TrechoValorM2
     */
    public function setCodLogradouro($codLogradouro)
    {
        $this->codLogradouro = $codLogradouro;
        return $this;
    }

    /**
     * Get codLogradouro
     *
     * @return integer
     */
    public function getCodLogradouro()
    {
        return $this->codLogradouro;
    }

    /**
     * Set codTrecho
     *
     * @param integer $codTrecho
     * @return TrechoValorM2
     */
    public function setCodTrecho($codTrecho)
    {
        $this->codTrecho = $codTrecho;
        return $this;
    }

    /**
     * Get codTrecho
     *
     * @return integer
     */
    public function getCodTrecho()
    {
        return $this->codTrecho;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return TrechoValorM2
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return TrechoValorM2
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set dtVigencia
     *
     * @param \DateTime $dtVigencia
     * @return TrechoValorM2
     */
    public function setDtVigencia(\DateTime $dtVigencia)
    {
        $this->dtVigencia = $dtVigencia;
        return $this;
    }

    /**
     * Get dtVigencia
     *
     * @return \DateTime
     */
    public function getDtVigencia()
    {
        return $this->dtVigencia;
    }

    /**
     * Set valorM2Territorial
     *
     * @param integer $valorM2Territorial
     * @return TrechoValorM2
     */
    public function setValorM2Territorial($valorM2Territorial)
    {
        $this->valorM2Territorial = $valorM2Territorial;
        return $this;
    }

    /**
     * Get valorM2Territorial
     *
     * @return integer
     */
    public function getValorM2Territorial()
    {
        return $this->valorM2Territorial;
    }

    /**
     * Set valorM2Predial
     *
     * @param integer $valorM2Predial
     * @return TrechoValorM2
     */
    public function setValorM2Predial($valorM2Predial)
    {
        $this->valorM2Predial = $valorM2Predial;
        return $this;
    }

    /**
     * Get valorM2Predial
     *
     * @return integer
     */
    public function getValorM2Predial()
    {
        return $this->valorM2Predial;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioTrecho
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Trecho $fkImobiliarioTrecho
     * @return TrechoValorM2
     */
    public function setFkImobiliarioTrecho(\Urbem\CoreBundle\Entity\Imobiliario\Trecho $fkImobiliarioTrecho)
    {
        $this->codTrecho = $fkImobiliarioTrecho->getCodTrecho();
        $this->codLogradouro = $fkImobiliarioTrecho->getCodLogradouro();
        $this->fkImobiliarioTrecho = $fkImobiliarioTrecho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioTrecho
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Trecho
     */
    public function getFkImobiliarioTrecho()
    {
        return $this->fkImobiliarioTrecho;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return TrechoValorM2
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }
}
