<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * Modelo
 */
class Modelo
{
    /**
     * PK
     * @var integer
     */
    private $codModelo;

    /**
     * PK
     * @var integer
     */
    private $codMarca;

    /**
     * @var string
     */
    private $nomModelo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    private $fkFrotaVeiculos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Marca
     */
    private $fkFrotaMarca;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFrotaVeiculos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codModelo
     *
     * @param integer $codModelo
     * @return Modelo
     */
    public function setCodModelo($codModelo)
    {
        $this->codModelo = $codModelo;
        return $this;
    }

    /**
     * Get codModelo
     *
     * @return integer
     */
    public function getCodModelo()
    {
        return $this->codModelo;
    }

    /**
     * Set codMarca
     *
     * @param integer $codMarca
     * @return Modelo
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
     * Set nomModelo
     *
     * @param string $nomModelo
     * @return Modelo
     */
    public function setNomModelo($nomModelo)
    {
        $this->nomModelo = $nomModelo;
        return $this;
    }

    /**
     * Get nomModelo
     *
     * @return string
     */
    public function getNomModelo()
    {
        return $this->nomModelo;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo
     * @return Modelo
     */
    public function addFkFrotaVeiculos(\Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo)
    {
        if (false === $this->fkFrotaVeiculos->contains($fkFrotaVeiculo)) {
            $fkFrotaVeiculo->setFkFrotaModelo($this);
            $this->fkFrotaVeiculos->add($fkFrotaVeiculo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo
     */
    public function removeFkFrotaVeiculos(\Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo)
    {
        $this->fkFrotaVeiculos->removeElement($fkFrotaVeiculo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaVeiculos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    public function getFkFrotaVeiculos()
    {
        return $this->fkFrotaVeiculos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaMarca
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Marca $fkFrotaMarca
     * @return Modelo
     */
    public function setFkFrotaMarca(\Urbem\CoreBundle\Entity\Frota\Marca $fkFrotaMarca)
    {
        $this->codMarca = $fkFrotaMarca->getCodMarca();
        $this->fkFrotaMarca = $fkFrotaMarca;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaMarca
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Marca
     */
    public function getFkFrotaMarca()
    {
        return $this->fkFrotaMarca;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->codModelo.' - '.$this->nomModelo;
    }
}
