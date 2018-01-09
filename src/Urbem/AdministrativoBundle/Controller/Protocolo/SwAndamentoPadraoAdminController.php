<?php

namespace Urbem\AdministrativoBundle\Controller\Protocolo;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SwAndamentoPadraoAdminController extends Controller
{
    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);
    }

    public function consultarAssuntoAction(Request $request)
    {
        $codClassificacao = $request->request->get('codClassificacao');

        $assuntos = $this->getDoctrine()
            ->getRepository('CoreBundle:SwAssunto')
            ->findByCodClassificacao($codClassificacao, array('nomAssunto' => 'ASC'));

        $listAssuntos = array();
        foreach($assuntos as $assunto) {
            $listAssuntos[$assunto->getNomAssunto()] = $assunto->getCodAssunto();
        }

        $response = new Response();
        $response->setContent(json_encode($listAssuntos));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
