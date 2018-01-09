<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * PrevidenciaEvento
 */
class PrevidenciaEvento
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
    private $codPrevidencia;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codEvento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoPrevidencia
     */
    private $fkFolhapagamentoTipoEventoPrevidencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia
     */
    private $fkFolhapagamentoPrevidenciaPrevidencia;

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
     * @return PrevidenciaEvento
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
     * Set codPrevidencia
     *
     * @param integer $codPrevidencia
     * @return PrevidenciaEvento
     */
    public function setCodPrevidencia($codPrevidencia)
    {
        $this->codPrevidencia = $codPrevidencia;
        return $this;
    }

    /**
     * Get codPrevidencia
     *
     * @return integer
     */
    public function getCodPrevidencia()
    {
        return $this->codPrevidencia;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return PrevidenciaEvento
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
     * Set codEvento
     *
     * @param integer $codEvento
     * @return PrevidenciaEvento
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
     * Set fkFolhapagamentoTipoEventoPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoPrevidencia $fkFolhapagamentoTipoEventoPrevidencia
     * @return PrevidenciaEvento
     */
    public function setFkFolhapagamentoTipoEventoPrevidencia(\Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoPrevidencia $fkFolhapagamentoTipoEventoPrevidencia)
    {
        $this->codTipo = $fkFolhapagamentoTipoEventoPrevidencia->getCodTipo();
        $this->fkFolhapagamentoTipoEventoPrevidencia = $fkFolhapagamentoTipoEventoPrevidencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoTipoEventoPrevidencia
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoPrevidencia
     */
    public function getFkFolhapagamentoTipoEventoPrevidencia()
    {
        return $this->fkFolhapagamentoTipoEventoPrevidencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoPrevidenciaPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia $fkFolhapagamentoPrevidenciaPrevidencia
     * @return PrevidenciaEvento
     */
    public function setFkFolhapagamentoPrevidenciaPrevidencia(\Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia $fkFolhapagamentoPrevidenciaPrevidencia)
    {
        $this->codPrevidencia = $fkFolhapagamentoPrevidenciaPrevidencia->getCodPrevidencia();
        $this->timestamp = $fkFolhapagamentoPrevidenciaPrevidencia->getTimestamp();
        $this->fkFolhapagamentoPrevidenciaPrevidencia = $fkFolhapagamentoPrevidenciaPrevidencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoPrevidenciaPrevidencia
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia
     */
    public function getFkFolhapagamentoPrevidenciaPrevidencia()
    {
        return $this->fkFolhapagamentoPrevidenciaPrevidencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return PrevidenciaEvento
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
