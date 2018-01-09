<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * Marca
 */
class Marca
{
    /**
     * PK
     * @var integer
     */
    private $codMarca;

    /**
     * @var string
     */
    private $nomMarca;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Modelo
     */
    private $fkFrotaModelos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFrotaModelos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codMarca
     *
     * @param integer $codMarca
     * @return Marca
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
     * Set nomMarca
     *
     * @param string $nomMarca
     * @return Marca
     */
    public function setNomMarca($nomMarca)
    {
        $this->nomMarca = $nomMarca;
        return $this;
    }

    /**
     * Get nomMarca
     *
     * @return string
     */
    public function getNomMarca()
    {
        return $this->nomMarca;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaModelo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Modelo $fkFrotaModelo
     * @return Marca
     */
    public function addFkFrotaModelos(\Urbem\CoreBundle\Entity\Frota\Modelo $fkFrotaModelo)
    {
        if (false === $this->fkFrotaModelos->contains($fkFrotaModelo)) {
            $fkFrotaModelo->setFkFrotaMarca($this);
            $this->fkFrotaModelos->add($fkFrotaModelo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaModelo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Modelo $fkFrotaModelo
     */
    public function removeFkFrotaModelos(\Urbem\CoreBundle\Entity\Frota\Modelo $fkFrotaModelo)
    {
        $this->fkFrotaModelos->removeElement($fkFrotaModelo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaModelos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Modelo
     */
    public function getFkFrotaModelos()
    {
        return $this->fkFrotaModelos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->codMarca.' - '.$this->nomMarca;
    }
}
