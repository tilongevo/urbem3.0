<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * Responsavel
 */
class Responsavel
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var integer
     */
    private $sequencia;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\EmpresaProfissao
     */
    private $fkEconomicoEmpresaProfissoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadastroEconRespContabil
     */
    private $fkEconomicoCadastroEconRespContabiis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadastroEconRespTecnico
     */
    private $fkEconomicoCadastroEconRespTecnicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ResponsavelEmpresa
     */
    private $fkEconomicoResponsavelEmpresas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaResponsavelTecnico
     */
    private $fkImobiliarioLicencaResponsavelTecnicos;

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
        $this->fkEconomicoEmpresaProfissoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoCadastroEconRespContabiis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoCadastroEconRespTecnicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoResponsavelEmpresas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLicencaResponsavelTecnicos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Responsavel
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
     * Set sequencia
     *
     * @param integer $sequencia
     * @return Responsavel
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoEmpresaProfissao
     *
     * @param \Urbem\CoreBundle\Entity\Economico\EmpresaProfissao $fkEconomicoEmpresaProfissao
     * @return Responsavel
     */
    public function addFkEconomicoEmpresaProfissoes(\Urbem\CoreBundle\Entity\Economico\EmpresaProfissao $fkEconomicoEmpresaProfissao)
    {
        if (false === $this->fkEconomicoEmpresaProfissoes->contains($fkEconomicoEmpresaProfissao)) {
            $fkEconomicoEmpresaProfissao->setFkEconomicoResponsavel($this);
            $this->fkEconomicoEmpresaProfissoes->add($fkEconomicoEmpresaProfissao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoEmpresaProfissao
     *
     * @param \Urbem\CoreBundle\Entity\Economico\EmpresaProfissao $fkEconomicoEmpresaProfissao
     */
    public function removeFkEconomicoEmpresaProfissoes(\Urbem\CoreBundle\Entity\Economico\EmpresaProfissao $fkEconomicoEmpresaProfissao)
    {
        $this->fkEconomicoEmpresaProfissoes->removeElement($fkEconomicoEmpresaProfissao);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoEmpresaProfissoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\EmpresaProfissao
     */
    public function getFkEconomicoEmpresaProfissoes()
    {
        return $this->fkEconomicoEmpresaProfissoes;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoCadastroEconRespContabil
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconRespContabil $fkEconomicoCadastroEconRespContabil
     * @return Responsavel
     */
    public function addFkEconomicoCadastroEconRespContabiis(\Urbem\CoreBundle\Entity\Economico\CadastroEconRespContabil $fkEconomicoCadastroEconRespContabil)
    {
        if (false === $this->fkEconomicoCadastroEconRespContabiis->contains($fkEconomicoCadastroEconRespContabil)) {
            $fkEconomicoCadastroEconRespContabil->setFkEconomicoResponsavel($this);
            $this->fkEconomicoCadastroEconRespContabiis->add($fkEconomicoCadastroEconRespContabil);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoCadastroEconRespContabil
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconRespContabil $fkEconomicoCadastroEconRespContabil
     */
    public function removeFkEconomicoCadastroEconRespContabiis(\Urbem\CoreBundle\Entity\Economico\CadastroEconRespContabil $fkEconomicoCadastroEconRespContabil)
    {
        $this->fkEconomicoCadastroEconRespContabiis->removeElement($fkEconomicoCadastroEconRespContabil);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoCadastroEconRespContabiis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadastroEconRespContabil
     */
    public function getFkEconomicoCadastroEconRespContabiis()
    {
        return $this->fkEconomicoCadastroEconRespContabiis;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoCadastroEconRespTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconRespTecnico $fkEconomicoCadastroEconRespTecnico
     * @return Responsavel
     */
    public function addFkEconomicoCadastroEconRespTecnicos(\Urbem\CoreBundle\Entity\Economico\CadastroEconRespTecnico $fkEconomicoCadastroEconRespTecnico)
    {
        if (false === $this->fkEconomicoCadastroEconRespTecnicos->contains($fkEconomicoCadastroEconRespTecnico)) {
            $fkEconomicoCadastroEconRespTecnico->setFkEconomicoResponsavel($this);
            $this->fkEconomicoCadastroEconRespTecnicos->add($fkEconomicoCadastroEconRespTecnico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoCadastroEconRespTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconRespTecnico $fkEconomicoCadastroEconRespTecnico
     */
    public function removeFkEconomicoCadastroEconRespTecnicos(\Urbem\CoreBundle\Entity\Economico\CadastroEconRespTecnico $fkEconomicoCadastroEconRespTecnico)
    {
        $this->fkEconomicoCadastroEconRespTecnicos->removeElement($fkEconomicoCadastroEconRespTecnico);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoCadastroEconRespTecnicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadastroEconRespTecnico
     */
    public function getFkEconomicoCadastroEconRespTecnicos()
    {
        return $this->fkEconomicoCadastroEconRespTecnicos;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoResponsavelEmpresa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ResponsavelEmpresa $fkEconomicoResponsavelEmpresa
     * @return Responsavel
     */
    public function addFkEconomicoResponsavelEmpresas(\Urbem\CoreBundle\Entity\Economico\ResponsavelEmpresa $fkEconomicoResponsavelEmpresa)
    {
        if (false === $this->fkEconomicoResponsavelEmpresas->contains($fkEconomicoResponsavelEmpresa)) {
            $fkEconomicoResponsavelEmpresa->setFkEconomicoResponsavel($this);
            $this->fkEconomicoResponsavelEmpresas->add($fkEconomicoResponsavelEmpresa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoResponsavelEmpresa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ResponsavelEmpresa $fkEconomicoResponsavelEmpresa
     */
    public function removeFkEconomicoResponsavelEmpresas(\Urbem\CoreBundle\Entity\Economico\ResponsavelEmpresa $fkEconomicoResponsavelEmpresa)
    {
        $this->fkEconomicoResponsavelEmpresas->removeElement($fkEconomicoResponsavelEmpresa);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoResponsavelEmpresas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ResponsavelEmpresa
     */
    public function getFkEconomicoResponsavelEmpresas()
    {
        return $this->fkEconomicoResponsavelEmpresas;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLicencaResponsavelTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaResponsavelTecnico $fkImobiliarioLicencaResponsavelTecnico
     * @return Responsavel
     */
    public function addFkImobiliarioLicencaResponsavelTecnicos(\Urbem\CoreBundle\Entity\Imobiliario\LicencaResponsavelTecnico $fkImobiliarioLicencaResponsavelTecnico)
    {
        if (false === $this->fkImobiliarioLicencaResponsavelTecnicos->contains($fkImobiliarioLicencaResponsavelTecnico)) {
            $fkImobiliarioLicencaResponsavelTecnico->setFkEconomicoResponsavel($this);
            $this->fkImobiliarioLicencaResponsavelTecnicos->add($fkImobiliarioLicencaResponsavelTecnico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLicencaResponsavelTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaResponsavelTecnico $fkImobiliarioLicencaResponsavelTecnico
     */
    public function removeFkImobiliarioLicencaResponsavelTecnicos(\Urbem\CoreBundle\Entity\Imobiliario\LicencaResponsavelTecnico $fkImobiliarioLicencaResponsavelTecnico)
    {
        $this->fkImobiliarioLicencaResponsavelTecnicos->removeElement($fkImobiliarioLicencaResponsavelTecnico);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLicencaResponsavelTecnicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaResponsavelTecnico
     */
    public function getFkImobiliarioLicencaResponsavelTecnicos()
    {
        return $this->fkImobiliarioLicencaResponsavelTecnicos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Responsavel
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
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->getNumCgm(), $this->getFkSwCgm()->getNomCgm());
    }
}
