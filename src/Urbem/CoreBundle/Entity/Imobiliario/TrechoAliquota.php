<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * TrechoAliquota
 */
class TrechoAliquota
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
    private $aliquotaTerritorial;

    /**
     * @var integer
     */
    private $aliquotaPredial;

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
     * @return TrechoAliquota
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
     * @return TrechoAliquota
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
     * @return TrechoAliquota
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
     * @return TrechoAliquota
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
     * @return TrechoAliquota
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
     * Set aliquotaTerritorial
     *
     * @param integer $aliquotaTerritorial
     * @return TrechoAliquota
     */
    public function setAliquotaTerritorial($aliquotaTerritorial)
    {
        $this->aliquotaTerritorial = $aliquotaTerritorial;
        return $this;
    }

    /**
     * Get aliquotaTerritorial
     *
     * @return integer
     */
    public function getAliquotaTerritorial()
    {
        return $this->aliquotaTerritorial;
    }

    /**
     * Set aliquotaPredial
     *
     * @param integer $aliquotaPredial
     * @return TrechoAliquota
     */
    public function setAliquotaPredial($aliquotaPredial)
    {
        $this->aliquotaPredial = $aliquotaPredial;
        return $this;
    }

    /**
     * Get aliquotaPredial
     *
     * @return integer
     */
    public function getAliquotaPredial()
    {
        return $this->aliquotaPredial;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioTrecho
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Trecho $fkImobiliarioTrecho
     * @return TrechoAliquota
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
     * @return TrechoAliquota
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
