<?php

namespace Urbem\CoreBundle\Model\Pessoal\Assentamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;

class MovSefipSaidaCategoriaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\\MovSefipSaidaCategoria");
    }

    public function consulta($codigo, $delete = false)
    {
        return $this->repository->consulta($codigo, $delete);
    }
}
