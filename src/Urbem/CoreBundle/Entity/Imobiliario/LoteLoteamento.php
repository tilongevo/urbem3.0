<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * LoteLoteamento
 */
class LoteLoteamento
{
    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * @var integer
     */
    private $codLoteamento;

    /**
     * @var boolean
     */
    private $caucionado = false;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Lote
     */
    private $fkImobiliarioLote;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Loteamento
     */
    private $fkImobiliarioLoteamento;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return LoteLoteamento
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
     * Set codLoteamento
     *
     * @param integer $codLoteamento
     * @return LoteLoteamento
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
     * Set caucionado
     *
     * @param boolean $caucionado
     * @return LoteLoteamento
     */
    public function setCaucionado($caucionado)
    {
        $this->caucionado = $caucionado;
        return $this;
    }

    /**
     * Get caucionado
     *
     * @return boolean
     */
    public function getCaucionado()
    {
        return $this->caucionado;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioLoteamento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Loteamento $fkImobiliarioLoteamento
     * @return LoteLoteamento
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
     * OneToOne (owning side)
     * Set ImobiliarioLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Lote $fkImobiliarioLote
     * @return LoteLoteamento
     */
    public function setFkImobiliarioLote(\Urbem\CoreBundle\Entity\Imobiliario\Lote $fkImobiliarioLote)
    {
        $this->codLote = $fkImobiliarioLote->getCodLote();
        $this->fkImobiliarioLote = $fkImobiliarioLote;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkImobiliarioLote
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Lote
     */
    public function getFkImobiliarioLote()
    {
        return $this->fkImobiliarioLote;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s/%s %s', (string) $this->fkImobiliarioLote->getFkImobiliarioLoteLocalizacao()->getFkImobiliarioLocalizacao(), (string) $this->fkImobiliarioLote, ($this->caucionado) ? '- Caucionado' : '');
    }
}
