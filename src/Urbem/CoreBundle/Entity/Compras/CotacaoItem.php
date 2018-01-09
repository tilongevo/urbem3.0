<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * CotacaoItem
 */
class CotacaoItem
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
    private $lote;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem
     */
    private $fkComprasCotacaoFornecedorItens;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Cotacao
     */
    private $fkComprasCotacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem
     */
    private $fkAlmoxarifadoCatalogoItem;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasCotacaoFornecedorItens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return CotacaoItem
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
     * @return CotacaoItem
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
     * Set lote
     *
     * @param integer $lote
     * @return CotacaoItem
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
     * Set codItem
     *
     * @param integer $codItem
     * @return CotacaoItem
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
     * Set quantidade
     *
     * @param integer $quantidade
     * @return CotacaoItem
     */
    public function setQuantidade($quantidade = null)
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
     * Add ComprasCotacaoFornecedorItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem $fkComprasCotacaoFornecedorItem
     * @return CotacaoItem
     */
    public function addFkComprasCotacaoFornecedorItens(\Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem $fkComprasCotacaoFornecedorItem)
    {
        if (false === $this->fkComprasCotacaoFornecedorItens->contains($fkComprasCotacaoFornecedorItem)) {
            $fkComprasCotacaoFornecedorItem->setFkComprasCotacaoItem($this);
            $this->fkComprasCotacaoFornecedorItens->add($fkComprasCotacaoFornecedorItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasCotacaoFornecedorItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem $fkComprasCotacaoFornecedorItem
     */
    public function removeFkComprasCotacaoFornecedorItens(\Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem $fkComprasCotacaoFornecedorItem)
    {
        $this->fkComprasCotacaoFornecedorItens->removeElement($fkComprasCotacaoFornecedorItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasCotacaoFornecedorItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem
     */
    public function getFkComprasCotacaoFornecedorItens()
    {
        return $this->fkComprasCotacaoFornecedorItens;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasCotacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Cotacao $fkComprasCotacao
     * @return CotacaoItem
     */
    public function setFkComprasCotacao(\Urbem\CoreBundle\Entity\Compras\Cotacao $fkComprasCotacao)
    {
        $this->exercicio = $fkComprasCotacao->getExercicio();
        $this->codCotacao = $fkComprasCotacao->getCodCotacao();
        $this->fkComprasCotacao = $fkComprasCotacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasCotacao
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Cotacao
     */
    public function getFkComprasCotacao()
    {
        return $this->fkComprasCotacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCatalogoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem
     * @return CotacaoItem
     */
    public function setFkAlmoxarifadoCatalogoItem(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem)
    {
        $this->codItem = $fkAlmoxarifadoCatalogoItem->getCodItem();
        $this->fkAlmoxarifadoCatalogoItem = $fkAlmoxarifadoCatalogoItem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoCatalogoItem
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem
     */
    public function getFkAlmoxarifadoCatalogoItem()
    {
        return $this->fkAlmoxarifadoCatalogoItem;
    }
}
