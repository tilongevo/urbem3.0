<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * SolicitacaoItemDotacao
 */
class SolicitacaoItemDotacao
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
    private $codSolicitacao;

    /**
     * PK
     * @var integer
     */
    private $codCentro;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * PK
     * @var integer
     */
    private $codConta;

    /**
     * PK
     * @var integer
     */
    private $codDespesa;

    /**
     * @var integer
     */
    private $vlReserva;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaItemDotacao
     */
    private $fkComprasMapaItemDotacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacaoAnulacao
     */
    private $fkComprasSolicitacaoItemDotacaoAnulacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaReserva
     */
    private $fkComprasSolicitacaoHomologadaReservas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa
     */
    private $fkOrcamentoContaDespesa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\SolicitacaoItem
     */
    private $fkComprasSolicitacaoItem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    private $fkOrcamentoDespesa;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasMapaItemDotacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasSolicitacaoItemDotacaoAnulacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasSolicitacaoHomologadaReservas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SolicitacaoItemDotacao
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
     * @return SolicitacaoItemDotacao
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
     * Set codSolicitacao
     *
     * @param integer $codSolicitacao
     * @return SolicitacaoItemDotacao
     */
    public function setCodSolicitacao($codSolicitacao)
    {
        $this->codSolicitacao = $codSolicitacao;
        return $this;
    }

    /**
     * Get codSolicitacao
     *
     * @return integer
     */
    public function getCodSolicitacao()
    {
        return $this->codSolicitacao;
    }

    /**
     * Set codCentro
     *
     * @param integer $codCentro
     * @return SolicitacaoItemDotacao
     */
    public function setCodCentro($codCentro)
    {
        $this->codCentro = $codCentro;
        return $this;
    }

    /**
     * Get codCentro
     *
     * @return integer
     */
    public function getCodCentro()
    {
        return $this->codCentro;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return SolicitacaoItemDotacao
     */
    public function setCodItem($codItem)
    {
        $this->codItem = $codItem;
        return $this;
    }

    /**
     * Get codItem
     *
     * @return integer
     */
    public function getCodItem()
    {
        return $this->codItem;
    }

    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return SolicitacaoItemDotacao
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
     * Set codDespesa
     *
     * @param integer $codDespesa
     * @return SolicitacaoItemDotacao
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
     * Set vlReserva
     *
     * @param integer $vlReserva
     * @return SolicitacaoItemDotacao
     */
    public function setVlReserva($vlReserva = null)
    {
        $this->vlReserva = $vlReserva;
        return $this;
    }

    /**
     * Get vlReserva
     *
     * @return integer
     */
    public function getVlReserva()
    {
        return $this->vlReserva;
    }

    /**
     * Set quantidade
     *
     * @param integer $quantidade
     * @return SolicitacaoItemDotacao
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    /**
     * Get quantidade
     *
     * @return integer
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasMapaItemDotacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaItemDotacao $fkComprasMapaItemDotacao
     * @return SolicitacaoItemDotacao
     */
    public function addFkComprasMapaItemDotacoes(\Urbem\CoreBundle\Entity\Compras\MapaItemDotacao $fkComprasMapaItemDotacao)
    {
        if (false === $this->fkComprasMapaItemDotacoes->contains($fkComprasMapaItemDotacao)) {
            $fkComprasMapaItemDotacao->setFkComprasSolicitacaoItemDotacao($this);
            $this->fkComprasMapaItemDotacoes->add($fkComprasMapaItemDotacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasMapaItemDotacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaItemDotacao $fkComprasMapaItemDotacao
     */
    public function removeFkComprasMapaItemDotacoes(\Urbem\CoreBundle\Entity\Compras\MapaItemDotacao $fkComprasMapaItemDotacao)
    {
        $this->fkComprasMapaItemDotacoes->removeElement($fkComprasMapaItemDotacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasMapaItemDotacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaItemDotacao
     */
    public function getFkComprasMapaItemDotacoes()
    {
        return $this->fkComprasMapaItemDotacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasSolicitacaoItemDotacaoAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacaoAnulacao $fkComprasSolicitacaoItemDotacaoAnulacao
     * @return SolicitacaoItemDotacao
     */
    public function addFkComprasSolicitacaoItemDotacaoAnulacoes(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacaoAnulacao $fkComprasSolicitacaoItemDotacaoAnulacao)
    {
        if (false === $this->fkComprasSolicitacaoItemDotacaoAnulacoes->contains($fkComprasSolicitacaoItemDotacaoAnulacao)) {
            $fkComprasSolicitacaoItemDotacaoAnulacao->setFkComprasSolicitacaoItemDotacao($this);
            $this->fkComprasSolicitacaoItemDotacaoAnulacoes->add($fkComprasSolicitacaoItemDotacaoAnulacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasSolicitacaoItemDotacaoAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacaoAnulacao $fkComprasSolicitacaoItemDotacaoAnulacao
     */
    public function removeFkComprasSolicitacaoItemDotacaoAnulacoes(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacaoAnulacao $fkComprasSolicitacaoItemDotacaoAnulacao)
    {
        $this->fkComprasSolicitacaoItemDotacaoAnulacoes->removeElement($fkComprasSolicitacaoItemDotacaoAnulacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasSolicitacaoItemDotacaoAnulacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacaoAnulacao
     */
    public function getFkComprasSolicitacaoItemDotacaoAnulacoes()
    {
        return $this->fkComprasSolicitacaoItemDotacaoAnulacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasSolicitacaoHomologadaReserva
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaReserva $fkComprasSolicitacaoHomologadaReserva
     * @return SolicitacaoItemDotacao
     */
    public function addFkComprasSolicitacaoHomologadaReservas(\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaReserva $fkComprasSolicitacaoHomologadaReserva)
    {
        if (false === $this->fkComprasSolicitacaoHomologadaReservas->contains($fkComprasSolicitacaoHomologadaReserva)) {
            $fkComprasSolicitacaoHomologadaReserva->setFkComprasSolicitacaoItemDotacao($this);
            $this->fkComprasSolicitacaoHomologadaReservas->add($fkComprasSolicitacaoHomologadaReserva);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasSolicitacaoHomologadaReserva
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaReserva $fkComprasSolicitacaoHomologadaReserva
     */
    public function removeFkComprasSolicitacaoHomologadaReservas(\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaReserva $fkComprasSolicitacaoHomologadaReserva)
    {
        $this->fkComprasSolicitacaoHomologadaReservas->removeElement($fkComprasSolicitacaoHomologadaReserva);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasSolicitacaoHomologadaReservas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaReserva
     */
    public function getFkComprasSolicitacaoHomologadaReservas()
    {
        return $this->fkComprasSolicitacaoHomologadaReservas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoContaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa $fkOrcamentoContaDespesa
     * @return SolicitacaoItemDotacao
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
     * Set fkComprasSolicitacaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItem $fkComprasSolicitacaoItem
     * @return SolicitacaoItemDotacao
     */
    public function setFkComprasSolicitacaoItem(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItem $fkComprasSolicitacaoItem)
    {
        $this->exercicio = $fkComprasSolicitacaoItem->getExercicio();
        $this->codEntidade = $fkComprasSolicitacaoItem->getCodEntidade();
        $this->codSolicitacao = $fkComprasSolicitacaoItem->getCodSolicitacao();
        $this->codCentro = $fkComprasSolicitacaoItem->getCodCentro();
        $this->codItem = $fkComprasSolicitacaoItem->getCodItem();
        $this->fkComprasSolicitacaoItem = $fkComprasSolicitacaoItem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasSolicitacaoItem
     *
     * @return \Urbem\CoreBundle\Entity\Compras\SolicitacaoItem
     */
    public function getFkComprasSolicitacaoItem()
    {
        return $this->fkComprasSolicitacaoItem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa
     * @return SolicitacaoItemDotacao
     */
    public function setFkOrcamentoDespesa(\Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa)
    {
        $this->exercicio = $fkOrcamentoDespesa->getExercicio();
        $this->codDespesa = $fkOrcamentoDespesa->getCodDespesa();
        $this->fkOrcamentoDespesa = $fkOrcamentoDespesa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    public function getFkOrcamentoDespesa()
    {
        return $this->fkOrcamentoDespesa;
    }
}
