<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * FaceQuadraAliquota
 */
class FaceQuadraAliquota
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
    private $aliquotaTerritorial;

    /**
     * @var integer
     */
    private $aliquotaPredial;

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
     * @return FaceQuadraAliquota
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
     * @return FaceQuadraAliquota
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
     * @return FaceQuadraAliquota
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
     * @return FaceQuadraAliquota
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
     * @return FaceQuadraAliquota
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
     * Set aliquotaTerritorial
     *
     * @param integer $aliquotaTerritorial
     * @return FaceQuadraAliquota
     */
    public function setAliquotaTerritorial($aliquotaTerritorial)
    {
        $this->aliquotaTerritorial = $aliquotaTerritorial;
        return $this;
    }

    /**
     * Get aliquotaTerritorial
     *
     * @return integer
     */
    public function getAliquotaTerritorial()
    {
        return $this->aliquotaTerritorial;
    }

    /**
     * Set aliquotaPredial
     *
     * @param integer $aliquotaPredial
     * @return FaceQuadraAliquota
     */
    public function setAliquotaPredial($aliquotaPredial)
    {
        $this->aliquotaPredial = $aliquotaPredial;
        return $this;
    }

    /**
     * Get aliquotaPredial
     *
     * @return integer
     */
    public function getAliquotaPredial()
    {
        return $this->aliquotaPredial;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioFaceQuadra
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\FaceQuadra $fkImobiliarioFaceQuadra
     * @return FaceQuadraAliquota
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
     * @return FaceQuadraAliquota
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
