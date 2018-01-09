<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * TabelaIrrfCid
 */
class TabelaIrrfCid
{
    /**
     * PK
     * @var integer
     */
    private $codCid;

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
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Cid
     */
    private $fkPessoalCid;

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
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK();
    }

    /**
     * Set codCid
     *
     * @param integer $codCid
     * @return TabelaIrrfCid
     */
    public function setCodCid($codCid)
    {
        $this->codCid = $codCid;
        return $this;
    }

    /**
     * Get codCid
     *
     * @return integer
     */
    public function getCodCid()
    {
        return $this->codCid;
    }

    /**
     * Set codTabela
     *
     * @param integer $codTabela
     * @return TabelaIrrfCid
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
     * @return TabelaIrrfCid
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
     * ManyToOne (inverse side)
     * Set fkPessoalCid
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Cid $fkPessoalCid
     * @return TabelaIrrfCid
     */
    public function setFkPessoalCid(\Urbem\CoreBundle\Entity\Pessoal\Cid $fkPessoalCid)
    {
        $this->codCid = $fkPessoalCid->getCodCid();
        $this->fkPessoalCid = $fkPessoalCid;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCid
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Cid
     */
    public function getFkPessoalCid()
    {
        return $this->fkPessoalCid;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoTabelaIrrf
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrf $fkFolhapagamentoTabelaIrrf
     * @return TabelaIrrfCid
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
        if (!is_null($this->fkPessoalCid)) {
            return $this->getCodCid() . ' - ' . $this->fkPessoalCid->getDescricao();
        }
        return 'Cid';
    }
}
