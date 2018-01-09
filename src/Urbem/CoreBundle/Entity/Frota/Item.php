<?php

namespace Urbem\CoreBundle\Entity\Frota;

/**
 * Item
 */
class Item
{
    const TIPOCADASTROITEM = 1;
    const TIPOCADASTROLOTE = 2;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Frota\CombustivelItem
     */
    private $fkFrotaCombustivelItem;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcmgo\CombustivelVinculo
     */
    private $fkTcmgoCombustivelVinculo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem
     */
    private $fkAlmoxarifadoCatalogoItem;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\ManutencaoItem
     */
    private $fkFrotaManutencaoItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Autorizacao
     */
    private $fkFrotaAutorizacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\TipoItem
     */
    private $fkFrotaTipoItem;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFrotaManutencaoItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaAutorizacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return Item
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return Item
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
     * OneToMany (owning side)
     * Add FrotaManutencaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Frota\ManutencaoItem $fkFrotaManutencaoItem
     * @return Item
     */
    public function addFkFrotaManutencaoItens(\Urbem\CoreBundle\Entity\Frota\ManutencaoItem $fkFrotaManutencaoItem)
    {
        if (false === $this->fkFrotaManutencaoItens->contains($fkFrotaManutencaoItem)) {
            $fkFrotaManutencaoItem->setFkFrotaItem($this);
            $this->fkFrotaManutencaoItens->add($fkFrotaManutencaoItem);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaManutencaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Frota\ManutencaoItem $fkFrotaManutencaoItem
     */
    public function removeFkFrotaManutencaoItens(\Urbem\CoreBundle\Entity\Frota\ManutencaoItem $fkFrotaManutencaoItem)
    {
        $this->fkFrotaManutencaoItens->removeElement($fkFrotaManutencaoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaManutencaoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\ManutencaoItem
     */
    public function getFkFrotaManutencaoItens()
    {
        return $this->fkFrotaManutencaoItens;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Autorizacao $fkFrotaAutorizacao
     * @return Item
     */
    public function addFkFrotaAutorizacoes(\Urbem\CoreBundle\Entity\Frota\Autorizacao $fkFrotaAutorizacao)
    {
        if (false === $this->fkFrotaAutorizacoes->contains($fkFrotaAutorizacao)) {
            $fkFrotaAutorizacao->setFkFrotaItem($this);
            $this->fkFrotaAutorizacoes->add($fkFrotaAutorizacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Autorizacao $fkFrotaAutorizacao
     */
    public function removeFkFrotaAutorizacoes(\Urbem\CoreBundle\Entity\Frota\Autorizacao $fkFrotaAutorizacao)
    {
        $this->fkFrotaAutorizacoes->removeElement($fkFrotaAutorizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaAutorizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Autorizacao
     */
    public function getFkFrotaAutorizacoes()
    {
        return $this->fkFrotaAutorizacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaTipoItem
     *
     * @param \Urbem\CoreBundle\Entity\Frota\TipoItem $fkFrotaTipoItem
     * @return Item
     */
    public function setFkFrotaTipoItem(\Urbem\CoreBundle\Entity\Frota\TipoItem $fkFrotaTipoItem)
    {
        $this->codTipo = $fkFrotaTipoItem->getCodTipo();
        $this->fkFrotaTipoItem = $fkFrotaTipoItem;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaTipoItem
     *
     * @return \Urbem\CoreBundle\Entity\Frota\TipoItem
     */
    public function getFkFrotaTipoItem()
    {
        return $this->fkFrotaTipoItem;
    }

    /**
     * OneToOne (inverse side)
     * Set FrotaCombustivelItem
     *
     * @param \Urbem\CoreBundle\Entity\Frota\CombustivelItem $fkFrotaCombustivelItem
     * @return Item
     */
    public function setFkFrotaCombustivelItem(\Urbem\CoreBundle\Entity\Frota\CombustivelItem $fkFrotaCombustivelItem)
    {
        $fkFrotaCombustivelItem->setFkFrotaItem($this);
        $this->fkFrotaCombustivelItem = $fkFrotaCombustivelItem;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFrotaCombustivelItem
     *
     * @return \Urbem\CoreBundle\Entity\Frota\CombustivelItem
     */
    public function getFkFrotaCombustivelItem()
    {
        return $this->fkFrotaCombustivelItem;
    }

    /**
     * OneToOne (inverse side)
     * Set TcmgoCombustivelVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\CombustivelVinculo $fkTcmgoCombustivelVinculo
     * @return Item
     */
    public function setFkTcmgoCombustivelVinculo(\Urbem\CoreBundle\Entity\Tcmgo\CombustivelVinculo $fkTcmgoCombustivelVinculo)
    {
        $fkTcmgoCombustivelVinculo->setFkFrotaItem($this);
        $this->fkTcmgoCombustivelVinculo = $fkTcmgoCombustivelVinculo;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcmgoCombustivelVinculo
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\CombustivelVinculo
     */
    public function getFkTcmgoCombustivelVinculo()
    {
        return $this->fkTcmgoCombustivelVinculo;
    }

    /**
     * OneToOne (owning side)
     * Set AlmoxarifadoCatalogoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem
     * @return Item
     */
    public function setFkAlmoxarifadoCatalogoItem(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem)
    {
        $this->codItem = $fkAlmoxarifadoCatalogoItem->getCodItem();
        $this->fkAlmoxarifadoCatalogoItem = $fkAlmoxarifadoCatalogoItem;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkAlmoxarifadoCatalogoItem
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem
     */
    public function getFkAlmoxarifadoCatalogoItem()
    {
        return $this->fkAlmoxarifadoCatalogoItem;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (is_null($this->fkAlmoxarifadoCatalogoItem)) {
            return (string) "Item de Manutenção";
        } else {
            return (string) $this->fkAlmoxarifadoCatalogoItem;
        }
    }
}
