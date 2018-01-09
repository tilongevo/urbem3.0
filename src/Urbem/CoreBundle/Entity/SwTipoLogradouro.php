<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwTipoLogradouro
 */
class SwTipoLogradouro
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
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Domicilio
     */
    private $fkCseDomicilios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwNomeLogradouro
     */
    private $fkSwNomeLogradouros;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCseDomicilios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwNomeLogradouros = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return SwTipoLogradouro
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
     * @return SwTipoLogradouro
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
     * OneToMany (owning side)
     * Add CseDomicilio
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio
     * @return SwTipoLogradouro
     */
    public function addFkCseDomicilios(\Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio)
    {
        if (false === $this->fkCseDomicilios->contains($fkCseDomicilio)) {
            $fkCseDomicilio->setFkSwTipoLogradouro($this);
            $this->fkCseDomicilios->add($fkCseDomicilio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CseDomicilio
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio
     */
    public function removeFkCseDomicilios(\Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio)
    {
        $this->fkCseDomicilios->removeElement($fkCseDomicilio);
    }

    /**
     * OneToMany (owning side)
     * Get fkCseDomicilios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Domicilio
     */
    public function getFkCseDomicilios()
    {
        return $this->fkCseDomicilios;
    }

    /**
     * OneToMany (owning side)
     * Add SwNomeLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwNomeLogradouro $fkSwNomeLogradouro
     * @return SwTipoLogradouro
     */
    public function addFkSwNomeLogradouros(\Urbem\CoreBundle\Entity\SwNomeLogradouro $fkSwNomeLogradouro)
    {
        if (false === $this->fkSwNomeLogradouros->contains($fkSwNomeLogradouro)) {
            $fkSwNomeLogradouro->setFkSwTipoLogradouro($this);
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
     * @return string
     */
    public function __toString()
    {
        return $this->getNomTipo();
    }
}
