<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * LoteamentoLoteOrigem
 */
class LoteamentoLoteOrigem
{
    /**
     * PK
     * @var integer
     */
    private $codLoteamento;

    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $dtAprovacao;

    /**
     * @var \DateTime
     */
    private $dtLiberacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Loteamento
     */
    private $fkImobiliarioLoteamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Lote
     */
    private $fkImobiliarioLote;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codLoteamento
     *
     * @param integer $codLoteamento
     * @return LoteamentoLoteOrigem
     */
    public function setCodLoteamento($codLoteamento)
    {
        $this->codLoteamento = $codLoteamento;
        return $this;
    }

    /**
     * Get codLoteamento
     *
     * @return integer
     */
    public function getCodLoteamento()
    {
        return $this->codLoteamento;
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return LoteamentoLoteOrigem
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
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return $this
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * @return \DateTime|\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set dtAprovacao
     *
     * @param \DateTime $dtAprovacao
     * @return LoteamentoLoteOrigem
     */
    public function setDtAprovacao(\DateTime $dtAprovacao = null)
    {
        $this->dtAprovacao = $dtAprovacao;
        return $this;
    }

    /**
     * Get dtAprovacao
     *
     * @return \DateTime
     */
    public function getDtAprovacao()
    {
        return $this->dtAprovacao;
    }

    /**
     * Set dtLiberacao
     *
     * @param \DateTime $dtLiberacao
     * @return LoteamentoLoteOrigem
     */
    public function setDtLiberacao(\DateTime $dtLiberacao = null)
    {
        $this->dtLiberacao = $dtLiberacao;
        return $this;
    }

    /**
     * Get dtLiberacao
     *
     * @return \DateTime
     */
    public function getDtLiberacao()
    {
        return $this->dtLiberacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioLoteamento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Loteamento $fkImobiliarioLoteamento
     * @return LoteamentoLoteOrigem
     */
    public function setFkImobiliarioLoteamento(\Urbem\CoreBundle\Entity\Imobiliario\Loteamento $fkImobiliarioLoteamento)
    {
        $this->codLoteamento = $fkImobiliarioLoteamento->getCodLoteamento();
        $this->fkImobiliarioLoteamento = $fkImobiliarioLoteamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioLoteamento
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Loteamento
     */
    public function getFkImobiliarioLoteamento()
    {
        return $this->fkImobiliarioLoteamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Lote $fkImobiliarioLote
     * @return LoteamentoLoteOrigem
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
}
