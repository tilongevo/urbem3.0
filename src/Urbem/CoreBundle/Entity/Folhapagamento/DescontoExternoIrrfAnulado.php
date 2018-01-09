<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * DescontoExternoIrrfAnulado
 */
class DescontoExternoIrrfAnulado
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
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrf
     */
    private $fkFolhapagamentoDescontoExternoIrrf;

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
     * @return DescontoExternoIrrfAnulado
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
     * @return DescontoExternoIrrfAnulado
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
     * @return DescontoExternoIrrfAnulado
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
     * Set FolhapagamentoDescontoExternoIrrf
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrf $fkFolhapagamentoDescontoExternoIrrf
     * @return DescontoExternoIrrfAnulado
     */
    public function setFkFolhapagamentoDescontoExternoIrrf(\Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrf $fkFolhapagamentoDescontoExternoIrrf)
    {
        $this->codContrato = $fkFolhapagamentoDescontoExternoIrrf->getCodContrato();
        $this->timestamp = $fkFolhapagamentoDescontoExternoIrrf->getTimestamp();
        $this->fkFolhapagamentoDescontoExternoIrrf = $fkFolhapagamentoDescontoExternoIrrf;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoDescontoExternoIrrf
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrf
     */
    public function getFkFolhapagamentoDescontoExternoIrrf()
    {
        return $this->fkFolhapagamentoDescontoExternoIrrf;
    }
}
