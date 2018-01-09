<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * TipoVeiculoTce
 */
class TipoVeiculoTce
{
    /**
     * PK
     * @var integer
     */
    private $codTipoTce;

    /**
     * @var string
     */
    private $nomTipoTce;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\TipoVeiculoVinculo
     */
    private $fkTcemgTipoVeiculoVinculos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\SubtipoVeiculoTce
     */
    private $fkTcemgSubtipoVeiculoTces;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcemgTipoVeiculoVinculos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgSubtipoVeiculoTces = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoTce
     *
     * @param integer $codTipoTce
     * @return TipoVeiculoTce
     */
    public function setCodTipoTce($codTipoTce)
    {
        $this->codTipoTce = $codTipoTce;
        return $this;
    }

    /**
     * Get codTipoTce
     *
     * @return integer
     */
    public function getCodTipoTce()
    {
        return $this->codTipoTce;
    }

    /**
     * Set nomTipoTce
     *
     * @param string $nomTipoTce
     * @return TipoVeiculoTce
     */
    public function setNomTipoTce($nomTipoTce)
    {
        $this->nomTipoTce = $nomTipoTce;
        return $this;
    }

    /**
     * Get nomTipoTce
     *
     * @return string
     */
    public function getNomTipoTce()
    {
        return $this->nomTipoTce;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgTipoVeiculoVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TipoVeiculoVinculo $fkTcemgTipoVeiculoVinculo
     * @return TipoVeiculoTce
     */
    public function addFkTcemgTipoVeiculoVinculos(\Urbem\CoreBundle\Entity\Tcemg\TipoVeiculoVinculo $fkTcemgTipoVeiculoVinculo)
    {
        if (false === $this->fkTcemgTipoVeiculoVinculos->contains($fkTcemgTipoVeiculoVinculo)) {
            $fkTcemgTipoVeiculoVinculo->setFkTcemgTipoVeiculoTce($this);
            $this->fkTcemgTipoVeiculoVinculos->add($fkTcemgTipoVeiculoVinculo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgTipoVeiculoVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TipoVeiculoVinculo $fkTcemgTipoVeiculoVinculo
     */
    public function removeFkTcemgTipoVeiculoVinculos(\Urbem\CoreBundle\Entity\Tcemg\TipoVeiculoVinculo $fkTcemgTipoVeiculoVinculo)
    {
        $this->fkTcemgTipoVeiculoVinculos->removeElement($fkTcemgTipoVeiculoVinculo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgTipoVeiculoVinculos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\TipoVeiculoVinculo
     */
    public function getFkTcemgTipoVeiculoVinculos()
    {
        return $this->fkTcemgTipoVeiculoVinculos;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgSubtipoVeiculoTce
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\SubtipoVeiculoTce $fkTcemgSubtipoVeiculoTce
     * @return TipoVeiculoTce
     */
    public function addFkTcemgSubtipoVeiculoTces(\Urbem\CoreBundle\Entity\Tcemg\SubtipoVeiculoTce $fkTcemgSubtipoVeiculoTce)
    {
        if (false === $this->fkTcemgSubtipoVeiculoTces->contains($fkTcemgSubtipoVeiculoTce)) {
            $fkTcemgSubtipoVeiculoTce->setFkTcemgTipoVeiculoTce($this);
            $this->fkTcemgSubtipoVeiculoTces->add($fkTcemgSubtipoVeiculoTce);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgSubtipoVeiculoTce
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\SubtipoVeiculoTce $fkTcemgSubtipoVeiculoTce
     */
    public function removeFkTcemgSubtipoVeiculoTces(\Urbem\CoreBundle\Entity\Tcemg\SubtipoVeiculoTce $fkTcemgSubtipoVeiculoTce)
    {
        $this->fkTcemgSubtipoVeiculoTces->removeElement($fkTcemgSubtipoVeiculoTce);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgSubtipoVeiculoTces
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\SubtipoVeiculoTce
     */
    public function getFkTcemgSubtipoVeiculoTces()
    {
        return $this->fkTcemgSubtipoVeiculoTces;
    }
}
