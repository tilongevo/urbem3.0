<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * DiasSemana
 */
class DiasSemana
{
    /**
     * PK
     * @var integer
     */
    private $codDia;

    /**
     * @var string
     */
    private $nomDia;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteSemanal
     */
    private $fkBeneficioConcessaoValeTransporteSemanais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\LicencaDiasSemana
     */
    private $fkEconomicoLicencaDiasSemanas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\DiasCadastroEconomico
     */
    private $fkEconomicoDiasCadastroEconomicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais
     */
    private $fkPontoConfiguracaoParametrosGerais;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkBeneficioConcessaoValeTransporteSemanais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoLicencaDiasSemanas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoDiasCadastroEconomicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoConfiguracaoParametrosGerais = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codDia
     *
     * @param integer $codDia
     * @return DiasSemana
     */
    public function setCodDia($codDia)
    {
        $this->codDia = $codDia;
        return $this;
    }

    /**
     * Get codDia
     *
     * @return integer
     */
    public function getCodDia()
    {
        return $this->codDia;
    }

    /**
     * Set nomDia
     *
     * @param string $nomDia
     * @return DiasSemana
     */
    public function setNomDia($nomDia)
    {
        $this->nomDia = $nomDia;
        return $this;
    }

    /**
     * Get nomDia
     *
     * @return string
     */
    public function getNomDia()
    {
        return $this->nomDia;
    }

    /**
     * OneToMany (owning side)
     * Add BeneficioConcessaoValeTransporteSemanal
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteSemanal $fkBeneficioConcessaoValeTransporteSemanal
     * @return DiasSemana
     */
    public function addFkBeneficioConcessaoValeTransporteSemanais(\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteSemanal $fkBeneficioConcessaoValeTransporteSemanal)
    {
        if (false === $this->fkBeneficioConcessaoValeTransporteSemanais->contains($fkBeneficioConcessaoValeTransporteSemanal)) {
            $fkBeneficioConcessaoValeTransporteSemanal->setFkAdministracaoDiasSemana($this);
            $this->fkBeneficioConcessaoValeTransporteSemanais->add($fkBeneficioConcessaoValeTransporteSemanal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioConcessaoValeTransporteSemanal
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteSemanal $fkBeneficioConcessaoValeTransporteSemanal
     */
    public function removeFkBeneficioConcessaoValeTransporteSemanais(\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteSemanal $fkBeneficioConcessaoValeTransporteSemanal)
    {
        $this->fkBeneficioConcessaoValeTransporteSemanais->removeElement($fkBeneficioConcessaoValeTransporteSemanal);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioConcessaoValeTransporteSemanais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteSemanal
     */
    public function getFkBeneficioConcessaoValeTransporteSemanais()
    {
        return $this->fkBeneficioConcessaoValeTransporteSemanais;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoLicencaDiasSemana
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaDiasSemana $fkEconomicoLicencaDiasSemana
     * @return DiasSemana
     */
    public function addFkEconomicoLicencaDiasSemanas(\Urbem\CoreBundle\Entity\Economico\LicencaDiasSemana $fkEconomicoLicencaDiasSemana)
    {
        if (false === $this->fkEconomicoLicencaDiasSemanas->contains($fkEconomicoLicencaDiasSemana)) {
            $fkEconomicoLicencaDiasSemana->setFkAdministracaoDiasSemana($this);
            $this->fkEconomicoLicencaDiasSemanas->add($fkEconomicoLicencaDiasSemana);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoLicencaDiasSemana
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaDiasSemana $fkEconomicoLicencaDiasSemana
     */
    public function removeFkEconomicoLicencaDiasSemanas(\Urbem\CoreBundle\Entity\Economico\LicencaDiasSemana $fkEconomicoLicencaDiasSemana)
    {
        $this->fkEconomicoLicencaDiasSemanas->removeElement($fkEconomicoLicencaDiasSemana);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoLicencaDiasSemanas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\LicencaDiasSemana
     */
    public function getFkEconomicoLicencaDiasSemanas()
    {
        return $this->fkEconomicoLicencaDiasSemanas;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoDiasCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\DiasCadastroEconomico $fkEconomicoDiasCadastroEconomico
     * @return DiasSemana
     */
    public function addFkEconomicoDiasCadastroEconomicos(\Urbem\CoreBundle\Entity\Economico\DiasCadastroEconomico $fkEconomicoDiasCadastroEconomico)
    {
        if (false === $this->fkEconomicoDiasCadastroEconomicos->contains($fkEconomicoDiasCadastroEconomico)) {
            $fkEconomicoDiasCadastroEconomico->setFkAdministracaoDiasSemana($this);
            $this->fkEconomicoDiasCadastroEconomicos->add($fkEconomicoDiasCadastroEconomico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoDiasCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\DiasCadastroEconomico $fkEconomicoDiasCadastroEconomico
     */
    public function removeFkEconomicoDiasCadastroEconomicos(\Urbem\CoreBundle\Entity\Economico\DiasCadastroEconomico $fkEconomicoDiasCadastroEconomico)
    {
        $this->fkEconomicoDiasCadastroEconomicos->removeElement($fkEconomicoDiasCadastroEconomico);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoDiasCadastroEconomicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\DiasCadastroEconomico
     */
    public function getFkEconomicoDiasCadastroEconomicos()
    {
        return $this->fkEconomicoDiasCadastroEconomicos;
    }

    /**
     * OneToMany (owning side)
     * Add PontoConfiguracaoParametrosGerais
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais $fkPontoConfiguracaoParametrosGerais
     * @return DiasSemana
     */
    public function addFkPontoConfiguracaoParametrosGerais(\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais $fkPontoConfiguracaoParametrosGerais)
    {
        if (false === $this->fkPontoConfiguracaoParametrosGerais->contains($fkPontoConfiguracaoParametrosGerais)) {
            $fkPontoConfiguracaoParametrosGerais->setFkAdministracaoDiasSemana($this);
            $this->fkPontoConfiguracaoParametrosGerais->add($fkPontoConfiguracaoParametrosGerais);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoConfiguracaoParametrosGerais
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais $fkPontoConfiguracaoParametrosGerais
     */
    public function removeFkPontoConfiguracaoParametrosGerais(\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais $fkPontoConfiguracaoParametrosGerais)
    {
        $this->fkPontoConfiguracaoParametrosGerais->removeElement($fkPontoConfiguracaoParametrosGerais);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoConfiguracaoParametrosGerais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais
     */
    public function getFkPontoConfiguracaoParametrosGerais()
    {
        return $this->fkPontoConfiguracaoParametrosGerais;
    }
}
