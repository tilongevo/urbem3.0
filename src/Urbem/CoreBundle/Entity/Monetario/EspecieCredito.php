<?php

namespace Urbem\CoreBundle\Entity\Monetario;

/**
 * EspecieCredito
 */
class EspecieCredito
{
    /**
     * PK
     * @var integer
     */
    private $codEspecie;

    /**
     * PK
     * @var integer
     */
    private $codGenero;

    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * @var string
     */
    private $nomEspecie;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\Credito
     */
    private $fkMonetarioCreditos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\GeneroCredito
     */
    private $fkMonetarioGeneroCredito;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkMonetarioCreditos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codEspecie
     *
     * @param integer $codEspecie
     * @return EspecieCredito
     */
    public function setCodEspecie($codEspecie)
    {
        $this->codEspecie = $codEspecie;
        return $this;
    }

    /**
     * Get codEspecie
     *
     * @return integer
     */
    public function getCodEspecie()
    {
        return $this->codEspecie;
    }

    /**
     * Set codGenero
     *
     * @param integer $codGenero
     * @return EspecieCredito
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
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return EspecieCredito
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
     * Set nomEspecie
     *
     * @param string $nomEspecie
     * @return EspecieCredito
     */
    public function setNomEspecie($nomEspecie)
    {
        $this->nomEspecie = $nomEspecie;
        return $this;
    }

    /**
     * Get nomEspecie
     *
     * @return string
     */
    public function getNomEspecie()
    {
        return $this->nomEspecie;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioCredito
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Credito $fkMonetarioCredito
     * @return EspecieCredito
     */
    public function addFkMonetarioCreditos(\Urbem\CoreBundle\Entity\Monetario\Credito $fkMonetarioCredito)
    {
        if (false === $this->fkMonetarioCreditos->contains($fkMonetarioCredito)) {
            $fkMonetarioCredito->setFkMonetarioEspecieCredito($this);
            $this->fkMonetarioCreditos->add($fkMonetarioCredito);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioCredito
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Credito $fkMonetarioCredito
     */
    public function removeFkMonetarioCreditos(\Urbem\CoreBundle\Entity\Monetario\Credito $fkMonetarioCredito)
    {
        $this->fkMonetarioCreditos->removeElement($fkMonetarioCredito);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioCreditos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\Credito
     */
    public function getFkMonetarioCreditos()
    {
        return $this->fkMonetarioCreditos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioGeneroCredito
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\GeneroCredito $fkMonetarioGeneroCredito
     * @return EspecieCredito
     */
    public function setFkMonetarioGeneroCredito(\Urbem\CoreBundle\Entity\Monetario\GeneroCredito $fkMonetarioGeneroCredito)
    {
        $this->codNatureza = $fkMonetarioGeneroCredito->getCodNatureza();
        $this->codGenero = $fkMonetarioGeneroCredito->getCodGenero();
        $this->fkMonetarioGeneroCredito = $fkMonetarioGeneroCredito;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioGeneroCredito
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\GeneroCredito
     */
    public function getFkMonetarioGeneroCredito()
    {
        return $this->fkMonetarioGeneroCredito;
    }

    /**
    * @return string
    */
    public function __toString()
    {
        return (string) $this->nomEspecie;
    }
}
