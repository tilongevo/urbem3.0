<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;

class CategoriaModel
{
    private $entityManager = null;
    private $categoriaRepository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->categoriaRepository = $this->entityManager->getRepository("CoreBundle:Pessoal\\Categoria");
    }

    public function getCategoriaByCodCategoria($codCategoria)
    {
        $return = $this->categoriaRepository->findOneByCodCategoria($codCategoria);
        return $return;
    }

    public function getCategoriaByCodFgts($codFgts)
    {
        $return = $this->categoriaRepository->findByCodFgts($codFgts);
        return $return;
    }

    public function getAll()
    {
        $return = $this->categoriaRepository->findAll();
        return $return;
    }
}
