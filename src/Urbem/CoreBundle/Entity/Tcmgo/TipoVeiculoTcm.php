<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * TipoVeiculoTcm
 */
class TipoVeiculoTcm
{
    /**
     * PK
     * @var integer
     */
    private $codTipoTcm;

    /**
     * @var string
     */
    private $nomTipoTcm;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\SubtipoVeiculoTcm
     */
    private $fkTcmgoSubtipoVeiculoTcns;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\TipoVeiculoVinculo
     */
    private $fkTcmgoTipoVeiculoVinculos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmgoSubtipoVeiculoTcns = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoTipoVeiculoVinculos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoTcm
     *
     * @param integer $codTipoTcm
     * @return TipoVeiculoTcm
     */
    public function setCodTipoTcm($codTipoTcm)
    {
        $this->codTipoTcm = $codTipoTcm;
        return $this;
    }

    /**
     * Get codTipoTcm
     *
     * @return integer
     */
    public function getCodTipoTcm()
    {
        return $this->codTipoTcm;
    }

    /**
     * Set nomTipoTcm
     *
     * @param string $nomTipoTcm
     * @return TipoVeiculoTcm
     */
    public function setNomTipoTcm($nomTipoTcm)
    {
        $this->nomTipoTcm = $nomTipoTcm;
        return $this;
    }

    /**
     * Get nomTipoTcm
     *
     * @return string
     */
    public function getNomTipoTcm()
    {
        return $this->nomTipoTcm;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoSubtipoVeiculoTcm
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\SubtipoVeiculoTcm $fkTcmgoSubtipoVeiculoTcm
     * @return TipoVeiculoTcm
     */
    public function addFkTcmgoSubtipoVeiculoTcns(\Urbem\CoreBundle\Entity\Tcmgo\SubtipoVeiculoTcm $fkTcmgoSubtipoVeiculoTcm)
    {
        if (false === $this->fkTcmgoSubtipoVeiculoTcns->contains($fkTcmgoSubtipoVeiculoTcm)) {
            $fkTcmgoSubtipoVeiculoTcm->setFkTcmgoTipoVeiculoTcm($this);
            $this->fkTcmgoSubtipoVeiculoTcns->add($fkTcmgoSubtipoVeiculoTcm);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoSubtipoVeiculoTcm
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\SubtipoVeiculoTcm $fkTcmgoSubtipoVeiculoTcm
     */
    public function removeFkTcmgoSubtipoVeiculoTcns(\Urbem\CoreBundle\Entity\Tcmgo\SubtipoVeiculoTcm $fkTcmgoSubtipoVeiculoTcm)
    {
        $this->fkTcmgoSubtipoVeiculoTcns->removeElement($fkTcmgoSubtipoVeiculoTcm);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoSubtipoVeiculoTcns
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\SubtipoVeiculoTcm
     */
    public function getFkTcmgoSubtipoVeiculoTcns()
    {
        return $this->fkTcmgoSubtipoVeiculoTcns;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoTipoVeiculoVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\TipoVeiculoVinculo $fkTcmgoTipoVeiculoVinculo
     * @return TipoVeiculoTcm
     */
    public function addFkTcmgoTipoVeiculoVinculos(\Urbem\CoreBundle\Entity\Tcmgo\TipoVeiculoVinculo $fkTcmgoTipoVeiculoVinculo)
    {
        if (false === $this->fkTcmgoTipoVeiculoVinculos->contains($fkTcmgoTipoVeiculoVinculo)) {
            $fkTcmgoTipoVeiculoVinculo->setFkTcmgoTipoVeiculoTcm($this);
            $this->fkTcmgoTipoVeiculoVinculos->add($fkTcmgoTipoVeiculoVinculo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoTipoVeiculoVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\TipoVeiculoVinculo $fkTcmgoTipoVeiculoVinculo
     */
    public function removeFkTcmgoTipoVeiculoVinculos(\Urbem\CoreBundle\Entity\Tcmgo\TipoVeiculoVinculo $fkTcmgoTipoVeiculoVinculo)
    {
        $this->fkTcmgoTipoVeiculoVinculos->removeElement($fkTcmgoTipoVeiculoVinculo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoTipoVeiculoVinculos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\TipoVeiculoVinculo
     */
    public function getFkTcmgoTipoVeiculoVinculos()
    {
        return $this->fkTcmgoTipoVeiculoVinculos;
    }
}
