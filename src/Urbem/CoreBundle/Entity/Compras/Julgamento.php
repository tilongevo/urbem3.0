<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * Julgamento
 */
class Julgamento
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
     * @var string
     */
    private $observacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Compras\Cotacao
     */
    private $fkComprasCotacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\JulgamentoItem
     */
    private $fkComprasJulgamentoItens;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasJulgamentoItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Julgamento
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
     * @return Julgamento
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
     * @return Julgamento
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
     * Set observacao
     *
     * @param string $observacao
     * @return Julgamento
     */
    public function setObservacao($observacao = null)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasJulgamentoItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\JulgamentoItem $fkComprasJulgamentoItem
     * @return Julgamento
     */
    public function addFkComprasJulgamentoItens(\Urbem\CoreBundle\Entity\Compras\JulgamentoItem $fkComprasJulgamentoItem)
    {
        if (false === $this->fkComprasJulgamentoItens->contains($fkComprasJulgamentoItem)) {
            $fkComprasJulgamentoItem->setFkComprasJulgamento($this);
            $this->fkComprasJulgamentoItens->add($fkComprasJulgamentoItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasJulgamentoItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\JulgamentoItem $fkComprasJulgamentoItem
     */
    public function removeFkComprasJulgamentoItens(\Urbem\CoreBundle\Entity\Compras\JulgamentoItem $fkComprasJulgamentoItem)
    {
        $this->fkComprasJulgamentoItens->removeElement($fkComprasJulgamentoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasJulgamentoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\JulgamentoItem
     */
    public function getFkComprasJulgamentoItens()
    {
        return $this->fkComprasJulgamentoItens;
    }

    /**
     * OneToOne (owning side)
     * Set ComprasCotacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Cotacao $fkComprasCotacao
     * @return Julgamento
     */
    public function setFkComprasCotacao(\Urbem\CoreBundle\Entity\Compras\Cotacao $fkComprasCotacao)
    {
        $this->exercicio = $fkComprasCotacao->getExercicio();
        $this->codCotacao = $fkComprasCotacao->getCodCotacao();
        $this->fkComprasCotacao = $fkComprasCotacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkComprasCotacao
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Cotacao
     */
    public function getFkComprasCotacao()
    {
        return $this->fkComprasCotacao;
    }
}
