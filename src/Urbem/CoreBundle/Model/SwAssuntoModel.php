<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;

class SwAssuntoModel extends AbstractModel implements InterfaceModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('CoreBundle:SwAssunto');
    }

    public function canRemove($object)
    {
        $processoRepository = $this->entityManager->getRepository("CoreBundle:SwProcesso");
        $result = $processoRepository->findOneByCodAssunto($object->getCodAssunto());

        return is_null($result);
    }

    public function getNextCodigo($codClassificacao)
    {
        $lastCode = $this->repository->findOneBy(
            ['codClassificacao' => $codClassificacao],
            ['codAssunto' => 'DESC']
        );

        if ($lastCode) {
            return $lastCode->getCodAssunto() + 1;
        }
        return 1;
    }

    public function findByCodClassificacao($codClassificacao)
    {
        return $this->repository->findBy([
            'codClassificacao' => $codClassificacao
        ]);
    }
}
