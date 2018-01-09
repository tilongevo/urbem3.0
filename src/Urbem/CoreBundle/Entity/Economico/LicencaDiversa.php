<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * LicencaDiversa
 */
class LicencaDiversa
{
    /**
     * PK
     * @var integer
     */
    private $codLicenca;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Economico\UsoSoloArea
     */
    private $fkEconomicoUsoSoloArea;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Economico\UsoSoloEmpresa
     */
    private $fkEconomicoUsoSoloEmpresa;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Economico\UsoSoloImovel
     */
    private $fkEconomicoUsoSoloImovel;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Economico\UsoSoloLogradouro
     */
    private $fkEconomicoUsoSoloLogradouro;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Economico\Licenca
     */
    private $fkEconomicoLicenca;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoLicencaDiversaValor
     */
    private $fkEconomicoAtributoLicencaDiversaValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ElementoLicencaDiversa
     */
    private $fkEconomicoElementoLicencaDiversas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\TipoLicencaDiversa
     */
    private $fkEconomicoTipoLicencaDiversa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoAtributoLicencaDiversaValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoElementoLicencaDiversas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return LicencaDiversa
     */
    public function setCodLicenca($codLicenca)
    {
        $this->codLicenca = $codLicenca;
        return $this;
    }

    /**
     * Get codLicenca
     *
     * @return integer
     */
    public function getCodLicenca()
    {
        return $this->codLicenca;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return LicencaDiversa
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return LicencaDiversa
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return LicencaDiversa
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
     * OneToMany (owning side)
     * Add EconomicoAtributoLicencaDiversaValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoLicencaDiversaValor $fkEconomicoAtributoLicencaDiversaValor
     * @return LicencaDiversa
     */
    public function addFkEconomicoAtributoLicencaDiversaValores(\Urbem\CoreBundle\Entity\Economico\AtributoLicencaDiversaValor $fkEconomicoAtributoLicencaDiversaValor)
    {
        if (false === $this->fkEconomicoAtributoLicencaDiversaValores->contains($fkEconomicoAtributoLicencaDiversaValor)) {
            $fkEconomicoAtributoLicencaDiversaValor->setFkEconomicoLicencaDiversa($this);
            $this->fkEconomicoAtributoLicencaDiversaValores->add($fkEconomicoAtributoLicencaDiversaValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtributoLicencaDiversaValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoLicencaDiversaValor $fkEconomicoAtributoLicencaDiversaValor
     */
    public function removeFkEconomicoAtributoLicencaDiversaValores(\Urbem\CoreBundle\Entity\Economico\AtributoLicencaDiversaValor $fkEconomicoAtributoLicencaDiversaValor)
    {
        $this->fkEconomicoAtributoLicencaDiversaValores->removeElement($fkEconomicoAtributoLicencaDiversaValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtributoLicencaDiversaValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoLicencaDiversaValor
     */
    public function getFkEconomicoAtributoLicencaDiversaValores()
    {
        return $this->fkEconomicoAtributoLicencaDiversaValores;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoElementoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ElementoLicencaDiversa $fkEconomicoElementoLicencaDiversa
     * @return LicencaDiversa
     */
    public function addFkEconomicoElementoLicencaDiversas(\Urbem\CoreBundle\Entity\Economico\ElementoLicencaDiversa $fkEconomicoElementoLicencaDiversa)
    {
        if (false === $this->fkEconomicoElementoLicencaDiversas->contains($fkEconomicoElementoLicencaDiversa)) {
            $fkEconomicoElementoLicencaDiversa->setFkEconomicoLicencaDiversa($this);
            $this->fkEconomicoElementoLicencaDiversas->add($fkEconomicoElementoLicencaDiversa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoElementoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ElementoLicencaDiversa $fkEconomicoElementoLicencaDiversa
     */
    public function removeFkEconomicoElementoLicencaDiversas(\Urbem\CoreBundle\Entity\Economico\ElementoLicencaDiversa $fkEconomicoElementoLicencaDiversa)
    {
        $this->fkEconomicoElementoLicencaDiversas->removeElement($fkEconomicoElementoLicencaDiversa);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoElementoLicencaDiversas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ElementoLicencaDiversa
     */
    public function getFkEconomicoElementoLicencaDiversas()
    {
        return $this->fkEconomicoElementoLicencaDiversas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoTipoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\TipoLicencaDiversa $fkEconomicoTipoLicencaDiversa
     * @return LicencaDiversa
     */
    public function setFkEconomicoTipoLicencaDiversa(\Urbem\CoreBundle\Entity\Economico\TipoLicencaDiversa $fkEconomicoTipoLicencaDiversa)
    {
        $this->codTipo = $fkEconomicoTipoLicencaDiversa->getCodTipo();
        $this->fkEconomicoTipoLicencaDiversa = $fkEconomicoTipoLicencaDiversa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoTipoLicencaDiversa
     *
     * @return \Urbem\CoreBundle\Entity\Economico\TipoLicencaDiversa
     */
    public function getFkEconomicoTipoLicencaDiversa()
    {
        return $this->fkEconomicoTipoLicencaDiversa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return LicencaDiversa
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * OneToOne (inverse side)
     * Set EconomicoUsoSoloArea
     *
     * @param \Urbem\CoreBundle\Entity\Economico\UsoSoloArea $fkEconomicoUsoSoloArea
     * @return LicencaDiversa
     */
    public function setFkEconomicoUsoSoloArea(\Urbem\CoreBundle\Entity\Economico\UsoSoloArea $fkEconomicoUsoSoloArea)
    {
        $fkEconomicoUsoSoloArea->setFkEconomicoLicencaDiversa($this);
        $this->fkEconomicoUsoSoloArea = $fkEconomicoUsoSoloArea;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEconomicoUsoSoloArea
     *
     * @return \Urbem\CoreBundle\Entity\Economico\UsoSoloArea
     */
    public function getFkEconomicoUsoSoloArea()
    {
        return $this->fkEconomicoUsoSoloArea;
    }

    /**
     * OneToOne (inverse side)
     * Set EconomicoUsoSoloEmpresa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\UsoSoloEmpresa $fkEconomicoUsoSoloEmpresa
     * @return LicencaDiversa
     */
    public function setFkEconomicoUsoSoloEmpresa(\Urbem\CoreBundle\Entity\Economico\UsoSoloEmpresa $fkEconomicoUsoSoloEmpresa)
    {
        $fkEconomicoUsoSoloEmpresa->setFkEconomicoLicencaDiversa($this);
        $this->fkEconomicoUsoSoloEmpresa = $fkEconomicoUsoSoloEmpresa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEconomicoUsoSoloEmpresa
     *
     * @return \Urbem\CoreBundle\Entity\Economico\UsoSoloEmpresa
     */
    public function getFkEconomicoUsoSoloEmpresa()
    {
        return $this->fkEconomicoUsoSoloEmpresa;
    }

    /**
     * OneToOne (inverse side)
     * Set EconomicoUsoSoloImovel
     *
     * @param \Urbem\CoreBundle\Entity\Economico\UsoSoloImovel $fkEconomicoUsoSoloImovel
     * @return LicencaDiversa
     */
    public function setFkEconomicoUsoSoloImovel(\Urbem\CoreBundle\Entity\Economico\UsoSoloImovel $fkEconomicoUsoSoloImovel)
    {
        $fkEconomicoUsoSoloImovel->setFkEconomicoLicencaDiversa($this);
        $this->fkEconomicoUsoSoloImovel = $fkEconomicoUsoSoloImovel;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEconomicoUsoSoloImovel
     *
     * @return \Urbem\CoreBundle\Entity\Economico\UsoSoloImovel
     */
    public function getFkEconomicoUsoSoloImovel()
    {
        return $this->fkEconomicoUsoSoloImovel;
    }

    /**
     * OneToOne (inverse side)
     * Set EconomicoUsoSoloLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\Economico\UsoSoloLogradouro $fkEconomicoUsoSoloLogradouro
     * @return LicencaDiversa
     */
    public function setFkEconomicoUsoSoloLogradouro(\Urbem\CoreBundle\Entity\Economico\UsoSoloLogradouro $fkEconomicoUsoSoloLogradouro)
    {
        $fkEconomicoUsoSoloLogradouro->setFkEconomicoLicencaDiversa($this);
        $this->fkEconomicoUsoSoloLogradouro = $fkEconomicoUsoSoloLogradouro;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEconomicoUsoSoloLogradouro
     *
     * @return \Urbem\CoreBundle\Entity\Economico\UsoSoloLogradouro
     */
    public function getFkEconomicoUsoSoloLogradouro()
    {
        return $this->fkEconomicoUsoSoloLogradouro;
    }

    /**
     * OneToOne (owning side)
     * Set EconomicoLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Licenca $fkEconomicoLicenca
     * @return LicencaDiversa
     */
    public function setFkEconomicoLicenca(\Urbem\CoreBundle\Entity\Economico\Licenca $fkEconomicoLicenca)
    {
        $this->codLicenca = $fkEconomicoLicenca->getCodLicenca();
        $this->exercicio = $fkEconomicoLicenca->getExercicio();
        $this->fkEconomicoLicenca = $fkEconomicoLicenca;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEconomicoLicenca
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Licenca
     */
    public function getFkEconomicoLicenca()
    {
        return $this->fkEconomicoLicenca;
    }
}
