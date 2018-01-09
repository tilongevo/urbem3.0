<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConcessaoDecimo
 */
class ConcessaoDecimo
{
    /**
     * PK
     * @var integer
     */
    private $codPeriodoMovimentacao;

    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var string
     */
    private $desdobramento;

    /**
     * @var boolean
     */
    private $folhaSalario = false;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAdiantamento
     */
    private $fkFolhapagamentoConfiguracaoAdiantamento;

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
     * Set codPeriodoMovimentacao
     *
     * @param integer $codPeriodoMovimentacao
     * @return ConcessaoDecimo
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
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ConcessaoDecimo
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
     * Set desdobramento
     *
     * @param string $desdobramento
     * @return ConcessaoDecimo
     */
    public function setDesdobramento($desdobramento)
    {
        $this->desdobramento = $desdobramento;
        return $this;
    }

    /**
     * Get desdobramento
     *
     * @return string
     */
    public function getDesdobramento()
    {
        return $this->desdobramento;
    }

    /**
     * Set folhaSalario
     *
     * @param boolean $folhaSalario
     * @return ConcessaoDecimo
     */
    public function setFolhaSalario($folhaSalario)
    {
        $this->folhaSalario = $folhaSalario;
        return $this;
    }

    /**
     * Get folhaSalario
     *
     * @return boolean
     */
    public function getFolhaSalario()
    {
        return $this->folhaSalario;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoPeriodoMovimentacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao $fkFolhapagamentoPeriodoMovimentacao
     * @return ConcessaoDecimo
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
     * @return ConcessaoDecimo
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
     * OneToOne (inverse side)
     * Set FolhapagamentoConfiguracaoAdiantamento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAdiantamento $fkFolhapagamentoConfiguracaoAdiantamento
     * @return ConcessaoDecimo
     */
    public function setFkFolhapagamentoConfiguracaoAdiantamento(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAdiantamento $fkFolhapagamentoConfiguracaoAdiantamento)
    {
        $fkFolhapagamentoConfiguracaoAdiantamento->setFkFolhapagamentoConcessaoDecimo($this);
        $this->fkFolhapagamentoConfiguracaoAdiantamento = $fkFolhapagamentoConfiguracaoAdiantamento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoConfiguracaoAdiantamento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAdiantamento
     */
    public function getFkFolhapagamentoConfiguracaoAdiantamento()
    {
        return $this->fkFolhapagamentoConfiguracaoAdiantamento;
    }
}
