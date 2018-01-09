<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository;
use Symfony\Component\Validator\Validator;
use Urbem\CoreBundle\AbstractModel as Model;

class SwCgmPessoaJuridicaModel extends Model implements InterfaceModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:SwCgmPessoaJuridica");
    }

    public function canRemove($object)
    {
    }

    public function getDisponiveis($id)
    {
        return $this->repository->getDisponiveis($id);
    }

    public function getNumCgmByNumCgm($numCgm)
    {
        return $this->repository->findOneByNumcgm($numCgm);
    }

    /**
     * @param string      $cnpj
     * @param string|null $exceptCnpj
     *
     * @return bool
     */
    public function checkIfCnpjAlreadyExists($cnpj, $exceptCnpj = null)
    {
        $queryBuilder = $this->repository->createQueryBuilder('pj');

        $queryBuilder
            ->where('pj.cnpj = :cnpj')
            ->setParameter('cnpj', $cnpj);

        if (!is_null($exceptCnpj)) {
            $queryBuilder
                ->andWhere('pj.cnpj <> :exceptCnpj')
                ->setParameter('exceptCnpj', $exceptCnpj);
        }

        $results = $queryBuilder->getQuery()->getResult(ORM\AbstractQuery::HYDRATE_SIMPLEOBJECT);

        return count($results) > 0;
    }

    public function findLikePessoaJuridicaQueryBuilder(array $columns, $q)
    {
        $queryBuilder = $this->repository->createQueryBuilder('pj');
        $queryBuilder->join(Entity\SwCgm::class, 'cgm', 'WITH', "pj.numcgm = cgm.numcgm");

        foreach ($columns as $key => $column) {
            $whereClause = $key == 0 ? "andWhere" : "orWhere" ;
            $queryBuilder->{$whereClause}("LOWER({$column}) LIKE LOWER(:q)");
        }

        $queryBuilder->setParameter("q", "%{$q}%");
        $queryBuilder->orderBy('cgm.nomCgm', 'ASC');

        return $queryBuilder;
    }

    /**
     * @param array $columns
     * @param string $q
     * @return array
     */
    public function findLike(array $columns, $q)
    {
        return $this->findLikePessoaJuridicaQueryBuilder($columns, $q)->getQuery()->getResult();
    }
}
