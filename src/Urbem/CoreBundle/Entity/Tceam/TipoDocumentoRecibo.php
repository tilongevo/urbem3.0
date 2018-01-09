<?php
 
namespace Urbem\CoreBundle\Entity\Tceam;

/**
 * TipoDocumentoRecibo
 */
class TipoDocumentoRecibo
{
    /**
     * PK
     * @var integer
     */
    private $codTipoDocumentoRecibo;

    /**
     * @var integer
     */
    private $codDocumento;

    /**
     * @var integer
     */
    private $codTipoRecibo;

    /**
     * @var string
     */
    private $numero;

    /**
     * @var integer
     */
    private $valor;

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
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tceam\TipoRecibo
     */
    private $fkTceamTipoRecibo;


    /**
     * Set codTipoDocumentoRecibo
     *
     * @param integer $codTipoDocumentoRecibo
     * @return TipoDocumentoRecibo
     */
    public function setCodTipoDocumentoRecibo($codTipoDocumentoRecibo)
    {
        $this->codTipoDocumentoRecibo = $codTipoDocumentoRecibo;
        return $this;
    }

    /**
     * Get codTipoDocumentoRecibo
     *
     * @return integer
     */
    public function getCodTipoDocumentoRecibo()
    {
        return $this->codTipoDocumentoRecibo;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return TipoDocumentoRecibo
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
     * Set codTipoRecibo
     *
     * @param integer $codTipoRecibo
     * @return TipoDocumentoRecibo
     */
    public function setCodTipoRecibo($codTipoRecibo)
    {
        $this->codTipoRecibo = $codTipoRecibo;
        return $this;
    }

    /**
     * Get codTipoRecibo
     *
     * @return integer
     */
    public function getCodTipoRecibo()
    {
        return $this->codTipoRecibo;
    }

    /**
     * Set numero
     *
     * @param string $numero
     * @return TipoDocumentoRecibo
     */
    public function setNumero($numero = null)
    {
        $this->numero = $numero;
        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return TipoDocumentoRecibo
     */
    public function setValor($valor = null)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set data
     *
     * @param \DateTime $data
     * @return TipoDocumentoRecibo
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
     * @return TipoDocumentoRecibo
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

    /**
     * ManyToOne (inverse side)
     * Set fkTceamTipoRecibo
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\TipoRecibo $fkTceamTipoRecibo
     * @return TipoDocumentoRecibo
     */
    public function setFkTceamTipoRecibo(\Urbem\CoreBundle\Entity\Tceam\TipoRecibo $fkTceamTipoRecibo)
    {
        $this->codTipoRecibo = $fkTceamTipoRecibo->getCodTipoRecibo();
        $this->fkTceamTipoRecibo = $fkTceamTipoRecibo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTceamTipoRecibo
     *
     * @return \Urbem\CoreBundle\Entity\Tceam\TipoRecibo
     */
    public function getFkTceamTipoRecibo()
    {
        return $this->fkTceamTipoRecibo;
    }
}
