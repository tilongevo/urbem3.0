<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * Parcela
 */
class Parcela
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
    private $numParcela;

    /**
     * @var integer
     */
    private $vlrParcela;

    /**
     * @var \DateTime
     */
    private $dtVencimentoParcela;

    /**
     * @var boolean
     */
    private $paga = false;

    /**
     * @var boolean
     */
    private $cancelada = false;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DocumentoParcela
     */
    private $fkDividaDocumentoParcelas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ParcelaAcrescimo
     */
    private $fkDividaParcelaAcrescimos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ParcelaCalculo
     */
    private $fkDividaParcelaCalculos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ParcelaReducao
     */
    private $fkDividaParcelaReducoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Divida\Parcelamento
     */
    private $fkDividaParcelamento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkDividaDocumentoParcelas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaParcelaAcrescimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaParcelaCalculos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaParcelaReducoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set numParcelamento
     *
     * @param integer $numParcelamento
     * @return Parcela
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
     * Set numParcela
     *
     * @param integer $numParcela
     * @return Parcela
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
     * Set vlrParcela
     *
     * @param integer $vlrParcela
     * @return Parcela
     */
    public function setVlrParcela($vlrParcela)
    {
        $this->vlrParcela = $vlrParcela;
        return $this;
    }

    /**
     * Get vlrParcela
     *
     * @return integer
     */
    public function getVlrParcela()
    {
        return $this->vlrParcela;
    }

    /**
     * Set dtVencimentoParcela
     *
     * @param \DateTime $dtVencimentoParcela
     * @return Parcela
     */
    public function setDtVencimentoParcela(\DateTime $dtVencimentoParcela)
    {
        $this->dtVencimentoParcela = $dtVencimentoParcela;
        return $this;
    }

    /**
     * Get dtVencimentoParcela
     *
     * @return \DateTime
     */
    public function getDtVencimentoParcela()
    {
        return $this->dtVencimentoParcela;
    }

    /**
     * Set paga
     *
     * @param boolean $paga
     * @return Parcela
     */
    public function setPaga($paga)
    {
        $this->paga = $paga;
        return $this;
    }

    /**
     * Get paga
     *
     * @return boolean
     */
    public function getPaga()
    {
        return $this->paga;
    }

    /**
     * Set cancelada
     *
     * @param boolean $cancelada
     * @return Parcela
     */
    public function setCancelada($cancelada)
    {
        $this->cancelada = $cancelada;
        return $this;
    }

    /**
     * Get cancelada
     *
     * @return boolean
     */
    public function getCancelada()
    {
        return $this->cancelada;
    }

    /**
     * OneToMany (owning side)
     * Add DividaDocumentoParcela
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DocumentoParcela $fkDividaDocumentoParcela
     * @return Parcela
     */
    public function addFkDividaDocumentoParcelas(\Urbem\CoreBundle\Entity\Divida\DocumentoParcela $fkDividaDocumentoParcela)
    {
        if (false === $this->fkDividaDocumentoParcelas->contains($fkDividaDocumentoParcela)) {
            $fkDividaDocumentoParcela->setFkDividaParcela($this);
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
     * Add DividaParcelaAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ParcelaAcrescimo $fkDividaParcelaAcrescimo
     * @return Parcela
     */
    public function addFkDividaParcelaAcrescimos(\Urbem\CoreBundle\Entity\Divida\ParcelaAcrescimo $fkDividaParcelaAcrescimo)
    {
        if (false === $this->fkDividaParcelaAcrescimos->contains($fkDividaParcelaAcrescimo)) {
            $fkDividaParcelaAcrescimo->setFkDividaParcela($this);
            $this->fkDividaParcelaAcrescimos->add($fkDividaParcelaAcrescimo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaParcelaAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ParcelaAcrescimo $fkDividaParcelaAcrescimo
     */
    public function removeFkDividaParcelaAcrescimos(\Urbem\CoreBundle\Entity\Divida\ParcelaAcrescimo $fkDividaParcelaAcrescimo)
    {
        $this->fkDividaParcelaAcrescimos->removeElement($fkDividaParcelaAcrescimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaParcelaAcrescimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ParcelaAcrescimo
     */
    public function getFkDividaParcelaAcrescimos()
    {
        return $this->fkDividaParcelaAcrescimos;
    }

    /**
     * OneToMany (owning side)
     * Add DividaParcelaCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ParcelaCalculo $fkDividaParcelaCalculo
     * @return Parcela
     */
    public function addFkDividaParcelaCalculos(\Urbem\CoreBundle\Entity\Divida\ParcelaCalculo $fkDividaParcelaCalculo)
    {
        if (false === $this->fkDividaParcelaCalculos->contains($fkDividaParcelaCalculo)) {
            $fkDividaParcelaCalculo->setFkDividaParcela($this);
            $this->fkDividaParcelaCalculos->add($fkDividaParcelaCalculo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaParcelaCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ParcelaCalculo $fkDividaParcelaCalculo
     */
    public function removeFkDividaParcelaCalculos(\Urbem\CoreBundle\Entity\Divida\ParcelaCalculo $fkDividaParcelaCalculo)
    {
        $this->fkDividaParcelaCalculos->removeElement($fkDividaParcelaCalculo);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaParcelaCalculos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ParcelaCalculo
     */
    public function getFkDividaParcelaCalculos()
    {
        return $this->fkDividaParcelaCalculos;
    }

    /**
     * OneToMany (owning side)
     * Add DividaParcelaReducao
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ParcelaReducao $fkDividaParcelaReducao
     * @return Parcela
     */
    public function addFkDividaParcelaReducoes(\Urbem\CoreBundle\Entity\Divida\ParcelaReducao $fkDividaParcelaReducao)
    {
        if (false === $this->fkDividaParcelaReducoes->contains($fkDividaParcelaReducao)) {
            $fkDividaParcelaReducao->setFkDividaParcela($this);
            $this->fkDividaParcelaReducoes->add($fkDividaParcelaReducao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaParcelaReducao
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ParcelaReducao $fkDividaParcelaReducao
     */
    public function removeFkDividaParcelaReducoes(\Urbem\CoreBundle\Entity\Divida\ParcelaReducao $fkDividaParcelaReducao)
    {
        $this->fkDividaParcelaReducoes->removeElement($fkDividaParcelaReducao);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaParcelaReducoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ParcelaReducao
     */
    public function getFkDividaParcelaReducoes()
    {
        return $this->fkDividaParcelaReducoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkDividaParcelamento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Parcelamento $fkDividaParcelamento
     * @return Parcela
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
}
