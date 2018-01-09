<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * DadosRelogioPontoExtras
 */
class DadosRelogioPontoExtras
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var boolean
     */
    private $autorizarHorasExtras = false;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ponto\DadosRelogioPonto
     */
    private $fkPontoDadosRelogioPonto;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return DadosRelogioPontoExtras
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return DadosRelogioPontoExtras
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
     * Set autorizarHorasExtras
     *
     * @param boolean $autorizarHorasExtras
     * @return DadosRelogioPontoExtras
     */
    public function setAutorizarHorasExtras($autorizarHorasExtras)
    {
        $this->autorizarHorasExtras = $autorizarHorasExtras;
        return $this;
    }

    /**
     * Get autorizarHorasExtras
     *
     * @return boolean
     */
    public function getAutorizarHorasExtras()
    {
        return $this->autorizarHorasExtras;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPontoDadosRelogioPonto
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\DadosRelogioPonto $fkPontoDadosRelogioPonto
     * @return DadosRelogioPontoExtras
     */
    public function setFkPontoDadosRelogioPonto(\Urbem\CoreBundle\Entity\Ponto\DadosRelogioPonto $fkPontoDadosRelogioPonto)
    {
        $this->codContrato = $fkPontoDadosRelogioPonto->getCodContrato();
        $this->fkPontoDadosRelogioPonto = $fkPontoDadosRelogioPonto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPontoDadosRelogioPonto
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\DadosRelogioPonto
     */
    public function getFkPontoDadosRelogioPonto()
    {
        return $this->fkPontoDadosRelogioPonto;
    }
}
