<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * Poder
 */
class Poder
{
    /**
     * PK
     * @var integer
     */
    private $codPoder;

    /**
     * @var string
     */
    private $nomPoder;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoOrgaoUnidade
     */
    private $fkTcmgoConfiguracaoOrgaoUnidades;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmgoConfiguracaoOrgaoUnidades = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPoder
     *
     * @param integer $codPoder
     * @return Poder
     */
    public function setCodPoder($codPoder)
    {
        $this->codPoder = $codPoder;
        return $this;
    }

    /**
     * Get codPoder
     *
     * @return integer
     */
    public function getCodPoder()
    {
        return $this->codPoder;
    }

    /**
     * Set nomPoder
     *
     * @param string $nomPoder
     * @return Poder
     */
    public function setNomPoder($nomPoder)
    {
        $this->nomPoder = $nomPoder;
        return $this;
    }

    /**
     * Get nomPoder
     *
     * @return string
     */
    public function getNomPoder()
    {
        return $this->nomPoder;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoConfiguracaoOrgaoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoOrgaoUnidade $fkTcmgoConfiguracaoOrgaoUnidade
     * @return Poder
     */
    public function addFkTcmgoConfiguracaoOrgaoUnidades(\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoOrgaoUnidade $fkTcmgoConfiguracaoOrgaoUnidade)
    {
        if (false === $this->fkTcmgoConfiguracaoOrgaoUnidades->contains($fkTcmgoConfiguracaoOrgaoUnidade)) {
            $fkTcmgoConfiguracaoOrgaoUnidade->setFkTcmgoPoder($this);
            $this->fkTcmgoConfiguracaoOrgaoUnidades->add($fkTcmgoConfiguracaoOrgaoUnidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoConfiguracaoOrgaoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoOrgaoUnidade $fkTcmgoConfiguracaoOrgaoUnidade
     */
    public function removeFkTcmgoConfiguracaoOrgaoUnidades(\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoOrgaoUnidade $fkTcmgoConfiguracaoOrgaoUnidade)
    {
        $this->fkTcmgoConfiguracaoOrgaoUnidades->removeElement($fkTcmgoConfiguracaoOrgaoUnidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoConfiguracaoOrgaoUnidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoOrgaoUnidade
     */
    public function getFkTcmgoConfiguracaoOrgaoUnidades()
    {
        return $this->fkTcmgoConfiguracaoOrgaoUnidades;
    }
}
