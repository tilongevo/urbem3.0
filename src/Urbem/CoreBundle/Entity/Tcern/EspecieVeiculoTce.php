<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

/**
 * EspecieVeiculoTce
 */
class EspecieVeiculoTce
{
    /**
     * PK
     * @var integer
     */
    private $codEspecieTce;

    /**
     * @var string
     */
    private $nomEspecieTce;

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
     * Set codEspecieTce
     *
     * @param integer $codEspecieTce
     * @return EspecieVeiculoTce
     */
    public function setCodEspecieTce($codEspecieTce)
    {
        $this->codEspecieTce = $codEspecieTce;
        return $this;
    }

    /**
     * Get codEspecieTce
     *
     * @return integer
     */
    public function getCodEspecieTce()
    {
        return $this->codEspecieTce;
    }

    /**
     * Set nomEspecieTce
     *
     * @param string $nomEspecieTce
     * @return EspecieVeiculoTce
     */
    public function setNomEspecieTce($nomEspecieTce)
    {
        $this->nomEspecieTce = $nomEspecieTce;
        return $this;
    }

    /**
     * Get nomEspecieTce
     *
     * @return string
     */
    public function getNomEspecieTce()
    {
        return $this->nomEspecieTce;
    }

    /**
     * OneToMany (owning side)
     * Add TcernTipoVeiculoVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\TipoVeiculoVinculo $fkTcernTipoVeiculoVinculo
     * @return EspecieVeiculoTce
     */
    public function addFkTcernTipoVeiculoVinculos(\Urbem\CoreBundle\Entity\Tcern\TipoVeiculoVinculo $fkTcernTipoVeiculoVinculo)
    {
        if (false === $this->fkTcernTipoVeiculoVinculos->contains($fkTcernTipoVeiculoVinculo)) {
            $fkTcernTipoVeiculoVinculo->setFkTcernEspecieVeiculoTce($this);
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
