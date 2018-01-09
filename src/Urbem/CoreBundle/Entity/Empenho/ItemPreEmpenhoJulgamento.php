<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * ItemPreEmpenhoJulgamento
 */
class ItemPreEmpenhoJulgamento
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
    private $codPreEmpenho;

    /**
     * PK
     * @var integer
     */
    private $numItem;

    /**
     * @var string
     */
    private $exercicioJulgamento;

    /**
     * @var integer
     */
    private $cgmFornecedor;

    /**
     * @var integer
     */
    private $lote;

    /**
     * @var integer
     */
    private $codItem;

    /**
     * @var integer
     */
    private $codCotacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho
     */
    private $fkEmpenhoItemPreEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\JulgamentoItem
     */
    private $fkComprasJulgamentoItem;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ItemPreEmpenhoJulgamento
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
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return ItemPreEmpenhoJulgamento
     */
    public function setCodPreEmpenho($codPreEmpenho)
    {
        $this->codPreEmpenho = $codPreEmpenho;
        return $this;
    }

    /**
     * Get codPreEmpenho
     *
     * @return integer
     */
    public function getCodPreEmpenho()
    {
        return $this->codPreEmpenho;
    }

    /**
     * Set numItem
     *
     * @param integer $numItem
     * @return ItemPreEmpenhoJulgamento
     */
    public function setNumItem($numItem)
    {
        $this->numItem = $numItem;
        return $this;
    }

    /**
     * Get numItem
     *
     * @return integer
     */
    public function getNumItem()
    {
        return $this->numItem;
    }

    /**
     * Set exercicioJulgamento
     *
     * @param string $exercicioJulgamento
     * @return ItemPreEmpenhoJulgamento
     */
    public function setExercicioJulgamento($exercicioJulgamento)
    {
        $this->exercicioJulgamento = $exercicioJulgamento;
        return $this;
    }

    /**
     * Get exercicioJulgamento
     *
     * @return string
     */
    public function getExercicioJulgamento()
    {
        return $this->exercicioJulgamento;
    }

    /**
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return ItemPreEmpenhoJulgamento
     */
    public function setCgmFornecedor($cgmFornecedor)
    {
        $this->cgmFornecedor = $cgmFornecedor;
        return $this;
    }

    /**
     * Get cgmFornecedor
     *
     * @return integer
     */
    public function getCgmFornecedor()
    {
        return $this->cgmFornecedor;
    }

    /**
     * Set lote
     *
     * @param integer $lote
     * @return ItemPreEmpenhoJulgamento
     */
    public function setLote($lote)
    {
        $this->lote = $lote;
        return $this;
    }

    /**
     * Get lote
     *
     * @return integer
     */
    public function getLote()
    {
        return $this->lote;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return ItemPreEmpenhoJulgamento
     */
    public function setCodItem($codItem)
    {
        $this->codItem = $codItem;
        return $this;
    }

    /**
     * Get codItem
     *
     * @return integer
     */
    public function getCodItem()
    {
        return $this->codItem;
    }

    /**
     * Set codCotacao
     *
     * @param integer $codCotacao
     * @return ItemPreEmpenhoJulgamento
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
     * ManyToOne (inverse side)
     * Set fkComprasJulgamentoItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\JulgamentoItem $fkComprasJulgamentoItem
     * @return ItemPreEmpenhoJulgamento
     */
    public function setFkComprasJulgamentoItem(\Urbem\CoreBundle\Entity\Compras\JulgamentoItem $fkComprasJulgamentoItem)
    {
        $this->exercicioJulgamento = $fkComprasJulgamentoItem->getExercicio();
        $this->codCotacao = $fkComprasJulgamentoItem->getCodCotacao();
        $this->codItem = $fkComprasJulgamentoItem->getCodItem();
        $this->cgmFornecedor = $fkComprasJulgamentoItem->getCgmFornecedor();
        $this->lote = $fkComprasJulgamentoItem->getLote();
        $this->fkComprasJulgamentoItem = $fkComprasJulgamentoItem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasJulgamentoItem
     *
     * @return \Urbem\CoreBundle\Entity\Compras\JulgamentoItem
     */
    public function getFkComprasJulgamentoItem()
    {
        return $this->fkComprasJulgamentoItem;
    }

    /**
     * OneToOne (owning side)
     * Set EmpenhoItemPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho
     * @return ItemPreEmpenhoJulgamento
     */
    public function setFkEmpenhoItemPreEmpenho(\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho)
    {
        $this->codPreEmpenho = $fkEmpenhoItemPreEmpenho->getCodPreEmpenho();
        $this->exercicio = $fkEmpenhoItemPreEmpenho->getExercicio();
        $this->numItem = $fkEmpenhoItemPreEmpenho->getNumItem();
        $this->fkEmpenhoItemPreEmpenho = $fkEmpenhoItemPreEmpenho;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEmpenhoItemPreEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho
     */
    public function getFkEmpenhoItemPreEmpenho()
    {
        return $this->fkEmpenhoItemPreEmpenho;
    }
}
