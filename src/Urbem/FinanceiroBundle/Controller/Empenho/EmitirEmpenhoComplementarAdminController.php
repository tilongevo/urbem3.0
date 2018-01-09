<?php

namespace Urbem\FinanceiroBundle\Controller\Empenho;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class EmitirEmpenhoComplementarAdminController extends Controller
{
    public function getEmpenhoOriginalAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $current_user = $this->get('security.token_storage')->getToken()->getUser();
        
        $empenhoOriginal = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getEmpenhoOriginal(
            $request->request->get('codEntidade'),
            $current_user->getFkSwCgm()->getNumcgm(),
            $request->request->get('exercicio'),
            $request->request->get('codEmpenhoInicial'),
            $request->request->get('codEmpenhoFinal'),
            $request->request->get('periodoInicial'),
            $request->request->get('periodoFinal')
        );
        
        return new JsonResponse($empenhoOriginal);
    }
    
    public function getInformacaoEmpenhoOriginalAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $current_user = $this->get('security.token_storage')->getToken()->getUser();
        
        $informacaoEmpenhoOriginal = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getInformacaoEmpenhoOriginal(
            $request->request->get('codEmpenho'),
            $request->request->get('codEntidade'),
            $current_user->getFkSwCgm()->getNumcgm(),
            $request->request->get('exercicio')
        );
        
        return new JsonResponse($informacaoEmpenhoOriginal);
    }
}
