<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * FaixaDescontoIrrf
 */
class FaixaDescontoIrrf
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
    private $codTabela;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

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
    private $aliquota;

    /**
     * @var integer
     */
    private $parcelaDeduzir;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrf
     */
    private $fkFolhapagamentoTabelaIrrf;

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
     * @return FaixaDescontoIrrf
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
     * Set codTabela
     *
     * @param integer $codTabela
     * @return FaixaDescontoIrrf
     */
    public function setCodTabela($codTabela)
    {
        $this->codTabela = $codTabela;
        return $this;
    }

    /**
     * Get codTabela
     *
     * @return integer
     */
    public function getCodTabela()
    {
        return $this->codTabela;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return FaixaDescontoIrrf
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
     * Set vlInicial
     *
     * @param integer $vlInicial
     * @return FaixaDescontoIrrf
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
     * @return FaixaDescontoIrrf
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
     * Set aliquota
     *
     * @param integer $aliquota
     * @return FaixaDescontoIrrf
     */
    public function setAliquota($aliquota)
    {
        $this->aliquota = $aliquota;
        return $this;
    }

    /**
     * Get aliquota
     *
     * @return integer
     */
    public function getAliquota()
    {
        return $this->aliquota;
    }

    /**
     * Set parcelaDeduzir
     *
     * @param integer $parcelaDeduzir
     * @return FaixaDescontoIrrf
     */
    public function setParcelaDeduzir($parcelaDeduzir)
    {
        $this->parcelaDeduzir = $parcelaDeduzir;
        return $this;
    }

    /**
     * Get parcelaDeduzir
     *
     * @return integer
     */
    public function getParcelaDeduzir()
    {
        return $this->parcelaDeduzir;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoTabelaIrrf
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrf $fkFolhapagamentoTabelaIrrf
     * @return FaixaDescontoIrrf
     */
    public function setFkFolhapagamentoTabelaIrrf(\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrf $fkFolhapagamentoTabelaIrrf)
    {
        $this->codTabela = $fkFolhapagamentoTabelaIrrf->getCodTabela();
        $this->timestamp = $fkFolhapagamentoTabelaIrrf->getTimestamp();
        $this->fkFolhapagamentoTabelaIrrf = $fkFolhapagamentoTabelaIrrf;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoTabelaIrrf
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrf
     */
    public function getFkFolhapagamentoTabelaIrrf()
    {
        return $this->fkFolhapagamentoTabelaIrrf;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'Faixa de desconto';
    }
}
