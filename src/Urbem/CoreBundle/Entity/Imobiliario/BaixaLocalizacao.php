<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * BaixaLocalizacao
 */
class BaixaLocalizacao
{
    /**
     * PK
     * @var integer
     */
    private $codLocalizacao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $justificativa;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtTermino;

    /**
     * @var string
     */
    private $justificativaTermino;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Localizacao
     */
    private $fkImobiliarioLocalizacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codLocalizacao
     *
     * @param integer $codLocalizacao
     * @return BaixaLocalizacao
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return BaixaLocalizacao
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set justificativa
     *
     * @param string $justificativa
     * @return BaixaLocalizacao
     */
    public function setJustificativa($justificativa)
    {
        $this->justificativa = $justificativa;
        return $this;
    }

    /**
     * Get justificativa
     *
     * @return string
     */
    public function getJustificativa()
    {
        return $this->justificativa;
    }

    /**
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return BaixaLocalizacao
     */
    public function setDtInicio(\DateTime $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \DateTime
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set dtTermino
     *
     * @param \DateTime $dtTermino
     * @return BaixaLocalizacao
     */
    public function setDtTermino(\DateTime $dtTermino = null)
    {
        $this->dtTermino = $dtTermino;
        return $this;
    }

    /**
     * Get dtTermino
     *
     * @return \DateTime
     */
    public function getDtTermino()
    {
        return $this->dtTermino;
    }

    /**
     * Set justificativaTermino
     *
     * @param string $justificativaTermino
     * @return BaixaLocalizacao
     */
    public function setJustificativaTermino($justificativaTermino = null)
    {
        $this->justificativaTermino = $justificativaTermino;
        return $this;
    }

    /**
     * Get justificativaTermino
     *
     * @return string
     */
    public function getJustificativaTermino()
    {
        return $this->justificativaTermino;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioLocalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Localizacao $fkImobiliarioLocalizacao
     * @return BaixaLocalizacao
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
}
