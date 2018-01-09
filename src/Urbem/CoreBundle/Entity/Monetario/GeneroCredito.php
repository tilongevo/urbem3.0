<?php

namespace Urbem\CoreBundle\Entity\Monetario;

/**
 * GeneroCredito
 */
class GeneroCredito
{
    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * PK
     * @var integer
     */
    private $codGenero;

    /**
     * @var string
     */
    private $nomGenero;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\EspecieCredito
     */
    private $fkMonetarioEspecieCreditos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\NaturezaCredito
     */
    private $fkMonetarioNaturezaCredito;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkMonetarioEspecieCreditos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return GeneroCredito
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
     * Set codGenero
     *
     * @param integer $codGenero
     * @return GeneroCredito
     */
    public function setCodGenero($codGenero)
    {
        $this->codGenero = $codGenero;
        return $this;
    }

    /**
     * Get codGenero
     *
     * @return integer
     */
    public function getCodGenero()
    {
        return $this->codGenero;
    }

    /**
     * Set nomGenero
     *
     * @param string $nomGenero
     * @return GeneroCredito
     */
    public function setNomGenero($nomGenero)
    {
        $this->nomGenero = $nomGenero;
        return $this;
    }

    /**
     * Get nomGenero
     *
     * @return string
     */
    public function getNomGenero()
    {
        return $this->nomGenero;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioEspecieCredito
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\EspecieCredito $fkMonetarioEspecieCredito
     * @return GeneroCredito
     */
    public function addFkMonetarioEspecieCreditos(\Urbem\CoreBundle\Entity\Monetario\EspecieCredito $fkMonetarioEspecieCredito)
    {
        if (false === $this->fkMonetarioEspecieCreditos->contains($fkMonetarioEspecieCredito)) {
            $fkMonetarioEspecieCredito->setFkMonetarioGeneroCredito($this);
            $this->fkMonetarioEspecieCreditos->add($fkMonetarioEspecieCredito);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioEspecieCredito
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\EspecieCredito $fkMonetarioEspecieCredito
     */
    public function removeFkMonetarioEspecieCreditos(\Urbem\CoreBundle\Entity\Monetario\EspecieCredito $fkMonetarioEspecieCredito)
    {
        $this->fkMonetarioEspecieCreditos->removeElement($fkMonetarioEspecieCredito);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioEspecieCreditos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\EspecieCredito
     */
    public function getFkMonetarioEspecieCreditos()
    {
        return $this->fkMonetarioEspecieCreditos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioNaturezaCredito
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\NaturezaCredito $fkMonetarioNaturezaCredito
     * @return GeneroCredito
     */
    public function setFkMonetarioNaturezaCredito(\Urbem\CoreBundle\Entity\Monetario\NaturezaCredito $fkMonetarioNaturezaCredito)
    {
        $this->codNatureza = $fkMonetarioNaturezaCredito->getCodNatureza();
        $this->fkMonetarioNaturezaCredito = $fkMonetarioNaturezaCredito;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioNaturezaCredito
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\NaturezaCredito
     */
    public function getFkMonetarioNaturezaCredito()
    {
        return $this->fkMonetarioNaturezaCredito;
    }

    /**
    * @return string
    */
    public function __toString()
    {
        return (string) $this->nomGenero;
    }
}
