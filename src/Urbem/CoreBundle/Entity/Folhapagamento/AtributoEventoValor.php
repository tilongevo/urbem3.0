<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * AtributoEventoValor
 */
class AtributoEventoValor
{
    /**
     * PK
     * @var integer
     */
    private $codEvento;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestampEvento;

    /**
     * PK
     * @var integer
     */
    private $codCadastro;

    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\EventoEvento
     */
    private $fkFolhapagamentoEventoEvento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamico;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampEvento = new \Urbem\CoreBundle\Helper\DateTimePK;
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return AtributoEventoValor
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
     * Set timestampEvento
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestampEvento
     * @return AtributoEventoValor
     */
    public function setTimestampEvento(\Urbem\CoreBundle\Helper\DateTimePK $timestampEvento)
    {
        $this->timestampEvento = $timestampEvento;
        return $this;
    }

    /**
     * Get timestampEvento
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestampEvento()
    {
        return $this->timestampEvento;
    }

    /**
     * Set codCadastro
     *
     * @param integer $codCadastro
     * @return AtributoEventoValor
     */
    public function setCodCadastro($codCadastro)
    {
        $this->codCadastro = $codCadastro;
        return $this;
    }

    /**
     * Get codCadastro
     *
     * @return integer
     */
    public function getCodCadastro()
    {
        return $this->codCadastro;
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoEventoValor
     */
    public function setCodAtributo($codAtributo)
    {
        $this->codAtributo = $codAtributo;
        return $this;
    }

    /**
     * Get codAtributo
     *
     * @return integer
     */
    public function getCodAtributo()
    {
        return $this->codAtributo;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoEventoValor
     */
    public function setCodModulo($codModulo)
    {
        $this->codModulo = $codModulo;
        return $this;
    }

    /**
     * Get codModulo
     *
     * @return integer
     */
    public function getCodModulo()
    {
        return $this->codModulo;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return AtributoEventoValor
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
     * Set valor
     *
     * @param string $valor
     * @return AtributoEventoValor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEventoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoEvento $fkFolhapagamentoEventoEvento
     * @return AtributoEventoValor
     */
    public function setFkFolhapagamentoEventoEvento(\Urbem\CoreBundle\Entity\Folhapagamento\EventoEvento $fkFolhapagamentoEventoEvento)
    {
        $this->codEvento = $fkFolhapagamentoEventoEvento->getCodEvento();
        $this->timestampEvento = $fkFolhapagamentoEventoEvento->getTimestamp();
        $this->fkFolhapagamentoEventoEvento = $fkFolhapagamentoEventoEvento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoEventoEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\EventoEvento
     */
    public function getFkFolhapagamentoEventoEvento()
    {
        return $this->fkFolhapagamentoEventoEvento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return AtributoEventoValor
     */
    public function setFkAdministracaoAtributoDinamico(\Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico)
    {
        $this->codModulo = $fkAdministracaoAtributoDinamico->getCodModulo();
        $this->codCadastro = $fkAdministracaoAtributoDinamico->getCodCadastro();
        $this->codAtributo = $fkAdministracaoAtributoDinamico->getCodAtributo();
        $this->fkAdministracaoAtributoDinamico = $fkAdministracaoAtributoDinamico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoAtributoDinamico
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    public function getFkAdministracaoAtributoDinamico()
    {
        return $this->fkAdministracaoAtributoDinamico;
    }
}
