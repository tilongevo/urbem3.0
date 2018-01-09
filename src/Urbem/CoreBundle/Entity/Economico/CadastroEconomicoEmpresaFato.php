<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * CadastroEconomicoEmpresaFato
 */
class CadastroEconomicoEmpresaFato
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoEmpresaFatoValor
     */
    private $fkEconomicoAtributoEmpresaFatoValores;

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
        $this->fkEconomicoAtributoEmpresaFatoValores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return CadastroEconomicoEmpresaFato
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
     * @return CadastroEconomicoEmpresaFato
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
     * Add EconomicoAtributoEmpresaFatoValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoEmpresaFatoValor $fkEconomicoAtributoEmpresaFatoValor
     * @return CadastroEconomicoEmpresaFato
     */
    public function addFkEconomicoAtributoEmpresaFatoValores(\Urbem\CoreBundle\Entity\Economico\AtributoEmpresaFatoValor $fkEconomicoAtributoEmpresaFatoValor)
    {
        if (false === $this->fkEconomicoAtributoEmpresaFatoValores->contains($fkEconomicoAtributoEmpresaFatoValor)) {
            $fkEconomicoAtributoEmpresaFatoValor->setFkEconomicoCadastroEconomicoEmpresaFato($this);
            $this->fkEconomicoAtributoEmpresaFatoValores->add($fkEconomicoAtributoEmpresaFatoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtributoEmpresaFatoValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoEmpresaFatoValor $fkEconomicoAtributoEmpresaFatoValor
     */
    public function removeFkEconomicoAtributoEmpresaFatoValores(\Urbem\CoreBundle\Entity\Economico\AtributoEmpresaFatoValor $fkEconomicoAtributoEmpresaFatoValor)
    {
        $this->fkEconomicoAtributoEmpresaFatoValores->removeElement($fkEconomicoAtributoEmpresaFatoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtributoEmpresaFatoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoEmpresaFatoValor
     */
    public function getFkEconomicoAtributoEmpresaFatoValores()
    {
        return $this->fkEconomicoAtributoEmpresaFatoValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return CadastroEconomicoEmpresaFato
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
     * @return CadastroEconomicoEmpresaFato
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
