<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * GrauParentesco
 */
class GrauParentesco
{
    /**
     * PK
     * @var integer
     */
    private $codGrau;

    /**
     * @var string
     */
    private $nomGrau;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Cidadao
     */
    private $fkCseCidadoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Dependente
     */
    private $fkPessoalDependentes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Pensionista
     */
    private $fkPessoalPensionistas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\Beneficiario
     */
    private $fkBeneficioBeneficiarios;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCseCidadoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalDependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalPensionistas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkBeneficioBeneficiarios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codGrau
     *
     * @param integer $codGrau
     * @return GrauParentesco
     */
    public function setCodGrau($codGrau)
    {
        $this->codGrau = $codGrau;
        return $this;
    }

    /**
     * Get codGrau
     *
     * @return integer
     */
    public function getCodGrau()
    {
        return $this->codGrau;
    }

    /**
     * Set nomGrau
     *
     * @param string $nomGrau
     * @return GrauParentesco
     */
    public function setNomGrau($nomGrau)
    {
        $this->nomGrau = $nomGrau;
        return $this;
    }

    /**
     * Get nomGrau
     *
     * @return string
     */
    public function getNomGrau()
    {
        return $this->nomGrau;
    }

    /**
     * OneToMany (owning side)
     * Add CseCidadao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao
     * @return GrauParentesco
     */
    public function addFkCseCidadoes(\Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao)
    {
        if (false === $this->fkCseCidadoes->contains($fkCseCidadao)) {
            $fkCseCidadao->setFkCseGrauParentesco($this);
            $this->fkCseCidadoes->add($fkCseCidadao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CseCidadao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao
     */
    public function removeFkCseCidadoes(\Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao)
    {
        $this->fkCseCidadoes->removeElement($fkCseCidadao);
    }

    /**
     * OneToMany (owning side)
     * Get fkCseCidadoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Cidadao
     */
    public function getFkCseCidadoes()
    {
        return $this->fkCseCidadoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalDependente
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Dependente $fkPessoalDependente
     * @return GrauParentesco
     */
    public function addFkPessoalDependentes(\Urbem\CoreBundle\Entity\Pessoal\Dependente $fkPessoalDependente)
    {
        if (false === $this->fkPessoalDependentes->contains($fkPessoalDependente)) {
            $fkPessoalDependente->setFkCseGrauParentesco($this);
            $this->fkPessoalDependentes->add($fkPessoalDependente);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalDependente
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Dependente $fkPessoalDependente
     */
    public function removeFkPessoalDependentes(\Urbem\CoreBundle\Entity\Pessoal\Dependente $fkPessoalDependente)
    {
        $this->fkPessoalDependentes->removeElement($fkPessoalDependente);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalDependentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Dependente
     */
    public function getFkPessoalDependentes()
    {
        return $this->fkPessoalDependentes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalPensionista
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Pensionista $fkPessoalPensionista
     * @return GrauParentesco
     */
    public function addFkPessoalPensionistas(\Urbem\CoreBundle\Entity\Pessoal\Pensionista $fkPessoalPensionista)
    {
        if (false === $this->fkPessoalPensionistas->contains($fkPessoalPensionista)) {
            $fkPessoalPensionista->setFkCseGrauParentesco($this);
            $this->fkPessoalPensionistas->add($fkPessoalPensionista);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalPensionista
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Pensionista $fkPessoalPensionista
     */
    public function removeFkPessoalPensionistas(\Urbem\CoreBundle\Entity\Pessoal\Pensionista $fkPessoalPensionista)
    {
        $this->fkPessoalPensionistas->removeElement($fkPessoalPensionista);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalPensionistas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Pensionista
     */
    public function getFkPessoalPensionistas()
    {
        return $this->fkPessoalPensionistas;
    }

    /**
     * OneToMany (owning side)
     * Add BeneficioBeneficiario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario
     * @return GrauParentesco
     */
    public function addFkBeneficioBeneficiarios(\Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario)
    {
        if (false === $this->fkBeneficioBeneficiarios->contains($fkBeneficioBeneficiario)) {
            $fkBeneficioBeneficiario->setFkCseGrauParentesco($this);
            $this->fkBeneficioBeneficiarios->add($fkBeneficioBeneficiario);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioBeneficiario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario
     */
    public function removeFkBeneficioBeneficiarios(\Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario)
    {
        $this->fkBeneficioBeneficiarios->removeElement($fkBeneficioBeneficiario);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioBeneficiarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\Beneficiario
     */
    public function getFkBeneficioBeneficiarios()
    {
        return $this->fkBeneficioBeneficiarios;
    }
}
