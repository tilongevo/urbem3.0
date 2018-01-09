<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * CotacaoFornecedorItem
 */
class CotacaoFornecedorItem
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
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * PK
     * @var integer
     */
    private $cgmFornecedor;

    /**
     * PK
     * @var integer
     */
    private $lote;

    /**
     * @var integer
     */
    private $codMarca;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $dtValidade;

    /**
     * @var integer
     */
    private $vlCotacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Compras\JulgamentoItem
     */
    private $fkComprasJulgamentoItem;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItemDesclassificacao
     */
    private $fkComprasCotacaoFornecedorItemDesclassificacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\CotacaoLicitacao
     */
    private $fkLicitacaoCotacaoLicitacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\CotacaoItem
     */
    private $fkComprasCotacaoItem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca
     */
    private $fkAlmoxarifadoCatalogoItemMarca;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Fornecedor
     */
    private $fkComprasFornecedor;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoCotacaoLicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return CotacaoFornecedorItem
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
     * @return CotacaoFornecedorItem
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
     * Set codItem
     *
     * @param integer $codItem
     * @return CotacaoFornecedorItem
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
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return CotacaoFornecedorItem
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
     * @return CotacaoFornecedorItem
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
     * Set codMarca
     *
     * @param integer $codMarca
     * @return CotacaoFornecedorItem
     */
    public function setCodMarca($codMarca)
    {
        $this->codMarca = $codMarca;
        return $this;
    }

    /**
     * Get codMarca
     *
     * @return integer
     */
    public function getCodMarca()
    {
        return $this->codMarca;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return CotacaoFornecedorItem
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp = null)
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
     * Set dtValidade
     *
     * @param \DateTime $dtValidade
     * @return CotacaoFornecedorItem
     */
    public function setDtValidade(\DateTime $dtValidade = null)
    {
        $this->dtValidade = $dtValidade;
        return $this;
    }

    /**
     * Get dtValidade
     *
     * @return \DateTime
     */
    public function getDtValidade()
    {
        return $this->dtValidade;
    }

    /**
     * Set vlCotacao
     *
     * @param integer $vlCotacao
     * @return CotacaoFornecedorItem
     */
    public function setVlCotacao($vlCotacao = null)
    {
        $this->vlCotacao = $vlCotacao;
        return $this;
    }

    /**
     * Get vlCotacao
     *
     * @return integer
     */
    public function getVlCotacao()
    {
        return $this->vlCotacao;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoCotacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\CotacaoLicitacao $fkLicitacaoCotacaoLicitacao
     * @return CotacaoFornecedorItem
     */
    public function addFkLicitacaoCotacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\CotacaoLicitacao $fkLicitacaoCotacaoLicitacao)
    {
        if (false === $this->fkLicitacaoCotacaoLicitacoes->contains($fkLicitacaoCotacaoLicitacao)) {
            $fkLicitacaoCotacaoLicitacao->setFkComprasCotacaoFornecedorItem($this);
            $this->fkLicitacaoCotacaoLicitacoes->add($fkLicitacaoCotacaoLicitacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoCotacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\CotacaoLicitacao $fkLicitacaoCotacaoLicitacao
     */
    public function removeFkLicitacaoCotacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\CotacaoLicitacao $fkLicitacaoCotacaoLicitacao)
    {
        $this->fkLicitacaoCotacaoLicitacoes->removeElement($fkLicitacaoCotacaoLicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoCotacaoLicitacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\CotacaoLicitacao
     */
    public function getFkLicitacaoCotacaoLicitacoes()
    {
        return $this->fkLicitacaoCotacaoLicitacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasCotacaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CotacaoItem $fkComprasCotacaoItem
     * @return CotacaoFornecedorItem
     */
    public function setFkComprasCotacaoItem(\Urbem\CoreBundle\Entity\Compras\CotacaoItem $fkComprasCotacaoItem)
    {
        $this->exercicio = $fkComprasCotacaoItem->getExercicio();
        $this->codCotacao = $fkComprasCotacaoItem->getCodCotacao();
        $this->lote = $fkComprasCotacaoItem->getLote();
        $this->codItem = $fkComprasCotacaoItem->getCodItem();
        $this->fkComprasCotacaoItem = $fkComprasCotacaoItem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasCotacaoItem
     *
     * @return \Urbem\CoreBundle\Entity\Compras\CotacaoItem
     */
    public function getFkComprasCotacaoItem()
    {
        return $this->fkComprasCotacaoItem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCatalogoItemMarca
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca $fkAlmoxarifadoCatalogoItemMarca
     * @return CotacaoFornecedorItem
     */
    public function setFkAlmoxarifadoCatalogoItemMarca(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca $fkAlmoxarifadoCatalogoItemMarca)
    {
        $this->codItem = $fkAlmoxarifadoCatalogoItemMarca->getCodItem();
        $this->codMarca = $fkAlmoxarifadoCatalogoItemMarca->getCodMarca();
        $this->fkAlmoxarifadoCatalogoItemMarca = $fkAlmoxarifadoCatalogoItemMarca;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoCatalogoItemMarca
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca
     */
    public function getFkAlmoxarifadoCatalogoItemMarca()
    {
        return $this->fkAlmoxarifadoCatalogoItemMarca;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Fornecedor $fkComprasFornecedor
     * @return CotacaoFornecedorItem
     */
    public function setFkComprasFornecedor(\Urbem\CoreBundle\Entity\Compras\Fornecedor $fkComprasFornecedor)
    {
        $this->cgmFornecedor = $fkComprasFornecedor->getCgmFornecedor();
        $this->fkComprasFornecedor = $fkComprasFornecedor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasFornecedor
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Fornecedor
     */
    public function getFkComprasFornecedor()
    {
        return $this->fkComprasFornecedor;
    }

    /**
     * OneToOne (inverse side)
     * Set ComprasJulgamentoItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\JulgamentoItem $fkComprasJulgamentoItem
     * @return CotacaoFornecedorItem
     */
    public function setFkComprasJulgamentoItem(\Urbem\CoreBundle\Entity\Compras\JulgamentoItem $fkComprasJulgamentoItem)
    {
        $fkComprasJulgamentoItem->setFkComprasCotacaoFornecedorItem($this);
        $this->fkComprasJulgamentoItem = $fkComprasJulgamentoItem;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkComprasJulgamentoItem
     *
     * @return \Urbem\CoreBundle\Entity\Compras\JulgamentoItem
     */
    public function getFkComprasJulgamentoItem()
    {
        return $this->fkComprasJulgamentoItem;
    }

    /**
     * OneToOne (inverse side)
     * Set ComprasCotacaoFornecedorItemDesclassificacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItemDesclassificacao $fkComprasCotacaoFornecedorItemDesclassificacao
     * @return CotacaoFornecedorItem
     */
    public function setFkComprasCotacaoFornecedorItemDesclassificacao(\Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItemDesclassificacao $fkComprasCotacaoFornecedorItemDesclassificacao)
    {
        $fkComprasCotacaoFornecedorItemDesclassificacao->setFkComprasCotacaoFornecedorItem($this);
        $this->fkComprasCotacaoFornecedorItemDesclassificacao = $fkComprasCotacaoFornecedorItemDesclassificacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkComprasCotacaoFornecedorItemDesclassificacao
     *
     * @return \Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItemDesclassificacao
     */
    public function getFkComprasCotacaoFornecedorItemDesclassificacao()
    {
        return $this->fkComprasCotacaoFornecedorItemDesclassificacao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->codCotacao && $this->exercicio) {
            return sprintf(
                '%s/%s',
                $this->codCotacao,
                $this->exercicio
            );
        } else {
            return 'Cotação Fornecedor Item';
        }
    }
}
