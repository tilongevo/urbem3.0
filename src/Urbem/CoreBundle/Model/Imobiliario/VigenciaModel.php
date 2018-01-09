<?php

namespace Urbem\CoreBundle\Model\Imobiliario;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Imobiliario\Vigencia;

class VigenciaModel
{
    /**
     * @var ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var ORM\EntityRepository
     */
    protected $repository;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Vigencia::class);
    }

    /**
     * @param Vigencia $object
     * @return bool
     */
    public function canRemove($object)
    {
        return ($object->getFkImobiliarioNiveis()->count())
            ? false
            : true;
    }

    /**
     * @param Vigencia|null $object
     * @return \DateTime|null
     */
    public function lastDtVigencia($object = null)
    {
        $qb = $this->repository->createQueryBuilder('o');
        if ($object != null) {
            $qb->where('o.codVigencia != :codVigencia');
            $qb->setParameter('codVigencia', $object->getCodVigencia());
        }
        $qb->addOrderBy('o.codVigencia', 'DESC');
        $qb->setMaxResults(1);
        $result = $qb->getQuery()->getResult();

        return (count($result))
            ? $result[0]->getDtInicio()
            : null;
    }
}
