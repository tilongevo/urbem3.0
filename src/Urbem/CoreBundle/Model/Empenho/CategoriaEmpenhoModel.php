<?php

namespace Urbem\CoreBundle\Model\Empenho;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Empenho\Historico;
use Urbem\CoreBundle\Model;

class CategoriaEmpenhoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Empenho\CategoriaEmpenho");
    }

    public function getOneByCodCategoria($codCategoria)
    {
        return $this->entityManager->getRepository("CoreBundle:Empenho\CategoriaEmpenho")
            ->findOneBy([
                    'codCategoria' => $codCategoria
               ]);
    }
}
