<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoEventosDescontoExterno
 */
class ConfiguracaoEventosDescontoExterno
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $eventoDescontoIrrf;

    /**
     * @var integer
     */
    private $eventoBaseIrrf;

    /**
     * @var integer
     */
    private $eventoDescontoPrevidencia;

    /**
     * @var integer
     */
    private $eventoBasePrevidencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    private $fkFolhapagamentoEvento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    private $fkFolhapagamentoEvento1;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    private $fkFolhapagamentoEvento2;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    private $fkFolhapagamentoEvento3;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ConfiguracaoEventosDescontoExterno
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ConfiguracaoEventosDescontoExterno
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
     * Set eventoDescontoIrrf
     *
     * @param integer $eventoDescontoIrrf
     * @return ConfiguracaoEventosDescontoExterno
     */
    public function setEventoDescontoIrrf($eventoDescontoIrrf)
    {
        $this->eventoDescontoIrrf = $eventoDescontoIrrf;
        return $this;
    }

    /**
     * Get eventoDescontoIrrf
     *
     * @return integer
     */
    public function getEventoDescontoIrrf()
    {
        return $this->eventoDescontoIrrf;
    }

    /**
     * Set eventoBaseIrrf
     *
     * @param integer $eventoBaseIrrf
     * @return ConfiguracaoEventosDescontoExterno
     */
    public function setEventoBaseIrrf($eventoBaseIrrf)
    {
        $this->eventoBaseIrrf = $eventoBaseIrrf;
        return $this;
    }

    /**
     * Get eventoBaseIrrf
     *
     * @return integer
     */
    public function getEventoBaseIrrf()
    {
        return $this->eventoBaseIrrf;
    }

    /**
     * Set eventoDescontoPrevidencia
     *
     * @param integer $eventoDescontoPrevidencia
     * @return ConfiguracaoEventosDescontoExterno
     */
    public function setEventoDescontoPrevidencia($eventoDescontoPrevidencia)
    {
        $this->eventoDescontoPrevidencia = $eventoDescontoPrevidencia;
        return $this;
    }

    /**
     * Get eventoDescontoPrevidencia
     *
     * @return integer
     */
    public function getEventoDescontoPrevidencia()
    {
        return $this->eventoDescontoPrevidencia;
    }

    /**
     * Set eventoBasePrevidencia
     *
     * @param integer $eventoBasePrevidencia
     * @return ConfiguracaoEventosDescontoExterno
     */
    public function setEventoBasePrevidencia($eventoBasePrevidencia)
    {
        $this->eventoBasePrevidencia = $eventoBasePrevidencia;
        return $this;
    }

    /**
     * Get eventoBasePrevidencia
     *
     * @return integer
     */
    public function getEventoBasePrevidencia()
    {
        return $this->eventoBasePrevidencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return ConfiguracaoEventosDescontoExterno
     */
    public function setFkFolhapagamentoEvento(\Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento)
    {
        $this->eventoDescontoIrrf = $fkFolhapagamentoEvento->getCodEvento();
        $this->fkFolhapagamentoEvento = $fkFolhapagamentoEvento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    public function getFkFolhapagamentoEvento()
    {
        return $this->fkFolhapagamentoEvento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento1
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento1
     * @return ConfiguracaoEventosDescontoExterno
     */
    public function setFkFolhapagamentoEvento1(\Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento1)
    {
        $this->eventoBaseIrrf = $fkFolhapagamentoEvento1->getCodEvento();
        $this->fkFolhapagamentoEvento1 = $fkFolhapagamentoEvento1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoEvento1
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    public function getFkFolhapagamentoEvento1()
    {
        return $this->fkFolhapagamentoEvento1;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento2
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento2
     * @return ConfiguracaoEventosDescontoExterno
     */
    public function setFkFolhapagamentoEvento2(\Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento2)
    {
        $this->eventoDescontoPrevidencia = $fkFolhapagamentoEvento2->getCodEvento();
        $this->fkFolhapagamentoEvento2 = $fkFolhapagamentoEvento2;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoEvento2
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    public function getFkFolhapagamentoEvento2()
    {
        return $this->fkFolhapagamentoEvento2;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento3
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento3
     * @return ConfiguracaoEventosDescontoExterno
     */
    public function setFkFolhapagamentoEvento3(\Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento3)
    {
        $this->eventoBasePrevidencia = $fkFolhapagamentoEvento3->getCodEvento();
        $this->fkFolhapagamentoEvento3 = $fkFolhapagamentoEvento3;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoEvento3
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    public function getFkFolhapagamentoEvento3()
    {
        return $this->fkFolhapagamentoEvento3;
    }
}
