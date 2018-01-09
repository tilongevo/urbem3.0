<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * CatalogoItemBarras
 */
class CatalogoItemBarras
{
    /**
     * PK
     * @var integer
     */
    private $codMarca;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * @var string
     */
    private $codigoBarras;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca
     */
    private $fkAlmoxarifadoCatalogoItemMarca;


    /**
     * Set codMarca
     *
     * @param integer $codMarca
     * @return CatalogoItemBarras
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
     * Set codItem
     *
     * @param integer $codItem
     * @return CatalogoItemBarras
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
     * Set codigoBarras
     *
     * @param string $codigoBarras
     * @return CatalogoItemBarras
     */
    public function setCodigoBarras($codigoBarras)
    {
        $this->codigoBarras = $codigoBarras;
        return $this;
    }

    /**
     * Get codigoBarras
     *
     * @return string
     */
    public function getCodigoBarras()
    {
        return $this->codigoBarras;
    }

    /**
     * OneToOne (owning side)
     * Set AlmoxarifadoCatalogoItemMarca
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca $fkAlmoxarifadoCatalogoItemMarca
     * @return CatalogoItemBarras
     */
    public function setFkAlmoxarifadoCatalogoItemMarca(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca $fkAlmoxarifadoCatalogoItemMarca)
    {
        $this->codItem = $fkAlmoxarifadoCatalogoItemMarca->getCodItem();
        $this->codMarca = $fkAlmoxarifadoCatalogoItemMarca->getCodMarca();
        $this->fkAlmoxarifadoCatalogoItemMarca = $fkAlmoxarifadoCatalogoItemMarca;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkAlmoxarifadoCatalogoItemMarca
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca
     */
    public function getFkAlmoxarifadoCatalogoItemMarca()
    {
        return $this->fkAlmoxarifadoCatalogoItemMarca;
    }
}
