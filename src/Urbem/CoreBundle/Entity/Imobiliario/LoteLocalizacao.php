<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * LoteLocalizacao
 */
class LoteLocalizacao
{
    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * @var integer
     */
    private $codLocalizacao;

    /**
     * @var string
     */
    private $valor;

    /**
     * @var string
     */
    private $localizacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Lote
     */
    private $fkImobiliarioLote;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Localizacao
     */
    private $fkImobiliarioLocalizacao;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return LoteLocalizacao
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
     * Set codLocalizacao
     *
     * @param integer $codLocalizacao
     * @return LoteLocalizacao
     */
    public function setCodLocalizacao($codLocalizacao)
    {
        $this->codLocalizacao = $codLocalizacao;
        return $this;
    }

    /**
     * Get codLocalizacao
     *
     * @return integer
     */
    public function getCodLocalizacao()
    {
        return $this->codLocalizacao;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return LoteLocalizacao
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set localizacao
     *
     * @param string $localizacao
     * @return LoteLocalizacao
     */
    public function setLocalizacao($localizacao = null)
    {
        $this->localizacao = $localizacao;
        return $this;
    }

    /**
     * Get localizacao
     *
     * @return string
     */
    public function getLocalizacao()
    {
        return $this->localizacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioLocalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Localizacao $fkImobiliarioLocalizacao
     * @return LoteLocalizacao
     */
    public function setFkImobiliarioLocalizacao(\Urbem\CoreBundle\Entity\Imobiliario\Localizacao $fkImobiliarioLocalizacao)
    {
        $this->codLocalizacao = $fkImobiliarioLocalizacao->getCodLocalizacao();
        $this->fkImobiliarioLocalizacao = $fkImobiliarioLocalizacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioLocalizacao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Localizacao
     */
    public function getFkImobiliarioLocalizacao()
    {
        return $this->fkImobiliarioLocalizacao;
    }

    /**
     * OneToOne (owning side)
     * Set ImobiliarioLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Lote $fkImobiliarioLote
     * @return LoteLocalizacao
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
}
