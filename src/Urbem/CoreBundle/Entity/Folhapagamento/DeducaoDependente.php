<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * DeducaoDependente
 */
class DeducaoDependente
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var integer
     */
    private $codPeriodoMovimentacao;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $codContrato;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependenteComplementar
     */
    private $fkFolhapagamentoDeducaoDependenteComplementar;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao
     */
    private $fkFolhapagamentoPeriodoMovimentacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    private $fkPessoalContrato;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\TipoFolha
     */
    private $fkFolhapagamentoTipoFolha;


    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return DeducaoDependente
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set codPeriodoMovimentacao
     *
     * @param integer $codPeriodoMovimentacao
     * @return DeducaoDependente
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
     * @return DeducaoDependente
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
     * Set codContrato
     *
     * @param integer $codContrato
     * @return DeducaoDependente
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
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return DeducaoDependente
     */
    public function setFkSwCgmPessoaFisica(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $this->numcgm = $fkSwCgmPessoaFisica->getNumcgm();
        $this->fkSwCgmPessoaFisica = $fkSwCgmPessoaFisica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica()
    {
        return $this->fkSwCgmPessoaFisica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoPeriodoMovimentacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao $fkFolhapagamentoPeriodoMovimentacao
     * @return DeducaoDependente
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

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContrato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato
     * @return DeducaoDependente
     */
    public function setFkPessoalContrato(\Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato)
    {
        $this->codContrato = $fkPessoalContrato->getCodContrato();
        $this->fkPessoalContrato = $fkPessoalContrato;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContrato
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    public function getFkPessoalContrato()
    {
        return $this->fkPessoalContrato;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoTipoFolha
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TipoFolha $fkFolhapagamentoTipoFolha
     * @return DeducaoDependente
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
     * OneToOne (inverse side)
     * Set FolhapagamentoDeducaoDependenteComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependenteComplementar $fkFolhapagamentoDeducaoDependenteComplementar
     * @return DeducaoDependente
     */
    public function setFkFolhapagamentoDeducaoDependenteComplementar(\Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependenteComplementar $fkFolhapagamentoDeducaoDependenteComplementar)
    {
        $fkFolhapagamentoDeducaoDependenteComplementar->setFkFolhapagamentoDeducaoDependente($this);
        $this->fkFolhapagamentoDeducaoDependenteComplementar = $fkFolhapagamentoDeducaoDependenteComplementar;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoDeducaoDependenteComplementar
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependenteComplementar
     */
    public function getFkFolhapagamentoDeducaoDependenteComplementar()
    {
        return $this->fkFolhapagamentoDeducaoDependenteComplementar;
    }
}
