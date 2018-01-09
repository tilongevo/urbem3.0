<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * EventoCalculadoDependente
 */
class EventoCalculadoDependente
{
    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampRegistro;

    /**
     * PK
     * @var integer
     */
    private $codRegistro;

    /**
     * PK
     * @var integer
     */
    private $codEvento;

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
     * @var string
     */
    private $desdobramento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\EventoCalculado
     */
    private $fkFolhapagamentoEventoCalculado;

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
     * Set timestampRegistro
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampRegistro
     * @return EventoCalculadoDependente
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
     * Set codRegistro
     *
     * @param integer $codRegistro
     * @return EventoCalculadoDependente
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
     * Set codEvento
     *
     * @param integer $codEvento
     * @return EventoCalculadoDependente
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
     * Set codDependente
     *
     * @param integer $codDependente
     * @return EventoCalculadoDependente
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
     * @return EventoCalculadoDependente
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
     * @return EventoCalculadoDependente
     */
    public function setQuantidade($quantidade = null)
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
     * @return EventoCalculadoDependente
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
     * Set desdobramento
     *
     * @param string $desdobramento
     * @return EventoCalculadoDependente
     */
    public function setDesdobramento($desdobramento = null)
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
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEventoCalculado
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoCalculado $fkFolhapagamentoEventoCalculado
     * @return EventoCalculadoDependente
     */
    public function setFkFolhapagamentoEventoCalculado(\Urbem\CoreBundle\Entity\Folhapagamento\EventoCalculado $fkFolhapagamentoEventoCalculado)
    {
        $this->codEvento = $fkFolhapagamentoEventoCalculado->getCodEvento();
        $this->codRegistro = $fkFolhapagamentoEventoCalculado->getCodRegistro();
        $this->timestampRegistro = $fkFolhapagamentoEventoCalculado->getTimestampRegistro();
        $this->fkFolhapagamentoEventoCalculado = $fkFolhapagamentoEventoCalculado;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoEventoCalculado
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\EventoCalculado
     */
    public function getFkFolhapagamentoEventoCalculado()
    {
        return $this->fkFolhapagamentoEventoCalculado;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalDependente
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Dependente $fkPessoalDependente
     * @return EventoCalculadoDependente
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
