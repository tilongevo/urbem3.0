<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AssentamentoFaixaDesconto
 */
class AssentamentoFaixaDesconto
{
    /**
     * PK
     * @var integer
     */
    private $codFaixa;

    /**
     * PK
     * @var integer
     */
    private $codAssentamento;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $valorInicial;

    /**
     * @var integer
     */
    private $valorFinal;

    /**
     * @var integer
     */
    private $percentualDesconto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAfastamentoTemporario
     */
    private $fkPessoalAssentamentoAfastamentoTemporario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codFaixa
     *
     * @param integer $codFaixa
     * @return AssentamentoFaixaDesconto
     */
    public function setCodFaixa($codFaixa)
    {
        $this->codFaixa = $codFaixa;
        return $this;
    }

    /**
     * Get codFaixa
     *
     * @return integer
     */
    public function getCodFaixa()
    {
        return $this->codFaixa;
    }

    /**
     * Set codAssentamento
     *
     * @param integer $codAssentamento
     * @return AssentamentoFaixaDesconto
     */
    public function setCodAssentamento($codAssentamento)
    {
        $this->codAssentamento = $codAssentamento;
        return $this;
    }

    /**
     * Get codAssentamento
     *
     * @return integer
     */
    public function getCodAssentamento()
    {
        return $this->codAssentamento;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return AssentamentoFaixaDesconto
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
     * Set valorInicial
     *
     * @param integer $valorInicial
     * @return AssentamentoFaixaDesconto
     */
    public function setValorInicial($valorInicial)
    {
        $this->valorInicial = $valorInicial;
        return $this;
    }

    /**
     * Get valorInicial
     *
     * @return integer
     */
    public function getValorInicial()
    {
        return $this->valorInicial;
    }

    /**
     * Set valorFinal
     *
     * @param integer $valorFinal
     * @return AssentamentoFaixaDesconto
     */
    public function setValorFinal($valorFinal)
    {
        $this->valorFinal = $valorFinal;
        return $this;
    }

    /**
     * Get valorFinal
     *
     * @return integer
     */
    public function getValorFinal()
    {
        return $this->valorFinal;
    }

    /**
     * Set percentualDesconto
     *
     * @param integer $percentualDesconto
     * @return AssentamentoFaixaDesconto
     */
    public function setPercentualDesconto($percentualDesconto)
    {
        $this->percentualDesconto = $percentualDesconto;
        return $this;
    }

    /**
     * Get percentualDesconto
     *
     * @return integer
     */
    public function getPercentualDesconto()
    {
        return $this->percentualDesconto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalAssentamentoAfastamentoTemporario
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAfastamentoTemporario $fkPessoalAssentamentoAfastamentoTemporario
     * @return AssentamentoFaixaDesconto
     */
    public function setFkPessoalAssentamentoAfastamentoTemporario(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAfastamentoTemporario $fkPessoalAssentamentoAfastamentoTemporario)
    {
        $this->codAssentamento = $fkPessoalAssentamentoAfastamentoTemporario->getCodAssentamento();
        $this->timestamp = $fkPessoalAssentamentoAfastamentoTemporario->getTimestamp();
        $this->fkPessoalAssentamentoAfastamentoTemporario = $fkPessoalAssentamentoAfastamentoTemporario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalAssentamentoAfastamentoTemporario
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAfastamentoTemporario
     */
    public function getFkPessoalAssentamentoAfastamentoTemporario()
    {
        return $this->fkPessoalAssentamentoAfastamentoTemporario;
    }
}
