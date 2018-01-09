<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * SubtipoVeiculoTcm
 */
class SubtipoVeiculoTcm
{
    /**
     * PK
     * @var integer
     */
    private $codTipoTcm;

    /**
     * PK
     * @var integer
     */
    private $codSubtipoTcm;

    /**
     * @var string
     */
    private $nomSubtipoTcm;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\TipoVeiculoVinculo
     */
    private $fkTcmgoTipoVeiculoVinculos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\TipoVeiculoTcm
     */
    private $fkTcmgoTipoVeiculoTcm;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmgoTipoVeiculoVinculos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoTcm
     *
     * @param integer $codTipoTcm
     * @return SubtipoVeiculoTcm
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
     * Set codSubtipoTcm
     *
     * @param integer $codSubtipoTcm
     * @return SubtipoVeiculoTcm
     */
    public function setCodSubtipoTcm($codSubtipoTcm)
    {
        $this->codSubtipoTcm = $codSubtipoTcm;
        return $this;
    }

    /**
     * Get codSubtipoTcm
     *
     * @return integer
     */
    public function getCodSubtipoTcm()
    {
        return $this->codSubtipoTcm;
    }

    /**
     * Set nomSubtipoTcm
     *
     * @param string $nomSubtipoTcm
     * @return SubtipoVeiculoTcm
     */
    public function setNomSubtipoTcm($nomSubtipoTcm = null)
    {
        $this->nomSubtipoTcm = $nomSubtipoTcm;
        return $this;
    }

    /**
     * Get nomSubtipoTcm
     *
     * @return string
     */
    public function getNomSubtipoTcm()
    {
        return $this->nomSubtipoTcm;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoTipoVeiculoVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\TipoVeiculoVinculo $fkTcmgoTipoVeiculoVinculo
     * @return SubtipoVeiculoTcm
     */
    public function addFkTcmgoTipoVeiculoVinculos(\Urbem\CoreBundle\Entity\Tcmgo\TipoVeiculoVinculo $fkTcmgoTipoVeiculoVinculo)
    {
        if (false === $this->fkTcmgoTipoVeiculoVinculos->contains($fkTcmgoTipoVeiculoVinculo)) {
            $fkTcmgoTipoVeiculoVinculo->setFkTcmgoSubtipoVeiculoTcm($this);
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

    /**
     * ManyToOne (inverse side)
     * Set fkTcmgoTipoVeiculoTcm
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\TipoVeiculoTcm $fkTcmgoTipoVeiculoTcm
     * @return SubtipoVeiculoTcm
     */
    public function setFkTcmgoTipoVeiculoTcm(\Urbem\CoreBundle\Entity\Tcmgo\TipoVeiculoTcm $fkTcmgoTipoVeiculoTcm)
    {
        $this->codTipoTcm = $fkTcmgoTipoVeiculoTcm->getCodTipoTcm();
        $this->fkTcmgoTipoVeiculoTcm = $fkTcmgoTipoVeiculoTcm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoTipoVeiculoTcm
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\TipoVeiculoTcm
     */
    public function getFkTcmgoTipoVeiculoTcm()
    {
        return $this->fkTcmgoTipoVeiculoTcm;
    }
}
