<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * FolhaSituacao
 */
class FolhaSituacao
{
    const ABERTO = 'a';
    const FECHADO = 'f';

    /**
     * PK
     * @var integer
     */
    private $codPeriodoMovimentacao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $situacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacaoFechada
     */
    private $fkFolhapagamentoComplementarSituacaoFechadas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao
     */
    private $fkFolhapagamentoPeriodoMovimentacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoComplementarSituacaoFechadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codPeriodoMovimentacao
     *
     * @param integer $codPeriodoMovimentacao
     * @return FolhaSituacao
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return FolhaSituacao
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
     * Set situacao
     *
     * @param string $situacao
     * @return FolhaSituacao
     */
    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
        return $this;
    }

    /**
     * Get situacao
     *
     * @return string
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoComplementarSituacaoFechada
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacaoFechada $fkFolhapagamentoComplementarSituacaoFechada
     * @return FolhaSituacao
     */
    public function addFkFolhapagamentoComplementarSituacaoFechadas(\Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacaoFechada $fkFolhapagamentoComplementarSituacaoFechada)
    {
        if (false === $this->fkFolhapagamentoComplementarSituacaoFechadas->contains($fkFolhapagamentoComplementarSituacaoFechada)) {
            $fkFolhapagamentoComplementarSituacaoFechada->setFkFolhapagamentoFolhaSituacao($this);
            $this->fkFolhapagamentoComplementarSituacaoFechadas->add($fkFolhapagamentoComplementarSituacaoFechada);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoComplementarSituacaoFechada
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacaoFechada $fkFolhapagamentoComplementarSituacaoFechada
     */
    public function removeFkFolhapagamentoComplementarSituacaoFechadas(\Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacaoFechada $fkFolhapagamentoComplementarSituacaoFechada)
    {
        $this->fkFolhapagamentoComplementarSituacaoFechadas->removeElement($fkFolhapagamentoComplementarSituacaoFechada);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoComplementarSituacaoFechadas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacaoFechada
     */
    public function getFkFolhapagamentoComplementarSituacaoFechadas()
    {
        return $this->fkFolhapagamentoComplementarSituacaoFechadas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoPeriodoMovimentacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao $fkFolhapagamentoPeriodoMovimentacao
     * @return FolhaSituacao
     */
    public function setFkFolhapagamentoPeriodoMovimentacao(\Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao $fkFolhapagamentoPeriodoMovimentacao)
    {
        $this->codPeriodoMovimentacao = $fkFolhapagamentoPeriodoMovimentacao->getCodPeriodoMovimentacao();
        $this->fkFolhapagamentoPeriodoMovimentacao = $fkFolhapagamentoPeriodoMovimentacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoPeriodoMovimentacao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao
     */
    public function getFkFolhapagamentoPeriodoMovimentacao()
    {
        return $this->fkFolhapagamentoPeriodoMovimentacao;
    }
}
