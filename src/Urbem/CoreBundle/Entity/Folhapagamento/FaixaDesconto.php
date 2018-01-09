<?php

namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * FaixaDesconto
 */
class FaixaDesconto
{
    /**
     * PK
     * @var integer
     */
    private $codFaixa;

    /**
     * PK
     * @var integer
     */
    private $codPrevidencia;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampPrevidencia;

    /**
     * @var integer
     */
    private $valorInicial;

    /**
     * @var integer
     */
    private $valorFinal;

    /**
     * @var integer
     */
    private $percentualDesconto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia
     */
    private $fkFolhapagamentoPrevidenciaPrevidencia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampPrevidencia = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codFaixa
     *
     * @param integer $codFaixa
     * @return FaixaDesconto
     */
    public function setCodFaixa($codFaixa)
    {
        $this->codFaixa = $codFaixa;
        return $this;
    }

    /**
     * Get codFaixa
     *
     * @return integer
     */
    public function getCodFaixa()
    {
        return $this->codFaixa;
    }

    /**
     * Set codPrevidencia
     *
     * @param integer $codPrevidencia
     * @return FaixaDesconto
     */
    public function setCodPrevidencia($codPrevidencia)
    {
        $this->codPrevidencia = $codPrevidencia;
        return $this;
    }

    /**
     * Get codPrevidencia
     *
     * @return integer
     */
    public function getCodPrevidencia()
    {
        return $this->codPrevidencia;
    }

    /**
     * Set timestampPrevidencia
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampPrevidencia
     * @return FaixaDesconto
     */
    public function setTimestampPrevidencia(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampPrevidencia)
    {
        $this->timestampPrevidencia = $timestampPrevidencia;
        return $this;
    }

    /**
     * Get timestampPrevidencia
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampPrevidencia()
    {
        return $this->timestampPrevidencia;
    }

    /**
     * Set valorInicial
     *
     * @param integer $valorInicial
     * @return FaixaDesconto
     */
    public function setValorInicial($valorInicial)
    {
        $this->valorInicial = $valorInicial;
        return $this;
    }

    /**
     * Get valorInicial
     *
     * @return integer
     */
    public function getValorInicial()
    {
        return $this->valorInicial;
    }

    /**
     * Set valorFinal
     *
     * @param integer $valorFinal
     * @return FaixaDesconto
     */
    public function setValorFinal($valorFinal)
    {
        $this->valorFinal = $valorFinal;
        return $this;
    }

    /**
     * Get valorFinal
     *
     * @return integer
     */
    public function getValorFinal()
    {
        return $this->valorFinal;
    }

    /**
     * Set percentualDesconto
     *
     * @param integer $percentualDesconto
     * @return FaixaDesconto
     */
    public function setPercentualDesconto($percentualDesconto)
    {
        $this->percentualDesconto = $percentualDesconto;
        return $this;
    }

    /**
     * Get percentualDesconto
     *
     * @return integer
     */
    public function getPercentualDesconto()
    {
        return $this->percentualDesconto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoPrevidenciaPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia $fkFolhapagamentoPrevidenciaPrevidencia
     * @return FaixaDesconto
     */
    public function setFkFolhapagamentoPrevidenciaPrevidencia(\Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia $fkFolhapagamentoPrevidenciaPrevidencia)
    {
        $this->codPrevidencia = $fkFolhapagamentoPrevidenciaPrevidencia->getCodPrevidencia();
        $this->timestampPrevidencia = $fkFolhapagamentoPrevidenciaPrevidencia->getTimestamp();
        $this->fkFolhapagamentoPrevidenciaPrevidencia = $fkFolhapagamentoPrevidenciaPrevidencia;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoPrevidenciaPrevidencia
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia
     */
    public function getFkFolhapagamentoPrevidenciaPrevidencia()
    {
        return $this->fkFolhapagamentoPrevidenciaPrevidencia;
    }
}
