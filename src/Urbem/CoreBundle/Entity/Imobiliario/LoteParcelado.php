<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * LoteParcelado
 */
class LoteParcelado
{
    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var integer
     */
    private $codParcelamento;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var boolean
     */
    private $validado = false;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Lote
     */
    private $fkImobiliarioLote;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo
     */
    private $fkImobiliarioParcelamentoSolo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return LoteParcelado
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set codParcelamento
     *
     * @param integer $codParcelamento
     * @return LoteParcelado
     */
    public function setCodParcelamento($codParcelamento)
    {
        $this->codParcelamento = $codParcelamento;
        return $this;
    }

    /**
     * Get codParcelamento
     *
     * @return integer
     */
    public function getCodParcelamento()
    {
        return $this->codParcelamento;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return LoteParcelado
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
     * Set validado
     *
     * @param boolean $validado
     * @return LoteParcelado
     */
    public function setValidado($validado)
    {
        $this->validado = $validado;
        return $this;
    }

    /**
     * Get validado
     *
     * @return boolean
     */
    public function getValidado()
    {
        return $this->validado;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Lote $fkImobiliarioLote
     * @return LoteParcelado
     */
    public function setFkImobiliarioLote(\Urbem\CoreBundle\Entity\Imobiliario\Lote $fkImobiliarioLote)
    {
        $this->codLote = $fkImobiliarioLote->getCodLote();
        $this->fkImobiliarioLote = $fkImobiliarioLote;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioLote
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Lote
     */
    public function getFkImobiliarioLote()
    {
        return $this->fkImobiliarioLote;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioParcelamentoSolo
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo $fkImobiliarioParcelamentoSolo
     * @return LoteParcelado
     */
    public function setFkImobiliarioParcelamentoSolo(\Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo $fkImobiliarioParcelamentoSolo)
    {
        $this->codParcelamento = $fkImobiliarioParcelamentoSolo->getCodParcelamento();
        $this->fkImobiliarioParcelamentoSolo = $fkImobiliarioParcelamentoSolo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioParcelamentoSolo
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo
     */
    public function getFkImobiliarioParcelamentoSolo()
    {
        return $this->fkImobiliarioParcelamentoSolo;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkImobiliarioLote;
    }
}
