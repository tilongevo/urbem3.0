<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * DescontoExternoIrrfValor
 */
class DescontoExternoIrrfValor
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampValor;

    /**
     * @var integer
     */
    private $valorIrrf;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrf
     */
    private $fkFolhapagamentoDescontoExternoIrrf;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampValor = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return DescontoExternoIrrfValor
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
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return DescontoExternoIrrfValor
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
     * Set timestampValor
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampValor
     * @return DescontoExternoIrrfValor
     */
    public function setTimestampValor(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampValor)
    {
        $this->timestampValor = $timestampValor;
        return $this;
    }

    /**
     * Get timestampValor
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampValor()
    {
        return $this->timestampValor;
    }

    /**
     * Set valorIrrf
     *
     * @param integer $valorIrrf
     * @return DescontoExternoIrrfValor
     */
    public function setValorIrrf($valorIrrf)
    {
        $this->valorIrrf = $valorIrrf;
        return $this;
    }

    /**
     * Get valorIrrf
     *
     * @return integer
     */
    public function getValorIrrf()
    {
        return $this->valorIrrf;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoDescontoExternoIrrf
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrf $fkFolhapagamentoDescontoExternoIrrf
     * @return DescontoExternoIrrfValor
     */
    public function setFkFolhapagamentoDescontoExternoIrrf(\Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrf $fkFolhapagamentoDescontoExternoIrrf)
    {
        $this->codContrato = $fkFolhapagamentoDescontoExternoIrrf->getCodContrato();
        $this->timestamp = $fkFolhapagamentoDescontoExternoIrrf->getTimestamp();
        $this->fkFolhapagamentoDescontoExternoIrrf = $fkFolhapagamentoDescontoExternoIrrf;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoDescontoExternoIrrf
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrf
     */
    public function getFkFolhapagamentoDescontoExternoIrrf()
    {
        return $this->fkFolhapagamentoDescontoExternoIrrf;
    }
}
