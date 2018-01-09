<?php

namespace Urbem\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller as ControllerCore;

/**
 * Licitacao Licitacao controller.
 *
 */
class AbstractSonataController extends ControllerCore\BaseController
{
    /**
     * Home Comissao Licitacao
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function erroAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        $host = $request->headers->get('host');
        $url = explode($host, $request->headers->get('referer'));

        // match route
        $routeParams = $this->get('router')->match($url[1]);

        $rotaExiste = (new \Urbem\CoreBundle\Model\Administracao\GrupoModel($entityManager))
            ->checkRotaExiste($routeParams);

        $this->setBreadCrumb([], $rotaExiste->getDescricaoRota());
        return $this->render('CoreBundle::Home/ErrorId0.html.twig', []);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function erroConfiguracaoAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $host = $request->headers->get('host');
        $url = explode($host, $request->headers->get('referer'));

        // match route
        $routeParams = $this->get('router')->match($url[1]);

        $rotaExiste = (new \Urbem\CoreBundle\Model\Administracao\GrupoModel($entityManager))
            ->checkRotaExiste($routeParams);

        $this->setBreadCrumb([], $rotaExiste->getDescricaoRota());
        return $this->render('CoreBundle::Home/ErrorConfiguracao.html.twig', []);
    }
}
