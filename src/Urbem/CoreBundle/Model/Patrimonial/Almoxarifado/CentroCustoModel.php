<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel as Model;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\CentroCustoRepository;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\PedidoTransferenciaItemRepository;

/**
 * Class CentroCustoModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class CentroCustoModel extends Model
{
    protected $entityManager = null;

    /** @var CentroCustoRepository $repository */
    protected $repository = null;

    /**
     * CentroCustoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(
            'CoreBundle:Almoxarifado\CentroCusto'
        );
    }

    /**
     * @param $entidade
     * @param $exercicio
     * @param $numCgm
     * @return array
     */
    public function getDotacaoByEntidade($entidade, $exercicio, $numCgm)
    {
        return $this->repository->getDotacaoByEntidade($entidade, $exercicio, $numCgm);
    }

    public function getCentroCustoLeftPermissao($numcgm)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $centrocusto = $qb
            ->select(['centro.codCentro,centro.descricao,centro.dtVigencia, ccp.responsavel'])
            ->from(Almoxarifado\CentroCusto::class, 'centro')
            ->leftJoin(Almoxarifado\CentroCustoPermissao::class, 'ccp', 'WITH', 'centro.codCentro = ccp.codCentro and ccp.numcgm = :numcgm')
            ->setParameter(':numcgm', $numcgm);

        return $centrocusto;
    }

    public function getCentroCustoByPermissionQuery(SwCgm $cgm, Orcamento\Entidade $entidade)
    {
        $results = $this->repository->getCentroCustoByUserPermission([
            'cod_entidade' => $entidade->getCodEntidade(),
            'numcgm' => $cgm->getNumcgm()
        ]);

        $ids = [];
        foreach ($results as $result) {
            $ids[] = $result['cod_centro'];
        }

        $queryBuilder = $this->repository->createQueryBuilder('centroCusto');
        $queryBuilder
            ->where(
                $queryBuilder->expr()->in('centroCusto.codCentro', $ids)
            )
        ;

        return $queryBuilder;
    }

    public function getCentroCustoByPermission(SwCgm $cgm, Orcamento\Entidade $entidade)
    {
        $query = $this->getCentroCustoByPermissionQuery($cgm, $entidade);

        return $query->getQuery()->getResult();
    }

    public function getCentroCustoByCodCentro($codCentro)
    {
        return $this->repository->findOneBy([
            'codCentro' => $codCentro
        ]);
    }

    /**
     * @param SwCgm $swCgm
     * @return ORM\QueryBuilder
     */
    public function findCentroCustoPermissaoByCgmQuery(SwCgm $swCgm)
    {
        $queryBuilder = $this->repository->createQueryBuilder('centroCusto');
        $queryBuilder
            ->join('centroCusto.fkAlmoxarifadoCentroCustoPermissoes', 'centroCustoPermissoes')
            ->where('centroCustoPermissoes.numcgm = :numcgm')
            ->setParameter('numcgm', $swCgm->getNumcgm())
        ;

        return $queryBuilder;
    }

    /**
     * @param SwCgm $swCgm
     * @return ORM\QueryBuilder
     */
    public function findCentroCustoByResponsavelQuery(SwCgm $swCgm)
    {
        $queryBuilder = $this->findCentroCustoPermissaoByCgmQuery($swCgm);
        $queryBuilder
            ->andWhere('centroCustoPermissoes.responsavel = true')
        ;

        return $queryBuilder;
    }

    /**
     * @param SwCgm $swCgm
     * @return array
     */
    public function findCentroCustoByResponsavel(SwCgm $swCgm)
    {
        return $this->findCentroCustoByResponsavelQuery($swCgm)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param SwCgm $swCgm
     * @return array
     */
    public function findCentroCustoPermissaoByCgm(SwCgm $swCgm)
    {
        return $this->findCentroCustoPermissaoByCgmQuery($swCgm)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $query
     * @return array|null
     */
    public function searchCentroCusto($query)
    {
        $queryBuilder = $this->repository->createQueryBuilder('centroCusto');
        $queryBuilder
            ->where(
                $queryBuilder->expr()->like(
                    $queryBuilder->expr()->lower('centroCusto.descricao'),
                    $queryBuilder->expr()->lower(':descricao')
                )
            )
            ->setParameter('descricao', "%{$query}%")
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param SwCgm         $cgm
     * @param CatalogoItem  $catalogoItem
     * @return ORM\QueryBuilder
     */
    public function getCentroCustoInLancamentoMaterial(SwCgm $cgm, CatalogoItem $catalogoItem)
    {
        /** @var PedidoTransferenciaItemRepository $pedidoTransferenciaItemRepository */
        $pedidoTransferenciaItemRepository =
            $this->entityManager->getRepository(Almoxarifado\PedidoTransferenciaItem::class);

        $results = $pedidoTransferenciaItemRepository
            ->getCentroCustoDestino($cgm->getNumcgm(), $catalogoItem->getCodItem());

        $codCentroArray = [];
        foreach ($results as $result) {
            $codCentroArray[] = $result['cod_centro'];
        }

        $codCentroArray = true == empty($codCentroArray) ? 0 : $codCentroArray ;

        $queryBuilder = $this->repository->createQueryBuilder('centro');
        $queryBuilder
            ->where(
                $queryBuilder->expr()->in('centro.codCentro', $codCentroArray)
            )
        ;

        return $queryBuilder;
    }
}
