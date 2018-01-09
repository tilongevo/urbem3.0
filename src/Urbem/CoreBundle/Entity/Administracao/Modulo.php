<?php

namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Modulo
 */
class Modulo
{
    const MODULO_ORGANOGRAMA = 19;
    const MODULO_PATRIMONIAL_ALMOXARIFADO = 29;
    const MODULO_PATRIMONIAL_COMPRAS = 35;
    const MODULO_PATRIMONIAL_LICITACAO = 37;
    const MODULO_ORCAMENTO = 8;
    const MODULO_CONTABILIDADE = 9;
    const MODULO_ADMINISTRATIVO = 2;
    const MODULO_PPA = 43;
    const MODULO_CADASTRO_IMOBILIARIO = 12;
    const MODULO_PROCESSO = 5;
    const MODULO_FROTA = 7;
    const MODULO_ARRECADACAO = 25;
    const MODULO_CADASTRO_ECONOMICO = 14;
    const MODULO_PESSOAL = 22;
    const MODULO_TRANSPARENCIA = 58;
    const MODULO_TESOURARIA = 30;
    const MODULO_FOLHAPAGAMENTO = 27;
    const MODULO_ALMOXARIFADO = 29;
    const MODULO_IMA = 40;
    const MODULO_DIVIDA_ATIVA = 33;
    const MODULO_TCE_RS = 46;
    const MODULO_TCE_MG = 55;
    const MODULO_TCE_PR = 67;
    const MODULO_EMPENHO = 10;
    const MODULO_PLANO_PLURIANUAL = 43;
    const MODULO_STN = 36;

    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * @var integer
     */
    private $codResponsavel = 0;

    /**
     * @var string
     */
    private $nomModulo;

    /**
     * @var string
     */
    private $nomDiretorio;

    /**
     * @var integer
     */
    private $ordem;

    /**
     * @var integer
     */
    private $codGestao;

    /**
     * @var boolean
     */
    private $ativo = true;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\ArrecadacaoModulos
     */
    private $fkArrecadacaoArrecadacaoModulos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\ConfiguracaoEntidade
     */
    private $fkAdministracaoConfiguracaoEntidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Cadastro
     */
    private $fkAdministracaoCadastros;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Biblioteca
     */
    private $fkAdministracaoBibliotecas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Configuracao
     */
    private $fkAdministracaoConfiguracoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Relatorio
     */
    private $fkAdministracaoRelatorios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne
     */
    private $fkArrecadacaoModeloCarnes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Documentodinamico\Documento
     */
    private $fkDocumentodinamicoDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Documentodinamico\TagBase
     */
    private $fkDocumentodinamicoTagBases;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAtributoDinamico
     */
    private $fkSwAtributoDinamicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\AssinaturaModulo
     */
    private $fkAdministracaoAssinaturaModulos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Funcionalidade
     */
    private $fkAdministracaoFuncionalidades;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Gestao
     */
    private $fkAdministracaoGestao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoConfiguracaoEntidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoCadastros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoBibliotecas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoConfiguracoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoRelatorios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoModeloCarnes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDocumentodinamicoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDocumentodinamicoTagBases = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwAtributoDinamicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoAssinaturaModulos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoFuncionalidades = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return Modulo
     */
    public function setCodModulo($codModulo)
    {
        $this->codModulo = $codModulo;
        return $this;
    }

    /**
     * Get codModulo
     *
     * @return integer
     */
    public function getCodModulo()
    {
        return $this->codModulo;
    }

    /**
     * Set codResponsavel
     *
     * @param integer $codResponsavel
     * @return Modulo
     */
    public function setCodResponsavel($codResponsavel)
    {
        $this->codResponsavel = $codResponsavel;
        return $this;
    }

    /**
     * Get codResponsavel
     *
     * @return integer
     */
    public function getCodResponsavel()
    {
        return $this->codResponsavel;
    }

    /**
     * Set nomModulo
     *
     * @param string $nomModulo
     * @return Modulo
     */
    public function setNomModulo($nomModulo)
    {
        $this->nomModulo = $nomModulo;
        return $this;
    }

    /**
     * Get nomModulo
     *
     * @return string
     */
    public function getNomModulo()
    {
        return $this->nomModulo;
    }

    /**
     * Set nomDiretorio
     *
     * @param string $nomDiretorio
     * @return Modulo
     */
    public function setNomDiretorio($nomDiretorio)
    {
        $this->nomDiretorio = $nomDiretorio;
        return $this;
    }

    /**
     * Get nomDiretorio
     *
     * @return string
     */
    public function getNomDiretorio()
    {
        return $this->nomDiretorio;
    }

    /**
     * Set ordem
     *
     * @param integer $ordem
     * @return Modulo
     */
    public function setOrdem($ordem)
    {
        $this->ordem = $ordem;
        return $this;
    }

    /**
     * Get ordem
     *
     * @return integer
     */
    public function getOrdem()
    {
        return $this->ordem;
    }

    /**
     * Set codGestao
     *
     * @param integer $codGestao
     * @return Modulo
     */
    public function setCodGestao($codGestao = null)
    {
        $this->codGestao = $codGestao;
        return $this;
    }

    /**
     * Get codGestao
     *
     * @return integer
     */
    public function getCodGestao()
    {
        return $this->codGestao;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return Modulo
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoConfiguracaoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ConfiguracaoEntidade $fkAdministracaoConfiguracaoEntidade
     * @return Modulo
     */
    public function addFkAdministracaoConfiguracaoEntidades(\Urbem\CoreBundle\Entity\Administracao\ConfiguracaoEntidade $fkAdministracaoConfiguracaoEntidade)
    {
        if (false === $this->fkAdministracaoConfiguracaoEntidades->contains($fkAdministracaoConfiguracaoEntidade)) {
            $fkAdministracaoConfiguracaoEntidade->setFkAdministracaoModulo($this);
            $this->fkAdministracaoConfiguracaoEntidades->add($fkAdministracaoConfiguracaoEntidade);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoConfiguracaoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ConfiguracaoEntidade $fkAdministracaoConfiguracaoEntidade
     */
    public function removeFkAdministracaoConfiguracaoEntidades(\Urbem\CoreBundle\Entity\Administracao\ConfiguracaoEntidade $fkAdministracaoConfiguracaoEntidade)
    {
        $this->fkAdministracaoConfiguracaoEntidades->removeElement($fkAdministracaoConfiguracaoEntidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoConfiguracaoEntidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\ConfiguracaoEntidade
     */
    public function getFkAdministracaoConfiguracaoEntidades()
    {
        return $this->fkAdministracaoConfiguracaoEntidades;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoCadastro
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Cadastro $fkAdministracaoCadastro
     * @return Modulo
     */
    public function addFkAdministracaoCadastros(\Urbem\CoreBundle\Entity\Administracao\Cadastro $fkAdministracaoCadastro)
    {
        if (false === $this->fkAdministracaoCadastros->contains($fkAdministracaoCadastro)) {
            $fkAdministracaoCadastro->setFkAdministracaoModulo($this);
            $this->fkAdministracaoCadastros->add($fkAdministracaoCadastro);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoCadastro
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Cadastro $fkAdministracaoCadastro
     */
    public function removeFkAdministracaoCadastros(\Urbem\CoreBundle\Entity\Administracao\Cadastro $fkAdministracaoCadastro)
    {
        $this->fkAdministracaoCadastros->removeElement($fkAdministracaoCadastro);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoCadastros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Cadastro
     */
    public function getFkAdministracaoCadastros()
    {
        return $this->fkAdministracaoCadastros;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoBiblioteca
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Biblioteca $fkAdministracaoBiblioteca
     * @return Modulo
     */
    public function addFkAdministracaoBibliotecas(\Urbem\CoreBundle\Entity\Administracao\Biblioteca $fkAdministracaoBiblioteca)
    {
        if (false === $this->fkAdministracaoBibliotecas->contains($fkAdministracaoBiblioteca)) {
            $fkAdministracaoBiblioteca->setFkAdministracaoModulo($this);
            $this->fkAdministracaoBibliotecas->add($fkAdministracaoBiblioteca);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoBiblioteca
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Biblioteca $fkAdministracaoBiblioteca
     */
    public function removeFkAdministracaoBibliotecas(\Urbem\CoreBundle\Entity\Administracao\Biblioteca $fkAdministracaoBiblioteca)
    {
        $this->fkAdministracaoBibliotecas->removeElement($fkAdministracaoBiblioteca);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoBibliotecas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Biblioteca
     */
    public function getFkAdministracaoBibliotecas()
    {
        return $this->fkAdministracaoBibliotecas;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoConfiguracao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Configuracao $fkAdministracaoConfiguracao
     * @return Modulo
     */
    public function addFkAdministracaoConfiguracoes(\Urbem\CoreBundle\Entity\Administracao\Configuracao $fkAdministracaoConfiguracao)
    {
        if (false === $this->fkAdministracaoConfiguracoes->contains($fkAdministracaoConfiguracao)) {
            $fkAdministracaoConfiguracao->setFkAdministracaoModulo($this);
            $this->fkAdministracaoConfiguracoes->add($fkAdministracaoConfiguracao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoConfiguracao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Configuracao $fkAdministracaoConfiguracao
     */
    public function removeFkAdministracaoConfiguracoes(\Urbem\CoreBundle\Entity\Administracao\Configuracao $fkAdministracaoConfiguracao)
    {
        $this->fkAdministracaoConfiguracoes->removeElement($fkAdministracaoConfiguracao);
    }

    /**
     * @param null $parameter
     * @param null $year
     * @param bool $previousYear
     * @return \Doctrine\Common\Collections\ArrayCollection|\Doctrine\Common\Collections\Collection|Configuracao
     */
    public function getFkAdministracaoConfiguracoes($parameter = null, $year = null, $previousYear = true)
    {
        if (null !== $parameter || null !== $year) {
            $getConfiguration = function($parameter, $year) {
                return $this->fkAdministracaoConfiguracoes->filter(function (Configuracao $configuration) use ($parameter, $year) {
                    return
                        (null !== $year && (string) $year === (string) $configuration->getExercicio()) &&
                        (null !== $parameter && (string) $parameter === (string) $configuration->getParametro());
                })->first();
            };

            /** @var Configuracao $configuration */
            $configuration = $getConfiguration($parameter, $year);

            if (false === $configuration && true === $previousYear && null !== $year && null !== $parameter) {
                $configuration = $getConfiguration($parameter, (int) $year - 1);

                if (false === $configuration) {
                    $configuration = new Configuracao();
                }

                $newConfiguration = new Configuracao();
                $newConfiguration->setExercicio($year);
                $newConfiguration->setParametro($parameter);
                $newConfiguration->setFkAdministracaoModulo($this);
                $newConfiguration->setValor($configuration->getValor());

                $configuration = $newConfiguration;

                $this->addFkAdministracaoConfiguracoes($configuration);
            }

            return $configuration;
        }

        return $this->fkAdministracaoConfiguracoes;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoRelatorio
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Relatorio $fkAdministracaoRelatorio
     * @return Modulo
     */
    public function addFkAdministracaoRelatorios(\Urbem\CoreBundle\Entity\Administracao\Relatorio $fkAdministracaoRelatorio)
    {
        if (false === $this->fkAdministracaoRelatorios->contains($fkAdministracaoRelatorio)) {
            $fkAdministracaoRelatorio->setFkAdministracaoModulo($this);
            $this->fkAdministracaoRelatorios->add($fkAdministracaoRelatorio);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoRelatorio
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Relatorio $fkAdministracaoRelatorio
     */
    public function removeFkAdministracaoRelatorios(\Urbem\CoreBundle\Entity\Administracao\Relatorio $fkAdministracaoRelatorio)
    {
        $this->fkAdministracaoRelatorios->removeElement($fkAdministracaoRelatorio);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoRelatorios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Relatorio
     */
    public function getFkAdministracaoRelatorios()
    {
        return $this->fkAdministracaoRelatorios;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoModeloCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne $fkArrecadacaoModeloCarne
     * @return Modulo
     */
    public function addFkArrecadacaoModeloCarnes(\Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne $fkArrecadacaoModeloCarne)
    {
        if (false === $this->fkArrecadacaoModeloCarnes->contains($fkArrecadacaoModeloCarne)) {
            $fkArrecadacaoModeloCarne->setFkAdministracaoModulo($this);
            $this->fkArrecadacaoModeloCarnes->add($fkArrecadacaoModeloCarne);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoModeloCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne $fkArrecadacaoModeloCarne
     */
    public function removeFkArrecadacaoModeloCarnes(\Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne $fkArrecadacaoModeloCarne)
    {
        $this->fkArrecadacaoModeloCarnes->removeElement($fkArrecadacaoModeloCarne);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoModeloCarnes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne
     */
    public function getFkArrecadacaoModeloCarnes()
    {
        return $this->fkArrecadacaoModeloCarnes;
    }

    /**
     * OneToMany (owning side)
     * Add DocumentodinamicoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Documentodinamico\Documento $fkDocumentodinamicoDocumento
     * @return Modulo
     */
    public function addFkDocumentodinamicoDocumentos(\Urbem\CoreBundle\Entity\Documentodinamico\Documento $fkDocumentodinamicoDocumento)
    {
        if (false === $this->fkDocumentodinamicoDocumentos->contains($fkDocumentodinamicoDocumento)) {
            $fkDocumentodinamicoDocumento->setFkAdministracaoModulo($this);
            $this->fkDocumentodinamicoDocumentos->add($fkDocumentodinamicoDocumento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DocumentodinamicoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Documentodinamico\Documento $fkDocumentodinamicoDocumento
     */
    public function removeFkDocumentodinamicoDocumentos(\Urbem\CoreBundle\Entity\Documentodinamico\Documento $fkDocumentodinamicoDocumento)
    {
        $this->fkDocumentodinamicoDocumentos->removeElement($fkDocumentodinamicoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkDocumentodinamicoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Documentodinamico\Documento
     */
    public function getFkDocumentodinamicoDocumentos()
    {
        return $this->fkDocumentodinamicoDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add DocumentodinamicoTagBase
     *
     * @param \Urbem\CoreBundle\Entity\Documentodinamico\TagBase $fkDocumentodinamicoTagBase
     * @return Modulo
     */
    public function addFkDocumentodinamicoTagBases(\Urbem\CoreBundle\Entity\Documentodinamico\TagBase $fkDocumentodinamicoTagBase)
    {
        if (false === $this->fkDocumentodinamicoTagBases->contains($fkDocumentodinamicoTagBase)) {
            $fkDocumentodinamicoTagBase->setFkAdministracaoModulo($this);
            $this->fkDocumentodinamicoTagBases->add($fkDocumentodinamicoTagBase);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DocumentodinamicoTagBase
     *
     * @param \Urbem\CoreBundle\Entity\Documentodinamico\TagBase $fkDocumentodinamicoTagBase
     */
    public function removeFkDocumentodinamicoTagBases(\Urbem\CoreBundle\Entity\Documentodinamico\TagBase $fkDocumentodinamicoTagBase)
    {
        $this->fkDocumentodinamicoTagBases->removeElement($fkDocumentodinamicoTagBase);
    }

    /**
     * OneToMany (owning side)
     * Get fkDocumentodinamicoTagBases
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Documentodinamico\TagBase
     */
    public function getFkDocumentodinamicoTagBases()
    {
        return $this->fkDocumentodinamicoTagBases;
    }

    /**
     * OneToMany (owning side)
     * Add SwAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\SwAtributoDinamico $fkSwAtributoDinamico
     * @return Modulo
     */
    public function addFkSwAtributoDinamicos(\Urbem\CoreBundle\Entity\SwAtributoDinamico $fkSwAtributoDinamico)
    {
        if (false === $this->fkSwAtributoDinamicos->contains($fkSwAtributoDinamico)) {
            $fkSwAtributoDinamico->setFkAdministracaoModulo($this);
            $this->fkSwAtributoDinamicos->add($fkSwAtributoDinamico);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\SwAtributoDinamico $fkSwAtributoDinamico
     */
    public function removeFkSwAtributoDinamicos(\Urbem\CoreBundle\Entity\SwAtributoDinamico $fkSwAtributoDinamico)
    {
        $this->fkSwAtributoDinamicos->removeElement($fkSwAtributoDinamico);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwAtributoDinamicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAtributoDinamico
     */
    public function getFkSwAtributoDinamicos()
    {
        return $this->fkSwAtributoDinamicos;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoAssinaturaModulo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AssinaturaModulo $fkAdministracaoAssinaturaModulo
     * @return Modulo
     */
    public function addFkAdministracaoAssinaturaModulos(\Urbem\CoreBundle\Entity\Administracao\AssinaturaModulo $fkAdministracaoAssinaturaModulo)
    {
        if (false === $this->fkAdministracaoAssinaturaModulos->contains($fkAdministracaoAssinaturaModulo)) {
            $fkAdministracaoAssinaturaModulo->setFkAdministracaoModulo($this);
            $this->fkAdministracaoAssinaturaModulos->add($fkAdministracaoAssinaturaModulo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoAssinaturaModulo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AssinaturaModulo $fkAdministracaoAssinaturaModulo
     */
    public function removeFkAdministracaoAssinaturaModulos(\Urbem\CoreBundle\Entity\Administracao\AssinaturaModulo $fkAdministracaoAssinaturaModulo)
    {
        $this->fkAdministracaoAssinaturaModulos->removeElement($fkAdministracaoAssinaturaModulo);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoAssinaturaModulos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\AssinaturaModulo
     */
    public function getFkAdministracaoAssinaturaModulos()
    {
        return $this->fkAdministracaoAssinaturaModulos;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoFuncionalidade
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Funcionalidade $fkAdministracaoFuncionalidade
     * @return Modulo
     */
    public function addFkAdministracaoFuncionalidades(\Urbem\CoreBundle\Entity\Administracao\Funcionalidade $fkAdministracaoFuncionalidade)
    {
        if (false === $this->fkAdministracaoFuncionalidades->contains($fkAdministracaoFuncionalidade)) {
            $fkAdministracaoFuncionalidade->setFkAdministracaoModulo($this);
            $this->fkAdministracaoFuncionalidades->add($fkAdministracaoFuncionalidade);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoFuncionalidade
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Funcionalidade $fkAdministracaoFuncionalidade
     */
    public function removeFkAdministracaoFuncionalidades(\Urbem\CoreBundle\Entity\Administracao\Funcionalidade $fkAdministracaoFuncionalidade)
    {
        $this->fkAdministracaoFuncionalidades->removeElement($fkAdministracaoFuncionalidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoFuncionalidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Funcionalidade
     */
    public function getFkAdministracaoFuncionalidades()
    {
        return $this->fkAdministracaoFuncionalidades;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return Modulo
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->codResponsavel = $fkAdministracaoUsuario->getNumcgm();
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUsuario
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoGestao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Gestao $fkAdministracaoGestao
     * @return Modulo
     */
    public function setFkAdministracaoGestao(\Urbem\CoreBundle\Entity\Administracao\Gestao $fkAdministracaoGestao)
    {
        $this->codGestao = $fkAdministracaoGestao->getCodGestao();
        $this->fkAdministracaoGestao = $fkAdministracaoGestao;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoGestao
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Gestao
     */
    public function getFkAdministracaoGestao()
    {
        return $this->fkAdministracaoGestao;
    }

    /**
     * OneToOne (inverse side)
     * Set ArrecadacaoArrecadacaoModulos
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ArrecadacaoModulos $fkArrecadacaoArrecadacaoModulos
     * @return Modulo
     */
    public function setFkArrecadacaoArrecadacaoModulos(\Urbem\CoreBundle\Entity\Arrecadacao\ArrecadacaoModulos $fkArrecadacaoArrecadacaoModulos)
    {
        $fkArrecadacaoArrecadacaoModulos->setFkAdministracaoModulo($this);
        $this->fkArrecadacaoArrecadacaoModulos = $fkArrecadacaoArrecadacaoModulos;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkArrecadacaoArrecadacaoModulos
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\ArrecadacaoModulos
     */
    public function getFkArrecadacaoArrecadacaoModulos()
    {
        return $this->fkArrecadacaoArrecadacaoModulos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%d - %s', $this->getCodModulo(), $this->getNomModulo());
    }

    /**
     * @return array
     */
    public static function getListModulesAvailable()
    {
        return [
            [
                'title' => 'Patrimonial',
                'name' => 'patrimonio',
                'route' => 'patrimonial',
                'icon'  => 'business'
            ],
            [
                'title' => 'Tributário',
                'name' => 'tributario',
                'route' => 'tributario',
                'icon'  => 'gavel'
            ],
            [
                'title' => 'Financeiro',
                'name' => 'financeiro',
                'route' => 'financeiro',
                'icon'  => 'monetization_on'
            ],
            [
                'title' => 'Administrativo',
                'name' => 'administrativo',
                'route' => 'administrativo',
                'icon'  => 'work'
            ],
            [
                'title' => 'Recursos Humanos',
                'name' => 'rh',
                'route' => 'recursos_humanos',
                'icon'  => 'supervisor_account'
            ],
            [
                'title' => 'Rede Simples',
                'name' => 'rede_simples',
                'route' => 'rede_simples',
                'icon'  => 'refresh',
                'target' => 'blank'
            ],
            [
                'title' => 'Portal do Gestor',
                'name' => 'portal_gestor',
                'route' => 'portal_gestor',
                'icon'  => 'insert_chart'
            ],
            [
                'title' => 'Compras Governamentais',
                'name' => 'compras_governamentais',
                'route' => 'compras_governamentais',
                'icon'  => 'shopping_cart'
            ],
            [
                'title' => 'Prestação de Contas',
                'name' => 'prestacao_contas',
                'route' => 'prestacao_contas',
                'icon'  => 'receipt'
            ]
        ];
    }

    /**
     * @return array
     */
    public static function getListModulesMunicipe()
    {
        return [
            [
                'title' => 'Portal do Cidadão',
                'name' => 'portal_servicos',
                'route' => 'home-portalservicos',
                'icon'  => 'face'
            ]
        ];
    }
}
