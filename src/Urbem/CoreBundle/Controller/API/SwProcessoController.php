<?php

namespace Urbem\CoreBundle\Controller\API;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Model\SwProcessoModel;

/**
* SwProcessoController.
*/
class SwProcessoController extends ControllerCore\BaseController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function findAssuntosByClassificacaoAction(Request $request)
    {
        $em = $this->getDoctrine();

        $codClassificacao = $request->get('codClassificacao');

        $assuntos = $em->getRepository(SwAssunto::class)->findBy(['codClassificacao' => $codClassificacao], ['codAssunto' => 'ASC']);
        $swProcessoModel = new SwProcessoModel($em->getEntityManager());

        $jsonResponse = [];

        /**
         * @var SwAssunto $assunto
         */
        foreach ($assuntos as $assunto) {
            $jsonResponse[] = [
                'codAssunto' => $swProcessoModel->getObjectIdentifier($assunto),
                'nomAssunto' => (string) $assunto
            ];
        }

        $assuntos = json_encode($jsonResponse);

        $response = new Response();
        $response->setContent($assuntos);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function findProcessoByAssuntosAndClassificacaoAction(Request $request)
    {
        $em = $this->getDoctrine();
        $swProcessoModel = new SwProcessoModel($em->getEntityManager());

        list($codAssunto, $codClassificacao) = explode('~', $request->get('codAssunto'));

        $processos = $em->getRepository(SwProcesso::class)->findBy(['codClassificacao' => $codClassificacao, 'codAssunto' => $codAssunto]);

        $jsonResponse = [];

        /**
         * @var SwProcesso $processo
         */
        foreach ($processos as $processo) {
            $jsonResponse[] = [
                'codProcesso' => $swProcessoModel->getObjectIdentifier($processo),
                'nomProcesso' => (string) $processo
            ];
        }
        $processos = json_encode($jsonResponse);

        $response = new Response();
        $response->setContent($processos);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
