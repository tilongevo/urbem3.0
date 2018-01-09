<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * Profissao
 */
class Profissao
{
    const ENGENHEIRO = 1;
    const ARQUITETO = 2;

    /**
     * PK
     * @var integer
     */
    private $codProfissao;

    /**
     * @var integer
     */
    private $codConselho;

    /**
     * @var string
     */
    private $nomProfissao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\QualificacaoProfissional
     */
    private $fkCseQualificacaoProfissionais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtividadeProfissao
     */
    private $fkEconomicoAtividadeProfissoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\EmpresaProfissao
     */
    private $fkEconomicoEmpresaProfissoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico
     */
    private $fkEconomicoResponsavelTecnicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Pensionista
     */
    private $fkPessoalPensionistas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\Conselho
     */
    private $fkCseConselho;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCseQualificacaoProfissionais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoAtividadeProfissoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoEmpresaProfissoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoResponsavelTecnicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalPensionistas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codProfissao
     *
     * @param integer $codProfissao
     * @return Profissao
     */
    public function setCodProfissao($codProfissao)
    {
        $this->codProfissao = $codProfissao;
        return $this;
    }

    /**
     * Get codProfissao
     *
     * @return integer
     */
    public function getCodProfissao()
    {
        return $this->codProfissao;
    }

    /**
     * Set codConselho
     *
     * @param integer $codConselho
     * @return Profissao
     */
    public function setCodConselho($codConselho)
    {
        $this->codConselho = $codConselho;
        return $this;
    }

    /**
     * Get codConselho
     *
     * @return integer
     */
    public function getCodConselho()
    {
        return $this->codConselho;
    }

    /**
     * Set nomProfissao
     *
     * @param string $nomProfissao
     * @return Profissao
     */
    public function setNomProfissao($nomProfissao)
    {
        $this->nomProfissao = $nomProfissao;
        return $this;
    }

    /**
     * Get nomProfissao
     *
     * @return string
     */
    public function getNomProfissao()
    {
        return $this->nomProfissao;
    }

    /**
     * OneToMany (owning side)
     * Add CseQualificacaoProfissional
     *
     * @param \Urbem\CoreBundle\Entity\Cse\QualificacaoProfissional $fkCseQualificacaoProfissional
     * @return Profissao
     */
    public function addFkCseQualificacaoProfissionais(\Urbem\CoreBundle\Entity\Cse\QualificacaoProfissional $fkCseQualificacaoProfissional)
    {
        if (false === $this->fkCseQualificacaoProfissionais->contains($fkCseQualificacaoProfissional)) {
            $fkCseQualificacaoProfissional->setFkCseProfissao($this);
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

    /**
     * OneToMany (owning side)
     * Add EconomicoAtividadeProfissao
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeProfissao $fkEconomicoAtividadeProfissao
     * @return Profissao
     */
    public function addFkEconomicoAtividadeProfissoes(\Urbem\CoreBundle\Entity\Economico\AtividadeProfissao $fkEconomicoAtividadeProfissao)
    {
        if (false === $this->fkEconomicoAtividadeProfissoes->contains($fkEconomicoAtividadeProfissao)) {
            $fkEconomicoAtividadeProfissao->setFkCseProfissao($this);
            $this->fkEconomicoAtividadeProfissoes->add($fkEconomicoAtividadeProfissao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtividadeProfissao
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeProfissao $fkEconomicoAtividadeProfissao
     */
    public function removeFkEconomicoAtividadeProfissoes(\Urbem\CoreBundle\Entity\Economico\AtividadeProfissao $fkEconomicoAtividadeProfissao)
    {
        $this->fkEconomicoAtividadeProfissoes->removeElement($fkEconomicoAtividadeProfissao);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtividadeProfissoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtividadeProfissao
     */
    public function getFkEconomicoAtividadeProfissoes()
    {
        return $this->fkEconomicoAtividadeProfissoes;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoEmpresaProfissao
     *
     * @param \Urbem\CoreBundle\Entity\Economico\EmpresaProfissao $fkEconomicoEmpresaProfissao
     * @return Profissao
     */
    public function addFkEconomicoEmpresaProfissoes(\Urbem\CoreBundle\Entity\Economico\EmpresaProfissao $fkEconomicoEmpresaProfissao)
    {
        if (false === $this->fkEconomicoEmpresaProfissoes->contains($fkEconomicoEmpresaProfissao)) {
            $fkEconomicoEmpresaProfissao->setFkCseProfissao($this);
            $this->fkEconomicoEmpresaProfissoes->add($fkEconomicoEmpresaProfissao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoEmpresaProfissao
     *
     * @param \Urbem\CoreBundle\Entity\Economico\EmpresaProfissao $fkEconomicoEmpresaProfissao
     */
    public function removeFkEconomicoEmpresaProfissoes(\Urbem\CoreBundle\Entity\Economico\EmpresaProfissao $fkEconomicoEmpresaProfissao)
    {
        $this->fkEconomicoEmpresaProfissoes->removeElement($fkEconomicoEmpresaProfissao);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoEmpresaProfissoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\EmpresaProfissao
     */
    public function getFkEconomicoEmpresaProfissoes()
    {
        return $this->fkEconomicoEmpresaProfissoes;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoResponsavelTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico $fkEconomicoResponsavelTecnico
     * @return Profissao
     */
    public function addFkEconomicoResponsavelTecnicos(\Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico $fkEconomicoResponsavelTecnico)
    {
        if (false === $this->fkEconomicoResponsavelTecnicos->contains($fkEconomicoResponsavelTecnico)) {
            $fkEconomicoResponsavelTecnico->setFkCseProfissao($this);
            $this->fkEconomicoResponsavelTecnicos->add($fkEconomicoResponsavelTecnico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoResponsavelTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico $fkEconomicoResponsavelTecnico
     */
    public function removeFkEconomicoResponsavelTecnicos(\Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico $fkEconomicoResponsavelTecnico)
    {
        $this->fkEconomicoResponsavelTecnicos->removeElement($fkEconomicoResponsavelTecnico);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoResponsavelTecnicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico
     */
    public function getFkEconomicoResponsavelTecnicos()
    {
        return $this->fkEconomicoResponsavelTecnicos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalPensionista
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Pensionista $fkPessoalPensionista
     * @return Profissao
     */
    public function addFkPessoalPensionistas(\Urbem\CoreBundle\Entity\Pessoal\Pensionista $fkPessoalPensionista)
    {
        if (false === $this->fkPessoalPensionistas->contains($fkPessoalPensionista)) {
            $fkPessoalPensionista->setFkCseProfissao($this);
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
     * ManyToOne (inverse side)
     * Set fkCseConselho
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Conselho $fkCseConselho
     * @return Profissao
     */
    public function setFkCseConselho(\Urbem\CoreBundle\Entity\Cse\Conselho $fkCseConselho)
    {
        $this->codConselho = $fkCseConselho->getCodConselho();
        $this->fkCseConselho = $fkCseConselho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseConselho
     *
     * @return \Urbem\CoreBundle\Entity\Cse\Conselho
     */
    public function getFkCseConselho()
    {
        return $this->fkCseConselho;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getCodProfissao();
    }
}
