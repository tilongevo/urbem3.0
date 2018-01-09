<?php

namespace Urbem\CoreBundle\Model\Administracao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Biblioteca;
use Urbem\CoreBundle\Model;

class BibliotecaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    const MODULO_ARRECADACAO_FORMULA_DESONERACAO = 3;

    /**
     * BibliotecaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Biblioteca::class);
    }
}
