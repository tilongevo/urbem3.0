<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository;
use Symfony\Component\Validator\Validator;

class TipoAdmissaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\\TipoAdmissao");
    }

    public function canRemove($object)
    {

        $codTipoAdmissao  = $object->getCodTipoAdmissao();

        $contratoServidorRepository = $this->entityManager->getRepository("CoreBundle:Pessoal\\ContratoServidor");
        $data = $contratoServidorRepository->findOneByCodTipoAdmissao($codTipoAdmissao);

        return is_null($data);
    }
}
