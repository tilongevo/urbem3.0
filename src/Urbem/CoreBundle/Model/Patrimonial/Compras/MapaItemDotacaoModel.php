<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao;
use Urbem\CoreBundle\Entity\Licitacao;
use Urbem\CoreBundle\Entity\Compras\MapaItem;
use Urbem\CoreBundle\AbstractModel;

/**
 * Class MapaItemDotacaoModel
 *
 * @package Urbem\CoreBundle\Model\Patrimonial\Compras
 */
class MapaItemDotacaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * MapaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Compras\MapaItemDotacao::class);
    }

    /**
     * @param $exercicio
     * @param $codMapa
     * @param $exercicioSolicitacao
     * @param $codEntidade
     * @param $codSolicitacao
     * @param $codCentro
     * @param $codItem
     * @param $lote
     * @param $codConta
     * @param $codDespesa
     *
     * @return null|object
     */
    public function getOneMapaItemDotacao($params)
    {
        return $this->repository->findOneBy([
            'exercicio' => $params->exercicio,
            'codMapa' => $params->cod_mapa,
            'exercicioSolicitacao' => $params->exercicio_solicitacao,
            'codEntidade' => $params->cod_entidade,
            'codSolicitacao' => $params->cod_solicitacao,
            'codCentro' => $params->cod_centro,
            'codItem' => $params->cod_item,
            'lote' => $params->lote,
            'codConta' => $params->cod_conta,
            'codDespesa' => $params->cod_despesa
        ]);
    }

    /**
     * @param $codMapa
     * @param $exercicio
     * @return null|object
     */
    public function getOneMapaItemDotacaoByCodMapaAndExercicio($codMapa, $exercicio)
    {
        return $this->repository->findOneBy([
            'exercicio' => $exercicio,
            'codMapa' => $codMapa
        ]);
    }

    /**
     * @param MapaItem $mapaItem
     * @param SolicitacaoItemDotacao $solicitacaoItemDotacao
     * @param null|float $setQuantidade
     * @param null|float $setVlTotal
     * @return Compras\MapaItemDotacao
     */
    public function saveMapaItemDotacao(MapaItem $mapaItem, SolicitacaoItemDotacao $solicitacaoItemDotacao, $setQuantidade = null, $setVlTotal = null)
    {
        $mapaItemDotacao = $this->repository->findOneBy([
            'exercicio'            => $mapaItem->getExercicio(),
            'codMapa'              => $mapaItem->getCodMapa(),
            'exercicioSolicitacao' => $mapaItem->getExercicioSolicitacao(),
            'codEntidade'          => $mapaItem->getCodEntidade(),
            'codSolicitacao'       => $mapaItem->getCodSolicitacao(),
            'codCentro'            => $mapaItem->getCodCentro(),
            'codItem'              => $mapaItem->getCodItem(),
        ]);

        if (is_null($mapaItemDotacao)) {
            $mapaItemDotacao = new Compras\MapaItemDotacao();

            $mapaItemDotacao->setFkComprasMapaItem($mapaItem);
            $mapaItemDotacao->setFkComprasSolicitacaoItemDotacao($solicitacaoItemDotacao);
            $mapaItemDotacao->setQuantidade((!is_null($setQuantidade) ? $setQuantidade : $solicitacaoItemDotacao->getQuantidade()));
            $mapaItemDotacao->setVlDotacao((!is_null($setVlTotal) ? $setVlTotal: $solicitacaoItemDotacao->getVlReserva()));
        }

        return $mapaItemDotacao;
    }

    /**
     * @param Compras\MapaItemDotacao $mapaItemDotacao
     * @param                         $quantidade
     * @param                         $vlReserva
     *
     * @return null|object|Compras\MapaItemDotacao
     */
    public function updateMapaItemDotacao(Compras\MapaItemDotacao $mapaItemDotacao, $quantidade, $vlReserva)
    {
        $mapaItemDotacao->setQuantidade($quantidade);
        $mapaItemDotacao->setVlDotacao($vlReserva);

        $this->entityManager->persist($mapaItemDotacao);

        return $mapaItemDotacao;
    }
}
