<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * EventoDecimoCalculadoDependente
 */
class EventoDecimoCalculadoDependente
{
    /**
     * PK
     * @var integer
     */
    private $codEvento;

    /**
     * PK
     * @var integer
     */
    private $codRegistro;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampRegistro;

    /**
     * PK
     * @var string
     */
    private $desdobramento;

    /**
     * PK
     * @var integer
     */
    private $codDependente;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\EventoDecimoCalculado
     */
    private $fkFolhapagamentoEventoDecimoCalculado;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Dependente
     */
    private $fkPessoalDependente;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampRegistro = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return EventoDecimoCalculadoDependente
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
     * Set codRegistro
     *
     * @param integer $codRegistro
     * @return EventoDecimoCalculadoDependente
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
     * Set timestampRegistro
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampRegistro
     * @return EventoDecimoCalculadoDependente
     */
    public function setTimestampRegistro(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampRegistro)
    {
        $this->timestampRegistro = $timestampRegistro;
        return $this;
    }

    /**
     * Get timestampRegistro
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampRegistro()
    {
        return $this->timestampRegistro;
    }

    /**
     * Set desdobramento
     *
     * @param string $desdobramento
     * @return EventoDecimoCalculadoDependente
     */
    public function setDesdobramento($desdobramento)
    {
        $this->desdobramento = $desdobramento;
        return $this;
    }

    /**
     * Get desdobramento
     *
     * @return string
     */
    public function getDesdobramento()
    {
        return $this->desdobramento;
    }

    /**
     * Set codDependente
     *
     * @param integer $codDependente
     * @return EventoDecimoCalculadoDependente
     */
    public function setCodDependente($codDependente)
    {
        $this->codDependente = $codDependente;
        return $this;
    }

    /**
     * Get codDependente
     *
     * @return integer
     */
    public function getCodDependente()
    {
        return $this->codDependente;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return EventoDecimoCalculadoDependente
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
     * @return EventoDecimoCalculadoDependente
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return EventoDecimoCalculadoDependente
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
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEventoDecimoCalculado
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoDecimoCalculado $fkFolhapagamentoEventoDecimoCalculado
     * @return EventoDecimoCalculadoDependente
     */
    public function setFkFolhapagamentoEventoDecimoCalculado(\Urbem\CoreBundle\Entity\Folhapagamento\EventoDecimoCalculado $fkFolhapagamentoEventoDecimoCalculado)
    {
        $this->codEvento = $fkFolhapagamentoEventoDecimoCalculado->getCodEvento();
        $this->codRegistro = $fkFolhapagamentoEventoDecimoCalculado->getCodRegistro();
        $this->desdobramento = $fkFolhapagamentoEventoDecimoCalculado->getDesdobramento();
        $this->timestampRegistro = $fkFolhapagamentoEventoDecimoCalculado->getTimestampRegistro();
        $this->fkFolhapagamentoEventoDecimoCalculado = $fkFolhapagamentoEventoDecimoCalculado;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoEventoDecimoCalculado
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\EventoDecimoCalculado
     */
    public function getFkFolhapagamentoEventoDecimoCalculado()
    {
        return $this->fkFolhapagamentoEventoDecimoCalculado;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalDependente
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Dependente $fkPessoalDependente
     * @return EventoDecimoCalculadoDependente
     */
    public function setFkPessoalDependente(\Urbem\CoreBundle\Entity\Pessoal\Dependente $fkPessoalDependente)
    {
        $this->codDependente = $fkPessoalDependente->getCodDependente();
        $this->fkPessoalDependente = $fkPessoalDependente;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalDependente
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Dependente
     */
    public function getFkPessoalDependente()
    {
        return $this->fkPessoalDependente;
    }
}
