<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * Escola
 */
class Escola
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * @var boolean
     */
    private $ativo = true;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\TransporteEscolar
     */
    private $fkFrotaTransporteEscolares;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFrotaTransporteEscolares = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Escola
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return Escola
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaTransporteEscolar
     *
     * @param \Urbem\CoreBundle\Entity\Frota\TransporteEscolar $fkFrotaTransporteEscolar
     * @return Escola
     */
    public function addFkFrotaTransporteEscolares(\Urbem\CoreBundle\Entity\Frota\TransporteEscolar $fkFrotaTransporteEscolar)
    {
        if (false === $this->fkFrotaTransporteEscolares->contains($fkFrotaTransporteEscolar)) {
            $fkFrotaTransporteEscolar->setFkFrotaEscola($this);
            $this->fkFrotaTransporteEscolares->add($fkFrotaTransporteEscolar);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaTransporteEscolar
     *
     * @param \Urbem\CoreBundle\Entity\Frota\TransporteEscolar $fkFrotaTransporteEscolar
     */
    public function removeFkFrotaTransporteEscolares(\Urbem\CoreBundle\Entity\Frota\TransporteEscolar $fkFrotaTransporteEscolar)
    {
        $this->fkFrotaTransporteEscolares->removeElement($fkFrotaTransporteEscolar);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaTransporteEscolares
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\TransporteEscolar
     */
    public function getFkFrotaTransporteEscolares()
    {
        return $this->fkFrotaTransporteEscolares;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection|TransporteEscolar $fkFrotaTransporteEscolares
     */
    public function setFkFrotaTransporteEscolares($fkFrotaTransporteEscolares)
    {
        $this->fkFrotaTransporteEscolares = $fkFrotaTransporteEscolares;
    }

    /**
     * OneToOne (owning side)
     * Set SwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Escola
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkSwCgm;
    }
}
