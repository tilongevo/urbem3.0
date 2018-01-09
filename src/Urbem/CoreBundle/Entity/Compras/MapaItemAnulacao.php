<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * MapaItemAnulacao
 */
class MapaItemAnulacao
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
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

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
    private $vlTotal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\MapaItemDotacao
     */
    private $fkComprasMapaItemDotacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\MapaSolicitacaoAnulacao
     */
    private $fkComprasMapaSolicitacaoAnulacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\MapaItem
     */
    private $fkComprasMapaItem;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return MapaItemAnulacao
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
     * @return MapaItemAnulacao
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
     * @return MapaItemAnulacao
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
     * @return MapaItemAnulacao
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
     * @return MapaItemAnulacao
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
     * @return MapaItemAnulacao
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
     * @return MapaItemAnulacao
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return MapaItemAnulacao
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
     * Set lote
     *
     * @param integer $lote
     * @return MapaItemAnulacao
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
     * @return MapaItemAnulacao
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
     * @return MapaItemAnulacao
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
     * @return MapaItemAnulacao
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
     * @return MapaItemAnulacao
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
     * ManyToOne (inverse side)
     * Set fkComprasMapaItemDotacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaItemDotacao $fkComprasMapaItemDotacao
     * @return MapaItemAnulacao
     */
    public function setFkComprasMapaItemDotacao(\Urbem\CoreBundle\Entity\Compras\MapaItemDotacao $fkComprasMapaItemDotacao)
    {
        $this->exercicio = $fkComprasMapaItemDotacao->getExercicio();
        $this->codMapa = $fkComprasMapaItemDotacao->getCodMapa();
        $this->exercicioSolicitacao = $fkComprasMapaItemDotacao->getExercicioSolicitacao();
        $this->codEntidade = $fkComprasMapaItemDotacao->getCodEntidade();
        $this->codSolicitacao = $fkComprasMapaItemDotacao->getCodSolicitacao();
        $this->codCentro = $fkComprasMapaItemDotacao->getCodCentro();
        $this->codItem = $fkComprasMapaItemDotacao->getCodItem();
        $this->lote = $fkComprasMapaItemDotacao->getLote();
        $this->codConta = $fkComprasMapaItemDotacao->getCodConta();
        $this->codDespesa = $fkComprasMapaItemDotacao->getCodDespesa();
        $this->fkComprasMapaItemDotacao = $fkComprasMapaItemDotacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasMapaItemDotacao
     *
     * @return \Urbem\CoreBundle\Entity\Compras\MapaItemDotacao
     */
    public function getFkComprasMapaItemDotacao()
    {
        return $this->fkComprasMapaItemDotacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasMapaSolicitacaoAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaSolicitacaoAnulacao $fkComprasMapaSolicitacaoAnulacao
     * @return MapaItemAnulacao
     */
    public function setFkComprasMapaSolicitacaoAnulacao(\Urbem\CoreBundle\Entity\Compras\MapaSolicitacaoAnulacao $fkComprasMapaSolicitacaoAnulacao)
    {
        $this->exercicio = $fkComprasMapaSolicitacaoAnulacao->getExercicio();
        $this->codMapa = $fkComprasMapaSolicitacaoAnulacao->getCodMapa();
        $this->exercicioSolicitacao = $fkComprasMapaSolicitacaoAnulacao->getExercicioSolicitacao();
        $this->codEntidade = $fkComprasMapaSolicitacaoAnulacao->getCodEntidade();
        $this->codSolicitacao = $fkComprasMapaSolicitacaoAnulacao->getCodSolicitacao();
        $this->timestamp = $fkComprasMapaSolicitacaoAnulacao->getTimestamp();
        $this->fkComprasMapaSolicitacaoAnulacao = $fkComprasMapaSolicitacaoAnulacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasMapaSolicitacaoAnulacao
     *
     * @return \Urbem\CoreBundle\Entity\Compras\MapaSolicitacaoAnulacao
     */
    public function getFkComprasMapaSolicitacaoAnulacao()
    {
        return $this->fkComprasMapaSolicitacaoAnulacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasMapaItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaItem $fkComprasMapaItem
     * @return MapaItemAnulacao
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
}
