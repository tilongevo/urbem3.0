<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * EventoRescisaoCalculadoDependente
 */
class EventoRescisaoCalculadoDependente
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
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\EventoRescisaoCalculado
     */
    private $fkFolhapagamentoEventoRescisaoCalculado;

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
     * @return EventoRescisaoCalculadoDependente
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
     * @return EventoRescisaoCalculadoDependente
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
     * @return EventoRescisaoCalculadoDependente
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
     * @return EventoRescisaoCalculadoDependente
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
     * @return EventoRescisaoCalculadoDependente
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
     * @return EventoRescisaoCalculadoDependente
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
     * @return EventoRescisaoCalculadoDependente
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
     * @return EventoRescisaoCalculadoDependente
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
     * Set fkFolhapagamentoEventoRescisaoCalculado
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoRescisaoCalculado $fkFolhapagamentoEventoRescisaoCalculado
     * @return EventoRescisaoCalculadoDependente
     */
    public function setFkFolhapagamentoEventoRescisaoCalculado(\Urbem\CoreBundle\Entity\Folhapagamento\EventoRescisaoCalculado $fkFolhapagamentoEventoRescisaoCalculado)
    {
        $this->codEvento = $fkFolhapagamentoEventoRescisaoCalculado->getCodEvento();
        $this->codRegistro = $fkFolhapagamentoEventoRescisaoCalculado->getCodRegistro();
        $this->desdobramento = $fkFolhapagamentoEventoRescisaoCalculado->getDesdobramento();
        $this->timestampRegistro = $fkFolhapagamentoEventoRescisaoCalculado->getTimestampRegistro();
        $this->fkFolhapagamentoEventoRescisaoCalculado = $fkFolhapagamentoEventoRescisaoCalculado;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoEventoRescisaoCalculado
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\EventoRescisaoCalculado
     */
    public function getFkFolhapagamentoEventoRescisaoCalculado()
    {
        return $this->fkFolhapagamentoEventoRescisaoCalculado;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalDependente
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Dependente $fkPessoalDependente
     * @return EventoRescisaoCalculadoDependente
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
