<?php

namespace Urbem\CoreBundle\Model\Administracao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity\Administracao;

/**
 * Class UnidadeMedidaModel
 * @package Urbem\CoreBundle\Model\Administracao
 */
class UnidadeMedidaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * UnidadeMedidaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Administracao\UnidadeMedida::class);
    }

    /**
     * @param $codUnidade
     * @param $codGrandeza
     * @return null|object
     */
    public function getOneByCodUnidadeCodGrandeza($codUnidade, $codGrandeza)
    {
        return $this->repository->findOneBy([
            'codUnidade' => $codUnidade,
            'codGrandeza' => $codGrandeza
        ]);
    }

    /**
     * @return ORM\QueryBuilder
     */
    public function getUnidadesMedidas()
    {
        $queryBuilder = $this->repository->createQueryBuilder('unidadeMedida');
        $queryBuilder->where('unidadeMedida.codUnidade <> 0');

        return $queryBuilder;
    }
}
