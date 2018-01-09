<?php

namespace Urbem\CoreBundle\Model\Administracao;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Rota;
use Urbem\CoreBundle\Entity\Administracao\Grupo;

/**
 * Class RotaModel
 *
 * @package Urbem\CoreBundle\Model\Administracao
 */
class RotaModel extends AbstractModel
{
    /** @var EntityRepository $repository */
    protected $repository = null;

    public function __construct(EntityManager $entityManager = null)
    {
        if (! $entityManager) {
            global $kernel;
            if ('AppCache' == get_class($kernel)) {
                $kernel = $kernel->getKernel();
            }

            $entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        }
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Administracao\Rota");
    }

    /**
     * @param Rota $routerEntity
     * @param array $rota
     * @return array
     */
    public function recursiveRoute($routerEntity, $rota = [])
    {
        if ($routerEntity->getDescricaoRota() == $routerEntity->getRotaSuperior()) {
            //TODO adicionar classe Rota\Exception
            throw new \Exception(
                "Rota {$routerEntity->getDescricaoRota()} possui ela mesma cadastrada como superior"
            );
        }
        //TODO seria melhor um array_unshift() pra ficar mais clara a intenção?
        //array_unshift($rota, [$routerEntity->getDescricaoRota() => $routerEntity->getTraducaoRota()]);
        $rota = [$routerEntity->getDescricaoRota() => $routerEntity->getTraducaoRota()] + $rota;
        $rotaEntityRecursive = $this->repository->findByDescricaoRota($routerEntity->getRotaSuperior());

        foreach ($rotaEntityRecursive as $rotaEntityRecursiveKet => $rotaEntityRecursiveValue) {
            $rota = $this->recursiveRoute($rotaEntityRecursiveValue, $rota);
        }

        return $rota;
    }

    public function getRouteByRouter($router)
    {
        $router = $this->repository->findOneByDescricaoRota($router);

        $router_list = array();

        if ($router) {
            $router_list[$router->getDescricaoRota()] = $this->recursiveRoute($router);
            return $router_list;
        } else {
            return null;
        }
    }

    public function getRouteByRouterAction($router)
    {
        $router = $this->repository->findOneByDescricaoRota($router);

        $router_list = array();

        if ($router) {
            $router_list[$router->getCodRota()] = $this->recursiveRouteAction($router);
            return $router_list;
        } else {
            return null;
        }
    }

    /**
     * @param Rota|null $rota
     * @return mixed
     */
    public function getChildren(Rota $rota = null)
    {
        $rotaSuperior = is_null($rota) ?: $rota->getDescricaoRota();

        $queryBuilder = $this->repository
            ->createQueryBuilder('rota')
            ->where('rota.rotaSuperior = :rota_superior')
            ->setParameter('rota_superior', $rotaSuperior)
            ->orderBy('rota.traducaoRota')
            ->getQuery()
        ;

        return $queryBuilder->getResult();
    }

    /**
     * @param Rota $rota
     * @return bool
     */
    public function hasChildren(Rota $rota)
    {
        $queryBuilder = $this->repository->createQueryBuilder('rota');
        $queryBuilder = $queryBuilder
            ->select(
                $queryBuilder->expr()->count('rota')
            )
            ->where('rota.rotaSuperior = :rota_superior')
            ->setParameter('rota_superior', $rota->getDescricaoRota())
            ->getQuery()
        ;

        return $queryBuilder->getSingleScalarResult() > 0;
    }

    /**
     * Retorna objeto QueryBuilder com a pesquisa basica de permissões.
     *
     * @param Grupo $grupo
     *
     * @return QueryBuilder
     */
    private function getPermissionsByGrupoBaseQuery(Grupo $grupo)
    {
        $queryBuilder = $this->repository->createQueryBuilder('rota');
        $queryBuilder = $queryBuilder
            ->join('rota.fkAdministracaoGrupoPermissoes', 'fkAdministracaoGrupoPermissoes')
            ->where('fkAdministracaoGrupoPermissoes.codGrupo = :cod_grupo')
            ->setParameter('cod_grupo', $grupo->getCodGrupo());

        return $queryBuilder;
    }

    /**
     * Retorna true/false para o grupo que tem permissão sobre a rota.
     *
     * @param Grupo $grupo
     * @param Rota  $rota
     *
     * @return bool
     */
    public function hasPermissionByGrupo(Grupo $grupo, Rota $rota)
    {
        $queryBuilder = $this->getPermissionsByGrupoBaseQuery($grupo);
        $rootAlias = $queryBuilder->getRootAlias();

        $queryBuilder = $queryBuilder
            ->select($queryBuilder->expr()->count($rootAlias))
            ->andWhere("{$rootAlias}.codRota = :cod_rota")
            ->setParameter("cod_rota", $rota->getCodRota())
            ->getQuery()
        ;

        return $queryBuilder->getSingleScalarResult() > 0;
    }

    /**
     * Retorna todas as permissões de rota por grupo.
     *
     * @param Grupo $grupo
     *
     * @return ArrayCollection
     */
    public function getPermissionsByGrupo(Grupo $grupo)
    {
        $queryBuilder = $this->getPermissionsByGrupoBaseQuery($grupo);

        $result = $queryBuilder->getQuery()->getResult();

        return new ArrayCollection($result);
    }

    /**
     * Retorna rotas ignoradas.
     *
     * @return array
     */
    public function getRotasIgnoradas()
    {
        $queryBuilder = $this->repository->createQueryBuilder('r');

        $queryBuilder
            ->select('r.descricaoRota')
            ->where('r.rotaSuperior IS NULL')
        ;

        return array_column($queryBuilder->getQuery()->getScalarResult(), "descricaoRota");
    }

    public function recursiveRouteAction($routerEntity, $rota = array())
    {
        if (! is_null($routerEntity->getRotaSuperior())) {
            $rota = array($routerEntity->getDescricaoRota() => $routerEntity->getTraducaoRota()) + $rota;
            $rotaEntityRecursive = $this->repository->findByDescricaoRota($routerEntity->getRotaSuperior());

            foreach ($rotaEntityRecursive as $rotaEntityRecursiveKet => $rotaEntityRecursiveValue) {
                $rota = $this->recursiveRouteAction($rotaEntityRecursiveValue, $rota);
            }
        }

        return $query->getResult();
    }

    /**
     * @param $rotaSuperior
     *
     * @return Rota
     */
    public function findByRotaSuperior($rotaSuperior)
    {
        return $this->repository->findByRotaSuperior($rotaSuperior);
    }
}
