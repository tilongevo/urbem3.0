<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * Pagamento910
 */
class Pagamento910
{
    /**
     * PK
     * @var integer
     */
    private $codPeriodoMovimentacao;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao
     */
    private $fkFolhapagamentoPeriodoMovimentacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\TipoFolha
     */
    private $fkFolhapagamentoTipoFolha;


    /**
     * Set codPeriodoMovimentacao
     *
     * @param integer $codPeriodoMovimentacao
     * @return Pagamento910
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return Pagamento910
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoTipoFolha
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TipoFolha $fkFolhapagamentoTipoFolha
     * @return Pagamento910
     */
    public function setFkFolhapagamentoTipoFolha(\Urbem\CoreBundle\Entity\Folhapagamento\TipoFolha $fkFolhapagamentoTipoFolha)
    {
        $this->codTipo = $fkFolhapagamentoTipoFolha->getCodTipo();
        $this->fkFolhapagamentoTipoFolha = $fkFolhapagamentoTipoFolha;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoTipoFolha
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\TipoFolha
     */
    public function getFkFolhapagamentoTipoFolha()
    {
        return $this->fkFolhapagamentoTipoFolha;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoPeriodoMovimentacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao $fkFolhapagamentoPeriodoMovimentacao
     * @return Pagamento910
     */
    public function setFkFolhapagamentoPeriodoMovimentacao(\Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao $fkFolhapagamentoPeriodoMovimentacao)
    {
        $this->codPeriodoMovimentacao = $fkFolhapagamentoPeriodoMovimentacao->getCodPeriodoMovimentacao();
        $this->fkFolhapagamentoPeriodoMovimentacao = $fkFolhapagamentoPeriodoMovimentacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoPeriodoMovimentacao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao
     */
    public function getFkFolhapagamentoPeriodoMovimentacao()
    {
        return $this->fkFolhapagamentoPeriodoMovimentacao;
    }
}
