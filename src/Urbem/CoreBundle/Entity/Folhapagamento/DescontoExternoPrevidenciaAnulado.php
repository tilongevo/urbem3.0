<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * DescontoExternoPrevidenciaAnulado
 */
class DescontoExternoPrevidenciaAnulado
{
    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * @var \DateTime
     */
    private $timestampAnulado;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidencia
     */
    private $fkFolhapagamentoDescontoExternoPrevidencia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampAnulado = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return DescontoExternoPrevidenciaAnulado
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
     * Set codContrato
     *
     * @param integer $codContrato
     * @return DescontoExternoPrevidenciaAnulado
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
     * Set timestampAnulado
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAnulado
     * @return DescontoExternoPrevidenciaAnulado
     */
    public function setTimestampAnulado(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAnulado)
    {
        $this->timestampAnulado = $timestampAnulado;
        return $this;
    }

    /**
     * Get timestampAnulado
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampAnulado()
    {
        return $this->timestampAnulado;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoDescontoExternoPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidencia $fkFolhapagamentoDescontoExternoPrevidencia
     * @return DescontoExternoPrevidenciaAnulado
     */
    public function setFkFolhapagamentoDescontoExternoPrevidencia(\Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidencia $fkFolhapagamentoDescontoExternoPrevidencia)
    {
        $this->codContrato = $fkFolhapagamentoDescontoExternoPrevidencia->getCodContrato();
        $this->timestamp = $fkFolhapagamentoDescontoExternoPrevidencia->getTimestamp();
        $this->fkFolhapagamentoDescontoExternoPrevidencia = $fkFolhapagamentoDescontoExternoPrevidencia;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoDescontoExternoPrevidencia
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidencia
     */
    public function getFkFolhapagamentoDescontoExternoPrevidencia()
    {
        return $this->fkFolhapagamentoDescontoExternoPrevidencia;
    }
}
