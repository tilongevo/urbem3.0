<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * TipoItem
 */
class TipoItem
{
    const TIPO_COMBUSTIVEL = 1;

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
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Item
     */
    private $fkFrotaItens;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFrotaItens = new \Doctrine\Common\Collections\ArrayCollection();
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
    public function setDescricao($descricao = null)
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
     * Add FrotaItem
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Item $fkFrotaItem
     * @return TipoItem
     */
    public function addFkFrotaItens(\Urbem\CoreBundle\Entity\Frota\Item $fkFrotaItem)
    {
        if (false === $this->fkFrotaItens->contains($fkFrotaItem)) {
            $fkFrotaItem->setFkFrotaTipoItem($this);
            $this->fkFrotaItens->add($fkFrotaItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaItem
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Item $fkFrotaItem
     */
    public function removeFkFrotaItens(\Urbem\CoreBundle\Entity\Frota\Item $fkFrotaItem)
    {
        $this->fkFrotaItens->removeElement($fkFrotaItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Item
     */
    public function getFkFrotaItens()
    {
        return $this->fkFrotaItens;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            "%s - %s",
            $this->codTipo,
            $this->descricao
        );
    }
}
