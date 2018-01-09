<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * FaceQuadraTrecho
 */
class FaceQuadraTrecho
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
     * @var integer
     */
    private $codTrecho;

    /**
     * PK
     * @var integer
     */
    private $codLogradouro;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\FaceQuadra
     */
    private $fkImobiliarioFaceQuadra;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Trecho
     */
    private $fkImobiliarioTrecho;


    /**
     * Set codFace
     *
     * @param integer $codFace
     * @return FaceQuadraTrecho
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
     * @return FaceQuadraTrecho
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
     * Set codTrecho
     *
     * @param integer $codTrecho
     * @return FaceQuadraTrecho
     */
    public function setCodTrecho($codTrecho)
    {
        $this->codTrecho = $codTrecho;
        return $this;
    }

    /**
     * Get codTrecho
     *
     * @return integer
     */
    public function getCodTrecho()
    {
        return $this->codTrecho;
    }

    /**
     * Set codLogradouro
     *
     * @param integer $codLogradouro
     * @return FaceQuadraTrecho
     */
    public function setCodLogradouro($codLogradouro)
    {
        $this->codLogradouro = $codLogradouro;
        return $this;
    }

    /**
     * Get codLogradouro
     *
     * @return integer
     */
    public function getCodLogradouro()
    {
        return $this->codLogradouro;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioFaceQuadra
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\FaceQuadra $fkImobiliarioFaceQuadra
     * @return FaceQuadraTrecho
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
     * Set fkImobiliarioTrecho
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Trecho $fkImobiliarioTrecho
     * @return FaceQuadraTrecho
     */
    public function setFkImobiliarioTrecho(\Urbem\CoreBundle\Entity\Imobiliario\Trecho $fkImobiliarioTrecho)
    {
        $this->codTrecho = $fkImobiliarioTrecho->getCodTrecho();
        $this->codLogradouro = $fkImobiliarioTrecho->getCodLogradouro();
        $this->fkImobiliarioTrecho = $fkImobiliarioTrecho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioTrecho
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Trecho
     */
    public function getFkImobiliarioTrecho()
    {
        return $this->fkImobiliarioTrecho;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->fkImobiliarioTrecho->getCodigoComposto(), $this->fkImobiliarioTrecho->getFkSwLogradouro());
    }
}
