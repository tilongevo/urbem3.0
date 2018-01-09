<?php
namespace Urbem\CoreBundle\Model\Beneficio;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Pessoal;

class ConcessaoValeTransporteModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(
            'CoreBundle:Beneficio\ConcessaoValeTransporte'
        );
    }

    public function findOneByCodConcessao($codConcessao)
    {
        return $this->repository->findOneByCodConcessao($codConcessao);
    }
}
