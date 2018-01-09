<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * RelogioPontoJustificativaExclusao
 */
class RelogioPontoJustificativaExclusao
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
     * PK
     * @var integer
     */
    private $codJustificativa;

    /**
     * PK
     * @var integer
     */
    private $sequencia;

    /**
     * @var \DateTime
     */
    private $timestampExclusao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Ponto\RelogioPontoJustificativa
     */
    private $fkPontoRelogioPontoJustificativa;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
        $this->timestampExclusao = new \DateTime;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return RelogioPontoJustificativaExclusao
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
     * @return RelogioPontoJustificativaExclusao
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
     * Set codJustificativa
     *
     * @param integer $codJustificativa
     * @return RelogioPontoJustificativaExclusao
     */
    public function setCodJustificativa($codJustificativa)
    {
        $this->codJustificativa = $codJustificativa;
        return $this;
    }

    /**
     * Get codJustificativa
     *
     * @return integer
     */
    public function getCodJustificativa()
    {
        return $this->codJustificativa;
    }

    /**
     * Set sequencia
     *
     * @param integer $sequencia
     * @return RelogioPontoJustificativaExclusao
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set timestampExclusao
     *
     * @param \DateTime $timestampExclusao
     * @return RelogioPontoJustificativaExclusao
     */
    public function setTimestampExclusao(\DateTime $timestampExclusao)
    {
        $this->timestampExclusao = $timestampExclusao;
        return $this;
    }

    /**
     * Get timestampExclusao
     *
     * @return \DateTime
     */
    public function getTimestampExclusao()
    {
        return $this->timestampExclusao;
    }

    /**
     * OneToOne (owning side)
     * Set PontoRelogioPontoJustificativa
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\RelogioPontoJustificativa $fkPontoRelogioPontoJustificativa
     * @return RelogioPontoJustificativaExclusao
     */
    public function setFkPontoRelogioPontoJustificativa(\Urbem\CoreBundle\Entity\Ponto\RelogioPontoJustificativa $fkPontoRelogioPontoJustificativa)
    {
        $this->codContrato = $fkPontoRelogioPontoJustificativa->getCodContrato();
        $this->timestamp = $fkPontoRelogioPontoJustificativa->getTimestamp();
        $this->codJustificativa = $fkPontoRelogioPontoJustificativa->getCodJustificativa();
        $this->sequencia = $fkPontoRelogioPontoJustificativa->getSequencia();
        $this->fkPontoRelogioPontoJustificativa = $fkPontoRelogioPontoJustificativa;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPontoRelogioPontoJustificativa
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\RelogioPontoJustificativa
     */
    public function getFkPontoRelogioPontoJustificativa()
    {
        return $this->fkPontoRelogioPontoJustificativa;
    }
}
