<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * RegistroEventoOrdenado
 */
class RegistroEventoOrdenado
{
    /**
     * PK
     * @var integer
     */
    private $codEvento;

    /**
     * @var string
     */
    private $codigo;

    /**
     * @var integer
     */
    private $codRegistro;

    /**
     * @var integer
     */
    private $codContrato;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var boolean
     */
    private $proporcional;

    /**
     * @var integer
     */
    private $parcela;

    /**
     * @var integer
     */
    private $codPeriodoMovimentacao;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var string
     */
    private $formula;

    /**
     * @var string
     */
    private $natureza;

    /**
     * @var integer
     */
    private $codConfiguracao;

    /**
     * @var integer
     */
    private $sequencia;


    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return RegistroEventoOrdenado
     */
    public function setCodEvento($codEvento)
    {
        $this->codEvento = $codEvento;
        return $this;
    }

    /**
     * Get codEvento
     *
     * @return integer
     */
    public function getCodEvento()
    {
        return $this->codEvento;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return RegistroEventoOrdenado
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set codRegistro
     *
     * @param integer $codRegistro
     * @return RegistroEventoOrdenado
     */
    public function setCodRegistro($codRegistro)
    {
        $this->codRegistro = $codRegistro;
        return $this;
    }

    /**
     * Get codRegistro
     *
     * @return integer
     */
    public function getCodRegistro()
    {
        return $this->codRegistro;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return RegistroEventoOrdenado
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
     * Set valor
     *
     * @param integer $valor
     * @return RegistroEventoOrdenado
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
     * @return RegistroEventoOrdenado
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
     * Set proporcional
     *
     * @param boolean $proporcional
     * @return RegistroEventoOrdenado
     */
    public function setProporcional($proporcional)
    {
        $this->proporcional = $proporcional;
        return $this;
    }

    /**
     * Get proporcional
     *
     * @return boolean
     */
    public function getProporcional()
    {
        return $this->proporcional;
    }

    /**
     * Set parcela
     *
     * @param integer $parcela
     * @return RegistroEventoOrdenado
     */
    public function setParcela($parcela = null)
    {
        $this->parcela = $parcela;
        return $this;
    }

    /**
     * Get parcela
     *
     * @return integer
     */
    public function getParcela()
    {
        return $this->parcela;
    }

    /**
     * Set codPeriodoMovimentacao
     *
     * @param integer $codPeriodoMovimentacao
     * @return RegistroEventoOrdenado
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return RegistroEventoOrdenado
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
     * Set formula
     *
     * @param string $formula
     * @return RegistroEventoOrdenado
     */
    public function setFormula($formula = null)
    {
        $this->formula = $formula;
        return $this;
    }

    /**
     * Get formula
     *
     * @return string
     */
    public function getFormula()
    {
        return $this->formula;
    }

    /**
     * Set natureza
     *
     * @param string $natureza
     * @return RegistroEventoOrdenado
     */
    public function setNatureza($natureza)
    {
        $this->natureza = $natureza;
        return $this;
    }

    /**
     * Get natureza
     *
     * @return string
     */
    public function getNatureza()
    {
        return $this->natureza;
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return RegistroEventoOrdenado
     */
    public function setCodConfiguracao($codConfiguracao)
    {
        $this->codConfiguracao = $codConfiguracao;
        return $this;
    }

    /**
     * Get codConfiguracao
     *
     * @return integer
     */
    public function getCodConfiguracao()
    {
        return $this->codConfiguracao;
    }

    /**
     * Set sequencia
     *
     * @param integer $sequencia
     * @return RegistroEventoOrdenado
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }
}
