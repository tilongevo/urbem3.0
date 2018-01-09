<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * CombustivelVinculo
 */
class CombustivelVinculo
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
    private $codTipo;

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
     * @var \Urbem\CoreBundle\Entity\Tcmgo\Combustivel
     */
    private $fkTcmgoCombustivel;


    /**
     * Set codCombustivel
     *
     * @param integer $codCombustivel
     * @return CombustivelVinculo
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return CombustivelVinculo
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
     * Set codItem
     *
     * @param integer $codItem
     * @return CombustivelVinculo
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
     * Set fkTcmgoCombustivel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Combustivel $fkTcmgoCombustivel
     * @return CombustivelVinculo
     */
    public function setFkTcmgoCombustivel(\Urbem\CoreBundle\Entity\Tcmgo\Combustivel $fkTcmgoCombustivel)
    {
        $this->codCombustivel = $fkTcmgoCombustivel->getCodCombustivel();
        $this->codTipo = $fkTcmgoCombustivel->getCodTipo();
        $this->fkTcmgoCombustivel = $fkTcmgoCombustivel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoCombustivel
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\Combustivel
     */
    public function getFkTcmgoCombustivel()
    {
        return $this->fkTcmgoCombustivel;
    }

    /**
     * OneToOne (owning side)
     * Set FrotaItem
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Item $fkFrotaItem
     * @return CombustivelVinculo
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
}
