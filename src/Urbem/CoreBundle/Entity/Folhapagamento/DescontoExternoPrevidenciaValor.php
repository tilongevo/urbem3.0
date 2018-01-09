<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * DescontoExternoPrevidenciaValor
 */
class DescontoExternoPrevidenciaValor
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
    private $valorPrevidencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidencia
     */
    private $fkFolhapagamentoDescontoExternoPrevidencia;

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
     * @return DescontoExternoPrevidenciaValor
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
     * @return DescontoExternoPrevidenciaValor
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
     * @return DescontoExternoPrevidenciaValor
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
     * Set valorPrevidencia
     *
     * @param integer $valorPrevidencia
     * @return DescontoExternoPrevidenciaValor
     */
    public function setValorPrevidencia($valorPrevidencia)
    {
        $this->valorPrevidencia = $valorPrevidencia;
        return $this;
    }

    /**
     * Get valorPrevidencia
     *
     * @return integer
     */
    public function getValorPrevidencia()
    {
        return $this->valorPrevidencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoDescontoExternoPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidencia $fkFolhapagamentoDescontoExternoPrevidencia
     * @return DescontoExternoPrevidenciaValor
     */
    public function setFkFolhapagamentoDescontoExternoPrevidencia(\Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidencia $fkFolhapagamentoDescontoExternoPrevidencia)
    {
        $this->codContrato = $fkFolhapagamentoDescontoExternoPrevidencia->getCodContrato();
        $this->timestamp = $fkFolhapagamentoDescontoExternoPrevidencia->getTimestamp();
        $this->fkFolhapagamentoDescontoExternoPrevidencia = $fkFolhapagamentoDescontoExternoPrevidencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoDescontoExternoPrevidencia
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidencia
     */
    public function getFkFolhapagamentoDescontoExternoPrevidencia()
    {
        return $this->fkFolhapagamentoDescontoExternoPrevidencia;
    }
}
