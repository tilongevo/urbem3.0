<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * Documento
 */
class Documento
{
    /**
     * PK
     * @var integer
     */
    private $numParcelamento;

    /**
     * PK
     * @var integer
     */
    private $codTipoDocumento;

    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DocumentoParcela
     */
    private $fkDividaDocumentoParcelas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\EmissaoDocumento
     */
    private $fkDividaEmissaoDocumentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Divida\Parcelamento
     */
    private $fkDividaParcelamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    private $fkAdministracaoModeloDocumento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkDividaDocumentoParcelas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaEmissaoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set numParcelamento
     *
     * @param integer $numParcelamento
     * @return Documento
     */
    public function setNumParcelamento($numParcelamento)
    {
        $this->numParcelamento = $numParcelamento;
        return $this;
    }

    /**
     * Get numParcelamento
     *
     * @return integer
     */
    public function getNumParcelamento()
    {
        return $this->numParcelamento;
    }

    /**
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return Documento
     */
    public function setCodTipoDocumento($codTipoDocumento)
    {
        $this->codTipoDocumento = $codTipoDocumento;
        return $this;
    }

    /**
     * Get codTipoDocumento
     *
     * @return integer
     */
    public function getCodTipoDocumento()
    {
        return $this->codTipoDocumento;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return Documento
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
     * OneToMany (owning side)
     * Add DividaDocumentoParcela
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DocumentoParcela $fkDividaDocumentoParcela
     * @return Documento
     */
    public function addFkDividaDocumentoParcelas(\Urbem\CoreBundle\Entity\Divida\DocumentoParcela $fkDividaDocumentoParcela)
    {
        if (false === $this->fkDividaDocumentoParcelas->contains($fkDividaDocumentoParcela)) {
            $fkDividaDocumentoParcela->setFkDividaDocumento($this);
            $this->fkDividaDocumentoParcelas->add($fkDividaDocumentoParcela);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaDocumentoParcela
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DocumentoParcela $fkDividaDocumentoParcela
     */
    public function removeFkDividaDocumentoParcelas(\Urbem\CoreBundle\Entity\Divida\DocumentoParcela $fkDividaDocumentoParcela)
    {
        $this->fkDividaDocumentoParcelas->removeElement($fkDividaDocumentoParcela);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaDocumentoParcelas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DocumentoParcela
     */
    public function getFkDividaDocumentoParcelas()
    {
        return $this->fkDividaDocumentoParcelas;
    }

    /**
     * OneToMany (owning side)
     * Add DividaEmissaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\EmissaoDocumento $fkDividaEmissaoDocumento
     * @return Documento
     */
    public function addFkDividaEmissaoDocumentos(\Urbem\CoreBundle\Entity\Divida\EmissaoDocumento $fkDividaEmissaoDocumento)
    {
        if (false === $this->fkDividaEmissaoDocumentos->contains($fkDividaEmissaoDocumento)) {
            $fkDividaEmissaoDocumento->setFkDividaDocumento($this);
            $this->fkDividaEmissaoDocumentos->add($fkDividaEmissaoDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaEmissaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\EmissaoDocumento $fkDividaEmissaoDocumento
     */
    public function removeFkDividaEmissaoDocumentos(\Urbem\CoreBundle\Entity\Divida\EmissaoDocumento $fkDividaEmissaoDocumento)
    {
        $this->fkDividaEmissaoDocumentos->removeElement($fkDividaEmissaoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaEmissaoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\EmissaoDocumento
     */
    public function getFkDividaEmissaoDocumentos()
    {
        return $this->fkDividaEmissaoDocumentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkDividaParcelamento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Parcelamento $fkDividaParcelamento
     * @return Documento
     */
    public function setFkDividaParcelamento(\Urbem\CoreBundle\Entity\Divida\Parcelamento $fkDividaParcelamento)
    {
        $this->numParcelamento = $fkDividaParcelamento->getNumParcelamento();
        $this->fkDividaParcelamento = $fkDividaParcelamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDividaParcelamento
     *
     * @return \Urbem\CoreBundle\Entity\Divida\Parcelamento
     */
    public function getFkDividaParcelamento()
    {
        return $this->fkDividaParcelamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     * @return Documento
     */
    public function setFkAdministracaoModeloDocumento(\Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento)
    {
        $this->codDocumento = $fkAdministracaoModeloDocumento->getCodDocumento();
        $this->codTipoDocumento = $fkAdministracaoModeloDocumento->getCodTipoDocumento();
        $this->fkAdministracaoModeloDocumento = $fkAdministracaoModeloDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoModeloDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    public function getFkAdministracaoModeloDocumento()
    {
        return $this->fkAdministracaoModeloDocumento;
    }
}
