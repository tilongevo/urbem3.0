<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwPais
 */
class SwPais
{
    const COD_BRASIL = 1;

    /**
     * PK
     * @var integer
     */
    private $codPais;

    /**
     * @var integer
     */
    private $codRais;

    /**
     * @var string
     */
    private $nomPais;

    /**
     * @var string
     */
    private $nacionalidade;

    /**
     * @var string
     */
    private $sigla3;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwUf
     */
    private $fkSwUfs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgaPessoaFisica
     */
    private $fkSwCgaPessoaFisicas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisicas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgns;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgns1;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwUfs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgaPessoaFisicas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgmPessoaFisicas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgns = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgns1 = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPais
     *
     * @param integer $codPais
     * @return SwPais
     */
    public function setCodPais($codPais)
    {
        $this->codPais = $codPais;
        return $this;
    }

    /**
     * Get codPais
     *
     * @return integer
     */
    public function getCodPais()
    {
        return $this->codPais;
    }

    /**
     * Set codRais
     *
     * @param integer $codRais
     * @return SwPais
     */
    public function setCodRais($codRais)
    {
        $this->codRais = $codRais;
        return $this;
    }

    /**
     * Get codRais
     *
     * @return integer
     */
    public function getCodRais()
    {
        return $this->codRais;
    }

    /**
     * Set nomPais
     *
     * @param string $nomPais
     * @return SwPais
     */
    public function setNomPais($nomPais)
    {
        $this->nomPais = $nomPais;
        return $this;
    }

    /**
     * Get nomPais
     *
     * @return string
     */
    public function getNomPais()
    {
        return $this->nomPais;
    }

    /**
     * Set nacionalidade
     *
     * @param string $nacionalidade
     * @return SwPais
     */
    public function setNacionalidade($nacionalidade)
    {
        $this->nacionalidade = $nacionalidade;
        return $this;
    }

    /**
     * Get nacionalidade
     *
     * @return string
     */
    public function getNacionalidade()
    {
        return $this->nacionalidade;
    }

    /**
     * Set sigla3
     *
     * @param string $sigla3
     * @return SwPais
     */
    public function setSigla3($sigla3)
    {
        $this->sigla3 = $sigla3;
        return $this;
    }

    /**
     * Get sigla3
     *
     * @return string
     */
    public function getSigla3()
    {
        return $this->sigla3;
    }

    /**
     * OneToMany (owning side)
     * Add SwUf
     *
     * @param \Urbem\CoreBundle\Entity\SwUf $fkSwUf
     * @return SwPais
     */
    public function addFkSwUfs(\Urbem\CoreBundle\Entity\SwUf $fkSwUf)
    {
        if (false === $this->fkSwUfs->contains($fkSwUf)) {
            $fkSwUf->setFkSwPais($this);
            $this->fkSwUfs->add($fkSwUf);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwUf
     *
     * @param \Urbem\CoreBundle\Entity\SwUf $fkSwUf
     */
    public function removeFkSwUfs(\Urbem\CoreBundle\Entity\SwUf $fkSwUf)
    {
        $this->fkSwUfs->removeElement($fkSwUf);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwUfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwUf
     */
    public function getFkSwUfs()
    {
        return $this->fkSwUfs;
    }

    /**
     * OneToMany (owning side)
     * Add SwCgaPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgaPessoaFisica $fkSwCgaPessoaFisica
     * @return SwPais
     */
    public function addFkSwCgaPessoaFisicas(\Urbem\CoreBundle\Entity\SwCgaPessoaFisica $fkSwCgaPessoaFisica)
    {
        if (false === $this->fkSwCgaPessoaFisicas->contains($fkSwCgaPessoaFisica)) {
            $fkSwCgaPessoaFisica->setFkSwPais($this);
            $this->fkSwCgaPessoaFisicas->add($fkSwCgaPessoaFisica);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCgaPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgaPessoaFisica $fkSwCgaPessoaFisica
     */
    public function removeFkSwCgaPessoaFisicas(\Urbem\CoreBundle\Entity\SwCgaPessoaFisica $fkSwCgaPessoaFisica)
    {
        $this->fkSwCgaPessoaFisicas->removeElement($fkSwCgaPessoaFisica);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCgaPessoaFisicas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgaPessoaFisica
     */
    public function getFkSwCgaPessoaFisicas()
    {
        return $this->fkSwCgaPessoaFisicas;
    }

    /**
     * OneToMany (owning side)
     * Add SwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return SwPais
     */
    public function addFkSwCgmPessoaFisicas(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        if (false === $this->fkSwCgmPessoaFisicas->contains($fkSwCgmPessoaFisica)) {
            $fkSwCgmPessoaFisica->setFkSwPais($this);
            $this->fkSwCgmPessoaFisicas->add($fkSwCgmPessoaFisica);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     */
    public function removeFkSwCgmPessoaFisicas(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $this->fkSwCgmPessoaFisicas->removeElement($fkSwCgmPessoaFisica);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCgmPessoaFisicas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisicas()
    {
        return $this->fkSwCgmPessoaFisicas;
    }

    /**
     * OneToMany (owning side)
     * Add SwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return SwPais
     */
    public function addFkSwCgns(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        if (false === $this->fkSwCgns->contains($fkSwCgm)) {
            $fkSwCgm->setFkSwPais($this);
            $this->fkSwCgns->add($fkSwCgm);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     */
    public function removeFkSwCgns(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->fkSwCgns->removeElement($fkSwCgm);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCgns
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgns()
    {
        return $this->fkSwCgns;
    }

    /**
     * OneToMany (owning side)
     * Add SwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return SwPais
     */
    public function addFkSwCgns1(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        if (false === $this->fkSwCgns1->contains($fkSwCgm)) {
            $fkSwCgm->setFkSwPais1($this);
            $this->fkSwCgns1->add($fkSwCgm);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     */
    public function removeFkSwCgns1(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->fkSwCgns1->removeElement($fkSwCgm);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCgns1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgns1()
    {
        return $this->fkSwCgns1;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getNomPais();
    }
}
