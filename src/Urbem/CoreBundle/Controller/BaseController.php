<?php

namespace Urbem\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Helper;
use Urbem\CoreBundle\Model\Administracao\GrupoModel;

/**
 * Class BaseController
 *
 * @package Urbem\CoreBundle\Controller
 */
class BaseController extends Controller
{
    protected $user;
    protected $translator;
    protected $language;
    protected $db;
    protected $session;
    protected static $logger;
    protected $itensPerPage;
    protected $breadcrumb;
    protected $hasBreadcrumb = false;

    /**
     * @todo We shall get rid of all that crap in our BaseController as soon as possible
     *
     * @return void|Response
     */
    private function loadContainersAsProperties()
    {
        $this->translator = $this->get('translator');
        $this->session = $this->get('session');
        $this->router = $this->get('router');
        $this->itensPerPage = $this->getParameter('itens_per_page');
        $this->db = $this->get('doctrine')->getManager();
        $this->breadcrumb = $this->get("white_october_breadcrumbs");

        $entityManager = $this->get('doctrine.orm.entity_manager');

        $rotasIgnoradas = (new GrupoModel($entityManager))
            ->getRotasIgnoradas();

        if (in_array($this->getCurrentRouteName(), $rotasIgnoradas)) {
            return;
        }

        $authorizationChecker = $this->get('security.authorization_checker');

        if (!$authorizationChecker->isGranted("ROLE_SUPER_ADMIN")) {
            $this->get('urbem.route.access')->checkAccess();
        }

        return;
    }

    public function before()
    {
        $this->loadContainersAsProperties();
    }

    public function log($shortMessage, $data, $entity)
    {
        self::$logger->send($data, $shortMessage, $entity, $this->router);
    }

    protected function setBreadCrumb($param = [], $routeName = null)
    {
        if ($this->hasBreadcrumb) {
            return null;
        }

        $this->hasBreadcrumb = true;
        $breadcrumb = $this->breadcrumb;
        $router = $this->get("router");
        $routeName = (is_null($routeName) ?  $this->getCurrentRouteName() : $routeName);
        $entityManager =  $this->get('doctrine')->getManager();

        /**
         * Técnica paleativa para solução do problema do breadcrumb com collection
         */
        if ($routeName != 'sonata_admin_append_form_element') {
            return Helper\BreadCrumbsHelper::getBreadCrumb(
                $breadcrumb,
                $router,
                $routeName,
                $entityManager,
                $param
            );
        }
    }

    public function getCurrentRouteName()
    {
        $routeName = $this->container
            ->get('request_stack')
            ->getCurrentRequest();

        return $routeName->attributes->get('_route');
    }
    
    /**
     * retorna o ano digitado no momento do login
     * @return string
     */
    public function getExercicio()
    {
        return $this->get('urbem.session.service')->getExercicio();
    }

    protected function returnJsonResponse($arrayResponse, $statusCode = 200, $headers = [])
    {
        return new JsonResponse($arrayResponse, $statusCode, $headers);
    }

    /**
     * Retorna o usuario logado
     *
     * @return Usuario
     */
    public function getCurrentUser()
    {
        $container = $this->container;
        $currentUser = $container->get('security.token_storage')->getToken()->getUser();

        return $currentUser;
    }
}
