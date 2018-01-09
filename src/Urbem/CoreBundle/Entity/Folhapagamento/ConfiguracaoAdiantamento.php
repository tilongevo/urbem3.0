<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoAdiantamento
 */
class ConfiguracaoAdiantamento
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
     * @var integer
     */
    private $percentual;

    /**
     * @var boolean
     */
    private $vantagensFixas = true;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConcessaoDecimo
     */
    private $fkFolhapagamentoConcessaoDecimo;


    /**
     * Set codPeriodoMovimentacao
     *
     * @param integer $codPeriodoMovimentacao
     * @return ConfiguracaoAdiantamento
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
     * @return ConfiguracaoAdiantamento
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
     * @return ConfiguracaoAdiantamento
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
     * Set percentual
     *
     * @param integer $percentual
     * @return ConfiguracaoAdiantamento
     */
    public function setPercentual($percentual)
    {
        $this->percentual = $percentual;
        return $this;
    }

    /**
     * Get percentual
     *
     * @return integer
     */
    public function getPercentual()
    {
        return $this->percentual;
    }

    /**
     * Set vantagensFixas
     *
     * @param boolean $vantagensFixas
     * @return ConfiguracaoAdiantamento
     */
    public function setVantagensFixas($vantagensFixas)
    {
        $this->vantagensFixas = $vantagensFixas;
        return $this;
    }

    /**
     * Get vantagensFixas
     *
     * @return boolean
     */
    public function getVantagensFixas()
    {
        return $this->vantagensFixas;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoConcessaoDecimo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConcessaoDecimo $fkFolhapagamentoConcessaoDecimo
     * @return ConfiguracaoAdiantamento
     */
    public function setFkFolhapagamentoConcessaoDecimo(\Urbem\CoreBundle\Entity\Folhapagamento\ConcessaoDecimo $fkFolhapagamentoConcessaoDecimo)
    {
        $this->codPeriodoMovimentacao = $fkFolhapagamentoConcessaoDecimo->getCodPeriodoMovimentacao();
        $this->codContrato = $fkFolhapagamentoConcessaoDecimo->getCodContrato();
        $this->desdobramento = $fkFolhapagamentoConcessaoDecimo->getDesdobramento();
        $this->fkFolhapagamentoConcessaoDecimo = $fkFolhapagamentoConcessaoDecimo;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoConcessaoDecimo
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConcessaoDecimo
     */
    public function getFkFolhapagamentoConcessaoDecimo()
    {
        return $this->fkFolhapagamentoConcessaoDecimo;
    }
}
