<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * Despesa
 */
class Despesa
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
    private $codDespesa;

    /**
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $codPrograma;

    /**
     * @var integer
     */
    private $codConta;

    /**
     * @var integer
     */
    private $numPao;

    /**
     * @var integer
     */
    private $numOrgao;

    /**
     * @var integer
     */
    private $numUnidade;

    /**
     * @var integer
     */
    private $codRecurso;

    /**
     * @var integer
     */
    private $codFuncao;

    /**
     * @var integer
     */
    private $codSubfuncao;

    /**
     * @var integer
     */
    private $vlOriginal = 0;

    /**
     * @var \DateTime
     */
    private $dtCriacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoDotacao
     */
    private $fkAlmoxarifadoCentroCustoDotacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\DespesasFixas
     */
    private $fkEmpenhoDespesasFixas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\PreEmpenhoDespesa
     */
    private $fkEmpenhoPreEmpenhoDespesas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\DespesaCredito
     */
    private $fkOrcamentoDespesaCreditos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\PrevisaoDespesa
     */
    private $fkOrcamentoPrevisaoDespesas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\SuplementacaoSuplementada
     */
    private $fkOrcamentoSuplementacaoSuplementadas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\SuplementacaoReducao
     */
    private $fkOrcamentoSuplementacaoReducoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\OrcamentoModalidadeDespesa
     */
    private $fkTcepbOrcamentoModalidadeDespesas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\OrcamentoModalidadeDespesa
     */
    private $fkTcepeOrcamentoModalidadeDespesas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho
     */
    private $fkFolhapagamentoConfiguracaoEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao
     */
    private $fkComprasSolicitacaoItemDotacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\DespesaAcao
     */
    private $fkOrcamentoDespesaAcoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos
     */
    private $fkOrcamentoReservaSaldos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\TermoParceriaDotacao
     */
    private $fkTcmbaTermoParceriaDotacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Recurso
     */
    private $fkOrcamentoRecurso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Pao
     */
    private $fkOrcamentoPao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Programa
     */
    private $fkOrcamentoPrograma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa
     */
    private $fkOrcamentoContaDespesa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Funcao
     */
    private $fkOrcamentoFuncao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Subfuncao
     */
    private $fkOrcamentoSubfuncao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    private $fkOrcamentoUnidade;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoCentroCustoDotacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoDespesasFixas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoPreEmpenhoDespesas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoDespesaCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoPrevisaoDespesas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoSuplementacaoSuplementadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoSuplementacaoReducoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepbOrcamentoModalidadeDespesas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeOrcamentoModalidadeDespesas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasSolicitacaoItemDotacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoDespesaAcoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoReservaSaldos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaTermoParceriaDotacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dtCriacao = new \DateTime;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Despesa
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
     * Set codDespesa
     *
     * @param integer $codDespesa
     * @return Despesa
     */
    public function setCodDespesa($codDespesa)
    {
        $this->codDespesa = $codDespesa;
        return $this;
    }

    /**
     * Get codDespesa
     *
     * @return integer
     */
    public function getCodDespesa()
    {
        return $this->codDespesa;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Despesa
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
     * Set codPrograma
     *
     * @param integer $codPrograma
     * @return Despesa
     */
    public function setCodPrograma($codPrograma)
    {
        $this->codPrograma = $codPrograma;
        return $this;
    }

    /**
     * Get codPrograma
     *
     * @return integer
     */
    public function getCodPrograma()
    {
        return $this->codPrograma;
    }

    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return Despesa
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
     * Set numPao
     *
     * @param integer $numPao
     * @return Despesa
     */
    public function setNumPao($numPao)
    {
        $this->numPao = $numPao;
        return $this;
    }

    /**
     * Get numPao
     *
     * @return integer
     */
    public function getNumPao()
    {
        return $this->numPao;
    }

    /**
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return Despesa
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
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return Despesa
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
     * Set codRecurso
     *
     * @param integer $codRecurso
     * @return Despesa
     */
    public function setCodRecurso($codRecurso)
    {
        $this->codRecurso = $codRecurso;
        return $this;
    }

    /**
     * Get codRecurso
     *
     * @return integer
     */
    public function getCodRecurso()
    {
        return $this->codRecurso;
    }

    /**
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return Despesa
     */
    public function setCodFuncao($codFuncao)
    {
        $this->codFuncao = $codFuncao;
        return $this;
    }

    /**
     * Get codFuncao
     *
     * @return integer
     */
    public function getCodFuncao()
    {
        return $this->codFuncao;
    }

    /**
     * Set codSubfuncao
     *
     * @param integer $codSubfuncao
     * @return Despesa
     */
    public function setCodSubfuncao($codSubfuncao)
    {
        $this->codSubfuncao = $codSubfuncao;
        return $this;
    }

    /**
     * Get codSubfuncao
     *
     * @return integer
     */
    public function getCodSubfuncao()
    {
        return $this->codSubfuncao;
    }

    /**
     * Set vlOriginal
     *
     * @param integer $vlOriginal
     * @return Despesa
     */
    public function setVlOriginal($vlOriginal = null)
    {
        $this->vlOriginal = $vlOriginal;
        return $this;
    }

    /**
     * Get vlOriginal
     *
     * @return integer
     */
    public function getVlOriginal()
    {
        return $this->vlOriginal;
    }

    /**
     * Set dtCriacao
     *
     * @param \DateTime $dtCriacao
     * @return Despesa
     */
    public function setDtCriacao(\DateTime $dtCriacao = null)
    {
        $this->dtCriacao = $dtCriacao;
        return $this;
    }

    /**
     * Get dtCriacao
     *
     * @return \DateTime
     */
    public function getDtCriacao()
    {
        return $this->dtCriacao;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoCentroCustoDotacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoDotacao $fkAlmoxarifadoCentroCustoDotacao
     * @return Despesa
     */
    public function addFkAlmoxarifadoCentroCustoDotacoes(\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoDotacao $fkAlmoxarifadoCentroCustoDotacao)
    {
        if (false === $this->fkAlmoxarifadoCentroCustoDotacoes->contains($fkAlmoxarifadoCentroCustoDotacao)) {
            $fkAlmoxarifadoCentroCustoDotacao->setFkOrcamentoDespesa($this);
            $this->fkAlmoxarifadoCentroCustoDotacoes->add($fkAlmoxarifadoCentroCustoDotacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoCentroCustoDotacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoDotacao $fkAlmoxarifadoCentroCustoDotacao
     */
    public function removeFkAlmoxarifadoCentroCustoDotacoes(\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoDotacao $fkAlmoxarifadoCentroCustoDotacao)
    {
        $this->fkAlmoxarifadoCentroCustoDotacoes->removeElement($fkAlmoxarifadoCentroCustoDotacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoCentroCustoDotacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoDotacao
     */
    public function getFkAlmoxarifadoCentroCustoDotacoes()
    {
        return $this->fkAlmoxarifadoCentroCustoDotacoes;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoDespesasFixas
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\DespesasFixas $fkEmpenhoDespesasFixas
     * @return Despesa
     */
    public function addFkEmpenhoDespesasFixas(\Urbem\CoreBundle\Entity\Empenho\DespesasFixas $fkEmpenhoDespesasFixas)
    {
        if (false === $this->fkEmpenhoDespesasFixas->contains($fkEmpenhoDespesasFixas)) {
            $fkEmpenhoDespesasFixas->setFkOrcamentoDespesa($this);
            $this->fkEmpenhoDespesasFixas->add($fkEmpenhoDespesasFixas);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoDespesasFixas
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\DespesasFixas $fkEmpenhoDespesasFixas
     */
    public function removeFkEmpenhoDespesasFixas(\Urbem\CoreBundle\Entity\Empenho\DespesasFixas $fkEmpenhoDespesasFixas)
    {
        $this->fkEmpenhoDespesasFixas->removeElement($fkEmpenhoDespesasFixas);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoDespesasFixas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\DespesasFixas
     */
    public function getFkEmpenhoDespesasFixas()
    {
        return $this->fkEmpenhoDespesasFixas;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoPreEmpenhoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PreEmpenhoDespesa $fkEmpenhoPreEmpenhoDespesa
     * @return Despesa
     */
    public function addFkEmpenhoPreEmpenhoDespesas(\Urbem\CoreBundle\Entity\Empenho\PreEmpenhoDespesa $fkEmpenhoPreEmpenhoDespesa)
    {
        if (false === $this->fkEmpenhoPreEmpenhoDespesas->contains($fkEmpenhoPreEmpenhoDespesa)) {
            $fkEmpenhoPreEmpenhoDespesa->setFkOrcamentoDespesa($this);
            $this->fkEmpenhoPreEmpenhoDespesas->add($fkEmpenhoPreEmpenhoDespesa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoPreEmpenhoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PreEmpenhoDespesa $fkEmpenhoPreEmpenhoDespesa
     */
    public function removeFkEmpenhoPreEmpenhoDespesas(\Urbem\CoreBundle\Entity\Empenho\PreEmpenhoDespesa $fkEmpenhoPreEmpenhoDespesa)
    {
        $this->fkEmpenhoPreEmpenhoDespesas->removeElement($fkEmpenhoPreEmpenhoDespesa);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoPreEmpenhoDespesas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\PreEmpenhoDespesa
     */
    public function getFkEmpenhoPreEmpenhoDespesas()
    {
        return $this->fkEmpenhoPreEmpenhoDespesas;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoDespesaCredito
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\DespesaCredito $fkOrcamentoDespesaCredito
     * @return Despesa
     */
    public function addFkOrcamentoDespesaCreditos(\Urbem\CoreBundle\Entity\Orcamento\DespesaCredito $fkOrcamentoDespesaCredito)
    {
        if (false === $this->fkOrcamentoDespesaCreditos->contains($fkOrcamentoDespesaCredito)) {
            $fkOrcamentoDespesaCredito->setFkOrcamentoDespesa($this);
            $this->fkOrcamentoDespesaCreditos->add($fkOrcamentoDespesaCredito);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoDespesaCredito
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\DespesaCredito $fkOrcamentoDespesaCredito
     */
    public function removeFkOrcamentoDespesaCreditos(\Urbem\CoreBundle\Entity\Orcamento\DespesaCredito $fkOrcamentoDespesaCredito)
    {
        $this->fkOrcamentoDespesaCreditos->removeElement($fkOrcamentoDespesaCredito);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoDespesaCreditos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\DespesaCredito
     */
    public function getFkOrcamentoDespesaCreditos()
    {
        return $this->fkOrcamentoDespesaCreditos;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoPrevisaoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\PrevisaoDespesa $fkOrcamentoPrevisaoDespesa
     * @return Despesa
     */
    public function addFkOrcamentoPrevisaoDespesas(\Urbem\CoreBundle\Entity\Orcamento\PrevisaoDespesa $fkOrcamentoPrevisaoDespesa)
    {
        if (false === $this->fkOrcamentoPrevisaoDespesas->contains($fkOrcamentoPrevisaoDespesa)) {
            $fkOrcamentoPrevisaoDespesa->setFkOrcamentoDespesa($this);
            $this->fkOrcamentoPrevisaoDespesas->add($fkOrcamentoPrevisaoDespesa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoPrevisaoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\PrevisaoDespesa $fkOrcamentoPrevisaoDespesa
     */
    public function removeFkOrcamentoPrevisaoDespesas(\Urbem\CoreBundle\Entity\Orcamento\PrevisaoDespesa $fkOrcamentoPrevisaoDespesa)
    {
        $this->fkOrcamentoPrevisaoDespesas->removeElement($fkOrcamentoPrevisaoDespesa);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoPrevisaoDespesas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\PrevisaoDespesa
     */
    public function getFkOrcamentoPrevisaoDespesas()
    {
        return $this->fkOrcamentoPrevisaoDespesas;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoSuplementacaoSuplementada
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\SuplementacaoSuplementada $fkOrcamentoSuplementacaoSuplementada
     * @return Despesa
     */
    public function addFkOrcamentoSuplementacaoSuplementadas(\Urbem\CoreBundle\Entity\Orcamento\SuplementacaoSuplementada $fkOrcamentoSuplementacaoSuplementada)
    {
        if (false === $this->fkOrcamentoSuplementacaoSuplementadas->contains($fkOrcamentoSuplementacaoSuplementada)) {
            $fkOrcamentoSuplementacaoSuplementada->setFkOrcamentoDespesa($this);
            $this->fkOrcamentoSuplementacaoSuplementadas->add($fkOrcamentoSuplementacaoSuplementada);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoSuplementacaoSuplementada
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\SuplementacaoSuplementada $fkOrcamentoSuplementacaoSuplementada
     */
    public function removeFkOrcamentoSuplementacaoSuplementadas(\Urbem\CoreBundle\Entity\Orcamento\SuplementacaoSuplementada $fkOrcamentoSuplementacaoSuplementada)
    {
        $this->fkOrcamentoSuplementacaoSuplementadas->removeElement($fkOrcamentoSuplementacaoSuplementada);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoSuplementacaoSuplementadas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\SuplementacaoSuplementada
     */
    public function getFkOrcamentoSuplementacaoSuplementadas()
    {
        return $this->fkOrcamentoSuplementacaoSuplementadas;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoSuplementacaoReducao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\SuplementacaoReducao $fkOrcamentoSuplementacaoReducao
     * @return Despesa
     */
    public function addFkOrcamentoSuplementacaoReducoes(\Urbem\CoreBundle\Entity\Orcamento\SuplementacaoReducao $fkOrcamentoSuplementacaoReducao)
    {
        if (false === $this->fkOrcamentoSuplementacaoReducoes->contains($fkOrcamentoSuplementacaoReducao)) {
            $fkOrcamentoSuplementacaoReducao->setFkOrcamentoDespesa($this);
            $this->fkOrcamentoSuplementacaoReducoes->add($fkOrcamentoSuplementacaoReducao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoSuplementacaoReducao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\SuplementacaoReducao $fkOrcamentoSuplementacaoReducao
     */
    public function removeFkOrcamentoSuplementacaoReducoes(\Urbem\CoreBundle\Entity\Orcamento\SuplementacaoReducao $fkOrcamentoSuplementacaoReducao)
    {
        $this->fkOrcamentoSuplementacaoReducoes->removeElement($fkOrcamentoSuplementacaoReducao);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoSuplementacaoReducoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\SuplementacaoReducao
     */
    public function getFkOrcamentoSuplementacaoReducoes()
    {
        return $this->fkOrcamentoSuplementacaoReducoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcepbOrcamentoModalidadeDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\OrcamentoModalidadeDespesa $fkTcepbOrcamentoModalidadeDespesa
     * @return Despesa
     */
    public function addFkTcepbOrcamentoModalidadeDespesas(\Urbem\CoreBundle\Entity\Tcepb\OrcamentoModalidadeDespesa $fkTcepbOrcamentoModalidadeDespesa)
    {
        if (false === $this->fkTcepbOrcamentoModalidadeDespesas->contains($fkTcepbOrcamentoModalidadeDespesa)) {
            $fkTcepbOrcamentoModalidadeDespesa->setFkOrcamentoDespesa($this);
            $this->fkTcepbOrcamentoModalidadeDespesas->add($fkTcepbOrcamentoModalidadeDespesa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepbOrcamentoModalidadeDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\OrcamentoModalidadeDespesa $fkTcepbOrcamentoModalidadeDespesa
     */
    public function removeFkTcepbOrcamentoModalidadeDespesas(\Urbem\CoreBundle\Entity\Tcepb\OrcamentoModalidadeDespesa $fkTcepbOrcamentoModalidadeDespesa)
    {
        $this->fkTcepbOrcamentoModalidadeDespesas->removeElement($fkTcepbOrcamentoModalidadeDespesa);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepbOrcamentoModalidadeDespesas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\OrcamentoModalidadeDespesa
     */
    public function getFkTcepbOrcamentoModalidadeDespesas()
    {
        return $this->fkTcepbOrcamentoModalidadeDespesas;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeOrcamentoModalidadeDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\OrcamentoModalidadeDespesa $fkTcepeOrcamentoModalidadeDespesa
     * @return Despesa
     */
    public function addFkTcepeOrcamentoModalidadeDespesas(\Urbem\CoreBundle\Entity\Tcepe\OrcamentoModalidadeDespesa $fkTcepeOrcamentoModalidadeDespesa)
    {
        if (false === $this->fkTcepeOrcamentoModalidadeDespesas->contains($fkTcepeOrcamentoModalidadeDespesa)) {
            $fkTcepeOrcamentoModalidadeDespesa->setFkOrcamentoDespesa($this);
            $this->fkTcepeOrcamentoModalidadeDespesas->add($fkTcepeOrcamentoModalidadeDespesa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeOrcamentoModalidadeDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\OrcamentoModalidadeDespesa $fkTcepeOrcamentoModalidadeDespesa
     */
    public function removeFkTcepeOrcamentoModalidadeDespesas(\Urbem\CoreBundle\Entity\Tcepe\OrcamentoModalidadeDespesa $fkTcepeOrcamentoModalidadeDespesa)
    {
        $this->fkTcepeOrcamentoModalidadeDespesas->removeElement($fkTcepeOrcamentoModalidadeDespesa);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeOrcamentoModalidadeDespesas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\OrcamentoModalidadeDespesa
     */
    public function getFkTcepeOrcamentoModalidadeDespesas()
    {
        return $this->fkTcepeOrcamentoModalidadeDespesas;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho $fkFolhapagamentoConfiguracaoEmpenho
     * @return Despesa
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho $fkFolhapagamentoConfiguracaoEmpenho)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhos->contains($fkFolhapagamentoConfiguracaoEmpenho)) {
            $fkFolhapagamentoConfiguracaoEmpenho->setFkOrcamentoDespesa($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhos->add($fkFolhapagamentoConfiguracaoEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho $fkFolhapagamentoConfiguracaoEmpenho
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho $fkFolhapagamentoConfiguracaoEmpenho)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhos->removeElement($fkFolhapagamentoConfiguracaoEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhos()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasSolicitacaoItemDotacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao $fkComprasSolicitacaoItemDotacao
     * @return Despesa
     */
    public function addFkComprasSolicitacaoItemDotacoes(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao $fkComprasSolicitacaoItemDotacao)
    {
        if (false === $this->fkComprasSolicitacaoItemDotacoes->contains($fkComprasSolicitacaoItemDotacao)) {
            $fkComprasSolicitacaoItemDotacao->setFkOrcamentoDespesa($this);
            $this->fkComprasSolicitacaoItemDotacoes->add($fkComprasSolicitacaoItemDotacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasSolicitacaoItemDotacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao $fkComprasSolicitacaoItemDotacao
     */
    public function removeFkComprasSolicitacaoItemDotacoes(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao $fkComprasSolicitacaoItemDotacao)
    {
        $this->fkComprasSolicitacaoItemDotacoes->removeElement($fkComprasSolicitacaoItemDotacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasSolicitacaoItemDotacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao
     */
    public function getFkComprasSolicitacaoItemDotacoes()
    {
        return $this->fkComprasSolicitacaoItemDotacoes;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoDespesaAcao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\DespesaAcao $fkOrcamentoDespesaAcao
     * @return Despesa
     */
    public function addFkOrcamentoDespesaAcoes(\Urbem\CoreBundle\Entity\Orcamento\DespesaAcao $fkOrcamentoDespesaAcao)
    {
        if (false === $this->fkOrcamentoDespesaAcoes->contains($fkOrcamentoDespesaAcao)) {
            $fkOrcamentoDespesaAcao->setFkOrcamentoDespesa($this);
            $this->fkOrcamentoDespesaAcoes->add($fkOrcamentoDespesaAcao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoDespesaAcao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\DespesaAcao $fkOrcamentoDespesaAcao
     */
    public function removeFkOrcamentoDespesaAcoes(\Urbem\CoreBundle\Entity\Orcamento\DespesaAcao $fkOrcamentoDespesaAcao)
    {
        $this->fkOrcamentoDespesaAcoes->removeElement($fkOrcamentoDespesaAcao);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoDespesaAcoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\DespesaAcao
     */
    public function getFkOrcamentoDespesaAcoes()
    {
        return $this->fkOrcamentoDespesaAcoes;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoReservaSaldos
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos $fkOrcamentoReservaSaldos
     * @return Despesa
     */
    public function addFkOrcamentoReservaSaldos(\Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos $fkOrcamentoReservaSaldos)
    {
        if (false === $this->fkOrcamentoReservaSaldos->contains($fkOrcamentoReservaSaldos)) {
            $fkOrcamentoReservaSaldos->setFkOrcamentoDespesa($this);
            $this->fkOrcamentoReservaSaldos->add($fkOrcamentoReservaSaldos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoReservaSaldos
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos $fkOrcamentoReservaSaldos
     */
    public function removeFkOrcamentoReservaSaldos(\Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos $fkOrcamentoReservaSaldos)
    {
        $this->fkOrcamentoReservaSaldos->removeElement($fkOrcamentoReservaSaldos);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoReservaSaldos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos
     */
    public function getFkOrcamentoReservaSaldos()
    {
        return $this->fkOrcamentoReservaSaldos;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaTermoParceriaDotacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TermoParceriaDotacao $fkTcmbaTermoParceriaDotacao
     * @return Despesa
     */
    public function addFkTcmbaTermoParceriaDotacoes(\Urbem\CoreBundle\Entity\Tcmba\TermoParceriaDotacao $fkTcmbaTermoParceriaDotacao)
    {
        if (false === $this->fkTcmbaTermoParceriaDotacoes->contains($fkTcmbaTermoParceriaDotacao)) {
            $fkTcmbaTermoParceriaDotacao->setFkOrcamentoDespesa($this);
            $this->fkTcmbaTermoParceriaDotacoes->add($fkTcmbaTermoParceriaDotacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaTermoParceriaDotacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TermoParceriaDotacao $fkTcmbaTermoParceriaDotacao
     */
    public function removeFkTcmbaTermoParceriaDotacoes(\Urbem\CoreBundle\Entity\Tcmba\TermoParceriaDotacao $fkTcmbaTermoParceriaDotacao)
    {
        $this->fkTcmbaTermoParceriaDotacoes->removeElement($fkTcmbaTermoParceriaDotacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaTermoParceriaDotacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\TermoParceriaDotacao
     */
    public function getFkTcmbaTermoParceriaDotacoes()
    {
        return $this->fkTcmbaTermoParceriaDotacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Recurso $fkOrcamentoRecurso
     * @return Despesa
     */
    public function setFkOrcamentoRecurso(\Urbem\CoreBundle\Entity\Orcamento\Recurso $fkOrcamentoRecurso)
    {
        $this->exercicio = $fkOrcamentoRecurso->getExercicio();
        $this->codRecurso = $fkOrcamentoRecurso->getCodRecurso();
        $this->fkOrcamentoRecurso = $fkOrcamentoRecurso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Recurso
     */
    public function getFkOrcamentoRecurso()
    {
        return $this->fkOrcamentoRecurso;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoPao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Pao $fkOrcamentoPao
     * @return Despesa
     */
    public function setFkOrcamentoPao(\Urbem\CoreBundle\Entity\Orcamento\Pao $fkOrcamentoPao)
    {
        $this->exercicio = $fkOrcamentoPao->getExercicio();
        $this->numPao = $fkOrcamentoPao->getNumPao();
        $this->fkOrcamentoPao = $fkOrcamentoPao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoPao
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Pao
     */
    public function getFkOrcamentoPao()
    {
        return $this->fkOrcamentoPao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return Despesa
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

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoPrograma
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Programa $fkOrcamentoPrograma
     * @return Despesa
     */
    public function setFkOrcamentoPrograma(\Urbem\CoreBundle\Entity\Orcamento\Programa $fkOrcamentoPrograma)
    {
        $this->exercicio = $fkOrcamentoPrograma->getExercicio();
        $this->codPrograma = $fkOrcamentoPrograma->getCodPrograma();
        $this->fkOrcamentoPrograma = $fkOrcamentoPrograma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoPrograma
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Programa
     */
    public function getFkOrcamentoPrograma()
    {
        return $this->fkOrcamentoPrograma;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoContaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa $fkOrcamentoContaDespesa
     * @return Despesa
     */
    public function setFkOrcamentoContaDespesa(\Urbem\CoreBundle\Entity\Orcamento\ContaDespesa $fkOrcamentoContaDespesa)
    {
        $this->exercicio = $fkOrcamentoContaDespesa->getExercicio();
        $this->codConta = $fkOrcamentoContaDespesa->getCodConta();
        $this->fkOrcamentoContaDespesa = $fkOrcamentoContaDespesa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoContaDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa
     */
    public function getFkOrcamentoContaDespesa()
    {
        return $this->fkOrcamentoContaDespesa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Funcao $fkOrcamentoFuncao
     * @return Despesa
     */
    public function setFkOrcamentoFuncao(\Urbem\CoreBundle\Entity\Orcamento\Funcao $fkOrcamentoFuncao)
    {
        $this->exercicio = $fkOrcamentoFuncao->getExercicio();
        $this->codFuncao = $fkOrcamentoFuncao->getCodFuncao();
        $this->fkOrcamentoFuncao = $fkOrcamentoFuncao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoFuncao
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Funcao
     */
    public function getFkOrcamentoFuncao()
    {
        return $this->fkOrcamentoFuncao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoSubfuncao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Subfuncao $fkOrcamentoSubfuncao
     * @return Despesa
     */
    public function setFkOrcamentoSubfuncao(\Urbem\CoreBundle\Entity\Orcamento\Subfuncao $fkOrcamentoSubfuncao)
    {
        $this->exercicio = $fkOrcamentoSubfuncao->getExercicio();
        $this->codSubfuncao = $fkOrcamentoSubfuncao->getCodSubfuncao();
        $this->fkOrcamentoSubfuncao = $fkOrcamentoSubfuncao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoSubfuncao
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Subfuncao
     */
    public function getFkOrcamentoSubfuncao()
    {
        return $this->fkOrcamentoSubfuncao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade
     * @return Despesa
     */
    public function setFkOrcamentoUnidade(\Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade)
    {
        $this->exercicio = $fkOrcamentoUnidade->getExercicio();
        $this->numUnidade = $fkOrcamentoUnidade->getNumUnidade();
        $this->numOrgao = $fkOrcamentoUnidade->getNumOrgao();
        $this->fkOrcamentoUnidade = $fkOrcamentoUnidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoUnidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    public function getFkOrcamentoUnidade()
    {
        return $this->fkOrcamentoUnidade;
    }

    /**
     * @return string
     */
    public function getDescricao()
    {
        return $this->fkOrcamentoContaDespesa->getDescricao();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codDespesa, is_null($this->getFkOrcamentoContaDespesa())?"":$this->getFkOrcamentoContaDespesa()->getDescricao());
    }
}
