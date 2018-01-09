<?php

namespace Urbem\PrestacaoContasBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;

/**
 * Class TceAdminController
 * @package Urbem\PrestacaoContasBundle\Controller
 */
class TceAdminController extends CRUDController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function serviceAction(Request $request)
    {
        $strategy = $this->admin->loadStrategy();

        // Set Form in Strategy
        $formContent = $request->getMethod() == 'POST' ? $this->admin->getForm() : null;
        $formSonataContent = $request->getMethod() == 'POST' ? $this->admin->getFormPost() : null;

        /** @var $strategy ConfiguracaoAbstract */
        $strategy->setContentForm($formContent);
        $strategy->setFormSonata($formSonataContent);
        $strategy->setRequest($request);
        $strategy->setAdmin($this->admin);

        return new JsonResponse($strategy->buildServiceProvider($this->container->get('templating')));
    }
}
