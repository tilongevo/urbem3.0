<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * Utilizacao
 */
class Utilizacao
{
    /**
     * PK
     * @var integer
     */
    private $codUtilizacao;

    /**
     * @var string
     */
    private $nomUtilizacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\TipoLicencaDiversa
     */
    private $fkEconomicoTipoLicencaDiversas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoTipoLicencaDiversas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codUtilizacao
     *
     * @param integer $codUtilizacao
     * @return Utilizacao
     */
    public function setCodUtilizacao($codUtilizacao)
    {
        $this->codUtilizacao = $codUtilizacao;
        return $this;
    }

    /**
     * Get codUtilizacao
     *
     * @return integer
     */
    public function getCodUtilizacao()
    {
        return $this->codUtilizacao;
    }

    /**
     * Set nomUtilizacao
     *
     * @param string $nomUtilizacao
     * @return Utilizacao
     */
    public function setNomUtilizacao($nomUtilizacao)
    {
        $this->nomUtilizacao = $nomUtilizacao;
        return $this;
    }

    /**
     * Get nomUtilizacao
     *
     * @return string
     */
    public function getNomUtilizacao()
    {
        return $this->nomUtilizacao;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoTipoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\TipoLicencaDiversa $fkEconomicoTipoLicencaDiversa
     * @return Utilizacao
     */
    public function addFkEconomicoTipoLicencaDiversas(\Urbem\CoreBundle\Entity\Economico\TipoLicencaDiversa $fkEconomicoTipoLicencaDiversa)
    {
        if (false === $this->fkEconomicoTipoLicencaDiversas->contains($fkEconomicoTipoLicencaDiversa)) {
            $fkEconomicoTipoLicencaDiversa->setFkEconomicoUtilizacao($this);
            $this->fkEconomicoTipoLicencaDiversas->add($fkEconomicoTipoLicencaDiversa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoTipoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\TipoLicencaDiversa $fkEconomicoTipoLicencaDiversa
     */
    public function removeFkEconomicoTipoLicencaDiversas(\Urbem\CoreBundle\Entity\Economico\TipoLicencaDiversa $fkEconomicoTipoLicencaDiversa)
    {
        $this->fkEconomicoTipoLicencaDiversas->removeElement($fkEconomicoTipoLicencaDiversa);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoTipoLicencaDiversas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\TipoLicencaDiversa
     */
    public function getFkEconomicoTipoLicencaDiversas()
    {
        return $this->fkEconomicoTipoLicencaDiversas;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->getCodUtilizacao(), $this->getNomUtilizacao());
    }
}
