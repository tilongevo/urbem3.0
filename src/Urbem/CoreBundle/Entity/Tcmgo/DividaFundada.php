<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * DividaFundada
 */
class DividaFundada
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codNorma;

    /**
     * @var integer
     */
    private $numUnidade;

    /**
     * @var integer
     */
    private $numOrgao;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $codTipoLancamento;

    /**
     * @var integer
     */
    private $valorSaldoAnterior;

    /**
     * @var integer
     */
    private $valorContratacao;

    /**
     * @var integer
     */
    private $valorAmortizacao;

    /**
     * @var integer
     */
    private $valorCancelamento;

    /**
     * @var integer
     */
    private $valorEncampacao;

    /**
     * @var integer
     */
    private $valorCorrecao;

    /**
     * @var integer
     */
    private $valorSaldoAtual;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return DividaFundada
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return DividaFundada
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return DividaFundada
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return DividaFundada
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
     * @return DividaFundada
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return DividaFundada
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
     * Set codTipoLancamento
     *
     * @param integer $codTipoLancamento
     * @return DividaFundada
     */
    public function setCodTipoLancamento($codTipoLancamento)
    {
        $this->codTipoLancamento = $codTipoLancamento;
        return $this;
    }

    /**
     * Get codTipoLancamento
     *
     * @return integer
     */
    public function getCodTipoLancamento()
    {
        return $this->codTipoLancamento;
    }

    /**
     * Set valorSaldoAnterior
     *
     * @param integer $valorSaldoAnterior
     * @return DividaFundada
     */
    public function setValorSaldoAnterior($valorSaldoAnterior)
    {
        $this->valorSaldoAnterior = $valorSaldoAnterior;
        return $this;
    }

    /**
     * Get valorSaldoAnterior
     *
     * @return integer
     */
    public function getValorSaldoAnterior()
    {
        return $this->valorSaldoAnterior;
    }

    /**
     * Set valorContratacao
     *
     * @param integer $valorContratacao
     * @return DividaFundada
     */
    public function setValorContratacao($valorContratacao)
    {
        $this->valorContratacao = $valorContratacao;
        return $this;
    }

    /**
     * Get valorContratacao
     *
     * @return integer
     */
    public function getValorContratacao()
    {
        return $this->valorContratacao;
    }

    /**
     * Set valorAmortizacao
     *
     * @param integer $valorAmortizacao
     * @return DividaFundada
     */
    public function setValorAmortizacao($valorAmortizacao)
    {
        $this->valorAmortizacao = $valorAmortizacao;
        return $this;
    }

    /**
     * Get valorAmortizacao
     *
     * @return integer
     */
    public function getValorAmortizacao()
    {
        return $this->valorAmortizacao;
    }

    /**
     * Set valorCancelamento
     *
     * @param integer $valorCancelamento
     * @return DividaFundada
     */
    public function setValorCancelamento($valorCancelamento)
    {
        $this->valorCancelamento = $valorCancelamento;
        return $this;
    }

    /**
     * Get valorCancelamento
     *
     * @return integer
     */
    public function getValorCancelamento()
    {
        return $this->valorCancelamento;
    }

    /**
     * Set valorEncampacao
     *
     * @param integer $valorEncampacao
     * @return DividaFundada
     */
    public function setValorEncampacao($valorEncampacao)
    {
        $this->valorEncampacao = $valorEncampacao;
        return $this;
    }

    /**
     * Get valorEncampacao
     *
     * @return integer
     */
    public function getValorEncampacao()
    {
        return $this->valorEncampacao;
    }

    /**
     * Set valorCorrecao
     *
     * @param integer $valorCorrecao
     * @return DividaFundada
     */
    public function setValorCorrecao($valorCorrecao)
    {
        $this->valorCorrecao = $valorCorrecao;
        return $this;
    }

    /**
     * Get valorCorrecao
     *
     * @return integer
     */
    public function getValorCorrecao()
    {
        return $this->valorCorrecao;
    }

    /**
     * Set valorSaldoAtual
     *
     * @param integer $valorSaldoAtual
     * @return DividaFundada
     */
    public function setValorSaldoAtual($valorSaldoAtual)
    {
        $this->valorSaldoAtual = $valorSaldoAtual;
        return $this;
    }

    /**
     * Get valorSaldoAtual
     *
     * @return integer
     */
    public function getValorSaldoAtual()
    {
        return $this->valorSaldoAtual;
    }
}
