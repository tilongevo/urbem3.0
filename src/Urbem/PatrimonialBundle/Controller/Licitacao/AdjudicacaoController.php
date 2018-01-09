<?php

namespace Urbem\PatrimonialBundle\Controller\Licitacao;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\AdjudicacaoModel;

/**
 * Licitacao Licitacao controller.
 *
 */
class AdjudicacaoController extends ControllerCore\BaseController
{
    public function getItensAdjudicacaoAction(Request $request)
    {
        $codLicitacao = $request->get('cod_licitacao');
        $codModalidade = $request->get('cod_modalidade');
        $codEntidade = $request->get('cod_entidade');
        $exercicio = $request->get('exercicio');

        $mode = is_null($request->get('mode')) ? 'json' : 'table';

        $response = new Response();

        if (is_null($codLicitacao)) {
            return $response;
        }

        $entityManager = $this->getDoctrine()->getManager();

        $adjudicacaoModel = new AdjudicacaoModel($entityManager);

        $itens = $adjudicacaoModel->montaRecuperaItensComStatus($codLicitacao, $codModalidade, $codEntidade, $exercicio);

        if ($mode == 'table') {
            return $this->render('PatrimonialBundle::Licitacao/Adjudicacao/items.html.twig', [
                'itens' => $itens
            ]);
        }

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });

        $serializer = new Serializer([$normalizer], [$encoder]);
        $itens = $serializer->serialize($itens, 'json');

        $response->setContent($itens);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
