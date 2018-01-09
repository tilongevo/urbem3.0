<?php

namespace Urbem\TributarioBundle\Controller\Arrecadacao;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller\BaseController;

class CalendarioFiscalController extends BaseController
{
    /**
     * Home
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::Arrecadacao/CalendarioFiscal/home.html.twig');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getParcelasDescontoAction(Request $request)
    {
        $dataVencimentoParcelamento = $request->query->get('dataVencimentoParcelamento');
        $dataVencimentoDesconto = $request->query->get('dataVencimentoDesconto');
        $quantidadeParcelas = $request->query->get('quantidadeParcelas');

        $dataVencimentoParcelamento = \DateTime::createFromFormat('d/m/Y', $dataVencimentoParcelamento);
        $dataVencimentoDesconto = \DateTime::createFromFormat('d/m/Y', $dataVencimentoDesconto);

        $parcelas = array();

        $i = 1;
        $interval = new \DateInterval('P1D');
        $dataVencimentoParcelamento->add($interval);

        $parcelas[$i]['dataVencimentoParcelamento'] = $dataVencimentoParcelamento->format('d/m/Y');
        $parcelas[$i]['dataVencimentoDesconto'] = $dataVencimentoDesconto->format('d/m/Y');

        for ($i = 2; $i <= $quantidadeParcelas; $i++) {
            $interval = new \DateInterval('P30D');

            $dataVencimentoDesconto = $dataVencimentoDesconto->add($interval);
            $dataVencimentoParcelamento = $dataVencimentoParcelamento->add($interval);

            $parcelas[$i]['dataVencimentoParcelamento'] = $dataVencimentoParcelamento->format('d/m/Y');
            $parcelas[$i]['dataVencimentoDesconto'] = $dataVencimentoDesconto->format('d/m/Y');
        }

        $response = new Response();
        $response->setContent(json_encode($parcelas));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
