<?php

namespace Urbem\PatrimonialBundle\Controller\Frota;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Frota;
use Urbem\CoreBundle\Model\Patrimonial\Frota\ModeloModel;
use Urbem\CoreBundle\Model\Patrimonial\Frota\TipoVeiculoModel;
use Urbem\CoreBundle\Model\Patrimonial\Frota\VeiculoModel;

/**
 * Class VeiculoAdminController
 * @package Urbem\PatrimonialBundle\Controller\Frota
 */
class VeiculoAdminController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function consultarRestricoesTipoVeiculoAction(Request $request)
    {
        $tipoVeiculo = $request->attributes->get('id');

        $em = $this->getDoctrine()->getManager();
        $tipoVeiculoModel = new TipoVeiculoModel($em);

        $tipoVeiculoInfo = $tipoVeiculoModel->getTipoVeiculoInfo($tipoVeiculo);

        $dados = array();
        $dados['placa']                     = $tipoVeiculoInfo->getPlaca();
        $dados['codPrefixo']                = $tipoVeiculoInfo->getPrefixo();
        $dados['controlarHorasTrabalhadas'] = $tipoVeiculoInfo->getControlarHorasTrabalhadas();

        $response = new Response();
        $response->setContent(json_encode($dados));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultarMarcaModelosAction(Request $request)
    {
        $codMarca = $request->attributes->get('id');

        $em = $this->getDoctrine()->getManager();
        $modeloModel = new ModeloModel($em);

        $modelos = $modeloModel->findBy(['codMarca' => $codMarca]);

        $arrModelos = [];

        foreach ($modelos as $modelo) {
            $arrModelos[]= array('id'=>$modelo->getCodModelo(), 'label' => (string) $modelo);
        }

        $response = new Response();
        $response->setContent(json_encode($arrModelos));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultarVeiculoCombustiveisAction(Request $request)
    {
        $codVeiculo = $request->attributes->get('id');

        $em = $this->getDoctrine()->getManager();
        $veiculoModel = new VeiculoModel($em);

        /** @var Frota\Veiculo $veiculo */
        $veiculo = $veiculoModel->getVeiculo($codVeiculo);

        $arrCombustiveis = [];

        /** @var Frota\VeiculoCombustivel $combustivel */
        foreach ($veiculo->getFkFrotaVeiculoCombustiveis() as $combustivel) {
            /** @var Frota\CombustivelItem $combustivelItem */
            $item = $combustivel->getFkFrotaCombustivel()->getFkFrotaCombustivelItens()->last()->getFkFrotaItem();
            $arrCombustiveis[$veiculoModel->getObjectIdentifier($item)] =
                (string) $item;
        }

        $response = new Response();
        $response->setContent(json_encode($arrCombustiveis));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultarDadosVeiculoAction(Request $request)
    {
        $codVeiculo =$request->attributes->get('id');
        $em = $this->getDoctrine()->getManager();
        $veiculoModel = new VeiculoModel($em);

        $arrVeiculo = [];

        /** @var VeiculoModel $veiculo */
        $veiculo = $veiculoModel->getVeiculo($codVeiculo);

        $arrVeiculo['placa'] = $veiculo->getPlaca();
        $arrVeiculo['prefixo'] = $veiculo->getPrefixo();

        $response = new Response();
        $response->setContent(json_encode($arrVeiculo));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getKmAction(Request $request)
    {
        $codVeiculo = $request->attributes->get('id');
        $km = (new VeiculoModel($this->getDoctrine()->getManager()))->getKmById($codVeiculo);

        return new JsonResponse(['km' => $km]);
    }
}
