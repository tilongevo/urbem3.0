<?php

namespace Urbem\RecursosHumanosBundle\Controller\Pessoal;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller\BaseController;

use Urbem\CoreBundle\Entity\Pessoal\Aposentadoria;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidor;
use Urbem\CoreBundle\Entity\Pessoal\Enquadramento;
use Urbem\CoreBundle\Model\Pessoal\AposentadoriaModel;

/**
 * Pessoal\Aposentadoria controller.
 *
 */
class AposentadoriaController extends BaseController
{
    public function findEnquadramentoAction(Request $request)
    {
        $classificacaoId = $request->query->get('codEnquadramento');

        if (empty($classificacaoId)) {
            return new Response();
        }

        $em = $this->getDoctrine()->getManager();

        $enquadramentoClassificacao = new AposentadoriaModel($em);
        $classificacao = $enquadramentoClassificacao->getEnquadramentosCodClassificacao($classificacaoId);

        $enquadramentoCollection = array();

        foreach ($classificacao as $enquadramento) {
            array_push($enquadramentoCollection, array(
                'cod_enquadramento' => $enquadramento->cod_enquadramento,
                'descricao' => $enquadramento->descricao,
                'reajuste' => $enquadramento->reajuste,
            ));
        }

        $response = new Response();
        $response->setContent(json_encode($enquadramentoCollection));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function findReajusteAction(Request $request)
    {
        $id = $request->get('id');
        $entityManager = $this->getDoctrine()->getManager();

        /** @var Enquadramento $getEnquadramento */
        $getEnquadramento = $entityManager->getRepository(Enquadramento::class)->findOneBy(["codEnquadramento" => $id]);
        $item = [];
        $item['reajuste'] = $getEnquadramento->getReajuste();

        return new JsonResponse(['item' => $item]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function findServidorAction(Request $request)
    {
        $find = $request->get('q');
        $entityManager = $this->getDoctrine()->getManager();

        $aposentadoriaModel = new AposentadoriaModel($entityManager);
        $getServidores = $aposentadoriaModel->getAposentadoriaValida($find);

        $servidores = [];

        foreach ($getServidores as $servidor) {
            array_push($servidores, ['id' => $servidor->cod_contrato . '~' . $servidor->timestamp, 'label' => $servidor->numcgm . ' - ' . $servidor->nom_cgm]);
        }
        $items = [
            'items' => $servidores
        ];

        return new JsonResponse($items);
    }
}
