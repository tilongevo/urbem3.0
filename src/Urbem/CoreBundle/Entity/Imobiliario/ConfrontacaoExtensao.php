<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * ConfrontacaoExtensao
 */
class ConfrontacaoExtensao
{
    /**
     * PK
     * @var integer
     */
    private $codConfrontacao;

    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Confrontacao
     */
    private $fkImobiliarioConfrontacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codConfrontacao
     *
     * @param integer $codConfrontacao
     * @return ConfrontacaoExtensao
     */
    public function setCodConfrontacao($codConfrontacao)
    {
        $this->codConfrontacao = $codConfrontacao;
        return $this;
    }

    /**
     * Get codConfrontacao
     *
     * @return integer
     */
    public function getCodConfrontacao()
    {
        return $this->codConfrontacao;
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return ConfrontacaoExtensao
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ConfrontacaoExtensao
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
     * Set valor
     *
     * @param integer $valor
     * @return ConfrontacaoExtensao
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioConfrontacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Confrontacao $fkImobiliarioConfrontacao
     * @return ConfrontacaoExtensao
     */
    public function setFkImobiliarioConfrontacao(\Urbem\CoreBundle\Entity\Imobiliario\Confrontacao $fkImobiliarioConfrontacao)
    {
        $this->codConfrontacao = $fkImobiliarioConfrontacao->getCodConfrontacao();
        $this->codLote = $fkImobiliarioConfrontacao->getCodLote();
        $this->fkImobiliarioConfrontacao = $fkImobiliarioConfrontacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioConfrontacao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Confrontacao
     */
    public function getFkImobiliarioConfrontacao()
    {
        return $this->fkImobiliarioConfrontacao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return number_format($this->getValor(), '2', ',', '.');
    }
}
