<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ValorDiversos
 */
class ValorDiversos
{
    /**
     * PK
     * @var integer
     */
    private $codValor;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dataVigencia;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var boolean
     */
    private $ativo = true;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->dataVigencia = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set codValor
     *
     * @param integer $codValor
     * @return ValorDiversos
     */
    public function setCodValor($codValor)
    {
        $this->codValor = $codValor;
        return $this;
    }

    /**
     * Get codValor
     *
     * @return integer
     */
    public function getCodValor()
    {
        return $this->codValor;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ValorDiversos
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
     * Set dataVigencia
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dataVigencia
     * @return ValorDiversos
     */
    public function setDataVigencia(\Urbem\CoreBundle\Helper\DatePK $dataVigencia)
    {
        $this->dataVigencia = $dataVigencia;
        return $this;
    }

    /**
     * Get dataVigencia
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDataVigencia()
    {
        return $this->dataVigencia;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ValorDiversos
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return ValorDiversos
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
     * Set ativo
     *
     * @param boolean $ativo
     * @return ValorDiversos
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
     * @return string
     */
    public function __toString()
    {
        return (string) $this->descricao;
    }
}
