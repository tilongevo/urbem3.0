<?php

namespace Urbem\CoreBundle\Entity\Beneficio;

/**
 * Beneficiario
 */
class Beneficiario
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var integer
     */
    private $cgmFornecedor;

    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * PK
     * @var integer
     */
    private $codTipoConvenio;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codigoUsuario;

    /**
     * @var integer
     */
    private $cgmBeneficiario;

    /**
     * @var integer
     */
    private $grauParentesco;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtFim;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var \DateTime
     */
    private $timestampExcluido;

    /**
     * @var integer
     */
    private $codPeriodoMovimentacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\BeneficiarioLancamento
     */
    private $fkBeneficioBeneficiarioLancamentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    private $fkPessoalContrato;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Fornecedor
     */
    private $fkComprasFornecedor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Beneficio\ModalidadeConvenioMedico
     */
    private $fkBeneficioModalidadeConvenioMedico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Beneficio\TipoConvenioMedico
     */
    private $fkBeneficioTipoConvenioMedico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\GrauParentesco
     */
    private $fkCseGrauParentesco;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao
     */
    private $fkFolhapagamentoPeriodoMovimentacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkBeneficioBeneficiarioLancamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return Beneficiario
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
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return Beneficiario
     */
    public function setCgmFornecedor($cgmFornecedor)
    {
        $this->cgmFornecedor = $cgmFornecedor;
        return $this;
    }

    /**
     * Get cgmFornecedor
     *
     * @return integer
     */
    public function getCgmFornecedor()
    {
        return $this->cgmFornecedor;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return Beneficiario
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set codTipoConvenio
     *
     * @param integer $codTipoConvenio
     * @return Beneficiario
     */
    public function setCodTipoConvenio($codTipoConvenio)
    {
        $this->codTipoConvenio = $codTipoConvenio;
        return $this;
    }

    /**
     * Get codTipoConvenio
     *
     * @return integer
     */
    public function getCodTipoConvenio()
    {
        return $this->codTipoConvenio;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Beneficiario
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codigoUsuario
     *
     * @param integer $codigoUsuario
     * @return Beneficiario
     */
    public function setCodigoUsuario($codigoUsuario)
    {
        $this->codigoUsuario = $codigoUsuario;
        return $this;
    }

    /**
     * Get codigoUsuario
     *
     * @return integer
     */
    public function getCodigoUsuario()
    {
        return $this->codigoUsuario;
    }

    /**
     * Set cgmBeneficiario
     *
     * @param integer $cgmBeneficiario
     * @return Beneficiario
     */
    public function setCgmBeneficiario($cgmBeneficiario)
    {
        $this->cgmBeneficiario = $cgmBeneficiario;
        return $this;
    }

    /**
     * Get cgmBeneficiario
     *
     * @return integer
     */
    public function getCgmBeneficiario()
    {
        return $this->cgmBeneficiario;
    }

    /**
     * Set grauParentesco
     *
     * @param integer $grauParentesco
     * @return Beneficiario
     */
    public function setGrauParentesco($grauParentesco)
    {
        $this->grauParentesco = $grauParentesco;
        return $this;
    }

    /**
     * Get grauParentesco
     *
     * @return integer
     */
    public function getGrauParentesco()
    {
        return $this->grauParentesco;
    }

    /**
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return Beneficiario
     */
    public function setDtInicio(\DateTime $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \DateTime
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set dtFim
     *
     * @param \DateTime $dtFim
     * @return Beneficiario
     */
    public function setDtFim(\DateTime $dtFim = null)
    {
        $this->dtFim = $dtFim;
        return $this;
    }

    /**
     * Get dtFim
     *
     * @return \DateTime
     */
    public function getDtFim()
    {
        return $this->dtFim;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return Beneficiario
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set timestampExcluido
     *
     * @param \DateTime $timestampExcluido
     * @return Beneficiario
     */
    public function setTimestampExcluido(\DateTime $timestampExcluido = null)
    {
        $this->timestampExcluido = $timestampExcluido;
        return $this;
    }

    /**
     * Get timestampExcluido
     *
     * @return \DateTime
     */
    public function getTimestampExcluido()
    {
        return $this->timestampExcluido;
    }

    /**
     * Set codPeriodoMovimentacao
     *
     * @param integer $codPeriodoMovimentacao
     * @return Beneficiario
     */
    public function setCodPeriodoMovimentacao($codPeriodoMovimentacao)
    {
        $this->codPeriodoMovimentacao = $codPeriodoMovimentacao;
        return $this;
    }

    /**
     * Get codPeriodoMovimentacao
     *
     * @return integer
     */
    public function getCodPeriodoMovimentacao()
    {
        return $this->codPeriodoMovimentacao;
    }

    /**
     * OneToMany (owning side)
     * Add BeneficioBeneficiarioLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\BeneficiarioLancamento $fkBeneficioBeneficiarioLancamento
     * @return Beneficiario
     */
    public function addFkBeneficioBeneficiarioLancamentos(\Urbem\CoreBundle\Entity\Beneficio\BeneficiarioLancamento $fkBeneficioBeneficiarioLancamento)
    {
        if (false === $this->fkBeneficioBeneficiarioLancamentos->contains($fkBeneficioBeneficiarioLancamento)) {
            $fkBeneficioBeneficiarioLancamento->setFkBeneficioBeneficiario($this);
            $this->fkBeneficioBeneficiarioLancamentos->add($fkBeneficioBeneficiarioLancamento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioBeneficiarioLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\BeneficiarioLancamento $fkBeneficioBeneficiarioLancamento
     */
    public function removeFkBeneficioBeneficiarioLancamentos(\Urbem\CoreBundle\Entity\Beneficio\BeneficiarioLancamento $fkBeneficioBeneficiarioLancamento)
    {
        $this->fkBeneficioBeneficiarioLancamentos->removeElement($fkBeneficioBeneficiarioLancamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioBeneficiarioLancamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\BeneficiarioLancamento
     */
    public function getFkBeneficioBeneficiarioLancamentos()
    {
        return $this->fkBeneficioBeneficiarioLancamentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContrato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato
     * @return Beneficiario
     */
    public function setFkPessoalContrato(\Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato)
    {
        $this->codContrato = $fkPessoalContrato->getCodContrato();
        $this->fkPessoalContrato = $fkPessoalContrato;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContrato
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    public function getFkPessoalContrato()
    {
        return $this->fkPessoalContrato;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Fornecedor $fkComprasFornecedor
     * @return Beneficiario
     */
    public function setFkComprasFornecedor(\Urbem\CoreBundle\Entity\Compras\Fornecedor $fkComprasFornecedor)
    {
        $this->cgmFornecedor = $fkComprasFornecedor->getCgmFornecedor();
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
     * Set fkBeneficioModalidadeConvenioMedico
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ModalidadeConvenioMedico $fkBeneficioModalidadeConvenioMedico
     * @return Beneficiario
     */
    public function setFkBeneficioModalidadeConvenioMedico(\Urbem\CoreBundle\Entity\Beneficio\ModalidadeConvenioMedico $fkBeneficioModalidadeConvenioMedico)
    {
        $this->codModalidade = $fkBeneficioModalidadeConvenioMedico->getCodModalidade();
        $this->fkBeneficioModalidadeConvenioMedico = $fkBeneficioModalidadeConvenioMedico;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkBeneficioModalidadeConvenioMedico
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\ModalidadeConvenioMedico
     */
    public function getFkBeneficioModalidadeConvenioMedico()
    {
        return $this->fkBeneficioModalidadeConvenioMedico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkBeneficioTipoConvenioMedico
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\TipoConvenioMedico $fkBeneficioTipoConvenioMedico
     * @return Beneficiario
     */
    public function setFkBeneficioTipoConvenioMedico(\Urbem\CoreBundle\Entity\Beneficio\TipoConvenioMedico $fkBeneficioTipoConvenioMedico)
    {
        $this->codTipoConvenio = $fkBeneficioTipoConvenioMedico->getCodTipoConvenio();
        $this->fkBeneficioTipoConvenioMedico = $fkBeneficioTipoConvenioMedico;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkBeneficioTipoConvenioMedico
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\TipoConvenioMedico
     */
    public function getFkBeneficioTipoConvenioMedico()
    {
        return $this->fkBeneficioTipoConvenioMedico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Beneficiario
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmBeneficiario = $fkSwCgm->getNumcgm();
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
     * Set fkCseGrauParentesco
     *
     * @param \Urbem\CoreBundle\Entity\Cse\GrauParentesco $fkCseGrauParentesco
     * @return Beneficiario
     */
    public function setFkCseGrauParentesco(\Urbem\CoreBundle\Entity\Cse\GrauParentesco $fkCseGrauParentesco)
    {
        $this->grauParentesco = $fkCseGrauParentesco->getCodGrau();
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
     * Set fkFolhapagamentoPeriodoMovimentacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao $fkFolhapagamentoPeriodoMovimentacao
     * @return Beneficiario
     */
    public function setFkFolhapagamentoPeriodoMovimentacao(\Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao $fkFolhapagamentoPeriodoMovimentacao)
    {
        $this->codPeriodoMovimentacao = $fkFolhapagamentoPeriodoMovimentacao->getCodPeriodoMovimentacao();
        $this->fkFolhapagamentoPeriodoMovimentacao = $fkFolhapagamentoPeriodoMovimentacao;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoPeriodoMovimentacao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao
     */
    public function getFkFolhapagamentoPeriodoMovimentacao()
    {
        return $this->fkFolhapagamentoPeriodoMovimentacao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->fkSwCgm->getNomCgm();
    }
}
