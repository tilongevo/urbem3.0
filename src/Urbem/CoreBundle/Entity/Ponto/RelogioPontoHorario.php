<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * RelogioPontoHorario
 */
class RelogioPontoHorario
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var integer
     */
    private $codPonto;

    /**
     * PK
     * @var integer
     */
    private $codHorario;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $hora;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ponto\RelogioPontoDias
     */
    private $fkPontoRelogioPontoDias;

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
     * @return RelogioPontoHorario
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
     * Set codPonto
     *
     * @param integer $codPonto
     * @return RelogioPontoHorario
     */
    public function setCodPonto($codPonto)
    {
        $this->codPonto = $codPonto;
        return $this;
    }

    /**
     * Get codPonto
     *
     * @return integer
     */
    public function getCodPonto()
    {
        return $this->codPonto;
    }

    /**
     * Set codHorario
     *
     * @param integer $codHorario
     * @return RelogioPontoHorario
     */
    public function setCodHorario($codHorario)
    {
        $this->codHorario = $codHorario;
        return $this;
    }

    /**
     * Get codHorario
     *
     * @return integer
     */
    public function getCodHorario()
    {
        return $this->codHorario;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return RelogioPontoHorario
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
     * Set hora
     *
     * @param \DateTime $hora
     * @return RelogioPontoHorario
     */
    public function setHora(\DateTime $hora)
    {
        $this->hora = $hora;
        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPontoRelogioPontoDias
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\RelogioPontoDias $fkPontoRelogioPontoDias
     * @return RelogioPontoHorario
     */
    public function setFkPontoRelogioPontoDias(\Urbem\CoreBundle\Entity\Ponto\RelogioPontoDias $fkPontoRelogioPontoDias)
    {
        $this->codContrato = $fkPontoRelogioPontoDias->getCodContrato();
        $this->codPonto = $fkPontoRelogioPontoDias->getCodPonto();
        $this->fkPontoRelogioPontoDias = $fkPontoRelogioPontoDias;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPontoRelogioPontoDias
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\RelogioPontoDias
     */
    public function getFkPontoRelogioPontoDias()
    {
        return $this->fkPontoRelogioPontoDias;
    }
}
