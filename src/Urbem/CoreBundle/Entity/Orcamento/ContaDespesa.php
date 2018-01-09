<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * ContaDespesa
 */
class ContaDespesa
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
    private $codConta;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $codEstrutural;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcerj\ContaDespesa
     */
    private $fkTcerjContaDespesa;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcmgo\ElementoDePara
     */
    private $fkTcmgoElementoDePara;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoContaDespesaItem
     */
    private $fkContabilidadeConfiguracaoLancamentoContaDespesaItens;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Diarias\TipoDiariaDespesa
     */
    private $fkDiariasTipoDiariaDespesas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\PreEmpenhoDespesa
     */
    private $fkEmpenhoPreEmpenhoDespesas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoContaDespesa
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoContaDespesas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPrestador
     */
    private $fkImaConfiguracaoDirfPrestadores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\ElementoDePara
     */
    private $fkTcepbElementoDeParas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    private $fkOrcamentoDespesas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao
     */
    private $fkComprasSolicitacaoItemDotacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoDespesa
     */
    private $fkFolhapagamentoConfiguracaoEventoDespesas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ClassificacaoDespesa
     */
    private $fkOrcamentoClassificacaoDespesas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkContabilidadeConfiguracaoLancamentoContaDespesaItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeConfiguracaoLancamentoCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeConfiguracaoLancamentoDebitos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDiariasTipoDiariaDespesas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoPreEmpenhoDespesas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEmpenhoContaDespesas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoDirfPrestadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepbElementoDeParas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoDespesas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasSolicitacaoItemDotacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEventoDespesas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoClassificacaoDespesas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ContaDespesa
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
     * Set codConta
     *
     * @param integer $codConta
     * @return ContaDespesa
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
     * Set descricao
     *
     * @param string $descricao
     * @return ContaDespesa
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set codEstrutural
     *
     * @param string $codEstrutural
     * @return ContaDespesa
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
     * OneToMany (owning side)
     * Add ContabilidadeConfiguracaoLancamentoContaDespesaItem
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoContaDespesaItem $fkContabilidadeConfiguracaoLancamentoContaDespesaItem
     * @return ContaDespesa
     */
    public function addFkContabilidadeConfiguracaoLancamentoContaDespesaItens(\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoContaDespesaItem $fkContabilidadeConfiguracaoLancamentoContaDespesaItem)
    {
        if (false === $this->fkContabilidadeConfiguracaoLancamentoContaDespesaItens->contains($fkContabilidadeConfiguracaoLancamentoContaDespesaItem)) {
            $fkContabilidadeConfiguracaoLancamentoContaDespesaItem->setFkOrcamentoContaDespesa($this);
            $this->fkContabilidadeConfiguracaoLancamentoContaDespesaItens->add($fkContabilidadeConfiguracaoLancamentoContaDespesaItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeConfiguracaoLancamentoContaDespesaItem
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoContaDespesaItem $fkContabilidadeConfiguracaoLancamentoContaDespesaItem
     */
    public function removeFkContabilidadeConfiguracaoLancamentoContaDespesaItens(\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoContaDespesaItem $fkContabilidadeConfiguracaoLancamentoContaDespesaItem)
    {
        $this->fkContabilidadeConfiguracaoLancamentoContaDespesaItens->removeElement($fkContabilidadeConfiguracaoLancamentoContaDespesaItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeConfiguracaoLancamentoContaDespesaItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoContaDespesaItem
     */
    public function getFkContabilidadeConfiguracaoLancamentoContaDespesaItens()
    {
        return $this->fkContabilidadeConfiguracaoLancamentoContaDespesaItens;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeConfiguracaoLancamentoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoCredito $fkContabilidadeConfiguracaoLancamentoCredito
     * @return ContaDespesa
     */
    public function addFkContabilidadeConfiguracaoLancamentoCreditos(\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoCredito $fkContabilidadeConfiguracaoLancamentoCredito)
    {
        if (false === $this->fkContabilidadeConfiguracaoLancamentoCreditos->contains($fkContabilidadeConfiguracaoLancamentoCredito)) {
            $fkContabilidadeConfiguracaoLancamentoCredito->setFkOrcamentoContaDespesa($this);
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
     * @return ContaDespesa
     */
    public function addFkContabilidadeConfiguracaoLancamentoDebitos(\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoDebito $fkContabilidadeConfiguracaoLancamentoDebito)
    {
        if (false === $this->fkContabilidadeConfiguracaoLancamentoDebitos->contains($fkContabilidadeConfiguracaoLancamentoDebito)) {
            $fkContabilidadeConfiguracaoLancamentoDebito->setFkOrcamentoContaDespesa($this);
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
     * Add DiariasTipoDiariaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Diarias\TipoDiariaDespesa $fkDiariasTipoDiariaDespesa
     * @return ContaDespesa
     */
    public function addFkDiariasTipoDiariaDespesas(\Urbem\CoreBundle\Entity\Diarias\TipoDiariaDespesa $fkDiariasTipoDiariaDespesa)
    {
        if (false === $this->fkDiariasTipoDiariaDespesas->contains($fkDiariasTipoDiariaDespesa)) {
            $fkDiariasTipoDiariaDespesa->setFkOrcamentoContaDespesa($this);
            $this->fkDiariasTipoDiariaDespesas->add($fkDiariasTipoDiariaDespesa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DiariasTipoDiariaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Diarias\TipoDiariaDespesa $fkDiariasTipoDiariaDespesa
     */
    public function removeFkDiariasTipoDiariaDespesas(\Urbem\CoreBundle\Entity\Diarias\TipoDiariaDespesa $fkDiariasTipoDiariaDespesa)
    {
        $this->fkDiariasTipoDiariaDespesas->removeElement($fkDiariasTipoDiariaDespesa);
    }

    /**
     * OneToMany (owning side)
     * Get fkDiariasTipoDiariaDespesas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Diarias\TipoDiariaDespesa
     */
    public function getFkDiariasTipoDiariaDespesas()
    {
        return $this->fkDiariasTipoDiariaDespesas;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoPreEmpenhoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PreEmpenhoDespesa $fkEmpenhoPreEmpenhoDespesa
     * @return ContaDespesa
     */
    public function addFkEmpenhoPreEmpenhoDespesas(\Urbem\CoreBundle\Entity\Empenho\PreEmpenhoDespesa $fkEmpenhoPreEmpenhoDespesa)
    {
        if (false === $this->fkEmpenhoPreEmpenhoDespesas->contains($fkEmpenhoPreEmpenhoDespesa)) {
            $fkEmpenhoPreEmpenhoDespesa->setFkOrcamentoContaDespesa($this);
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
     * Add FolhapagamentoConfiguracaoEmpenhoContaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoContaDespesa $fkFolhapagamentoConfiguracaoEmpenhoContaDespesa
     * @return ContaDespesa
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhoContaDespesas(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoContaDespesa $fkFolhapagamentoConfiguracaoEmpenhoContaDespesa)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhoContaDespesas->contains($fkFolhapagamentoConfiguracaoEmpenhoContaDespesa)) {
            $fkFolhapagamentoConfiguracaoEmpenhoContaDespesa->setFkOrcamentoContaDespesa($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhoContaDespesas->add($fkFolhapagamentoConfiguracaoEmpenhoContaDespesa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenhoContaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoContaDespesa $fkFolhapagamentoConfiguracaoEmpenhoContaDespesa
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhoContaDespesas(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoContaDespesa $fkFolhapagamentoConfiguracaoEmpenhoContaDespesa)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoContaDespesas->removeElement($fkFolhapagamentoConfiguracaoEmpenhoContaDespesa);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoContaDespesas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoContaDespesa
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoContaDespesas()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoContaDespesas;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoDirfPrestador
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPrestador $fkImaConfiguracaoDirfPrestador
     * @return ContaDespesa
     */
    public function addFkImaConfiguracaoDirfPrestadores(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPrestador $fkImaConfiguracaoDirfPrestador)
    {
        if (false === $this->fkImaConfiguracaoDirfPrestadores->contains($fkImaConfiguracaoDirfPrestador)) {
            $fkImaConfiguracaoDirfPrestador->setFkOrcamentoContaDespesa($this);
            $this->fkImaConfiguracaoDirfPrestadores->add($fkImaConfiguracaoDirfPrestador);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoDirfPrestador
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPrestador $fkImaConfiguracaoDirfPrestador
     */
    public function removeFkImaConfiguracaoDirfPrestadores(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPrestador $fkImaConfiguracaoDirfPrestador)
    {
        $this->fkImaConfiguracaoDirfPrestadores->removeElement($fkImaConfiguracaoDirfPrestador);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoDirfPrestadores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPrestador
     */
    public function getFkImaConfiguracaoDirfPrestadores()
    {
        return $this->fkImaConfiguracaoDirfPrestadores;
    }

    /**
     * OneToMany (owning side)
     * Add TcepbElementoDePara
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\ElementoDePara $fkTcepbElementoDePara
     * @return ContaDespesa
     */
    public function addFkTcepbElementoDeParas(\Urbem\CoreBundle\Entity\Tcepb\ElementoDePara $fkTcepbElementoDePara)
    {
        if (false === $this->fkTcepbElementoDeParas->contains($fkTcepbElementoDePara)) {
            $fkTcepbElementoDePara->setFkOrcamentoContaDespesa($this);
            $this->fkTcepbElementoDeParas->add($fkTcepbElementoDePara);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepbElementoDePara
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\ElementoDePara $fkTcepbElementoDePara
     */
    public function removeFkTcepbElementoDeParas(\Urbem\CoreBundle\Entity\Tcepb\ElementoDePara $fkTcepbElementoDePara)
    {
        $this->fkTcepbElementoDeParas->removeElement($fkTcepbElementoDePara);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepbElementoDeParas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\ElementoDePara
     */
    public function getFkTcepbElementoDeParas()
    {
        return $this->fkTcepbElementoDeParas;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa
     * @return ContaDespesa
     */
    public function addFkOrcamentoDespesas(\Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa)
    {
        if (false === $this->fkOrcamentoDespesas->contains($fkOrcamentoDespesa)) {
            $fkOrcamentoDespesa->setFkOrcamentoContaDespesa($this);
            $this->fkOrcamentoDespesas->add($fkOrcamentoDespesa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa
     */
    public function removeFkOrcamentoDespesas(\Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa)
    {
        $this->fkOrcamentoDespesas->removeElement($fkOrcamentoDespesa);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoDespesas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    public function getFkOrcamentoDespesas()
    {
        return $this->fkOrcamentoDespesas;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasSolicitacaoItemDotacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao $fkComprasSolicitacaoItemDotacao
     * @return ContaDespesa
     */
    public function addFkComprasSolicitacaoItemDotacoes(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao $fkComprasSolicitacaoItemDotacao)
    {
        if (false === $this->fkComprasSolicitacaoItemDotacoes->contains($fkComprasSolicitacaoItemDotacao)) {
            $fkComprasSolicitacaoItemDotacao->setFkOrcamentoContaDespesa($this);
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
     * Add FolhapagamentoConfiguracaoEventoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoDespesa $fkFolhapagamentoConfiguracaoEventoDespesa
     * @return ContaDespesa
     */
    public function addFkFolhapagamentoConfiguracaoEventoDespesas(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoDespesa $fkFolhapagamentoConfiguracaoEventoDespesa)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEventoDespesas->contains($fkFolhapagamentoConfiguracaoEventoDespesa)) {
            $fkFolhapagamentoConfiguracaoEventoDespesa->setFkOrcamentoContaDespesa($this);
            $this->fkFolhapagamentoConfiguracaoEventoDespesas->add($fkFolhapagamentoConfiguracaoEventoDespesa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEventoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoDespesa $fkFolhapagamentoConfiguracaoEventoDespesa
     */
    public function removeFkFolhapagamentoConfiguracaoEventoDespesas(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoDespesa $fkFolhapagamentoConfiguracaoEventoDespesa)
    {
        $this->fkFolhapagamentoConfiguracaoEventoDespesas->removeElement($fkFolhapagamentoConfiguracaoEventoDespesa);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEventoDespesas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoDespesa
     */
    public function getFkFolhapagamentoConfiguracaoEventoDespesas()
    {
        return $this->fkFolhapagamentoConfiguracaoEventoDespesas;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoClassificacaoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ClassificacaoDespesa $fkOrcamentoClassificacaoDespesa
     * @return ContaDespesa
     */
    public function addFkOrcamentoClassificacaoDespesas(\Urbem\CoreBundle\Entity\Orcamento\ClassificacaoDespesa $fkOrcamentoClassificacaoDespesa)
    {
        if (false === $this->fkOrcamentoClassificacaoDespesas->contains($fkOrcamentoClassificacaoDespesa)) {
            $fkOrcamentoClassificacaoDespesa->setFkOrcamentoContaDespesa($this);
            $this->fkOrcamentoClassificacaoDespesas->add($fkOrcamentoClassificacaoDespesa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoClassificacaoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ClassificacaoDespesa $fkOrcamentoClassificacaoDespesa
     */
    public function removeFkOrcamentoClassificacaoDespesas(\Urbem\CoreBundle\Entity\Orcamento\ClassificacaoDespesa $fkOrcamentoClassificacaoDespesa)
    {
        $this->fkOrcamentoClassificacaoDespesas->removeElement($fkOrcamentoClassificacaoDespesa);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoClassificacaoDespesas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ClassificacaoDespesa
     */
    public function getFkOrcamentoClassificacaoDespesas()
    {
        return $this->fkOrcamentoClassificacaoDespesas;
    }

    /**
     * OneToOne (inverse side)
     * Set TcerjContaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Tcerj\ContaDespesa $fkTcerjContaDespesa
     * @return ContaDespesa
     */
    public function setFkTcerjContaDespesa(\Urbem\CoreBundle\Entity\Tcerj\ContaDespesa $fkTcerjContaDespesa)
    {
        $fkTcerjContaDespesa->setFkOrcamentoContaDespesa($this);
        $this->fkTcerjContaDespesa = $fkTcerjContaDespesa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcerjContaDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Tcerj\ContaDespesa
     */
    public function getFkTcerjContaDespesa()
    {
        return $this->fkTcerjContaDespesa;
    }

    /**
     * OneToOne (inverse side)
     * Set TcmgoElementoDePara
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ElementoDePara $fkTcmgoElementoDePara
     * @return ContaDespesa
     */
    public function setFkTcmgoElementoDePara(\Urbem\CoreBundle\Entity\Tcmgo\ElementoDePara $fkTcmgoElementoDePara)
    {
        $fkTcmgoElementoDePara->setFkOrcamentoContaDespesa($this);
        $this->fkTcmgoElementoDePara = $fkTcmgoElementoDePara;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcmgoElementoDePara
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\ElementoDePara
     */
    public function getFkTcmgoElementoDePara()
    {
        return $this->fkTcmgoElementoDePara;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codConta, $this->descricao);
    }
}
