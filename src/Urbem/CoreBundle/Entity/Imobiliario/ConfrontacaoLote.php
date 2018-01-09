<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * ConfrontacaoLote
 */
class ConfrontacaoLote
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
     * @var integer
     */
    private $codLoteConfrontacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Confrontacao
     */
    private $fkImobiliarioConfrontacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Lote
     */
    private $fkImobiliarioLote;


    /**
     * Set codConfrontacao
     *
     * @param integer $codConfrontacao
     * @return ConfrontacaoLote
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
     * @return ConfrontacaoLote
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
     * Set codLoteConfrontacao
     *
     * @param integer $codLoteConfrontacao
     * @return ConfrontacaoLote
     */
    public function setCodLoteConfrontacao($codLoteConfrontacao)
    {
        $this->codLoteConfrontacao = $codLoteConfrontacao;
        return $this;
    }

    /**
     * Get codLoteConfrontacao
     *
     * @return integer
     */
    public function getCodLoteConfrontacao()
    {
        return $this->codLoteConfrontacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Lote $fkImobiliarioLote
     * @return ConfrontacaoLote
     */
    public function setFkImobiliarioLote(\Urbem\CoreBundle\Entity\Imobiliario\Lote $fkImobiliarioLote)
    {
        $this->codLoteConfrontacao = $fkImobiliarioLote->getCodLote();
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
     * OneToOne (owning side)
     * Set ImobiliarioConfrontacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Confrontacao $fkImobiliarioConfrontacao
     * @return ConfrontacaoLote
     */
    public function setFkImobiliarioConfrontacao(\Urbem\CoreBundle\Entity\Imobiliario\Confrontacao $fkImobiliarioConfrontacao)
    {
        $this->codConfrontacao = $fkImobiliarioConfrontacao->getCodConfrontacao();
        $this->codLote = $fkImobiliarioConfrontacao->getCodLote();
        $this->fkImobiliarioConfrontacao = $fkImobiliarioConfrontacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkImobiliarioConfrontacao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Confrontacao
     */
    public function getFkImobiliarioConfrontacao()
    {
        return $this->fkImobiliarioConfrontacao;
    }
}
