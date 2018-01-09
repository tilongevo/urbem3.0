<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * SubtipoVeiculoTce
 */
class SubtipoVeiculoTce
{
    /**
     * PK
     * @var integer
     */
    private $codTipoTce;

    /**
     * PK
     * @var integer
     */
    private $codSubtipoTce;

    /**
     * @var string
     */
    private $nomSubtipoTce;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\TipoVeiculoVinculo
     */
    private $fkTcemgTipoVeiculoVinculos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\TipoVeiculoTce
     */
    private $fkTcemgTipoVeiculoTce;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcemgTipoVeiculoVinculos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoTce
     *
     * @param integer $codTipoTce
     * @return SubtipoVeiculoTce
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
     * Set codSubtipoTce
     *
     * @param integer $codSubtipoTce
     * @return SubtipoVeiculoTce
     */
    public function setCodSubtipoTce($codSubtipoTce)
    {
        $this->codSubtipoTce = $codSubtipoTce;
        return $this;
    }

    /**
     * Get codSubtipoTce
     *
     * @return integer
     */
    public function getCodSubtipoTce()
    {
        return $this->codSubtipoTce;
    }

    /**
     * Set nomSubtipoTce
     *
     * @param string $nomSubtipoTce
     * @return SubtipoVeiculoTce
     */
    public function setNomSubtipoTce($nomSubtipoTce = null)
    {
        $this->nomSubtipoTce = $nomSubtipoTce;
        return $this;
    }

    /**
     * Get nomSubtipoTce
     *
     * @return string
     */
    public function getNomSubtipoTce()
    {
        return $this->nomSubtipoTce;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgTipoVeiculoVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TipoVeiculoVinculo $fkTcemgTipoVeiculoVinculo
     * @return SubtipoVeiculoTce
     */
    public function addFkTcemgTipoVeiculoVinculos(\Urbem\CoreBundle\Entity\Tcemg\TipoVeiculoVinculo $fkTcemgTipoVeiculoVinculo)
    {
        if (false === $this->fkTcemgTipoVeiculoVinculos->contains($fkTcemgTipoVeiculoVinculo)) {
            $fkTcemgTipoVeiculoVinculo->setFkTcemgSubtipoVeiculoTce($this);
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
     * ManyToOne (inverse side)
     * Set fkTcemgTipoVeiculoTce
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TipoVeiculoTce $fkTcemgTipoVeiculoTce
     * @return SubtipoVeiculoTce
     */
    public function setFkTcemgTipoVeiculoTce(\Urbem\CoreBundle\Entity\Tcemg\TipoVeiculoTce $fkTcemgTipoVeiculoTce)
    {
        $this->codTipoTce = $fkTcemgTipoVeiculoTce->getCodTipoTce();
        $this->fkTcemgTipoVeiculoTce = $fkTcemgTipoVeiculoTce;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgTipoVeiculoTce
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\TipoVeiculoTce
     */
    public function getFkTcemgTipoVeiculoTce()
    {
        return $this->fkTcemgTipoVeiculoTce;
    }
}
