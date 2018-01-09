<?php

namespace Urbem\CoreBundle\Services\Administracao;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Services\SessionService;

/**
 * Class ConfiguracaoService
 * @package Urbem\CoreBundle\Services\Administracao
 */
class ConfiguracaoService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var SessionService
     */
    private $sessionService;

    /**
     * @var mixed
     */
    private $logoTipo;

    /**
     * ConfiguracaoService constructor.
     * @param EntityManager $entityManager
     * @param SessionService $sessionService
     */
    public function __construct(EntityManager $entityManager, SessionService $sessionService)
    {
        $this->entityManager = $entityManager;
        $this->sessionService = $sessionService;

        $this->logoTipo = $sessionService->getLogoTipo();
    }

    /**
     * @return mixed
     */
    public function getLogoTipo()
    {
        return $this->logoTipo;
    }
}
