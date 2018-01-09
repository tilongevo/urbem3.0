<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * Cotacao
 */
class Cotacao
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codCotacao;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Compras\CotacaoAnulada
     */
    private $fkComprasCotacaoAnulada;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Compras\Julgamento
     */
    private $fkComprasJulgamento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaCotacao
     */
    private $fkComprasMapaCotacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\CotacaoItem
     */
    private $fkComprasCotacaoItens;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasMapaCotacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasCotacaoItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Cotacao
     */
    public function setExercicio($exercicio)
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
     * Set codCotacao
     *
     * @param integer $codCotacao
     * @return Cotacao
     */
    public function setCodCotacao($codCotacao)
    {
        $this->codCotacao = $codCotacao;
        return $this;
    }

    /**
     * Get codCotacao
     *
     * @return integer
     */
    public function getCodCotacao()
    {
        return $this->codCotacao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Cotacao
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasMapaCotacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaCotacao $fkComprasMapaCotacao
     * @return Cotacao
     */
    public function addFkComprasMapaCotacoes(\Urbem\CoreBundle\Entity\Compras\MapaCotacao $fkComprasMapaCotacao)
    {
        if (false === $this->fkComprasMapaCotacoes->contains($fkComprasMapaCotacao)) {
            $fkComprasMapaCotacao->setFkComprasCotacao($this);
            $this->fkComprasMapaCotacoes->add($fkComprasMapaCotacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasMapaCotacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaCotacao $fkComprasMapaCotacao
     */
    public function removeFkComprasMapaCotacoes(\Urbem\CoreBundle\Entity\Compras\MapaCotacao $fkComprasMapaCotacao)
    {
        $this->fkComprasMapaCotacoes->removeElement($fkComprasMapaCotacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasMapaCotacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaCotacao
     */
    public function getFkComprasMapaCotacoes()
    {
        return $this->fkComprasMapaCotacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasCotacaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CotacaoItem $fkComprasCotacaoItem
     * @return Cotacao
     */
    public function addFkComprasCotacaoItens(\Urbem\CoreBundle\Entity\Compras\CotacaoItem $fkComprasCotacaoItem)
    {
        if (false === $this->fkComprasCotacaoItens->contains($fkComprasCotacaoItem)) {
            $fkComprasCotacaoItem->setFkComprasCotacao($this);
            $this->fkComprasCotacaoItens->add($fkComprasCotacaoItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasCotacaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CotacaoItem $fkComprasCotacaoItem
     */
    public function removeFkComprasCotacaoItens(\Urbem\CoreBundle\Entity\Compras\CotacaoItem $fkComprasCotacaoItem)
    {
        $this->fkComprasCotacaoItens->removeElement($fkComprasCotacaoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasCotacaoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\CotacaoItem
     */
    public function getFkComprasCotacaoItens()
    {
        return $this->fkComprasCotacaoItens;
    }

    /**
     * OneToOne (inverse side)
     * Set ComprasCotacaoAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CotacaoAnulada $fkComprasCotacaoAnulada
     * @return Cotacao
     */
    public function setFkComprasCotacaoAnulada(\Urbem\CoreBundle\Entity\Compras\CotacaoAnulada $fkComprasCotacaoAnulada)
    {
        $fkComprasCotacaoAnulada->setFkComprasCotacao($this);
        $this->fkComprasCotacaoAnulada = $fkComprasCotacaoAnulada;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkComprasCotacaoAnulada
     *
     * @return \Urbem\CoreBundle\Entity\Compras\CotacaoAnulada
     */
    public function getFkComprasCotacaoAnulada()
    {
        return $this->fkComprasCotacaoAnulada;
    }

    /**
     * OneToOne (inverse side)
     * Set ComprasJulgamento
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Julgamento $fkComprasJulgamento
     * @return Cotacao
     */
    public function setFkComprasJulgamento(\Urbem\CoreBundle\Entity\Compras\Julgamento $fkComprasJulgamento)
    {
        $fkComprasJulgamento->setFkComprasCotacao($this);
        $this->fkComprasJulgamento = $fkComprasJulgamento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkComprasJulgamento
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Julgamento
     */
    public function getFkComprasJulgamento()
    {
        return $this->fkComprasJulgamento;
    }
}
