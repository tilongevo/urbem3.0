<?php

namespace Urbem\RecursosHumanosBundle\Controller\Pessoal;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model\Pessoal\Assentamento\AssentamentoAssentamentoModel;
use Urbem\CoreBundle\Model\Pessoal\Assentamento\AssentamentoGeradoContratoServidorModel;

class AssentamentoGeradoContratoServidorAdminController extends Controller
{
    /**
     * Retorna a lista de classificação de assentamento usando o codContrato (matrícula)
     * como parametro
     * @param  Request $request
     * @return Response
     */
    public function getClassificacaoAssentamentoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $codContrato = $request->request->get('codContrato');

        $classificacaoAssentamentoList = (new AssentamentoGeradoContratoServidorModel($em))
        ->getClassificacaoAssentamento($codContrato);

        $response = new Response();
        $response->setContent(json_encode($classificacaoAssentamentoList));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function getAssentamentoClassificacaoMatriculaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $codContrato = $request->request->get('codContrato');
        $codClassificacao = $request->request->get('codClassificacao');

        $assentamentoList = (new AssentamentoGeradoContratoServidorModel($em))
        ->getAssentamentoByClassificacaoMatricula($codContrato, $codClassificacao);

        $response = new Response();
        $response->setContent(json_encode($assentamentoList));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function getAssentamentoClassificacaoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $codClassificacao = $request->request->get('codClassificacao');

        $assentamentoList = (new AssentamentoGeradoContratoServidorModel($em))
        ->getAssentamentoByClassificacao($codClassificacao);

        $response = new Response();
        $response->setContent(json_encode($assentamentoList));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getAssentamentoByCodClassificacaoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $codClassificacao = $request->request->get('codClassificacao');

        $assentamentoList = (new AssentamentoAssentamentoModel($em))
            ->getAssentamentosByCodClassificacao($codClassificacao);

        $response = new Response();
        $response->setContent(json_encode($assentamentoList));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
