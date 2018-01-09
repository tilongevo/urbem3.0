<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * CotacaoFornecedorItemDesclassificacao
 */
class CotacaoFornecedorItemDesclassificacao
{
    /**
     * PK
     * @var integer
     */
    private $cgmFornecedor;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * PK
     * @var integer
     */
    private $codCotacao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $lote;

    /**
     * @var string
     */
    private $justificativa;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem
     */
    private $fkComprasCotacaoFornecedorItem;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return CotacaoFornecedorItemDesclassificacao
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
     * Set codItem
     *
     * @param integer $codItem
     * @return CotacaoFornecedorItemDesclassificacao
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
     * @return CotacaoFornecedorItemDesclassificacao
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return CotacaoFornecedorItemDesclassificacao
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
     * Set lote
     *
     * @param integer $lote
     * @return CotacaoFornecedorItemDesclassificacao
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
     * Set justificativa
     *
     * @param string $justificativa
     * @return CotacaoFornecedorItemDesclassificacao
     */
    public function setJustificativa($justificativa)
    {
        $this->justificativa = $justificativa;
        return $this;
    }

    /**
     * Get justificativa
     *
     * @return string
     */
    public function getJustificativa()
    {
        return $this->justificativa;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return CotacaoFornecedorItemDesclassificacao
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
     * OneToOne (owning side)
     * Set ComprasCotacaoFornecedorItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem $fkComprasCotacaoFornecedorItem
     * @return CotacaoFornecedorItemDesclassificacao
     */
    public function setFkComprasCotacaoFornecedorItem(\Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem $fkComprasCotacaoFornecedorItem)
    {
        $this->exercicio = $fkComprasCotacaoFornecedorItem->getExercicio();
        $this->codCotacao = $fkComprasCotacaoFornecedorItem->getCodCotacao();
        $this->codItem = $fkComprasCotacaoFornecedorItem->getCodItem();
        $this->cgmFornecedor = $fkComprasCotacaoFornecedorItem->getCgmFornecedor();
        $this->lote = $fkComprasCotacaoFornecedorItem->getLote();
        $this->fkComprasCotacaoFornecedorItem = $fkComprasCotacaoFornecedorItem;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkComprasCotacaoFornecedorItem
     *
     * @return \Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem
     */
    public function getFkComprasCotacaoFornecedorItem()
    {
        return $this->fkComprasCotacaoFornecedorItem;
    }
}
