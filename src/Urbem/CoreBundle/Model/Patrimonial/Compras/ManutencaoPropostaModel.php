<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\Config\Definition\Exception\Exception;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Orcamento;

class ManutencaoPropostaModel
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
        $this->repository = $this->entityManager->getRepository(Compras\CompraDireta::class);
    }

    /**
     * Retorna a ProxyQuery com os itens da Manutenção de Propostas para listagem
     * @param ProxyQuery $proxyQuery
     * @param $exercicio
     * @return ProxyQuery
     */
    public function getManutencaoPropostaList(ProxyQuery $proxyQuery, $exercicio)
    {
        $queryCompraDiretaAnulacao = $this->entityManager->createQueryBuilder();
        $queryCompraDiretaAnulacao
            ->select('1')
            ->from(Compras\CompraDiretaAnulacao::class, 'cda')
            ->where('cda.codModalidade = o.codModalidade')
            ->andWhere('cda.exercicioEntidade = o.exercicioEntidade')
            ->andWhere('cda.codCompraDireta = o.codCompraDireta')
        ;

        $queryCotacaoAnulada = $this->entityManager->createQueryBuilder();
        $queryCotacaoAnulada
            ->select('1')
            ->from(Compras\CotacaoAnulada::class, 'ca')
            ->where('ca.codCotacao = mc.codCotacao')
            ->andWhere('ca.exercicio = mc.exercicioCotacao')
        ;

        $queryMapaCotacao = $this->entityManager->createQueryBuilder();
        $queryMapaCotacao
            ->select('1')
            ->from(Compras\MapaCotacao::class, 'mc')
            ->join(
                Compras\Julgamento::class,
                'julgamento',
                'WITH',
                'julgamento.exercicio = mc.exercicioCotacao AND ' .
                'julgamento.codCotacao = mc.codCotacao'
            )
            ->where('mc.codMapa = o.codMapa')
            ->andWhere('mc.exercicioMapa = o.exercicioMapa')
            ->andWhere($queryMapaCotacao->expr()->not($queryMapaCotacao->expr()->exists($queryCotacaoAnulada->getDQL())))
        ;

        $proxyQuery
            ->andWhere('o.exercicioEntidade = :exercicioEntidade')
            ->andWhere(
                $proxyQuery->expr()->not($proxyQuery->expr()->exists($queryCompraDiretaAnulacao->getDQL()))
            )
            ->andWhere(
                $proxyQuery->expr()->not($proxyQuery->expr()->exists($queryMapaCotacao->getDQL()))
            )
            ->setParameters([
                'exercicioEntidade' => $exercicio
            ])
        ;
        return $proxyQuery;
    }
}
