<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * MapaItemDotacao
 */
class MapaItemDotacao
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
    private $lote;

    /**
     * PK
     * @var integer
     */
    private $codConta;

    /**
     * PK
     * @var integer
     */
    private $codDespesa;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var integer
     */
    private $vlDotacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Compras\MapaItemReserva
     */
    private $fkComprasMapaItemReserva;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaItemAnulacao
     */
    private $fkComprasMapaItemAnulacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\MapaItem
     */
    private $fkComprasMapaItem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao
     */
    private $fkComprasSolicitacaoItemDotacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasMapaItemAnulacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return MapaItemDotacao
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
     * @return MapaItemDotacao
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
     * @return MapaItemDotacao
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
     * @return MapaItemDotacao
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
     * @return MapaItemDotacao
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
     * @return MapaItemDotacao
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
     * @return MapaItemDotacao
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
     * @return MapaItemDotacao
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
     * Set codConta
     *
     * @param integer $codConta
     * @return MapaItemDotacao
     */
    public function setCodConta($codConta)
    {
        $this->codConta = $codConta;
        return $this;
    }

    /**
     * Get codConta
     *
     * @return integer
     */
    public function getCodConta()
    {
        return $this->codConta;
    }

    /**
     * Set codDespesa
     *
     * @param integer $codDespesa
     * @return MapaItemDotacao
     */
    public function setCodDespesa($codDespesa)
    {
        $this->codDespesa = $codDespesa;
        return $this;
    }

    /**
     * Get codDespesa
     *
     * @return integer
     */
    public function getCodDespesa()
    {
        return $this->codDespesa;
    }

    /**
     * Set quantidade
     *
     * @param integer $quantidade
     * @return MapaItemDotacao
     */
    public function setQuantidade($quantidade)
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
     * Set vlDotacao
     *
     * @param integer $vlDotacao
     * @return MapaItemDotacao
     */
    public function setVlDotacao($vlDotacao)
    {
        $this->vlDotacao = $vlDotacao;
        return $this;
    }

    /**
     * Get vlDotacao
     *
     * @return integer
     */
    public function getVlDotacao()
    {
        return $this->vlDotacao;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasMapaItemAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaItemAnulacao $fkComprasMapaItemAnulacao
     * @return MapaItemDotacao
     */
    public function addFkComprasMapaItemAnulacoes(\Urbem\CoreBundle\Entity\Compras\MapaItemAnulacao $fkComprasMapaItemAnulacao)
    {
        if (false === $this->fkComprasMapaItemAnulacoes->contains($fkComprasMapaItemAnulacao)) {
            $fkComprasMapaItemAnulacao->setFkComprasMapaItemDotacao($this);
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
     * ManyToOne (inverse side)
     * Set fkComprasMapaItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaItem $fkComprasMapaItem
     * @return MapaItemDotacao
     */
    public function setFkComprasMapaItem(\Urbem\CoreBundle\Entity\Compras\MapaItem $fkComprasMapaItem)
    {
        $this->exercicio = $fkComprasMapaItem->getExercicio();
        $this->codMapa = $fkComprasMapaItem->getCodMapa();
        $this->exercicioSolicitacao = $fkComprasMapaItem->getExercicioSolicitacao();
        $this->codEntidade = $fkComprasMapaItem->getCodEntidade();
        $this->codSolicitacao = $fkComprasMapaItem->getCodSolicitacao();
        $this->codCentro = $fkComprasMapaItem->getCodCentro();
        $this->codItem = $fkComprasMapaItem->getCodItem();
        $this->lote = $fkComprasMapaItem->getLote();
        $this->fkComprasMapaItem = $fkComprasMapaItem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasMapaItem
     *
     * @return \Urbem\CoreBundle\Entity\Compras\MapaItem
     */
    public function getFkComprasMapaItem()
    {
        return $this->fkComprasMapaItem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasSolicitacaoItemDotacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao $fkComprasSolicitacaoItemDotacao
     * @return MapaItemDotacao
     */
    public function setFkComprasSolicitacaoItemDotacao(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao $fkComprasSolicitacaoItemDotacao)
    {
        $this->exercicioSolicitacao = $fkComprasSolicitacaoItemDotacao->getExercicio();
        $this->codEntidade = $fkComprasSolicitacaoItemDotacao->getCodEntidade();
        $this->codSolicitacao = $fkComprasSolicitacaoItemDotacao->getCodSolicitacao();
        $this->codCentro = $fkComprasSolicitacaoItemDotacao->getCodCentro();
        $this->codItem = $fkComprasSolicitacaoItemDotacao->getCodItem();
        $this->codConta = $fkComprasSolicitacaoItemDotacao->getCodConta();
        $this->codDespesa = $fkComprasSolicitacaoItemDotacao->getCodDespesa();
        $this->fkComprasSolicitacaoItemDotacao = $fkComprasSolicitacaoItemDotacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasSolicitacaoItemDotacao
     *
     * @return \Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao
     */
    public function getFkComprasSolicitacaoItemDotacao()
    {
        return $this->fkComprasSolicitacaoItemDotacao;
    }

    /**
     * OneToOne (inverse side)
     * Set ComprasMapaItemReserva
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaItemReserva $fkComprasMapaItemReserva
     * @return MapaItemDotacao
     */
    public function setFkComprasMapaItemReserva(\Urbem\CoreBundle\Entity\Compras\MapaItemReserva $fkComprasMapaItemReserva)
    {
        $fkComprasMapaItemReserva->setFkComprasMapaItemDotacao($this);
        $this->fkComprasMapaItemReserva = $fkComprasMapaItemReserva;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkComprasMapaItemReserva
     *
     * @return \Urbem\CoreBundle\Entity\Compras\MapaItemReserva
     */
    public function getFkComprasMapaItemReserva()
    {
        return $this->fkComprasMapaItemReserva;
    }
}
