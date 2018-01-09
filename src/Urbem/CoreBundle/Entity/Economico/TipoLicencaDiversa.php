<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * TipoLicencaDiversa
 */
class TipoLicencaDiversa
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $nomTipo;

    /**
     * @var integer
     */
    private $codUtilizacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoTipoLicencaDiversa
     */
    private $fkEconomicoAtributoTipoLicencaDiversas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ElementoTipoLicencaDiversa
     */
    private $fkEconomicoElementoTipoLicencaDiversas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\LicencaDiversa
     */
    private $fkEconomicoLicencaDiversas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\TipoLicencaModeloDocumento
     */
    private $fkEconomicoTipoLicencaModeloDocumentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Utilizacao
     */
    private $fkEconomicoUtilizacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoAtributoTipoLicencaDiversas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoElementoTipoLicencaDiversas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoLicencaDiversas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoTipoLicencaModeloDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoLicencaDiversa
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set nomTipo
     *
     * @param string $nomTipo
     * @return TipoLicencaDiversa
     */
    public function setNomTipo($nomTipo)
    {
        $this->nomTipo = $nomTipo;
        return $this;
    }

    /**
     * Get nomTipo
     *
     * @return string
     */
    public function getNomTipo()
    {
        return $this->nomTipo;
    }

    /**
     * Set codUtilizacao
     *
     * @param integer $codUtilizacao
     * @return TipoLicencaDiversa
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
     * OneToMany (owning side)
     * Add EconomicoAtributoTipoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoTipoLicencaDiversa $fkEconomicoAtributoTipoLicencaDiversa
     * @return TipoLicencaDiversa
     */
    public function addFkEconomicoAtributoTipoLicencaDiversas(\Urbem\CoreBundle\Entity\Economico\AtributoTipoLicencaDiversa $fkEconomicoAtributoTipoLicencaDiversa)
    {
        if (false === $this->fkEconomicoAtributoTipoLicencaDiversas->contains($fkEconomicoAtributoTipoLicencaDiversa)) {
            $fkEconomicoAtributoTipoLicencaDiversa->setFkEconomicoTipoLicencaDiversa($this);
            $this->fkEconomicoAtributoTipoLicencaDiversas->add($fkEconomicoAtributoTipoLicencaDiversa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtributoTipoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoTipoLicencaDiversa $fkEconomicoAtributoTipoLicencaDiversa
     */
    public function removeFkEconomicoAtributoTipoLicencaDiversas(\Urbem\CoreBundle\Entity\Economico\AtributoTipoLicencaDiversa $fkEconomicoAtributoTipoLicencaDiversa)
    {
        $this->fkEconomicoAtributoTipoLicencaDiversas->removeElement($fkEconomicoAtributoTipoLicencaDiversa);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtributoTipoLicencaDiversas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoTipoLicencaDiversa
     */
    public function getFkEconomicoAtributoTipoLicencaDiversas()
    {
        return $this->fkEconomicoAtributoTipoLicencaDiversas;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoElementoTipoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ElementoTipoLicencaDiversa $fkEconomicoElementoTipoLicencaDiversa
     * @return TipoLicencaDiversa
     */
    public function addFkEconomicoElementoTipoLicencaDiversas(\Urbem\CoreBundle\Entity\Economico\ElementoTipoLicencaDiversa $fkEconomicoElementoTipoLicencaDiversa)
    {
        if (false === $this->fkEconomicoElementoTipoLicencaDiversas->contains($fkEconomicoElementoTipoLicencaDiversa)) {
            $fkEconomicoElementoTipoLicencaDiversa->setFkEconomicoTipoLicencaDiversa($this);
            $this->fkEconomicoElementoTipoLicencaDiversas->add($fkEconomicoElementoTipoLicencaDiversa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoElementoTipoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ElementoTipoLicencaDiversa $fkEconomicoElementoTipoLicencaDiversa
     */
    public function removeFkEconomicoElementoTipoLicencaDiversas(\Urbem\CoreBundle\Entity\Economico\ElementoTipoLicencaDiversa $fkEconomicoElementoTipoLicencaDiversa)
    {
        $this->fkEconomicoElementoTipoLicencaDiversas->removeElement($fkEconomicoElementoTipoLicencaDiversa);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoElementoTipoLicencaDiversas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ElementoTipoLicencaDiversa
     */
    public function getFkEconomicoElementoTipoLicencaDiversas()
    {
        return $this->fkEconomicoElementoTipoLicencaDiversas;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaDiversa $fkEconomicoLicencaDiversa
     * @return TipoLicencaDiversa
     */
    public function addFkEconomicoLicencaDiversas(\Urbem\CoreBundle\Entity\Economico\LicencaDiversa $fkEconomicoLicencaDiversa)
    {
        if (false === $this->fkEconomicoLicencaDiversas->contains($fkEconomicoLicencaDiversa)) {
            $fkEconomicoLicencaDiversa->setFkEconomicoTipoLicencaDiversa($this);
            $this->fkEconomicoLicencaDiversas->add($fkEconomicoLicencaDiversa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaDiversa $fkEconomicoLicencaDiversa
     */
    public function removeFkEconomicoLicencaDiversas(\Urbem\CoreBundle\Entity\Economico\LicencaDiversa $fkEconomicoLicencaDiversa)
    {
        $this->fkEconomicoLicencaDiversas->removeElement($fkEconomicoLicencaDiversa);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoLicencaDiversas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\LicencaDiversa
     */
    public function getFkEconomicoLicencaDiversas()
    {
        return $this->fkEconomicoLicencaDiversas;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoTipoLicencaModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\TipoLicencaModeloDocumento $fkEconomicoTipoLicencaModeloDocumento
     * @return TipoLicencaDiversa
     */
    public function addFkEconomicoTipoLicencaModeloDocumentos(\Urbem\CoreBundle\Entity\Economico\TipoLicencaModeloDocumento $fkEconomicoTipoLicencaModeloDocumento)
    {
        if (false === $this->fkEconomicoTipoLicencaModeloDocumentos->contains($fkEconomicoTipoLicencaModeloDocumento)) {
            $fkEconomicoTipoLicencaModeloDocumento->setFkEconomicoTipoLicencaDiversa($this);
            $this->fkEconomicoTipoLicencaModeloDocumentos->add($fkEconomicoTipoLicencaModeloDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoTipoLicencaModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\TipoLicencaModeloDocumento $fkEconomicoTipoLicencaModeloDocumento
     */
    public function removeFkEconomicoTipoLicencaModeloDocumentos(\Urbem\CoreBundle\Entity\Economico\TipoLicencaModeloDocumento $fkEconomicoTipoLicencaModeloDocumento)
    {
        $this->fkEconomicoTipoLicencaModeloDocumentos->removeElement($fkEconomicoTipoLicencaModeloDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoTipoLicencaModeloDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\TipoLicencaModeloDocumento
     */
    public function getFkEconomicoTipoLicencaModeloDocumentos()
    {
        return $this->fkEconomicoTipoLicencaModeloDocumentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoUtilizacao
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Utilizacao $fkEconomicoUtilizacao
     * @return TipoLicencaDiversa
     */
    public function setFkEconomicoUtilizacao(\Urbem\CoreBundle\Entity\Economico\Utilizacao $fkEconomicoUtilizacao)
    {
        $this->codUtilizacao = $fkEconomicoUtilizacao->getCodUtilizacao();
        $this->fkEconomicoUtilizacao = $fkEconomicoUtilizacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoUtilizacao
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Utilizacao
     */
    public function getFkEconomicoUtilizacao()
    {
        return $this->fkEconomicoUtilizacao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->getCodTipo(), $this->getNomTipo());
    }
}
