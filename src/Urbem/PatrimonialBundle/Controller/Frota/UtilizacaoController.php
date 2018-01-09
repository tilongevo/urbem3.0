<?php
namespace Urbem\PatrimonialBundle\Controller\Frota;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UtilizacaoAdminController extends Controller
{
    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);
    }

    public function consultarVeiculoAction(Request $request)
    {
        $codVeiculo = $request->attributes->get('id');

        $arVeiculo = [];

        $veiculo = $this->getDoctrine()
            ->getRepository('CoreBundle:Frota\UtilizacaoRetorno')
            ->findByCodVeiculo($codVeiculo);

        if(is_array($veiculo)) {
            krsort($veiculo);
            foreach ($veiculo as $value) {
                $arVeiculo['kmInicial'] = $value->getKmRetorno();
                break;
            }
        } else {
            $veiculo = $this->getDoctrine()
                ->getRepository('CoreBundle:Frota\Veiculo')
                ->find($codVeiculo);

                $arVeiculo['kmInicial'] = $veiculo->getKmInicial();
        }



        $response = new Response();
        $response->setContent(json_encode($arVeiculo));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
