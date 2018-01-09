<?php

namespace Urbem\CoreBundle\Services;

use Doctrine\ORM\EntityManager;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

use Urbem\CoreBundle\Entity\Administracao\Rota;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Model\Administracao\GrupoPermissaoModel;

/**
 * Class RouteAccessService
 *
 * @package Urbem\CoreBundle\Services
 */
class RouteAccessService
{
    /** @var Usuario */
    protected $usuario;

    /** @var EntityManager */
    protected $entityManager;

    /** @var Request */
    protected $request;

    /**
     * RouteAccessService constructor.
     *
     * @param EntityManager $entityManager
     * @param TokenStorage  $tokenStorage
     */
    public function __construct(EntityManager $entityManager, TokenStorage $tokenStorage, RequestStack $requestStack)
    {
        $this->usuario = $tokenStorage->getToken()->getUser();
        $this->entityManager = $entityManager;

        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @return null|Rota
     */
    public function getCurrentRoute()
    {
        $rota = $this->entityManager->getRepository(Rota::class)->findOneBy([
            'descricaoRota' => $this->request->get('_route')
        ]);

        if (is_null($rota)) {
            throw new NotFoundHttpException;
        }

        return $rota;
    }

    /**
     * @return bool
     */
    public function checkAccess()
    {
        $rota = $this->getCurrentRoute();
        $grupoPermissaoModel = new GrupoPermissaoModel($this->entityManager);
        $hasAccess = $grupoPermissaoModel->hasAccessToRoute($this->usuario, $rota);

        if ($hasAccess == false) {
            throw new AccessDeniedHttpException;
        }

        return true;
    }
}
