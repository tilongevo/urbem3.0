<?php
 
namespace Urbem\CoreBundle\Entity\Tceam;

/**
 * TipoDocumentoDiverso
 */
class TipoDocumentoDiverso
{
    /**
     * PK
     * @var integer
     */
    private $codTipoDocumentoDiverso;

    /**
     * @var integer
     */
    private $codDocumento;

    /**
     * @var string
     */
    private $numero;

    /**
     * @var \DateTime
     */
    private $data;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $nomeDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tceam\Documento
     */
    private $fkTceamDocumento;


    /**
     * Set codTipoDocumentoDiverso
     *
     * @param integer $codTipoDocumentoDiverso
     * @return TipoDocumentoDiverso
     */
    public function setCodTipoDocumentoDiverso($codTipoDocumentoDiverso)
    {
        $this->codTipoDocumentoDiverso = $codTipoDocumentoDiverso;
        return $this;
    }

    /**
     * Get codTipoDocumentoDiverso
     *
     * @return integer
     */
    public function getCodTipoDocumentoDiverso()
    {
        return $this->codTipoDocumentoDiverso;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return TipoDocumentoDiverso
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
     * Set numero
     *
     * @param string $numero
     * @return TipoDocumentoDiverso
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
     * Set data
     *
     * @param \DateTime $data
     * @return TipoDocumentoDiverso
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
     * Set descricao
     *
     * @param string $descricao
     * @return TipoDocumentoDiverso
     */
    public function setDescricao($descricao = null)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set nomeDocumento
     *
     * @param string $nomeDocumento
     * @return TipoDocumentoDiverso
     */
    public function setNomeDocumento($nomeDocumento = null)
    {
        $this->nomeDocumento = $nomeDocumento;
        return $this;
    }

    /**
     * Get nomeDocumento
     *
     * @return string
     */
    public function getNomeDocumento()
    {
        return $this->nomeDocumento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTceamDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\Documento $fkTceamDocumento
     * @return TipoDocumentoDiverso
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
