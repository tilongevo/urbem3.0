<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Empenho;

class MapaCotacaoModel
{
    private $entityManager = null;
    protected $repository = null;

    /**
     * MapaCotacaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Compras\MapaCotacao::class);
    }

    /**
     * @param $exercicio
     * @return ORM\QueryBuilder
     */
    public function getMapasIndisponiveis($exercicio)
    {
        // Item Pre Empenho Julgamento
        $itemPreEmpenhoJulgamentoQB = $this->entityManager->createQueryBuilder();
        $itemPreEmpenhoJulgamentoQB
            ->select('(itemPreEmpenhoJulgamento.codCotacao)')
            ->from(Empenho\ItemPreEmpenhoJulgamento::class, 'itemPreEmpenhoJulgamento')
            ->where('itemPreEmpenhoJulgamento.exercicio = :exercicio')
            ->setParameter(':exercicio', $exercicio)
        ;

        // Julgamento Item
        $julgamentoItemQB = $this->entityManager->createQueryBuilder();
        $julgamentoItemQB
            ->select('(julgamentoItem.codCotacao)')
            ->from(Compras\JulgamentoItem::class, 'julgamentoItem')
            ->where($julgamentoItemQB->expr()->in('julgamentoItem.codCotacao', $itemPreEmpenhoJulgamentoQB->getDQL()))
            ->andWhere('julgamentoItem.exercicio = :exercicio')
            ->setParameter(':exercicio', $exercicio)
        ;

        // Julgamento Item
        $julgamentoQB = $this->entityManager->createQueryBuilder();
        $julgamentoQB
            ->select('(julgamento.codCotacao)')
            ->from(Compras\Julgamento::class, 'julgamento')
            ->where($julgamentoItemQB->expr()->in('julgamento.codCotacao', $julgamentoItemQB->getDQL()))
            ->andWhere('julgamento.exercicio = :exercicio')
            ->setParameter(':exercicio', $exercicio)
        ;

        // Mapa Cotação
        $mapaCotacaoQB = $this->repository->createQueryBuilder('mapaCotacao');
        $mapaCotacaoQB
            ->where($mapaCotacaoQB->expr()->in('mapaCotacao.codCotacao', $julgamentoQB->getDQL()))
            ->setParameter(':exercicio', $exercicio)
        ;

        return $mapaCotacaoQB;
    }

    /**
     * Retorna Mapas de Cotações com base na Compra Direta Enviada
     *
     * @param Compras\CompraDireta $compraDireta
     * @return ORM\QueryBuilder
     */
    public function getCotacaoWithCompraDireta(Compras\CompraDireta $compraDireta)
    {
        $queryBuilderCotacaoAnulada = $this->entityManager->createQueryBuilder();
        $queryBuilderCotacaoAnulada
            ->select('(cotacaoAnulada.codCotacao)')
            ->from(Compras\CotacaoAnulada::class, 'cotacaoAnulada')
            ->where('cotacaoAnulada.codCotacao = mapaCotacao.codCotacao')
            ->andWhere('cotacaoAnulada.exercicio = mapaCotacao.exercicioCotacao')
        ;

        $queryBuilder = $this->repository->createQueryBuilder('mapaCotacao');
        $queryBuilder
            ->select()
            ->join(
                Compras\Cotacao::class,
                'cotacao',
                'WITH',
                'cotacao.codCotacao = mapaCotacao.codCotacao AND cotacao.exercicio = mapaCotacao.exercicioCotacao'
            )
            ->where($queryBuilder->expr()->notIn('cotacao.codCotacao', $queryBuilderCotacaoAnulada->getDQL()))
            ->andWhere('mapaCotacao.codMapa = :mapa')
            ->andWhere('mapaCotacao.exercicioMapa = :exercicio')
            ->setParameters([
                'mapa' => $compraDireta->getCodMapa(),
                'exercicio' => $compraDireta->getExercicioMapa()
            ])
        ;

        return $queryBuilder;
    }

    /**
     * @param $codCotacao
     * @param $exercicioCotacao
     * @return null|object
     */
    public function getOneMapaCotacaoByCodCotacaoAndExercicioCotacao($codCotacao, $exercicioCotacao)
    {
        return $this->repository->findOneBy([
            'exercicioCotacao' => $exercicioCotacao,
            'codCotacao' => $codCotacao
        ]);
    }
}
