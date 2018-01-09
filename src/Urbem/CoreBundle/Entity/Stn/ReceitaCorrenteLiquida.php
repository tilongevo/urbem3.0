<?php
 
namespace Urbem\CoreBundle\Entity\Stn;

/**
 * ReceitaCorrenteLiquida
 */
class ReceitaCorrenteLiquida
{
    /**
     * PK
     * @var integer
     */
    private $mes;

    /**
     * PK
     * @var string
     */
    private $ano;

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
     * @var integer
     */
    private $valor;

    /**
     * @var integer
     */
    private $valorReceitaTributaria;

    /**
     * @var integer
     */
    private $valorReceitaContribuicoes;

    /**
     * @var integer
     */
    private $valorReceitaPatrimonial;

    /**
     * @var integer
     */
    private $valorReceitaAgropecuaria;

    /**
     * @var integer
     */
    private $valorReceitaIndustrial;

    /**
     * @var integer
     */
    private $valorReceitaServicos;

    /**
     * @var integer
     */
    private $valorTransferenciasCorrentes;

    /**
     * @var integer
     */
    private $valorOutrasReceitas;

    /**
     * @var integer
     */
    private $valorContribPlanoSss;

    /**
     * @var integer
     */
    private $valorCompensacaoFinanceira;

    /**
     * @var integer
     */
    private $valorDeducaoFundeb;

    /**
     * @var integer
     */
    private $valorIptu;

    /**
     * @var integer
     */
    private $valorIss;

    /**
     * @var integer
     */
    private $valorItbi;

    /**
     * @var integer
     */
    private $valorIrrf;

    /**
     * @var integer
     */
    private $valorOutrasReceitasTributarias;

    /**
     * @var integer
     */
    private $valorCotaParteFpm;

    /**
     * @var integer
     */
    private $valorCotaParteIcms;

    /**
     * @var integer
     */
    private $valorCotaParteIpva;

    /**
     * @var integer
     */
    private $valorCotaParteItr;

    /**
     * @var integer
     */
    private $valorTransferenciasLc871996;

    /**
     * @var integer
     */
    private $valorTransferenciasLc611989;

    /**
     * @var integer
     */
    private $valorTransferenciasFundeb;

    /**
     * @var integer
     */
    private $valorOutrasTransferenciasCorrentes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;


    /**
     * Set mes
     *
     * @param integer $mes
     * @return ReceitaCorrenteLiquida
     */
    public function setMes($mes)
    {
        $this->mes = $mes;
        return $this;
    }

    /**
     * Get mes
     *
     * @return integer
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * Set ano
     *
     * @param string $ano
     * @return ReceitaCorrenteLiquida
     */
    public function setAno($ano)
    {
        $this->ano = $ano;
        return $this;
    }

    /**
     * Get ano
     *
     * @return string
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ReceitaCorrenteLiquida
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
     * @return ReceitaCorrenteLiquida
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
     * Set valor
     *
     * @param integer $valor
     * @return ReceitaCorrenteLiquida
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set valorReceitaTributaria
     *
     * @param integer $valorReceitaTributaria
     * @return ReceitaCorrenteLiquida
     */
    public function setValorReceitaTributaria($valorReceitaTributaria = null)
    {
        $this->valorReceitaTributaria = $valorReceitaTributaria;
        return $this;
    }

    /**
     * Get valorReceitaTributaria
     *
     * @return integer
     */
    public function getValorReceitaTributaria()
    {
        return $this->valorReceitaTributaria;
    }

    /**
     * Set valorReceitaContribuicoes
     *
     * @param integer $valorReceitaContribuicoes
     * @return ReceitaCorrenteLiquida
     */
    public function setValorReceitaContribuicoes($valorReceitaContribuicoes = null)
    {
        $this->valorReceitaContribuicoes = $valorReceitaContribuicoes;
        return $this;
    }

    /**
     * Get valorReceitaContribuicoes
     *
     * @return integer
     */
    public function getValorReceitaContribuicoes()
    {
        return $this->valorReceitaContribuicoes;
    }

    /**
     * Set valorReceitaPatrimonial
     *
     * @param integer $valorReceitaPatrimonial
     * @return ReceitaCorrenteLiquida
     */
    public function setValorReceitaPatrimonial($valorReceitaPatrimonial = null)
    {
        $this->valorReceitaPatrimonial = $valorReceitaPatrimonial;
        return $this;
    }

    /**
     * Get valorReceitaPatrimonial
     *
     * @return integer
     */
    public function getValorReceitaPatrimonial()
    {
        return $this->valorReceitaPatrimonial;
    }

    /**
     * Set valorReceitaAgropecuaria
     *
     * @param integer $valorReceitaAgropecuaria
     * @return ReceitaCorrenteLiquida
     */
    public function setValorReceitaAgropecuaria($valorReceitaAgropecuaria = null)
    {
        $this->valorReceitaAgropecuaria = $valorReceitaAgropecuaria;
        return $this;
    }

    /**
     * Get valorReceitaAgropecuaria
     *
     * @return integer
     */
    public function getValorReceitaAgropecuaria()
    {
        return $this->valorReceitaAgropecuaria;
    }

    /**
     * Set valorReceitaIndustrial
     *
     * @param integer $valorReceitaIndustrial
     * @return ReceitaCorrenteLiquida
     */
    public function setValorReceitaIndustrial($valorReceitaIndustrial = null)
    {
        $this->valorReceitaIndustrial = $valorReceitaIndustrial;
        return $this;
    }

    /**
     * Get valorReceitaIndustrial
     *
     * @return integer
     */
    public function getValorReceitaIndustrial()
    {
        return $this->valorReceitaIndustrial;
    }

    /**
     * Set valorReceitaServicos
     *
     * @param integer $valorReceitaServicos
     * @return ReceitaCorrenteLiquida
     */
    public function setValorReceitaServicos($valorReceitaServicos = null)
    {
        $this->valorReceitaServicos = $valorReceitaServicos;
        return $this;
    }

    /**
     * Get valorReceitaServicos
     *
     * @return integer
     */
    public function getValorReceitaServicos()
    {
        return $this->valorReceitaServicos;
    }

    /**
     * Set valorTransferenciasCorrentes
     *
     * @param integer $valorTransferenciasCorrentes
     * @return ReceitaCorrenteLiquida
     */
    public function setValorTransferenciasCorrentes($valorTransferenciasCorrentes = null)
    {
        $this->valorTransferenciasCorrentes = $valorTransferenciasCorrentes;
        return $this;
    }

    /**
     * Get valorTransferenciasCorrentes
     *
     * @return integer
     */
    public function getValorTransferenciasCorrentes()
    {
        return $this->valorTransferenciasCorrentes;
    }

    /**
     * Set valorOutrasReceitas
     *
     * @param integer $valorOutrasReceitas
     * @return ReceitaCorrenteLiquida
     */
    public function setValorOutrasReceitas($valorOutrasReceitas = null)
    {
        $this->valorOutrasReceitas = $valorOutrasReceitas;
        return $this;
    }

    /**
     * Get valorOutrasReceitas
     *
     * @return integer
     */
    public function getValorOutrasReceitas()
    {
        return $this->valorOutrasReceitas;
    }

    /**
     * Set valorContribPlanoSss
     *
     * @param integer $valorContribPlanoSss
     * @return ReceitaCorrenteLiquida
     */
    public function setValorContribPlanoSss($valorContribPlanoSss = null)
    {
        $this->valorContribPlanoSss = $valorContribPlanoSss;
        return $this;
    }

    /**
     * Get valorContribPlanoSss
     *
     * @return integer
     */
    public function getValorContribPlanoSss()
    {
        return $this->valorContribPlanoSss;
    }

    /**
     * Set valorCompensacaoFinanceira
     *
     * @param integer $valorCompensacaoFinanceira
     * @return ReceitaCorrenteLiquida
     */
    public function setValorCompensacaoFinanceira($valorCompensacaoFinanceira = null)
    {
        $this->valorCompensacaoFinanceira = $valorCompensacaoFinanceira;
        return $this;
    }

    /**
     * Get valorCompensacaoFinanceira
     *
     * @return integer
     */
    public function getValorCompensacaoFinanceira()
    {
        return $this->valorCompensacaoFinanceira;
    }

    /**
     * Set valorDeducaoFundeb
     *
     * @param integer $valorDeducaoFundeb
     * @return ReceitaCorrenteLiquida
     */
    public function setValorDeducaoFundeb($valorDeducaoFundeb = null)
    {
        $this->valorDeducaoFundeb = $valorDeducaoFundeb;
        return $this;
    }

    /**
     * Get valorDeducaoFundeb
     *
     * @return integer
     */
    public function getValorDeducaoFundeb()
    {
        return $this->valorDeducaoFundeb;
    }

    /**
     * Set valorIptu
     *
     * @param integer $valorIptu
     * @return ReceitaCorrenteLiquida
     */
    public function setValorIptu($valorIptu = null)
    {
        $this->valorIptu = $valorIptu;
        return $this;
    }

    /**
     * Get valorIptu
     *
     * @return integer
     */
    public function getValorIptu()
    {
        return $this->valorIptu;
    }

    /**
     * Set valorIss
     *
     * @param integer $valorIss
     * @return ReceitaCorrenteLiquida
     */
    public function setValorIss($valorIss = null)
    {
        $this->valorIss = $valorIss;
        return $this;
    }

    /**
     * Get valorIss
     *
     * @return integer
     */
    public function getValorIss()
    {
        return $this->valorIss;
    }

    /**
     * Set valorItbi
     *
     * @param integer $valorItbi
     * @return ReceitaCorrenteLiquida
     */
    public function setValorItbi($valorItbi = null)
    {
        $this->valorItbi = $valorItbi;
        return $this;
    }

    /**
     * Get valorItbi
     *
     * @return integer
     */
    public function getValorItbi()
    {
        return $this->valorItbi;
    }

    /**
     * Set valorIrrf
     *
     * @param integer $valorIrrf
     * @return ReceitaCorrenteLiquida
     */
    public function setValorIrrf($valorIrrf = null)
    {
        $this->valorIrrf = $valorIrrf;
        return $this;
    }

    /**
     * Get valorIrrf
     *
     * @return integer
     */
    public function getValorIrrf()
    {
        return $this->valorIrrf;
    }

    /**
     * Set valorOutrasReceitasTributarias
     *
     * @param integer $valorOutrasReceitasTributarias
     * @return ReceitaCorrenteLiquida
     */
    public function setValorOutrasReceitasTributarias($valorOutrasReceitasTributarias = null)
    {
        $this->valorOutrasReceitasTributarias = $valorOutrasReceitasTributarias;
        return $this;
    }

    /**
     * Get valorOutrasReceitasTributarias
     *
     * @return integer
     */
    public function getValorOutrasReceitasTributarias()
    {
        return $this->valorOutrasReceitasTributarias;
    }

    /**
     * Set valorCotaParteFpm
     *
     * @param integer $valorCotaParteFpm
     * @return ReceitaCorrenteLiquida
     */
    public function setValorCotaParteFpm($valorCotaParteFpm = null)
    {
        $this->valorCotaParteFpm = $valorCotaParteFpm;
        return $this;
    }

    /**
     * Get valorCotaParteFpm
     *
     * @return integer
     */
    public function getValorCotaParteFpm()
    {
        return $this->valorCotaParteFpm;
    }

    /**
     * Set valorCotaParteIcms
     *
     * @param integer $valorCotaParteIcms
     * @return ReceitaCorrenteLiquida
     */
    public function setValorCotaParteIcms($valorCotaParteIcms = null)
    {
        $this->valorCotaParteIcms = $valorCotaParteIcms;
        return $this;
    }

    /**
     * Get valorCotaParteFpm
     *
     * @return integer
     */
    public function getValorCotaParteIcms()
    {
        return $this->valorCotaParteIcms;
    }

    /**
     * Set valorCotaParteIpva
     *
     * @param integer $valorCotaParteIpva
     * @return ReceitaCorrenteLiquida
     */
    public function setValorCotaParteIpva($valorCotaParteIpva = null)
    {
        $this->valorCotaParteIpva = $valorCotaParteIpva;
        return $this;
    }

    /**
     * Get valorCotaParteIpva
     *
     * @return integer
     */
    public function getValorCotaParteIpva()
    {
        return $this->valorCotaParteIpva;
    }

    /**
     * Set valorCotaParteItr
     *
     * @param integer $valorCotaParteItr
     * @return ReceitaCorrenteLiquida
     */
    public function setValorCotaParteItr($valorCotaParteItr = null)
    {
        $this->valorCotaParteItr = $valorCotaParteItr;
        return $this;
    }

    /**
     * Get valorCotaParteIpva
     *
     * @return integer
     */
    public function getValorCotaParteItr()
    {
        return $this->valorCotaParteItr;
    }

    /**
     * Set valorTransferenciasLc871996
     *
     * @param integer $valorTransferenciasLc871996
     * @return ReceitaCorrenteLiquida
     */
    public function setValorTransferenciasLc871996($valorTransferenciasLc871996 = null)
    {
        $this->valorTransferenciasLc871996 = $valorTransferenciasLc871996;
        return $this;
    }

    /**
     * Get valorTransferenciasLc871996
     *
     * @return integer
     */
    public function getValorTransferenciasLc871996()
    {
        return $this->valorTransferenciasLc871996;
    }

    /**
     * Set valorTransferenciasLc611989
     *
     * @param integer $valorTransferenciasLc611989
     * @return ReceitaCorrenteLiquida
     */
    public function setValorTransferenciasLc611989($valorTransferenciasLc611989 = null)
    {
        $this->valorTransferenciasLc611989 = $valorTransferenciasLc611989;
        return $this;
    }

    /**
     * Get valorTransferenciasLc611989
     *
     * @return integer
     */
    public function getValorTransferenciasLc611989()
    {
        return $this->valorTransferenciasLc611989;
    }

    /**
     * Set valorTransferenciasFundeb
     *
     * @param integer $valorTransferenciasFundeb
     * @return ReceitaCorrenteLiquida
     */
    public function setValorTransferenciasFundeb($valorTransferenciasFundeb = null)
    {
        $this->valorTransferenciasFundeb = $valorTransferenciasFundeb;
        return $this;
    }

    /**
     * Get valorTransferenciasFundeb
     *
     * @return integer
     */
    public function getValorTransferenciasFundeb()
    {
        return $this->valorTransferenciasFundeb;
    }

    /**
     * Set valorOutrasTransferenciasCorrentes
     *
     * @param integer $valorOutrasTransferenciasCorrentes
     * @return ReceitaCorrenteLiquida
     */
    public function setValorOutrasTransferenciasCorrentes($valorOutrasTransferenciasCorrentes = null)
    {
        $this->valorOutrasTransferenciasCorrentes = $valorOutrasTransferenciasCorrentes;
        return $this;
    }

    /**
     * Get valorOutrasTransferenciasCorrentes
     *
     * @return integer
     */
    public function getValorOutrasTransferenciasCorrentes()
    {
        return $this->valorOutrasTransferenciasCorrentes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return ReceitaCorrenteLiquida
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }
}
