<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * FeriasEvento
 */
class FeriasEvento
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

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
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoFerias
     */
    private $fkFolhapagamentoTipoEventoFerias;

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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return FeriasEvento
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
     * Set codEvento
     *
     * @param integer $codEvento
     * @return FeriasEvento
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
     * @return FeriasEvento
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
     * Set fkFolhapagamentoTipoEventoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoFerias $fkFolhapagamentoTipoEventoFerias
     * @return FeriasEvento
     */
    public function setFkFolhapagamentoTipoEventoFerias(\Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoFerias $fkFolhapagamentoTipoEventoFerias)
    {
        $this->codTipo = $fkFolhapagamentoTipoEventoFerias->getCodTipo();
        $this->fkFolhapagamentoTipoEventoFerias = $fkFolhapagamentoTipoEventoFerias;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoTipoEventoFerias
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoFerias
     */
    public function getFkFolhapagamentoTipoEventoFerias()
    {
        return $this->fkFolhapagamentoTipoEventoFerias;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return FeriasEvento
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
