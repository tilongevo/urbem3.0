<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * EstoqueMaterial
 */
class EstoqueMaterial
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
     * PK
     * @var integer
     */
    private $codAlmoxarifado;

    /**
     * PK
     * @var integer
     */
    private $codCentro;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\Perecivel
     */
    private $fkAlmoxarifadoPereciveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem
     */
    private $fkAlmoxarifadoRequisicaoItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial
     */
    private $fkAlmoxarifadoLancamentoMateriais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\InventarioItens
     */
    private $fkAlmoxarifadoInventarioItens;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca
     */
    private $fkAlmoxarifadoCatalogoItemMarca;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado
     */
    private $fkAlmoxarifadoAlmoxarifado;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto
     */
    private $fkAlmoxarifadoCentroCusto;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoPereciveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoRequisicaoItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoLancamentoMateriais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoInventarioItens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return EstoqueMaterial
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
     * @return EstoqueMaterial
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
     * Set codAlmoxarifado
     *
     * @param integer $codAlmoxarifado
     * @return EstoqueMaterial
     */
    public function setCodAlmoxarifado($codAlmoxarifado)
    {
        $this->codAlmoxarifado = $codAlmoxarifado;
        return $this;
    }

    /**
     * Get codAlmoxarifado
     *
     * @return integer
     */
    public function getCodAlmoxarifado()
    {
        return $this->codAlmoxarifado;
    }

    /**
     * Set codCentro
     *
     * @param integer $codCentro
     * @return EstoqueMaterial
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
     * OneToMany (owning side)
     * Add AlmoxarifadoPerecivel
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Perecivel $fkAlmoxarifadoPerecivel
     * @return EstoqueMaterial
     */
    public function addFkAlmoxarifadoPereciveis(\Urbem\CoreBundle\Entity\Almoxarifado\Perecivel $fkAlmoxarifadoPerecivel)
    {
        if (false === $this->fkAlmoxarifadoPereciveis->contains($fkAlmoxarifadoPerecivel)) {
            $fkAlmoxarifadoPerecivel->setFkAlmoxarifadoEstoqueMaterial($this);
            $this->fkAlmoxarifadoPereciveis->add($fkAlmoxarifadoPerecivel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoPerecivel
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Perecivel $fkAlmoxarifadoPerecivel
     */
    public function removeFkAlmoxarifadoPereciveis(\Urbem\CoreBundle\Entity\Almoxarifado\Perecivel $fkAlmoxarifadoPerecivel)
    {
        $this->fkAlmoxarifadoPereciveis->removeElement($fkAlmoxarifadoPerecivel);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoPereciveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\Perecivel
     */
    public function getFkAlmoxarifadoPereciveis()
    {
        return $this->fkAlmoxarifadoPereciveis;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoRequisicaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem $fkAlmoxarifadoRequisicaoItem
     * @return EstoqueMaterial
     */
    public function addFkAlmoxarifadoRequisicaoItens(\Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem $fkAlmoxarifadoRequisicaoItem)
    {
        if (false === $this->fkAlmoxarifadoRequisicaoItens->contains($fkAlmoxarifadoRequisicaoItem)) {
            $fkAlmoxarifadoRequisicaoItem->setFkAlmoxarifadoEstoqueMaterial($this);
            $this->fkAlmoxarifadoRequisicaoItens->add($fkAlmoxarifadoRequisicaoItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoRequisicaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem $fkAlmoxarifadoRequisicaoItem
     */
    public function removeFkAlmoxarifadoRequisicaoItens(\Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem $fkAlmoxarifadoRequisicaoItem)
    {
        $this->fkAlmoxarifadoRequisicaoItens->removeElement($fkAlmoxarifadoRequisicaoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoRequisicaoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem
     */
    public function getFkAlmoxarifadoRequisicaoItens()
    {
        return $this->fkAlmoxarifadoRequisicaoItens;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoLancamentoMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial
     * @return EstoqueMaterial
     */
    public function addFkAlmoxarifadoLancamentoMateriais(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial)
    {
        if (false === $this->fkAlmoxarifadoLancamentoMateriais->contains($fkAlmoxarifadoLancamentoMaterial)) {
            $fkAlmoxarifadoLancamentoMaterial->setFkAlmoxarifadoEstoqueMaterial($this);
            $this->fkAlmoxarifadoLancamentoMateriais->add($fkAlmoxarifadoLancamentoMaterial);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoLancamentoMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial
     */
    public function removeFkAlmoxarifadoLancamentoMateriais(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial)
    {
        $this->fkAlmoxarifadoLancamentoMateriais->removeElement($fkAlmoxarifadoLancamentoMaterial);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoLancamentoMateriais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial
     */
    public function getFkAlmoxarifadoLancamentoMateriais()
    {
        return $this->fkAlmoxarifadoLancamentoMateriais;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoInventarioItens
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\InventarioItens $fkAlmoxarifadoInventarioItens
     * @return EstoqueMaterial
     */
    public function addFkAlmoxarifadoInventarioItens(\Urbem\CoreBundle\Entity\Almoxarifado\InventarioItens $fkAlmoxarifadoInventarioItens)
    {
        if (false === $this->fkAlmoxarifadoInventarioItens->contains($fkAlmoxarifadoInventarioItens)) {
            $fkAlmoxarifadoInventarioItens->setFkAlmoxarifadoEstoqueMaterial($this);
            $this->fkAlmoxarifadoInventarioItens->add($fkAlmoxarifadoInventarioItens);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoInventarioItens
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\InventarioItens $fkAlmoxarifadoInventarioItens
     */
    public function removeFkAlmoxarifadoInventarioItens(\Urbem\CoreBundle\Entity\Almoxarifado\InventarioItens $fkAlmoxarifadoInventarioItens)
    {
        $this->fkAlmoxarifadoInventarioItens->removeElement($fkAlmoxarifadoInventarioItens);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoInventarioItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\InventarioItens
     */
    public function getFkAlmoxarifadoInventarioItens()
    {
        return $this->fkAlmoxarifadoInventarioItens;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCatalogoItemMarca
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca $fkAlmoxarifadoCatalogoItemMarca
     * @return EstoqueMaterial
     */
    public function setFkAlmoxarifadoCatalogoItemMarca(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca $fkAlmoxarifadoCatalogoItemMarca)
    {
        $this->codItem = $fkAlmoxarifadoCatalogoItemMarca->getCodItem();
        $this->codMarca = $fkAlmoxarifadoCatalogoItemMarca->getCodMarca();
        $this->fkAlmoxarifadoCatalogoItemMarca = $fkAlmoxarifadoCatalogoItemMarca;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoCatalogoItemMarca
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca
     */
    public function getFkAlmoxarifadoCatalogoItemMarca()
    {
        return $this->fkAlmoxarifadoCatalogoItemMarca;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoAlmoxarifado
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado $fkAlmoxarifadoAlmoxarifado
     * @return EstoqueMaterial
     */
    public function setFkAlmoxarifadoAlmoxarifado(\Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado $fkAlmoxarifadoAlmoxarifado)
    {
        $this->codAlmoxarifado = $fkAlmoxarifadoAlmoxarifado->getCodAlmoxarifado();
        $this->fkAlmoxarifadoAlmoxarifado = $fkAlmoxarifadoAlmoxarifado;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoAlmoxarifado
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado
     */
    public function getFkAlmoxarifadoAlmoxarifado()
    {
        return $this->fkAlmoxarifadoAlmoxarifado;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCentroCusto
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto $fkAlmoxarifadoCentroCusto
     * @return EstoqueMaterial
     */
    public function setFkAlmoxarifadoCentroCusto(\Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto $fkAlmoxarifadoCentroCusto)
    {
        $this->codCentro = $fkAlmoxarifadoCentroCusto->getCodCentro();
        $this->fkAlmoxarifadoCentroCusto = $fkAlmoxarifadoCentroCusto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoCentroCusto
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto
     */
    public function getFkAlmoxarifadoCentroCusto()
    {
        return $this->fkAlmoxarifadoCentroCusto;
    }
}
