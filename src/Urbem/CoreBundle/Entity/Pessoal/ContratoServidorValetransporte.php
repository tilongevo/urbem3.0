<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ContratoServidorValetransporte
 */
class ContratoServidorValetransporte
{
    /**
     * PK
     * @var integer
     */
    private $codVt;

    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var string
     */
    private $peridiocidade;

    /**
     * @var string
     */
    private $tipoPagamento;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidor;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codVt
     *
     * @param integer $codVt
     * @return ContratoServidorValetransporte
     */
    public function setCodVt($codVt)
    {
        $this->codVt = $codVt;
        return $this;
    }

    /**
     * Get codVt
     *
     * @return integer
     */
    public function getCodVt()
    {
        return $this->codVt;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoServidorValetransporte
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
     * Set quantidade
     *
     * @param integer $quantidade
     * @return ContratoServidorValetransporte
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    /**
     * Get quantidade
     *
     * @return integer
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set peridiocidade
     *
     * @param string $peridiocidade
     * @return ContratoServidorValetransporte
     */
    public function setPeridiocidade($peridiocidade)
    {
        $this->peridiocidade = $peridiocidade;
        return $this;
    }

    /**
     * Get peridiocidade
     *
     * @return string
     */
    public function getPeridiocidade()
    {
        return $this->peridiocidade;
    }

    /**
     * Set tipoPagamento
     *
     * @param string $tipoPagamento
     * @return ContratoServidorValetransporte
     */
    public function setTipoPagamento($tipoPagamento)
    {
        $this->tipoPagamento = $tipoPagamento;
        return $this;
    }

    /**
     * Get tipoPagamento
     *
     * @return string
     */
    public function getTipoPagamento()
    {
        return $this->tipoPagamento;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return ContratoServidorValetransporte
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return ContratoServidorValetransporte
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
