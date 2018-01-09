<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwCategoriaHabilitacao
 */
class SwCategoriaHabilitacao
{
    /**
     * PK
     * @var integer
     */
    private $codCategoria;

    /**
     * @var string
     */
    private $nomCategoria;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCategoriaHabilitacaoVinculada
     */
    private $fkSwCategoriaHabilitacaoVinculadas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCategoriaHabilitacaoVinculada
     */
    private $fkSwCategoriaHabilitacaoVinculadas1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    private $fkFrotaVeiculos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwCgaPessoaFisicas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgmPessoaFisicas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCategoriaHabilitacaoVinculadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCategoriaHabilitacaoVinculadas1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaVeiculos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCategoria
     *
     * @param integer $codCategoria
     * @return SwCategoriaHabilitacao
     */
    public function setCodCategoria($codCategoria)
    {
        $this->codCategoria = $codCategoria;
        return $this;
    }

    /**
     * Get codCategoria
     *
     * @return integer
     */
    public function getCodCategoria()
    {
        return $this->codCategoria;
    }

    /**
     * Set nomCategoria
     *
     * @param string $nomCategoria
     * @return SwCategoriaHabilitacao
     */
    public function setNomCategoria($nomCategoria)
    {
        $this->nomCategoria = $nomCategoria;
        return $this;
    }

    /**
     * Get nomCategoria
     *
     * @return string
     */
    public function getNomCategoria()
    {
        return $this->nomCategoria;
    }

    /**
     * OneToMany (owning side)
     * Add SwCgaPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgaPessoaFisica $fkSwCgaPessoaFisica
     * @return SwCategoriaHabilitacao
     */
    public function addFkSwCgaPessoaFisicas(\Urbem\CoreBundle\Entity\SwCgaPessoaFisica $fkSwCgaPessoaFisica)
    {
        if (false === $this->fkSwCgaPessoaFisicas->contains($fkSwCgaPessoaFisica)) {
            $fkSwCgaPessoaFisica->setFkSwCategoriaHabilitacao($this);
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
     * @return SwCategoriaHabilitacao
     */
    public function addFkSwCgmPessoaFisicas(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        if (false === $this->fkSwCgmPessoaFisicas->contains($fkSwCgmPessoaFisica)) {
            $fkSwCgmPessoaFisica->setFkSwCategoriaHabilitacao($this);
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
     * Add SwCategoriaHabilitacaoVinculada
     *
     * @param \Urbem\CoreBundle\Entity\SwCategoriaHabilitacaoVinculada $fkSwCategoriaHabilitacaoVinculada
     * @return SwCategoriaHabilitacao
     */
    public function addFkSwCategoriaHabilitacaoVinculadas(\Urbem\CoreBundle\Entity\SwCategoriaHabilitacaoVinculada $fkSwCategoriaHabilitacaoVinculada)
    {
        if (false === $this->fkSwCategoriaHabilitacaoVinculadas->contains($fkSwCategoriaHabilitacaoVinculada)) {
            $fkSwCategoriaHabilitacaoVinculada->setFkSwCategoriaHabilitacao($this);
            $this->fkSwCategoriaHabilitacaoVinculadas->add($fkSwCategoriaHabilitacaoVinculada);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCategoriaHabilitacaoVinculada
     *
     * @param \Urbem\CoreBundle\Entity\SwCategoriaHabilitacaoVinculada $fkSwCategoriaHabilitacaoVinculada
     */
    public function removeFkSwCategoriaHabilitacaoVinculadas(\Urbem\CoreBundle\Entity\SwCategoriaHabilitacaoVinculada $fkSwCategoriaHabilitacaoVinculada)
    {
        $this->fkSwCategoriaHabilitacaoVinculadas->removeElement($fkSwCategoriaHabilitacaoVinculada);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCategoriaHabilitacaoVinculadas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCategoriaHabilitacaoVinculada
     */
    public function getFkSwCategoriaHabilitacaoVinculadas()
    {
        return $this->fkSwCategoriaHabilitacaoVinculadas;
    }

    /**
     * OneToMany (owning side)
     * Add SwCategoriaHabilitacaoVinculada
     *
     * @param \Urbem\CoreBundle\Entity\SwCategoriaHabilitacaoVinculada $fkSwCategoriaHabilitacaoVinculada
     * @return SwCategoriaHabilitacao
     */
    public function addFkSwCategoriaHabilitacaoVinculadas1(\Urbem\CoreBundle\Entity\SwCategoriaHabilitacaoVinculada $fkSwCategoriaHabilitacaoVinculada)
    {
        if (false === $this->fkSwCategoriaHabilitacaoVinculadas1->contains($fkSwCategoriaHabilitacaoVinculada)) {
            $fkSwCategoriaHabilitacaoVinculada->setFkSwCategoriaHabilitacao1($this);
            $this->fkSwCategoriaHabilitacaoVinculadas1->add($fkSwCategoriaHabilitacaoVinculada);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCategoriaHabilitacaoVinculada
     *
     * @param \Urbem\CoreBundle\Entity\SwCategoriaHabilitacaoVinculada $fkSwCategoriaHabilitacaoVinculada
     */
    public function removeFkSwCategoriaHabilitacaoVinculadas1(\Urbem\CoreBundle\Entity\SwCategoriaHabilitacaoVinculada $fkSwCategoriaHabilitacaoVinculada)
    {
        $this->fkSwCategoriaHabilitacaoVinculadas1->removeElement($fkSwCategoriaHabilitacaoVinculada);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCategoriaHabilitacaoVinculadas1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCategoriaHabilitacaoVinculada
     */
    public function getFkSwCategoriaHabilitacaoVinculadas1()
    {
        return $this->fkSwCategoriaHabilitacaoVinculadas1;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo
     * @return SwCategoriaHabilitacao
     */
    public function addFkFrotaVeiculos(\Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo)
    {
        if (false === $this->fkFrotaVeiculos->contains($fkFrotaVeiculo)) {
            $fkFrotaVeiculo->setFkSwCategoriaHabilitacao($this);
            $this->fkFrotaVeiculos->add($fkFrotaVeiculo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo
     */
    public function removeFkFrotaVeiculos(\Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo)
    {
        $this->fkFrotaVeiculos->removeElement($fkFrotaVeiculo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaVeiculos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    public function getFkFrotaVeiculos()
    {
        return $this->fkFrotaVeiculos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s - %s',
            $this->codCategoria,
            $this->nomCategoria
        );
    }
}
