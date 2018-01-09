<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ComplementarSituacaoFechada
 */
class ComplementarSituacaoFechada
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
    private $codComplementar;

    /**
     * PK
     * @var integer
     */
    private $codPeriodoMovimentacao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampFolha;

    /**
     * PK
     * @var integer
     */
    private $codPeriodoMovimentacaoFolha;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacao
     */
    private $fkFolhapagamentoComplementarSituacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\FolhaSituacao
     */
    private $fkFolhapagamentoFolhaSituacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampFolha = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ComplementarSituacaoFechada
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
     * Set codComplementar
     *
     * @param integer $codComplementar
     * @return ComplementarSituacaoFechada
     */
    public function setCodComplementar($codComplementar)
    {
        $this->codComplementar = $codComplementar;
        return $this;
    }

    /**
     * Get codComplementar
     *
     * @return integer
     */
    public function getCodComplementar()
    {
        return $this->codComplementar;
    }

    /**
     * Set codPeriodoMovimentacao
     *
     * @param integer $codPeriodoMovimentacao
     * @return ComplementarSituacaoFechada
     */
    public function setCodPeriodoMovimentacao($codPeriodoMovimentacao)
    {
        $this->codPeriodoMovimentacao = $codPeriodoMovimentacao;
        return $this;
    }

    /**
     * Get codPeriodoMovimentacao
     *
     * @return integer
     */
    public function getCodPeriodoMovimentacao()
    {
        return $this->codPeriodoMovimentacao;
    }

    /**
     * Set timestampFolha
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampFolha
     * @return ComplementarSituacaoFechada
     */
    public function setTimestampFolha(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampFolha)
    {
        $this->timestampFolha = $timestampFolha;
        return $this;
    }

    /**
     * Get timestampFolha
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampFolha()
    {
        return $this->timestampFolha;
    }

    /**
     * Set codPeriodoMovimentacaoFolha
     *
     * @param integer $codPeriodoMovimentacaoFolha
     * @return ComplementarSituacaoFechada
     */
    public function setCodPeriodoMovimentacaoFolha($codPeriodoMovimentacaoFolha)
    {
        $this->codPeriodoMovimentacaoFolha = $codPeriodoMovimentacaoFolha;
        return $this;
    }

    /**
     * Get codPeriodoMovimentacaoFolha
     *
     * @return integer
     */
    public function getCodPeriodoMovimentacaoFolha()
    {
        return $this->codPeriodoMovimentacaoFolha;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoComplementarSituacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacao $fkFolhapagamentoComplementarSituacao
     * @return ComplementarSituacaoFechada
     */
    public function setFkFolhapagamentoComplementarSituacao(\Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacao $fkFolhapagamentoComplementarSituacao)
    {
        $this->codPeriodoMovimentacao = $fkFolhapagamentoComplementarSituacao->getCodPeriodoMovimentacao();
        $this->codComplementar = $fkFolhapagamentoComplementarSituacao->getCodComplementar();
        $this->timestamp = $fkFolhapagamentoComplementarSituacao->getTimestamp();
        $this->fkFolhapagamentoComplementarSituacao = $fkFolhapagamentoComplementarSituacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoComplementarSituacao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacao
     */
    public function getFkFolhapagamentoComplementarSituacao()
    {
        return $this->fkFolhapagamentoComplementarSituacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoFolhaSituacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\FolhaSituacao $fkFolhapagamentoFolhaSituacao
     * @return ComplementarSituacaoFechada
     */
    public function setFkFolhapagamentoFolhaSituacao(\Urbem\CoreBundle\Entity\Folhapagamento\FolhaSituacao $fkFolhapagamentoFolhaSituacao)
    {
        $this->codPeriodoMovimentacaoFolha = $fkFolhapagamentoFolhaSituacao->getCodPeriodoMovimentacao();
        $this->timestampFolha = $fkFolhapagamentoFolhaSituacao->getTimestamp();
        $this->fkFolhapagamentoFolhaSituacao = $fkFolhapagamentoFolhaSituacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoFolhaSituacao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\FolhaSituacao
     */
    public function getFkFolhapagamentoFolhaSituacao()
    {
        return $this->fkFolhapagamentoFolhaSituacao;
    }
}
