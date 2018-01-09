<?php

namespace Urbem\PatrimonialBundle\Controller\Patrimonio;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\InventarioModel;

use Urbem\CoreBundle\Entity\Patrimonio;

/**
 * Class InventarioHistoricoBemAdminController
 * @package Urbem\PatrimonialBundle\Controller\Patrimonio
 */
class InventarioHistoricoBemAdminController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function getItemInfoAction(Request $request)
    {
        $codBem = $request->get('codBem');

        $entityMnager = $this->getDoctrine()->getManager();

        $bemInfo = (new InventarioModel($entityMnager))->getBemHistoricoInfo($codBem);

        $dados['codOrgao'] = (string) $bemInfo->getFkOrganogramaOrgao();
        $dados['codLocal'] = (string) $bemInfo->getFkOrganogramaLocal();

        $response = new Response();
        $response->setContent(json_encode($dados));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getItemInventarioHistoricoBemAction(Request $request)
    {
        $codBem = $request->get('codBem');
        $exercicio = $request->get('exercicio');
        $idInventario = $request->get('idInventario');

        $entityMnager = $this->getDoctrine()->getManager();

        $bemInfo = (new InventarioModel($entityMnager))->getIventarioHistoricoBemInfo($codBem, $exercicio, $idInventario);

        $dados['codOrgao'] = (string) $bemInfo->getFkOrganogramaOrgao();
        $dados['codLocal'] = (string) $bemInfo->getFkOrganogramaLocal();

        $response = new Response();
        $response->setContent(json_encode($dados));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
