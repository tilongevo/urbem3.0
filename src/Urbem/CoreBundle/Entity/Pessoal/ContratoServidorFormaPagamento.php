<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ContratoServidorFormaPagamento
 */
class ContratoServidorFormaPagamento
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codFormaPagamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\FormaPagamento
     */
    private $fkPessoalFormaPagamento;

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
     * @return ContratoServidorFormaPagamento
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ContratoServidorFormaPagamento
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
     * Set codFormaPagamento
     *
     * @param integer $codFormaPagamento
     * @return ContratoServidorFormaPagamento
     */
    public function setCodFormaPagamento($codFormaPagamento)
    {
        $this->codFormaPagamento = $codFormaPagamento;
        return $this;
    }

    /**
     * Get codFormaPagamento
     *
     * @return integer
     */
    public function getCodFormaPagamento()
    {
        return $this->codFormaPagamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return ContratoServidorFormaPagamento
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
     * Set fkPessoalFormaPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\FormaPagamento $fkPessoalFormaPagamento
     * @return ContratoServidorFormaPagamento
     */
    public function setFkPessoalFormaPagamento(\Urbem\CoreBundle\Entity\Pessoal\FormaPagamento $fkPessoalFormaPagamento)
    {
        $this->codFormaPagamento = $fkPessoalFormaPagamento->getCodFormaPagamento();
        $this->fkPessoalFormaPagamento = $fkPessoalFormaPagamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalFormaPagamento
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\FormaPagamento
     */
    public function getFkPessoalFormaPagamento()
    {
        return $this->fkPessoalFormaPagamento;
    }
}
