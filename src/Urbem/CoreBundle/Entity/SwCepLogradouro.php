<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwCepLogradouro
 */
class SwCepLogradouro
{
    /**
     * PK
     * @var string
     */
    private $cep;

    /**
     * PK
     * @var integer
     */
    private $codLogradouro;

    /**
     * @var string
     */
    private $numInicial;

    /**
     * @var string
     */
    private $numFinal;

    /**
     * @var boolean
     */
    private $par = false;

    /**
     * @var boolean
     */
    private $impar = false;

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
     * @var \Urbem\CoreBundle\Entity\SwCep
     */
    private $fkSwCep;

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
        $this->fkSwCgmLogradouroCorrespondencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgaLogradouroCorrespondencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgmLogradouros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgaLogradouros = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set cep
     *
     * @param string $cep
     * @return SwCepLogradouro
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
        return $this;
    }

    /**
     * Get cep
     *
     * @return string
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * Set codLogradouro
     *
     * @param integer $codLogradouro
     * @return SwCepLogradouro
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
     * Set numInicial
     *
     * @param string $numInicial
     * @return SwCepLogradouro
     */
    public function setNumInicial($numInicial)
    {
        $this->numInicial = $numInicial;
        return $this;
    }

    /**
     * Get numInicial
     *
     * @return string
     */
    public function getNumInicial()
    {
        return $this->numInicial;
    }

    /**
     * Set numFinal
     *
     * @param string $numFinal
     * @return SwCepLogradouro
     */
    public function setNumFinal($numFinal)
    {
        $this->numFinal = $numFinal;
        return $this;
    }

    /**
     * Get numFinal
     *
     * @return string
     */
    public function getNumFinal()
    {
        return $this->numFinal;
    }

    /**
     * Set par
     *
     * @param boolean $par
     * @return SwCepLogradouro
     */
    public function setPar($par = null)
    {
        $this->par = $par;
        return $this;
    }

    /**
     * Get par
     *
     * @return boolean
     */
    public function getPar()
    {
        return $this->par;
    }

    /**
     * Set impar
     *
     * @param boolean $impar
     * @return SwCepLogradouro
     */
    public function setImpar($impar = null)
    {
        $this->impar = $impar;
        return $this;
    }

    /**
     * Get impar
     *
     * @return boolean
     */
    public function getImpar()
    {
        return $this->impar;
    }

    /**
     * OneToMany (owning side)
     * Add SwCgmLogradouroCorrespondencia
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmLogradouroCorrespondencia $fkSwCgmLogradouroCorrespondencia
     * @return SwCepLogradouro
     */
    public function addFkSwCgmLogradouroCorrespondencias(\Urbem\CoreBundle\Entity\SwCgmLogradouroCorrespondencia $fkSwCgmLogradouroCorrespondencia)
    {
        if (false === $this->fkSwCgmLogradouroCorrespondencias->contains($fkSwCgmLogradouroCorrespondencia)) {
            $fkSwCgmLogradouroCorrespondencia->setFkSwCepLogradouro($this);
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
     * @return SwCepLogradouro
     */
    public function addFkSwCgaLogradouroCorrespondencias(\Urbem\CoreBundle\Entity\SwCgaLogradouroCorrespondencia $fkSwCgaLogradouroCorrespondencia)
    {
        if (false === $this->fkSwCgaLogradouroCorrespondencias->contains($fkSwCgaLogradouroCorrespondencia)) {
            $fkSwCgaLogradouroCorrespondencia->setFkSwCepLogradouro($this);
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
     * @return SwCepLogradouro
     */
    public function addFkSwCgmLogradouros(\Urbem\CoreBundle\Entity\SwCgmLogradouro $fkSwCgmLogradouro)
    {
        if (false === $this->fkSwCgmLogradouros->contains($fkSwCgmLogradouro)) {
            $fkSwCgmLogradouro->setFkSwCepLogradouro($this);
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
     * @return SwCepLogradouro
     */
    public function addFkSwCgaLogradouros(\Urbem\CoreBundle\Entity\SwCgaLogradouro $fkSwCgaLogradouro)
    {
        if (false === $this->fkSwCgaLogradouros->contains($fkSwCgaLogradouro)) {
            $fkSwCgaLogradouro->setFkSwCepLogradouro($this);
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
     * Set fkSwCep
     *
     * @param \Urbem\CoreBundle\Entity\SwCep $fkSwCep
     * @return SwCepLogradouro
     */
    public function setFkSwCep(\Urbem\CoreBundle\Entity\SwCep $fkSwCep)
    {
        $this->cep = $fkSwCep->getCep();
        $this->fkSwCep = $fkSwCep;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCep
     *
     * @return \Urbem\CoreBundle\Entity\SwCep
     */
    public function getFkSwCep()
    {
        return $this->fkSwCep;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwLogradouro $fkSwLogradouro
     * @return SwCepLogradouro
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
