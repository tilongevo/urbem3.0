<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwBairro
 */
class SwBairro
{
    /**
     * PK
     * @var integer
     */
    private $codBairro;

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
     * @var string
     */
    private $nomBairro;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\BairroAliquota
     */
    private $fkImobiliarioBairroAliquotas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\BairroValorM2
     */
    private $fkImobiliarioBairroValorM2s;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LoteBairro
     */
    private $fkImobiliarioLoteBairros;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\Obra
     */
    private $fkTcmbaObras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwBairroLogradouro
     */
    private $fkSwBairroLogradouros;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwMunicipio
     */
    private $fkSwMunicipio;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioBairroAliquotas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioBairroValorM2s = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLoteBairros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaObras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwBairroLogradouros = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codBairro
     *
     * @param integer $codBairro
     * @return SwBairro
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
     * Set codUf
     *
     * @param integer $codUf
     * @return SwBairro
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
     * @return SwBairro
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
     * Set nomBairro
     *
     * @param string $nomBairro
     * @return SwBairro
     */
    public function setNomBairro($nomBairro)
    {
        $this->nomBairro = $nomBairro;
        return $this;
    }

    /**
     * Get nomBairro
     *
     * @return string
     */
    public function getNomBairro()
    {
        return $this->nomBairro;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioBairroAliquota
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\BairroAliquota $fkImobiliarioBairroAliquota
     * @return SwBairro
     */
    public function addFkImobiliarioBairroAliquotas(\Urbem\CoreBundle\Entity\Imobiliario\BairroAliquota $fkImobiliarioBairroAliquota)
    {
        if (false === $this->fkImobiliarioBairroAliquotas->contains($fkImobiliarioBairroAliquota)) {
            $fkImobiliarioBairroAliquota->setFkSwBairro($this);
            $this->fkImobiliarioBairroAliquotas->add($fkImobiliarioBairroAliquota);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioBairroAliquota
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\BairroAliquota $fkImobiliarioBairroAliquota
     */
    public function removeFkImobiliarioBairroAliquotas(\Urbem\CoreBundle\Entity\Imobiliario\BairroAliquota $fkImobiliarioBairroAliquota)
    {
        $this->fkImobiliarioBairroAliquotas->removeElement($fkImobiliarioBairroAliquota);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioBairroAliquotas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\BairroAliquota
     */
    public function getFkImobiliarioBairroAliquotas()
    {
        return $this->fkImobiliarioBairroAliquotas;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioBairroValorM2
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\BairroValorM2 $fkImobiliarioBairroValorM2
     * @return SwBairro
     */
    public function addFkImobiliarioBairroValorM2s(\Urbem\CoreBundle\Entity\Imobiliario\BairroValorM2 $fkImobiliarioBairroValorM2)
    {
        if (false === $this->fkImobiliarioBairroValorM2s->contains($fkImobiliarioBairroValorM2)) {
            $fkImobiliarioBairroValorM2->setFkSwBairro($this);
            $this->fkImobiliarioBairroValorM2s->add($fkImobiliarioBairroValorM2);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioBairroValorM2
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\BairroValorM2 $fkImobiliarioBairroValorM2
     */
    public function removeFkImobiliarioBairroValorM2s(\Urbem\CoreBundle\Entity\Imobiliario\BairroValorM2 $fkImobiliarioBairroValorM2)
    {
        $this->fkImobiliarioBairroValorM2s->removeElement($fkImobiliarioBairroValorM2);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioBairroValorM2s
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\BairroValorM2
     */
    public function getFkImobiliarioBairroValorM2s()
    {
        return $this->fkImobiliarioBairroValorM2s;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLoteBairro
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteBairro $fkImobiliarioLoteBairro
     * @return SwBairro
     */
    public function addFkImobiliarioLoteBairros(\Urbem\CoreBundle\Entity\Imobiliario\LoteBairro $fkImobiliarioLoteBairro)
    {
        if (false === $this->fkImobiliarioLoteBairros->contains($fkImobiliarioLoteBairro)) {
            $fkImobiliarioLoteBairro->setFkSwBairro($this);
            $this->fkImobiliarioLoteBairros->add($fkImobiliarioLoteBairro);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLoteBairro
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteBairro $fkImobiliarioLoteBairro
     */
    public function removeFkImobiliarioLoteBairros(\Urbem\CoreBundle\Entity\Imobiliario\LoteBairro $fkImobiliarioLoteBairro)
    {
        $this->fkImobiliarioLoteBairros->removeElement($fkImobiliarioLoteBairro);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLoteBairros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LoteBairro
     */
    public function getFkImobiliarioLoteBairros()
    {
        return $this->fkImobiliarioLoteBairros;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\Obra $fkTcmbaObra
     * @return SwBairro
     */
    public function addFkTcmbaObras(\Urbem\CoreBundle\Entity\Tcmba\Obra $fkTcmbaObra)
    {
        if (false === $this->fkTcmbaObras->contains($fkTcmbaObra)) {
            $fkTcmbaObra->setFkSwBairro($this);
            $this->fkTcmbaObras->add($fkTcmbaObra);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\Obra $fkTcmbaObra
     */
    public function removeFkTcmbaObras(\Urbem\CoreBundle\Entity\Tcmba\Obra $fkTcmbaObra)
    {
        $this->fkTcmbaObras->removeElement($fkTcmbaObra);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaObras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\Obra
     */
    public function getFkTcmbaObras()
    {
        return $this->fkTcmbaObras;
    }

    /**
     * OneToMany (owning side)
     * Add SwBairroLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwBairroLogradouro $fkSwBairroLogradouro
     * @return SwBairro
     */
    public function addFkSwBairroLogradouros(\Urbem\CoreBundle\Entity\SwBairroLogradouro $fkSwBairroLogradouro)
    {
        if (false === $this->fkSwBairroLogradouros->contains($fkSwBairroLogradouro)) {
            $fkSwBairroLogradouro->setFkSwBairro($this);
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
     * ManyToOne (inverse side)
     * Set fkSwMunicipio
     *
     * @param \Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio
     * @return SwBairro
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
        return (string) $this->nomBairro;
    }
}
