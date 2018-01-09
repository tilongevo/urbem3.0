<?php
 
namespace Urbem\CoreBundle\Entity\Documentodinamico;

/**
 * BlocoTexto
 */
class BlocoTexto
{
    /**
     * PK
     * @var integer
     */
    private $codBloco;

    /**
     * @var string
     */
    private $texto;

    /**
     * @var string
     */
    private $alinhamento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Documentodinamico\DocumentoBlocoTexto
     */
    private $fkDocumentodinamicoDocumentoBlocoTextos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkDocumentodinamicoDocumentoBlocoTextos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codBloco
     *
     * @param integer $codBloco
     * @return BlocoTexto
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
     * Set texto
     *
     * @param string $texto
     * @return BlocoTexto
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;
        return $this;
    }

    /**
     * Get texto
     *
     * @return string
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * Set alinhamento
     *
     * @param string $alinhamento
     * @return BlocoTexto
     */
    public function setAlinhamento($alinhamento)
    {
        $this->alinhamento = $alinhamento;
        return $this;
    }

    /**
     * Get alinhamento
     *
     * @return string
     */
    public function getAlinhamento()
    {
        return $this->alinhamento;
    }

    /**
     * OneToMany (owning side)
     * Add DocumentodinamicoDocumentoBlocoTexto
     *
     * @param \Urbem\CoreBundle\Entity\Documentodinamico\DocumentoBlocoTexto $fkDocumentodinamicoDocumentoBlocoTexto
     * @return BlocoTexto
     */
    public function addFkDocumentodinamicoDocumentoBlocoTextos(\Urbem\CoreBundle\Entity\Documentodinamico\DocumentoBlocoTexto $fkDocumentodinamicoDocumentoBlocoTexto)
    {
        if (false === $this->fkDocumentodinamicoDocumentoBlocoTextos->contains($fkDocumentodinamicoDocumentoBlocoTexto)) {
            $fkDocumentodinamicoDocumentoBlocoTexto->setFkDocumentodinamicoBlocoTexto($this);
            $this->fkDocumentodinamicoDocumentoBlocoTextos->add($fkDocumentodinamicoDocumentoBlocoTexto);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DocumentodinamicoDocumentoBlocoTexto
     *
     * @param \Urbem\CoreBundle\Entity\Documentodinamico\DocumentoBlocoTexto $fkDocumentodinamicoDocumentoBlocoTexto
     */
    public function removeFkDocumentodinamicoDocumentoBlocoTextos(\Urbem\CoreBundle\Entity\Documentodinamico\DocumentoBlocoTexto $fkDocumentodinamicoDocumentoBlocoTexto)
    {
        $this->fkDocumentodinamicoDocumentoBlocoTextos->removeElement($fkDocumentodinamicoDocumentoBlocoTexto);
    }

    /**
     * OneToMany (owning side)
     * Get fkDocumentodinamicoDocumentoBlocoTextos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Documentodinamico\DocumentoBlocoTexto
     */
    public function getFkDocumentodinamicoDocumentoBlocoTextos()
    {
        return $this->fkDocumentodinamicoDocumentoBlocoTextos;
    }
}
