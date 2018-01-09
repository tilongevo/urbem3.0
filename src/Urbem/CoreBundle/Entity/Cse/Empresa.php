<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * Empresa
 */
class Empresa
{
    /**
     * PK
     * @var integer
     */
    private $codEmpresa;

    /**
     * @var string
     */
    private $nomEmpresa;

    /**
     * @var string
     */
    private $cnpj;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\QualificacaoProfissional
     */
    private $fkCseQualificacaoProfissionais;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCseQualificacaoProfissionais = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codEmpresa
     *
     * @param integer $codEmpresa
     * @return Empresa
     */
    public function setCodEmpresa($codEmpresa)
    {
        $this->codEmpresa = $codEmpresa;
        return $this;
    }

    /**
     * Get codEmpresa
     *
     * @return integer
     */
    public function getCodEmpresa()
    {
        return $this->codEmpresa;
    }

    /**
     * Set nomEmpresa
     *
     * @param string $nomEmpresa
     * @return Empresa
     */
    public function setNomEmpresa($nomEmpresa)
    {
        $this->nomEmpresa = $nomEmpresa;
        return $this;
    }

    /**
     * Get nomEmpresa
     *
     * @return string
     */
    public function getNomEmpresa()
    {
        return $this->nomEmpresa;
    }

    /**
     * Set cnpj
     *
     * @param string $cnpj
     * @return Empresa
     */
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
        return $this;
    }

    /**
     * Get cnpj
     *
     * @return string
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * OneToMany (owning side)
     * Add CseQualificacaoProfissional
     *
     * @param \Urbem\CoreBundle\Entity\Cse\QualificacaoProfissional $fkCseQualificacaoProfissional
     * @return Empresa
     */
    public function addFkCseQualificacaoProfissionais(\Urbem\CoreBundle\Entity\Cse\QualificacaoProfissional $fkCseQualificacaoProfissional)
    {
        if (false === $this->fkCseQualificacaoProfissionais->contains($fkCseQualificacaoProfissional)) {
            $fkCseQualificacaoProfissional->setFkCseEmpresa($this);
            $this->fkCseQualificacaoProfissionais->add($fkCseQualificacaoProfissional);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CseQualificacaoProfissional
     *
     * @param \Urbem\CoreBundle\Entity\Cse\QualificacaoProfissional $fkCseQualificacaoProfissional
     */
    public function removeFkCseQualificacaoProfissionais(\Urbem\CoreBundle\Entity\Cse\QualificacaoProfissional $fkCseQualificacaoProfissional)
    {
        $this->fkCseQualificacaoProfissionais->removeElement($fkCseQualificacaoProfissional);
    }

    /**
     * OneToMany (owning side)
     * Get fkCseQualificacaoProfissionais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\QualificacaoProfissional
     */
    public function getFkCseQualificacaoProfissionais()
    {
        return $this->fkCseQualificacaoProfissionais;
    }
}
