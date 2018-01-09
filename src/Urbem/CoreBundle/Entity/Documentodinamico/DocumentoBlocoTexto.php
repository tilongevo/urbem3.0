<?php
 
namespace Urbem\CoreBundle\Entity\Documentodinamico;

/**
 * DocumentoBlocoTexto
 */
class DocumentoBlocoTexto
{
    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * PK
     * @var integer
     */
    private $codBloco;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Documentodinamico\Documento
     */
    private $fkDocumentodinamicoDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Documentodinamico\BlocoTexto
     */
    private $fkDocumentodinamicoBlocoTexto;


    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return DocumentoBlocoTexto
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
     * Set codBloco
     *
     * @param integer $codBloco
     * @return DocumentoBlocoTexto
     */
    public function setCodBloco($codBloco)
    {
        $this->codBloco = $codBloco;
        return $this;
    }

    /**
     * Get codBloco
     *
     * @return integer
     */
    public function getCodBloco()
    {
        return $this->codBloco;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkDocumentodinamicoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Documentodinamico\Documento $fkDocumentodinamicoDocumento
     * @return DocumentoBlocoTexto
     */
    public function setFkDocumentodinamicoDocumento(\Urbem\CoreBundle\Entity\Documentodinamico\Documento $fkDocumentodinamicoDocumento)
    {
        $this->codDocumento = $fkDocumentodinamicoDocumento->getCodDocumento();
        $this->fkDocumentodinamicoDocumento = $fkDocumentodinamicoDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDocumentodinamicoDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Documentodinamico\Documento
     */
    public function getFkDocumentodinamicoDocumento()
    {
        return $this->fkDocumentodinamicoDocumento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkDocumentodinamicoBlocoTexto
     *
     * @param \Urbem\CoreBundle\Entity\Documentodinamico\BlocoTexto $fkDocumentodinamicoBlocoTexto
     * @return DocumentoBlocoTexto
     */
    public function setFkDocumentodinamicoBlocoTexto(\Urbem\CoreBundle\Entity\Documentodinamico\BlocoTexto $fkDocumentodinamicoBlocoTexto)
    {
        $this->codBloco = $fkDocumentodinamicoBlocoTexto->getCodBloco();
        $this->fkDocumentodinamicoBlocoTexto = $fkDocumentodinamicoBlocoTexto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDocumentodinamicoBlocoTexto
     *
     * @return \Urbem\CoreBundle\Entity\Documentodinamico\BlocoTexto
     */
    public function getFkDocumentodinamicoBlocoTexto()
    {
        return $this->fkDocumentodinamicoBlocoTexto;
    }
}
