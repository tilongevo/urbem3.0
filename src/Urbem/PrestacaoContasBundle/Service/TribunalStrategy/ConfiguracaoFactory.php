<?php

namespace Urbem\PrestacaoContasBundle\Service\TribunalStrategy;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Services\SessionService;

/**
 * Class ConfiguracaoFactory
 * @package Urbem\PrestacaoContasBundle\Service\TribunalStrategy
 */
class ConfiguracaoFactory
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var \Urbem\CoreBundle\Services\SessionService
     */
    protected $session;

    /**
     * @var Usuario
     */
    protected $user;

    /**
     * StnFactory constructor.
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param \Urbem\CoreBundle\Services\SessionService $session
     */
    public function __construct(EntityManager $entityManager, SessionService $session, TokenStorage $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->session = $session;
        $this->user = $tokenStorage->getToken()->getUser();
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @return \Urbem\CoreBundle\Services\SessionService
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param $class
     * @return mixed
     * @throws \Exception
     */
    public function build($class)
    {
        try {
            $class = new $class($this);
        } catch (\Exception $e) {
            throw new \Exception(Error::CLASS_NOT_FOUND . "<br>{$class}<br>" . $e->getMessage());
        }

        return $class;
    }
}
