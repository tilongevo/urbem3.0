<?php

namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ContratoServidor
 */
class ContratoServidor
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var integer
     */
    private $codTipoPagamento;

    /**
     * @var integer
     */
    private $codTipoSalario;

    /**
     * @var integer
     */
    private $codTipoAdmissao;

    /**
     * @var integer
     */
    private $codCategoria;

    /**
     * @var integer
     */
    private $codVinculo;

    /**
     * @var integer
     */
    private $codCargo;

    /**
     * @var integer
     */
    private $codRegime;

    /**
     * @var integer
     */
    private $codSubDivisao;

    /**
     * @var string
     */
    private $nrCartaoPonto;

    /**
     * @var boolean
     */
    private $ativo;

    /**
     * @var \DateTime
     */
    private $dtOpcaoFgts;

    /**
     * @var boolean
     */
    private $adiantamento;

    /**
     * @var integer
     */
    private $codGrade;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausa
     */
    private $fkPessoalContratoServidorCasoCausa;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCedencia
     */
    private $fkPessoalContratoServidorCedencia;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorConselho
     */
    private $fkPessoalContratoServidorConselho;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaFgts
     */
    private $fkPessoalContratoServidorContaFgts;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSindicato
     */
    private $fkPessoalContratoServidorSindicato;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaSalario
     */
    private $fkPessoalContratoServidorContaSalario;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    private $fkPessoalContrato;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\ContratoServidorGrupoConcessaoValeTransporte
     */
    private $fkBeneficioContratoServidorGrupoConcessaoValeTransportes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\ContratoServidorConcessaoValeTransporte
     */
    private $fkBeneficioContratoServidorConcessaoValeTransportes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Aposentadoria
     */
    private $fkPessoalAposentadorias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AdidoCedido
     */
    private $fkPessoalAdidoCedidos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AtributoContratoServidorValor
     */
    private $fkPessoalAtributoContratoServidorValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeFuncao
     */
    private $fkPessoalContratoServidorEspecialidadeFuncoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeCargo
     */
    private $fkPessoalContratoServidorEspecialidadeCargos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorExameMedico
     */
    private $fkPessoalContratoServidorExameMedicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaSalarioHistorico
     */
    private $fkPessoalContratoServidorContaSalarioHistoricos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorHistoricoFuncional
     */
    private $fkPessoalContratoServidorHistoricoFuncionais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFuncao
     */
    private $fkPessoalContratoServidorFuncoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorInicioProgressao
     */
    private $fkPessoalContratoServidorInicioProgressoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNivelPadrao
     */
    private $fkPessoalContratoServidorNivelPadroes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocal
     */
    private $fkPessoalContratoServidorLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPrevidencia
     */
    private $fkPessoalContratoServidorPrevidencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOrgao
     */
    private $fkPessoalContratoServidorOrgoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNomeacaoPosse
     */
    private $fkPessoalContratoServidorNomeacaoPosses;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOcorrencia
     */
    private $fkPessoalContratoServidorOcorrencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorRegimeFuncao
     */
    private $fkPessoalContratoServidorRegimeFuncoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSalario
     */
    private $fkPessoalContratoServidorSalarios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSubDivisaoFuncao
     */
    private $fkPessoalContratoServidorSubDivisaoFuncoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorValetransporte
     */
    private $fkPessoalContratoServidorValetransportes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Ferias
     */
    private $fkPessoalFerias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Pensionista
     */
    private $fkPessoalPensionistas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorContratoServidor
     */
    private $fkPessoalServidorContratoServidores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFormaPagamento
     */
    private $fkPessoalContratoServidorFormaPagamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocalHistorico
     */
    private $fkPessoalContratoServidorLocalHistoricos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPadrao
     */
    private $fkPessoalContratoServidorPadroes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\TipoPagamento
     */
    private $fkPessoalTipoPagamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\TipoAdmissao
     */
    private $fkPessoalTipoAdmissao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Categoria
     */
    private $fkPessoalCategoria;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\VinculoEmpregaticio
     */
    private $fkPessoalVinculoEmpregaticio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Cargo
     */
    private $fkPessoalCargo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Regime
     */
    private $fkPessoalRegime;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\SubDivisao
     */
    private $fkPessoalSubDivisao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\GradeHorario
     */
    private $fkPessoalGradeHorario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkBeneficioContratoServidorGrupoConcessaoValeTransportes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkBeneficioContratoServidorConcessaoValeTransportes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalAposentadorias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalAdidoCedidos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalAtributoContratoServidorValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorEspecialidadeFuncoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorEspecialidadeCargos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorExameMedicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorContaSalarioHistoricos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorHistoricoFuncionais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorFuncoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorInicioProgressoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorNivelPadroes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorPrevidencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorNomeacaoPosses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorOcorrencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorRegimeFuncoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorSalarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorSubDivisaoFuncoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorValetransportes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalFerias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalPensionistas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalServidorContratoServidores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorFormaPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorLocalHistoricos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorPadroes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoServidor
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return ContratoServidor
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set codTipoPagamento
     *
     * @param integer $codTipoPagamento
     * @return ContratoServidor
     */
    public function setCodTipoPagamento($codTipoPagamento)
    {
        $this->codTipoPagamento = $codTipoPagamento;
        return $this;
    }

    /**
     * Get codTipoPagamento
     *
     * @return integer
     */
    public function getCodTipoPagamento()
    {
        return $this->codTipoPagamento;
    }

    /**
     * Set codTipoSalario
     *
     * @param integer $codTipoSalario
     * @return ContratoServidor
     */
    public function setCodTipoSalario($codTipoSalario)
    {
        $this->codTipoSalario = $codTipoSalario;
        return $this;
    }

    /**
     * Get codTipoSalario
     *
     * @return integer
     */
    public function getCodTipoSalario()
    {
        return $this->codTipoSalario;
    }

    /**
     * Set codTipoAdmissao
     *
     * @param integer $codTipoAdmissao
     * @return ContratoServidor
     */
    public function setCodTipoAdmissao($codTipoAdmissao)
    {
        $this->codTipoAdmissao = $codTipoAdmissao;
        return $this;
    }

    /**
     * Get codTipoAdmissao
     *
     * @return integer
     */
    public function getCodTipoAdmissao()
    {
        return $this->codTipoAdmissao;
    }

    /**
     * Set codCategoria
     *
     * @param integer $codCategoria
     * @return ContratoServidor
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
     * Set codVinculo
     *
     * @param integer $codVinculo
     * @return ContratoServidor
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
     * Set codCargo
     *
     * @param integer $codCargo
     * @return ContratoServidor
     */
    public function setCodCargo($codCargo)
    {
        $this->codCargo = $codCargo;
        return $this;
    }

    /**
     * Get codCargo
     *
     * @return integer
     */
    public function getCodCargo()
    {
        return $this->codCargo;
    }

    /**
     * Set codRegime
     *
     * @param integer $codRegime
     * @return ContratoServidor
     */
    public function setCodRegime($codRegime)
    {
        $this->codRegime = $codRegime;
        return $this;
    }

    /**
     * Get codRegime
     *
     * @return integer
     */
    public function getCodRegime()
    {
        return $this->codRegime;
    }

    /**
     * Set codSubDivisao
     *
     * @param integer $codSubDivisao
     * @return ContratoServidor
     */
    public function setCodSubDivisao($codSubDivisao)
    {
        $this->codSubDivisao = $codSubDivisao;
        return $this;
    }

    /**
     * Get codSubDivisao
     *
     * @return integer
     */
    public function getCodSubDivisao()
    {
        return $this->codSubDivisao;
    }

    /**
     * Set nrCartaoPonto
     *
     * @param string $nrCartaoPonto
     * @return ContratoServidor
     */
    public function setNrCartaoPonto($nrCartaoPonto = null)
    {
        $this->nrCartaoPonto = $nrCartaoPonto;
        return $this;
    }

    /**
     * Get nrCartaoPonto
     *
     * @return string
     */
    public function getNrCartaoPonto()
    {
        return $this->nrCartaoPonto;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return ContratoServidor
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
     * Set dtOpcaoFgts
     *
     * @param \DateTime $dtOpcaoFgts
     * @return ContratoServidor
     */
    public function setDtOpcaoFgts(\DateTime $dtOpcaoFgts = null)
    {
        $this->dtOpcaoFgts = $dtOpcaoFgts;
        return $this;
    }

    /**
     * Get dtOpcaoFgts
     *
     * @return \DateTime
     */
    public function getDtOpcaoFgts()
    {
        return $this->dtOpcaoFgts;
    }

    /**
     * Set adiantamento
     *
     * @param boolean $adiantamento
     * @return ContratoServidor
     */
    public function setAdiantamento($adiantamento)
    {
        $this->adiantamento = $adiantamento;
        return $this;
    }

    /**
     * Get adiantamento
     *
     * @return boolean
     */
    public function getAdiantamento()
    {
        return $this->adiantamento;
    }

    /**
     * Set codGrade
     *
     * @param integer $codGrade
     * @return ContratoServidor
     */
    public function setCodGrade($codGrade)
    {
        $this->codGrade = $codGrade;
        return $this;
    }

    /**
     * Get codGrade
     *
     * @return integer
     */
    public function getCodGrade()
    {
        return $this->codGrade;
    }

    /**
     * OneToMany (owning side)
     * Add BeneficioContratoServidorGrupoConcessaoValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ContratoServidorGrupoConcessaoValeTransporte $fkBeneficioContratoServidorGrupoConcessaoValeTransporte
     * @return ContratoServidor
     */
    public function addFkBeneficioContratoServidorGrupoConcessaoValeTransportes(\Urbem\CoreBundle\Entity\Beneficio\ContratoServidorGrupoConcessaoValeTransporte $fkBeneficioContratoServidorGrupoConcessaoValeTransporte)
    {
        if (false === $this->fkBeneficioContratoServidorGrupoConcessaoValeTransportes->contains($fkBeneficioContratoServidorGrupoConcessaoValeTransporte)) {
            $fkBeneficioContratoServidorGrupoConcessaoValeTransporte->setFkPessoalContratoServidor($this);
            $this->fkBeneficioContratoServidorGrupoConcessaoValeTransportes->add($fkBeneficioContratoServidorGrupoConcessaoValeTransporte);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioContratoServidorGrupoConcessaoValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ContratoServidorGrupoConcessaoValeTransporte $fkBeneficioContratoServidorGrupoConcessaoValeTransporte
     */
    public function removeFkBeneficioContratoServidorGrupoConcessaoValeTransportes(\Urbem\CoreBundle\Entity\Beneficio\ContratoServidorGrupoConcessaoValeTransporte $fkBeneficioContratoServidorGrupoConcessaoValeTransporte)
    {
        $this->fkBeneficioContratoServidorGrupoConcessaoValeTransportes->removeElement($fkBeneficioContratoServidorGrupoConcessaoValeTransporte);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioContratoServidorGrupoConcessaoValeTransportes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\ContratoServidorGrupoConcessaoValeTransporte
     */
    public function getFkBeneficioContratoServidorGrupoConcessaoValeTransportes()
    {
        return $this->fkBeneficioContratoServidorGrupoConcessaoValeTransportes;
    }

    /**
     * OneToMany (owning side)
     * Add BeneficioContratoServidorConcessaoValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ContratoServidorConcessaoValeTransporte $fkBeneficioContratoServidorConcessaoValeTransporte
     * @return ContratoServidor
     */
    public function addFkBeneficioContratoServidorConcessaoValeTransportes(\Urbem\CoreBundle\Entity\Beneficio\ContratoServidorConcessaoValeTransporte $fkBeneficioContratoServidorConcessaoValeTransporte)
    {
        if (false === $this->fkBeneficioContratoServidorConcessaoValeTransportes->contains($fkBeneficioContratoServidorConcessaoValeTransporte)) {
            $fkBeneficioContratoServidorConcessaoValeTransporte->setFkPessoalContratoServidor($this);
            $this->fkBeneficioContratoServidorConcessaoValeTransportes->add($fkBeneficioContratoServidorConcessaoValeTransporte);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioContratoServidorConcessaoValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ContratoServidorConcessaoValeTransporte $fkBeneficioContratoServidorConcessaoValeTransporte
     */
    public function removeFkBeneficioContratoServidorConcessaoValeTransportes(\Urbem\CoreBundle\Entity\Beneficio\ContratoServidorConcessaoValeTransporte $fkBeneficioContratoServidorConcessaoValeTransporte)
    {
        $this->fkBeneficioContratoServidorConcessaoValeTransportes->removeElement($fkBeneficioContratoServidorConcessaoValeTransporte);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioContratoServidorConcessaoValeTransportes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\ContratoServidorConcessaoValeTransporte
     */
    public function getFkBeneficioContratoServidorConcessaoValeTransportes()
    {
        return $this->fkBeneficioContratoServidorConcessaoValeTransportes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAposentadoria
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Aposentadoria $fkPessoalAposentadoria
     * @return ContratoServidor
     */
    public function addFkPessoalAposentadorias(\Urbem\CoreBundle\Entity\Pessoal\Aposentadoria $fkPessoalAposentadoria)
    {
        if (false === $this->fkPessoalAposentadorias->contains($fkPessoalAposentadoria)) {
            $fkPessoalAposentadoria->setFkPessoalContratoServidor($this);
            $this->fkPessoalAposentadorias->add($fkPessoalAposentadoria);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAposentadoria
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Aposentadoria $fkPessoalAposentadoria
     */
    public function removeFkPessoalAposentadorias(\Urbem\CoreBundle\Entity\Pessoal\Aposentadoria $fkPessoalAposentadoria)
    {
        $this->fkPessoalAposentadorias->removeElement($fkPessoalAposentadoria);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAposentadorias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Aposentadoria
     */
    public function getFkPessoalAposentadorias()
    {
        return $this->fkPessoalAposentadorias;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAdidoCedido
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AdidoCedido $fkPessoalAdidoCedido
     * @return ContratoServidor
     */
    public function addFkPessoalAdidoCedidos(\Urbem\CoreBundle\Entity\Pessoal\AdidoCedido $fkPessoalAdidoCedido)
    {
        if (false === $this->fkPessoalAdidoCedidos->contains($fkPessoalAdidoCedido)) {
            $fkPessoalAdidoCedido->setFkPessoalContratoServidor($this);
            $this->fkPessoalAdidoCedidos->add($fkPessoalAdidoCedido);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAdidoCedido
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AdidoCedido $fkPessoalAdidoCedido
     */
    public function removeFkPessoalAdidoCedidos(\Urbem\CoreBundle\Entity\Pessoal\AdidoCedido $fkPessoalAdidoCedido)
    {
        $this->fkPessoalAdidoCedidos->removeElement($fkPessoalAdidoCedido);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAdidoCedidos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AdidoCedido
     */
    public function getFkPessoalAdidoCedidos()
    {
        return $this->fkPessoalAdidoCedidos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAtributoContratoServidorValor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AtributoContratoServidorValor $fkPessoalAtributoContratoServidorValor
     * @return ContratoServidor
     */
    public function addFkPessoalAtributoContratoServidorValores(\Urbem\CoreBundle\Entity\Pessoal\AtributoContratoServidorValor $fkPessoalAtributoContratoServidorValor)
    {
        if (false === $this->fkPessoalAtributoContratoServidorValores->contains($fkPessoalAtributoContratoServidorValor)) {
            $fkPessoalAtributoContratoServidorValor->setFkPessoalContratoServidor($this);
            $this->fkPessoalAtributoContratoServidorValores->add($fkPessoalAtributoContratoServidorValor);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAtributoContratoServidorValor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AtributoContratoServidorValor $fkPessoalAtributoContratoServidorValor
     */
    public function removeFkPessoalAtributoContratoServidorValores(\Urbem\CoreBundle\Entity\Pessoal\AtributoContratoServidorValor $fkPessoalAtributoContratoServidorValor)
    {
        $this->fkPessoalAtributoContratoServidorValores->removeElement($fkPessoalAtributoContratoServidorValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAtributoContratoServidorValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AtributoContratoServidorValor
     */
    public function getFkPessoalAtributoContratoServidorValores()
    {
        return $this->fkPessoalAtributoContratoServidorValores;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorEspecialidadeFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeFuncao $fkPessoalContratoServidorEspecialidadeFuncao
     * @return ContratoServidor
     */
    public function addFkPessoalContratoServidorEspecialidadeFuncoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeFuncao $fkPessoalContratoServidorEspecialidadeFuncao)
    {
        if (false === $this->fkPessoalContratoServidorEspecialidadeFuncoes->contains($fkPessoalContratoServidorEspecialidadeFuncao)) {
            $fkPessoalContratoServidorEspecialidadeFuncao->setFkPessoalContratoServidor($this);
            $this->fkPessoalContratoServidorEspecialidadeFuncoes->add($fkPessoalContratoServidorEspecialidadeFuncao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorEspecialidadeFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeFuncao $fkPessoalContratoServidorEspecialidadeFuncao
     */
    public function removeFkPessoalContratoServidorEspecialidadeFuncoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeFuncao $fkPessoalContratoServidorEspecialidadeFuncao)
    {
        $this->fkPessoalContratoServidorEspecialidadeFuncoes->removeElement($fkPessoalContratoServidorEspecialidadeFuncao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorEspecialidadeFuncoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeFuncao
     */
    public function getFkPessoalContratoServidorEspecialidadeFuncoes()
    {
        return $this->fkPessoalContratoServidorEspecialidadeFuncoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorEspecialidadeCargo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeCargo $fkPessoalContratoServidorEspecialidadeCargo
     * @return ContratoServidor
     */
    public function addFkPessoalContratoServidorEspecialidadeCargos(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeCargo $fkPessoalContratoServidorEspecialidadeCargo)
    {
        if (false === $this->fkPessoalContratoServidorEspecialidadeCargos->contains($fkPessoalContratoServidorEspecialidadeCargo)) {
            $fkPessoalContratoServidorEspecialidadeCargo->setFkPessoalContratoServidor($this);
            $this->fkPessoalContratoServidorEspecialidadeCargos->add($fkPessoalContratoServidorEspecialidadeCargo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorEspecialidadeCargo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeCargo $fkPessoalContratoServidorEspecialidadeCargo
     */
    public function removeFkPessoalContratoServidorEspecialidadeCargos(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeCargo $fkPessoalContratoServidorEspecialidadeCargo)
    {
        $this->fkPessoalContratoServidorEspecialidadeCargos->removeElement($fkPessoalContratoServidorEspecialidadeCargo);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorEspecialidadeCargos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeCargo
     */
    public function getFkPessoalContratoServidorEspecialidadeCargos()
    {
        return $this->fkPessoalContratoServidorEspecialidadeCargos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorExameMedico
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorExameMedico $fkPessoalContratoServidorExameMedico
     * @return ContratoServidor
     */
    public function addFkPessoalContratoServidorExameMedicos(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorExameMedico $fkPessoalContratoServidorExameMedico)
    {
        if (false === $this->fkPessoalContratoServidorExameMedicos->contains($fkPessoalContratoServidorExameMedico)) {
            $fkPessoalContratoServidorExameMedico->setFkPessoalContratoServidor($this);
            $this->fkPessoalContratoServidorExameMedicos->add($fkPessoalContratoServidorExameMedico);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorExameMedico
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorExameMedico $fkPessoalContratoServidorExameMedico
     */
    public function removeFkPessoalContratoServidorExameMedicos(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorExameMedico $fkPessoalContratoServidorExameMedico)
    {
        $this->fkPessoalContratoServidorExameMedicos->removeElement($fkPessoalContratoServidorExameMedico);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorExameMedicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorExameMedico
     */
    public function getFkPessoalContratoServidorExameMedicos()
    {
        return $this->fkPessoalContratoServidorExameMedicos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorContaSalarioHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaSalarioHistorico $fkPessoalContratoServidorContaSalarioHistorico
     * @return ContratoServidor
     */
    public function addFkPessoalContratoServidorContaSalarioHistoricos(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaSalarioHistorico $fkPessoalContratoServidorContaSalarioHistorico)
    {
        if (false === $this->fkPessoalContratoServidorContaSalarioHistoricos->contains($fkPessoalContratoServidorContaSalarioHistorico)) {
            $fkPessoalContratoServidorContaSalarioHistorico->setFkPessoalContratoServidor($this);
            $this->fkPessoalContratoServidorContaSalarioHistoricos->add($fkPessoalContratoServidorContaSalarioHistorico);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorContaSalarioHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaSalarioHistorico $fkPessoalContratoServidorContaSalarioHistorico
     */
    public function removeFkPessoalContratoServidorContaSalarioHistoricos(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaSalarioHistorico $fkPessoalContratoServidorContaSalarioHistorico)
    {
        $this->fkPessoalContratoServidorContaSalarioHistoricos->removeElement($fkPessoalContratoServidorContaSalarioHistorico);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorContaSalarioHistoricos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaSalarioHistorico
     */
    public function getFkPessoalContratoServidorContaSalarioHistoricos()
    {
        return $this->fkPessoalContratoServidorContaSalarioHistoricos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorHistoricoFuncional
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorHistoricoFuncional $fkPessoalContratoServidorHistoricoFuncional
     * @return ContratoServidor
     */
    public function addFkPessoalContratoServidorHistoricoFuncionais(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorHistoricoFuncional $fkPessoalContratoServidorHistoricoFuncional)
    {
        if (false === $this->fkPessoalContratoServidorHistoricoFuncionais->contains($fkPessoalContratoServidorHistoricoFuncional)) {
            $fkPessoalContratoServidorHistoricoFuncional->setFkPessoalContratoServidor($this);
            $this->fkPessoalContratoServidorHistoricoFuncionais->add($fkPessoalContratoServidorHistoricoFuncional);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorHistoricoFuncional
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorHistoricoFuncional $fkPessoalContratoServidorHistoricoFuncional
     */
    public function removeFkPessoalContratoServidorHistoricoFuncionais(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorHistoricoFuncional $fkPessoalContratoServidorHistoricoFuncional)
    {
        $this->fkPessoalContratoServidorHistoricoFuncionais->removeElement($fkPessoalContratoServidorHistoricoFuncional);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorHistoricoFuncionais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorHistoricoFuncional
     */
    public function getFkPessoalContratoServidorHistoricoFuncionais()
    {
        return $this->fkPessoalContratoServidorHistoricoFuncionais;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFuncao $fkPessoalContratoServidorFuncao
     * @return ContratoServidor
     */
    public function addFkPessoalContratoServidorFuncoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFuncao $fkPessoalContratoServidorFuncao)
    {
        if (false === $this->fkPessoalContratoServidorFuncoes->contains($fkPessoalContratoServidorFuncao)) {
            $fkPessoalContratoServidorFuncao->setFkPessoalContratoServidor($this);
            $this->fkPessoalContratoServidorFuncoes->add($fkPessoalContratoServidorFuncao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFuncao $fkPessoalContratoServidorFuncao
     */
    public function removeFkPessoalContratoServidorFuncoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFuncao $fkPessoalContratoServidorFuncao)
    {
        $this->fkPessoalContratoServidorFuncoes->removeElement($fkPessoalContratoServidorFuncao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorFuncoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFuncao
     */
    public function getFkPessoalContratoServidorFuncoes()
    {
        return $this->fkPessoalContratoServidorFuncoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorInicioProgressao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorInicioProgressao $fkPessoalContratoServidorInicioProgressao
     * @return ContratoServidor
     */
    public function addFkPessoalContratoServidorInicioProgressoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorInicioProgressao $fkPessoalContratoServidorInicioProgressao)
    {
        if (false === $this->fkPessoalContratoServidorInicioProgressoes->contains($fkPessoalContratoServidorInicioProgressao)) {
            $fkPessoalContratoServidorInicioProgressao->setFkPessoalContratoServidor($this);
            $this->fkPessoalContratoServidorInicioProgressoes->add($fkPessoalContratoServidorInicioProgressao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorInicioProgressao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorInicioProgressao $fkPessoalContratoServidorInicioProgressao
     */
    public function removeFkPessoalContratoServidorInicioProgressoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorInicioProgressao $fkPessoalContratoServidorInicioProgressao)
    {
        $this->fkPessoalContratoServidorInicioProgressoes->removeElement($fkPessoalContratoServidorInicioProgressao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorInicioProgressoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorInicioProgressao
     */
    public function getFkPessoalContratoServidorInicioProgressoes()
    {
        return $this->fkPessoalContratoServidorInicioProgressoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorNivelPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNivelPadrao $fkPessoalContratoServidorNivelPadrao
     * @return ContratoServidor
     */
    public function addFkPessoalContratoServidorNivelPadroes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNivelPadrao $fkPessoalContratoServidorNivelPadrao)
    {
        if (false === $this->fkPessoalContratoServidorNivelPadroes->contains($fkPessoalContratoServidorNivelPadrao)) {
            $fkPessoalContratoServidorNivelPadrao->setFkPessoalContratoServidor($this);
            $this->fkPessoalContratoServidorNivelPadroes->add($fkPessoalContratoServidorNivelPadrao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorNivelPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNivelPadrao $fkPessoalContratoServidorNivelPadrao
     */
    public function removeFkPessoalContratoServidorNivelPadroes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNivelPadrao $fkPessoalContratoServidorNivelPadrao)
    {
        $this->fkPessoalContratoServidorNivelPadroes->removeElement($fkPessoalContratoServidorNivelPadrao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorNivelPadroes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNivelPadrao
     */
    public function getFkPessoalContratoServidorNivelPadroes()
    {
        return $this->fkPessoalContratoServidorNivelPadroes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorLocal
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocal $fkPessoalContratoServidorLocal
     * @return ContratoServidor
     */
    public function addFkPessoalContratoServidorLocais(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocal $fkPessoalContratoServidorLocal)
    {
        if (false === $this->fkPessoalContratoServidorLocais->contains($fkPessoalContratoServidorLocal)) {
            $fkPessoalContratoServidorLocal->setFkPessoalContratoServidor($this);
            $this->fkPessoalContratoServidorLocais->add($fkPessoalContratoServidorLocal);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorLocal
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocal $fkPessoalContratoServidorLocal
     */
    public function removeFkPessoalContratoServidorLocais(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocal $fkPessoalContratoServidorLocal)
    {
        $this->fkPessoalContratoServidorLocais->removeElement($fkPessoalContratoServidorLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocal
     */
    public function getFkPessoalContratoServidorLocais()
    {
        return $this->fkPessoalContratoServidorLocais;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPrevidencia $fkPessoalContratoServidorPrevidencia
     * @return ContratoServidor
     */
    public function addFkPessoalContratoServidorPrevidencias(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPrevidencia $fkPessoalContratoServidorPrevidencia)
    {
        if (false === $this->fkPessoalContratoServidorPrevidencias->contains($fkPessoalContratoServidorPrevidencia)) {
            $fkPessoalContratoServidorPrevidencia->setFkPessoalContratoServidor($this);
            $this->fkPessoalContratoServidorPrevidencias->add($fkPessoalContratoServidorPrevidencia);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPrevidencia $fkPessoalContratoServidorPrevidencia
     */
    public function removeFkPessoalContratoServidorPrevidencias(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPrevidencia $fkPessoalContratoServidorPrevidencia)
    {
        $this->fkPessoalContratoServidorPrevidencias->removeElement($fkPessoalContratoServidorPrevidencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorPrevidencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPrevidencia
     */
    public function getFkPessoalContratoServidorPrevidencias()
    {
        return $this->fkPessoalContratoServidorPrevidencias;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOrgao $fkPessoalContratoServidorOrgao
     * @return ContratoServidor
     */
    public function addFkPessoalContratoServidorOrgoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOrgao $fkPessoalContratoServidorOrgao)
    {
        if (false === $this->fkPessoalContratoServidorOrgoes->contains($fkPessoalContratoServidorOrgao)) {
            $fkPessoalContratoServidorOrgao->setFkPessoalContratoServidor($this);
            $this->fkPessoalContratoServidorOrgoes->add($fkPessoalContratoServidorOrgao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOrgao $fkPessoalContratoServidorOrgao
     */
    public function removeFkPessoalContratoServidorOrgoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOrgao $fkPessoalContratoServidorOrgao)
    {
        $this->fkPessoalContratoServidorOrgoes->removeElement($fkPessoalContratoServidorOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOrgao
     */
    public function getFkPessoalContratoServidorOrgoes()
    {
        return $this->fkPessoalContratoServidorOrgoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorNomeacaoPosse
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNomeacaoPosse $fkPessoalContratoServidorNomeacaoPosse
     * @return ContratoServidor
     */
    public function addFkPessoalContratoServidorNomeacaoPosses(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNomeacaoPosse $fkPessoalContratoServidorNomeacaoPosse)
    {
        if (false === $this->fkPessoalContratoServidorNomeacaoPosses->contains($fkPessoalContratoServidorNomeacaoPosse)) {
            $fkPessoalContratoServidorNomeacaoPosse->setFkPessoalContratoServidor($this);
            $this->fkPessoalContratoServidorNomeacaoPosses->add($fkPessoalContratoServidorNomeacaoPosse);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorNomeacaoPosse
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNomeacaoPosse $fkPessoalContratoServidorNomeacaoPosse
     */
    public function removeFkPessoalContratoServidorNomeacaoPosses(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNomeacaoPosse $fkPessoalContratoServidorNomeacaoPosse)
    {
        $this->fkPessoalContratoServidorNomeacaoPosses->removeElement($fkPessoalContratoServidorNomeacaoPosse);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorNomeacaoPosses
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNomeacaoPosse
     */
    public function getFkPessoalContratoServidorNomeacaoPosses()
    {
        return $this->fkPessoalContratoServidorNomeacaoPosses;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorOcorrencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOcorrencia $fkPessoalContratoServidorOcorrencia
     * @return ContratoServidor
     */
    public function addFkPessoalContratoServidorOcorrencias(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOcorrencia $fkPessoalContratoServidorOcorrencia)
    {
        if (false === $this->fkPessoalContratoServidorOcorrencias->contains($fkPessoalContratoServidorOcorrencia)) {
            $fkPessoalContratoServidorOcorrencia->setFkPessoalContratoServidor($this);
            $this->fkPessoalContratoServidorOcorrencias->add($fkPessoalContratoServidorOcorrencia);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorOcorrencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOcorrencia $fkPessoalContratoServidorOcorrencia
     */
    public function removeFkPessoalContratoServidorOcorrencias(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOcorrencia $fkPessoalContratoServidorOcorrencia)
    {
        $this->fkPessoalContratoServidorOcorrencias->removeElement($fkPessoalContratoServidorOcorrencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorOcorrencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOcorrencia
     */
    public function getFkPessoalContratoServidorOcorrencias()
    {
        return $this->fkPessoalContratoServidorOcorrencias;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorRegimeFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorRegimeFuncao $fkPessoalContratoServidorRegimeFuncao
     * @return ContratoServidor
     */
    public function addFkPessoalContratoServidorRegimeFuncoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorRegimeFuncao $fkPessoalContratoServidorRegimeFuncao)
    {
        if (false === $this->fkPessoalContratoServidorRegimeFuncoes->contains($fkPessoalContratoServidorRegimeFuncao)) {
            $fkPessoalContratoServidorRegimeFuncao->setFkPessoalContratoServidor($this);
            $this->fkPessoalContratoServidorRegimeFuncoes->add($fkPessoalContratoServidorRegimeFuncao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorRegimeFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorRegimeFuncao $fkPessoalContratoServidorRegimeFuncao
     */
    public function removeFkPessoalContratoServidorRegimeFuncoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorRegimeFuncao $fkPessoalContratoServidorRegimeFuncao)
    {
        $this->fkPessoalContratoServidorRegimeFuncoes->removeElement($fkPessoalContratoServidorRegimeFuncao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorRegimeFuncoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorRegimeFuncao
     */
    public function getFkPessoalContratoServidorRegimeFuncoes()
    {
        return $this->fkPessoalContratoServidorRegimeFuncoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorSalario
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSalario $fkPessoalContratoServidorSalario
     * @return ContratoServidor
     */
    public function addFkPessoalContratoServidorSalarios(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSalario $fkPessoalContratoServidorSalario)
    {
        if (false === $this->fkPessoalContratoServidorSalarios->contains($fkPessoalContratoServidorSalario)) {
            $fkPessoalContratoServidorSalario->setFkPessoalContratoServidor($this);
            $this->fkPessoalContratoServidorSalarios->add($fkPessoalContratoServidorSalario);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorSalario
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSalario $fkPessoalContratoServidorSalario
     */
    public function removeFkPessoalContratoServidorSalarios(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSalario $fkPessoalContratoServidorSalario)
    {
        $this->fkPessoalContratoServidorSalarios->removeElement($fkPessoalContratoServidorSalario);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorSalarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSalario
     */
    public function getFkPessoalContratoServidorSalarios()
    {
        return $this->fkPessoalContratoServidorSalarios;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorSubDivisaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSubDivisaoFuncao $fkPessoalContratoServidorSubDivisaoFuncao
     * @return ContratoServidor
     */
    public function addFkPessoalContratoServidorSubDivisaoFuncoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSubDivisaoFuncao $fkPessoalContratoServidorSubDivisaoFuncao)
    {
        if (false === $this->fkPessoalContratoServidorSubDivisaoFuncoes->contains($fkPessoalContratoServidorSubDivisaoFuncao)) {
            $fkPessoalContratoServidorSubDivisaoFuncao->setFkPessoalContratoServidor($this);
            $this->fkPessoalContratoServidorSubDivisaoFuncoes->add($fkPessoalContratoServidorSubDivisaoFuncao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorSubDivisaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSubDivisaoFuncao $fkPessoalContratoServidorSubDivisaoFuncao
     */
    public function removeFkPessoalContratoServidorSubDivisaoFuncoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSubDivisaoFuncao $fkPessoalContratoServidorSubDivisaoFuncao)
    {
        $this->fkPessoalContratoServidorSubDivisaoFuncoes->removeElement($fkPessoalContratoServidorSubDivisaoFuncao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorSubDivisaoFuncoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSubDivisaoFuncao
     */
    public function getFkPessoalContratoServidorSubDivisaoFuncoes()
    {
        return $this->fkPessoalContratoServidorSubDivisaoFuncoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorValetransporte
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorValetransporte $fkPessoalContratoServidorValetransporte
     * @return ContratoServidor
     */
    public function addFkPessoalContratoServidorValetransportes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorValetransporte $fkPessoalContratoServidorValetransporte)
    {
        if (false === $this->fkPessoalContratoServidorValetransportes->contains($fkPessoalContratoServidorValetransporte)) {
            $fkPessoalContratoServidorValetransporte->setFkPessoalContratoServidor($this);
            $this->fkPessoalContratoServidorValetransportes->add($fkPessoalContratoServidorValetransporte);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorValetransporte
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorValetransporte $fkPessoalContratoServidorValetransporte
     */
    public function removeFkPessoalContratoServidorValetransportes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorValetransporte $fkPessoalContratoServidorValetransporte)
    {
        $this->fkPessoalContratoServidorValetransportes->removeElement($fkPessoalContratoServidorValetransporte);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorValetransportes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorValetransporte
     */
    public function getFkPessoalContratoServidorValetransportes()
    {
        return $this->fkPessoalContratoServidorValetransportes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalFerias
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Ferias $fkPessoalFerias
     * @return ContratoServidor
     */
    public function addFkPessoalFerias(\Urbem\CoreBundle\Entity\Pessoal\Ferias $fkPessoalFerias)
    {
        if (false === $this->fkPessoalFerias->contains($fkPessoalFerias)) {
            $fkPessoalFerias->setFkPessoalContratoServidor($this);
            $this->fkPessoalFerias->add($fkPessoalFerias);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalFerias
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Ferias $fkPessoalFerias
     */
    public function removeFkPessoalFerias(\Urbem\CoreBundle\Entity\Pessoal\Ferias $fkPessoalFerias)
    {
        $this->fkPessoalFerias->removeElement($fkPessoalFerias);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalFerias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Ferias
     */
    public function getFkPessoalFerias()
    {
        return $this->fkPessoalFerias;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalPensionista
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Pensionista $fkPessoalPensionista
     * @return ContratoServidor
     */
    public function addFkPessoalPensionistas(\Urbem\CoreBundle\Entity\Pessoal\Pensionista $fkPessoalPensionista)
    {
        if (false === $this->fkPessoalPensionistas->contains($fkPessoalPensionista)) {
            $fkPessoalPensionista->setFkPessoalContratoServidor($this);
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
     * Add PessoalServidorContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorContratoServidor $fkPessoalServidorContratoServidor
     * @return ContratoServidor
     */
    public function addFkPessoalServidorContratoServidores(\Urbem\CoreBundle\Entity\Pessoal\ServidorContratoServidor $fkPessoalServidorContratoServidor)
    {
        if (false === $this->fkPessoalServidorContratoServidores->contains($fkPessoalServidorContratoServidor)) {
            $fkPessoalServidorContratoServidor->setFkPessoalContratoServidor($this);
            $this->fkPessoalServidorContratoServidores->add($fkPessoalServidorContratoServidor);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalServidorContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorContratoServidor $fkPessoalServidorContratoServidor
     */
    public function removeFkPessoalServidorContratoServidores(\Urbem\CoreBundle\Entity\Pessoal\ServidorContratoServidor $fkPessoalServidorContratoServidor)
    {
        $this->fkPessoalServidorContratoServidores->removeElement($fkPessoalServidorContratoServidor);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalServidorContratoServidores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorContratoServidor
     */
    public function getFkPessoalServidorContratoServidores()
    {
        return $this->fkPessoalServidorContratoServidores;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorFormaPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFormaPagamento $fkPessoalContratoServidorFormaPagamento
     * @return ContratoServidor
     */
    public function addFkPessoalContratoServidorFormaPagamentos(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFormaPagamento $fkPessoalContratoServidorFormaPagamento)
    {
        if (false === $this->fkPessoalContratoServidorFormaPagamentos->contains($fkPessoalContratoServidorFormaPagamento)) {
            $fkPessoalContratoServidorFormaPagamento->setFkPessoalContratoServidor($this);
            $this->fkPessoalContratoServidorFormaPagamentos->add($fkPessoalContratoServidorFormaPagamento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorFormaPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFormaPagamento $fkPessoalContratoServidorFormaPagamento
     */
    public function removeFkPessoalContratoServidorFormaPagamentos(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFormaPagamento $fkPessoalContratoServidorFormaPagamento)
    {
        $this->fkPessoalContratoServidorFormaPagamentos->removeElement($fkPessoalContratoServidorFormaPagamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorFormaPagamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFormaPagamento
     */
    public function getFkPessoalContratoServidorFormaPagamentos()
    {
        return $this->fkPessoalContratoServidorFormaPagamentos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorLocalHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocalHistorico $fkPessoalContratoServidorLocalHistorico
     * @return ContratoServidor
     */
    public function addFkPessoalContratoServidorLocalHistoricos(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocalHistorico $fkPessoalContratoServidorLocalHistorico)
    {
        if (false === $this->fkPessoalContratoServidorLocalHistoricos->contains($fkPessoalContratoServidorLocalHistorico)) {
            $fkPessoalContratoServidorLocalHistorico->setFkPessoalContratoServidor($this);
            $this->fkPessoalContratoServidorLocalHistoricos->add($fkPessoalContratoServidorLocalHistorico);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorLocalHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocalHistorico $fkPessoalContratoServidorLocalHistorico
     */
    public function removeFkPessoalContratoServidorLocalHistoricos(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocalHistorico $fkPessoalContratoServidorLocalHistorico)
    {
        $this->fkPessoalContratoServidorLocalHistoricos->removeElement($fkPessoalContratoServidorLocalHistorico);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorLocalHistoricos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocalHistorico
     */
    public function getFkPessoalContratoServidorLocalHistoricos()
    {
        return $this->fkPessoalContratoServidorLocalHistoricos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPadrao $fkPessoalContratoServidorPadrao
     * @return ContratoServidor
     */
    public function addFkPessoalContratoServidorPadroes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPadrao $fkPessoalContratoServidorPadrao)
    {
        if (false === $this->fkPessoalContratoServidorPadroes->contains($fkPessoalContratoServidorPadrao)) {
            $fkPessoalContratoServidorPadrao->setFkPessoalContratoServidor($this);
            $this->fkPessoalContratoServidorPadroes->add($fkPessoalContratoServidorPadrao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPadrao $fkPessoalContratoServidorPadrao
     */
    public function removeFkPessoalContratoServidorPadroes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPadrao $fkPessoalContratoServidorPadrao)
    {
        $this->fkPessoalContratoServidorPadroes->removeElement($fkPessoalContratoServidorPadrao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorPadroes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPadrao
     */
    public function getFkPessoalContratoServidorPadroes()
    {
        return $this->fkPessoalContratoServidorPadroes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return ContratoServidor
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalTipoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\TipoPagamento $fkPessoalTipoPagamento
     * @return ContratoServidor
     */
    public function setFkPessoalTipoPagamento(\Urbem\CoreBundle\Entity\Pessoal\TipoPagamento $fkPessoalTipoPagamento)
    {
        $this->codTipoPagamento = $fkPessoalTipoPagamento->getCodTipoPagamento();
        $this->fkPessoalTipoPagamento = $fkPessoalTipoPagamento;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalTipoPagamento
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\TipoPagamento
     */
    public function getFkPessoalTipoPagamento()
    {
        return $this->fkPessoalTipoPagamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalTipoAdmissao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\TipoAdmissao $fkPessoalTipoAdmissao
     * @return ContratoServidor
     */
    public function setFkPessoalTipoAdmissao(\Urbem\CoreBundle\Entity\Pessoal\TipoAdmissao $fkPessoalTipoAdmissao)
    {
        $this->codTipoAdmissao = $fkPessoalTipoAdmissao->getCodTipoAdmissao();
        $this->fkPessoalTipoAdmissao = $fkPessoalTipoAdmissao;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalTipoAdmissao
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\TipoAdmissao
     */
    public function getFkPessoalTipoAdmissao()
    {
        return $this->fkPessoalTipoAdmissao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCategoria
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Categoria $fkPessoalCategoria
     * @return ContratoServidor
     */
    public function setFkPessoalCategoria(\Urbem\CoreBundle\Entity\Pessoal\Categoria $fkPessoalCategoria)
    {
        $this->codCategoria = $fkPessoalCategoria->getCodCategoria();
        $this->fkPessoalCategoria = $fkPessoalCategoria;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCategoria
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Categoria
     */
    public function getFkPessoalCategoria()
    {
        return $this->fkPessoalCategoria;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalVinculoEmpregaticio
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\VinculoEmpregaticio $fkPessoalVinculoEmpregaticio
     * @return ContratoServidor
     */
    public function setFkPessoalVinculoEmpregaticio(\Urbem\CoreBundle\Entity\Pessoal\VinculoEmpregaticio $fkPessoalVinculoEmpregaticio)
    {
        $this->codVinculo = $fkPessoalVinculoEmpregaticio->getCodVinculo();
        $this->fkPessoalVinculoEmpregaticio = $fkPessoalVinculoEmpregaticio;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalVinculoEmpregaticio
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\VinculoEmpregaticio
     */
    public function getFkPessoalVinculoEmpregaticio()
    {
        return $this->fkPessoalVinculoEmpregaticio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCargo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Cargo $fkPessoalCargo
     * @return ContratoServidor
     */
    public function setFkPessoalCargo(\Urbem\CoreBundle\Entity\Pessoal\Cargo $fkPessoalCargo)
    {
        $this->codCargo = $fkPessoalCargo->getCodCargo();
        $this->fkPessoalCargo = $fkPessoalCargo;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCargo
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Cargo
     */
    public function getFkPessoalCargo()
    {
        return $this->fkPessoalCargo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalRegime
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Regime $fkPessoalRegime
     * @return ContratoServidor
     */
    public function setFkPessoalRegime(\Urbem\CoreBundle\Entity\Pessoal\Regime $fkPessoalRegime)
    {
        $this->codRegime = $fkPessoalRegime->getCodRegime();
        $this->fkPessoalRegime = $fkPessoalRegime;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalRegime
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Regime
     */
    public function getFkPessoalRegime()
    {
        return $this->fkPessoalRegime;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao
     * @return ContratoServidor
     */
    public function setFkPessoalSubDivisao(\Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao)
    {
        $this->codSubDivisao = $fkPessoalSubDivisao->getCodSubDivisao();
        $this->fkPessoalSubDivisao = $fkPessoalSubDivisao;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalSubDivisao
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\SubDivisao
     */
    public function getFkPessoalSubDivisao()
    {
        return $this->fkPessoalSubDivisao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalGradeHorario
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\GradeHorario $fkPessoalGradeHorario
     * @return ContratoServidor
     */
    public function setFkPessoalGradeHorario(\Urbem\CoreBundle\Entity\Pessoal\GradeHorario $fkPessoalGradeHorario)
    {
        $this->codGrade = $fkPessoalGradeHorario->getCodGrade();
        $this->fkPessoalGradeHorario = $fkPessoalGradeHorario;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalGradeHorario
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\GradeHorario
     */
    public function getFkPessoalGradeHorario()
    {
        return $this->fkPessoalGradeHorario;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalContratoServidorCasoCausa
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausa $fkPessoalContratoServidorCasoCausa
     * @return ContratoServidor
     */
    public function setFkPessoalContratoServidorCasoCausa(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausa $fkPessoalContratoServidorCasoCausa)
    {
        $fkPessoalContratoServidorCasoCausa->setFkPessoalContratoServidor($this);
        $this->fkPessoalContratoServidorCasoCausa = $fkPessoalContratoServidorCasoCausa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalContratoServidorCasoCausa
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausa
     */
    public function getFkPessoalContratoServidorCasoCausa()
    {
        return $this->fkPessoalContratoServidorCasoCausa;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalContratoServidorCedencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCedencia $fkPessoalContratoServidorCedencia
     * @return ContratoServidor
     */
    public function setFkPessoalContratoServidorCedencia(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCedencia $fkPessoalContratoServidorCedencia)
    {
        $fkPessoalContratoServidorCedencia->setFkPessoalContratoServidor($this);
        $this->fkPessoalContratoServidorCedencia = $fkPessoalContratoServidorCedencia;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalContratoServidorCedencia
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCedencia
     */
    public function getFkPessoalContratoServidorCedencia()
    {
        return $this->fkPessoalContratoServidorCedencia;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalContratoServidorConselho
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorConselho $fkPessoalContratoServidorConselho
     * @return ContratoServidor
     */
    public function setFkPessoalContratoServidorConselho(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorConselho $fkPessoalContratoServidorConselho = null)
    {
        if ($fkPessoalContratoServidorConselho) {
            $fkPessoalContratoServidorConselho->setFkPessoalContratoServidor($this);
        }
        $this->fkPessoalContratoServidorConselho = $fkPessoalContratoServidorConselho;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalContratoServidorConselho
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorConselho
     */
    public function getFkPessoalContratoServidorConselho()
    {
        return $this->fkPessoalContratoServidorConselho;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalContratoServidorContaFgts
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaFgts $fkPessoalContratoServidorContaFgts
     * @return ContratoServidor
     */
    public function setFkPessoalContratoServidorContaFgts(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaFgts $fkPessoalContratoServidorContaFgts)
    {
        $fkPessoalContratoServidorContaFgts->setFkPessoalContratoServidor($this);
        $this->fkPessoalContratoServidorContaFgts = $fkPessoalContratoServidorContaFgts;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalContratoServidorContaFgts
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaFgts
     */
    public function getFkPessoalContratoServidorContaFgts()
    {
        return $this->fkPessoalContratoServidorContaFgts;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalContratoServidorSindicato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSindicato $fkPessoalContratoServidorSindicato
     * @return ContratoServidor
     */
    public function setFkPessoalContratoServidorSindicato(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSindicato $fkPessoalContratoServidorSindicato)
    {
        $fkPessoalContratoServidorSindicato->setFkPessoalContratoServidor($this);
        $this->fkPessoalContratoServidorSindicato = $fkPessoalContratoServidorSindicato;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalContratoServidorSindicato
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSindicato
     */
    public function getFkPessoalContratoServidorSindicato()
    {
        return $this->fkPessoalContratoServidorSindicato;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalContratoServidorContaSalario
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaSalario $fkPessoalContratoServidorContaSalario
     * @return ContratoServidor
     */
    public function setFkPessoalContratoServidorContaSalario(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaSalario $fkPessoalContratoServidorContaSalario)
    {
        $fkPessoalContratoServidorContaSalario->setFkPessoalContratoServidor($this);
        $this->fkPessoalContratoServidorContaSalario = $fkPessoalContratoServidorContaSalario;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalContratoServidorContaSalario
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaSalario
     */
    public function getFkPessoalContratoServidorContaSalario()
    {
        return $this->fkPessoalContratoServidorContaSalario;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalContrato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato
     * @return ContratoServidor
     */
    public function setFkPessoalContrato(\Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato)
    {
        $this->codContrato = $fkPessoalContrato->getCodContrato();
        $this->fkPessoalContrato = $fkPessoalContrato;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPessoalContrato
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    public function getFkPessoalContrato()
    {
        return $this->fkPessoalContrato;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->codContrato;
    }

    /**
     * Retorna o registro/matricula do servidor
     * @return string
     */
    public function getMatricula()
    {
        return $this->getFkPessoalContrato()
        ->getRegistro();
    }

    /**
     * Retorna o CGM do Servidor
     * @return string
     */
    public function getCgm()
    {
        $servidor = $this->getFkPessoalServidorContratoServidores()->last()->getFkPessoalServidor();
        return $servidor->getFkSwCgmPessoaFisica()
            ->getNumcgm()
            . " - "
            . $servidor->getFkSwCgmPessoaFisica()
            ->getFkSwCgm()
            ->getNomCgm();
    }
}
