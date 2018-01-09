<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ContratoServidorHistoricoFuncional
 */
class ContratoServidorHistoricoFuncional
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var string
     */
    private $periodoMovimentacao;

    /**
     * @var integer
     */
    private $atoMovimentacao;

    /**
     * @var \DateTime
     */
    private $dataApresentada;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidor;


    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoServidorHistoricoFuncional
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
     * Set periodoMovimentacao
     *
     * @param string $periodoMovimentacao
     * @return ContratoServidorHistoricoFuncional
     */
    public function setPeriodoMovimentacao($periodoMovimentacao)
    {
        $this->periodoMovimentacao = $periodoMovimentacao;
        return $this;
    }

    /**
     * Get periodoMovimentacao
     *
     * @return string
     */
    public function getPeriodoMovimentacao()
    {
        return $this->periodoMovimentacao;
    }

    /**
     * Set atoMovimentacao
     *
     * @param integer $atoMovimentacao
     * @return ContratoServidorHistoricoFuncional
     */
    public function setAtoMovimentacao($atoMovimentacao)
    {
        $this->atoMovimentacao = $atoMovimentacao;
        return $this;
    }

    /**
     * Get atoMovimentacao
     *
     * @return integer
     */
    public function getAtoMovimentacao()
    {
        return $this->atoMovimentacao;
    }

    /**
     * Set dataApresentada
     *
     * @param \DateTime $dataApresentada
     * @return ContratoServidorHistoricoFuncional
     */
    public function setDataApresentada(\DateTime $dataApresentada)
    {
        $this->dataApresentada = $dataApresentada;
        return $this;
    }

    /**
     * Get dataApresentada
     *
     * @return \DateTime
     */
    public function getDataApresentada()
    {
        return $this->dataApresentada;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return ContratoServidorHistoricoFuncional
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
}
