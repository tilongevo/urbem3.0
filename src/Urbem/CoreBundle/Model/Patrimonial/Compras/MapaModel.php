<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Licitacao;
use Urbem\CoreBundle\Repository\Patrimonio\Compras\MapaRepository;

/**
 * Class MapaModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Compras
 */
class MapaModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var MapaRepository|null */
    protected $repository = null;

    private $mapaItemModel;

    /**
     * MapaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Compras\Mapa::class);
        $this->mapaItemModel = new MapaItemModel($this->entityManager);
    }

    /**
     * @param $exercicio
     * @return mixed
     */
    public function getProximoCodMapa($exercicio)
    {
        return $this->repository->getProximoCodMapa($exercicio);
    }

    /**
     * @param $exercicio
     * @return ORM\QueryBuilder
     */
    public function getMapasDisponiveis($exercicio)
    {
        // Conta Direta
        $contaDiretaQueryBuilder = $this->entityManager->createQueryBuilder();
        $contaDiretaQueryBuilder
            ->select('CompraDireta.codMapa')
            ->from(Compras\CompraDireta::class, 'CompraDireta')
            ->where('CompraDireta.exercicioMapa = :exercicio');

        // Licitacao
        $licitacaoQueryBuilder = $this->entityManager->createQueryBuilder();
        $licitacaoQueryBuilder
            ->select('(Licitacao.codMapa)')
            ->from(Licitacao\Licitacao::class, 'Licitacao')
            ->where('Licitacao.exercicio = :exercicio');


        // Mapa Item AnulaÃ§Ã£o
        $mapaItemAnulacaoQueryBuilder = $this->entityManager->createQueryBuilder();
        $mapaItemAnulacaoQueryBuilder
            ->select('(MapaItemAnulacao.codMapa)')
            ->from(Compras\MapaItemAnulacao::class, 'MapaItemAnulacao')
            ->where('MapaItemAnulacao.exercicio = :exercicio');

        // Mapa Solicitacao Anulacao
        $mapaSolicitacaoAnulacaoQueryBuilder = $this->entityManager->createQueryBuilder();
        $mapaSolicitacaoAnulacaoQueryBuilder
            ->select('(MapaSolicitacaoAnulacao.codMapa)')
            ->from(Compras\MapaSolicitacaoAnulacao::class, 'MapaSolicitacaoAnulacao')
            ->where('MapaSolicitacaoAnulacao.exercicio = :exercicio');

        // Mapa Cotacao
        $mapaCotacaoModel = new MapaCotacaoModel($this->entityManager);
        $mapaCotacaoQB = $mapaCotacaoModel->getMapasIndisponiveis($exercicio);

        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('Mapa')
            ->from('CoreBundle:Compras\Mapa', 'Mapa')
            ->where('Mapa.exercicio = :exercicio')
            ->andWhere($queryBuilder->expr()->notIn('Mapa.codMapa', $contaDiretaQueryBuilder->getDQL()))
            ->andWhere($queryBuilder->expr()->notIn('Mapa.codMapa', $licitacaoQueryBuilder->getDQL()))
            ->andWhere($queryBuilder->expr()->notIn('Mapa.codMapa', $mapaItemAnulacaoQueryBuilder->getDQL()))
            ->andWhere($queryBuilder->expr()->notIn('Mapa.codMapa', $mapaSolicitacaoAnulacaoQueryBuilder->getDQL()))
            ->andWhere($queryBuilder->expr()->notIn('Mapa.codMapa', $mapaCotacaoQB->select('(mapaCotacao.codMapa)')->getDQL()))
            ->setParameter(':exercicio', $exercicio);

        return $queryBuilder;
    }

    /**
     * @param $exercicio
     * @return array
     */
    public function getMapasDisponiveisArray($exercicio)
    {
        return $this->repository->getMapasDisponiveisArray($exercicio);
    }

    /**
     * @param $codMapa
     * @return array
     */
    public function montaRecuperaMapaSolicitacoes($codMapa)
    {
        return $this->repository->montaRecuperaMapaSolicitacoes($codMapa);
    }

    /**
     * @param $codMapa
     * @param $exercicio
     * @return mixed
     */
    public function recuperaMapasAnulacao($codMapa, $exercicio)
    {
        return $this->repository->recuperaMapasAnulacao($codMapa, $exercicio);
    }

    /**
     * @param $cod_solicitacao
     * @param $exercicio
     * @param $cod_entidade
     * @return array
     */
    public function montaRecuperaValoresTotaisSolicitacao($cod_solicitacao, $exercicio, $cod_entidade)
    {
        return $this->repository->montaRecuperaValoresTotaisSolicitacao($cod_solicitacao, $exercicio, $cod_entidade);
    }

    /**
     * @param $cod_solicitacao
     * @param $cod_entidade
     * @param $exercicio
     * @param $cod_mapa
     * @return array
     */
    public function montaRecuperaMapaItemReserva($cod_solicitacao, $cod_entidade, $exercicio, $cod_mapa)
    {
        return $this->repository->montaRecuperaMapaItemReserva($cod_solicitacao, $cod_entidade, $exercicio, $cod_mapa);
    }

    /**
     * @param Compras\Mapa $mapa
     * @return Compras\Mapa
     */
    public function montaValorReferenciaItensMapa(Compras\Mapa $mapa)
    {

        /** @var Compras\MapaItem $item */
        foreach ($this->mapaItemModel->getMapaItem($mapa->getCodMapa(), $mapa->getExercicio()) as $item) {
            $item = $this->mapaItemModel->montaValorReferencia($item);
        }

        return $mapa;
    }

    /**
     * @param Compras\Mapa $mapa
     * @return Compras\Mapa
     */
    public function montaValorUltimaCompraItensMapa(Compras\Mapa $mapa)
    {
        $mapaItemModel = new MapaItemModel($this->entityManager);

        /** @var Compras\MapaItem $item */
        foreach ($this->getMapaItem($mapa) as $item) {
            $item = $mapaItemModel->montaValorUltimaCompra($item);
        }

        return $mapa;
    }

    /**
     * @param Compras\Mapa $mapa
     * @return Compras\Mapa
     */
    public function montaCotacaoItemReference(Compras\Mapa $mapa)
    {
        $mapaItemModel = new MapaItemModel($this->entityManager);
        $cotacao = $mapa->getFkComprasMapaCotacoes()->first()->getFkComprasCotacao();

        /** @var Compras\MapaItem $item */
        foreach ($this->getMapaItem($mapa) as $item) {
            $mapaItemModel->montaCotacaoItemReference($item, $cotacao);
        }

        return $mapa;
    }

    public function getMapaItem(Compras\Mapa $mapa)
    {
        return $this->entityManager
            ->getRepository('CoreBundle:Compras\MapaItem')
            ->createQueryBuilder('mi')
            ->orWhere('mi.codMapa = ?0')
            ->orWhere('mi.exercicio = ?1')
            ->setParameters([$mapa->getCodMapa(), $mapa->getExercicio()])
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $codMapa
     * @param $exercicio
     * @return null|object
     */
    public function getOneMapa($codMapa, $exercicio)
    {
        return $this->repository->findOneBy([
            'codMapa' => $codMapa,
            'exercicio' => $exercicio,
        ]);
    }

    /**
     * @param $exercicio
     * @return array
     */
    public function recuperMapaDisponiveisCompraDireta($exercicio)
    {
        return $this->repository->recuperMapaDisponiveisCompraDireta($exercicio);
    }
}
