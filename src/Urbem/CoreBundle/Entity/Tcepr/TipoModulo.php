<?php
 
namespace Urbem\CoreBundle\Entity\Tcepr;

/**
 * TipoModulo
 */
class TipoModulo 
{
    /**
     * PK
     * @var integer
     */
    private $idTipoModulo;

    /**
     * @var string
     */
    private $dsTipoModulo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepr\ResponsavelModulo
     */
    private $fkTceprResponsavelModulos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTceprResponsavelModulos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set idTipoModulo
     *
     * @param integer $idTipoModulo
     * @return TipoModulo
     */
    public function setIdTipoModulo($idTipoModulo)
    {
        $this->idTipoModulo = $idTipoModulo;
        return $this;
    }

    /**
     * Get idTipoModulo
     *
     * @return integer
     */
    public function getIdTipoModulo()
    {
        return $this->idTipoModulo;
    }

    /**
     * Set dsTipoModulo
     *
     * @param string $dsTipoModulo
     * @return TipoModulo
     */
    public function setDsTipoModulo($dsTipoModulo = null)
    {
        $this->dsTipoModulo = $dsTipoModulo;
        return $this;
    }

    /**
     * Get dsTipoModulo
     *
     * @return string
     */
    public function getDsTipoModulo()
    {
        return $this->dsTipoModulo;
    }

    /**
     * OneToMany (owning side)
     * Add TceprResponsavelModulo
     *
     * @param \Urbem\CoreBundle\Entity\Tcepr\ResponsavelModulo $fkTceprResponsavelModulo
     * @return TipoModulo
     */
    public function addFkTceprResponsavelModulos(\Urbem\CoreBundle\Entity\Tcepr\ResponsavelModulo $fkTceprResponsavelModulo)
    {
        if (false === $this->fkTceprResponsavelModulos->contains($fkTceprResponsavelModulo)) {
            $fkTceprResponsavelModulo->setFkTceprTipoModulo($this);
            $this->fkTceprResponsavelModulos->add($fkTceprResponsavelModulo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TceprResponsavelModulo
     *
     * @param \Urbem\CoreBundle\Entity\Tcepr\ResponsavelModulo $fkTceprResponsavelModulo
     */
    public function removeFkTceprResponsavelModulos(\Urbem\CoreBundle\Entity\Tcepr\ResponsavelModulo $fkTceprResponsavelModulo)
    {
        $this->fkTceprResponsavelModulos->removeElement($fkTceprResponsavelModulo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTceprResponsavelModulos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepr\ResponsavelModulo
     */
    public function getFkTceprResponsavelModulos()
    {
        return $this->fkTceprResponsavelModulos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->idTipoModulo, $this->dsTipoModulo);
    }
}
