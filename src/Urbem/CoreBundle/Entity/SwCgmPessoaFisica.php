<?php

namespace Urbem\CoreBundle\Entity;

/**
 * SwCgmPessoaFisica
 */
class SwCgmPessoaFisica
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $codCategoriaCnh;

    /**
     * @var \DateTime
     */
    private $dtEmissaoRg;

    /**
     * @var string
     */
    private $orgaoEmissor;

    /**
     * @var string
     */
    private $cpf;

    /**
     * @var string
     */
    private $numCnh;

    /**
     * @var \DateTime
     */
    private $dtValidadeCnh;

    /**
     * @var integer
     */
    private $codNacionalidade;

    /**
     * @var integer
     */
    private $codEscolaridade;

    /**
     * @var string
     */
    private $rg;

    /**
     * @var \DateTime
     */
    private $dtNascimento;

    /**
     * @var string
     */
    private $sexo;

    /**
     * @var integer
     */
    private $codUfOrgaoEmissor = 0;

    /**
     * @var string
     */
    private $servidorPisPasep;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Estagio\Estagiario
     */
    private $fkEstagioEstagiario;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\Servidor
     */
    private $fkPessoalServidor;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcepe\CgmAgentePolitico
     */
    private $fkTcepeCgmAgentePolitico;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Assinatura
     */
    private $fkAdministracaoAssinaturas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado
     */
    private $fkAlmoxarifadoAlmoxarifados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\Candidato
     */
    private $fkConcursoCandidatos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\Autoridade
     */
    private $fkDividaAutoridades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoAutonomo
     */
    private $fkEconomicoCadastroEconomicoAutonomos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaFato
     */
    private $fkEconomicoCadastroEconomicoEmpresaFatos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\Fiscal
     */
    private $fkFiscalizacaoFiscais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente
     */
    private $fkFolhapagamentoDeducaoDependentes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Corretor
     */
    private $fkImobiliarioCorretores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    private $fkLicitacaoContratos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    private $fkLicitacaoContratos1;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorConjuge
     */
    private $fkPessoalServidorConjuges;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ResponsavelLegal
     */
    private $fkPessoalResponsavelLegais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Contrato
     */
    private $fkTcemgContratos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos
     */
    private $fkTcemgRegistroPrecos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Resplic
     */
    private $fkTcemgResplics;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Resplic
     */
    private $fkTcemgResplics1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Resplic
     */
    private $fkTcemgResplics2;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Resplic
     */
    private $fkTcemgResplics3;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Resplic
     */
    private $fkTcemgResplics4;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Resplic
     */
    private $fkTcemgResplics5;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Resplic
     */
    private $fkTcemgResplics6;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Resplic
     */
    private $fkTcemgResplics7;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Resplic
     */
    private $fkTcemgResplics8;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoOrdenador
     */
    private $fkTcepeConfiguracaoOrdenadores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoGestor
     */
    private $fkTcepeConfiguracaoGestores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoRatificador
     */
    private $fkTcmbaConfiguracaoRatificadores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ObraMedicao
     */
    private $fkTcmbaObraMedicoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ObraContratos
     */
    private $fkTcmbaObraContratos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao
     */
    private $fkTcmgoResponsavelLicitacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao
     */
    private $fkTcmgoResponsavelLicitacoes1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao
     */
    private $fkTcmgoResponsavelLicitacoes2;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao
     */
    private $fkTcmgoResponsavelLicitacoes3;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao
     */
    private $fkTcmgoResponsavelLicitacoes4;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao
     */
    private $fkTcmgoResponsavelLicitacoes5;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao
     */
    private $fkTcmgoResponsavelLicitacoes6;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    private $fkOrganogramaOrgoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgao
     */
    private $fkTcemgRegistroPrecosOrgoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoOrdenador
     */
    private $fkTcmbaConfiguracaoOrdenadores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa
     */
    private $fkTcmgoResponsavelLicitacaoDispensas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa
     */
    private $fkTcmgoResponsavelLicitacaoDispensas1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa
     */
    private $fkTcmgoResponsavelLicitacaoDispensas2;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa
     */
    private $fkTcmgoResponsavelLicitacaoDispensas3;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa
     */
    private $fkTcmgoResponsavelLicitacaoDispensas4;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa
     */
    private $fkTcmgoResponsavelLicitacaoDispensas5;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa
     */
    private $fkTcmgoResponsavelLicitacaoDispensas6;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCategoriaHabilitacao
     */
    private $fkSwCategoriaHabilitacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwPais
     */
    private $fkSwPais;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwEscolaridade
     */
    private $fkSwEscolaridade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwUf
     */
    private $fkSwUf;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoAssinaturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoAlmoxarifados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkConcursoCandidatos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaAutoridades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoCadastroEconomicoAutonomos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoCadastroEconomicoEmpresaFatos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoFiscais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoDeducaoDependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioCorretores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoContratos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoContratos1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalDependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalPensionistas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalServidorConjuges = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalResponsavelLegais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgContratos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgRegistroPrecos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgResplics = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgResplics1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgResplics2 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgResplics3 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgResplics4 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgResplics5 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgResplics6 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgResplics7 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgResplics8 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeConfiguracaoOrdenadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeConfiguracaoGestores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaConfiguracaoRatificadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaObraMedicoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaObraContratos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoResponsavelLicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoResponsavelLicitacoes1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoResponsavelLicitacoes2 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoResponsavelLicitacoes3 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoResponsavelLicitacoes4 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoResponsavelLicitacoes5 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoResponsavelLicitacoes6 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoEntidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrganogramaOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgRegistroPrecosOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaConfiguracaoOrdenadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoResponsavelLicitacaoDispensas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoResponsavelLicitacaoDispensas1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoResponsavelLicitacaoDispensas2 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoResponsavelLicitacaoDispensas3 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoResponsavelLicitacaoDispensas4 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoResponsavelLicitacaoDispensas5 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoResponsavelLicitacaoDispensas6 = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return SwCgmPessoaFisica
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
     * Set codCategoriaCnh
     *
     * @param integer $codCategoriaCnh
     * @return SwCgmPessoaFisica
     */
    public function setCodCategoriaCnh($codCategoriaCnh)
    {
        $this->codCategoriaCnh = $codCategoriaCnh;
        return $this;
    }

    /**
     * Get codCategoriaCnh
     *
     * @return integer
     */
    public function getCodCategoriaCnh()
    {
        return $this->codCategoriaCnh;
    }

    /**
     * Set dtEmissaoRg
     *
     * @param \DateTime $dtEmissaoRg
     * @return SwCgmPessoaFisica
     */
    public function setDtEmissaoRg(\DateTime $dtEmissaoRg = null)
    {
        $this->dtEmissaoRg = $dtEmissaoRg;
        return $this;
    }

    /**
     * Get dtEmissaoRg
     *
     * @return \DateTime
     */
    public function getDtEmissaoRg()
    {
        return $this->dtEmissaoRg;
    }

    /**
     * Set orgaoEmissor
     *
     * @param string $orgaoEmissor
     * @return SwCgmPessoaFisica
     */
    public function setOrgaoEmissor($orgaoEmissor)
    {
        $this->orgaoEmissor = $orgaoEmissor;
        return $this;
    }

    /**
     * Get orgaoEmissor
     *
     * @return string
     */
    public function getOrgaoEmissor()
    {
        return $this->orgaoEmissor;
    }

    /**
     * Set cpf
     *
     * @param string $cpf
     * @return SwCgmPessoaFisica
     */
    public function setCpf($cpf = null)
    {
        $this->cpf = $cpf;
        return $this;
    }

    /**
     * Get cpf
     *
     * @return string
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Set numCnh
     *
     * @param string $numCnh
     * @return SwCgmPessoaFisica
     */
    public function setNumCnh($numCnh)
    {
        $this->numCnh = $numCnh;
        return $this;
    }

    /**
     * Get numCnh
     *
     * @return string
     */
    public function getNumCnh()
    {
        return $this->numCnh;
    }

    /**
     * Set dtValidadeCnh
     *
     * @param \DateTime $dtValidadeCnh
     * @return SwCgmPessoaFisica
     */
    public function setDtValidadeCnh(\DateTime $dtValidadeCnh = null)
    {
        $this->dtValidadeCnh = $dtValidadeCnh;
        return $this;
    }

    /**
     * Get dtValidadeCnh
     *
     * @return \DateTime
     */
    public function getDtValidadeCnh()
    {
        return $this->dtValidadeCnh;
    }

    /**
     * Set codNacionalidade
     *
     * @param integer $codNacionalidade
     * @return SwCgmPessoaFisica
     */
    public function setCodNacionalidade($codNacionalidade)
    {
        $this->codNacionalidade = $codNacionalidade;
        return $this;
    }

    /**
     * Get codNacionalidade
     *
     * @return integer
     */
    public function getCodNacionalidade()
    {
        return $this->codNacionalidade;
    }

    /**
     * Set codEscolaridade
     *
     * @param integer $codEscolaridade
     * @return SwCgmPessoaFisica
     */
    public function setCodEscolaridade($codEscolaridade = null)
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
     * Set rg
     *
     * @param string $rg
     * @return SwCgmPessoaFisica
     */
    public function setRg($rg)
    {
        $this->rg = $rg;
        return $this;
    }

    /**
     * Get rg
     *
     * @return string
     */
    public function getRg()
    {
        return $this->rg;
    }

    /**
     * Set dtNascimento
     *
     * @param \DateTime $dtNascimento
     * @return SwCgmPessoaFisica
     */
    public function setDtNascimento(\DateTime $dtNascimento = null)
    {
        $this->dtNascimento = $dtNascimento;
        return $this;
    }

    /**
     * Get dtNascimento
     *
     * @return \DateTime
     */
    public function getDtNascimento()
    {
        return $this->dtNascimento;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     * @return SwCgmPessoaFisica
     */
    public function setSexo($sexo = null)
    {
        $this->sexo = $sexo;
        return $this;
    }

    /**
     * Get sexo
     *
     * @return string
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set codUfOrgaoEmissor
     *
     * @param integer $codUfOrgaoEmissor
     * @return SwCgmPessoaFisica
     */
    public function setCodUfOrgaoEmissor($codUfOrgaoEmissor = null)
    {
        $this->codUfOrgaoEmissor = $codUfOrgaoEmissor;
        return $this;
    }

    /**
     * Get codUfOrgaoEmissor
     *
     * @return integer
     */
    public function getCodUfOrgaoEmissor()
    {
        return $this->codUfOrgaoEmissor;
    }

    /**
     * Set servidorPisPasep
     *
     * @param string $servidorPisPasep
     * @return SwCgmPessoaFisica
     */
    public function setServidorPisPasep($servidorPisPasep = null)
    {
        $this->servidorPisPasep = $servidorPisPasep;
        return $this;
    }

    /**
     * Get servidorPisPasep
     *
     * @return string
     */
    public function getServidorPisPasep()
    {
        return $this->servidorPisPasep;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Assinatura $fkAdministracaoAssinatura
     * @return SwCgmPessoaFisica
     */
    public function addFkAdministracaoAssinaturas(\Urbem\CoreBundle\Entity\Administracao\Assinatura $fkAdministracaoAssinatura)
    {
        if (false === $this->fkAdministracaoAssinaturas->contains($fkAdministracaoAssinatura)) {
            $fkAdministracaoAssinatura->setFkSwCgmPessoaFisica($this);
            $this->fkAdministracaoAssinaturas->add($fkAdministracaoAssinatura);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Assinatura $fkAdministracaoAssinatura
     */
    public function removeFkAdministracaoAssinaturas(\Urbem\CoreBundle\Entity\Administracao\Assinatura $fkAdministracaoAssinatura)
    {
        $this->fkAdministracaoAssinaturas->removeElement($fkAdministracaoAssinatura);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoAssinaturas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Assinatura
     */
    public function getFkAdministracaoAssinaturas()
    {
        return $this->fkAdministracaoAssinaturas;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoAlmoxarifado
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado $fkAlmoxarifadoAlmoxarifado
     * @return SwCgmPessoaFisica
     */
    public function addFkAlmoxarifadoAlmoxarifados(\Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado $fkAlmoxarifadoAlmoxarifado)
    {
        if (false === $this->fkAlmoxarifadoAlmoxarifados->contains($fkAlmoxarifadoAlmoxarifado)) {
            $fkAlmoxarifadoAlmoxarifado->setFkSwCgmPessoaFisica($this);
            $this->fkAlmoxarifadoAlmoxarifados->add($fkAlmoxarifadoAlmoxarifado);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoAlmoxarifado
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado $fkAlmoxarifadoAlmoxarifado
     */
    public function removeFkAlmoxarifadoAlmoxarifados(\Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado $fkAlmoxarifadoAlmoxarifado)
    {
        $this->fkAlmoxarifadoAlmoxarifados->removeElement($fkAlmoxarifadoAlmoxarifado);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoAlmoxarifados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado
     */
    public function getFkAlmoxarifadoAlmoxarifados()
    {
        return $this->fkAlmoxarifadoAlmoxarifados;
    }

    /**
     * OneToMany (owning side)
     * Add ConcursoCandidato
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\Candidato $fkConcursoCandidato
     * @return SwCgmPessoaFisica
     */
    public function addFkConcursoCandidatos(\Urbem\CoreBundle\Entity\Concurso\Candidato $fkConcursoCandidato)
    {
        if (false === $this->fkConcursoCandidatos->contains($fkConcursoCandidato)) {
            $fkConcursoCandidato->setFkSwCgmPessoaFisica($this);
            $this->fkConcursoCandidatos->add($fkConcursoCandidato);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ConcursoCandidato
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\Candidato $fkConcursoCandidato
     */
    public function removeFkConcursoCandidatos(\Urbem\CoreBundle\Entity\Concurso\Candidato $fkConcursoCandidato)
    {
        $this->fkConcursoCandidatos->removeElement($fkConcursoCandidato);
    }

    /**
     * OneToMany (owning side)
     * Get fkConcursoCandidatos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\Candidato
     */
    public function getFkConcursoCandidatos()
    {
        return $this->fkConcursoCandidatos;
    }

    /**
     * OneToMany (owning side)
     * Add DividaAutoridade
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Autoridade $fkDividaAutoridade
     * @return SwCgmPessoaFisica
     */
    public function addFkDividaAutoridades(\Urbem\CoreBundle\Entity\Divida\Autoridade $fkDividaAutoridade)
    {
        if (false === $this->fkDividaAutoridades->contains($fkDividaAutoridade)) {
            $fkDividaAutoridade->setFkSwCgmPessoaFisica($this);
            $this->fkDividaAutoridades->add($fkDividaAutoridade);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaAutoridade
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Autoridade $fkDividaAutoridade
     */
    public function removeFkDividaAutoridades(\Urbem\CoreBundle\Entity\Divida\Autoridade $fkDividaAutoridade)
    {
        $this->fkDividaAutoridades->removeElement($fkDividaAutoridade);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaAutoridades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\Autoridade
     */
    public function getFkDividaAutoridades()
    {
        return $this->fkDividaAutoridades;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoCadastroEconomicoAutonomo
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoAutonomo $fkEconomicoCadastroEconomicoAutonomo
     * @return SwCgmPessoaFisica
     */
    public function addFkEconomicoCadastroEconomicoAutonomos(\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoAutonomo $fkEconomicoCadastroEconomicoAutonomo)
    {
        if (false === $this->fkEconomicoCadastroEconomicoAutonomos->contains($fkEconomicoCadastroEconomicoAutonomo)) {
            $fkEconomicoCadastroEconomicoAutonomo->setFkSwCgmPessoaFisica($this);
            $this->fkEconomicoCadastroEconomicoAutonomos->add($fkEconomicoCadastroEconomicoAutonomo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoCadastroEconomicoAutonomo
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoAutonomo $fkEconomicoCadastroEconomicoAutonomo
     */
    public function removeFkEconomicoCadastroEconomicoAutonomos(\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoAutonomo $fkEconomicoCadastroEconomicoAutonomo)
    {
        $this->fkEconomicoCadastroEconomicoAutonomos->removeElement($fkEconomicoCadastroEconomicoAutonomo);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoCadastroEconomicoAutonomos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoAutonomo
     */
    public function getFkEconomicoCadastroEconomicoAutonomos()
    {
        return $this->fkEconomicoCadastroEconomicoAutonomos;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoCadastroEconomicoEmpresaFato
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaFato $fkEconomicoCadastroEconomicoEmpresaFato
     * @return SwCgmPessoaFisica
     */
    public function addFkEconomicoCadastroEconomicoEmpresaFatos(\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaFato $fkEconomicoCadastroEconomicoEmpresaFato)
    {
        if (false === $this->fkEconomicoCadastroEconomicoEmpresaFatos->contains($fkEconomicoCadastroEconomicoEmpresaFato)) {
            $fkEconomicoCadastroEconomicoEmpresaFato->setFkSwCgmPessoaFisica($this);
            $this->fkEconomicoCadastroEconomicoEmpresaFatos->add($fkEconomicoCadastroEconomicoEmpresaFato);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoCadastroEconomicoEmpresaFato
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaFato $fkEconomicoCadastroEconomicoEmpresaFato
     */
    public function removeFkEconomicoCadastroEconomicoEmpresaFatos(\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaFato $fkEconomicoCadastroEconomicoEmpresaFato)
    {
        $this->fkEconomicoCadastroEconomicoEmpresaFatos->removeElement($fkEconomicoCadastroEconomicoEmpresaFato);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoCadastroEconomicoEmpresaFatos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaFato
     */
    public function getFkEconomicoCadastroEconomicoEmpresaFatos()
    {
        return $this->fkEconomicoCadastroEconomicoEmpresaFatos;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Fiscal $fkFiscalizacaoFiscal
     * @return SwCgmPessoaFisica
     */
    public function addFkFiscalizacaoFiscais(\Urbem\CoreBundle\Entity\Fiscalizacao\Fiscal $fkFiscalizacaoFiscal)
    {
        if (false === $this->fkFiscalizacaoFiscais->contains($fkFiscalizacaoFiscal)) {
            $fkFiscalizacaoFiscal->setFkSwCgmPessoaFisica($this);
            $this->fkFiscalizacaoFiscais->add($fkFiscalizacaoFiscal);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Fiscal $fkFiscalizacaoFiscal
     */
    public function removeFkFiscalizacaoFiscais(\Urbem\CoreBundle\Entity\Fiscalizacao\Fiscal $fkFiscalizacaoFiscal)
    {
        $this->fkFiscalizacaoFiscais->removeElement($fkFiscalizacaoFiscal);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoFiscais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\Fiscal
     */
    public function getFkFiscalizacaoFiscais()
    {
        return $this->fkFiscalizacaoFiscais;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoDeducaoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente $fkFolhapagamentoDeducaoDependente
     * @return SwCgmPessoaFisica
     */
    public function addFkFolhapagamentoDeducaoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente $fkFolhapagamentoDeducaoDependente)
    {
        if (false === $this->fkFolhapagamentoDeducaoDependentes->contains($fkFolhapagamentoDeducaoDependente)) {
            $fkFolhapagamentoDeducaoDependente->setFkSwCgmPessoaFisica($this);
            $this->fkFolhapagamentoDeducaoDependentes->add($fkFolhapagamentoDeducaoDependente);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoDeducaoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente $fkFolhapagamentoDeducaoDependente
     */
    public function removeFkFolhapagamentoDeducaoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente $fkFolhapagamentoDeducaoDependente)
    {
        $this->fkFolhapagamentoDeducaoDependentes->removeElement($fkFolhapagamentoDeducaoDependente);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoDeducaoDependentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente
     */
    public function getFkFolhapagamentoDeducaoDependentes()
    {
        return $this->fkFolhapagamentoDeducaoDependentes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioCorretor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Corretor $fkImobiliarioCorretor
     * @return SwCgmPessoaFisica
     */
    public function addFkImobiliarioCorretores(\Urbem\CoreBundle\Entity\Imobiliario\Corretor $fkImobiliarioCorretor)
    {
        if (false === $this->fkImobiliarioCorretores->contains($fkImobiliarioCorretor)) {
            $fkImobiliarioCorretor->setFkSwCgmPessoaFisica($this);
            $this->fkImobiliarioCorretores->add($fkImobiliarioCorretor);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioCorretor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Corretor $fkImobiliarioCorretor
     */
    public function removeFkImobiliarioCorretores(\Urbem\CoreBundle\Entity\Imobiliario\Corretor $fkImobiliarioCorretor)
    {
        $this->fkImobiliarioCorretores->removeElement($fkImobiliarioCorretor);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioCorretores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Corretor
     */
    public function getFkImobiliarioCorretores()
    {
        return $this->fkImobiliarioCorretores;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato
     * @return SwCgmPessoaFisica
     */
    public function addFkLicitacaoContratos(\Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato)
    {
        if (false === $this->fkLicitacaoContratos->contains($fkLicitacaoContrato)) {
            $fkLicitacaoContrato->setFkSwCgmPessoaFisica($this);
            $this->fkLicitacaoContratos->add($fkLicitacaoContrato);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato
     */
    public function removeFkLicitacaoContratos(\Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato)
    {
        $this->fkLicitacaoContratos->removeElement($fkLicitacaoContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    public function getFkLicitacaoContratos()
    {
        return $this->fkLicitacaoContratos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato
     * @return SwCgmPessoaFisica
     */
    public function addFkLicitacaoContratos1(\Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato)
    {
        if (false === $this->fkLicitacaoContratos1->contains($fkLicitacaoContrato)) {
            $fkLicitacaoContrato->setFkSwCgmPessoaFisica1($this);
            $this->fkLicitacaoContratos1->add($fkLicitacaoContrato);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato
     */
    public function removeFkLicitacaoContratos1(\Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato)
    {
        $this->fkLicitacaoContratos1->removeElement($fkLicitacaoContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoContratos1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    public function getFkLicitacaoContratos1()
    {
        return $this->fkLicitacaoContratos1;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalDependente
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Dependente $fkPessoalDependente
     * @return SwCgmPessoaFisica
     */
    public function addFkPessoalDependentes(\Urbem\CoreBundle\Entity\Pessoal\Dependente $fkPessoalDependente)
    {
        if (false === $this->fkPessoalDependentes->contains($fkPessoalDependente)) {
            $fkPessoalDependente->setFkSwCgmPessoaFisica($this);
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
     * @return SwCgmPessoaFisica
     */
    public function addFkPessoalPensionistas(\Urbem\CoreBundle\Entity\Pessoal\Pensionista $fkPessoalPensionista)
    {
        if (false === $this->fkPessoalPensionistas->contains($fkPessoalPensionista)) {
            $fkPessoalPensionista->setFkSwCgmPessoaFisica($this);
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
     * Add PessoalServidorConjuge
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorConjuge $fkPessoalServidorConjuge
     * @return SwCgmPessoaFisica
     */
    public function addFkPessoalServidorConjuges(\Urbem\CoreBundle\Entity\Pessoal\ServidorConjuge $fkPessoalServidorConjuge)
    {
        if (false === $this->fkPessoalServidorConjuges->contains($fkPessoalServidorConjuge)) {
            $fkPessoalServidorConjuge->setFkSwCgmPessoaFisica($this);
            $this->fkPessoalServidorConjuges->add($fkPessoalServidorConjuge);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalServidorConjuge
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorConjuge $fkPessoalServidorConjuge
     */
    public function removeFkPessoalServidorConjuges(\Urbem\CoreBundle\Entity\Pessoal\ServidorConjuge $fkPessoalServidorConjuge)
    {
        $this->fkPessoalServidorConjuges->removeElement($fkPessoalServidorConjuge);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalServidorConjuges
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorConjuge
     */
    public function getFkPessoalServidorConjuges()
    {
        return $this->fkPessoalServidorConjuges;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalResponsavelLegal
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ResponsavelLegal $fkPessoalResponsavelLegal
     * @return SwCgmPessoaFisica
     */
    public function addFkPessoalResponsavelLegais(\Urbem\CoreBundle\Entity\Pessoal\ResponsavelLegal $fkPessoalResponsavelLegal)
    {
        if (false === $this->fkPessoalResponsavelLegais->contains($fkPessoalResponsavelLegal)) {
            $fkPessoalResponsavelLegal->setFkSwCgmPessoaFisica($this);
            $this->fkPessoalResponsavelLegais->add($fkPessoalResponsavelLegal);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalResponsavelLegal
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ResponsavelLegal $fkPessoalResponsavelLegal
     */
    public function removeFkPessoalResponsavelLegais(\Urbem\CoreBundle\Entity\Pessoal\ResponsavelLegal $fkPessoalResponsavelLegal)
    {
        $this->fkPessoalResponsavelLegais->removeElement($fkPessoalResponsavelLegal);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalResponsavelLegais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ResponsavelLegal
     */
    public function getFkPessoalResponsavelLegais()
    {
        return $this->fkPessoalResponsavelLegais;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato
     * @return SwCgmPessoaFisica
     */
    public function addFkTcemgContratos(\Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato)
    {
        if (false === $this->fkTcemgContratos->contains($fkTcemgContrato)) {
            $fkTcemgContrato->setFkSwCgmPessoaFisica($this);
            $this->fkTcemgContratos->add($fkTcemgContrato);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato
     */
    public function removeFkTcemgContratos(\Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato)
    {
        $this->fkTcemgContratos->removeElement($fkTcemgContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Contrato
     */
    public function getFkTcemgContratos()
    {
        return $this->fkTcemgContratos;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgRegistroPrecos
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos $fkTcemgRegistroPrecos
     * @return SwCgmPessoaFisica
     */
    public function addFkTcemgRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos $fkTcemgRegistroPrecos)
    {
        if (false === $this->fkTcemgRegistroPrecos->contains($fkTcemgRegistroPrecos)) {
            $fkTcemgRegistroPrecos->setFkSwCgmPessoaFisica($this);
            $this->fkTcemgRegistroPrecos->add($fkTcemgRegistroPrecos);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgRegistroPrecos
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos $fkTcemgRegistroPrecos
     */
    public function removeFkTcemgRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos $fkTcemgRegistroPrecos)
    {
        $this->fkTcemgRegistroPrecos->removeElement($fkTcemgRegistroPrecos);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgRegistroPrecos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos
     */
    public function getFkTcemgRegistroPrecos()
    {
        return $this->fkTcemgRegistroPrecos;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgResplic
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic
     * @return SwCgmPessoaFisica
     */
    public function addFkTcemgResplics(\Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic)
    {
        if (false === $this->fkTcemgResplics->contains($fkTcemgResplic)) {
            $fkTcemgResplic->setFkSwCgmPessoaFisica($this);
            $this->fkTcemgResplics->add($fkTcemgResplic);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgResplic
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic
     */
    public function removeFkTcemgResplics(\Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic)
    {
        $this->fkTcemgResplics->removeElement($fkTcemgResplic);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgResplics
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Resplic
     */
    public function getFkTcemgResplics()
    {
        return $this->fkTcemgResplics;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgResplic
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic
     * @return SwCgmPessoaFisica
     */
    public function addFkTcemgResplics1(\Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic)
    {
        if (false === $this->fkTcemgResplics1->contains($fkTcemgResplic)) {
            $fkTcemgResplic->setFkSwCgmPessoaFisica1($this);
            $this->fkTcemgResplics1->add($fkTcemgResplic);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgResplic
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic
     */
    public function removeFkTcemgResplics1(\Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic)
    {
        $this->fkTcemgResplics1->removeElement($fkTcemgResplic);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgResplics1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Resplic
     */
    public function getFkTcemgResplics1()
    {
        return $this->fkTcemgResplics1;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgResplic
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic
     * @return SwCgmPessoaFisica
     */
    public function addFkTcemgResplics2(\Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic)
    {
        if (false === $this->fkTcemgResplics2->contains($fkTcemgResplic)) {
            $fkTcemgResplic->setFkSwCgmPessoaFisica2($this);
            $this->fkTcemgResplics2->add($fkTcemgResplic);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgResplic
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic
     */
    public function removeFkTcemgResplics2(\Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic)
    {
        $this->fkTcemgResplics2->removeElement($fkTcemgResplic);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgResplics2
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Resplic
     */
    public function getFkTcemgResplics2()
    {
        return $this->fkTcemgResplics2;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgResplic
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic
     * @return SwCgmPessoaFisica
     */
    public function addFkTcemgResplics3(\Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic)
    {
        if (false === $this->fkTcemgResplics3->contains($fkTcemgResplic)) {
            $fkTcemgResplic->setFkSwCgmPessoaFisica3($this);
            $this->fkTcemgResplics3->add($fkTcemgResplic);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgResplic
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic
     */
    public function removeFkTcemgResplics3(\Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic)
    {
        $this->fkTcemgResplics3->removeElement($fkTcemgResplic);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgResplics3
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Resplic
     */
    public function getFkTcemgResplics3()
    {
        return $this->fkTcemgResplics3;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgResplic
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic
     * @return SwCgmPessoaFisica
     */
    public function addFkTcemgResplics4(\Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic)
    {
        if (false === $this->fkTcemgResplics4->contains($fkTcemgResplic)) {
            $fkTcemgResplic->setFkSwCgmPessoaFisica4($this);
            $this->fkTcemgResplics4->add($fkTcemgResplic);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgResplic
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic
     */
    public function removeFkTcemgResplics4(\Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic)
    {
        $this->fkTcemgResplics4->removeElement($fkTcemgResplic);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgResplics4
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Resplic
     */
    public function getFkTcemgResplics4()
    {
        return $this->fkTcemgResplics4;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgResplic
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic
     * @return SwCgmPessoaFisica
     */
    public function addFkTcemgResplics5(\Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic)
    {
        if (false === $this->fkTcemgResplics5->contains($fkTcemgResplic)) {
            $fkTcemgResplic->setFkSwCgmPessoaFisica5($this);
            $this->fkTcemgResplics5->add($fkTcemgResplic);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgResplic
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic
     */
    public function removeFkTcemgResplics5(\Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic)
    {
        $this->fkTcemgResplics5->removeElement($fkTcemgResplic);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgResplics5
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Resplic
     */
    public function getFkTcemgResplics5()
    {
        return $this->fkTcemgResplics5;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgResplic
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic
     * @return SwCgmPessoaFisica
     */
    public function addFkTcemgResplics6(\Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic)
    {
        if (false === $this->fkTcemgResplics6->contains($fkTcemgResplic)) {
            $fkTcemgResplic->setFkSwCgmPessoaFisica6($this);
            $this->fkTcemgResplics6->add($fkTcemgResplic);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgResplic
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic
     */
    public function removeFkTcemgResplics6(\Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic)
    {
        $this->fkTcemgResplics6->removeElement($fkTcemgResplic);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgResplics6
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Resplic
     */
    public function getFkTcemgResplics6()
    {
        return $this->fkTcemgResplics6;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgResplic
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic
     * @return SwCgmPessoaFisica
     */
    public function addFkTcemgResplics7(\Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic)
    {
        if (false === $this->fkTcemgResplics7->contains($fkTcemgResplic)) {
            $fkTcemgResplic->setFkSwCgmPessoaFisica7($this);
            $this->fkTcemgResplics7->add($fkTcemgResplic);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgResplic
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic
     */
    public function removeFkTcemgResplics7(\Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic)
    {
        $this->fkTcemgResplics7->removeElement($fkTcemgResplic);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgResplics7
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Resplic
     */
    public function getFkTcemgResplics7()
    {
        return $this->fkTcemgResplics7;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgResplic
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic
     * @return SwCgmPessoaFisica
     */
    public function addFkTcemgResplics8(\Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic)
    {
        if (false === $this->fkTcemgResplics8->contains($fkTcemgResplic)) {
            $fkTcemgResplic->setFkSwCgmPessoaFisica8($this);
            $this->fkTcemgResplics8->add($fkTcemgResplic);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgResplic
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic
     */
    public function removeFkTcemgResplics8(\Urbem\CoreBundle\Entity\Tcemg\Resplic $fkTcemgResplic)
    {
        $this->fkTcemgResplics8->removeElement($fkTcemgResplic);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgResplics8
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Resplic
     */
    public function getFkTcemgResplics8()
    {
        return $this->fkTcemgResplics8;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeConfiguracaoOrdenador
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoOrdenador $fkTcepeConfiguracaoOrdenador
     * @return SwCgmPessoaFisica
     */
    public function addFkTcepeConfiguracaoOrdenadores(\Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoOrdenador $fkTcepeConfiguracaoOrdenador)
    {
        if (false === $this->fkTcepeConfiguracaoOrdenadores->contains($fkTcepeConfiguracaoOrdenador)) {
            $fkTcepeConfiguracaoOrdenador->setFkSwCgmPessoaFisica($this);
            $this->fkTcepeConfiguracaoOrdenadores->add($fkTcepeConfiguracaoOrdenador);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeConfiguracaoOrdenador
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoOrdenador $fkTcepeConfiguracaoOrdenador
     */
    public function removeFkTcepeConfiguracaoOrdenadores(\Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoOrdenador $fkTcepeConfiguracaoOrdenador)
    {
        $this->fkTcepeConfiguracaoOrdenadores->removeElement($fkTcepeConfiguracaoOrdenador);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeConfiguracaoOrdenadores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoOrdenador
     */
    public function getFkTcepeConfiguracaoOrdenadores()
    {
        return $this->fkTcepeConfiguracaoOrdenadores;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeConfiguracaoGestor
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoGestor $fkTcepeConfiguracaoGestor
     * @return SwCgmPessoaFisica
     */
    public function addFkTcepeConfiguracaoGestores(\Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoGestor $fkTcepeConfiguracaoGestor)
    {
        if (false === $this->fkTcepeConfiguracaoGestores->contains($fkTcepeConfiguracaoGestor)) {
            $fkTcepeConfiguracaoGestor->setFkSwCgmPessoaFisica($this);
            $this->fkTcepeConfiguracaoGestores->add($fkTcepeConfiguracaoGestor);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeConfiguracaoGestor
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoGestor $fkTcepeConfiguracaoGestor
     */
    public function removeFkTcepeConfiguracaoGestores(\Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoGestor $fkTcepeConfiguracaoGestor)
    {
        $this->fkTcepeConfiguracaoGestores->removeElement($fkTcepeConfiguracaoGestor);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeConfiguracaoGestores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoGestor
     */
    public function getFkTcepeConfiguracaoGestores()
    {
        return $this->fkTcepeConfiguracaoGestores;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaConfiguracaoRatificador
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoRatificador $fkTcmbaConfiguracaoRatificador
     * @return SwCgmPessoaFisica
     */
    public function addFkTcmbaConfiguracaoRatificadores(\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoRatificador $fkTcmbaConfiguracaoRatificador)
    {
        if (false === $this->fkTcmbaConfiguracaoRatificadores->contains($fkTcmbaConfiguracaoRatificador)) {
            $fkTcmbaConfiguracaoRatificador->setFkSwCgmPessoaFisica($this);
            $this->fkTcmbaConfiguracaoRatificadores->add($fkTcmbaConfiguracaoRatificador);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaConfiguracaoRatificador
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoRatificador $fkTcmbaConfiguracaoRatificador
     */
    public function removeFkTcmbaConfiguracaoRatificadores(\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoRatificador $fkTcmbaConfiguracaoRatificador)
    {
        $this->fkTcmbaConfiguracaoRatificadores->removeElement($fkTcmbaConfiguracaoRatificador);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaConfiguracaoRatificadores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoRatificador
     */
    public function getFkTcmbaConfiguracaoRatificadores()
    {
        return $this->fkTcmbaConfiguracaoRatificadores;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaObraMedicao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ObraMedicao $fkTcmbaObraMedicao
     * @return SwCgmPessoaFisica
     */
    public function addFkTcmbaObraMedicoes(\Urbem\CoreBundle\Entity\Tcmba\ObraMedicao $fkTcmbaObraMedicao)
    {
        if (false === $this->fkTcmbaObraMedicoes->contains($fkTcmbaObraMedicao)) {
            $fkTcmbaObraMedicao->setFkSwCgmPessoaFisica($this);
            $this->fkTcmbaObraMedicoes->add($fkTcmbaObraMedicao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaObraMedicao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ObraMedicao $fkTcmbaObraMedicao
     */
    public function removeFkTcmbaObraMedicoes(\Urbem\CoreBundle\Entity\Tcmba\ObraMedicao $fkTcmbaObraMedicao)
    {
        $this->fkTcmbaObraMedicoes->removeElement($fkTcmbaObraMedicao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaObraMedicoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ObraMedicao
     */
    public function getFkTcmbaObraMedicoes()
    {
        return $this->fkTcmbaObraMedicoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaObraContratos
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ObraContratos $fkTcmbaObraContratos
     * @return SwCgmPessoaFisica
     */
    public function addFkTcmbaObraContratos(\Urbem\CoreBundle\Entity\Tcmba\ObraContratos $fkTcmbaObraContratos)
    {
        if (false === $this->fkTcmbaObraContratos->contains($fkTcmbaObraContratos)) {
            $fkTcmbaObraContratos->setFkSwCgmPessoaFisica($this);
            $this->fkTcmbaObraContratos->add($fkTcmbaObraContratos);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaObraContratos
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ObraContratos $fkTcmbaObraContratos
     */
    public function removeFkTcmbaObraContratos(\Urbem\CoreBundle\Entity\Tcmba\ObraContratos $fkTcmbaObraContratos)
    {
        $this->fkTcmbaObraContratos->removeElement($fkTcmbaObraContratos);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaObraContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ObraContratos
     */
    public function getFkTcmbaObraContratos()
    {
        return $this->fkTcmbaObraContratos;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoResponsavelLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao
     * @return SwCgmPessoaFisica
     */
    public function addFkTcmgoResponsavelLicitacoes(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao)
    {
        if (false === $this->fkTcmgoResponsavelLicitacoes->contains($fkTcmgoResponsavelLicitacao)) {
            $fkTcmgoResponsavelLicitacao->setFkSwCgmPessoaFisica($this);
            $this->fkTcmgoResponsavelLicitacoes->add($fkTcmgoResponsavelLicitacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoResponsavelLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao
     */
    public function removeFkTcmgoResponsavelLicitacoes(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao)
    {
        $this->fkTcmgoResponsavelLicitacoes->removeElement($fkTcmgoResponsavelLicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoResponsavelLicitacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao
     */
    public function getFkTcmgoResponsavelLicitacoes()
    {
        return $this->fkTcmgoResponsavelLicitacoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoResponsavelLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao
     * @return SwCgmPessoaFisica
     */
    public function addFkTcmgoResponsavelLicitacoes1(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao)
    {
        if (false === $this->fkTcmgoResponsavelLicitacoes1->contains($fkTcmgoResponsavelLicitacao)) {
            $fkTcmgoResponsavelLicitacao->setFkSwCgmPessoaFisica1($this);
            $this->fkTcmgoResponsavelLicitacoes1->add($fkTcmgoResponsavelLicitacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoResponsavelLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao
     */
    public function removeFkTcmgoResponsavelLicitacoes1(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao)
    {
        $this->fkTcmgoResponsavelLicitacoes1->removeElement($fkTcmgoResponsavelLicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoResponsavelLicitacoes1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao
     */
    public function getFkTcmgoResponsavelLicitacoes1()
    {
        return $this->fkTcmgoResponsavelLicitacoes1;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoResponsavelLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao
     * @return SwCgmPessoaFisica
     */
    public function addFkTcmgoResponsavelLicitacoes2(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao)
    {
        if (false === $this->fkTcmgoResponsavelLicitacoes2->contains($fkTcmgoResponsavelLicitacao)) {
            $fkTcmgoResponsavelLicitacao->setFkSwCgmPessoaFisica2($this);
            $this->fkTcmgoResponsavelLicitacoes2->add($fkTcmgoResponsavelLicitacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoResponsavelLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao
     */
    public function removeFkTcmgoResponsavelLicitacoes2(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao)
    {
        $this->fkTcmgoResponsavelLicitacoes2->removeElement($fkTcmgoResponsavelLicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoResponsavelLicitacoes2
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao
     */
    public function getFkTcmgoResponsavelLicitacoes2()
    {
        return $this->fkTcmgoResponsavelLicitacoes2;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoResponsavelLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao
     * @return SwCgmPessoaFisica
     */
    public function addFkTcmgoResponsavelLicitacoes3(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao)
    {
        if (false === $this->fkTcmgoResponsavelLicitacoes3->contains($fkTcmgoResponsavelLicitacao)) {
            $fkTcmgoResponsavelLicitacao->setFkSwCgmPessoaFisica3($this);
            $this->fkTcmgoResponsavelLicitacoes3->add($fkTcmgoResponsavelLicitacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoResponsavelLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao
     */
    public function removeFkTcmgoResponsavelLicitacoes3(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao)
    {
        $this->fkTcmgoResponsavelLicitacoes3->removeElement($fkTcmgoResponsavelLicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoResponsavelLicitacoes3
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao
     */
    public function getFkTcmgoResponsavelLicitacoes3()
    {
        return $this->fkTcmgoResponsavelLicitacoes3;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoResponsavelLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao
     * @return SwCgmPessoaFisica
     */
    public function addFkTcmgoResponsavelLicitacoes4(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao)
    {
        if (false === $this->fkTcmgoResponsavelLicitacoes4->contains($fkTcmgoResponsavelLicitacao)) {
            $fkTcmgoResponsavelLicitacao->setFkSwCgmPessoaFisica4($this);
            $this->fkTcmgoResponsavelLicitacoes4->add($fkTcmgoResponsavelLicitacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoResponsavelLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao
     */
    public function removeFkTcmgoResponsavelLicitacoes4(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao)
    {
        $this->fkTcmgoResponsavelLicitacoes4->removeElement($fkTcmgoResponsavelLicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoResponsavelLicitacoes4
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao
     */
    public function getFkTcmgoResponsavelLicitacoes4()
    {
        return $this->fkTcmgoResponsavelLicitacoes4;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoResponsavelLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao
     * @return SwCgmPessoaFisica
     */
    public function addFkTcmgoResponsavelLicitacoes5(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao)
    {
        if (false === $this->fkTcmgoResponsavelLicitacoes5->contains($fkTcmgoResponsavelLicitacao)) {
            $fkTcmgoResponsavelLicitacao->setFkSwCgmPessoaFisica5($this);
            $this->fkTcmgoResponsavelLicitacoes5->add($fkTcmgoResponsavelLicitacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoResponsavelLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao
     */
    public function removeFkTcmgoResponsavelLicitacoes5(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao)
    {
        $this->fkTcmgoResponsavelLicitacoes5->removeElement($fkTcmgoResponsavelLicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoResponsavelLicitacoes5
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao
     */
    public function getFkTcmgoResponsavelLicitacoes5()
    {
        return $this->fkTcmgoResponsavelLicitacoes5;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoResponsavelLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao
     * @return SwCgmPessoaFisica
     */
    public function addFkTcmgoResponsavelLicitacoes6(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao)
    {
        if (false === $this->fkTcmgoResponsavelLicitacoes6->contains($fkTcmgoResponsavelLicitacao)) {
            $fkTcmgoResponsavelLicitacao->setFkSwCgmPessoaFisica6($this);
            $this->fkTcmgoResponsavelLicitacoes6->add($fkTcmgoResponsavelLicitacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoResponsavelLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao
     */
    public function removeFkTcmgoResponsavelLicitacoes6(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao $fkTcmgoResponsavelLicitacao)
    {
        $this->fkTcmgoResponsavelLicitacoes6->removeElement($fkTcmgoResponsavelLicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoResponsavelLicitacoes6
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacao
     */
    public function getFkTcmgoResponsavelLicitacoes6()
    {
        return $this->fkTcmgoResponsavelLicitacoes6;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return SwCgmPessoaFisica
     */
    public function addFkOrcamentoEntidades(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        if (false === $this->fkOrcamentoEntidades->contains($fkOrcamentoEntidade)) {
            $fkOrcamentoEntidade->setFkSwCgmPessoaFisica($this);
            $this->fkOrcamentoEntidades->add($fkOrcamentoEntidade);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     */
    public function removeFkOrcamentoEntidades(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->fkOrcamentoEntidades->removeElement($fkOrcamentoEntidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoEntidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidades()
    {
        return $this->fkOrcamentoEntidades;
    }

    /**
     * OneToMany (owning side)
     * Add OrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     * @return SwCgmPessoaFisica
     */
    public function addFkOrganogramaOrgoes(\Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao)
    {
        if (false === $this->fkOrganogramaOrgoes->contains($fkOrganogramaOrgao)) {
            $fkOrganogramaOrgao->setFkSwCgmPessoaFisica($this);
            $this->fkOrganogramaOrgoes->add($fkOrganogramaOrgao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     */
    public function removeFkOrganogramaOrgoes(\Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao)
    {
        $this->fkOrganogramaOrgoes->removeElement($fkOrganogramaOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrganogramaOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    public function getFkOrganogramaOrgoes()
    {
        return $this->fkOrganogramaOrgoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgRegistroPrecosOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgao $fkTcemgRegistroPrecosOrgao
     * @return SwCgmPessoaFisica
     */
    public function addFkTcemgRegistroPrecosOrgoes(\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgao $fkTcemgRegistroPrecosOrgao)
    {
        if (false === $this->fkTcemgRegistroPrecosOrgoes->contains($fkTcemgRegistroPrecosOrgao)) {
            $fkTcemgRegistroPrecosOrgao->setFkSwCgmPessoaFisica($this);
            $this->fkTcemgRegistroPrecosOrgoes->add($fkTcemgRegistroPrecosOrgao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgRegistroPrecosOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgao $fkTcemgRegistroPrecosOrgao
     */
    public function removeFkTcemgRegistroPrecosOrgoes(\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgao $fkTcemgRegistroPrecosOrgao)
    {
        $this->fkTcemgRegistroPrecosOrgoes->removeElement($fkTcemgRegistroPrecosOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgRegistroPrecosOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgao
     */
    public function getFkTcemgRegistroPrecosOrgoes()
    {
        return $this->fkTcemgRegistroPrecosOrgoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaConfiguracaoOrdenador
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoOrdenador $fkTcmbaConfiguracaoOrdenador
     * @return SwCgmPessoaFisica
     */
    public function addFkTcmbaConfiguracaoOrdenadores(\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoOrdenador $fkTcmbaConfiguracaoOrdenador)
    {
        if (false === $this->fkTcmbaConfiguracaoOrdenadores->contains($fkTcmbaConfiguracaoOrdenador)) {
            $fkTcmbaConfiguracaoOrdenador->setFkSwCgmPessoaFisica($this);
            $this->fkTcmbaConfiguracaoOrdenadores->add($fkTcmbaConfiguracaoOrdenador);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaConfiguracaoOrdenador
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoOrdenador $fkTcmbaConfiguracaoOrdenador
     */
    public function removeFkTcmbaConfiguracaoOrdenadores(\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoOrdenador $fkTcmbaConfiguracaoOrdenador)
    {
        $this->fkTcmbaConfiguracaoOrdenadores->removeElement($fkTcmbaConfiguracaoOrdenador);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaConfiguracaoOrdenadores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoOrdenador
     */
    public function getFkTcmbaConfiguracaoOrdenadores()
    {
        return $this->fkTcmbaConfiguracaoOrdenadores;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoResponsavelLicitacaoDispensa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa
     * @return SwCgmPessoaFisica
     */
    public function addFkTcmgoResponsavelLicitacaoDispensas(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa)
    {
        if (false === $this->fkTcmgoResponsavelLicitacaoDispensas->contains($fkTcmgoResponsavelLicitacaoDispensa)) {
            $fkTcmgoResponsavelLicitacaoDispensa->setFkSwCgmPessoaFisica($this);
            $this->fkTcmgoResponsavelLicitacaoDispensas->add($fkTcmgoResponsavelLicitacaoDispensa);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoResponsavelLicitacaoDispensa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa
     */
    public function removeFkTcmgoResponsavelLicitacaoDispensas(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa)
    {
        $this->fkTcmgoResponsavelLicitacaoDispensas->removeElement($fkTcmgoResponsavelLicitacaoDispensa);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoResponsavelLicitacaoDispensas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa
     */
    public function getFkTcmgoResponsavelLicitacaoDispensas()
    {
        return $this->fkTcmgoResponsavelLicitacaoDispensas;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoResponsavelLicitacaoDispensa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa
     * @return SwCgmPessoaFisica
     */
    public function addFkTcmgoResponsavelLicitacaoDispensas1(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa)
    {
        if (false === $this->fkTcmgoResponsavelLicitacaoDispensas1->contains($fkTcmgoResponsavelLicitacaoDispensa)) {
            $fkTcmgoResponsavelLicitacaoDispensa->setFkSwCgmPessoaFisica1($this);
            $this->fkTcmgoResponsavelLicitacaoDispensas1->add($fkTcmgoResponsavelLicitacaoDispensa);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoResponsavelLicitacaoDispensa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa
     */
    public function removeFkTcmgoResponsavelLicitacaoDispensas1(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa)
    {
        $this->fkTcmgoResponsavelLicitacaoDispensas1->removeElement($fkTcmgoResponsavelLicitacaoDispensa);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoResponsavelLicitacaoDispensas1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa
     */
    public function getFkTcmgoResponsavelLicitacaoDispensas1()
    {
        return $this->fkTcmgoResponsavelLicitacaoDispensas1;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoResponsavelLicitacaoDispensa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa
     * @return SwCgmPessoaFisica
     */
    public function addFkTcmgoResponsavelLicitacaoDispensas2(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa)
    {
        if (false === $this->fkTcmgoResponsavelLicitacaoDispensas2->contains($fkTcmgoResponsavelLicitacaoDispensa)) {
            $fkTcmgoResponsavelLicitacaoDispensa->setFkSwCgmPessoaFisica2($this);
            $this->fkTcmgoResponsavelLicitacaoDispensas2->add($fkTcmgoResponsavelLicitacaoDispensa);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoResponsavelLicitacaoDispensa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa
     */
    public function removeFkTcmgoResponsavelLicitacaoDispensas2(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa)
    {
        $this->fkTcmgoResponsavelLicitacaoDispensas2->removeElement($fkTcmgoResponsavelLicitacaoDispensa);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoResponsavelLicitacaoDispensas2
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa
     */
    public function getFkTcmgoResponsavelLicitacaoDispensas2()
    {
        return $this->fkTcmgoResponsavelLicitacaoDispensas2;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoResponsavelLicitacaoDispensa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa
     * @return SwCgmPessoaFisica
     */
    public function addFkTcmgoResponsavelLicitacaoDispensas3(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa)
    {
        if (false === $this->fkTcmgoResponsavelLicitacaoDispensas3->contains($fkTcmgoResponsavelLicitacaoDispensa)) {
            $fkTcmgoResponsavelLicitacaoDispensa->setFkSwCgmPessoaFisica3($this);
            $this->fkTcmgoResponsavelLicitacaoDispensas3->add($fkTcmgoResponsavelLicitacaoDispensa);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoResponsavelLicitacaoDispensa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa
     */
    public function removeFkTcmgoResponsavelLicitacaoDispensas3(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa)
    {
        $this->fkTcmgoResponsavelLicitacaoDispensas3->removeElement($fkTcmgoResponsavelLicitacaoDispensa);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoResponsavelLicitacaoDispensas3
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa
     */
    public function getFkTcmgoResponsavelLicitacaoDispensas3()
    {
        return $this->fkTcmgoResponsavelLicitacaoDispensas3;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoResponsavelLicitacaoDispensa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa
     * @return SwCgmPessoaFisica
     */
    public function addFkTcmgoResponsavelLicitacaoDispensas4(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa)
    {
        if (false === $this->fkTcmgoResponsavelLicitacaoDispensas4->contains($fkTcmgoResponsavelLicitacaoDispensa)) {
            $fkTcmgoResponsavelLicitacaoDispensa->setFkSwCgmPessoaFisica4($this);
            $this->fkTcmgoResponsavelLicitacaoDispensas4->add($fkTcmgoResponsavelLicitacaoDispensa);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoResponsavelLicitacaoDispensa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa
     */
    public function removeFkTcmgoResponsavelLicitacaoDispensas4(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa)
    {
        $this->fkTcmgoResponsavelLicitacaoDispensas4->removeElement($fkTcmgoResponsavelLicitacaoDispensa);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoResponsavelLicitacaoDispensas4
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa
     */
    public function getFkTcmgoResponsavelLicitacaoDispensas4()
    {
        return $this->fkTcmgoResponsavelLicitacaoDispensas4;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoResponsavelLicitacaoDispensa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa
     * @return SwCgmPessoaFisica
     */
    public function addFkTcmgoResponsavelLicitacaoDispensas5(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa)
    {
        if (false === $this->fkTcmgoResponsavelLicitacaoDispensas5->contains($fkTcmgoResponsavelLicitacaoDispensa)) {
            $fkTcmgoResponsavelLicitacaoDispensa->setFkSwCgmPessoaFisica5($this);
            $this->fkTcmgoResponsavelLicitacaoDispensas5->add($fkTcmgoResponsavelLicitacaoDispensa);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoResponsavelLicitacaoDispensa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa
     */
    public function removeFkTcmgoResponsavelLicitacaoDispensas5(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa)
    {
        $this->fkTcmgoResponsavelLicitacaoDispensas5->removeElement($fkTcmgoResponsavelLicitacaoDispensa);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoResponsavelLicitacaoDispensas5
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa
     */
    public function getFkTcmgoResponsavelLicitacaoDispensas5()
    {
        return $this->fkTcmgoResponsavelLicitacaoDispensas5;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoResponsavelLicitacaoDispensa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa
     * @return SwCgmPessoaFisica
     */
    public function addFkTcmgoResponsavelLicitacaoDispensas6(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa)
    {
        if (false === $this->fkTcmgoResponsavelLicitacaoDispensas6->contains($fkTcmgoResponsavelLicitacaoDispensa)) {
            $fkTcmgoResponsavelLicitacaoDispensa->setFkSwCgmPessoaFisica6($this);
            $this->fkTcmgoResponsavelLicitacaoDispensas6->add($fkTcmgoResponsavelLicitacaoDispensa);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoResponsavelLicitacaoDispensa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa
     */
    public function removeFkTcmgoResponsavelLicitacaoDispensas6(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa $fkTcmgoResponsavelLicitacaoDispensa)
    {
        $this->fkTcmgoResponsavelLicitacaoDispensas6->removeElement($fkTcmgoResponsavelLicitacaoDispensa);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoResponsavelLicitacaoDispensas6
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelLicitacaoDispensa
     */
    public function getFkTcmgoResponsavelLicitacaoDispensas6()
    {
        return $this->fkTcmgoResponsavelLicitacaoDispensas6;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCategoriaHabilitacao
     *
     * @param \Urbem\CoreBundle\Entity\SwCategoriaHabilitacao $fkSwCategoriaHabilitacao
     * @return SwCgmPessoaFisica
     */
    public function setFkSwCategoriaHabilitacao(\Urbem\CoreBundle\Entity\SwCategoriaHabilitacao $fkSwCategoriaHabilitacao)
    {
        $this->codCategoriaCnh = $fkSwCategoriaHabilitacao->getCodCategoria();
        $this->fkSwCategoriaHabilitacao = $fkSwCategoriaHabilitacao;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCategoriaHabilitacao
     *
     * @return \Urbem\CoreBundle\Entity\SwCategoriaHabilitacao
     */
    public function getFkSwCategoriaHabilitacao()
    {
        return $this->fkSwCategoriaHabilitacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwPais
     *
     * @param \Urbem\CoreBundle\Entity\SwPais $fkSwPais
     * @return SwCgmPessoaFisica
     */
    public function setFkSwPais(\Urbem\CoreBundle\Entity\SwPais $fkSwPais)
    {
        $this->codNacionalidade = $fkSwPais->getCodPais();
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
     * ManyToOne (inverse side)
     * Set fkSwEscolaridade
     *
     * @param \Urbem\CoreBundle\Entity\SwEscolaridade $fkSwEscolaridade
     * @return SwCgmPessoaFisica
     */
    public function setFkSwEscolaridade(\Urbem\CoreBundle\Entity\SwEscolaridade $fkSwEscolaridade)
    {
        $this->codEscolaridade = $fkSwEscolaridade->getCodEscolaridade();
        $this->fkSwEscolaridade = $fkSwEscolaridade;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwEscolaridade
     *
     * @return \Urbem\CoreBundle\Entity\SwEscolaridade
     */
    public function getFkSwEscolaridade()
    {
        return $this->fkSwEscolaridade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwUf
     *
     * @param \Urbem\CoreBundle\Entity\SwUf $fkSwUf
     * @return SwCgmPessoaFisica
     */
    public function setFkSwUf(\Urbem\CoreBundle\Entity\SwUf $fkSwUf)
    {
        $this->codUfOrgaoEmissor = $fkSwUf->getCodUf();
        $this->fkSwUf = $fkSwUf;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwUf
     *
     * @return \Urbem\CoreBundle\Entity\SwUf
     */
    public function getFkSwUf()
    {
        return $this->fkSwUf;
    }

    /**
     * OneToOne (inverse side)
     * Set EstagioEstagiario
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\Estagiario $fkEstagioEstagiario
     * @return SwCgmPessoaFisica
     */
    public function setFkEstagioEstagiario(\Urbem\CoreBundle\Entity\Estagio\Estagiario $fkEstagioEstagiario)
    {
        $fkEstagioEstagiario->setFkSwCgmPessoaFisica($this);
        $this->fkEstagioEstagiario = $fkEstagioEstagiario;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEstagioEstagiario
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\Estagiario
     */
    public function getFkEstagioEstagiario()
    {
        return $this->fkEstagioEstagiario;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Servidor $fkPessoalServidor
     * @return SwCgmPessoaFisica
     */
    public function setFkPessoalServidor(\Urbem\CoreBundle\Entity\Pessoal\Servidor $fkPessoalServidor)
    {
        $fkPessoalServidor->setFkSwCgmPessoaFisica($this);
        $this->fkPessoalServidor = $fkPessoalServidor;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalServidor
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Servidor
     */
    public function getFkPessoalServidor()
    {
        return $this->fkPessoalServidor;
    }

    /**
     * OneToOne (inverse side)
     * Set TcepeCgmAgentePolitico
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\CgmAgentePolitico $fkTcepeCgmAgentePolitico
     * @return SwCgmPessoaFisica
     */
    public function setFkTcepeCgmAgentePolitico(\Urbem\CoreBundle\Entity\Tcepe\CgmAgentePolitico $fkTcepeCgmAgentePolitico)
    {
        $fkTcepeCgmAgentePolitico->setFkSwCgmPessoaFisica($this);
        $this->fkTcepeCgmAgentePolitico = $fkTcepeCgmAgentePolitico;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcepeCgmAgentePolitico
     *
     * @return \Urbem\CoreBundle\Entity\Tcepe\CgmAgentePolitico
     */
    public function getFkTcepeCgmAgentePolitico()
    {
        return $this->fkTcepeCgmAgentePolitico;
    }

    /**
     * OneToOne (owning side)
     * Set SwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return SwCgmPessoaFisica
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (!is_null($this->getFkSwCgm())) {
            return (string) $this->getFkSwCgm();
        }

        return "Pessoa Física";
    }
}
