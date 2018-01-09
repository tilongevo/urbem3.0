<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;

class VinculoEmpregaticioModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\\VinculoEmpregaticio");
    }

    public function canRemove($object)
    {
        $codVinculo = $object->getCodVinculo();
        $contratoServidorRepository = $this->entityManager->getRepository("CoreBundle:Pessoal\\ContratoServidor");
        $data = $contratoServidorRepository->findOneByCodVinculo($codVinculo);
        return is_null($data);
    }
}
