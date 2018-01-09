<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * DocumentoDePara
 */
class DocumentoDePara
{
    /**
     * PK
     * @var integer
     */
    private $codDocumentoTcm;

    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\TipoDocumentoTcm
     */
    private $fkTcmgoTipoDocumentoTcm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Documento
     */
    private $fkLicitacaoDocumento;


    /**
     * Set codDocumentoTcm
     *
     * @param integer $codDocumentoTcm
     * @return DocumentoDePara
     */
    public function setCodDocumentoTcm($codDocumentoTcm)
    {
        $this->codDocumentoTcm = $codDocumentoTcm;
        return $this;
    }

    /**
     * Get codDocumentoTcm
     *
     * @return integer
     */
    public function getCodDocumentoTcm()
    {
        return $this->codDocumentoTcm;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return DocumentoDePara
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
     * ManyToOne (inverse side)
     * Set fkTcmgoTipoDocumentoTcm
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\TipoDocumentoTcm $fkTcmgoTipoDocumentoTcm
     * @return DocumentoDePara
     */
    public function setFkTcmgoTipoDocumentoTcm(\Urbem\CoreBundle\Entity\Tcmgo\TipoDocumentoTcm $fkTcmgoTipoDocumentoTcm)
    {
        $this->codDocumentoTcm = $fkTcmgoTipoDocumentoTcm->getCodDocumentoTcm();
        $this->fkTcmgoTipoDocumentoTcm = $fkTcmgoTipoDocumentoTcm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoTipoDocumentoTcm
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\TipoDocumentoTcm
     */
    public function getFkTcmgoTipoDocumentoTcm()
    {
        return $this->fkTcmgoTipoDocumentoTcm;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Documento $fkLicitacaoDocumento
     * @return DocumentoDePara
     */
    public function setFkLicitacaoDocumento(\Urbem\CoreBundle\Entity\Licitacao\Documento $fkLicitacaoDocumento)
    {
        $this->codDocumento = $fkLicitacaoDocumento->getCodDocumento();
        $this->fkLicitacaoDocumento = $fkLicitacaoDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Documento
     */
    public function getFkLicitacaoDocumento()
    {
        return $this->fkLicitacaoDocumento;
    }
}
