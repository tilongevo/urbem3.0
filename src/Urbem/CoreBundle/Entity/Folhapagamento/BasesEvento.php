<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * BasesEvento
 */
class BasesEvento
{
    /**
     * PK
     * @var integer
     */
    private $codBase;

    /**
     * PK
     * @var integer
     */
    private $codEvento;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Bases
     */
    private $fkFolhapagamentoBases;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    private $fkFolhapagamentoEvento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codBase
     *
     * @param integer $codBase
     * @return BasesEvento
     */
    public function setCodBase($codBase)
    {
        $this->codBase = $codBase;
        return $this;
    }

    /**
     * Get codBase
     *
     * @return integer
     */
    public function getCodBase()
    {
        return $this->codBase;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return BasesEvento
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return BasesEvento
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
     * Set fkFolhapagamentoBases
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Bases $fkFolhapagamentoBases
     * @return BasesEvento
     */
    public function setFkFolhapagamentoBases(\Urbem\CoreBundle\Entity\Folhapagamento\Bases $fkFolhapagamentoBases)
    {
        $this->codBase = $fkFolhapagamentoBases->getCodBase();
        $this->fkFolhapagamentoBases = $fkFolhapagamentoBases;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoBases
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Bases
     */
    public function getFkFolhapagamentoBases()
    {
        return $this->fkFolhapagamentoBases;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return BasesEvento
     */
    public function setFkFolhapagamentoEvento(\Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento)
    {
        $this->codEvento = $fkFolhapagamentoEvento->getCodEvento();
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
}
