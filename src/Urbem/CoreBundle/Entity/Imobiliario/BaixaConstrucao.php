<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * BaixaConstrucao
 */
class BaixaConstrucao
{
    /**
     * PK
     * @var integer
     */
    private $codConstrucao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $justificativa;

    /**
     * @var boolean
     */
    private $sistema = false;

    /**
     * @var string
     */
    private $justificativaTermino;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtTermino;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Construcao
     */
    private $fkImobiliarioConstrucao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codConstrucao
     *
     * @param integer $codConstrucao
     * @return BaixaConstrucao
     */
    public function setCodConstrucao($codConstrucao)
    {
        $this->codConstrucao = $codConstrucao;
        return $this;
    }

    /**
     * Get codConstrucao
     *
     * @return integer
     */
    public function getCodConstrucao()
    {
        return $this->codConstrucao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return BaixaConstrucao
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
     * Set justificativa
     *
     * @param string $justificativa
     * @return BaixaConstrucao
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
     * Set sistema
     *
     * @param boolean $sistema
     * @return BaixaConstrucao
     */
    public function setSistema($sistema)
    {
        $this->sistema = $sistema;
        return $this;
    }

    /**
     * Get sistema
     *
     * @return boolean
     */
    public function getSistema()
    {
        return $this->sistema;
    }

    /**
     * Set justificativaTermino
     *
     * @param string $justificativaTermino
     * @return BaixaConstrucao
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
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return BaixaConstrucao
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
     * @return BaixaConstrucao
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
     * ManyToOne (inverse side)
     * Set fkImobiliarioConstrucao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Construcao $fkImobiliarioConstrucao
     * @return BaixaConstrucao
     */
    public function setFkImobiliarioConstrucao(\Urbem\CoreBundle\Entity\Imobiliario\Construcao $fkImobiliarioConstrucao)
    {
        $this->codConstrucao = $fkImobiliarioConstrucao->getCodConstrucao();
        $this->fkImobiliarioConstrucao = $fkImobiliarioConstrucao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioConstrucao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Construcao
     */
    public function getFkImobiliarioConstrucao()
    {
        return $this->fkImobiliarioConstrucao;
    }
}
