<?php
 
namespace Urbem\CoreBundle\Entity\Tceam;

/**
 * TipoDocumentoFolha
 */
class TipoDocumentoFolha
{
    /**
     * PK
     * @var integer
     */
    private $codTipoDocumentoFolha;

    /**
     * @var integer
     */
    private $codDocumento;

    /**
     * @var string
     */
    private $mes;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tceam\Documento
     */
    private $fkTceamDocumento;


    /**
     * Set codTipoDocumentoFolha
     *
     * @param integer $codTipoDocumentoFolha
     * @return TipoDocumentoFolha
     */
    public function setCodTipoDocumentoFolha($codTipoDocumentoFolha)
    {
        $this->codTipoDocumentoFolha = $codTipoDocumentoFolha;
        return $this;
    }

    /**
     * Get codTipoDocumentoFolha
     *
     * @return integer
     */
    public function getCodTipoDocumentoFolha()
    {
        return $this->codTipoDocumentoFolha;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return TipoDocumentoFolha
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
     * Set mes
     *
     * @param string $mes
     * @return TipoDocumentoFolha
     */
    public function setMes($mes = null)
    {
        $this->mes = $mes;
        return $this;
    }

    /**
     * Get mes
     *
     * @return string
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return TipoDocumentoFolha
     */
    public function setExercicio($exercicio = null)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTceamDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\Documento $fkTceamDocumento
     * @return TipoDocumentoFolha
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
