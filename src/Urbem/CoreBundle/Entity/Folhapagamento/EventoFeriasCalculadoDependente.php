<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * EventoFeriasCalculadoDependente
 */
class EventoFeriasCalculadoDependente
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
     * @var string
     */
    private $desdobramento;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampRegistro;

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
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\EventoFeriasCalculado
     */
    private $fkFolhapagamentoEventoFeriasCalculado;

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
     * @return EventoFeriasCalculadoDependente
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
     * @return EventoFeriasCalculadoDependente
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
     * Set desdobramento
     *
     * @param string $desdobramento
     * @return EventoFeriasCalculadoDependente
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
     * Set timestampRegistro
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampRegistro
     * @return EventoFeriasCalculadoDependente
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
     * Set codDependente
     *
     * @param integer $codDependente
     * @return EventoFeriasCalculadoDependente
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
     * @return EventoFeriasCalculadoDependente
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
     * @return EventoFeriasCalculadoDependente
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
     * @return EventoFeriasCalculadoDependente
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
     * Set fkFolhapagamentoEventoFeriasCalculado
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoFeriasCalculado $fkFolhapagamentoEventoFeriasCalculado
     * @return EventoFeriasCalculadoDependente
     */
    public function setFkFolhapagamentoEventoFeriasCalculado(\Urbem\CoreBundle\Entity\Folhapagamento\EventoFeriasCalculado $fkFolhapagamentoEventoFeriasCalculado)
    {
        $this->codRegistro = $fkFolhapagamentoEventoFeriasCalculado->getCodRegistro();
        $this->codEvento = $fkFolhapagamentoEventoFeriasCalculado->getCodEvento();
        $this->timestampRegistro = $fkFolhapagamentoEventoFeriasCalculado->getTimestampRegistro();
        $this->desdobramento = $fkFolhapagamentoEventoFeriasCalculado->getDesdobramento();
        $this->fkFolhapagamentoEventoFeriasCalculado = $fkFolhapagamentoEventoFeriasCalculado;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoEventoFeriasCalculado
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\EventoFeriasCalculado
     */
    public function getFkFolhapagamentoEventoFeriasCalculado()
    {
        return $this->fkFolhapagamentoEventoFeriasCalculado;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalDependente
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Dependente $fkPessoalDependente
     * @return EventoFeriasCalculadoDependente
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
