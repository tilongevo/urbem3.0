<?php

namespace Urbem\CoreBundle\Model\Calendario;

use Doctrine\ORM;

class CalendarioCadastroModel
{

    private $entityManager = null;

    /**
     * CalendarioCadastroModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Calendario\\CalendarioCadastro");
    }
}
