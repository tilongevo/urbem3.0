<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\TipoVeiculoVinculo
     */
    private $fkTcernTipoVeiculoVinculos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcernTipoVeiculoVinculos = new \Doctrine\Common\Collections\ArrayCollection();
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
    public function setNomTipoTce($nomTipoTce = null)
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
     * Add TcernTipoVeiculoVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\TipoVeiculoVinculo $fkTcernTipoVeiculoVinculo
     * @return TipoVeiculoTce
     */
    public function addFkTcernTipoVeiculoVinculos(\Urbem\CoreBundle\Entity\Tcern\TipoVeiculoVinculo $fkTcernTipoVeiculoVinculo)
    {
        if (false === $this->fkTcernTipoVeiculoVinculos->contains($fkTcernTipoVeiculoVinculo)) {
            $fkTcernTipoVeiculoVinculo->setFkTcernTipoVeiculoTce($this);
            $this->fkTcernTipoVeiculoVinculos->add($fkTcernTipoVeiculoVinculo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernTipoVeiculoVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\TipoVeiculoVinculo $fkTcernTipoVeiculoVinculo
     */
    public function removeFkTcernTipoVeiculoVinculos(\Urbem\CoreBundle\Entity\Tcern\TipoVeiculoVinculo $fkTcernTipoVeiculoVinculo)
    {
        $this->fkTcernTipoVeiculoVinculos->removeElement($fkTcernTipoVeiculoVinculo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernTipoVeiculoVinculos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\TipoVeiculoVinculo
     */
    public function getFkTcernTipoVeiculoVinculos()
    {
        return $this->fkTcernTipoVeiculoVinculos;
    }
}
