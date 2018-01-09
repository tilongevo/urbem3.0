<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * Elemento
 */
class Elemento
{
    /**
     * PK
     * @var integer
     */
    private $codElemento;

    /**
     * @var string
     */
    private $nomElemento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoElemento
     */
    private $fkEconomicoAtributoElementos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ElementoAtividade
     */
    private $fkEconomicoElementoAtividades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ElementoTipoLicencaDiversa
     */
    private $fkEconomicoElementoTipoLicencaDiversas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoAtributoElementos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoElementoAtividades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoElementoTipoLicencaDiversas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codElemento
     *
     * @param integer $codElemento
     * @return Elemento
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
     * Set nomElemento
     *
     * @param string $nomElemento
     * @return Elemento
     */
    public function setNomElemento($nomElemento)
    {
        $this->nomElemento = $nomElemento;
        return $this;
    }

    /**
     * Get nomElemento
     *
     * @return string
     */
    public function getNomElemento()
    {
        return $this->nomElemento;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoAtributoElemento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoElemento $fkEconomicoAtributoElemento
     * @return Elemento
     */
    public function addFkEconomicoAtributoElementos(\Urbem\CoreBundle\Entity\Economico\AtributoElemento $fkEconomicoAtributoElemento)
    {
        if (false === $this->fkEconomicoAtributoElementos->contains($fkEconomicoAtributoElemento)) {
            $fkEconomicoAtributoElemento->setFkEconomicoElemento($this);
            $this->fkEconomicoAtributoElementos->add($fkEconomicoAtributoElemento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtributoElemento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoElemento $fkEconomicoAtributoElemento
     */
    public function removeFkEconomicoAtributoElementos(\Urbem\CoreBundle\Entity\Economico\AtributoElemento $fkEconomicoAtributoElemento)
    {
        $this->fkEconomicoAtributoElementos->removeElement($fkEconomicoAtributoElemento);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtributoElementos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoElemento
     */
    public function getFkEconomicoAtributoElementos()
    {
        return $this->fkEconomicoAtributoElementos;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoElementoAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ElementoAtividade $fkEconomicoElementoAtividade
     * @return Elemento
     */
    public function addFkEconomicoElementoAtividades(\Urbem\CoreBundle\Entity\Economico\ElementoAtividade $fkEconomicoElementoAtividade)
    {
        if (false === $this->fkEconomicoElementoAtividades->contains($fkEconomicoElementoAtividade)) {
            $fkEconomicoElementoAtividade->setFkEconomicoElemento($this);
            $this->fkEconomicoElementoAtividades->add($fkEconomicoElementoAtividade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoElementoAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ElementoAtividade $fkEconomicoElementoAtividade
     */
    public function removeFkEconomicoElementoAtividades(\Urbem\CoreBundle\Entity\Economico\ElementoAtividade $fkEconomicoElementoAtividade)
    {
        $this->fkEconomicoElementoAtividades->removeElement($fkEconomicoElementoAtividade);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoElementoAtividades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ElementoAtividade
     */
    public function getFkEconomicoElementoAtividades()
    {
        return $this->fkEconomicoElementoAtividades;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoElementoTipoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ElementoTipoLicencaDiversa $fkEconomicoElementoTipoLicencaDiversa
     * @return Elemento
     */
    public function addFkEconomicoElementoTipoLicencaDiversas(\Urbem\CoreBundle\Entity\Economico\ElementoTipoLicencaDiversa $fkEconomicoElementoTipoLicencaDiversa)
    {
        if (false === $this->fkEconomicoElementoTipoLicencaDiversas->contains($fkEconomicoElementoTipoLicencaDiversa)) {
            $fkEconomicoElementoTipoLicencaDiversa->setFkEconomicoElemento($this);
            $this->fkEconomicoElementoTipoLicencaDiversas->add($fkEconomicoElementoTipoLicencaDiversa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoElementoTipoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ElementoTipoLicencaDiversa $fkEconomicoElementoTipoLicencaDiversa
     */
    public function removeFkEconomicoElementoTipoLicencaDiversas(\Urbem\CoreBundle\Entity\Economico\ElementoTipoLicencaDiversa $fkEconomicoElementoTipoLicencaDiversa)
    {
        $this->fkEconomicoElementoTipoLicencaDiversas->removeElement($fkEconomicoElementoTipoLicencaDiversa);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoElementoTipoLicencaDiversas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ElementoTipoLicencaDiversa
     */
    public function getFkEconomicoElementoTipoLicencaDiversas()
    {
        return $this->fkEconomicoElementoTipoLicencaDiversas;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) ($this->nomElemento ? $this->nomElemento : $this->codElemento);
    }
}
