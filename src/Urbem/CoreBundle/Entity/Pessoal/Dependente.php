<?php

namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * Dependente
 */
class Dependente
{
    /**
     * PK
     * @var integer
     */
    private $codDependente;

    /**
     * @var boolean
     */
    private $carteiraVacinacao;

    /**
     * @var boolean
     */
    private $comprovanteMatricula;

    /**
     * @var \DateTime
     */
    private $dtInicioSalFamilia;

    /**
     * @var integer
     */
    private $codGrau;

    /**
     * @var integer
     */
    private $codVinculo;

    /**
     * @var boolean
     */
    private $dependenteSalFamilia = false;

    /**
     * @var boolean
     */
    private $dependenteInvalido = false;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var boolean
     */
    private $dependentePrev = false;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoCalculadoDependente
     */
    private $fkFolhapagamentoEventoCalculadoDependentes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoDecimoCalculadoDependente
     */
    private $fkFolhapagamentoEventoDecimoCalculadoDependentes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DependenteComprovanteMatricula
     */
    private $fkPessoalDependenteComprovanteMatriculas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorDependente
     */
    private $fkPessoalServidorDependentes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoRescisaoCalculadoDependente
     */
    private $fkFolhapagamentoEventoRescisaoCalculadoDependentes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoFeriasCalculadoDependente
     */
    private $fkFolhapagamentoEventoFeriasCalculadoDependentes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DependenteCarteiraVacinacao
     */
    private $fkPessoalDependenteCarteiraVacinacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoComplementarCalculadoDependente
     */
    private $fkFolhapagamentoEventoComplementarCalculadoDependentes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DependenteCid
     */
    private $fkPessoalDependenteCids;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\GrauParentesco
     */
    private $fkCseGrauParentesco;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\VinculoIrrf
     */
    private $fkFolhapagamentoVinculoIrrf;

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
        $this->fkFolhapagamentoEventoCalculadoDependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoEventoDecimoCalculadoDependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalDependenteComprovanteMatriculas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalServidorDependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoEventoRescisaoCalculadoDependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoEventoFeriasCalculadoDependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalDependenteCarteiraVacinacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoEventoComplementarCalculadoDependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalDependenteCids = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codDependente
     *
     * @param integer $codDependente
     * @return Dependente
     */
    public function setCodDependente($codDependente)
    {
        $this->codDependente = $codDependente;
        return $this;
    }

    /**
     * Get codDependente
     *
     * @return integer
     */
    public function getCodDependente()
    {
        return $this->codDependente;
    }

    /**
     * Set carteiraVacinacao
     *
     * @param boolean $carteiraVacinacao
     * @return Dependente
     */
    public function setCarteiraVacinacao($carteiraVacinacao)
    {
        $this->carteiraVacinacao = $carteiraVacinacao;
        return $this;
    }

    /**
     * Get carteiraVacinacao
     *
     * @return boolean
     */
    public function getCarteiraVacinacao()
    {
        return $this->carteiraVacinacao;
    }

    /**
     * Set comprovanteMatricula
     *
     * @param boolean $comprovanteMatricula
     * @return Dependente
     */
    public function setComprovanteMatricula($comprovanteMatricula)
    {
        $this->comprovanteMatricula = $comprovanteMatricula;
        return $this;
    }

    /**
     * Get comprovanteMatricula
     *
     * @return boolean
     */
    public function getComprovanteMatricula()
    {
        return $this->comprovanteMatricula;
    }

    /**
     * Set dtInicioSalFamilia
     *
     * @param \DateTime $dtInicioSalFamilia
     * @return Dependente
     */
    public function setDtInicioSalFamilia(\DateTime $dtInicioSalFamilia = null)
    {
        $this->dtInicioSalFamilia = $dtInicioSalFamilia;
        return $this;
    }

    /**
     * Get dtInicioSalFamilia
     *
     * @return \DateTime
     */
    public function getDtInicioSalFamilia()
    {
        return $this->dtInicioSalFamilia;
    }

    /**
     * Set codGrau
     *
     * @param integer $codGrau
     * @return Dependente
     */
    public function setCodGrau($codGrau = null)
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
     * Set codVinculo
     *
     * @param integer $codVinculo
     * @return Dependente
     */
    public function setCodVinculo($codVinculo)
    {
        $this->codVinculo = $codVinculo;
        return $this;
    }

    /**
     * Get codVinculo
     *
     * @return integer
     */
    public function getCodVinculo()
    {
        return $this->codVinculo;
    }

    /**
     * Set dependenteSalFamilia
     *
     * @param boolean $dependenteSalFamilia
     * @return Dependente
     */
    public function setDependenteSalFamilia($dependenteSalFamilia)
    {
        $this->dependenteSalFamilia = $dependenteSalFamilia;
        return $this;
    }

    /**
     * Get dependenteSalFamilia
     *
     * @return boolean
     */
    public function getDependenteSalFamilia()
    {
        return $this->dependenteSalFamilia;
    }

    /**
     * Set dependenteInvalido
     *
     * @param boolean $dependenteInvalido
     * @return Dependente
     */
    public function setDependenteInvalido($dependenteInvalido)
    {
        $this->dependenteInvalido = $dependenteInvalido;
        return $this;
    }

    /**
     * Get dependenteInvalido
     *
     * @return boolean
     */
    public function getDependenteInvalido()
    {
        return $this->dependenteInvalido;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Dependente
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
     * Set dependentePrev
     *
     * @param boolean $dependentePrev
     * @return Dependente
     */
    public function setDependentePrev($dependentePrev)
    {
        $this->dependentePrev = $dependentePrev;
        return $this;
    }

    /**
     * Get dependentePrev
     *
     * @return boolean
     */
    public function getDependentePrev()
    {
        return $this->dependentePrev;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoEventoCalculadoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoCalculadoDependente $fkFolhapagamentoEventoCalculadoDependente
     * @return Dependente
     */
    public function addFkFolhapagamentoEventoCalculadoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\EventoCalculadoDependente $fkFolhapagamentoEventoCalculadoDependente)
    {
        if (false === $this->fkFolhapagamentoEventoCalculadoDependentes->contains($fkFolhapagamentoEventoCalculadoDependente)) {
            $fkFolhapagamentoEventoCalculadoDependente->setFkPessoalDependente($this);
            $this->fkFolhapagamentoEventoCalculadoDependentes->add($fkFolhapagamentoEventoCalculadoDependente);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoEventoCalculadoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoCalculadoDependente $fkFolhapagamentoEventoCalculadoDependente
     */
    public function removeFkFolhapagamentoEventoCalculadoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\EventoCalculadoDependente $fkFolhapagamentoEventoCalculadoDependente)
    {
        $this->fkFolhapagamentoEventoCalculadoDependentes->removeElement($fkFolhapagamentoEventoCalculadoDependente);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoEventoCalculadoDependentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoCalculadoDependente
     */
    public function getFkFolhapagamentoEventoCalculadoDependentes()
    {
        return $this->fkFolhapagamentoEventoCalculadoDependentes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoEventoDecimoCalculadoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoDecimoCalculadoDependente $fkFolhapagamentoEventoDecimoCalculadoDependente
     * @return Dependente
     */
    public function addFkFolhapagamentoEventoDecimoCalculadoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\EventoDecimoCalculadoDependente $fkFolhapagamentoEventoDecimoCalculadoDependente)
    {
        if (false === $this->fkFolhapagamentoEventoDecimoCalculadoDependentes->contains($fkFolhapagamentoEventoDecimoCalculadoDependente)) {
            $fkFolhapagamentoEventoDecimoCalculadoDependente->setFkPessoalDependente($this);
            $this->fkFolhapagamentoEventoDecimoCalculadoDependentes->add($fkFolhapagamentoEventoDecimoCalculadoDependente);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoEventoDecimoCalculadoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoDecimoCalculadoDependente $fkFolhapagamentoEventoDecimoCalculadoDependente
     */
    public function removeFkFolhapagamentoEventoDecimoCalculadoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\EventoDecimoCalculadoDependente $fkFolhapagamentoEventoDecimoCalculadoDependente)
    {
        $this->fkFolhapagamentoEventoDecimoCalculadoDependentes->removeElement($fkFolhapagamentoEventoDecimoCalculadoDependente);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoEventoDecimoCalculadoDependentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoDecimoCalculadoDependente
     */
    public function getFkFolhapagamentoEventoDecimoCalculadoDependentes()
    {
        return $this->fkFolhapagamentoEventoDecimoCalculadoDependentes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalDependenteComprovanteMatricula
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DependenteComprovanteMatricula $fkPessoalDependenteComprovanteMatricula
     * @return Dependente
     */
    public function addFkPessoalDependenteComprovanteMatriculas(\Urbem\CoreBundle\Entity\Pessoal\DependenteComprovanteMatricula $fkPessoalDependenteComprovanteMatricula)
    {
        if (false === $this->fkPessoalDependenteComprovanteMatriculas->contains($fkPessoalDependenteComprovanteMatricula)) {
            $fkPessoalDependenteComprovanteMatricula->setFkPessoalDependente($this);
            $this->fkPessoalDependenteComprovanteMatriculas->add($fkPessoalDependenteComprovanteMatricula);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalDependenteComprovanteMatricula
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DependenteComprovanteMatricula $fkPessoalDependenteComprovanteMatricula
     */
    public function removeFkPessoalDependenteComprovanteMatriculas(\Urbem\CoreBundle\Entity\Pessoal\DependenteComprovanteMatricula $fkPessoalDependenteComprovanteMatricula)
    {
        $this->fkPessoalDependenteComprovanteMatriculas->removeElement($fkPessoalDependenteComprovanteMatricula);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalDependenteComprovanteMatriculas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DependenteComprovanteMatricula
     */
    public function getFkPessoalDependenteComprovanteMatriculas()
    {
        return $this->fkPessoalDependenteComprovanteMatriculas;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalServidorDependente
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorDependente $fkPessoalServidorDependente
     * @return Dependente
     */
    public function addFkPessoalServidorDependentes(\Urbem\CoreBundle\Entity\Pessoal\ServidorDependente $fkPessoalServidorDependente)
    {
        if (false === $this->fkPessoalServidorDependentes->contains($fkPessoalServidorDependente)) {
            $fkPessoalServidorDependente->setFkPessoalDependente($this);
            $this->fkPessoalServidorDependentes->add($fkPessoalServidorDependente);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalServidorDependente
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorDependente $fkPessoalServidorDependente
     */
    public function removeFkPessoalServidorDependentes(\Urbem\CoreBundle\Entity\Pessoal\ServidorDependente $fkPessoalServidorDependente)
    {
        $this->fkPessoalServidorDependentes->removeElement($fkPessoalServidorDependente);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalServidorDependentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorDependente
     */
    public function getFkPessoalServidorDependentes()
    {
        return $this->fkPessoalServidorDependentes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoEventoRescisaoCalculadoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoRescisaoCalculadoDependente $fkFolhapagamentoEventoRescisaoCalculadoDependente
     * @return Dependente
     */
    public function addFkFolhapagamentoEventoRescisaoCalculadoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\EventoRescisaoCalculadoDependente $fkFolhapagamentoEventoRescisaoCalculadoDependente)
    {
        if (false === $this->fkFolhapagamentoEventoRescisaoCalculadoDependentes->contains($fkFolhapagamentoEventoRescisaoCalculadoDependente)) {
            $fkFolhapagamentoEventoRescisaoCalculadoDependente->setFkPessoalDependente($this);
            $this->fkFolhapagamentoEventoRescisaoCalculadoDependentes->add($fkFolhapagamentoEventoRescisaoCalculadoDependente);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoEventoRescisaoCalculadoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoRescisaoCalculadoDependente $fkFolhapagamentoEventoRescisaoCalculadoDependente
     */
    public function removeFkFolhapagamentoEventoRescisaoCalculadoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\EventoRescisaoCalculadoDependente $fkFolhapagamentoEventoRescisaoCalculadoDependente)
    {
        $this->fkFolhapagamentoEventoRescisaoCalculadoDependentes->removeElement($fkFolhapagamentoEventoRescisaoCalculadoDependente);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoEventoRescisaoCalculadoDependentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoRescisaoCalculadoDependente
     */
    public function getFkFolhapagamentoEventoRescisaoCalculadoDependentes()
    {
        return $this->fkFolhapagamentoEventoRescisaoCalculadoDependentes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoEventoFeriasCalculadoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoFeriasCalculadoDependente $fkFolhapagamentoEventoFeriasCalculadoDependente
     * @return Dependente
     */
    public function addFkFolhapagamentoEventoFeriasCalculadoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\EventoFeriasCalculadoDependente $fkFolhapagamentoEventoFeriasCalculadoDependente)
    {
        if (false === $this->fkFolhapagamentoEventoFeriasCalculadoDependentes->contains($fkFolhapagamentoEventoFeriasCalculadoDependente)) {
            $fkFolhapagamentoEventoFeriasCalculadoDependente->setFkPessoalDependente($this);
            $this->fkFolhapagamentoEventoFeriasCalculadoDependentes->add($fkFolhapagamentoEventoFeriasCalculadoDependente);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoEventoFeriasCalculadoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoFeriasCalculadoDependente $fkFolhapagamentoEventoFeriasCalculadoDependente
     */
    public function removeFkFolhapagamentoEventoFeriasCalculadoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\EventoFeriasCalculadoDependente $fkFolhapagamentoEventoFeriasCalculadoDependente)
    {
        $this->fkFolhapagamentoEventoFeriasCalculadoDependentes->removeElement($fkFolhapagamentoEventoFeriasCalculadoDependente);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoEventoFeriasCalculadoDependentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoFeriasCalculadoDependente
     */
    public function getFkFolhapagamentoEventoFeriasCalculadoDependentes()
    {
        return $this->fkFolhapagamentoEventoFeriasCalculadoDependentes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalDependenteCarteiraVacinacao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DependenteCarteiraVacinacao $fkPessoalDependenteCarteiraVacinacao
     * @return Dependente
     */
    public function addFkPessoalDependenteCarteiraVacinacoes(\Urbem\CoreBundle\Entity\Pessoal\DependenteCarteiraVacinacao $fkPessoalDependenteCarteiraVacinacao)
    {
        if (false === $this->fkPessoalDependenteCarteiraVacinacoes->contains($fkPessoalDependenteCarteiraVacinacao)) {
            $fkPessoalDependenteCarteiraVacinacao->setFkPessoalDependente($this);
            $this->fkPessoalDependenteCarteiraVacinacoes->add($fkPessoalDependenteCarteiraVacinacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalDependenteCarteiraVacinacao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DependenteCarteiraVacinacao $fkPessoalDependenteCarteiraVacinacao
     */
    public function removeFkPessoalDependenteCarteiraVacinacoes(\Urbem\CoreBundle\Entity\Pessoal\DependenteCarteiraVacinacao $fkPessoalDependenteCarteiraVacinacao)
    {
        $this->fkPessoalDependenteCarteiraVacinacoes->removeElement($fkPessoalDependenteCarteiraVacinacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalDependenteCarteiraVacinacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DependenteCarteiraVacinacao
     */
    public function getFkPessoalDependenteCarteiraVacinacoes()
    {
        return $this->fkPessoalDependenteCarteiraVacinacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoEventoComplementarCalculadoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoComplementarCalculadoDependente $fkFolhapagamentoEventoComplementarCalculadoDependente
     * @return Dependente
     */
    public function addFkFolhapagamentoEventoComplementarCalculadoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\EventoComplementarCalculadoDependente $fkFolhapagamentoEventoComplementarCalculadoDependente)
    {
        if (false === $this->fkFolhapagamentoEventoComplementarCalculadoDependentes->contains($fkFolhapagamentoEventoComplementarCalculadoDependente)) {
            $fkFolhapagamentoEventoComplementarCalculadoDependente->setFkPessoalDependente($this);
            $this->fkFolhapagamentoEventoComplementarCalculadoDependentes->add($fkFolhapagamentoEventoComplementarCalculadoDependente);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoEventoComplementarCalculadoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoComplementarCalculadoDependente $fkFolhapagamentoEventoComplementarCalculadoDependente
     */
    public function removeFkFolhapagamentoEventoComplementarCalculadoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\EventoComplementarCalculadoDependente $fkFolhapagamentoEventoComplementarCalculadoDependente)
    {
        $this->fkFolhapagamentoEventoComplementarCalculadoDependentes->removeElement($fkFolhapagamentoEventoComplementarCalculadoDependente);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoEventoComplementarCalculadoDependentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoComplementarCalculadoDependente
     */
    public function getFkFolhapagamentoEventoComplementarCalculadoDependentes()
    {
        return $this->fkFolhapagamentoEventoComplementarCalculadoDependentes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalDependenteCid
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DependenteCid $fkPessoalDependenteCid
     * @return Dependente
     */
    public function addFkPessoalDependenteCids(\Urbem\CoreBundle\Entity\Pessoal\DependenteCid $fkPessoalDependenteCid)
    {
        if (false === $this->fkPessoalDependenteCids->contains($fkPessoalDependenteCid)) {
            $fkPessoalDependenteCid->setFkPessoalDependente($this);
            $this->fkPessoalDependenteCids->add($fkPessoalDependenteCid);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalDependenteCid
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DependenteCid $fkPessoalDependenteCid
     */
    public function removeFkPessoalDependenteCids(\Urbem\CoreBundle\Entity\Pessoal\DependenteCid $fkPessoalDependenteCid)
    {
        $this->fkPessoalDependenteCids->removeElement($fkPessoalDependenteCid);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalDependenteCids
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DependenteCid
     */
    public function getFkPessoalDependenteCids()
    {
        return $this->fkPessoalDependenteCids;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseGrauParentesco
     *
     * @param \Urbem\CoreBundle\Entity\Cse\GrauParentesco $fkCseGrauParentesco
     * @return Dependente
     */
    public function setFkCseGrauParentesco(\Urbem\CoreBundle\Entity\Cse\GrauParentesco $fkCseGrauParentesco)
    {
        $this->codGrau = $fkCseGrauParentesco->getCodGrau();
        $this->fkCseGrauParentesco = $fkCseGrauParentesco;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseGrauParentesco
     *
     * @return \Urbem\CoreBundle\Entity\Cse\GrauParentesco
     */
    public function getFkCseGrauParentesco()
    {
        return $this->fkCseGrauParentesco;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoVinculoIrrf
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\VinculoIrrf $fkFolhapagamentoVinculoIrrf
     * @return Dependente
     */
    public function setFkFolhapagamentoVinculoIrrf(\Urbem\CoreBundle\Entity\Folhapagamento\VinculoIrrf $fkFolhapagamentoVinculoIrrf)
    {
        $this->codVinculo = $fkFolhapagamentoVinculoIrrf->getCodVinculo();
        $this->fkFolhapagamentoVinculoIrrf = $fkFolhapagamentoVinculoIrrf;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoVinculoIrrf
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\VinculoIrrf
     */
    public function getFkFolhapagamentoVinculoIrrf()
    {
        return $this->fkFolhapagamentoVinculoIrrf;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return Dependente
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
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getFkSwCgmPessoaFisica();
    }
}
