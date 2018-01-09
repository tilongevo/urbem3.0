<?php

namespace Urbem\CoreBundle\Entity\Economico;

/**
 * ElementoTipoLicencaDiversa
 */
class ElementoTipoLicencaDiversa
{
    /**
     * PK
     * @var integer
     */
    private $codElemento;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var boolean
     */
    private $ativo = true;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ElementoLicencaDiversa
     */
    private $fkEconomicoElementoLicencaDiversas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Elemento
     */
    private $fkEconomicoElemento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\TipoLicencaDiversa
     */
    private $fkEconomicoTipoLicencaDiversa;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoElementoLicencaDiversas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codElemento
     *
     * @param integer $codElemento
     * @return ElementoTipoLicencaDiversa
     */
    public function setCodElemento($codElemento)
    {
        $this->codElemento = $codElemento;
        return $this;
    }

    /**
     * Get codElemento
     *
     * @return integer
     */
    public function getCodElemento()
    {
        return $this->codElemento;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ElementoTipoLicencaDiversa
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
     * Set ativo
     *
     * @param boolean $ativo
     * @return ElementoTipoLicencaDiversa
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoElementoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ElementoLicencaDiversa $fkEconomicoElementoLicencaDiversa
     * @return ElementoTipoLicencaDiversa
     */
    public function addFkEconomicoElementoLicencaDiversas(\Urbem\CoreBundle\Entity\Economico\ElementoLicencaDiversa $fkEconomicoElementoLicencaDiversa)
    {
        if (false === $this->fkEconomicoElementoLicencaDiversas->contains($fkEconomicoElementoLicencaDiversa)) {
            $fkEconomicoElementoLicencaDiversa->setFkEconomicoElementoTipoLicencaDiversa($this);
            $this->fkEconomicoElementoLicencaDiversas->add($fkEconomicoElementoLicencaDiversa);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoElementoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ElementoLicencaDiversa $fkEconomicoElementoLicencaDiversa
     */
    public function removeFkEconomicoElementoLicencaDiversas(\Urbem\CoreBundle\Entity\Economico\ElementoLicencaDiversa $fkEconomicoElementoLicencaDiversa)
    {
        $this->fkEconomicoElementoLicencaDiversas->removeElement($fkEconomicoElementoLicencaDiversa);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoElementoLicencaDiversas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ElementoLicencaDiversa
     */
    public function getFkEconomicoElementoLicencaDiversas()
    {
        return $this->fkEconomicoElementoLicencaDiversas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoElemento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Elemento $fkEconomicoElemento
     * @return ElementoTipoLicencaDiversa
     */
    public function setFkEconomicoElemento(\Urbem\CoreBundle\Entity\Economico\Elemento $fkEconomicoElemento)
    {
        $this->codElemento = $fkEconomicoElemento->getCodElemento();
        $this->fkEconomicoElemento = $fkEconomicoElemento;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoElemento
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Elemento
     */
    public function getFkEconomicoElemento()
    {
        return $this->fkEconomicoElemento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoTipoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\TipoLicencaDiversa $fkEconomicoTipoLicencaDiversa
     * @return ElementoTipoLicencaDiversa
     */
    public function setFkEconomicoTipoLicencaDiversa(\Urbem\CoreBundle\Entity\Economico\TipoLicencaDiversa $fkEconomicoTipoLicencaDiversa)
    {
        $this->codTipo = $fkEconomicoTipoLicencaDiversa->getCodTipo();
        $this->fkEconomicoTipoLicencaDiversa = $fkEconomicoTipoLicencaDiversa;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoTipoLicencaDiversa
     *
     * @return \Urbem\CoreBundle\Entity\Economico\TipoLicencaDiversa
     */
    public function getFkEconomicoTipoLicencaDiversa()
    {
        return $this->fkEconomicoTipoLicencaDiversa;
    }
}
