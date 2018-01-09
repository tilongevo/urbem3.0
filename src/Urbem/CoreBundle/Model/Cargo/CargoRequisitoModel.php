<?php

namespace Urbem\CoreBundle\Model\Cargo;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel as Model;
use Urbem\CoreBundle\Entity\Pessoal;
use Urbem\CoreBundle\Repository;
use Symfony\Component\Validator\Validator;

class CargoRequisitoModel extends Model
{

    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Pessoal\CargoRequisito::class);
    }
}
