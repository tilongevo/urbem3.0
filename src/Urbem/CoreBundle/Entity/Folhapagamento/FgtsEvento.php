<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * FgtsEvento
 */
class FgtsEvento
{
    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var integer
     */
    private $codFgts;

    /**
     * @var integer
     */
    private $codEvento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Fgts
     */
    private $fkFolhapagamentoFgts;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoFgts
     */
    private $fkFolhapagamentoTipoEventoFgts;

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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return FgtsEvento
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return FgtsEvento
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set codFgts
     *
     * @param integer $codFgts
     * @return FgtsEvento
     */
    public function setCodFgts($codFgts)
    {
        $this->codFgts = $codFgts;
        return $this;
    }

    /**
     * Get codFgts
     *
     * @return integer
     */
    public function getCodFgts()
    {
        return $this->codFgts;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return FgtsEvento
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
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoFgts
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Fgts $fkFolhapagamentoFgts
     * @return FgtsEvento
     */
    public function setFkFolhapagamentoFgts(\Urbem\CoreBundle\Entity\Folhapagamento\Fgts $fkFolhapagamentoFgts)
    {
        $this->codFgts = $fkFolhapagamentoFgts->getCodFgts();
        $this->timestamp = $fkFolhapagamentoFgts->getTimestamp();
        $this->fkFolhapagamentoFgts = $fkFolhapagamentoFgts;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoFgts
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Fgts
     */
    public function getFkFolhapagamentoFgts()
    {
        return $this->fkFolhapagamentoFgts;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoTipoEventoFgts
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoFgts $fkFolhapagamentoTipoEventoFgts
     * @return FgtsEvento
     */
    public function setFkFolhapagamentoTipoEventoFgts(\Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoFgts $fkFolhapagamentoTipoEventoFgts)
    {
        $this->codTipo = $fkFolhapagamentoTipoEventoFgts->getCodTipo();
        $this->fkFolhapagamentoTipoEventoFgts = $fkFolhapagamentoTipoEventoFgts;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoTipoEventoFgts
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoFgts
     */
    public function getFkFolhapagamentoTipoEventoFgts()
    {
        return $this->fkFolhapagamentoTipoEventoFgts;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return FgtsEvento
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
