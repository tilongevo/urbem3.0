<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * CombustivelItem
 */
class CombustivelItem
{
    /**
     * PK
     * @var integer
     */
    private $codCombustivel;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Frota\Item
     */
    private $fkFrotaItem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Combustivel
     */
    private $fkFrotaCombustivel;


    /**
     * Set codCombustivel
     *
     * @param integer $codCombustivel
     * @return CombustivelItem
     */
    public function setCodCombustivel($codCombustivel)
    {
        $this->codCombustivel = $codCombustivel;
        return $this;
    }

    /**
     * Get codCombustivel
     *
     * @return integer
     */
    public function getCodCombustivel()
    {
        return $this->codCombustivel;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return CombustivelItem
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
     * ManyToOne (inverse side)
     * Set fkFrotaCombustivel
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Combustivel $fkFrotaCombustivel
     * @return CombustivelItem
     */
    public function setFkFrotaCombustivel(\Urbem\CoreBundle\Entity\Frota\Combustivel $fkFrotaCombustivel)
    {
        $this->codCombustivel = $fkFrotaCombustivel->getCodCombustivel();
        $this->fkFrotaCombustivel = $fkFrotaCombustivel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaCombustivel
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Combustivel
     */
    public function getFkFrotaCombustivel()
    {
        return $this->fkFrotaCombustivel;
    }

    /**
     * OneToOne (owning side)
     * Set FrotaItem
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Item $fkFrotaItem
     * @return CombustivelItem
     */
    public function setFkFrotaItem(\Urbem\CoreBundle\Entity\Frota\Item $fkFrotaItem)
    {
        $this->codItem = $fkFrotaItem->getCodItem();
        $this->fkFrotaItem = $fkFrotaItem;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFrotaItem
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Item
     */
    public function getFkFrotaItem()
    {
        return $this->fkFrotaItem;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkFrotaCombustivel;
    }
}
