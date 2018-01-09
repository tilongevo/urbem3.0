<?php

namespace Urbem\CoreBundle\Services\Orcamento;

use Doctrine\ORM\EntityManager;

use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Model\Orcamento\EntidadeModel;
use Urbem\CoreBundle\Services\SessionService;

/**
 * Class EntidadeService
 *
 * @package Urbem\CoreBundle\Services\Orcamento
 */
class EntidadeService
{
    /** @var EntityManager */
    private $entityManager;

    /** @var SessionService */
    private $sessionService;

    /** @var string|integer */
    private $exercicio;

    /**
     * EntidadeService constructor.
     *
     * @param EntityManager  $entityManager
     * @param SessionService $sessionService
     */
    public function __construct(EntityManager $entityManager, SessionService $sessionService)
    {
        $this->entityManager = $entityManager;
        $this->sessionService = $sessionService;

        $this->exercicio = $sessionService->getExercicio();
    }

    /**
     * @return int|string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * @return null|object|Entidade
     */
    public function getEntidade()
    {
        return (new EntidadeModel($this->entityManager))
            ->getEntidadePrefeitura($this->exercicio);
    }
}
