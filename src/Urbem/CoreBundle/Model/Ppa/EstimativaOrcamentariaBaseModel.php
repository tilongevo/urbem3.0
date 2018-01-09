<?php

namespace Urbem\CoreBundle\Model\Ppa;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository;
use Symfony\Component\Validator\Validator;

class EstimativaOrcamentariaBaseModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Ppa\\EstimativaOrcamentariaBase");
    }

    public function getEstimativaByCodPpa($codPpa)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('e', 'p')
           ->from('CoreBundle:Ppa\\EstimativaOrcamentariaBase', 'e')
           ->leftJoin(
               'CoreBundle:Ppa\\PpaEstimativaOrcamentariaBase',
               'p',
               'WITH',
               $qb->expr()->andX(
                   $qb->expr()->eq('e.codReceita', 'p.codReceita'),
                   $qb->expr()->eq('p.codPpa', ':codPpa')
               )
           )
           ->setParameter('codPpa', $codPpa)
           ->orderBy('e.codReceita', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
