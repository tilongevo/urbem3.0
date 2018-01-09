<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * FaceQuadraValorM2
 */
class FaceQuadraValorM2
{
    /**
     * PK
     * @var integer
     */
    private $codLocalizacao;

    /**
     * PK
     * @var integer
     */
    private $codFace;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var \DateTime
     */
    private $dtVigencia;

    /**
     * @var integer
     */
    private $valorM2Territorial;

    /**
     * @var integer
     */
    private $valorM2Predial;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\FaceQuadra
     */
    private $fkImobiliarioFaceQuadra;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

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
     * @return FaceQuadraValorM2
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
     * Set codFace
     *
     * @param integer $codFace
     * @return FaceQuadraValorM2
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return FaceQuadraValorM2
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
     * Set codNorma
     *
     * @param integer $codNorma
     * @return FaceQuadraValorM2
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set dtVigencia
     *
     * @param \DateTime $dtVigencia
     * @return FaceQuadraValorM2
     */
    public function setDtVigencia(\DateTime $dtVigencia)
    {
        $this->dtVigencia = $dtVigencia;
        return $this;
    }

    /**
     * Get dtVigencia
     *
     * @return \DateTime
     */
    public function getDtVigencia()
    {
        return $this->dtVigencia;
    }

    /**
     * Set valorM2Territorial
     *
     * @param integer $valorM2Territorial
     * @return FaceQuadraValorM2
     */
    public function setValorM2Territorial($valorM2Territorial)
    {
        $this->valorM2Territorial = $valorM2Territorial;
        return $this;
    }

    /**
     * Get valorM2Territorial
     *
     * @return integer
     */
    public function getValorM2Territorial()
    {
        return $this->valorM2Territorial;
    }

    /**
     * Set valorM2Predial
     *
     * @param integer $valorM2Predial
     * @return FaceQuadraValorM2
     */
    public function setValorM2Predial($valorM2Predial)
    {
        $this->valorM2Predial = $valorM2Predial;
        return $this;
    }

    /**
     * Get valorM2Predial
     *
     * @return integer
     */
    public function getValorM2Predial()
    {
        return $this->valorM2Predial;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioFaceQuadra
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\FaceQuadra $fkImobiliarioFaceQuadra
     * @return FaceQuadraValorM2
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

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return FaceQuadraValorM2
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }
}
