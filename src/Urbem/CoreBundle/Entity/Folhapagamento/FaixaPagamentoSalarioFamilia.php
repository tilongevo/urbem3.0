<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * FaixaPagamentoSalarioFamilia
 */
class FaixaPagamentoSalarioFamilia
{
    /**
     * PK
     * @var integer
     */
    private $codFaixa;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codRegimePrevidencia;

    /**
     * @var integer
     */
    private $vlInicial;

    /**
     * @var integer
     */
    private $vlFinal;

    /**
     * @var integer
     */
    private $vlPagamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamilia
     */
    private $fkFolhapagamentoSalarioFamilia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codFaixa
     *
     * @param integer $codFaixa
     * @return FaixaPagamentoSalarioFamilia
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return FaixaPagamentoSalarioFamilia
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
     * Set codRegimePrevidencia
     *
     * @param integer $codRegimePrevidencia
     * @return FaixaPagamentoSalarioFamilia
     */
    public function setCodRegimePrevidencia($codRegimePrevidencia)
    {
        $this->codRegimePrevidencia = $codRegimePrevidencia;
        return $this;
    }

    /**
     * Get codRegimePrevidencia
     *
     * @return integer
     */
    public function getCodRegimePrevidencia()
    {
        return $this->codRegimePrevidencia;
    }

    /**
     * Set vlInicial
     *
     * @param integer $vlInicial
     * @return FaixaPagamentoSalarioFamilia
     */
    public function setVlInicial($vlInicial)
    {
        $this->vlInicial = $vlInicial;
        return $this;
    }

    /**
     * Get vlInicial
     *
     * @return integer
     */
    public function getVlInicial()
    {
        return $this->vlInicial;
    }

    /**
     * Set vlFinal
     *
     * @param integer $vlFinal
     * @return FaixaPagamentoSalarioFamilia
     */
    public function setVlFinal($vlFinal)
    {
        $this->vlFinal = $vlFinal;
        return $this;
    }

    /**
     * Get vlFinal
     *
     * @return integer
     */
    public function getVlFinal()
    {
        return $this->vlFinal;
    }

    /**
     * Set vlPagamento
     *
     * @param integer $vlPagamento
     * @return FaixaPagamentoSalarioFamilia
     */
    public function setVlPagamento($vlPagamento)
    {
        $this->vlPagamento = $vlPagamento;
        return $this;
    }

    /**
     * Get vlPagamento
     *
     * @return integer
     */
    public function getVlPagamento()
    {
        return $this->vlPagamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoSalarioFamilia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamilia $fkFolhapagamentoSalarioFamilia
     * @return FaixaPagamentoSalarioFamilia
     */
    public function setFkFolhapagamentoSalarioFamilia(\Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamilia $fkFolhapagamentoSalarioFamilia)
    {
        $this->codRegimePrevidencia = $fkFolhapagamentoSalarioFamilia->getCodRegimePrevidencia();
        $this->timestamp = $fkFolhapagamentoSalarioFamilia->getTimestamp();
        $this->fkFolhapagamentoSalarioFamilia = $fkFolhapagamentoSalarioFamilia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoSalarioFamilia
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamilia
     */
    public function getFkFolhapagamentoSalarioFamilia()
    {
        return $this->fkFolhapagamentoSalarioFamilia;
    }
}
