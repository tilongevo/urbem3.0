<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * LocalizacaoFisicaItem
 */
class LocalizacaoFisicaItem
{
    /**
     * PK
     * @var integer
     */
    private $codAlmoxarifado;

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
     * @var integer
     */
    private $codLocalizacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\LocalizacaoFisica
     */
    private $fkAlmoxarifadoLocalizacaoFisica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca
     */
    private $fkAlmoxarifadoCatalogoItemMarca;


    /**
     * Set codAlmoxarifado
     *
     * @param integer $codAlmoxarifado
     * @return LocalizacaoFisicaItem
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
     * Set codItem
     *
     * @param integer $codItem
     * @return LocalizacaoFisicaItem
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
     * @return LocalizacaoFisicaItem
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
     * Set codLocalizacao
     *
     * @param integer $codLocalizacao
     * @return LocalizacaoFisicaItem
     */
    public function setCodLocalizacao($codLocalizacao)
    {
        $this->codLocalizacao = $codLocalizacao;
        return $this;
    }

    /**
     * Get codLocalizacao
     *
     * @return integer
     */
    public function getCodLocalizacao()
    {
        return $this->codLocalizacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoLocalizacaoFisica
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LocalizacaoFisica $fkAlmoxarifadoLocalizacaoFisica
     * @return LocalizacaoFisicaItem
     */
    public function setFkAlmoxarifadoLocalizacaoFisica(\Urbem\CoreBundle\Entity\Almoxarifado\LocalizacaoFisica $fkAlmoxarifadoLocalizacaoFisica)
    {
        $this->codAlmoxarifado = $fkAlmoxarifadoLocalizacaoFisica->getCodAlmoxarifado();
        $this->codLocalizacao = $fkAlmoxarifadoLocalizacaoFisica->getCodLocalizacao();
        $this->fkAlmoxarifadoLocalizacaoFisica = $fkAlmoxarifadoLocalizacaoFisica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoLocalizacaoFisica
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\LocalizacaoFisica
     */
    public function getFkAlmoxarifadoLocalizacaoFisica()
    {
        return $this->fkAlmoxarifadoLocalizacaoFisica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCatalogoItemMarca
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca $fkAlmoxarifadoCatalogoItemMarca
     * @return LocalizacaoFisicaItem
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
}
