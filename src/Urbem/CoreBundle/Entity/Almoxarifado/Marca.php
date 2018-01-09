<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * Marca
 */
class Marca
{
    /**
     * PK
     * @var integer
     */
    private $codMarca;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca
     */
    private $fkAlmoxarifadoCatalogoItemMarcas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem
     */
    private $fkAlmoxarifadoPedidoTransferenciaItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho
     */
    private $fkEmpenhoItemPreEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemMarca
     */
    private $fkPatrimonioBemMarcas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoCatalogoItemMarcas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoPedidoTransferenciaItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoItemPreEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioBemMarcas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codMarca
     *
     * @param integer $codMarca
     * @return Marca
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
     * Set descricao
     *
     * @param string $descricao
     * @return Marca
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
     * OneToMany (owning side)
     * Add AlmoxarifadoCatalogoItemMarca
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca $fkAlmoxarifadoCatalogoItemMarca
     * @return Marca
     */
    public function addFkAlmoxarifadoCatalogoItemMarcas(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca $fkAlmoxarifadoCatalogoItemMarca)
    {
        if (false === $this->fkAlmoxarifadoCatalogoItemMarcas->contains($fkAlmoxarifadoCatalogoItemMarca)) {
            $fkAlmoxarifadoCatalogoItemMarca->setFkAlmoxarifadoMarca($this);
            $this->fkAlmoxarifadoCatalogoItemMarcas->add($fkAlmoxarifadoCatalogoItemMarca);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoCatalogoItemMarca
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca $fkAlmoxarifadoCatalogoItemMarca
     */
    public function removeFkAlmoxarifadoCatalogoItemMarcas(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca $fkAlmoxarifadoCatalogoItemMarca)
    {
        $this->fkAlmoxarifadoCatalogoItemMarcas->removeElement($fkAlmoxarifadoCatalogoItemMarca);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoCatalogoItemMarcas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca
     */
    public function getFkAlmoxarifadoCatalogoItemMarcas()
    {
        return $this->fkAlmoxarifadoCatalogoItemMarcas;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoPedidoTransferenciaItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem $fkAlmoxarifadoPedidoTransferenciaItem
     * @return Marca
     */
    public function addFkAlmoxarifadoPedidoTransferenciaItens(\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem $fkAlmoxarifadoPedidoTransferenciaItem)
    {
        if (false === $this->fkAlmoxarifadoPedidoTransferenciaItens->contains($fkAlmoxarifadoPedidoTransferenciaItem)) {
            $fkAlmoxarifadoPedidoTransferenciaItem->setFkAlmoxarifadoMarca($this);
            $this->fkAlmoxarifadoPedidoTransferenciaItens->add($fkAlmoxarifadoPedidoTransferenciaItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoPedidoTransferenciaItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem $fkAlmoxarifadoPedidoTransferenciaItem
     */
    public function removeFkAlmoxarifadoPedidoTransferenciaItens(\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem $fkAlmoxarifadoPedidoTransferenciaItem)
    {
        $this->fkAlmoxarifadoPedidoTransferenciaItens->removeElement($fkAlmoxarifadoPedidoTransferenciaItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoPedidoTransferenciaItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem
     */
    public function getFkAlmoxarifadoPedidoTransferenciaItens()
    {
        return $this->fkAlmoxarifadoPedidoTransferenciaItens;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoItemPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho
     * @return Marca
     */
    public function addFkEmpenhoItemPreEmpenhos(\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho)
    {
        if (false === $this->fkEmpenhoItemPreEmpenhos->contains($fkEmpenhoItemPreEmpenho)) {
            $fkEmpenhoItemPreEmpenho->setFkAlmoxarifadoMarca($this);
            $this->fkEmpenhoItemPreEmpenhos->add($fkEmpenhoItemPreEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoItemPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho
     */
    public function removeFkEmpenhoItemPreEmpenhos(\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho)
    {
        $this->fkEmpenhoItemPreEmpenhos->removeElement($fkEmpenhoItemPreEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoItemPreEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho
     */
    public function getFkEmpenhoItemPreEmpenhos()
    {
        return $this->fkEmpenhoItemPreEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioBemMarca
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemMarca $fkPatrimonioBemMarca
     * @return Marca
     */
    public function addFkPatrimonioBemMarcas(\Urbem\CoreBundle\Entity\Patrimonio\BemMarca $fkPatrimonioBemMarca)
    {
        if (false === $this->fkPatrimonioBemMarcas->contains($fkPatrimonioBemMarca)) {
            $fkPatrimonioBemMarca->setFkAlmoxarifadoMarca($this);
            $this->fkPatrimonioBemMarcas->add($fkPatrimonioBemMarca);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioBemMarca
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemMarca $fkPatrimonioBemMarca
     */
    public function removeFkPatrimonioBemMarcas(\Urbem\CoreBundle\Entity\Patrimonio\BemMarca $fkPatrimonioBemMarca)
    {
        $this->fkPatrimonioBemMarcas->removeElement($fkPatrimonioBemMarca);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioBemMarcas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemMarca
     */
    public function getFkPatrimonioBemMarcas()
    {
        return $this->fkPatrimonioBemMarcas;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->codMarca . " - " . $this->descricao;
    }
}
