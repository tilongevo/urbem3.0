<?php

namespace Urbem\CoreBundle\Entity\Monetario;

/**
 * NaturezaCredito
 */
class NaturezaCredito
{
    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * @var string
     */
    private $nomNatureza;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\GeneroCredito
     */
    private $fkMonetarioGeneroCreditos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkMonetarioGeneroCreditos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return NaturezaCredito
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set nomNatureza
     *
     * @param string $nomNatureza
     * @return NaturezaCredito
     */
    public function setNomNatureza($nomNatureza)
    {
        $this->nomNatureza = $nomNatureza;
        return $this;
    }

    /**
     * Get nomNatureza
     *
     * @return string
     */
    public function getNomNatureza()
    {
        return $this->nomNatureza;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioGeneroCredito
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\GeneroCredito $fkMonetarioGeneroCredito
     * @return NaturezaCredito
     */
    public function addFkMonetarioGeneroCreditos(\Urbem\CoreBundle\Entity\Monetario\GeneroCredito $fkMonetarioGeneroCredito)
    {
        if (false === $this->fkMonetarioGeneroCreditos->contains($fkMonetarioGeneroCredito)) {
            $fkMonetarioGeneroCredito->setFkMonetarioNaturezaCredito($this);
            $this->fkMonetarioGeneroCreditos->add($fkMonetarioGeneroCredito);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioGeneroCredito
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\GeneroCredito $fkMonetarioGeneroCredito
     */
    public function removeFkMonetarioGeneroCreditos(\Urbem\CoreBundle\Entity\Monetario\GeneroCredito $fkMonetarioGeneroCredito)
    {
        $this->fkMonetarioGeneroCreditos->removeElement($fkMonetarioGeneroCredito);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioGeneroCreditos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\GeneroCredito
     */
    public function getFkMonetarioGeneroCreditos()
    {
        return $this->fkMonetarioGeneroCreditos;
    }

    /**
    *
    * @return string
    */
    public function __toString()
    {
        return (string) $this->nomNatureza;
    }
}
