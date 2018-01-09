<?php
 
namespace Urbem\CoreBundle\Entity\Tceam;

/**
 * TipoDocumentoNota
 */
class TipoDocumentoNota
{
    /**
     * PK
     * @var integer
     */
    private $codTipoDocumentoNota;

    /**
     * @var integer
     */
    private $codDocumento;

    /**
     * @var string
     */
    private $numeroNotaFiscal;

    /**
     * @var string
     */
    private $numeroSerie;

    /**
     * @var string
     */
    private $numeroSubserie;

    /**
     * @var \DateTime
     */
    private $data;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tceam\Documento
     */
    private $fkTceamDocumento;


    /**
     * Set codTipoDocumentoNota
     *
     * @param integer $codTipoDocumentoNota
     * @return TipoDocumentoNota
     */
    public function setCodTipoDocumentoNota($codTipoDocumentoNota)
    {
        $this->codTipoDocumentoNota = $codTipoDocumentoNota;
        return $this;
    }

    /**
     * Get codTipoDocumentoNota
     *
     * @return integer
     */
    public function getCodTipoDocumentoNota()
    {
        return $this->codTipoDocumentoNota;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return TipoDocumentoNota
     */
    public function setCodDocumento($codDocumento)
    {
        $this->codDocumento = $codDocumento;
        return $this;
    }

    /**
     * Get codDocumento
     *
     * @return integer
     */
    public function getCodDocumento()
    {
        return $this->codDocumento;
    }

    /**
     * Set numeroNotaFiscal
     *
     * @param string $numeroNotaFiscal
     * @return TipoDocumentoNota
     */
    public function setNumeroNotaFiscal($numeroNotaFiscal = null)
    {
        $this->numeroNotaFiscal = $numeroNotaFiscal;
        return $this;
    }

    /**
     * Get numeroNotaFiscal
     *
     * @return string
     */
    public function getNumeroNotaFiscal()
    {
        return $this->numeroNotaFiscal;
    }

    /**
     * Set numeroSerie
     *
     * @param string $numeroSerie
     * @return TipoDocumentoNota
     */
    public function setNumeroSerie($numeroSerie = null)
    {
        $this->numeroSerie = $numeroSerie;
        return $this;
    }

    /**
     * Get numeroSerie
     *
     * @return string
     */
    public function getNumeroSerie()
    {
        return $this->numeroSerie;
    }

    /**
     * Set numeroSubserie
     *
     * @param string $numeroSubserie
     * @return TipoDocumentoNota
     */
    public function setNumeroSubserie($numeroSubserie = null)
    {
        $this->numeroSubserie = $numeroSubserie;
        return $this;
    }

    /**
     * Get numeroSubserie
     *
     * @return string
     */
    public function getNumeroSubserie()
    {
        return $this->numeroSubserie;
    }

    /**
     * Set data
     *
     * @param \DateTime $data
     * @return TipoDocumentoNota
     */
    public function setData(\DateTime $data = null)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTceamDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\Documento $fkTceamDocumento
     * @return TipoDocumentoNota
     */
    public function setFkTceamDocumento(\Urbem\CoreBundle\Entity\Tceam\Documento $fkTceamDocumento)
    {
        $this->codDocumento = $fkTceamDocumento->getCodDocumento();
        $this->fkTceamDocumento = $fkTceamDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTceamDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Tceam\Documento
     */
    public function getFkTceamDocumento()
    {
        return $this->fkTceamDocumento;
    }
}
