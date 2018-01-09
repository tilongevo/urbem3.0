<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwEscolaridade
 */
class SwEscolaridade
{
    /**
     * PK
     * @var integer
     */
    private $codEscolaridade;

    /**
     * @var string
     */
    private $descricao;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Cargo
     */
    private $fkPessoalCargo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwCgaPessoaFisicas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgmPessoaFisicas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codEscolaridade
     *
     * @param integer $codEscolaridade
     * @return SwEscolaridade
     */
    public function setCodEscolaridade($codEscolaridade)
    {
        $this->codEscolaridade = $codEscolaridade;
        return $this;
    }

    /**
     * Get codEscolaridade
     *
     * @return integer
     */
    public function getCodEscolaridade()
    {
        return $this->codEscolaridade;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return SwEscolaridade
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * OneToMany (owning side)
     * Add SwCgaPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgaPessoaFisica $fkSwCgaPessoaFisica
     * @return SwEscolaridade
     */
    public function addFkSwCgaPessoaFisicas(\Urbem\CoreBundle\Entity\SwCgaPessoaFisica $fkSwCgaPessoaFisica)
    {
        if (false === $this->fkSwCgaPessoaFisicas->contains($fkSwCgaPessoaFisica)) {
            $fkSwCgaPessoaFisica->setFkSwEscolaridade($this);
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
     * @return SwEscolaridade
     */
    public function addFkSwCgmPessoaFisicas(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        if (false === $this->fkSwCgmPessoaFisicas->contains($fkSwCgmPessoaFisica)) {
            $fkSwCgmPessoaFisica->setFkSwEscolaridade($this);
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
     * @return \Doctrine\Common\Collections\Collection|Pessoal\Cargo
     */
    public function getFkPessoalCargo()
    {
        return $this->fkPessoalCargo;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection|Pessoal\Cargo $fkPessoalCargo
     */
    public function setFkPessoalCargo($fkPessoalCargo)
    {
        $this->fkPessoalCargo = $fkPessoalCargo;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->descricao;
    }
}
