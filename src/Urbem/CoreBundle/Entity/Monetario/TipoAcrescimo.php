<?php
 
namespace Urbem\CoreBundle\Entity\Monetario;

/**
 * TipoAcrescimo
 */
class TipoAcrescimo
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $nomTipo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\Acrescimo
     */
    private $fkMonetarioAcrescimos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkMonetarioAcrescimos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoAcrescimo
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
     * Set nomTipo
     *
     * @param string $nomTipo
     * @return TipoAcrescimo
     */
    public function setNomTipo($nomTipo = null)
    {
        $this->nomTipo = $nomTipo;
        return $this;
    }

    /**
     * Get nomTipo
     *
     * @return string
     */
    public function getNomTipo()
    {
        return $this->nomTipo;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Acrescimo $fkMonetarioAcrescimo
     * @return TipoAcrescimo
     */
    public function addFkMonetarioAcrescimos(\Urbem\CoreBundle\Entity\Monetario\Acrescimo $fkMonetarioAcrescimo)
    {
        if (false === $this->fkMonetarioAcrescimos->contains($fkMonetarioAcrescimo)) {
            $fkMonetarioAcrescimo->setFkMonetarioTipoAcrescimo($this);
            $this->fkMonetarioAcrescimos->add($fkMonetarioAcrescimo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Acrescimo $fkMonetarioAcrescimo
     */
    public function removeFkMonetarioAcrescimos(\Urbem\CoreBundle\Entity\Monetario\Acrescimo $fkMonetarioAcrescimo)
    {
        $this->fkMonetarioAcrescimos->removeElement($fkMonetarioAcrescimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioAcrescimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\Acrescimo
     */
    public function getFkMonetarioAcrescimos()
    {
        return $this->fkMonetarioAcrescimos;
    }
}
