<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * CadastroEconomicoAutonomo
 */
class CadastroEconomicoAutonomo
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    private $fkEconomicoCadastroEconomico;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoCadEconAutonomoValor
     */
    private $fkEconomicoAtributoCadEconAutonomoValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoAtributoCadEconAutonomoValores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return CadastroEconomicoAutonomo
     */
    public function setInscricaoEconomica($inscricaoEconomica)
    {
        $this->inscricaoEconomica = $inscricaoEconomica;
        return $this;
    }

    /**
     * Get inscricaoEconomica
     *
     * @return integer
     */
    public function getInscricaoEconomica()
    {
        return $this->inscricaoEconomica;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return CadastroEconomicoAutonomo
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
     * OneToMany (owning side)
     * Add EconomicoAtributoCadEconAutonomoValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoCadEconAutonomoValor $fkEconomicoAtributoCadEconAutonomoValor
     * @return CadastroEconomicoAutonomo
     */
    public function addFkEconomicoAtributoCadEconAutonomoValores(\Urbem\CoreBundle\Entity\Economico\AtributoCadEconAutonomoValor $fkEconomicoAtributoCadEconAutonomoValor)
    {
        if (false === $this->fkEconomicoAtributoCadEconAutonomoValores->contains($fkEconomicoAtributoCadEconAutonomoValor)) {
            $fkEconomicoAtributoCadEconAutonomoValor->setFkEconomicoCadastroEconomicoAutonomo($this);
            $this->fkEconomicoAtributoCadEconAutonomoValores->add($fkEconomicoAtributoCadEconAutonomoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtributoCadEconAutonomoValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoCadEconAutonomoValor $fkEconomicoAtributoCadEconAutonomoValor
     */
    public function removeFkEconomicoAtributoCadEconAutonomoValores(\Urbem\CoreBundle\Entity\Economico\AtributoCadEconAutonomoValor $fkEconomicoAtributoCadEconAutonomoValor)
    {
        $this->fkEconomicoAtributoCadEconAutonomoValores->removeElement($fkEconomicoAtributoCadEconAutonomoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtributoCadEconAutonomoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoCadEconAutonomoValor
     */
    public function getFkEconomicoAtributoCadEconAutonomoValores()
    {
        return $this->fkEconomicoAtributoCadEconAutonomoValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return CadastroEconomicoAutonomo
     */
    public function setFkSwCgmPessoaFisica(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $this->numcgm = $fkSwCgmPessoaFisica->getNumcgm();
        $this->fkSwCgmPessoaFisica = $fkSwCgmPessoaFisica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica()
    {
        return $this->fkSwCgmPessoaFisica;
    }

    /**
     * OneToOne (owning side)
     * Set EconomicoCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico
     * @return CadastroEconomicoAutonomo
     */
    public function setFkEconomicoCadastroEconomico(\Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico)
    {
        $this->inscricaoEconomica = $fkEconomicoCadastroEconomico->getInscricaoEconomica();
        $this->fkEconomicoCadastroEconomico = $fkEconomicoCadastroEconomico;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEconomicoCadastroEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    public function getFkEconomicoCadastroEconomico()
    {
        return $this->fkEconomicoCadastroEconomico;
    }
}
