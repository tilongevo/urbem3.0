<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * InicioFiscalizacaoDocumentos
 */
class InicioFiscalizacaoDocumentos
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
    private $codProcesso;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\DocumentosEntrega
     */
    private $fkFiscalizacaoDocumentosEntregas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\Documento
     */
    private $fkFiscalizacaoDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacao
     */
    private $fkFiscalizacaoInicioFiscalizacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFiscalizacaoDocumentosEntregas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return InicioFiscalizacaoDocumentos
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
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return InicioFiscalizacaoDocumentos
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoDocumentosEntrega
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\DocumentosEntrega $fkFiscalizacaoDocumentosEntrega
     * @return InicioFiscalizacaoDocumentos
     */
    public function addFkFiscalizacaoDocumentosEntregas(\Urbem\CoreBundle\Entity\Fiscalizacao\DocumentosEntrega $fkFiscalizacaoDocumentosEntrega)
    {
        if (false === $this->fkFiscalizacaoDocumentosEntregas->contains($fkFiscalizacaoDocumentosEntrega)) {
            $fkFiscalizacaoDocumentosEntrega->setFkFiscalizacaoInicioFiscalizacaoDocumentos($this);
            $this->fkFiscalizacaoDocumentosEntregas->add($fkFiscalizacaoDocumentosEntrega);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoDocumentosEntrega
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\DocumentosEntrega $fkFiscalizacaoDocumentosEntrega
     */
    public function removeFkFiscalizacaoDocumentosEntregas(\Urbem\CoreBundle\Entity\Fiscalizacao\DocumentosEntrega $fkFiscalizacaoDocumentosEntrega)
    {
        $this->fkFiscalizacaoDocumentosEntregas->removeElement($fkFiscalizacaoDocumentosEntrega);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoDocumentosEntregas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\DocumentosEntrega
     */
    public function getFkFiscalizacaoDocumentosEntregas()
    {
        return $this->fkFiscalizacaoDocumentosEntregas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Documento $fkFiscalizacaoDocumento
     * @return InicioFiscalizacaoDocumentos
     */
    public function setFkFiscalizacaoDocumento(\Urbem\CoreBundle\Entity\Fiscalizacao\Documento $fkFiscalizacaoDocumento)
    {
        $this->codDocumento = $fkFiscalizacaoDocumento->getCodDocumento();
        $this->fkFiscalizacaoDocumento = $fkFiscalizacaoDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\Documento
     */
    public function getFkFiscalizacaoDocumento()
    {
        return $this->fkFiscalizacaoDocumento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoInicioFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacao $fkFiscalizacaoInicioFiscalizacao
     * @return InicioFiscalizacaoDocumentos
     */
    public function setFkFiscalizacaoInicioFiscalizacao(\Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacao $fkFiscalizacaoInicioFiscalizacao)
    {
        $this->codProcesso = $fkFiscalizacaoInicioFiscalizacao->getCodProcesso();
        $this->fkFiscalizacaoInicioFiscalizacao = $fkFiscalizacaoInicioFiscalizacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoInicioFiscalizacao
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacao
     */
    public function getFkFiscalizacaoInicioFiscalizacao()
    {
        return $this->fkFiscalizacaoInicioFiscalizacao;
    }
}
