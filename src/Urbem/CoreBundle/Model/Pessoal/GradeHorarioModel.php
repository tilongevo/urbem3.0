<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model\InterfaceModel;

class GradeHorarioModel extends AbstractModel implements InterfaceModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\\GradeHorario");
    }

    public function canRemove($object)
    {
        $contratoServidorRepository = $this->entityManager->getRepository("CoreBundle:Pessoal\\ContratoServidor");

        return  empty($contratoServidorRepository->findOneByCodGrade($object->getCodGrade()));
    }
}
