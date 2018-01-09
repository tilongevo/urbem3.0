<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\SwBairro;
use Urbem\CoreBundle\Entity\SwLogradouro;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Repository\SwBairroRepository;

/**
 * Class SwBairroModel
 *
 * @package Urbem\CoreBundle\Model
 */
class SwBairroModel extends AbstractModel
{
    /**
     * @var SwBairroRepository
     */
    protected $repository;

    /**
     * SwBairroModel constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(SwBairro::class);
    }

    /**
     * @param SwBairro $swBairro
     *
     * @return bool
     */
    public function canRemove(SwBairro $swBairro)
    {
        return $this->canRemoveWithAssociation($swBairro, [
            'fkSwMunicipio'
        ]);
    }

    /**
     * @param SwMunicipio $swMunicipio
     *
     * @return int
     */
    public function nextVal(SwMunicipio $swMunicipio)
    {
        return $this->repository->nextVal('cod_bairro', [
            'cod_uf'        => $swMunicipio->getCodUf(),
            'cod_municipio' => $swMunicipio->getCodMunicipio()
        ]);
    }

    /**
     * @param SwLogradouro $swLogradouro
     *
     * @return array
     */
    public function getBairrosBySwLogradouroForChoiceField(SwLogradouro $swLogradouro)
    {
        $queryBuilder = $this->repository
            ->createQueryBuilder('b')
            ->join('b.fkSwBairroLogradouros', 'bl')
            ->where('bl.codLogradouro = :codLogradouro')
            ->setParameter('codLogradouro', $swLogradouro->getCodLogradouro());

        $choices = [];

        /** @var SwBairro $swBairro */
        foreach ($queryBuilder->getQuery()->getResult() as $swBairro) {
            $choices[$swBairro->getNomBairro()] = $this->getObjectIdentifier($swBairro);
        }

        return $choices;
    }

    /**
     * @param $params
     * @return array
     */
    public function filtraBairro($params)
    {
        return $this->repository->filtraBairro($params);
    }
}
