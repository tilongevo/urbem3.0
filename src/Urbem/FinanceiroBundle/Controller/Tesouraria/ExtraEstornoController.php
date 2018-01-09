<?php

namespace Urbem\FinanceiroBundle\Controller\Tesouraria;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Tesouraria\VwTransferenciaView;
use Urbem\CoreBundle\Model\Tesouraria\TransferenciaModel;

class ExtraEstornoController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getPagamentoAction(Request $request)
    {
        $codBoletim = $request->get('codboletim');
        $dtBoletim = $request->get('dtboletim');
        $codReciboExtra = $request->get('recibo');
        $pagamentoItem = $this->getDoctrine()
            ->getRepository(VwTransferenciaView::class);
        $pagamento = $pagamentoItem->getPagamentobyCodRecibo($this->getExercicio(), $codBoletim, $dtBoletim, $codReciboExtra);
        return $this->returnJsonResponse($pagamento);
    }
}
