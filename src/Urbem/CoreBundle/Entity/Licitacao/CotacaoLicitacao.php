<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * CotacaoLicitacao
 */
class CotacaoLicitacao
{
    /**
     * PK
     * @var integer
     */
    private $codLicitacao;

    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicioLicitacao;

    /**
     * PK
     * @var integer
     */
    private $lote;

    /**
     * PK
     * @var integer
     */
    private $codCotacao;

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
     * @var string
     */
    private $exercicioCotacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Adjudicacao
     */
    private $fkLicitacaoAdjudicacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    private $fkLicitacaoLicitacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem
     */
    private $fkComprasCotacaoFornecedorItem;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoAdjudicacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codLicitacao
     *
     * @param integer $codLicitacao
     * @return CotacaoLicitacao
     */
    public function setCodLicitacao($codLicitacao)
    {
        $this->codLicitacao = $codLicitacao;
        return $this;
    }

    /**
     * Get codLicitacao
     *
     * @return integer
     */
    public function getCodLicitacao()
    {
        return $this->codLicitacao;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return CotacaoLicitacao
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return CotacaoLicitacao
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set exercicioLicitacao
     *
     * @param string $exercicioLicitacao
     * @return CotacaoLicitacao
     */
    public function setExercicioLicitacao($exercicioLicitacao)
    {
        $this->exercicioLicitacao = $exercicioLicitacao;
        return $this;
    }

    /**
     * Get exercicioLicitacao
     *
     * @return string
     */
    public function getExercicioLicitacao()
    {
        return $this->exercicioLicitacao;
    }

    /**
     * Set lote
     *
     * @param integer $lote
     * @return CotacaoLicitacao
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
     * Set codCotacao
     *
     * @param integer $codCotacao
     * @return CotacaoLicitacao
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
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return CotacaoLicitacao
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
     * @return CotacaoLicitacao
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
     * Set exercicioCotacao
     *
     * @param string $exercicioCotacao
     * @return CotacaoLicitacao
     */
    public function setExercicioCotacao($exercicioCotacao)
    {
        $this->exercicioCotacao = $exercicioCotacao;
        return $this;
    }

    /**
     * Get exercicioCotacao
     *
     * @return string
     */
    public function getExercicioCotacao()
    {
        return $this->exercicioCotacao;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoAdjudicacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Adjudicacao $fkLicitacaoAdjudicacao
     * @return CotacaoLicitacao
     */
    public function addFkLicitacaoAdjudicacoes(\Urbem\CoreBundle\Entity\Licitacao\Adjudicacao $fkLicitacaoAdjudicacao)
    {
        if (false === $this->fkLicitacaoAdjudicacoes->contains($fkLicitacaoAdjudicacao)) {
            $fkLicitacaoAdjudicacao->setFkLicitacaoCotacaoLicitacao($this);
            $this->fkLicitacaoAdjudicacoes->add($fkLicitacaoAdjudicacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoAdjudicacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Adjudicacao $fkLicitacaoAdjudicacao
     */
    public function removeFkLicitacaoAdjudicacoes(\Urbem\CoreBundle\Entity\Licitacao\Adjudicacao $fkLicitacaoAdjudicacao)
    {
        $this->fkLicitacaoAdjudicacoes->removeElement($fkLicitacaoAdjudicacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoAdjudicacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Adjudicacao
     */
    public function getFkLicitacaoAdjudicacoes()
    {
        return $this->fkLicitacaoAdjudicacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     * @return CotacaoLicitacao
     */
    public function setFkLicitacaoLicitacao(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        $this->codLicitacao = $fkLicitacaoLicitacao->getCodLicitacao();
        $this->codModalidade = $fkLicitacaoLicitacao->getCodModalidade();
        $this->codEntidade = $fkLicitacaoLicitacao->getCodEntidade();
        $this->exercicioLicitacao = $fkLicitacaoLicitacao->getExercicio();
        $this->fkLicitacaoLicitacao = $fkLicitacaoLicitacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoLicitacao
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    public function getFkLicitacaoLicitacao()
    {
        return $this->fkLicitacaoLicitacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasCotacaoFornecedorItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem $fkComprasCotacaoFornecedorItem
     * @return CotacaoLicitacao
     */
    public function setFkComprasCotacaoFornecedorItem(\Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem $fkComprasCotacaoFornecedorItem)
    {
        $this->exercicioCotacao = $fkComprasCotacaoFornecedorItem->getExercicio();
        $this->codCotacao = $fkComprasCotacaoFornecedorItem->getCodCotacao();
        $this->codItem = $fkComprasCotacaoFornecedorItem->getCodItem();
        $this->cgmFornecedor = $fkComprasCotacaoFornecedorItem->getCgmFornecedor();
        $this->lote = $fkComprasCotacaoFornecedorItem->getLote();
        $this->fkComprasCotacaoFornecedorItem = $fkComprasCotacaoFornecedorItem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasCotacaoFornecedorItem
     *
     * @return \Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem
     */
    public function getFkComprasCotacaoFornecedorItem()
    {
        return $this->fkComprasCotacaoFornecedorItem;
    }
}
