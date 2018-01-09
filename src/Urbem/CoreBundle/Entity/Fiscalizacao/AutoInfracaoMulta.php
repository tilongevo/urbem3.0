<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * AutoInfracaoMulta
 */
class AutoInfracaoMulta
{
    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var integer
     */
    private $codAutoFiscalizacao;

    /**
     * PK
     * @var integer
     */
    private $codInfracao;

    /**
     * PK
     * @var integer
     */
    private $codPenalidade;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var integer
     */
    private $baseCalculo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracao
     */
    private $fkFiscalizacaoAutoInfracao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return AutoInfracaoMulta
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set codAutoFiscalizacao
     *
     * @param integer $codAutoFiscalizacao
     * @return AutoInfracaoMulta
     */
    public function setCodAutoFiscalizacao($codAutoFiscalizacao)
    {
        $this->codAutoFiscalizacao = $codAutoFiscalizacao;
        return $this;
    }

    /**
     * Get codAutoFiscalizacao
     *
     * @return integer
     */
    public function getCodAutoFiscalizacao()
    {
        return $this->codAutoFiscalizacao;
    }

    /**
     * Set codInfracao
     *
     * @param integer $codInfracao
     * @return AutoInfracaoMulta
     */
    public function setCodInfracao($codInfracao)
    {
        $this->codInfracao = $codInfracao;
        return $this;
    }

    /**
     * Get codInfracao
     *
     * @return integer
     */
    public function getCodInfracao()
    {
        return $this->codInfracao;
    }

    /**
     * Set codPenalidade
     *
     * @param integer $codPenalidade
     * @return AutoInfracaoMulta
     */
    public function setCodPenalidade($codPenalidade)
    {
        $this->codPenalidade = $codPenalidade;
        return $this;
    }

    /**
     * Get codPenalidade
     *
     * @return integer
     */
    public function getCodPenalidade()
    {
        return $this->codPenalidade;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return AutoInfracaoMulta
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return AutoInfracaoMulta
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
     * Set quantidade
     *
     * @param integer $quantidade
     * @return AutoInfracaoMulta
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
     * Set baseCalculo
     *
     * @param integer $baseCalculo
     * @return AutoInfracaoMulta
     */
    public function setBaseCalculo($baseCalculo)
    {
        $this->baseCalculo = $baseCalculo;
        return $this;
    }

    /**
     * Get baseCalculo
     *
     * @return integer
     */
    public function getBaseCalculo()
    {
        return $this->baseCalculo;
    }

    /**
     * OneToOne (owning side)
     * Set FiscalizacaoAutoInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracao $fkFiscalizacaoAutoInfracao
     * @return AutoInfracaoMulta
     */
    public function setFkFiscalizacaoAutoInfracao(\Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracao $fkFiscalizacaoAutoInfracao)
    {
        $this->codProcesso = $fkFiscalizacaoAutoInfracao->getCodProcesso();
        $this->codAutoFiscalizacao = $fkFiscalizacaoAutoInfracao->getCodAutoFiscalizacao();
        $this->codPenalidade = $fkFiscalizacaoAutoInfracao->getCodPenalidade();
        $this->codInfracao = $fkFiscalizacaoAutoInfracao->getCodInfracao();
        $this->timestamp = $fkFiscalizacaoAutoInfracao->getTimestamp();
        $this->fkFiscalizacaoAutoInfracao = $fkFiscalizacaoAutoInfracao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFiscalizacaoAutoInfracao
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracao
     */
    public function getFkFiscalizacaoAutoInfracao()
    {
        return $this->fkFiscalizacaoAutoInfracao;
    }
}
