<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * TabelaIrrfEvento
 */
class TabelaIrrfEvento
{
    /**
     * PK
     * @var integer
     */
    private $codTabela;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

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
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrf
     */
    private $fkFolhapagamentoTabelaIrrf;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoIrrf
     */
    private $fkFolhapagamentoTipoEventoIrrf;

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
     * Set codTabela
     *
     * @param integer $codTabela
     * @return TabelaIrrfEvento
     */
    public function setCodTabela($codTabela)
    {
        $this->codTabela = $codTabela;
        return $this;
    }

    /**
     * Get codTabela
     *
     * @return integer
     */
    public function getCodTabela()
    {
        return $this->codTabela;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TabelaIrrfEvento
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return TabelaIrrfEvento
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
     * @return TabelaIrrfEvento
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
     * Set fkFolhapagamentoTabelaIrrf
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrf $fkFolhapagamentoTabelaIrrf
     * @return TabelaIrrfEvento
     */
    public function setFkFolhapagamentoTabelaIrrf(\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrf $fkFolhapagamentoTabelaIrrf)
    {
        $this->codTabela = $fkFolhapagamentoTabelaIrrf->getCodTabela();
        $this->timestamp = $fkFolhapagamentoTabelaIrrf->getTimestamp();
        $this->fkFolhapagamentoTabelaIrrf = $fkFolhapagamentoTabelaIrrf;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoTabelaIrrf
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrf
     */
    public function getFkFolhapagamentoTabelaIrrf()
    {
        return $this->fkFolhapagamentoTabelaIrrf;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoTipoEventoIrrf
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoIrrf $fkFolhapagamentoTipoEventoIrrf
     * @return TabelaIrrfEvento
     */
    public function setFkFolhapagamentoTipoEventoIrrf(\Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoIrrf $fkFolhapagamentoTipoEventoIrrf)
    {
        $this->codTipo = $fkFolhapagamentoTipoEventoIrrf->getCodTipo();
        $this->fkFolhapagamentoTipoEventoIrrf = $fkFolhapagamentoTipoEventoIrrf;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoTipoEventoIrrf
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoIrrf
     */
    public function getFkFolhapagamentoTipoEventoIrrf()
    {
        return $this->fkFolhapagamentoTipoEventoIrrf;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return TabelaIrrfEvento
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
