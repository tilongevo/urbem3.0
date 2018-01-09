<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * DeParaDocumento
 */
class DeParaDocumento
{
    /**
     * PK
     * @var integer
     */
    private $codDocTce;

    /**
     * PK
     * @var integer
     */
    private $codDocUrbem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\TipoDocCredor
     */
    private $fkTcemgTipoDocCredor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Documento
     */
    private $fkLicitacaoDocumento;


    /**
     * Set codDocTce
     *
     * @param integer $codDocTce
     * @return DeParaDocumento
     */
    public function setCodDocTce($codDocTce)
    {
        $this->codDocTce = $codDocTce;
        return $this;
    }

    /**
     * Get codDocTce
     *
     * @return integer
     */
    public function getCodDocTce()
    {
        return $this->codDocTce;
    }

    /**
     * Set codDocUrbem
     *
     * @param integer $codDocUrbem
     * @return DeParaDocumento
     */
    public function setCodDocUrbem($codDocUrbem)
    {
        $this->codDocUrbem = $codDocUrbem;
        return $this;
    }

    /**
     * Get codDocUrbem
     *
     * @return integer
     */
    public function getCodDocUrbem()
    {
        return $this->codDocUrbem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgTipoDocCredor
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TipoDocCredor $fkTcemgTipoDocCredor
     * @return DeParaDocumento
     */
    public function setFkTcemgTipoDocCredor(\Urbem\CoreBundle\Entity\Tcemg\TipoDocCredor $fkTcemgTipoDocCredor)
    {
        $this->codDocTce = $fkTcemgTipoDocCredor->getCodigo();
        $this->fkTcemgTipoDocCredor = $fkTcemgTipoDocCredor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgTipoDocCredor
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\TipoDocCredor
     */
    public function getFkTcemgTipoDocCredor()
    {
        return $this->fkTcemgTipoDocCredor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Documento $fkLicitacaoDocumento
     * @return DeParaDocumento
     */
    public function setFkLicitacaoDocumento(\Urbem\CoreBundle\Entity\Licitacao\Documento $fkLicitacaoDocumento)
    {
        $this->codDocUrbem = $fkLicitacaoDocumento->getCodDocumento();
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
