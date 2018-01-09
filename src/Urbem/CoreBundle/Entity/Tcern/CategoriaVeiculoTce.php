<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

/**
 * CategoriaVeiculoTce
 */
class CategoriaVeiculoTce
{
    /**
     * PK
     * @var integer
     */
    private $codCategoria;

    /**
     * @var string
     */
    private $nomCategoria;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\VeiculoCategoriaVinculo
     */
    private $fkTcernVeiculoCategoriaVinculos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcernVeiculoCategoriaVinculos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCategoria
     *
     * @param integer $codCategoria
     * @return CategoriaVeiculoTce
     */
    public function setCodCategoria($codCategoria)
    {
        $this->codCategoria = $codCategoria;
        return $this;
    }

    /**
     * Get codCategoria
     *
     * @return integer
     */
    public function getCodCategoria()
    {
        return $this->codCategoria;
    }

    /**
     * Set nomCategoria
     *
     * @param string $nomCategoria
     * @return CategoriaVeiculoTce
     */
    public function setNomCategoria($nomCategoria = null)
    {
        $this->nomCategoria = $nomCategoria;
        return $this;
    }

    /**
     * Get nomCategoria
     *
     * @return string
     */
    public function getNomCategoria()
    {
        return $this->nomCategoria;
    }

    /**
     * OneToMany (owning side)
     * Add TcernVeiculoCategoriaVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\VeiculoCategoriaVinculo $fkTcernVeiculoCategoriaVinculo
     * @return CategoriaVeiculoTce
     */
    public function addFkTcernVeiculoCategoriaVinculos(\Urbem\CoreBundle\Entity\Tcern\VeiculoCategoriaVinculo $fkTcernVeiculoCategoriaVinculo)
    {
        if (false === $this->fkTcernVeiculoCategoriaVinculos->contains($fkTcernVeiculoCategoriaVinculo)) {
            $fkTcernVeiculoCategoriaVinculo->setFkTcernCategoriaVeiculoTce($this);
            $this->fkTcernVeiculoCategoriaVinculos->add($fkTcernVeiculoCategoriaVinculo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernVeiculoCategoriaVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\VeiculoCategoriaVinculo $fkTcernVeiculoCategoriaVinculo
     */
    public function removeFkTcernVeiculoCategoriaVinculos(\Urbem\CoreBundle\Entity\Tcern\VeiculoCategoriaVinculo $fkTcernVeiculoCategoriaVinculo)
    {
        $this->fkTcernVeiculoCategoriaVinculos->removeElement($fkTcernVeiculoCategoriaVinculo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernVeiculoCategoriaVinculos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\VeiculoCategoriaVinculo
     */
    public function getFkTcernVeiculoCategoriaVinculos()
    {
        return $this->fkTcernVeiculoCategoriaVinculos;
    }
}
