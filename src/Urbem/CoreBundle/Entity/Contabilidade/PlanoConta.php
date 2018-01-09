<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * PlanoConta
 */
class PlanoConta
{
    /**
     * PK
     * @var integer
     */
    private $codConta;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $nomConta;

    /**
     * @var integer
     */
    private $codClassificacao;

    /**
     * @var integer
     */
    private $codSistema;

    /**
     * @var string
     */
    private $codEstrutural;

    /**
     * @var string
     */
    private $escrituracao;

    /**
     * @var string
     */
    private $naturezaSaldo;

    /**
     * @var string
     */
    private $indicadorSuperavit;

    /**
     * @var string
     */
    private $funcao;

    /**
     * @var integer
     */
    private $atributoTcepe;

    /**
     * @var integer
     */
    private $atributoTcemg;

    /**
     * @var string
     */
    private $escrituracaoPcasp = 'N';

    /**
     * @var boolean
     */
    private $obrigatorioTcmgo = false;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\ContaContabilRpNp
     */
    private $fkContabilidadeContaContabilRpNp;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoContaEncerrada
     */
    private $fkContabilidadePlanoContaEncerrada;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfIrrfPlanoConta
     */
    private $fkImaConfiguracaoDirfIrrfPlanoConta;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Manad\PlanoContaEntidade
     */
    private $fkManadPlanoContaEntidade;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcemg\ContaBancaria
     */
    private $fkTcemgContaBancaria;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcerj\PlanoConta
     */
    private $fkTcerjPlanoConta;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcers\RdExtra
     */
    private $fkTcersRdExtra;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcers\PlanoContaEntidade
     */
    private $fkTcersPlanoContaEntidade;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcmgo\BalancoBlpaaaa
     */
    private $fkTcmgoBalancoBlpaaaa;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcmgo\BalancoPfraaaa
     */
    private $fkTcmgoBalancoPfraaaa;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoContasExtras
     */
    private $fkContabilidadeConfiguracaoContasExtras;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcepb\PlanoContaTipoTransferencia
     */
    private $fkTcepbPlanoContaTipoTransferencia;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfInss
     */
    private $fkImaConfiguracaoDirfInss;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Manad\RdExtra
     */
    private $fkManadRdExtra;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoCredito
     */
    private $fkContabilidadeConfiguracaoLancamentoCreditos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoDebito
     */
    private $fkContabilidadeConfiguracaoLancamentoDebitos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoReceita
     */
    private $fkContabilidadeConfiguracaoLancamentoReceitas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\PlanoContaModeloLrf
     */
    private $fkManadPlanoContaModeloLrfs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoTributario
     */
    private $fkOrcamentoReceitaCreditoTributarios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\PlanoContaModeloLrf
     */
    private $fkTcersPlanoContaModeloLrfs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ArquivoPct
     */
    private $fkTcmgoArquivoPcts;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\VinculoPlanoContasTcmgo
     */
    private $fkTcmgoVinculoPlanoContasTcmgos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ClassificacaoPlano
     */
    private $fkContabilidadeClassificacaoPlanos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\ClassificacaoContabil
     */
    private $fkContabilidadeClassificacaoContabil;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\SistemaContabil
     */
    private $fkContabilidadeSistemaContabil;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepe\TipoContaCorrente
     */
    private $fkTcepeTipoContaCorrente;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\TipoContaCorrente
     */
    private $fkTcemgTipoContaCorrente;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkContabilidadeConfiguracaoLancamentoCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeConfiguracaoLancamentoDebitos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeConfiguracaoLancamentoReceitas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkManadPlanoContaModeloLrfs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoReceitaCreditoTributarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcersPlanoContaModeloLrfs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoArquivoPcts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoVinculoPlanoContasTcmgos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeClassificacaoPlanos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return PlanoConta
     */
    public function setCodConta($codConta)
    {
        $this->codConta = $codConta;
        return $this;
    }

    /**
     * Get codConta
     *
     * @return integer
     */
    public function getCodConta()
    {
        return $this->codConta;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PlanoConta
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
     * Set nomConta
     *
     * @param string $nomConta
     * @return PlanoConta
     */
    public function setNomConta($nomConta)
    {
        $this->nomConta = $nomConta;
        return $this;
    }

    /**
     * Get nomConta
     *
     * @return string
     */
    public function getNomConta()
    {
        return $this->nomConta;
    }

    /**
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return PlanoConta
     */
    public function setCodClassificacao($codClassificacao)
    {
        $this->codClassificacao = $codClassificacao;
        return $this;
    }

    /**
     * Get codClassificacao
     *
     * @return integer
     */
    public function getCodClassificacao()
    {
        return $this->codClassificacao;
    }

    /**
     * Set codSistema
     *
     * @param integer $codSistema
     * @return PlanoConta
     */
    public function setCodSistema($codSistema)
    {
        $this->codSistema = $codSistema;
        return $this;
    }

    /**
     * Get codSistema
     *
     * @return integer
     */
    public function getCodSistema()
    {
        return $this->codSistema;
    }

    /**
     * Set codEstrutural
     *
     * @param string $codEstrutural
     * @return PlanoConta
     */
    public function setCodEstrutural($codEstrutural)
    {
        $this->codEstrutural = $codEstrutural;
        return $this;
    }

    /**
     * Get codEstrutural
     *
     * @return string
     */
    public function getCodEstrutural()
    {
        return $this->codEstrutural;
    }

    /**
     * Set escrituracao
     *
     * @param string $escrituracao
     * @return PlanoConta
     */
    public function setEscrituracao($escrituracao = null)
    {
        $this->escrituracao = $escrituracao;
        return $this;
    }

    /**
     * Get escrituracao
     *
     * @return string
     */
    public function getEscrituracao()
    {
        return $this->escrituracao;
    }

    /**
     * Set naturezaSaldo
     *
     * @param string $naturezaSaldo
     * @return PlanoConta
     */
    public function setNaturezaSaldo($naturezaSaldo = null)
    {
        $this->naturezaSaldo = $naturezaSaldo;
        return $this;
    }

    /**
     * Get naturezaSaldo
     *
     * @return string
     */
    public function getNaturezaSaldo()
    {
        return $this->naturezaSaldo;
    }

    /**
     * Set indicadorSuperavit
     *
     * @param string $indicadorSuperavit
     * @return PlanoConta
     */
    public function setIndicadorSuperavit($indicadorSuperavit = null)
    {
        $this->indicadorSuperavit = $indicadorSuperavit;
        return $this;
    }

    /**
     * Get indicadorSuperavit
     *
     * @return string
     */
    public function getIndicadorSuperavit()
    {
        return $this->indicadorSuperavit;
    }

    /**
     * Set funcao
     *
     * @param string $funcao
     * @return PlanoConta
     */
    public function setFuncao($funcao = null)
    {
        $this->funcao = $funcao;
        return $this;
    }

    /**
     * Get funcao
     *
     * @return string
     */
    public function getFuncao()
    {
        return $this->funcao;
    }

    /**
     * Set atributoTcepe
     *
     * @param integer $atributoTcepe
     * @return PlanoConta
     */
    public function setAtributoTcepe($atributoTcepe = null)
    {
        $this->atributoTcepe = $atributoTcepe;
        return $this;
    }

    /**
     * Get atributoTcepe
     *
     * @return integer
     */
    public function getAtributoTcepe()
    {
        return $this->atributoTcepe;
    }

    /**
     * Set atributoTcemg
     *
     * @param integer $atributoTcemg
     * @return PlanoConta
     */
    public function setAtributoTcemg($atributoTcemg = null)
    {
        $this->atributoTcemg = $atributoTcemg;
        return $this;
    }

    /**
     * Get atributoTcemg
     *
     * @return integer
     */
    public function getAtributoTcemg()
    {
        return $this->atributoTcemg;
    }

    /**
     * Set escrituracaoPcasp
     *
     * @param string $escrituracaoPcasp
     * @return PlanoConta
     */
    public function setEscrituracaoPcasp($escrituracaoPcasp)
    {
        $this->escrituracaoPcasp = $escrituracaoPcasp;
        return $this;
    }

    /**
     * Get escrituracaoPcasp
     *
     * @return string
     */
    public function getEscrituracaoPcasp()
    {
        return $this->escrituracaoPcasp;
    }

    /**
     * Set obrigatorioTcmgo
     *
     * @param boolean $obrigatorioTcmgo
     * @return PlanoConta
     */
    public function setObrigatorioTcmgo($obrigatorioTcmgo)
    {
        $this->obrigatorioTcmgo = $obrigatorioTcmgo;
        return $this;
    }

    /**
     * Get obrigatorioTcmgo
     *
     * @return boolean
     */
    public function getObrigatorioTcmgo()
    {
        return $this->obrigatorioTcmgo;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeConfiguracaoLancamentoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoCredito $fkContabilidadeConfiguracaoLancamentoCredito
     * @return PlanoConta
     */
    public function addFkContabilidadeConfiguracaoLancamentoCreditos(\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoCredito $fkContabilidadeConfiguracaoLancamentoCredito)
    {
        if (false === $this->fkContabilidadeConfiguracaoLancamentoCreditos->contains($fkContabilidadeConfiguracaoLancamentoCredito)) {
            $fkContabilidadeConfiguracaoLancamentoCredito->setFkContabilidadePlanoConta($this);
            $this->fkContabilidadeConfiguracaoLancamentoCreditos->add($fkContabilidadeConfiguracaoLancamentoCredito);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeConfiguracaoLancamentoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoCredito $fkContabilidadeConfiguracaoLancamentoCredito
     */
    public function removeFkContabilidadeConfiguracaoLancamentoCreditos(\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoCredito $fkContabilidadeConfiguracaoLancamentoCredito)
    {
        $this->fkContabilidadeConfiguracaoLancamentoCreditos->removeElement($fkContabilidadeConfiguracaoLancamentoCredito);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeConfiguracaoLancamentoCreditos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoCredito
     */
    public function getFkContabilidadeConfiguracaoLancamentoCreditos()
    {
        return $this->fkContabilidadeConfiguracaoLancamentoCreditos;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeConfiguracaoLancamentoDebito
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoDebito $fkContabilidadeConfiguracaoLancamentoDebito
     * @return PlanoConta
     */
    public function addFkContabilidadeConfiguracaoLancamentoDebitos(\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoDebito $fkContabilidadeConfiguracaoLancamentoDebito)
    {
        if (false === $this->fkContabilidadeConfiguracaoLancamentoDebitos->contains($fkContabilidadeConfiguracaoLancamentoDebito)) {
            $fkContabilidadeConfiguracaoLancamentoDebito->setFkContabilidadePlanoConta($this);
            $this->fkContabilidadeConfiguracaoLancamentoDebitos->add($fkContabilidadeConfiguracaoLancamentoDebito);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeConfiguracaoLancamentoDebito
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoDebito $fkContabilidadeConfiguracaoLancamentoDebito
     */
    public function removeFkContabilidadeConfiguracaoLancamentoDebitos(\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoDebito $fkContabilidadeConfiguracaoLancamentoDebito)
    {
        $this->fkContabilidadeConfiguracaoLancamentoDebitos->removeElement($fkContabilidadeConfiguracaoLancamentoDebito);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeConfiguracaoLancamentoDebitos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoDebito
     */
    public function getFkContabilidadeConfiguracaoLancamentoDebitos()
    {
        return $this->fkContabilidadeConfiguracaoLancamentoDebitos;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeConfiguracaoLancamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoReceita $fkContabilidadeConfiguracaoLancamentoReceita
     * @return PlanoConta
     */
    public function addFkContabilidadeConfiguracaoLancamentoReceitas(\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoReceita $fkContabilidadeConfiguracaoLancamentoReceita)
    {
        if (false === $this->fkContabilidadeConfiguracaoLancamentoReceitas->contains($fkContabilidadeConfiguracaoLancamentoReceita)) {
            $fkContabilidadeConfiguracaoLancamentoReceita->setFkContabilidadePlanoConta($this);
            $this->fkContabilidadeConfiguracaoLancamentoReceitas->add($fkContabilidadeConfiguracaoLancamentoReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeConfiguracaoLancamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoReceita $fkContabilidadeConfiguracaoLancamentoReceita
     */
    public function removeFkContabilidadeConfiguracaoLancamentoReceitas(\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoReceita $fkContabilidadeConfiguracaoLancamentoReceita)
    {
        $this->fkContabilidadeConfiguracaoLancamentoReceitas->removeElement($fkContabilidadeConfiguracaoLancamentoReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeConfiguracaoLancamentoReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoReceita
     */
    public function getFkContabilidadeConfiguracaoLancamentoReceitas()
    {
        return $this->fkContabilidadeConfiguracaoLancamentoReceitas;
    }

    /**
     * OneToMany (owning side)
     * Add ManadPlanoContaModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Manad\PlanoContaModeloLrf $fkManadPlanoContaModeloLrf
     * @return PlanoConta
     */
    public function addFkManadPlanoContaModeloLrfs(\Urbem\CoreBundle\Entity\Manad\PlanoContaModeloLrf $fkManadPlanoContaModeloLrf)
    {
        if (false === $this->fkManadPlanoContaModeloLrfs->contains($fkManadPlanoContaModeloLrf)) {
            $fkManadPlanoContaModeloLrf->setFkContabilidadePlanoConta($this);
            $this->fkManadPlanoContaModeloLrfs->add($fkManadPlanoContaModeloLrf);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ManadPlanoContaModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Manad\PlanoContaModeloLrf $fkManadPlanoContaModeloLrf
     */
    public function removeFkManadPlanoContaModeloLrfs(\Urbem\CoreBundle\Entity\Manad\PlanoContaModeloLrf $fkManadPlanoContaModeloLrf)
    {
        $this->fkManadPlanoContaModeloLrfs->removeElement($fkManadPlanoContaModeloLrf);
    }

    /**
     * OneToMany (owning side)
     * Get fkManadPlanoContaModeloLrfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\PlanoContaModeloLrf
     */
    public function getFkManadPlanoContaModeloLrfs()
    {
        return $this->fkManadPlanoContaModeloLrfs;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoReceitaCreditoTributario
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoTributario $fkOrcamentoReceitaCreditoTributario
     * @return PlanoConta
     */
    public function addFkOrcamentoReceitaCreditoTributarios(\Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoTributario $fkOrcamentoReceitaCreditoTributario)
    {
        if (false === $this->fkOrcamentoReceitaCreditoTributarios->contains($fkOrcamentoReceitaCreditoTributario)) {
            $fkOrcamentoReceitaCreditoTributario->setFkContabilidadePlanoConta($this);
            $this->fkOrcamentoReceitaCreditoTributarios->add($fkOrcamentoReceitaCreditoTributario);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoReceitaCreditoTributario
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoTributario $fkOrcamentoReceitaCreditoTributario
     */
    public function removeFkOrcamentoReceitaCreditoTributarios(\Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoTributario $fkOrcamentoReceitaCreditoTributario)
    {
        $this->fkOrcamentoReceitaCreditoTributarios->removeElement($fkOrcamentoReceitaCreditoTributario);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoReceitaCreditoTributarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoTributario
     */
    public function getFkOrcamentoReceitaCreditoTributarios()
    {
        return $this->fkOrcamentoReceitaCreditoTributarios;
    }

    /**
     * OneToMany (owning side)
     * Add TcersPlanoContaModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\PlanoContaModeloLrf $fkTcersPlanoContaModeloLrf
     * @return PlanoConta
     */
    public function addFkTcersPlanoContaModeloLrfs(\Urbem\CoreBundle\Entity\Tcers\PlanoContaModeloLrf $fkTcersPlanoContaModeloLrf)
    {
        if (false === $this->fkTcersPlanoContaModeloLrfs->contains($fkTcersPlanoContaModeloLrf)) {
            $fkTcersPlanoContaModeloLrf->setFkContabilidadePlanoConta($this);
            $this->fkTcersPlanoContaModeloLrfs->add($fkTcersPlanoContaModeloLrf);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcersPlanoContaModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\PlanoContaModeloLrf $fkTcersPlanoContaModeloLrf
     */
    public function removeFkTcersPlanoContaModeloLrfs(\Urbem\CoreBundle\Entity\Tcers\PlanoContaModeloLrf $fkTcersPlanoContaModeloLrf)
    {
        $this->fkTcersPlanoContaModeloLrfs->removeElement($fkTcersPlanoContaModeloLrf);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcersPlanoContaModeloLrfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\PlanoContaModeloLrf
     */
    public function getFkTcersPlanoContaModeloLrfs()
    {
        return $this->fkTcersPlanoContaModeloLrfs;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoArquivoPct
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ArquivoPct $fkTcmgoArquivoPct
     * @return PlanoConta
     */
    public function addFkTcmgoArquivoPcts(\Urbem\CoreBundle\Entity\Tcmgo\ArquivoPct $fkTcmgoArquivoPct)
    {
        if (false === $this->fkTcmgoArquivoPcts->contains($fkTcmgoArquivoPct)) {
            $fkTcmgoArquivoPct->setFkContabilidadePlanoConta($this);
            $this->fkTcmgoArquivoPcts->add($fkTcmgoArquivoPct);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoArquivoPct
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ArquivoPct $fkTcmgoArquivoPct
     */
    public function removeFkTcmgoArquivoPcts(\Urbem\CoreBundle\Entity\Tcmgo\ArquivoPct $fkTcmgoArquivoPct)
    {
        $this->fkTcmgoArquivoPcts->removeElement($fkTcmgoArquivoPct);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoArquivoPcts
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ArquivoPct
     */
    public function getFkTcmgoArquivoPcts()
    {
        return $this->fkTcmgoArquivoPcts;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoVinculoPlanoContasTcmgo
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\VinculoPlanoContasTcmgo $fkTcmgoVinculoPlanoContasTcmgo
     * @return PlanoConta
     */
    public function addFkTcmgoVinculoPlanoContasTcmgos(\Urbem\CoreBundle\Entity\Tcmgo\VinculoPlanoContasTcmgo $fkTcmgoVinculoPlanoContasTcmgo)
    {
        if (false === $this->fkTcmgoVinculoPlanoContasTcmgos->contains($fkTcmgoVinculoPlanoContasTcmgo)) {
            $fkTcmgoVinculoPlanoContasTcmgo->setFkContabilidadePlanoConta($this);
            $this->fkTcmgoVinculoPlanoContasTcmgos->add($fkTcmgoVinculoPlanoContasTcmgo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoVinculoPlanoContasTcmgo
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\VinculoPlanoContasTcmgo $fkTcmgoVinculoPlanoContasTcmgo
     */
    public function removeFkTcmgoVinculoPlanoContasTcmgos(\Urbem\CoreBundle\Entity\Tcmgo\VinculoPlanoContasTcmgo $fkTcmgoVinculoPlanoContasTcmgo)
    {
        $this->fkTcmgoVinculoPlanoContasTcmgos->removeElement($fkTcmgoVinculoPlanoContasTcmgo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoVinculoPlanoContasTcmgos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\VinculoPlanoContasTcmgo
     */
    public function getFkTcmgoVinculoPlanoContasTcmgos()
    {
        return $this->fkTcmgoVinculoPlanoContasTcmgos;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeClassificacaoPlano
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ClassificacaoPlano $fkContabilidadeClassificacaoPlano
     * @return PlanoConta
     */
    public function addFkContabilidadeClassificacaoPlanos(\Urbem\CoreBundle\Entity\Contabilidade\ClassificacaoPlano $fkContabilidadeClassificacaoPlano)
    {
        if (false === $this->fkContabilidadeClassificacaoPlanos->contains($fkContabilidadeClassificacaoPlano)) {
            $fkContabilidadeClassificacaoPlano->setFkContabilidadePlanoConta($this);
            $this->fkContabilidadeClassificacaoPlanos->add($fkContabilidadeClassificacaoPlano);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeClassificacaoPlano
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ClassificacaoPlano $fkContabilidadeClassificacaoPlano
     */
    public function removeFkContabilidadeClassificacaoPlanos(\Urbem\CoreBundle\Entity\Contabilidade\ClassificacaoPlano $fkContabilidadeClassificacaoPlano)
    {
        $this->fkContabilidadeClassificacaoPlanos->removeElement($fkContabilidadeClassificacaoPlano);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeClassificacaoPlanos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ClassificacaoPlano
     */
    public function getFkContabilidadeClassificacaoPlanos()
    {
        return $this->fkContabilidadeClassificacaoPlanos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadeClassificacaoContabil
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ClassificacaoContabil $fkContabilidadeClassificacaoContabil
     * @return PlanoConta
     */
    public function setFkContabilidadeClassificacaoContabil(\Urbem\CoreBundle\Entity\Contabilidade\ClassificacaoContabil $fkContabilidadeClassificacaoContabil)
    {
        $this->codClassificacao = $fkContabilidadeClassificacaoContabil->getCodClassificacao();
        $this->exercicio = $fkContabilidadeClassificacaoContabil->getExercicio();
        $this->fkContabilidadeClassificacaoContabil = $fkContabilidadeClassificacaoContabil;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadeClassificacaoContabil
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\ClassificacaoContabil
     */
    public function getFkContabilidadeClassificacaoContabil()
    {
        return $this->fkContabilidadeClassificacaoContabil;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadeSistemaContabil
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\SistemaContabil $fkContabilidadeSistemaContabil
     * @return PlanoConta
     */
    public function setFkContabilidadeSistemaContabil(\Urbem\CoreBundle\Entity\Contabilidade\SistemaContabil $fkContabilidadeSistemaContabil)
    {
        $this->codSistema = $fkContabilidadeSistemaContabil->getCodSistema();
        $this->exercicio = $fkContabilidadeSistemaContabil->getExercicio();
        $this->fkContabilidadeSistemaContabil = $fkContabilidadeSistemaContabil;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadeSistemaContabil
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\SistemaContabil
     */
    public function getFkContabilidadeSistemaContabil()
    {
        return $this->fkContabilidadeSistemaContabil;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcepeTipoContaCorrente
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\TipoContaCorrente $fkTcepeTipoContaCorrente
     * @return PlanoConta
     */
    public function setFkTcepeTipoContaCorrente(\Urbem\CoreBundle\Entity\Tcepe\TipoContaCorrente $fkTcepeTipoContaCorrente)
    {
        $this->atributoTcepe = $fkTcepeTipoContaCorrente->getCodTipo();
        $this->fkTcepeTipoContaCorrente = $fkTcepeTipoContaCorrente;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepeTipoContaCorrente
     *
     * @return \Urbem\CoreBundle\Entity\Tcepe\TipoContaCorrente
     */
    public function getFkTcepeTipoContaCorrente()
    {
        return $this->fkTcepeTipoContaCorrente;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgTipoContaCorrente
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TipoContaCorrente $fkTcemgTipoContaCorrente
     * @return PlanoConta
     */
    public function setFkTcemgTipoContaCorrente(\Urbem\CoreBundle\Entity\Tcemg\TipoContaCorrente $fkTcemgTipoContaCorrente)
    {
        $this->atributoTcemg = $fkTcemgTipoContaCorrente->getCodTipo();
        $this->fkTcemgTipoContaCorrente = $fkTcemgTipoContaCorrente;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgTipoContaCorrente
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\TipoContaCorrente
     */
    public function getFkTcemgTipoContaCorrente()
    {
        return $this->fkTcemgTipoContaCorrente;
    }

    /**
     * OneToOne (inverse side)
     * Set ContabilidadeContaContabilRpNp
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ContaContabilRpNp $fkContabilidadeContaContabilRpNp
     * @return PlanoConta
     */
    public function setFkContabilidadeContaContabilRpNp(\Urbem\CoreBundle\Entity\Contabilidade\ContaContabilRpNp $fkContabilidadeContaContabilRpNp)
    {
        $fkContabilidadeContaContabilRpNp->setFkContabilidadePlanoConta($this);
        $this->fkContabilidadeContaContabilRpNp = $fkContabilidadeContaContabilRpNp;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkContabilidadeContaContabilRpNp
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\ContaContabilRpNp
     */
    public function getFkContabilidadeContaContabilRpNp()
    {
        return $this->fkContabilidadeContaContabilRpNp;
    }

    /**
     * OneToOne (inverse side)
     * Set ContabilidadePlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica
     * @return PlanoConta
     */
    public function setFkContabilidadePlanoAnalitica(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica)
    {
        $fkContabilidadePlanoAnalitica->setFkContabilidadePlanoConta($this);
        $this->fkContabilidadePlanoAnalitica = $fkContabilidadePlanoAnalitica;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkContabilidadePlanoAnalitica
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica()
    {
        return $this->fkContabilidadePlanoAnalitica;
    }

    /**
     * OneToOne (inverse side)
     * Set ContabilidadePlanoContaEncerrada
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoContaEncerrada $fkContabilidadePlanoContaEncerrada
     * @return PlanoConta
     */
    public function setFkContabilidadePlanoContaEncerrada(\Urbem\CoreBundle\Entity\Contabilidade\PlanoContaEncerrada $fkContabilidadePlanoContaEncerrada)
    {
        $fkContabilidadePlanoContaEncerrada->setFkContabilidadePlanoConta($this);
        $this->fkContabilidadePlanoContaEncerrada = $fkContabilidadePlanoContaEncerrada;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkContabilidadePlanoContaEncerrada
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoContaEncerrada
     */
    public function getFkContabilidadePlanoContaEncerrada()
    {
        return $this->fkContabilidadePlanoContaEncerrada;
    }

    /**
     * OneToOne (inverse side)
     * Set ImaConfiguracaoDirfIrrfPlanoConta
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfIrrfPlanoConta $fkImaConfiguracaoDirfIrrfPlanoConta
     * @return PlanoConta
     */
    public function setFkImaConfiguracaoDirfIrrfPlanoConta(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfIrrfPlanoConta $fkImaConfiguracaoDirfIrrfPlanoConta)
    {
        $fkImaConfiguracaoDirfIrrfPlanoConta->setFkContabilidadePlanoConta($this);
        $this->fkImaConfiguracaoDirfIrrfPlanoConta = $fkImaConfiguracaoDirfIrrfPlanoConta;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImaConfiguracaoDirfIrrfPlanoConta
     *
     * @return \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfIrrfPlanoConta
     */
    public function getFkImaConfiguracaoDirfIrrfPlanoConta()
    {
        return $this->fkImaConfiguracaoDirfIrrfPlanoConta;
    }

    /**
     * OneToOne (inverse side)
     * Set ManadPlanoContaEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Manad\PlanoContaEntidade $fkManadPlanoContaEntidade
     * @return PlanoConta
     */
    public function setFkManadPlanoContaEntidade(\Urbem\CoreBundle\Entity\Manad\PlanoContaEntidade $fkManadPlanoContaEntidade)
    {
        $fkManadPlanoContaEntidade->setFkContabilidadePlanoConta($this);
        $this->fkManadPlanoContaEntidade = $fkManadPlanoContaEntidade;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkManadPlanoContaEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Manad\PlanoContaEntidade
     */
    public function getFkManadPlanoContaEntidade()
    {
        return $this->fkManadPlanoContaEntidade;
    }

    /**
     * OneToOne (inverse side)
     * Set TcemgContaBancaria
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContaBancaria $fkTcemgContaBancaria
     * @return PlanoConta
     */
    public function setFkTcemgContaBancaria(\Urbem\CoreBundle\Entity\Tcemg\ContaBancaria $fkTcemgContaBancaria)
    {
        $fkTcemgContaBancaria->setFkContabilidadePlanoConta($this);
        $this->fkTcemgContaBancaria = $fkTcemgContaBancaria;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcemgContaBancaria
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\ContaBancaria
     */
    public function getFkTcemgContaBancaria()
    {
        return $this->fkTcemgContaBancaria;
    }

    /**
     * OneToOne (inverse side)
     * Set TcerjPlanoConta
     *
     * @param \Urbem\CoreBundle\Entity\Tcerj\PlanoConta $fkTcerjPlanoConta
     * @return PlanoConta
     */
    public function setFkTcerjPlanoConta(\Urbem\CoreBundle\Entity\Tcerj\PlanoConta $fkTcerjPlanoConta)
    {
        $fkTcerjPlanoConta->setFkContabilidadePlanoConta($this);
        $this->fkTcerjPlanoConta = $fkTcerjPlanoConta;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcerjPlanoConta
     *
     * @return \Urbem\CoreBundle\Entity\Tcerj\PlanoConta
     */
    public function getFkTcerjPlanoConta()
    {
        return $this->fkTcerjPlanoConta;
    }

    /**
     * OneToOne (inverse side)
     * Set TcersRdExtra
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\RdExtra $fkTcersRdExtra
     * @return PlanoConta
     */
    public function setFkTcersRdExtra(\Urbem\CoreBundle\Entity\Tcers\RdExtra $fkTcersRdExtra)
    {
        $fkTcersRdExtra->setFkContabilidadePlanoConta($this);
        $this->fkTcersRdExtra = $fkTcersRdExtra;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcersRdExtra
     *
     * @return \Urbem\CoreBundle\Entity\Tcers\RdExtra
     */
    public function getFkTcersRdExtra()
    {
        return $this->fkTcersRdExtra;
    }

    /**
     * OneToOne (inverse side)
     * Set TcersPlanoContaEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\PlanoContaEntidade $fkTcersPlanoContaEntidade
     * @return PlanoConta
     */
    public function setFkTcersPlanoContaEntidade(\Urbem\CoreBundle\Entity\Tcers\PlanoContaEntidade $fkTcersPlanoContaEntidade)
    {
        $fkTcersPlanoContaEntidade->setFkContabilidadePlanoConta($this);
        $this->fkTcersPlanoContaEntidade = $fkTcersPlanoContaEntidade;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcersPlanoContaEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Tcers\PlanoContaEntidade
     */
    public function getFkTcersPlanoContaEntidade()
    {
        return $this->fkTcersPlanoContaEntidade;
    }

    /**
     * OneToOne (inverse side)
     * Set TcmgoBalancoBlpaaaa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\BalancoBlpaaaa $fkTcmgoBalancoBlpaaaa
     * @return PlanoConta
     */
    public function setFkTcmgoBalancoBlpaaaa(\Urbem\CoreBundle\Entity\Tcmgo\BalancoBlpaaaa $fkTcmgoBalancoBlpaaaa)
    {
        $fkTcmgoBalancoBlpaaaa->setFkContabilidadePlanoConta($this);
        $this->fkTcmgoBalancoBlpaaaa = $fkTcmgoBalancoBlpaaaa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcmgoBalancoBlpaaaa
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\BalancoBlpaaaa
     */
    public function getFkTcmgoBalancoBlpaaaa()
    {
        return $this->fkTcmgoBalancoBlpaaaa;
    }

    /**
     * OneToOne (inverse side)
     * Set TcmgoBalancoPfraaaa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\BalancoPfraaaa $fkTcmgoBalancoPfraaaa
     * @return PlanoConta
     */
    public function setFkTcmgoBalancoPfraaaa(\Urbem\CoreBundle\Entity\Tcmgo\BalancoPfraaaa $fkTcmgoBalancoPfraaaa)
    {
        $fkTcmgoBalancoPfraaaa->setFkContabilidadePlanoConta($this);
        $this->fkTcmgoBalancoPfraaaa = $fkTcmgoBalancoPfraaaa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcmgoBalancoPfraaaa
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\BalancoPfraaaa
     */
    public function getFkTcmgoBalancoPfraaaa()
    {
        return $this->fkTcmgoBalancoPfraaaa;
    }

    /**
     * OneToOne (inverse side)
     * Set ContabilidadeConfiguracaoContasExtras
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoContasExtras $fkContabilidadeConfiguracaoContasExtras
     * @return PlanoConta
     */
    public function setFkContabilidadeConfiguracaoContasExtras(\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoContasExtras $fkContabilidadeConfiguracaoContasExtras)
    {
        $fkContabilidadeConfiguracaoContasExtras->setFkContabilidadePlanoConta($this);
        $this->fkContabilidadeConfiguracaoContasExtras = $fkContabilidadeConfiguracaoContasExtras;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkContabilidadeConfiguracaoContasExtras
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoContasExtras
     */
    public function getFkContabilidadeConfiguracaoContasExtras()
    {
        return $this->fkContabilidadeConfiguracaoContasExtras;
    }

    /**
     * OneToOne (inverse side)
     * Set TcepbPlanoContaTipoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\PlanoContaTipoTransferencia $fkTcepbPlanoContaTipoTransferencia
     * @return PlanoConta
     */
    public function setFkTcepbPlanoContaTipoTransferencia(\Urbem\CoreBundle\Entity\Tcepb\PlanoContaTipoTransferencia $fkTcepbPlanoContaTipoTransferencia)
    {
        $fkTcepbPlanoContaTipoTransferencia->setFkContabilidadePlanoConta($this);
        $this->fkTcepbPlanoContaTipoTransferencia = $fkTcepbPlanoContaTipoTransferencia;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcepbPlanoContaTipoTransferencia
     *
     * @return \Urbem\CoreBundle\Entity\Tcepb\PlanoContaTipoTransferencia
     */
    public function getFkTcepbPlanoContaTipoTransferencia()
    {
        return $this->fkTcepbPlanoContaTipoTransferencia;
    }

    /**
     * OneToOne (inverse side)
     * Set ImaConfiguracaoDirfInss
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfInss $fkImaConfiguracaoDirfInss
     * @return PlanoConta
     */
    public function setFkImaConfiguracaoDirfInss(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfInss $fkImaConfiguracaoDirfInss)
    {
        $fkImaConfiguracaoDirfInss->setFkContabilidadePlanoConta($this);
        $this->fkImaConfiguracaoDirfInss = $fkImaConfiguracaoDirfInss;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImaConfiguracaoDirfInss
     *
     * @return \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfInss
     */
    public function getFkImaConfiguracaoDirfInss()
    {
        return $this->fkImaConfiguracaoDirfInss;
    }

    /**
     * OneToOne (inverse side)
     * Set ManadRdExtra
     *
     * @param \Urbem\CoreBundle\Entity\Manad\RdExtra $fkManadRdExtra
     * @return PlanoConta
     */
    public function setFkManadRdExtra(\Urbem\CoreBundle\Entity\Manad\RdExtra $fkManadRdExtra)
    {
        $fkManadRdExtra->setFkContabilidadePlanoConta($this);
        $this->fkManadRdExtra = $fkManadRdExtra;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkManadRdExtra
     *
     * @return \Urbem\CoreBundle\Entity\Manad\RdExtra
     */
    public function getFkManadRdExtra()
    {
        return $this->fkManadRdExtra;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->nomConta;
    }

    /**
     * @return string
     */
    public function getStringPlanoConta()
    {
        return sprintf("%s/%s - %s", $this->getFkContabilidadePlanoAnalitica()->getCodPlano(), $this->getExercicio(), $this->getNomConta());
    }
}
