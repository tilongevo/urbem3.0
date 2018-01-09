<?php
 
namespace Urbem\CoreBundle\Entity\Tcepr;

/**
 * TipoResponsavelModulo
 */
class TipoResponsavelModulo 
{
    /**
     * PK
     * @var integer
     */
    private $idTipoResponsavelModulo;

    /**
     * @var string
     */
    private $dsTipoResponsavelModulo;

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
     * Set idTipoResponsavelModulo
     *
     * @param integer $idTipoResponsavelModulo
     * @return TipoResponsavelModulo
     */
    public function setIdTipoResponsavelModulo($idTipoResponsavelModulo)
    {
        $this->idTipoResponsavelModulo = $idTipoResponsavelModulo;
        return $this;
    }

    /**
     * Get idTipoResponsavelModulo
     *
     * @return integer
     */
    public function getIdTipoResponsavelModulo()
    {
        return $this->idTipoResponsavelModulo;
    }

    /**
     * Set dsTipoResponsavelModulo
     *
     * @param string $dsTipoResponsavelModulo
     * @return TipoResponsavelModulo
     */
    public function setDsTipoResponsavelModulo($dsTipoResponsavelModulo = null)
    {
        $this->dsTipoResponsavelModulo = $dsTipoResponsavelModulo;
        return $this;
    }

    /**
     * Get dsTipoResponsavelModulo
     *
     * @return string
     */
    public function getDsTipoResponsavelModulo()
    {
        return $this->dsTipoResponsavelModulo;
    }

    /**
     * OneToMany (owning side)
     * Add TceprResponsavelModulo
     *
     * @param \Urbem\CoreBundle\Entity\Tcepr\ResponsavelModulo $fkTceprResponsavelModulo
     * @return TipoResponsavelModulo
     */
    public function addFkTceprResponsavelModulos(\Urbem\CoreBundle\Entity\Tcepr\ResponsavelModulo $fkTceprResponsavelModulo)
    {
        if (false === $this->fkTceprResponsavelModulos->contains($fkTceprResponsavelModulo)) {
            $fkTceprResponsavelModulo->setFkTceprTipoResponsavelModulo($this);
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
        return sprintf('%s - %s', $this->idTipoResponsavelModulo, $this->dsTipoResponsavelModulo);
    }
}
