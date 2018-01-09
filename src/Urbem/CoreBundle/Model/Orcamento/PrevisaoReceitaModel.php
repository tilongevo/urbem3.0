<?php

namespace Urbem\CoreBundle\Model\Orcamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;

class PrevisaoReceitaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Orcamento\\PrevisaoReceita");
    }

    public function getPrevisaoReceita(array $codReceitas, $exercicio)
    {
        if (!count($codReceitas)) {
            return null;
        }

        return $this->repository->findPrevisaoReceita($codReceitas, $exercicio);
    }
}
