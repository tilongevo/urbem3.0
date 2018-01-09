<?php

namespace Urbem\CoreBundle\Model\Pessoal\Assentamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;

class MovSefipRetornoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\\MovSefipRetorno");
    }

    public function insere($info)
    {
        $this->repository->insere($info);
    }

    public function consulta($codigo, $delete = false)
    {
        return $this->repository->consulta($codigo, $delete);
    }

    public function deleteMovSefipRetorno($codigo)
    {
        return $this->repository->deleteMovSefipRetorno($codigo);
    }
}
