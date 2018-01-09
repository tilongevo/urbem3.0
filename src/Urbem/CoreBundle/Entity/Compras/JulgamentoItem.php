<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * JulgamentoItem
 */
class JulgamentoItem
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
    private $codCotacao;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * PK
     * @var integer
     */
    private $cgmFornecedor;

    /**
     * PK
     * @var integer
     */
    private $lote;

    /**
     * @var integer
     */
    private $ordem;

    /**
     * @var string
     */
    private $justificativa;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem
     */
    private $fkComprasCotacaoFornecedorItem;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\Homologacao
     */
    private $fkComprasHomologacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenhoJulgamento
     */
    private $fkEmpenhoItemPreEmpenhoJulgamentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Julgamento
     */
    private $fkComprasJulgamento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasHomologacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoItemPreEmpenhoJulgamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return JulgamentoItem
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
     * Set codCotacao
     *
     * @param integer $codCotacao
     * @return JulgamentoItem
     */
    public function setCodCotacao($codCotacao)
    {
        $this->codCotacao = $codCotacao;
        return $this;
    }

    /**
     * Get codCotacao
     *
     * @return integer
     */
    public function getCodCotacao()
    {
        return $this->codCotacao;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return JulgamentoItem
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
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return JulgamentoItem
     */
    public function setCgmFornecedor($cgmFornecedor)
    {
        $this->cgmFornecedor = $cgmFornecedor;
        return $this;
    }

    /**
     * Get cgmFornecedor
     *
     * @return integer
     */
    public function getCgmFornecedor()
    {
        return $this->cgmFornecedor;
    }

    /**
     * Set lote
     *
     * @param integer $lote
     * @return JulgamentoItem
     */
    public function setLote($lote)
    {
        $this->lote = $lote;
        return $this;
    }

    /**
     * Get lote
     *
     * @return integer
     */
    public function getLote()
    {
        return $this->lote;
    }

    /**
     * Set ordem
     *
     * @param integer $ordem
     * @return JulgamentoItem
     */
    public function setOrdem($ordem)
    {
        $this->ordem = $ordem;
        return $this;
    }

    /**
     * Get ordem
     *
     * @return integer
     */
    public function getOrdem()
    {
        return $this->ordem;
    }

    /**
     * Set justificativa
     *
     * @param string $justificativa
     * @return JulgamentoItem
     */
    public function setJustificativa($justificativa = null)
    {
        $this->justificativa = $justificativa;
        return $this;
    }

    /**
     * Get justificativa
     *
     * @return string
     */
    public function getJustificativa()
    {
        return $this->justificativa;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasHomologacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Homologacao $fkComprasHomologacao
     * @return JulgamentoItem
     */
    public function addFkComprasHomologacoes(\Urbem\CoreBundle\Entity\Compras\Homologacao $fkComprasHomologacao)
    {
        if (false === $this->fkComprasHomologacoes->contains($fkComprasHomologacao)) {
            $fkComprasHomologacao->setFkComprasJulgamentoItem($this);
            $this->fkComprasHomologacoes->add($fkComprasHomologacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasHomologacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Homologacao $fkComprasHomologacao
     */
    public function removeFkComprasHomologacoes(\Urbem\CoreBundle\Entity\Compras\Homologacao $fkComprasHomologacao)
    {
        $this->fkComprasHomologacoes->removeElement($fkComprasHomologacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasHomologacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\Homologacao
     */
    public function getFkComprasHomologacoes()
    {
        return $this->fkComprasHomologacoes;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoItemPreEmpenhoJulgamento
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenhoJulgamento $fkEmpenhoItemPreEmpenhoJulgamento
     * @return JulgamentoItem
     */
    public function addFkEmpenhoItemPreEmpenhoJulgamentos(\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenhoJulgamento $fkEmpenhoItemPreEmpenhoJulgamento)
    {
        if (false === $this->fkEmpenhoItemPreEmpenhoJulgamentos->contains($fkEmpenhoItemPreEmpenhoJulgamento)) {
            $fkEmpenhoItemPreEmpenhoJulgamento->setFkComprasJulgamentoItem($this);
            $this->fkEmpenhoItemPreEmpenhoJulgamentos->add($fkEmpenhoItemPreEmpenhoJulgamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoItemPreEmpenhoJulgamento
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenhoJulgamento $fkEmpenhoItemPreEmpenhoJulgamento
     */
    public function removeFkEmpenhoItemPreEmpenhoJulgamentos(\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenhoJulgamento $fkEmpenhoItemPreEmpenhoJulgamento)
    {
        $this->fkEmpenhoItemPreEmpenhoJulgamentos->removeElement($fkEmpenhoItemPreEmpenhoJulgamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoItemPreEmpenhoJulgamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenhoJulgamento
     */
    public function getFkEmpenhoItemPreEmpenhoJulgamentos()
    {
        return $this->fkEmpenhoItemPreEmpenhoJulgamentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasJulgamento
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Julgamento $fkComprasJulgamento
     * @return JulgamentoItem
     */
    public function setFkComprasJulgamento(\Urbem\CoreBundle\Entity\Compras\Julgamento $fkComprasJulgamento)
    {
        $this->exercicio = $fkComprasJulgamento->getExercicio();
        $this->codCotacao = $fkComprasJulgamento->getCodCotacao();
        $this->fkComprasJulgamento = $fkComprasJulgamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasJulgamento
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Julgamento
     */
    public function getFkComprasJulgamento()
    {
        return $this->fkComprasJulgamento;
    }

    /**
     * OneToOne (owning side)
     * Set ComprasCotacaoFornecedorItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem $fkComprasCotacaoFornecedorItem
     * @return JulgamentoItem
     */
    public function setFkComprasCotacaoFornecedorItem(\Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem $fkComprasCotacaoFornecedorItem)
    {
        $this->exercicio = $fkComprasCotacaoFornecedorItem->getExercicio();
        $this->codCotacao = $fkComprasCotacaoFornecedorItem->getCodCotacao();
        $this->codItem = $fkComprasCotacaoFornecedorItem->getCodItem();
        $this->cgmFornecedor = $fkComprasCotacaoFornecedorItem->getCgmFornecedor();
        $this->lote = $fkComprasCotacaoFornecedorItem->getLote();
        $this->fkComprasCotacaoFornecedorItem = $fkComprasCotacaoFornecedorItem;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkComprasCotacaoFornecedorItem
     *
     * @return \Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem
     */
    public function getFkComprasCotacaoFornecedorItem()
    {
        return $this->fkComprasCotacaoFornecedorItem;
    }
}
