<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * MapaItem
 */
class MapaItem
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
    private $codMapa;

    /**
     * PK
     * @var string
     */
    private $exercicioSolicitacao;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codSolicitacao;

    /**
     * PK
     * @var integer
     */
    private $codCentro;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * PK
     * @var integer
     */
    private $lote = 0;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var integer
     */
    private $vlTotal;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaItemAnulacao
     */
    private $fkComprasMapaItemAnulacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaItemDotacao
     */
    private $fkComprasMapaItemDotacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\MapaSolicitacao
     */
    private $fkComprasMapaSolicitacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\SolicitacaoItem
     */
    private $fkComprasSolicitacaoItem;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasMapaItemAnulacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasMapaItemDotacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return MapaItem
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
     * Set codMapa
     *
     * @param integer $codMapa
     * @return MapaItem
     */
    public function setCodMapa($codMapa)
    {
        $this->codMapa = $codMapa;
        return $this;
    }

    /**
     * Get codMapa
     *
     * @return integer
     */
    public function getCodMapa()
    {
        return $this->codMapa;
    }

    /**
     * Set exercicioSolicitacao
     *
     * @param string $exercicioSolicitacao
     * @return MapaItem
     */
    public function setExercicioSolicitacao($exercicioSolicitacao)
    {
        $this->exercicioSolicitacao = $exercicioSolicitacao;
        return $this;
    }

    /**
     * Get exercicioSolicitacao
     *
     * @return string
     */
    public function getExercicioSolicitacao()
    {
        return $this->exercicioSolicitacao;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return MapaItem
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
     * Set codSolicitacao
     *
     * @param integer $codSolicitacao
     * @return MapaItem
     */
    public function setCodSolicitacao($codSolicitacao)
    {
        $this->codSolicitacao = $codSolicitacao;
        return $this;
    }

    /**
     * Get codSolicitacao
     *
     * @return integer
     */
    public function getCodSolicitacao()
    {
        return $this->codSolicitacao;
    }

    /**
     * Set codCentro
     *
     * @param integer $codCentro
     * @return MapaItem
     */
    public function setCodCentro($codCentro)
    {
        $this->codCentro = $codCentro;
        return $this;
    }

    /**
     * Get codCentro
     *
     * @return integer
     */
    public function getCodCentro()
    {
        return $this->codCentro;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return MapaItem
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
     * Set lote
     *
     * @param integer $lote
     * @return MapaItem
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
     * Set quantidade
     *
     * @param integer $quantidade
     * @return MapaItem
     */
    public function setQuantidade($quantidade = null)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    /**
     * Get quantidade
     *
     * @return integer
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set vlTotal
     *
     * @param integer $vlTotal
     * @return MapaItem
     */
    public function setVlTotal($vlTotal = null)
    {
        $this->vlTotal = $vlTotal;
        return $this;
    }

    /**
     * Get vlTotal
     *
     * @return integer
     */
    public function getVlTotal()
    {
        return $this->vlTotal;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasMapaItemAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaItemAnulacao $fkComprasMapaItemAnulacao
     * @return MapaItem
     */
    public function addFkComprasMapaItemAnulacoes(\Urbem\CoreBundle\Entity\Compras\MapaItemAnulacao $fkComprasMapaItemAnulacao)
    {
        if (false === $this->fkComprasMapaItemAnulacoes->contains($fkComprasMapaItemAnulacao)) {
            $fkComprasMapaItemAnulacao->setFkComprasMapaItem($this);
            $this->fkComprasMapaItemAnulacoes->add($fkComprasMapaItemAnulacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasMapaItemAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaItemAnulacao $fkComprasMapaItemAnulacao
     */
    public function removeFkComprasMapaItemAnulacoes(\Urbem\CoreBundle\Entity\Compras\MapaItemAnulacao $fkComprasMapaItemAnulacao)
    {
        $this->fkComprasMapaItemAnulacoes->removeElement($fkComprasMapaItemAnulacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasMapaItemAnulacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaItemAnulacao
     */
    public function getFkComprasMapaItemAnulacoes()
    {
        return $this->fkComprasMapaItemAnulacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasMapaItemDotacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaItemDotacao $fkComprasMapaItemDotacao
     * @return MapaItem
     */
    public function addFkComprasMapaItemDotacoes(\Urbem\CoreBundle\Entity\Compras\MapaItemDotacao $fkComprasMapaItemDotacao)
    {
        if (false === $this->fkComprasMapaItemDotacoes->contains($fkComprasMapaItemDotacao)) {
            $fkComprasMapaItemDotacao->setFkComprasMapaItem($this);
            $this->fkComprasMapaItemDotacoes->add($fkComprasMapaItemDotacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasMapaItemDotacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaItemDotacao $fkComprasMapaItemDotacao
     */
    public function removeFkComprasMapaItemDotacoes(\Urbem\CoreBundle\Entity\Compras\MapaItemDotacao $fkComprasMapaItemDotacao)
    {
        $this->fkComprasMapaItemDotacoes->removeElement($fkComprasMapaItemDotacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasMapaItemDotacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaItemDotacao
     */
    public function getFkComprasMapaItemDotacoes()
    {
        return $this->fkComprasMapaItemDotacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasMapaSolicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaSolicitacao $fkComprasMapaSolicitacao
     * @return MapaItem
     */
    public function setFkComprasMapaSolicitacao(\Urbem\CoreBundle\Entity\Compras\MapaSolicitacao $fkComprasMapaSolicitacao)
    {
        $this->exercicio = $fkComprasMapaSolicitacao->getExercicio();
        $this->codMapa = $fkComprasMapaSolicitacao->getCodMapa();
        $this->exercicioSolicitacao = $fkComprasMapaSolicitacao->getExercicioSolicitacao();
        $this->codEntidade = $fkComprasMapaSolicitacao->getCodEntidade();
        $this->codSolicitacao = $fkComprasMapaSolicitacao->getCodSolicitacao();
        $this->fkComprasMapaSolicitacao = $fkComprasMapaSolicitacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasMapaSolicitacao
     *
     * @return \Urbem\CoreBundle\Entity\Compras\MapaSolicitacao
     */
    public function getFkComprasMapaSolicitacao()
    {
        return $this->fkComprasMapaSolicitacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasSolicitacaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItem $fkComprasSolicitacaoItem
     * @return MapaItem
     */
    public function setFkComprasSolicitacaoItem(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItem $fkComprasSolicitacaoItem)
    {
        $this->exercicioSolicitacao = $fkComprasSolicitacaoItem->getExercicio();
        $this->codEntidade = $fkComprasSolicitacaoItem->getCodEntidade();
        $this->codSolicitacao = $fkComprasSolicitacaoItem->getCodSolicitacao();
        $this->codCentro = $fkComprasSolicitacaoItem->getCodCentro();
        $this->codItem = $fkComprasSolicitacaoItem->getCodItem();
        $this->fkComprasSolicitacaoItem = $fkComprasSolicitacaoItem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasSolicitacaoItem
     *
     * @return \Urbem\CoreBundle\Entity\Compras\SolicitacaoItem
     */
    public function getFkComprasSolicitacaoItem()
    {
        return $this->fkComprasSolicitacaoItem;
    }
}
