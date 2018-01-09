<?php
 
namespace Urbem\CoreBundle\Entity\Beneficio;

/**
 * BeneficiarioLancamento
 */
class BeneficiarioLancamento
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
     * @var integer
     */
    private $codigoUsuario;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampLancamento;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var integer
     */
    private $codPeriodoMovimentacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Beneficio\Beneficiario
     */
    private $fkBeneficioBeneficiario;

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
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampLancamento = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return BeneficiarioLancamento
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
     * @return BeneficiarioLancamento
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
     * @return BeneficiarioLancamento
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
     * @return BeneficiarioLancamento
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
     * Set codigoUsuario
     *
     * @param integer $codigoUsuario
     * @return BeneficiarioLancamento
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return BeneficiarioLancamento
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
     * Set timestampLancamento
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampLancamento
     * @return BeneficiarioLancamento
     */
    public function setTimestampLancamento(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampLancamento)
    {
        $this->timestampLancamento = $timestampLancamento;
        return $this;
    }

    /**
     * Get timestampLancamento
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampLancamento()
    {
        return $this->timestampLancamento;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return BeneficiarioLancamento
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
     * Set codPeriodoMovimentacao
     *
     * @param integer $codPeriodoMovimentacao
     * @return BeneficiarioLancamento
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
     * ManyToOne (inverse side)
     * Set fkBeneficioBeneficiario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario
     * @return BeneficiarioLancamento
     */
    public function setFkBeneficioBeneficiario(\Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario)
    {
        $this->codContrato = $fkBeneficioBeneficiario->getCodContrato();
        $this->cgmFornecedor = $fkBeneficioBeneficiario->getCgmFornecedor();
        $this->codModalidade = $fkBeneficioBeneficiario->getCodModalidade();
        $this->codTipoConvenio = $fkBeneficioBeneficiario->getCodTipoConvenio();
        $this->timestamp = $fkBeneficioBeneficiario->getTimestamp();
        $this->codigoUsuario = $fkBeneficioBeneficiario->getCodigoUsuario();
        $this->fkBeneficioBeneficiario = $fkBeneficioBeneficiario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkBeneficioBeneficiario
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\Beneficiario
     */
    public function getFkBeneficioBeneficiario()
    {
        return $this->fkBeneficioBeneficiario;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoPeriodoMovimentacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao $fkFolhapagamentoPeriodoMovimentacao
     * @return BeneficiarioLancamento
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
}
