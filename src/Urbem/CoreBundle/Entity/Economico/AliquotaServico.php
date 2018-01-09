<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * AliquotaServico
 */
class AliquotaServico
{
    /**
     * PK
     * @var integer
     */
    private $codServico;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var \DateTime
     */
    private $dtVigencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Servico
     */
    private $fkEconomicoServico;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->dtVigencia = new \DateTime;
    }

    /**
     * Set codServico
     *
     * @param integer $codServico
     * @return AliquotaServico
     */
    public function setCodServico($codServico)
    {
        $this->codServico = $codServico;
        return $this;
    }

    /**
     * Get codServico
     *
     * @return integer
     */
    public function getCodServico()
    {
        return $this->codServico;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return AliquotaServico
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
     * @param integer $valor
     * @return AliquotaServico
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set dtVigencia
     *
     * @param \DateTime $dtVigencia
     * @return AliquotaServico
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
     * ManyToOne (inverse side)
     * Set fkEconomicoServico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Servico $fkEconomicoServico
     * @return AliquotaServico
     */
    public function setFkEconomicoServico(\Urbem\CoreBundle\Entity\Economico\Servico $fkEconomicoServico)
    {
        $this->codServico = $fkEconomicoServico->getCodServico();
        $this->fkEconomicoServico = $fkEconomicoServico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoServico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Servico
     */
    public function getFkEconomicoServico()
    {
        return $this->fkEconomicoServico;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s', $this->getValor());
    }
}
