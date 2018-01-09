<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * Contrato
 */
class Contrato
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $numContrato;

    /**
     * @var integer
     */
    private $codTipoDocumento;

    /**
     * @var integer
     */
    private $codDocumento;

    /**
     * @var integer
     */
    private $cgmResponsavelJuridico;

    /**
     * @var integer
     */
    private $cgmContratado;

    /**
     * @var \DateTime
     */
    private $dtAssinatura;

    /**
     * @var \DateTime
     */
    private $vencimento;

    /**
     * @var integer
     */
    private $valorContratado;

    /**
     * @var integer
     */
    private $valorGarantia;

    /**
     * @var \DateTime
     */
    private $inicioExecucao;

    /**
     * @var \DateTime
     */
    private $fimExecucao;

    /**
     * @var integer
     */
    private $codTipoContrato;

    /**
     * @var integer
     */
    private $numeroContrato;

    /**
     * @var string
     */
    private $exercicioOrgao;

    /**
     * @var integer
     */
    private $numOrgao;

    /**
     * @var integer
     */
    private $numUnidade;

    /**
     * @var integer
     */
    private $tipoObjeto;

    /**
     * @var string
     */
    private $objeto;

    /**
     * @var integer
     */
    private $codGarantia;

    /**
     * @var string
     */
    private $formaFornecimento;

    /**
     * @var string
     */
    private $formaPagamento;

    /**
     * @var integer
     */
    private $cgmSignatario;

    /**
     * @var string
     */
    private $justificativa;

    /**
     * @var string
     */
    private $razao;

    /**
     * @var string
     */
    private $fundamentacaoLegal;

    /**
     * @var string
     */
    private $multaRescisoria;

    /**
     * @var string
     */
    private $prazoExecucao;

    /**
     * @var string
     */
    private $multaInadimplemento;

    /**
     * @var integer
     */
    private $codTipoInstrumento;

    /**
     * @var integer
     */
    private $cgmRepresentanteLegal;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\ContratoLicitacao
     */
    private $fkLicitacaoContratoLicitacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\ContratoAnulado
     */
    private $fkLicitacaoContratoAnulado;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\RescisaoContrato
     */
    private $fkLicitacaoRescisaoContrato;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\ContratoCompraDireta
     */
    private $fkLicitacaoContratoCompraDireta;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\EmpenhoContrato
     */
    private $fkEmpenhoEmpenhoContratos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ContratoDocumento
     */
    private $fkLicitacaoContratoDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ContratoAditivos
     */
    private $fkLicitacaoContratoAditivos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ContratoApostila
     */
    private $fkLicitacaoContratoApostilas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ContratoArquivo
     */
    private $fkLicitacaoContratoArquivos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoContrato
     */
    private $fkLicitacaoPublicacaoContratos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    private $fkAdministracaoModeloDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Fornecedor
     */
    private $fkComprasFornecedor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\TipoContrato
     */
    private $fkLicitacaoTipoContrato;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    private $fkOrcamentoUnidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\TipoObjeto
     */
    private $fkComprasTipoObjeto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\TipoGarantia
     */
    private $fkLicitacaoTipoGarantia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\TipoInstrumento
     */
    private $fkLicitacaoTipoInstrumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica1;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEmpenhoEmpenhoContratos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoContratoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoContratoAditivos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoContratoApostilas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoContratoArquivos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoPublicacaoContratos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Contrato
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Contrato
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set numContrato
     *
     * @param integer $numContrato
     * @return Contrato
     */
    public function setNumContrato($numContrato)
    {
        $this->numContrato = $numContrato;
        return $this;
    }

    /**
     * Get numContrato
     *
     * @return integer
     */
    public function getNumContrato()
    {
        return $this->numContrato;
    }

    /**
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return Contrato
     */
    public function setCodTipoDocumento($codTipoDocumento)
    {
        $this->codTipoDocumento = $codTipoDocumento;
        return $this;
    }

    /**
     * Get codTipoDocumento
     *
     * @return integer
     */
    public function getCodTipoDocumento()
    {
        return $this->codTipoDocumento;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return Contrato
     */
    public function setCodDocumento($codDocumento)
    {
        $this->codDocumento = $codDocumento;
        return $this;
    }

    /**
     * Get codDocumento
     *
     * @return integer
     */
    public function getCodDocumento()
    {
        return $this->codDocumento;
    }

    /**
     * Set cgmResponsavelJuridico
     *
     * @param integer $cgmResponsavelJuridico
     * @return Contrato
     */
    public function setCgmResponsavelJuridico($cgmResponsavelJuridico)
    {
        $this->cgmResponsavelJuridico = $cgmResponsavelJuridico;
        return $this;
    }

    /**
     * Get cgmResponsavelJuridico
     *
     * @return integer
     */
    public function getCgmResponsavelJuridico()
    {
        return $this->cgmResponsavelJuridico;
    }

    /**
     * Set cgmContratado
     *
     * @param integer $cgmContratado
     * @return Contrato
     */
    public function setCgmContratado($cgmContratado)
    {
        $this->cgmContratado = $cgmContratado;
        return $this;
    }

    /**
     * Get cgmContratado
     *
     * @return integer
     */
    public function getCgmContratado()
    {
        return $this->cgmContratado;
    }

    /**
     * Set dtAssinatura
     *
     * @param \DateTime $dtAssinatura
     * @return Contrato
     */
    public function setDtAssinatura(\DateTime $dtAssinatura)
    {
        $this->dtAssinatura = $dtAssinatura;
        return $this;
    }

    /**
     * Get dtAssinatura
     *
     * @return \DateTime
     */
    public function getDtAssinatura()
    {
        return $this->dtAssinatura;
    }

    /**
     * Set vencimento
     *
     * @param \DateTime $vencimento
     * @return Contrato
     */
    public function setVencimento(\DateTime $vencimento)
    {
        $this->vencimento = $vencimento;
        return $this;
    }

    /**
     * Get vencimento
     *
     * @return \DateTime
     */
    public function getVencimento()
    {
        return $this->vencimento;
    }

    /**
     * Set valorContratado
     *
     * @param integer $valorContratado
     * @return Contrato
     */
    public function setValorContratado($valorContratado)
    {
        $this->valorContratado = $valorContratado;
        return $this;
    }

    /**
     * Get valorContratado
     *
     * @return integer
     */
    public function getValorContratado()
    {
        return $this->valorContratado;
    }

    /**
     * Set valorGarantia
     *
     * @param integer $valorGarantia
     * @return Contrato
     */
    public function setValorGarantia($valorGarantia)
    {
        $this->valorGarantia = $valorGarantia;
        return $this;
    }

    /**
     * Get valorGarantia
     *
     * @return integer
     */
    public function getValorGarantia()
    {
        return $this->valorGarantia;
    }

    /**
     * Set inicioExecucao
     *
     * @param \DateTime $inicioExecucao
     * @return Contrato
     */
    public function setInicioExecucao(\DateTime $inicioExecucao)
    {
        $this->inicioExecucao = $inicioExecucao;
        return $this;
    }

    /**
     * Get inicioExecucao
     *
     * @return \DateTime
     */
    public function getInicioExecucao()
    {
        return $this->inicioExecucao;
    }

    /**
     * Set fimExecucao
     *
     * @param \DateTime $fimExecucao
     * @return Contrato
     */
    public function setFimExecucao(\DateTime $fimExecucao)
    {
        $this->fimExecucao = $fimExecucao;
        return $this;
    }

    /**
     * Get fimExecucao
     *
     * @return \DateTime
     */
    public function getFimExecucao()
    {
        return $this->fimExecucao;
    }

    /**
     * Set codTipoContrato
     *
     * @param integer $codTipoContrato
     * @return Contrato
     */
    public function setCodTipoContrato($codTipoContrato)
    {
        $this->codTipoContrato = $codTipoContrato;
        return $this;
    }

    /**
     * Get codTipoContrato
     *
     * @return integer
     */
    public function getCodTipoContrato()
    {
        return $this->codTipoContrato;
    }

    /**
     * Set numeroContrato
     *
     * @param integer $numeroContrato
     * @return Contrato
     */
    public function setNumeroContrato($numeroContrato)
    {
        $this->numeroContrato = $numeroContrato;
        return $this;
    }

    /**
     * Get numeroContrato
     *
     * @return integer
     */
    public function getNumeroContrato()
    {
        return $this->numeroContrato;
    }

    /**
     * Set exercicioOrgao
     *
     * @param string $exercicioOrgao
     * @return Contrato
     */
    public function setExercicioOrgao($exercicioOrgao = null)
    {
        $this->exercicioOrgao = $exercicioOrgao;
        return $this;
    }

    /**
     * Get exercicioOrgao
     *
     * @return string
     */
    public function getExercicioOrgao()
    {
        return $this->exercicioOrgao;
    }

    /**
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return Contrato
     */
    public function setNumOrgao($numOrgao = null)
    {
        $this->numOrgao = $numOrgao;
        return $this;
    }

    /**
     * Get numOrgao
     *
     * @return integer
     */
    public function getNumOrgao()
    {
        return $this->numOrgao;
    }

    /**
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return Contrato
     */
    public function setNumUnidade($numUnidade = null)
    {
        $this->numUnidade = $numUnidade;
        return $this;
    }

    /**
     * Get numUnidade
     *
     * @return integer
     */
    public function getNumUnidade()
    {
        return $this->numUnidade;
    }

    /**
     * Set tipoObjeto
     *
     * @param integer $tipoObjeto
     * @return Contrato
     */
    public function setTipoObjeto($tipoObjeto = null)
    {
        $this->tipoObjeto = $tipoObjeto;
        return $this;
    }

    /**
     * Get tipoObjeto
     *
     * @return integer
     */
    public function getTipoObjeto()
    {
        return $this->tipoObjeto;
    }

    /**
     * Set objeto
     *
     * @param string $objeto
     * @return Contrato
     */
    public function setObjeto($objeto = null)
    {
        $this->objeto = $objeto;
        return $this;
    }

    /**
     * Get objeto
     *
     * @return string
     */
    public function getObjeto()
    {
        return $this->objeto;
    }

    /**
     * Set codGarantia
     *
     * @param integer $codGarantia
     * @return Contrato
     */
    public function setCodGarantia($codGarantia = null)
    {
        $this->codGarantia = $codGarantia;
        return $this;
    }

    /**
     * Get codGarantia
     *
     * @return integer
     */
    public function getCodGarantia()
    {
        return $this->codGarantia;
    }

    /**
     * Set formaFornecimento
     *
     * @param string $formaFornecimento
     * @return Contrato
     */
    public function setFormaFornecimento($formaFornecimento = null)
    {
        $this->formaFornecimento = $formaFornecimento;
        return $this;
    }

    /**
     * Get formaFornecimento
     *
     * @return string
     */
    public function getFormaFornecimento()
    {
        return $this->formaFornecimento;
    }

    /**
     * Set formaPagamento
     *
     * @param string $formaPagamento
     * @return Contrato
     */
    public function setFormaPagamento($formaPagamento = null)
    {
        $this->formaPagamento = $formaPagamento;
        return $this;
    }

    /**
     * Get formaPagamento
     *
     * @return string
     */
    public function getFormaPagamento()
    {
        return $this->formaPagamento;
    }

    /**
     * Set cgmSignatario
     *
     * @param integer $cgmSignatario
     * @return Contrato
     */
    public function setCgmSignatario($cgmSignatario = null)
    {
        $this->cgmSignatario = $cgmSignatario;
        return $this;
    }

    /**
     * Get cgmSignatario
     *
     * @return integer
     */
    public function getCgmSignatario()
    {
        return $this->cgmSignatario;
    }

    /**
     * Set justificativa
     *
     * @param string $justificativa
     * @return Contrato
     */
    public function setJustificativa($justificativa)
    {
        $this->justificativa = $justificativa;
        return $this;
    }

    /**
     * Get justificativa
     *
     * @return string
     */
    public function getJustificativa()
    {
        return $this->justificativa;
    }

    /**
     * Set razao
     *
     * @param string $razao
     * @return Contrato
     */
    public function setRazao($razao)
    {
        $this->razao = $razao;
        return $this;
    }

    /**
     * Get razao
     *
     * @return string
     */
    public function getRazao()
    {
        return $this->razao;
    }

    /**
     * Set fundamentacaoLegal
     *
     * @param string $fundamentacaoLegal
     * @return Contrato
     */
    public function setFundamentacaoLegal($fundamentacaoLegal)
    {
        $this->fundamentacaoLegal = $fundamentacaoLegal;
        return $this;
    }

    /**
     * Get fundamentacaoLegal
     *
     * @return string
     */
    public function getFundamentacaoLegal()
    {
        return $this->fundamentacaoLegal;
    }

    /**
     * Set multaRescisoria
     *
     * @param string $multaRescisoria
     * @return Contrato
     */
    public function setMultaRescisoria($multaRescisoria)
    {
        $this->multaRescisoria = $multaRescisoria;
        return $this;
    }

    /**
     * Get multaRescisoria
     *
     * @return string
     */
    public function getMultaRescisoria()
    {
        return $this->multaRescisoria;
    }

    /**
     * Set prazoExecucao
     *
     * @param string $prazoExecucao
     * @return Contrato
     */
    public function setPrazoExecucao($prazoExecucao)
    {
        $this->prazoExecucao = $prazoExecucao;
        return $this;
    }

    /**
     * Get prazoExecucao
     *
     * @return string
     */
    public function getPrazoExecucao()
    {
        return $this->prazoExecucao;
    }

    /**
     * Set multaInadimplemento
     *
     * @param string $multaInadimplemento
     * @return Contrato
     */
    public function setMultaInadimplemento($multaInadimplemento = null)
    {
        $this->multaInadimplemento = $multaInadimplemento;
        return $this;
    }

    /**
     * Get multaInadimplemento
     *
     * @return string
     */
    public function getMultaInadimplemento()
    {
        return $this->multaInadimplemento;
    }

    /**
     * Set codTipoInstrumento
     *
     * @param integer $codTipoInstrumento
     * @return Contrato
     */
    public function setCodTipoInstrumento($codTipoInstrumento)
    {
        $this->codTipoInstrumento = $codTipoInstrumento;
        return $this;
    }

    /**
     * Get codTipoInstrumento
     *
     * @return integer
     */
    public function getCodTipoInstrumento()
    {
        return $this->codTipoInstrumento;
    }

    /**
     * Set cgmRepresentanteLegal
     *
     * @param integer $cgmRepresentanteLegal
     * @return Contrato
     */
    public function setCgmRepresentanteLegal($cgmRepresentanteLegal = null)
    {
        $this->cgmRepresentanteLegal = $cgmRepresentanteLegal;
        return $this;
    }

    /**
     * Get cgmRepresentanteLegal
     *
     * @return integer
     */
    public function getCgmRepresentanteLegal()
    {
        return $this->cgmRepresentanteLegal;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoEmpenhoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoContrato $fkEmpenhoEmpenhoContrato
     * @return Contrato
     */
    public function addFkEmpenhoEmpenhoContratos(\Urbem\CoreBundle\Entity\Empenho\EmpenhoContrato $fkEmpenhoEmpenhoContrato)
    {
        if (false === $this->fkEmpenhoEmpenhoContratos->contains($fkEmpenhoEmpenhoContrato)) {
            $fkEmpenhoEmpenhoContrato->setFkLicitacaoContrato($this);
            $this->fkEmpenhoEmpenhoContratos->add($fkEmpenhoEmpenhoContrato);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoEmpenhoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoContrato $fkEmpenhoEmpenhoContrato
     */
    public function removeFkEmpenhoEmpenhoContratos(\Urbem\CoreBundle\Entity\Empenho\EmpenhoContrato $fkEmpenhoEmpenhoContrato)
    {
        $this->fkEmpenhoEmpenhoContratos->removeElement($fkEmpenhoEmpenhoContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoEmpenhoContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\EmpenhoContrato
     */
    public function getFkEmpenhoEmpenhoContratos()
    {
        return $this->fkEmpenhoEmpenhoContratos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoContratoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ContratoDocumento $fkLicitacaoContratoDocumento
     * @return Contrato
     */
    public function addFkLicitacaoContratoDocumentos(\Urbem\CoreBundle\Entity\Licitacao\ContratoDocumento $fkLicitacaoContratoDocumento)
    {
        if (false === $this->fkLicitacaoContratoDocumentos->contains($fkLicitacaoContratoDocumento)) {
            $fkLicitacaoContratoDocumento->setFkLicitacaoContrato($this);
            $this->fkLicitacaoContratoDocumentos->add($fkLicitacaoContratoDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoContratoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ContratoDocumento $fkLicitacaoContratoDocumento
     */
    public function removeFkLicitacaoContratoDocumentos(\Urbem\CoreBundle\Entity\Licitacao\ContratoDocumento $fkLicitacaoContratoDocumento)
    {
        $this->fkLicitacaoContratoDocumentos->removeElement($fkLicitacaoContratoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoContratoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ContratoDocumento
     */
    public function getFkLicitacaoContratoDocumentos()
    {
        return $this->fkLicitacaoContratoDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoContratoAditivos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ContratoAditivos $fkLicitacaoContratoAditivos
     * @return Contrato
     */
    public function addFkLicitacaoContratoAditivos(\Urbem\CoreBundle\Entity\Licitacao\ContratoAditivos $fkLicitacaoContratoAditivos)
    {
        if (false === $this->fkLicitacaoContratoAditivos->contains($fkLicitacaoContratoAditivos)) {
            $fkLicitacaoContratoAditivos->setFkLicitacaoContrato($this);
            $this->fkLicitacaoContratoAditivos->add($fkLicitacaoContratoAditivos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoContratoAditivos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ContratoAditivos $fkLicitacaoContratoAditivos
     */
    public function removeFkLicitacaoContratoAditivos(\Urbem\CoreBundle\Entity\Licitacao\ContratoAditivos $fkLicitacaoContratoAditivos)
    {
        $this->fkLicitacaoContratoAditivos->removeElement($fkLicitacaoContratoAditivos);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoContratoAditivos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ContratoAditivos
     */
    public function getFkLicitacaoContratoAditivos()
    {
        return $this->fkLicitacaoContratoAditivos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoContratoApostila
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ContratoApostila $fkLicitacaoContratoApostila
     * @return Contrato
     */
    public function addFkLicitacaoContratoApostilas(\Urbem\CoreBundle\Entity\Licitacao\ContratoApostila $fkLicitacaoContratoApostila)
    {
        if (false === $this->fkLicitacaoContratoApostilas->contains($fkLicitacaoContratoApostila)) {
            $fkLicitacaoContratoApostila->setFkLicitacaoContrato($this);
            $this->fkLicitacaoContratoApostilas->add($fkLicitacaoContratoApostila);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoContratoApostila
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ContratoApostila $fkLicitacaoContratoApostila
     */
    public function removeFkLicitacaoContratoApostilas(\Urbem\CoreBundle\Entity\Licitacao\ContratoApostila $fkLicitacaoContratoApostila)
    {
        $this->fkLicitacaoContratoApostilas->removeElement($fkLicitacaoContratoApostila);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoContratoApostilas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ContratoApostila
     */
    public function getFkLicitacaoContratoApostilas()
    {
        return $this->fkLicitacaoContratoApostilas;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoContratoArquivo
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ContratoArquivo $fkLicitacaoContratoArquivo
     * @return Contrato
     */
    public function addFkLicitacaoContratoArquivos(\Urbem\CoreBundle\Entity\Licitacao\ContratoArquivo $fkLicitacaoContratoArquivo)
    {
        if (false === $this->fkLicitacaoContratoArquivos->contains($fkLicitacaoContratoArquivo)) {
            $fkLicitacaoContratoArquivo->setFkLicitacaoContrato($this);
            $this->fkLicitacaoContratoArquivos->add($fkLicitacaoContratoArquivo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoContratoArquivo
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ContratoArquivo $fkLicitacaoContratoArquivo
     */
    public function removeFkLicitacaoContratoArquivos(\Urbem\CoreBundle\Entity\Licitacao\ContratoArquivo $fkLicitacaoContratoArquivo)
    {
        $this->fkLicitacaoContratoArquivos->removeElement($fkLicitacaoContratoArquivo);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoContratoArquivos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ContratoArquivo
     */
    public function getFkLicitacaoContratoArquivos()
    {
        return $this->fkLicitacaoContratoArquivos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoPublicacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoContrato $fkLicitacaoPublicacaoContrato
     * @return Contrato
     */
    public function addFkLicitacaoPublicacaoContratos(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoContrato $fkLicitacaoPublicacaoContrato)
    {
        if (false === $this->fkLicitacaoPublicacaoContratos->contains($fkLicitacaoPublicacaoContrato)) {
            $fkLicitacaoPublicacaoContrato->setFkLicitacaoContrato($this);
            $this->fkLicitacaoPublicacaoContratos->add($fkLicitacaoPublicacaoContrato);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoPublicacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoContrato $fkLicitacaoPublicacaoContrato
     */
    public function removeFkLicitacaoPublicacaoContratos(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoContrato $fkLicitacaoPublicacaoContrato)
    {
        $this->fkLicitacaoPublicacaoContratos->removeElement($fkLicitacaoPublicacaoContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoPublicacaoContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoContrato
     */
    public function getFkLicitacaoPublicacaoContratos()
    {
        return $this->fkLicitacaoPublicacaoContratos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return Contrato
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     * @return Contrato
     */
    public function setFkAdministracaoModeloDocumento(\Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento)
    {
        $this->codDocumento = $fkAdministracaoModeloDocumento->getCodDocumento();
        $this->codTipoDocumento = $fkAdministracaoModeloDocumento->getCodTipoDocumento();
        $this->fkAdministracaoModeloDocumento = $fkAdministracaoModeloDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoModeloDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    public function getFkAdministracaoModeloDocumento()
    {
        return $this->fkAdministracaoModeloDocumento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Contrato
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmResponsavelJuridico = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Fornecedor $fkComprasFornecedor
     * @return Contrato
     */
    public function setFkComprasFornecedor(\Urbem\CoreBundle\Entity\Compras\Fornecedor $fkComprasFornecedor)
    {
        $this->cgmContratado = $fkComprasFornecedor->getCgmFornecedor();
        $this->fkComprasFornecedor = $fkComprasFornecedor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasFornecedor
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Fornecedor
     */
    public function getFkComprasFornecedor()
    {
        return $this->fkComprasFornecedor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoTipoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\TipoContrato $fkLicitacaoTipoContrato
     * @return Contrato
     */
    public function setFkLicitacaoTipoContrato(\Urbem\CoreBundle\Entity\Licitacao\TipoContrato $fkLicitacaoTipoContrato)
    {
        $this->codTipoContrato = $fkLicitacaoTipoContrato->getCodTipo();
        $this->fkLicitacaoTipoContrato = $fkLicitacaoTipoContrato;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoTipoContrato
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\TipoContrato
     */
    public function getFkLicitacaoTipoContrato()
    {
        return $this->fkLicitacaoTipoContrato;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade
     * @return Contrato
     */
    public function setFkOrcamentoUnidade(\Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade)
    {
        $this->exercicioOrgao = $fkOrcamentoUnidade->getExercicio();
        $this->numUnidade = $fkOrcamentoUnidade->getNumUnidade();
        $this->numOrgao = $fkOrcamentoUnidade->getNumOrgao();
        $this->fkOrcamentoUnidade = $fkOrcamentoUnidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoUnidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    public function getFkOrcamentoUnidade()
    {
        return $this->fkOrcamentoUnidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasTipoObjeto
     *
     * @param \Urbem\CoreBundle\Entity\Compras\TipoObjeto $fkComprasTipoObjeto
     * @return Contrato
     */
    public function setFkComprasTipoObjeto(\Urbem\CoreBundle\Entity\Compras\TipoObjeto $fkComprasTipoObjeto)
    {
        $this->tipoObjeto = $fkComprasTipoObjeto->getCodTipoObjeto();
        $this->fkComprasTipoObjeto = $fkComprasTipoObjeto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasTipoObjeto
     *
     * @return \Urbem\CoreBundle\Entity\Compras\TipoObjeto
     */
    public function getFkComprasTipoObjeto()
    {
        return $this->fkComprasTipoObjeto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoTipoGarantia
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\TipoGarantia $fkLicitacaoTipoGarantia
     * @return Contrato
     */
    public function setFkLicitacaoTipoGarantia(\Urbem\CoreBundle\Entity\Licitacao\TipoGarantia $fkLicitacaoTipoGarantia)
    {
        $this->codGarantia = $fkLicitacaoTipoGarantia->getCodGarantia();
        $this->fkLicitacaoTipoGarantia = $fkLicitacaoTipoGarantia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoTipoGarantia
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\TipoGarantia
     */
    public function getFkLicitacaoTipoGarantia()
    {
        return $this->fkLicitacaoTipoGarantia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return Contrato
     */
    public function setFkSwCgmPessoaFisica(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $this->cgmSignatario = $fkSwCgmPessoaFisica->getNumcgm();
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
     * ManyToOne (inverse side)
     * Set fkLicitacaoTipoInstrumento
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\TipoInstrumento $fkLicitacaoTipoInstrumento
     * @return Contrato
     */
    public function setFkLicitacaoTipoInstrumento(\Urbem\CoreBundle\Entity\Licitacao\TipoInstrumento $fkLicitacaoTipoInstrumento)
    {
        $this->codTipoInstrumento = $fkLicitacaoTipoInstrumento->getCodTipo();
        $this->fkLicitacaoTipoInstrumento = $fkLicitacaoTipoInstrumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoTipoInstrumento
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\TipoInstrumento
     */
    public function getFkLicitacaoTipoInstrumento()
    {
        return $this->fkLicitacaoTipoInstrumento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica1
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica1
     * @return Contrato
     */
    public function setFkSwCgmPessoaFisica1(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica1)
    {
        $this->cgmRepresentanteLegal = $fkSwCgmPessoaFisica1->getNumcgm();
        $this->fkSwCgmPessoaFisica1 = $fkSwCgmPessoaFisica1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica1
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica1()
    {
        return $this->fkSwCgmPessoaFisica1;
    }

    /**
     * OneToOne (inverse side)
     * Set LicitacaoContratoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ContratoLicitacao $fkLicitacaoContratoLicitacao
     * @return Contrato
     */
    public function setFkLicitacaoContratoLicitacao(\Urbem\CoreBundle\Entity\Licitacao\ContratoLicitacao $fkLicitacaoContratoLicitacao)
    {
        $fkLicitacaoContratoLicitacao->setFkLicitacaoContrato($this);
        $this->fkLicitacaoContratoLicitacao = $fkLicitacaoContratoLicitacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkLicitacaoContratoLicitacao
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\ContratoLicitacao
     */
    public function getFkLicitacaoContratoLicitacao()
    {
        return $this->fkLicitacaoContratoLicitacao;
    }

    /**
     * OneToOne (inverse side)
     * Set LicitacaoContratoAnulado
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ContratoAnulado $fkLicitacaoContratoAnulado
     * @return Contrato
     */
    public function setFkLicitacaoContratoAnulado(\Urbem\CoreBundle\Entity\Licitacao\ContratoAnulado $fkLicitacaoContratoAnulado)
    {
        $fkLicitacaoContratoAnulado->setFkLicitacaoContrato($this);
        $this->fkLicitacaoContratoAnulado = $fkLicitacaoContratoAnulado;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkLicitacaoContratoAnulado
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\ContratoAnulado
     */
    public function getFkLicitacaoContratoAnulado()
    {
        return $this->fkLicitacaoContratoAnulado;
    }

    /**
     * OneToOne (inverse side)
     * Set LicitacaoRescisaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\RescisaoContrato $fkLicitacaoRescisaoContrato
     * @return Contrato
     */
    public function setFkLicitacaoRescisaoContrato(\Urbem\CoreBundle\Entity\Licitacao\RescisaoContrato $fkLicitacaoRescisaoContrato)
    {
        $fkLicitacaoRescisaoContrato->setFkLicitacaoContrato($this);
        $this->fkLicitacaoRescisaoContrato = $fkLicitacaoRescisaoContrato;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkLicitacaoRescisaoContrato
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\RescisaoContrato
     */
    public function getFkLicitacaoRescisaoContrato()
    {
        return $this->fkLicitacaoRescisaoContrato;
    }

    /**
     * OneToOne (inverse side)
     * Set LicitacaoContratoCompraDireta
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ContratoCompraDireta $fkLicitacaoContratoCompraDireta
     * @return Contrato
     */
    public function setFkLicitacaoContratoCompraDireta(\Urbem\CoreBundle\Entity\Licitacao\ContratoCompraDireta $fkLicitacaoContratoCompraDireta)
    {
        $fkLicitacaoContratoCompraDireta->setFkLicitacaoContrato($this);
        $this->fkLicitacaoContratoCompraDireta = $fkLicitacaoContratoCompraDireta;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkLicitacaoContratoCompraDireta
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\ContratoCompraDireta
     */
    public function getFkLicitacaoContratoCompraDireta()
    {
        return $this->fkLicitacaoContratoCompraDireta;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->numContrato;
    }
}
