<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ContratoServidorNivelPadrao
 */
class ContratoServidorNivelPadrao
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
    private $codNivelPadrao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codPeriodoMovimentacao;

    /**
     * @var boolean
     */
    private $reajuste = false;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\NivelPadrao
     */
    private $fkFolhapagamentoNivelPadrao;

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
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoServidorNivelPadrao
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
     * Set codNivelPadrao
     *
     * @param integer $codNivelPadrao
     * @return ContratoServidorNivelPadrao
     */
    public function setCodNivelPadrao($codNivelPadrao)
    {
        $this->codNivelPadrao = $codNivelPadrao;
        return $this;
    }

    /**
     * Get codNivelPadrao
     *
     * @return integer
     */
    public function getCodNivelPadrao()
    {
        return $this->codNivelPadrao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ContratoServidorNivelPadrao
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
     * Set codPeriodoMovimentacao
     *
     * @param integer $codPeriodoMovimentacao
     * @return ContratoServidorNivelPadrao
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
     * Set reajuste
     *
     * @param boolean $reajuste
     * @return ContratoServidorNivelPadrao
     */
    public function setReajuste($reajuste)
    {
        $this->reajuste = $reajuste;
        return $this;
    }

    /**
     * Get reajuste
     *
     * @return boolean
     */
    public function getReajuste()
    {
        return $this->reajuste;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return ContratoServidorNivelPadrao
     */
    public function setFkPessoalContratoServidor(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        $this->codContrato = $fkPessoalContratoServidor->getCodContrato();
        $this->fkPessoalContratoServidor = $fkPessoalContratoServidor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContratoServidor
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    public function getFkPessoalContratoServidor()
    {
        return $this->fkPessoalContratoServidor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoNivelPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\NivelPadrao $fkFolhapagamentoNivelPadrao
     * @return ContratoServidorNivelPadrao
     */
    public function setFkFolhapagamentoNivelPadrao(\Urbem\CoreBundle\Entity\Folhapagamento\NivelPadrao $fkFolhapagamentoNivelPadrao)
    {
        $this->codNivelPadrao = $fkFolhapagamentoNivelPadrao->getCodNivelPadrao();
        $this->fkFolhapagamentoNivelPadrao = $fkFolhapagamentoNivelPadrao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoNivelPadrao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\NivelPadrao
     */
    public function getFkFolhapagamentoNivelPadrao()
    {
        return $this->fkFolhapagamentoNivelPadrao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoPeriodoMovimentacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao $fkFolhapagamentoPeriodoMovimentacao
     * @return ContratoServidorNivelPadrao
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
