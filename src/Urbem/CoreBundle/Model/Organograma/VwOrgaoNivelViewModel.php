<?php

namespace Urbem\CoreBundle\Model\Organograma;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Organograma\VwOrgaoNivelView;
use Urbem\CoreBundle\Entity\Organograma\Orgao;
use Urbem\CoreBundle\Repository\Organograma\VwOrgaoNivelViewRepository;

class VwOrgaoNivelViewModel extends AbstractModel
{
    /** @var VwOrgaoNivelViewRepository  */
    protected $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(VwOrgaoNivelView::class);
    }

    /**
     * @param Orgao $orgao
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getOrgaosNivelQuery(Orgao $orgao)
    {
        $queryBuilder = $this->repository->createQueryBuilder('o');

        $result = $this->repository->getArrayOrgaosInsideOrgao($orgao->getCodOrgao());

        $codigos = [];
        foreach ($result as $arrOrgaoNivel) {
            $codigos[] = $arrOrgaoNivel['cod_orgao'];
        }

        $codigos = empty($codigos) ? 0 : $codigos;

        $queryBuilder = $queryBuilder
            ->where($queryBuilder->expr()->in(
                'o.codOrgao',
                $codigos
            ))
        ;

        return $queryBuilder;
    }

    /**
     * @param Orgao $orgao
     *
     * @return array
     */
    public function getOrgaosNivel(Orgao $orgao)
    {
        return $this->getOrgaosNivelQuery($orgao)->getQuery()->getResult();
    }
}
