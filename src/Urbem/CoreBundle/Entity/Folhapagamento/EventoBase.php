<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * EventoBase
 */
class EventoBase
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
    private $codEventoBase;

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
     * PK
     * @var integer
     */
    private $codCaso;

    /**
     * PK
     * @var integer
     */
    private $codCasoBase;

    /**
     * PK
     * @var integer
     */
    private $codConfiguracaoBase;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampBase;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso
     */
    private $fkFolhapagamentoConfiguracaoEventoCaso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso
     */
    private $fkFolhapagamentoConfiguracaoEventoCaso1;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampBase = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return EventoBase
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
     * Set codEventoBase
     *
     * @param integer $codEventoBase
     * @return EventoBase
     */
    public function setCodEventoBase($codEventoBase)
    {
        $this->codEventoBase = $codEventoBase;
        return $this;
    }

    /**
     * Get codEventoBase
     *
     * @return integer
     */
    public function getCodEventoBase()
    {
        return $this->codEventoBase;
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return EventoBase
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
     * @return EventoBase
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
     * Set codCaso
     *
     * @param integer $codCaso
     * @return EventoBase
     */
    public function setCodCaso($codCaso)
    {
        $this->codCaso = $codCaso;
        return $this;
    }

    /**
     * Get codCaso
     *
     * @return integer
     */
    public function getCodCaso()
    {
        return $this->codCaso;
    }

    /**
     * Set codCasoBase
     *
     * @param integer $codCasoBase
     * @return EventoBase
     */
    public function setCodCasoBase($codCasoBase)
    {
        $this->codCasoBase = $codCasoBase;
        return $this;
    }

    /**
     * Get codCasoBase
     *
     * @return integer
     */
    public function getCodCasoBase()
    {
        return $this->codCasoBase;
    }

    /**
     * Set codConfiguracaoBase
     *
     * @param integer $codConfiguracaoBase
     * @return EventoBase
     */
    public function setCodConfiguracaoBase($codConfiguracaoBase)
    {
        $this->codConfiguracaoBase = $codConfiguracaoBase;
        return $this;
    }

    /**
     * Get codConfiguracaoBase
     *
     * @return integer
     */
    public function getCodConfiguracaoBase()
    {
        return $this->codConfiguracaoBase;
    }

    /**
     * Set timestampBase
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampBase
     * @return EventoBase
     */
    public function setTimestampBase(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampBase)
    {
        $this->timestampBase = $timestampBase;
        return $this;
    }

    /**
     * Get timestampBase
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampBase()
    {
        return $this->timestampBase;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoConfiguracaoEventoCaso
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso $fkFolhapagamentoConfiguracaoEventoCaso
     * @return EventoBase
     */
    public function setFkFolhapagamentoConfiguracaoEventoCaso(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso $fkFolhapagamentoConfiguracaoEventoCaso)
    {
        $this->codCaso = $fkFolhapagamentoConfiguracaoEventoCaso->getCodCaso();
        $this->codEvento = $fkFolhapagamentoConfiguracaoEventoCaso->getCodEvento();
        $this->timestamp = $fkFolhapagamentoConfiguracaoEventoCaso->getTimestamp();
        $this->codConfiguracao = $fkFolhapagamentoConfiguracaoEventoCaso->getCodConfiguracao();
        $this->fkFolhapagamentoConfiguracaoEventoCaso = $fkFolhapagamentoConfiguracaoEventoCaso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoConfiguracaoEventoCaso
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso
     */
    public function getFkFolhapagamentoConfiguracaoEventoCaso()
    {
        return $this->fkFolhapagamentoConfiguracaoEventoCaso;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoConfiguracaoEventoCaso1
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso $fkFolhapagamentoConfiguracaoEventoCaso1
     * @return EventoBase
     */
    public function setFkFolhapagamentoConfiguracaoEventoCaso1(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso $fkFolhapagamentoConfiguracaoEventoCaso1)
    {
        $this->codCasoBase = $fkFolhapagamentoConfiguracaoEventoCaso1->getCodCaso();
        $this->codEventoBase = $fkFolhapagamentoConfiguracaoEventoCaso1->getCodEvento();
        $this->timestampBase = $fkFolhapagamentoConfiguracaoEventoCaso1->getTimestamp();
        $this->codConfiguracaoBase = $fkFolhapagamentoConfiguracaoEventoCaso1->getCodConfiguracao();
        $this->fkFolhapagamentoConfiguracaoEventoCaso1 = $fkFolhapagamentoConfiguracaoEventoCaso1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoConfiguracaoEventoCaso1
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso
     */
    public function getFkFolhapagamentoConfiguracaoEventoCaso1()
    {
        return $this->fkFolhapagamentoConfiguracaoEventoCaso1;
    }
}
