<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * TipoItem
 */
class TipoItem
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $alias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem
     */
    private $fkAlmoxarifadoCatalogoItens;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoCatalogoItens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoItem
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoItem
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
     * Add AlmoxarifadoCatalogoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem
     * @return TipoItem
     */
    public function addFkAlmoxarifadoCatalogoItens(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem)
    {
        if (false === $this->fkAlmoxarifadoCatalogoItens->contains($fkAlmoxarifadoCatalogoItem)) {
            $fkAlmoxarifadoCatalogoItem->setFkAlmoxarifadoTipoItem($this);
            $this->fkAlmoxarifadoCatalogoItens->add($fkAlmoxarifadoCatalogoItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoCatalogoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem
     */
    public function removeFkAlmoxarifadoCatalogoItens(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem)
    {
        $this->fkAlmoxarifadoCatalogoItens->removeElement($fkAlmoxarifadoCatalogoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoCatalogoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem
     */
    public function getFkAlmoxarifadoCatalogoItens()
    {
        return $this->fkAlmoxarifadoCatalogoItens;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->descricao;
    }
}
