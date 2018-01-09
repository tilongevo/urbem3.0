<?php

namespace Urbem\CoreBundle\Entity;

/**
 * SwLogradouro
 */
class SwLogradouro
{
    /**
     * PK
     *
     * @var integer
     */
    private $codLogradouro;

    /**
     * @var integer
     */
    private $codUf;

    /**
     * @var integer
     */
    private $codMunicipio;

    /**
     * OneToMany
     *
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\DomicilioInformado
     */
    private $fkEconomicoDomicilioInformados;

    /**
     * OneToMany
     *
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\UsoSoloLogradouro
     */
    private $fkEconomicoUsoSoloLogradouros;

    /**
     * OneToMany
     *
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ImovelCorrespondencia
     */
    private $fkImobiliarioImovelCorrespondencias;

    /**
     * OneToMany
     *
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Trecho
     */
    private $fkImobiliarioTrechos;

    /**
     * OneToMany
     *
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\Local
     */
    private $fkOrganogramaLocais;

    /**
     * OneToMany
     *
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwBairroLogradouro
     */
    private $fkSwBairroLogradouros;

    /**
     * OneToMany
     *
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCepLogradouro
     */
    private $fkSwCepLogradouros;

    /**
     * OneToMany
     *
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwNomeLogradouro
     */
    private $fkSwNomeLogradouros;

    /**
     * ManyToOne
     *
     * @var \Urbem\CoreBundle\Entity\SwMunicipio
     */
    private $fkSwMunicipio;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoDomicilioInformados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoUsoSoloLogradouros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioImovelCorrespondencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioTrechos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrganogramaLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwBairroLogradouros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCepLogradouros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwNomeLogradouros = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codLogradouro
     *
     * @param integer $codLogradouro
     *
     * @return SwLogradouro
     */
    public function setCodLogradouro($codLogradouro)
    {
        $this->codLogradouro = $codLogradouro;

        return $this;
    }

    /**
     * Get codLogradouro
     *
     * @return integer
     */
    public function getCodLogradouro()
    {
        return $this->codLogradouro;
    }

    /**
     * Set codUf
     *
     * @param integer $codUf
     *
     * @return SwLogradouro
     */
    public function setCodUf($codUf)
    {
        $this->codUf = $codUf;

        return $this;
    }

    /**
     * Get codUf
     *
     * @return integer
     */
    public function getCodUf()
    {
        return $this->codUf;
    }

    /**
     * Set codMunicipio
     *
     * @param integer $codMunicipio
     *
     * @return SwLogradouro
     */
    public function setCodMunicipio($codMunicipio)
    {
        $this->codMunicipio = $codMunicipio;

        return $this;
    }

    /**
     * Get codMunicipio
     *
     * @return integer
     */
    public function getCodMunicipio()
    {
        return $this->codMunicipio;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoDomicilioInformado
     *
     * @param \Urbem\CoreBundle\Entity\Economico\DomicilioInformado $fkEconomicoDomicilioInformado
     *
     * @return SwLogradouro
     */
    public function addFkEconomicoDomicilioInformados(\Urbem\CoreBundle\Entity\Economico\DomicilioInformado $fkEconomicoDomicilioInformado)
    {
        if (false === $this->fkEconomicoDomicilioInformados->contains($fkEconomicoDomicilioInformado)) {
            $fkEconomicoDomicilioInformado->setFkSwLogradouro($this);
            $this->fkEconomicoDomicilioInformados->add($fkEconomicoDomicilioInformado);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoDomicilioInformado
     *
     * @param \Urbem\CoreBundle\Entity\Economico\DomicilioInformado $fkEconomicoDomicilioInformado
     */
    public function removeFkEconomicoDomicilioInformados(\Urbem\CoreBundle\Entity\Economico\DomicilioInformado $fkEconomicoDomicilioInformado)
    {
        $this->fkEconomicoDomicilioInformados->removeElement($fkEconomicoDomicilioInformado);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoDomicilioInformados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\DomicilioInformado
     */
    public function getFkEconomicoDomicilioInformados()
    {
        return $this->fkEconomicoDomicilioInformados;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoUsoSoloLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\Economico\UsoSoloLogradouro $fkEconomicoUsoSoloLogradouro
     *
     * @return SwLogradouro
     */
    public function addFkEconomicoUsoSoloLogradouros(\Urbem\CoreBundle\Entity\Economico\UsoSoloLogradouro $fkEconomicoUsoSoloLogradouro)
    {
        if (false === $this->fkEconomicoUsoSoloLogradouros->contains($fkEconomicoUsoSoloLogradouro)) {
            $fkEconomicoUsoSoloLogradouro->setFkSwLogradouro($this);
            $this->fkEconomicoUsoSoloLogradouros->add($fkEconomicoUsoSoloLogradouro);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoUsoSoloLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\Economico\UsoSoloLogradouro $fkEconomicoUsoSoloLogradouro
     */
    public function removeFkEconomicoUsoSoloLogradouros(\Urbem\CoreBundle\Entity\Economico\UsoSoloLogradouro $fkEconomicoUsoSoloLogradouro)
    {
        $this->fkEconomicoUsoSoloLogradouros->removeElement($fkEconomicoUsoSoloLogradouro);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoUsoSoloLogradouros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\UsoSoloLogradouro
     */
    public function getFkEconomicoUsoSoloLogradouros()
    {
        return $this->fkEconomicoUsoSoloLogradouros;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioImovelCorrespondencia
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ImovelCorrespondencia $fkImobiliarioImovelCorrespondencia
     *
     * @return SwLogradouro
     */
    public function addFkImobiliarioImovelCorrespondencias(\Urbem\CoreBundle\Entity\Imobiliario\ImovelCorrespondencia $fkImobiliarioImovelCorrespondencia)
    {
        if (false === $this->fkImobiliarioImovelCorrespondencias->contains($fkImobiliarioImovelCorrespondencia)) {
            $fkImobiliarioImovelCorrespondencia->setFkSwLogradouro($this);
            $this->fkImobiliarioImovelCorrespondencias->add($fkImobiliarioImovelCorrespondencia);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioImovelCorrespondencia
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ImovelCorrespondencia $fkImobiliarioImovelCorrespondencia
     */
    public function removeFkImobiliarioImovelCorrespondencias(\Urbem\CoreBundle\Entity\Imobiliario\ImovelCorrespondencia $fkImobiliarioImovelCorrespondencia)
    {
        $this->fkImobiliarioImovelCorrespondencias->removeElement($fkImobiliarioImovelCorrespondencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioImovelCorrespondencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ImovelCorrespondencia
     */
    public function getFkImobiliarioImovelCorrespondencias()
    {
        return $this->fkImobiliarioImovelCorrespondencias;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioTrecho
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Trecho $fkImobiliarioTrecho
     *
     * @return SwLogradouro
     */
    public function addFkImobiliarioTrechos(\Urbem\CoreBundle\Entity\Imobiliario\Trecho $fkImobiliarioTrecho)
    {
        if (false === $this->fkImobiliarioTrechos->contains($fkImobiliarioTrecho)) {
            $fkImobiliarioTrecho->setFkSwLogradouro($this);
            $this->fkImobiliarioTrechos->add($fkImobiliarioTrecho);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioTrecho
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Trecho $fkImobiliarioTrecho
     */
    public function removeFkImobiliarioTrechos(\Urbem\CoreBundle\Entity\Imobiliario\Trecho $fkImobiliarioTrecho)
    {
        $this->fkImobiliarioTrechos->removeElement($fkImobiliarioTrecho);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioTrechos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Trecho
     */
    public function getFkImobiliarioTrechos()
    {
        return $this->fkImobiliarioTrechos;
    }

    /**
     * OneToMany (owning side)
     * Add OrganogramaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal
     *
     * @return SwLogradouro
     */
    public function addFkOrganogramaLocais(\Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal)
    {
        if (false === $this->fkOrganogramaLocais->contains($fkOrganogramaLocal)) {
            $fkOrganogramaLocal->setFkSwLogradouro($this);
            $this->fkOrganogramaLocais->add($fkOrganogramaLocal);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrganogramaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal
     */
    public function removeFkOrganogramaLocais(\Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal)
    {
        $this->fkOrganogramaLocais->removeElement($fkOrganogramaLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrganogramaLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\Local
     */
    public function getFkOrganogramaLocais()
    {
        return $this->fkOrganogramaLocais;
    }

    /**
     * OneToMany (owning side)
     * Add SwBairroLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwBairroLogradouro $fkSwBairroLogradouro
     *
     * @return SwLogradouro
     */
    public function addFkSwBairroLogradouros(\Urbem\CoreBundle\Entity\SwBairroLogradouro $fkSwBairroLogradouro)
    {
        if (false === $this->fkSwBairroLogradouros->contains($fkSwBairroLogradouro)) {
            $fkSwBairroLogradouro->setFkSwLogradouro($this);
            $this->fkSwBairroLogradouros->add($fkSwBairroLogradouro);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwBairroLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwBairroLogradouro $fkSwBairroLogradouro
     */
    public function removeFkSwBairroLogradouros(\Urbem\CoreBundle\Entity\SwBairroLogradouro $fkSwBairroLogradouro)
    {
        $this->fkSwBairroLogradouros->removeElement($fkSwBairroLogradouro);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwBairroLogradouros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwBairroLogradouro
     */
    public function getFkSwBairroLogradouros()
    {
        return $this->fkSwBairroLogradouros;
    }

    /**
     * OneToMany (owning side)
     * Set fkSwBairroLogradouros
     *
     * @param \Doctrine\Common\Collections\Collection|SwBairroLogradouro $fkSwBairroLogradouros
     */
    public function setFkSwBairroLogradouros($fkSwBairroLogradouros)
    {
        $this->fkSwBairroLogradouros = $fkSwBairroLogradouros;
    }

    /**
     * OneToMany (owning side)
     * Add SwCepLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwCepLogradouro $fkSwCepLogradouro
     *
     * @return SwLogradouro
     */
    public function addFkSwCepLogradouros(\Urbem\CoreBundle\Entity\SwCepLogradouro $fkSwCepLogradouro)
    {
        if (false === $this->fkSwCepLogradouros->contains($fkSwCepLogradouro)) {
            $fkSwCepLogradouro->setFkSwLogradouro($this);
            $this->fkSwCepLogradouros->add($fkSwCepLogradouro);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCepLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwCepLogradouro $fkSwCepLogradouro
     */
    public function removeFkSwCepLogradouros(\Urbem\CoreBundle\Entity\SwCepLogradouro $fkSwCepLogradouro)
    {
        $this->fkSwCepLogradouros->removeElement($fkSwCepLogradouro);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCepLogradouros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCepLogradouro
     */
    public function getFkSwCepLogradouros()
    {
        return $this->fkSwCepLogradouros;
    }

    /**
     * OneToMany (owning side)
     * Set fkSwCepLogradouros
     *
     * @param \Doctrine\Common\Collections\Collection|SwCepLogradouro $fkSwCepLogradouros
     */
    public function setFkSwCepLogradouros($fkSwCepLogradouros)
    {
        $this->fkSwCepLogradouros = $fkSwCepLogradouros;
    }

    /**
     * OneToMany (owning side)
     * Add SwNomeLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwNomeLogradouro $fkSwNomeLogradouro
     *
     * @return SwLogradouro
     */
    public function addFkSwNomeLogradouros(\Urbem\CoreBundle\Entity\SwNomeLogradouro $fkSwNomeLogradouro)
    {
        if (false === $this->fkSwNomeLogradouros->contains($fkSwNomeLogradouro)) {
            $fkSwNomeLogradouro->setFkSwLogradouro($this);
            $this->fkSwNomeLogradouros->add($fkSwNomeLogradouro);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwNomeLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwNomeLogradouro $fkSwNomeLogradouro
     */
    public function removeFkSwNomeLogradouros(\Urbem\CoreBundle\Entity\SwNomeLogradouro $fkSwNomeLogradouro)
    {
        $this->fkSwNomeLogradouros->removeElement($fkSwNomeLogradouro);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwNomeLogradouros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwNomeLogradouro
     */
    public function getFkSwNomeLogradouros()
    {
        return $this->fkSwNomeLogradouros;
    }

    /**
     * @return \Urbem\CoreBundle\Entity\SwNomeLogradouro|null
     */
    public function getCurrentFkSwNomeLogradouro()
    {
        $collectionFkSwNomeLogradouros = $this->getFkSwNomeLogradouros();
        if ($collectionFkSwNomeLogradouros->isEmpty()) {
            return null;
        }

        return $collectionFkSwNomeLogradouros->last();
    }

    /**
     * @param SwNomeLogradouro $swNomeLogradouro
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFkSwNomeLogradourosInHistorico(\Urbem\CoreBundle\Entity\SwNomeLogradouro $swNomeLogradouro)
    {
        return $this->getFkSwNomeLogradouros()->filter(
            function (\Urbem\CoreBundle\Entity\SwNomeLogradouro $swNomeLogradouroInCollection) use ($swNomeLogradouro) {
                return $swNomeLogradouro !== $swNomeLogradouroInCollection;
            }
        );
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwMunicipio
     *
     * @param \Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio
     *
     * @return SwLogradouro
     */
    public function setFkSwMunicipio(\Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio)
    {
        $this->codMunicipio = $fkSwMunicipio->getCodMunicipio();
        $this->codUf = $fkSwMunicipio->getCodUf();
        $this->fkSwMunicipio = $fkSwMunicipio;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwMunicipio
     *
     * @return \Urbem\CoreBundle\Entity\SwMunicipio
     */
    public function getFkSwMunicipio()
    {
        return $this->fkSwMunicipio;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getCurrentFkSwNomeLogradouro();
    }
}
