<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AssentamentoFaixaCorrecao
 */
class AssentamentoFaixaCorrecao
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
    private $quantMeses;

    /**
     * @var integer
     */
    private $percentualCorrecao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoVantagem
     */
    private $fkPessoalAssentamentoVantagem;

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
     * @return AssentamentoFaixaCorrecao
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
     * @return AssentamentoFaixaCorrecao
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
     * @return AssentamentoFaixaCorrecao
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
     * Set quantMeses
     *
     * @param integer $quantMeses
     * @return AssentamentoFaixaCorrecao
     */
    public function setQuantMeses($quantMeses)
    {
        $this->quantMeses = $quantMeses;
        return $this;
    }

    /**
     * Get quantMeses
     *
     * @return integer
     */
    public function getQuantMeses()
    {
        return $this->quantMeses;
    }

    /**
     * Set percentualCorrecao
     *
     * @param integer $percentualCorrecao
     * @return AssentamentoFaixaCorrecao
     */
    public function setPercentualCorrecao($percentualCorrecao)
    {
        $this->percentualCorrecao = $percentualCorrecao;
        return $this;
    }

    /**
     * Get percentualCorrecao
     *
     * @return integer
     */
    public function getPercentualCorrecao()
    {
        return $this->percentualCorrecao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalAssentamentoVantagem
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoVantagem $fkPessoalAssentamentoVantagem
     * @return AssentamentoFaixaCorrecao
     */
    public function setFkPessoalAssentamentoVantagem(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoVantagem $fkPessoalAssentamentoVantagem)
    {
        $this->codAssentamento = $fkPessoalAssentamentoVantagem->getCodAssentamento();
        $this->timestamp = $fkPessoalAssentamentoVantagem->getTimestamp();
        $this->fkPessoalAssentamentoVantagem = $fkPessoalAssentamentoVantagem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalAssentamentoVantagem
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AssentamentoVantagem
     */
    public function getFkPessoalAssentamentoVantagem()
    {
        return $this->fkPessoalAssentamentoVantagem;
    }
}
