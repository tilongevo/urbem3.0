<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * DocumentoParcela
 */
class DocumentoParcela
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
     * PK
     * @var integer
     */
    private $numParcela;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Divida\Documento
     */
    private $fkDividaDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Divida\Parcela
     */
    private $fkDividaParcela;


    /**
     * Set numParcelamento
     *
     * @param integer $numParcelamento
     * @return DocumentoParcela
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
     * @return DocumentoParcela
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
     * @return DocumentoParcela
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
     * Set numParcela
     *
     * @param integer $numParcela
     * @return DocumentoParcela
     */
    public function setNumParcela($numParcela)
    {
        $this->numParcela = $numParcela;
        return $this;
    }

    /**
     * Get numParcela
     *
     * @return integer
     */
    public function getNumParcela()
    {
        return $this->numParcela;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkDividaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Documento $fkDividaDocumento
     * @return DocumentoParcela
     */
    public function setFkDividaDocumento(\Urbem\CoreBundle\Entity\Divida\Documento $fkDividaDocumento)
    {
        $this->numParcelamento = $fkDividaDocumento->getNumParcelamento();
        $this->codTipoDocumento = $fkDividaDocumento->getCodTipoDocumento();
        $this->codDocumento = $fkDividaDocumento->getCodDocumento();
        $this->fkDividaDocumento = $fkDividaDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDividaDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Divida\Documento
     */
    public function getFkDividaDocumento()
    {
        return $this->fkDividaDocumento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkDividaParcela
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Parcela $fkDividaParcela
     * @return DocumentoParcela
     */
    public function setFkDividaParcela(\Urbem\CoreBundle\Entity\Divida\Parcela $fkDividaParcela)
    {
        $this->numParcelamento = $fkDividaParcela->getNumParcelamento();
        $this->numParcela = $fkDividaParcela->getNumParcela();
        $this->fkDividaParcela = $fkDividaParcela;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDividaParcela
     *
     * @return \Urbem\CoreBundle\Entity\Divida\Parcela
     */
    public function getFkDividaParcela()
    {
        return $this->fkDividaParcela;
    }
}
