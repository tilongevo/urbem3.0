<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwBairroLogradouro
 */
class SwBairroLogradouro
{
    /**
     * PK
     * @var integer
     */
    private $codUf;

    /**
     * PK
     * @var integer
     */
    private $codMunicipio;

    /**
     * PK
     * @var integer
     */
    private $codBairro;

    /**
     * PK
     * @var integer
     */
    private $codLogradouro;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\DomicilioInformado
     */
    private $fkEconomicoDomicilioInformados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ImovelCorrespondencia
     */
    private $fkImobiliarioImovelCorrespondencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgmLogradouroCorrespondencia
     */
    private $fkSwCgmLogradouroCorrespondencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgaLogradouroCorrespondencia
     */
    private $fkSwCgaLogradouroCorrespondencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgmLogradouro
     */
    private $fkSwCgmLogradouros;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgaLogradouro
     */
    private $fkSwCgaLogradouros;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwBairro
     */
    private $fkSwBairro;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwLogradouro
     */
    private $fkSwLogradouro;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoDomicilioInformados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioImovelCorrespondencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgmLogradouroCorrespondencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgaLogradouroCorrespondencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgmLogradouros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgaLogradouros = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codUf
     *
     * @param integer $codUf
     * @return SwBairroLogradouro
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
     * @return SwBairroLogradouro
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
     * Set codBairro
     *
     * @param integer $codBairro
     * @return SwBairroLogradouro
     */
    public function setCodBairro($codBairro)
    {
        $this->codBairro = $codBairro;
        return $this;
    }

    /**
     * Get codBairro
     *
     * @return integer
     */
    public function getCodBairro()
    {
        return $this->codBairro;
    }

    /**
     * Set codLogradouro
     *
     * @param integer $codLogradouro
     * @return SwBairroLogradouro
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
     * OneToMany (owning side)
     * Add EconomicoDomicilioInformado
     *
     * @param \Urbem\CoreBundle\Entity\Economico\DomicilioInformado $fkEconomicoDomicilioInformado
     * @return SwBairroLogradouro
     */
    public function addFkEconomicoDomicilioInformados(\Urbem\CoreBundle\Entity\Economico\DomicilioInformado $fkEconomicoDomicilioInformado)
    {
        if (false === $this->fkEconomicoDomicilioInformados->contains($fkEconomicoDomicilioInformado)) {
            $fkEconomicoDomicilioInformado->setFkSwBairroLogradouro($this);
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
     * Add ImobiliarioImovelCorrespondencia
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ImovelCorrespondencia $fkImobiliarioImovelCorrespondencia
     * @return SwBairroLogradouro
     */
    public function addFkImobiliarioImovelCorrespondencias(\Urbem\CoreBundle\Entity\Imobiliario\ImovelCorrespondencia $fkImobiliarioImovelCorrespondencia)
    {
        if (false === $this->fkImobiliarioImovelCorrespondencias->contains($fkImobiliarioImovelCorrespondencia)) {
            $fkImobiliarioImovelCorrespondencia->setFkSwBairroLogradouro($this);
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
     * Add SwCgmLogradouroCorrespondencia
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmLogradouroCorrespondencia $fkSwCgmLogradouroCorrespondencia
     * @return SwBairroLogradouro
     */
    public function addFkSwCgmLogradouroCorrespondencias(\Urbem\CoreBundle\Entity\SwCgmLogradouroCorrespondencia $fkSwCgmLogradouroCorrespondencia)
    {
        if (false === $this->fkSwCgmLogradouroCorrespondencias->contains($fkSwCgmLogradouroCorrespondencia)) {
            $fkSwCgmLogradouroCorrespondencia->setFkSwBairroLogradouro($this);
            $this->fkSwCgmLogradouroCorrespondencias->add($fkSwCgmLogradouroCorrespondencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCgmLogradouroCorrespondencia
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmLogradouroCorrespondencia $fkSwCgmLogradouroCorrespondencia
     */
    public function removeFkSwCgmLogradouroCorrespondencias(\Urbem\CoreBundle\Entity\SwCgmLogradouroCorrespondencia $fkSwCgmLogradouroCorrespondencia)
    {
        $this->fkSwCgmLogradouroCorrespondencias->removeElement($fkSwCgmLogradouroCorrespondencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCgmLogradouroCorrespondencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgmLogradouroCorrespondencia
     */
    public function getFkSwCgmLogradouroCorrespondencias()
    {
        return $this->fkSwCgmLogradouroCorrespondencias;
    }

    /**
     * OneToMany (owning side)
     * Add SwCgaLogradouroCorrespondencia
     *
     * @param \Urbem\CoreBundle\Entity\SwCgaLogradouroCorrespondencia $fkSwCgaLogradouroCorrespondencia
     * @return SwBairroLogradouro
     */
    public function addFkSwCgaLogradouroCorrespondencias(\Urbem\CoreBundle\Entity\SwCgaLogradouroCorrespondencia $fkSwCgaLogradouroCorrespondencia)
    {
        if (false === $this->fkSwCgaLogradouroCorrespondencias->contains($fkSwCgaLogradouroCorrespondencia)) {
            $fkSwCgaLogradouroCorrespondencia->setFkSwBairroLogradouro($this);
            $this->fkSwCgaLogradouroCorrespondencias->add($fkSwCgaLogradouroCorrespondencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCgaLogradouroCorrespondencia
     *
     * @param \Urbem\CoreBundle\Entity\SwCgaLogradouroCorrespondencia $fkSwCgaLogradouroCorrespondencia
     */
    public function removeFkSwCgaLogradouroCorrespondencias(\Urbem\CoreBundle\Entity\SwCgaLogradouroCorrespondencia $fkSwCgaLogradouroCorrespondencia)
    {
        $this->fkSwCgaLogradouroCorrespondencias->removeElement($fkSwCgaLogradouroCorrespondencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCgaLogradouroCorrespondencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgaLogradouroCorrespondencia
     */
    public function getFkSwCgaLogradouroCorrespondencias()
    {
        return $this->fkSwCgaLogradouroCorrespondencias;
    }

    /**
     * OneToMany (owning side)
     * Add SwCgmLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmLogradouro $fkSwCgmLogradouro
     * @return SwBairroLogradouro
     */
    public function addFkSwCgmLogradouros(\Urbem\CoreBundle\Entity\SwCgmLogradouro $fkSwCgmLogradouro)
    {
        if (false === $this->fkSwCgmLogradouros->contains($fkSwCgmLogradouro)) {
            $fkSwCgmLogradouro->setFkSwBairroLogradouro($this);
            $this->fkSwCgmLogradouros->add($fkSwCgmLogradouro);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCgmLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmLogradouro $fkSwCgmLogradouro
     */
    public function removeFkSwCgmLogradouros(\Urbem\CoreBundle\Entity\SwCgmLogradouro $fkSwCgmLogradouro)
    {
        $this->fkSwCgmLogradouros->removeElement($fkSwCgmLogradouro);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCgmLogradouros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgmLogradouro
     */
    public function getFkSwCgmLogradouros()
    {
        return $this->fkSwCgmLogradouros;
    }

    /**
     * OneToMany (owning side)
     * Add SwCgaLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwCgaLogradouro $fkSwCgaLogradouro
     * @return SwBairroLogradouro
     */
    public function addFkSwCgaLogradouros(\Urbem\CoreBundle\Entity\SwCgaLogradouro $fkSwCgaLogradouro)
    {
        if (false === $this->fkSwCgaLogradouros->contains($fkSwCgaLogradouro)) {
            $fkSwCgaLogradouro->setFkSwBairroLogradouro($this);
            $this->fkSwCgaLogradouros->add($fkSwCgaLogradouro);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCgaLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwCgaLogradouro $fkSwCgaLogradouro
     */
    public function removeFkSwCgaLogradouros(\Urbem\CoreBundle\Entity\SwCgaLogradouro $fkSwCgaLogradouro)
    {
        $this->fkSwCgaLogradouros->removeElement($fkSwCgaLogradouro);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCgaLogradouros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgaLogradouro
     */
    public function getFkSwCgaLogradouros()
    {
        return $this->fkSwCgaLogradouros;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwBairro
     *
     * @param \Urbem\CoreBundle\Entity\SwBairro $fkSwBairro
     * @return SwBairroLogradouro
     */
    public function setFkSwBairro(\Urbem\CoreBundle\Entity\SwBairro $fkSwBairro)
    {
        $this->codBairro = $fkSwBairro->getCodBairro();
        $this->codUf = $fkSwBairro->getCodUf();
        $this->codMunicipio = $fkSwBairro->getCodMunicipio();
        $this->fkSwBairro = $fkSwBairro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwBairro
     *
     * @return \Urbem\CoreBundle\Entity\SwBairro
     */
    public function getFkSwBairro()
    {
        return $this->fkSwBairro;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwLogradouro $fkSwLogradouro
     * @return SwBairroLogradouro
     */
    public function setFkSwLogradouro(\Urbem\CoreBundle\Entity\SwLogradouro $fkSwLogradouro)
    {
        $this->codLogradouro = $fkSwLogradouro->getCodLogradouro();
        $this->fkSwLogradouro = $fkSwLogradouro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwLogradouro
     *
     * @return \Urbem\CoreBundle\Entity\SwLogradouro
     */
    public function getFkSwLogradouro()
    {
        return $this->fkSwLogradouro;
    }
}
