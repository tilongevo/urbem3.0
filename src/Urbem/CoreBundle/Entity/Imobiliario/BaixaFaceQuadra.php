<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * BaixaFaceQuadra
 */
class BaixaFaceQuadra
{
    /**
     * PK
     * @var integer
     */
    private $codFace;

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
     * @var \Urbem\CoreBundle\Entity\Imobiliario\FaceQuadra
     */
    private $fkImobiliarioFaceQuadra;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codFace
     *
     * @param integer $codFace
     * @return BaixaFaceQuadra
     */
    public function setCodFace($codFace)
    {
        $this->codFace = $codFace;
        return $this;
    }

    /**
     * Get codFace
     *
     * @return integer
     */
    public function getCodFace()
    {
        return $this->codFace;
    }

    /**
     * Set codLocalizacao
     *
     * @param integer $codLocalizacao
     * @return BaixaFaceQuadra
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
     * @return BaixaFaceQuadra
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
     * @return BaixaFaceQuadra
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
     * Set justificativaTermino
     *
     * @param string $justificativaTermino
     * @return BaixaFaceQuadra
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
     * @return BaixaFaceQuadra
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
     * @return BaixaFaceQuadra
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
     * Set fkImobiliarioFaceQuadra
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\FaceQuadra $fkImobiliarioFaceQuadra
     * @return BaixaFaceQuadra
     */
    public function setFkImobiliarioFaceQuadra(\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadra $fkImobiliarioFaceQuadra)
    {
        $this->codFace = $fkImobiliarioFaceQuadra->getCodFace();
        $this->codLocalizacao = $fkImobiliarioFaceQuadra->getCodLocalizacao();
        $this->fkImobiliarioFaceQuadra = $fkImobiliarioFaceQuadra;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioFaceQuadra
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\FaceQuadra
     */
    public function getFkImobiliarioFaceQuadra()
    {
        return $this->fkImobiliarioFaceQuadra;
    }
}
