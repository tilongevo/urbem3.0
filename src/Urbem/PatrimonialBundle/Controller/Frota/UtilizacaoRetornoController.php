<?php
namespace Urbem\PatrimonialBundle\Controller\Frota;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UtilizacaoRetornoAdminController extends Controller
{
    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);
    }

    public function consultarUtilizacaoAction(Request $request)
    {
        $codUtilizacao = $request->attributes->get('id');

        $utilizacao = $this->getDoctrine()
            ->getRepository('CoreBundle:Frota\Utilizacao')
            ->find($codUtilizacao);

        $return = [];

        $arUtilizacao['dtSaida'] = $utilizacao->getDtSaida();
        $arUtilizacao['hrSaida'] = $utilizacao->getHrSaida();
        $arUtilizacao['kmSaida'] = $utilizacao->getKmSaida();
        $arUtilizacao['destino'] = $utilizacao->getDestino();
        $arUtilizacao['cgmMotorista'] = $utilizacao->getCgmMotorista()->getCgmMotorista()->getNumcgm();

        $response = new Response();
        $response->setContent(json_encode($arUtilizacao));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
