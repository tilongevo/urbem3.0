<?php

namespace Urbem\CoreBundle\Entity;

/**
 * SwUf
 */
class SwUf
{
    /**
     * PK
     * @var integer
     */
    private $codUf;

    /**
     * @var integer
     */
    private $codPais;

    /**
     * @var string
     */
    private $nomUf;

    /**
     * @var string
     */
    private $siglaUf;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Cidadao
     */
    private $fkCseCidadoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoContaGeral
     */
    private $fkContabilidadePlanoContaGerais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico
     */
    private $fkEconomicoResponsavelTecnicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Ctps
     */
    private $fkPessoalCtps;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwMunicipio
     */
    private $fkSwMunicipios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\Documento
     */
    private $fkTcepeDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde
     */
    private $fkTcmgoConfiguracaoIdes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel
     */
    private $fkTcmgoUnidadeResponsaveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel
     */
    private $fkTcmgoUnidadeResponsaveis1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisicas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwPais
     */
    private $fkSwPais;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCseCidadoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadePlanoContaGerais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoResponsavelTecnicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalCtps = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwMunicipios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoConfiguracaoIdes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoUnidadeResponsaveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoUnidadeResponsaveis1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgmPessoaFisicas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codUf
     *
     * @param integer $codUf
     * @return SwUf
     */
    public function setCodUf($codUf)
    {
        $this->codUf = $codUf;
        return $this;
    }

    /**
     * Get codUf
     *
     * @return integer
     */
    public function getCodUf()
    {
        return $this->codUf;
    }

    /**
     * Set codPais
     *
     * @param integer $codPais
     * @return SwUf
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
     * Set nomUf
     *
     * @param string $nomUf
     * @return SwUf
     */
    public function setNomUf($nomUf)
    {
        $this->nomUf = $nomUf;
        return $this;
    }

    /**
     * Get nomUf
     *
     * @return string
     */
    public function getNomUf()
    {
        return $this->nomUf;
    }

    /**
     * Set siglaUf
     *
     * @param string $siglaUf
     * @return SwUf
     */
    public function setSiglaUf($siglaUf)
    {
        $this->siglaUf = $siglaUf;
        return $this;
    }

    /**
     * Get siglaUf
     *
     * @return string
     */
    public function getSiglaUf()
    {
        return $this->siglaUf;
    }

    /**
     * OneToMany (owning side)
     * Add CseCidadao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao
     * @return SwUf
     */
    public function addFkCseCidadoes(\Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao)
    {
        if (false === $this->fkCseCidadoes->contains($fkCseCidadao)) {
            $fkCseCidadao->setFkSwUf($this);
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
     * Add ContabilidadePlanoContaGeral
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoContaGeral $fkContabilidadePlanoContaGeral
     * @return SwUf
     */
    public function addFkContabilidadePlanoContaGerais(\Urbem\CoreBundle\Entity\Contabilidade\PlanoContaGeral $fkContabilidadePlanoContaGeral)
    {
        if (false === $this->fkContabilidadePlanoContaGerais->contains($fkContabilidadePlanoContaGeral)) {
            $fkContabilidadePlanoContaGeral->setFkSwUf($this);
            $this->fkContabilidadePlanoContaGerais->add($fkContabilidadePlanoContaGeral);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadePlanoContaGeral
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoContaGeral $fkContabilidadePlanoContaGeral
     */
    public function removeFkContabilidadePlanoContaGerais(\Urbem\CoreBundle\Entity\Contabilidade\PlanoContaGeral $fkContabilidadePlanoContaGeral)
    {
        $this->fkContabilidadePlanoContaGerais->removeElement($fkContabilidadePlanoContaGeral);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadePlanoContaGerais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoContaGeral
     */
    public function getFkContabilidadePlanoContaGerais()
    {
        return $this->fkContabilidadePlanoContaGerais;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoResponsavelTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico $fkEconomicoResponsavelTecnico
     * @return SwUf
     */
    public function addFkEconomicoResponsavelTecnicos(\Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico $fkEconomicoResponsavelTecnico)
    {
        if (false === $this->fkEconomicoResponsavelTecnicos->contains($fkEconomicoResponsavelTecnico)) {
            $fkEconomicoResponsavelTecnico->setFkSwUf($this);
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
     * Add PessoalCtps
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Ctps $fkPessoalCtps
     * @return SwUf
     */
    public function addFkPessoalCtps(\Urbem\CoreBundle\Entity\Pessoal\Ctps $fkPessoalCtps)
    {
        if (false === $this->fkPessoalCtps->contains($fkPessoalCtps)) {
            $fkPessoalCtps->setFkSwUf($this);
            $this->fkPessoalCtps->add($fkPessoalCtps);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalCtps
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Ctps $fkPessoalCtps
     */
    public function removeFkPessoalCtps(\Urbem\CoreBundle\Entity\Pessoal\Ctps $fkPessoalCtps)
    {
        $this->fkPessoalCtps->removeElement($fkPessoalCtps);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalCtps
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Ctps
     */
    public function getFkPessoalCtps()
    {
        return $this->fkPessoalCtps;
    }

    /**
     * OneToMany (owning side)
     * Add SwMunicipio
     *
     * @param \Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio
     * @return SwUf
     */
    public function addFkSwMunicipios(\Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio)
    {
        if (false === $this->fkSwMunicipios->contains($fkSwMunicipio)) {
            $fkSwMunicipio->setFkSwUf($this);
            $this->fkSwMunicipios->add($fkSwMunicipio);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwMunicipio
     *
     * @param \Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio
     */
    public function removeFkSwMunicipios(\Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio)
    {
        $this->fkSwMunicipios->removeElement($fkSwMunicipio);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwMunicipios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwMunicipio
     */
    public function getFkSwMunicipios()
    {
        return $this->fkSwMunicipios;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\Documento $fkTcepeDocumento
     * @return SwUf
     */
    public function addFkTcepeDocumentos(\Urbem\CoreBundle\Entity\Tcepe\Documento $fkTcepeDocumento)
    {
        if (false === $this->fkTcepeDocumentos->contains($fkTcepeDocumento)) {
            $fkTcepeDocumento->setFkSwUf($this);
            $this->fkTcepeDocumentos->add($fkTcepeDocumento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\Documento $fkTcepeDocumento
     */
    public function removeFkTcepeDocumentos(\Urbem\CoreBundle\Entity\Tcepe\Documento $fkTcepeDocumento)
    {
        $this->fkTcepeDocumentos->removeElement($fkTcepeDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\Documento
     */
    public function getFkTcepeDocumentos()
    {
        return $this->fkTcepeDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoConfiguracaoIde
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde $fkTcmgoConfiguracaoIde
     * @return SwUf
     */
    public function addFkTcmgoConfiguracaoIdes(\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde $fkTcmgoConfiguracaoIde)
    {
        if (false === $this->fkTcmgoConfiguracaoIdes->contains($fkTcmgoConfiguracaoIde)) {
            $fkTcmgoConfiguracaoIde->setFkSwUf($this);
            $this->fkTcmgoConfiguracaoIdes->add($fkTcmgoConfiguracaoIde);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoConfiguracaoIde
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde $fkTcmgoConfiguracaoIde
     */
    public function removeFkTcmgoConfiguracaoIdes(\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde $fkTcmgoConfiguracaoIde)
    {
        $this->fkTcmgoConfiguracaoIdes->removeElement($fkTcmgoConfiguracaoIde);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoConfiguracaoIdes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoIde
     */
    public function getFkTcmgoConfiguracaoIdes()
    {
        return $this->fkTcmgoConfiguracaoIdes;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoUnidadeResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel
     * @return SwUf
     */
    public function addFkTcmgoUnidadeResponsaveis(\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel)
    {
        if (false === $this->fkTcmgoUnidadeResponsaveis->contains($fkTcmgoUnidadeResponsavel)) {
            $fkTcmgoUnidadeResponsavel->setFkSwUf($this);
            $this->fkTcmgoUnidadeResponsaveis->add($fkTcmgoUnidadeResponsavel);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoUnidadeResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel
     */
    public function removeFkTcmgoUnidadeResponsaveis(\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel)
    {
        $this->fkTcmgoUnidadeResponsaveis->removeElement($fkTcmgoUnidadeResponsavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoUnidadeResponsaveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel
     */
    public function getFkTcmgoUnidadeResponsaveis()
    {
        return $this->fkTcmgoUnidadeResponsaveis;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoUnidadeResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel
     * @return SwUf
     */
    public function addFkTcmgoUnidadeResponsaveis1(\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel)
    {
        if (false === $this->fkTcmgoUnidadeResponsaveis1->contains($fkTcmgoUnidadeResponsavel)) {
            $fkTcmgoUnidadeResponsavel->setFkSwUf1($this);
            $this->fkTcmgoUnidadeResponsaveis1->add($fkTcmgoUnidadeResponsavel);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoUnidadeResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel
     */
    public function removeFkTcmgoUnidadeResponsaveis1(\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel)
    {
        $this->fkTcmgoUnidadeResponsaveis1->removeElement($fkTcmgoUnidadeResponsavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoUnidadeResponsaveis1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel
     */
    public function getFkTcmgoUnidadeResponsaveis1()
    {
        return $this->fkTcmgoUnidadeResponsaveis1;
    }

    /**
     * OneToMany (owning side)
     * Add SwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return SwUf
     */
    public function addFkSwCgmPessoaFisicas(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        if (false === $this->fkSwCgmPessoaFisicas->contains($fkSwCgmPessoaFisica)) {
            $fkSwCgmPessoaFisica->setFkSwUf($this);
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
     * ManyToOne (inverse side)
     * Set fkSwPais
     *
     * @param \Urbem\CoreBundle\Entity\SwPais $fkSwPais
     * @return SwUf
     */
    public function setFkSwPais(\Urbem\CoreBundle\Entity\SwPais $fkSwPais)
    {
        $this->codPais = $fkSwPais->getCodPais();
        $this->fkSwPais = $fkSwPais;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwPais
     *
     * @return \Urbem\CoreBundle\Entity\SwPais
     */
    public function getFkSwPais()
    {
        return $this->fkSwPais;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->siglaUf, $this->nomUf);
    }
}
