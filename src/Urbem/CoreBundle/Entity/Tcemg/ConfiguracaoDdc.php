<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ConfiguracaoDdc
 */
class ConfiguracaoDdc
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
    private $mesReferencia;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $nroContratoDivida;

    /**
     * @var integer
     */
    private $codOrgao;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var \DateTime
     */
    private $dtAssinatura;

    /**
     * @var integer
     */
    private $contratoDecLei;

    /**
     * @var string
     */
    private $objetoContratoDivida;

    /**
     * @var string
     */
    private $especificacaoContratoDivida;

    /**
     * @var string
     */
    private $tipoLancamento;

    /**
     * @var string
     */
    private $justificativaCancelamento;

    /**
     * @var integer
     */
    private $numcgm;

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
    private $valorAtualizacao;

    /**
     * @var integer
     */
    private $valorSaldoAtual;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoDdc
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
     * Set mesReferencia
     *
     * @param integer $mesReferencia
     * @return ConfiguracaoDdc
     */
    public function setMesReferencia($mesReferencia)
    {
        $this->mesReferencia = $mesReferencia;
        return $this;
    }

    /**
     * Get mesReferencia
     *
     * @return integer
     */
    public function getMesReferencia()
    {
        return $this->mesReferencia;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ConfiguracaoDdc
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
     * Set nroContratoDivida
     *
     * @param string $nroContratoDivida
     * @return ConfiguracaoDdc
     */
    public function setNroContratoDivida($nroContratoDivida)
    {
        $this->nroContratoDivida = $nroContratoDivida;
        return $this;
    }

    /**
     * Get nroContratoDivida
     *
     * @return string
     */
    public function getNroContratoDivida()
    {
        return $this->nroContratoDivida;
    }

    /**
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return ConfiguracaoDdc
     */
    public function setCodOrgao($codOrgao = null)
    {
        $this->codOrgao = $codOrgao;
        return $this;
    }

    /**
     * Get codOrgao
     *
     * @return integer
     */
    public function getCodOrgao()
    {
        return $this->codOrgao;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return ConfiguracaoDdc
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
     * Set dtAssinatura
     *
     * @param \DateTime $dtAssinatura
     * @return ConfiguracaoDdc
     */
    public function setDtAssinatura(\DateTime $dtAssinatura = null)
    {
        $this->dtAssinatura = $dtAssinatura;
        return $this;
    }

    /**
     * Get dtAssinatura
     *
     * @return \DateTime
     */
    public function getDtAssinatura()
    {
        return $this->dtAssinatura;
    }

    /**
     * Set contratoDecLei
     *
     * @param integer $contratoDecLei
     * @return ConfiguracaoDdc
     */
    public function setContratoDecLei($contratoDecLei = null)
    {
        $this->contratoDecLei = $contratoDecLei;
        return $this;
    }

    /**
     * Get contratoDecLei
     *
     * @return integer
     */
    public function getContratoDecLei()
    {
        return $this->contratoDecLei;
    }

    /**
     * Set objetoContratoDivida
     *
     * @param string $objetoContratoDivida
     * @return ConfiguracaoDdc
     */
    public function setObjetoContratoDivida($objetoContratoDivida)
    {
        $this->objetoContratoDivida = $objetoContratoDivida;
        return $this;
    }

    /**
     * Get objetoContratoDivida
     *
     * @return string
     */
    public function getObjetoContratoDivida()
    {
        return $this->objetoContratoDivida;
    }

    /**
     * Set especificacaoContratoDivida
     *
     * @param string $especificacaoContratoDivida
     * @return ConfiguracaoDdc
     */
    public function setEspecificacaoContratoDivida($especificacaoContratoDivida)
    {
        $this->especificacaoContratoDivida = $especificacaoContratoDivida;
        return $this;
    }

    /**
     * Get especificacaoContratoDivida
     *
     * @return string
     */
    public function getEspecificacaoContratoDivida()
    {
        return $this->especificacaoContratoDivida;
    }

    /**
     * Set tipoLancamento
     *
     * @param string $tipoLancamento
     * @return ConfiguracaoDdc
     */
    public function setTipoLancamento($tipoLancamento)
    {
        $this->tipoLancamento = $tipoLancamento;
        return $this;
    }

    /**
     * Get tipoLancamento
     *
     * @return string
     */
    public function getTipoLancamento()
    {
        return $this->tipoLancamento;
    }

    /**
     * Set justificativaCancelamento
     *
     * @param string $justificativaCancelamento
     * @return ConfiguracaoDdc
     */
    public function setJustificativaCancelamento($justificativaCancelamento = null)
    {
        $this->justificativaCancelamento = $justificativaCancelamento;
        return $this;
    }

    /**
     * Get justificativaCancelamento
     *
     * @return string
     */
    public function getJustificativaCancelamento()
    {
        return $this->justificativaCancelamento;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ConfiguracaoDdc
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
     * Set valorSaldoAnterior
     *
     * @param integer $valorSaldoAnterior
     * @return ConfiguracaoDdc
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
     * @return ConfiguracaoDdc
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
     * @return ConfiguracaoDdc
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
     * @return ConfiguracaoDdc
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
     * @return ConfiguracaoDdc
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
     * Set valorAtualizacao
     *
     * @param integer $valorAtualizacao
     * @return ConfiguracaoDdc
     */
    public function setValorAtualizacao($valorAtualizacao)
    {
        $this->valorAtualizacao = $valorAtualizacao;
        return $this;
    }

    /**
     * Get valorAtualizacao
     *
     * @return integer
     */
    public function getValorAtualizacao()
    {
        return $this->valorAtualizacao;
    }

    /**
     * Set valorSaldoAtual
     *
     * @param integer $valorSaldoAtual
     * @return ConfiguracaoDdc
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

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ConfiguracaoDdc
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
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return ConfiguracaoDdc
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return ConfiguracaoDdc
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
