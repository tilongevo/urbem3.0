<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * DividaConsolidada
 */
class DividaConsolidada
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtInicio;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtFim;

    /**
     * PK
     * @var integer
     */
    private $numUnidade;

    /**
     * PK
     * @var integer
     */
    private $numOrgao;

    /**
     * PK
     * @var integer
     */
    private $tipoLancamento;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var string
     */
    private $nroLeiAutorizacao;

    /**
     * @var \DateTime
     */
    private $dtLeiAutorizacao;

    /**
     * @var integer
     */
    private $vlSaldoAnterior;

    /**
     * @var integer
     */
    private $vlContratacao;

    /**
     * @var integer
     */
    private $vlAmortizacao;

    /**
     * @var integer
     */
    private $vlCancelamento;

    /**
     * @var integer
     */
    private $vlEncampacao;

    /**
     * @var integer
     */
    private $vlAtualizacao;

    /**
     * @var integer
     */
    private $vlSaldoAtual;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\TipoLancamento
     */
    private $fkTcmgoTipoLancamento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dtInicio = new \Urbem\CoreBundle\Helper\DatePK;
        $this->dtFim = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return DividaConsolidada
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set dtInicio
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtInicio
     * @return DividaConsolidada
     */
    public function setDtInicio(\Urbem\CoreBundle\Helper\DatePK $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set dtFim
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtFim
     * @return DividaConsolidada
     */
    public function setDtFim(\Urbem\CoreBundle\Helper\DatePK $dtFim)
    {
        $this->dtFim = $dtFim;
        return $this;
    }

    /**
     * Get dtFim
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDtFim()
    {
        return $this->dtFim;
    }

    /**
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return DividaConsolidada
     */
    public function setNumUnidade($numUnidade)
    {
        $this->numUnidade = $numUnidade;
        return $this;
    }

    /**
     * Get numUnidade
     *
     * @return integer
     */
    public function getNumUnidade()
    {
        return $this->numUnidade;
    }

    /**
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return DividaConsolidada
     */
    public function setNumOrgao($numOrgao)
    {
        $this->numOrgao = $numOrgao;
        return $this;
    }

    /**
     * Get numOrgao
     *
     * @return integer
     */
    public function getNumOrgao()
    {
        return $this->numOrgao;
    }

    /**
     * Set tipoLancamento
     *
     * @param integer $tipoLancamento
     * @return DividaConsolidada
     */
    public function setTipoLancamento($tipoLancamento)
    {
        $this->tipoLancamento = $tipoLancamento;
        return $this;
    }

    /**
     * Get tipoLancamento
     *
     * @return integer
     */
    public function getTipoLancamento()
    {
        return $this->tipoLancamento;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return DividaConsolidada
     */
    public function setNumcgm($numcgm = null)
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
     * Set nroLeiAutorizacao
     *
     * @param string $nroLeiAutorizacao
     * @return DividaConsolidada
     */
    public function setNroLeiAutorizacao($nroLeiAutorizacao)
    {
        $this->nroLeiAutorizacao = $nroLeiAutorizacao;
        return $this;
    }

    /**
     * Get nroLeiAutorizacao
     *
     * @return string
     */
    public function getNroLeiAutorizacao()
    {
        return $this->nroLeiAutorizacao;
    }

    /**
     * Set dtLeiAutorizacao
     *
     * @param \DateTime $dtLeiAutorizacao
     * @return DividaConsolidada
     */
    public function setDtLeiAutorizacao(\DateTime $dtLeiAutorizacao)
    {
        $this->dtLeiAutorizacao = $dtLeiAutorizacao;
        return $this;
    }

    /**
     * Get dtLeiAutorizacao
     *
     * @return \DateTime
     */
    public function getDtLeiAutorizacao()
    {
        return $this->dtLeiAutorizacao;
    }

    /**
     * Set vlSaldoAnterior
     *
     * @param integer $vlSaldoAnterior
     * @return DividaConsolidada
     */
    public function setVlSaldoAnterior($vlSaldoAnterior = null)
    {
        $this->vlSaldoAnterior = $vlSaldoAnterior;
        return $this;
    }

    /**
     * Get vlSaldoAnterior
     *
     * @return integer
     */
    public function getVlSaldoAnterior()
    {
        return $this->vlSaldoAnterior;
    }

    /**
     * Set vlContratacao
     *
     * @param integer $vlContratacao
     * @return DividaConsolidada
     */
    public function setVlContratacao($vlContratacao = null)
    {
        $this->vlContratacao = $vlContratacao;
        return $this;
    }

    /**
     * Get vlContratacao
     *
     * @return integer
     */
    public function getVlContratacao()
    {
        return $this->vlContratacao;
    }

    /**
     * Set vlAmortizacao
     *
     * @param integer $vlAmortizacao
     * @return DividaConsolidada
     */
    public function setVlAmortizacao($vlAmortizacao = null)
    {
        $this->vlAmortizacao = $vlAmortizacao;
        return $this;
    }

    /**
     * Get vlAmortizacao
     *
     * @return integer
     */
    public function getVlAmortizacao()
    {
        return $this->vlAmortizacao;
    }

    /**
     * Set vlCancelamento
     *
     * @param integer $vlCancelamento
     * @return DividaConsolidada
     */
    public function setVlCancelamento($vlCancelamento = null)
    {
        $this->vlCancelamento = $vlCancelamento;
        return $this;
    }

    /**
     * Get vlCancelamento
     *
     * @return integer
     */
    public function getVlCancelamento()
    {
        return $this->vlCancelamento;
    }

    /**
     * Set vlEncampacao
     *
     * @param integer $vlEncampacao
     * @return DividaConsolidada
     */
    public function setVlEncampacao($vlEncampacao = null)
    {
        $this->vlEncampacao = $vlEncampacao;
        return $this;
    }

    /**
     * Get vlEncampacao
     *
     * @return integer
     */
    public function getVlEncampacao()
    {
        return $this->vlEncampacao;
    }

    /**
     * Set vlAtualizacao
     *
     * @param integer $vlAtualizacao
     * @return DividaConsolidada
     */
    public function setVlAtualizacao($vlAtualizacao = null)
    {
        $this->vlAtualizacao = $vlAtualizacao;
        return $this;
    }

    /**
     * Get vlAtualizacao
     *
     * @return integer
     */
    public function getVlAtualizacao()
    {
        return $this->vlAtualizacao;
    }

    /**
     * Set vlSaldoAtual
     *
     * @param integer $vlSaldoAtual
     * @return DividaConsolidada
     */
    public function setVlSaldoAtual($vlSaldoAtual = null)
    {
        $this->vlSaldoAtual = $vlSaldoAtual;
        return $this;
    }

    /**
     * Get vlSaldoAtual
     *
     * @return integer
     */
    public function getVlSaldoAtual()
    {
        return $this->vlSaldoAtual;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return DividaConsolidada
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmgoTipoLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\TipoLancamento $fkTcmgoTipoLancamento
     * @return DividaConsolidada
     */
    public function setFkTcmgoTipoLancamento(\Urbem\CoreBundle\Entity\Tcmgo\TipoLancamento $fkTcmgoTipoLancamento)
    {
        $this->tipoLancamento = $fkTcmgoTipoLancamento->getCodLancamento();
        $this->fkTcmgoTipoLancamento = $fkTcmgoTipoLancamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoTipoLancamento
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\TipoLancamento
     */
    public function getFkTcmgoTipoLancamento()
    {
        return $this->fkTcmgoTipoLancamento;
    }
}
