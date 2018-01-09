<?php

namespace Urbem\CoreBundle\Model\Contabilidade;

use Doctrine\ORM;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository;
use Symfony\Component\Validator\Validator;

/**
 * Class PlanoAnaliticaModel
 * @package Urbem\CoreBundle\Model\Contabilidade
 */
class PlanoAnaliticaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    const TYPE_NATUREZA_SALDO_CREDITO = 'C';
    const TYPE_NATUREZA_SALDO_DEBITO = 'D';

    /**
     * PlanoAnaliticaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Contabilidade\\PlanoAnalitica");
    }

    /**
     * @param ProxyQuery|null $query
     * @param $nomConta
     * @return ProxyQuery
     */
    public function getPlanoAnaliticaPlanoConta(ProxyQuery $query = null, $nomConta)
    {
        $query
            ->join(
                'CoreBundle:Contabilidade\PlanoConta',
                'PC',
                'WITH',
                "{$query->getRootAliases()[0]}.codConta = PC.codConta 
                    AND {$query->getRootAliases()[0]}.exercicio = PC.exercicio"
            )
            ->where("PC.nomConta LIKE '%{$nomConta}%'")
        ;

        return $query;
    }

    public function listarSaldoContaAnalitica($exercicio)
    {
        return $this->repository->listarSaldoContaAnalitica($exercicio);
    }

    public function listarLoteImplantacao($params)
    {
        return $this->repository->listarLoteImplantacao($params);
    }

    /**
     * @param array $params['codPlano', 'exercicio']
     * @return null|Entity\Contabilidade\PlanoAnalitica
     */
    public function getPlanoAnalitica($params)
    {
        return $this->repository->findOneBy($params);
    }

    /**
     * @param $q
     * @param $codEstrutural
     * @return ORM\QueryBuilder
     */
    public function carregaPlanoAnaliticaQuery($q, $codEstrutural)
    {
        $queryBuilder = $this->repository->createQueryBuilder('planoAnalitica');
        $queryBuilder->join('planoAnalitica.fkContabilidadePlanoConta', 'planoConta');

        if (is_numeric($q)) {
            $queryBuilder->where(sprintf("planoAnalitica.codPlano = %s", $q));
        } else {
            $queryBuilder->add(
                'where',
                $queryBuilder->expr()->like(
                    $queryBuilder->expr()->lower('planoConta.nomConta'),
                    $queryBuilder->expr()->literal(sprintf('%%%s%%', $q))
                )
            );
        }
        if (0 < strlen($codEstrutural) && null != $codEstrutural) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('planoConta.codEstrutural', $queryBuilder->expr()->literal(sprintf('%%%s%%', $codEstrutural))));
        }

        return $queryBuilder;
    }

    /**
     * @param $q
     * @param $codEstrutural
     * @return ORM\QueryBuilder
     */
    public function montaRecuperaContaSintetica($q, $codEstrutural)
    {
        $queryBuilder = $this->entityManager->getRepository("CoreBundle:Contabilidade\\PlanoConta")->createQueryBuilder('planoConta');
        $queryBuilder->join('planoConta.fkContabilidadePlanoAnalitica', 'planoAnalitica');

        if (strpos($q, ".") === false) {
            $queryBuilder->add(
                'where',
                $queryBuilder->expr()->like(
                    $queryBuilder->expr()->lower('planoConta.nomConta'),
                    $queryBuilder->expr()->literal(sprintf('%%%s%%', $q))
                )
            );
        } else {
            $queryBuilder->add(
                'where',
                $queryBuilder->expr()->like(
                    $queryBuilder->expr()->lower('planoConta.codEstrutural'),
                    $queryBuilder->expr()->literal(sprintf('%%%s%%', $q))
                )
            );
        }
        if (0 < strlen($codEstrutural) && null != $codEstrutural) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('planoConta.codEstrutural', $queryBuilder->expr()->literal(sprintf('%%%s%%', $codEstrutural))));
        }

        return $queryBuilder;
    }
}
