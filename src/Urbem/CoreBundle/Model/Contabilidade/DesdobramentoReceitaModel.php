<?php

namespace Urbem\CoreBundle\Model\Contabilidade;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;

class DesdobramentoReceitaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Contabilidade\\DesdobramentoReceita");
    }

    public function getAllDesdobramentosReceitas($exercicio)
    {
        return $this->repository->getAllDesdobramentosReceitas($exercicio);
    }
}
