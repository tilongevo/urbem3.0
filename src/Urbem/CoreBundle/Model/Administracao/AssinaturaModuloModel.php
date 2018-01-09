<?php

namespace Urbem\CoreBundle\Model\Administracao;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;

use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\AssinaturaModulo;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Model\InterfaceModel;
use Urbem\CoreBundle\Repository\Administracao\AssinaturaModuloRepository;

/**
 * Class AssinaturaModuloModel
 *
 * @package Urbem\CoreBundle\Model\Administracao
 */
class AssinaturaModuloModel extends AbstractModel implements InterfaceModel
{
    /** @var AssinaturaModuloRepository */
    protected $repository;

    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(AssinaturaModulo::class);
    }

    /**
     * {@inheritdoc}
     */
    public function canRemove($object)
    {
        return true;
    }

    /**
     * @param Entidade $entidade
     * @param Modulo   $modulo
     * @param          $exercicio
     *
     * @return array
     */
    public function getAssinaturasByEntidadeModulo(Entidade $entidade, Modulo $modulo, $exercicio)
    {
        $queryResult = $this->repository
            ->getAssinaturasPorModulo($modulo->getCodModulo(), $exercicio, $entidade->getCodEntidade());

        $timestamps = [];
        foreach ($queryResult as $item) {
            $timestamps[] = $item['timestamp'];
        }

        if (empty($timestamps)) {
            return [];
        }

        $queryBuilder = $this->repository->createQueryBuilder('am');
        $queryBuilder = $queryBuilder
            ->where($queryBuilder->expr()->in('am.timestamp', $timestamps))
            ->andWhere('am.codEntidade = :codEntidade')
            ->andWhere('am.codModulo = :codModulo')
            ->andWhere('am.exercicio = :exercicio')
            ->setParameters([
                'codEntidade' => $entidade->getCodEntidade(),
                'codModulo'   => $modulo->getCodModulo(),
                'exercicio'   => $exercicio
            ])
        ;

        return $queryBuilder->getQuery()->getResult();
    }
}
