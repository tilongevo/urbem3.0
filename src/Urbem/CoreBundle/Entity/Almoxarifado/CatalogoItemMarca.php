<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * CatalogoItemMarca
 */
class CatalogoItemMarca
{
    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * PK
     * @var integer
     */
    private $codMarca;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemBarras
     */
    private $fkAlmoxarifadoCatalogoItemBarras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial
     */
    private $fkAlmoxarifadoEstoqueMateriais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem
     */
    private $fkComprasCotacaoFornecedorItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\OrdemItem
     */
    private $fkComprasOrdemItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LocalizacaoFisicaItem
     */
    private $fkAlmoxarifadoLocalizacaoFisicaItens;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Marca
     */
    private $fkAlmoxarifadoMarca;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoEstoqueMateriais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasCotacaoFornecedorItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasOrdemItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoLocalizacaoFisicaItens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return CatalogoItemMarca
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
     * Set codMarca
     *
     * @param integer $codMarca
     * @return CatalogoItemMarca
     */
    public function setCodMarca($codMarca)
    {
        $this->codMarca = $codMarca;
        return $this;
    }

    /**
     * Get codMarca
     *
     * @return integer
     */
    public function getCodMarca()
    {
        return $this->codMarca;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoEstoqueMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial $fkAlmoxarifadoEstoqueMaterial
     * @return CatalogoItemMarca
     */
    public function addFkAlmoxarifadoEstoqueMateriais(\Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial $fkAlmoxarifadoEstoqueMaterial)
    {
        if (false === $this->fkAlmoxarifadoEstoqueMateriais->contains($fkAlmoxarifadoEstoqueMaterial)) {
            $fkAlmoxarifadoEstoqueMaterial->setFkAlmoxarifadoCatalogoItemMarca($this);
            $this->fkAlmoxarifadoEstoqueMateriais->add($fkAlmoxarifadoEstoqueMaterial);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoEstoqueMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial $fkAlmoxarifadoEstoqueMaterial
     */
    public function removeFkAlmoxarifadoEstoqueMateriais(\Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial $fkAlmoxarifadoEstoqueMaterial)
    {
        $this->fkAlmoxarifadoEstoqueMateriais->removeElement($fkAlmoxarifadoEstoqueMaterial);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoEstoqueMateriais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial
     */
    public function getFkAlmoxarifadoEstoqueMateriais()
    {
        return $this->fkAlmoxarifadoEstoqueMateriais;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasCotacaoFornecedorItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem $fkComprasCotacaoFornecedorItem
     * @return CatalogoItemMarca
     */
    public function addFkComprasCotacaoFornecedorItens(\Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem $fkComprasCotacaoFornecedorItem)
    {
        if (false === $this->fkComprasCotacaoFornecedorItens->contains($fkComprasCotacaoFornecedorItem)) {
            $fkComprasCotacaoFornecedorItem->setFkAlmoxarifadoCatalogoItemMarca($this);
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
     * OneToMany (owning side)
     * Add ComprasOrdemItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\OrdemItem $fkComprasOrdemItem
     * @return CatalogoItemMarca
     */
    public function addFkComprasOrdemItens(\Urbem\CoreBundle\Entity\Compras\OrdemItem $fkComprasOrdemItem)
    {
        if (false === $this->fkComprasOrdemItens->contains($fkComprasOrdemItem)) {
            $fkComprasOrdemItem->setFkAlmoxarifadoCatalogoItemMarca($this);
            $this->fkComprasOrdemItens->add($fkComprasOrdemItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasOrdemItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\OrdemItem $fkComprasOrdemItem
     */
    public function removeFkComprasOrdemItens(\Urbem\CoreBundle\Entity\Compras\OrdemItem $fkComprasOrdemItem)
    {
        $this->fkComprasOrdemItens->removeElement($fkComprasOrdemItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasOrdemItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\OrdemItem
     */
    public function getFkComprasOrdemItens()
    {
        return $this->fkComprasOrdemItens;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoLocalizacaoFisicaItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LocalizacaoFisicaItem $fkAlmoxarifadoLocalizacaoFisicaItem
     * @return CatalogoItemMarca
     */
    public function addFkAlmoxarifadoLocalizacaoFisicaItens(\Urbem\CoreBundle\Entity\Almoxarifado\LocalizacaoFisicaItem $fkAlmoxarifadoLocalizacaoFisicaItem)
    {
        if (false === $this->fkAlmoxarifadoLocalizacaoFisicaItens->contains($fkAlmoxarifadoLocalizacaoFisicaItem)) {
            $fkAlmoxarifadoLocalizacaoFisicaItem->setFkAlmoxarifadoCatalogoItemMarca($this);
            $this->fkAlmoxarifadoLocalizacaoFisicaItens->add($fkAlmoxarifadoLocalizacaoFisicaItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoLocalizacaoFisicaItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LocalizacaoFisicaItem $fkAlmoxarifadoLocalizacaoFisicaItem
     */
    public function removeFkAlmoxarifadoLocalizacaoFisicaItens(\Urbem\CoreBundle\Entity\Almoxarifado\LocalizacaoFisicaItem $fkAlmoxarifadoLocalizacaoFisicaItem)
    {
        $this->fkAlmoxarifadoLocalizacaoFisicaItens->removeElement($fkAlmoxarifadoLocalizacaoFisicaItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoLocalizacaoFisicaItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LocalizacaoFisicaItem
     */
    public function getFkAlmoxarifadoLocalizacaoFisicaItens()
    {
        return $this->fkAlmoxarifadoLocalizacaoFisicaItens;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoMarca
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Marca $fkAlmoxarifadoMarca
     * @return CatalogoItemMarca
     */
    public function setFkAlmoxarifadoMarca(\Urbem\CoreBundle\Entity\Almoxarifado\Marca $fkAlmoxarifadoMarca)
    {
        $this->codMarca = $fkAlmoxarifadoMarca->getCodMarca();
        $this->fkAlmoxarifadoMarca = $fkAlmoxarifadoMarca;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoMarca
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\Marca
     */
    public function getFkAlmoxarifadoMarca()
    {
        return $this->fkAlmoxarifadoMarca;
    }

    /**
     * OneToOne (inverse side)
     * Set AlmoxarifadoCatalogoItemBarras
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemBarras $fkAlmoxarifadoCatalogoItemBarras
     * @return CatalogoItemMarca
     */
    public function setFkAlmoxarifadoCatalogoItemBarras(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemBarras $fkAlmoxarifadoCatalogoItemBarras)
    {
        $fkAlmoxarifadoCatalogoItemBarras->setFkAlmoxarifadoCatalogoItemMarca($this);
        $this->fkAlmoxarifadoCatalogoItemBarras = $fkAlmoxarifadoCatalogoItemBarras;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkAlmoxarifadoCatalogoItemBarras
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemBarras
     */
    public function getFkAlmoxarifadoCatalogoItemBarras()
    {
        return $this->fkAlmoxarifadoCatalogoItemBarras;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkAlmoxarifadoMarca->getDescricao();
    }
}
