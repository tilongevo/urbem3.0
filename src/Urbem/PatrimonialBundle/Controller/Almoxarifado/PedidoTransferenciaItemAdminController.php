<?php
namespace Urbem\PatrimonialBundle\Controller\Almoxarifado;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\RequisicaoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\PedidoTransferenciaItemModel;

/**
 * Class PedidoTransferenciaItemAdminController
 * @package Urbem\PatrimonialBundle\Controller\Almoxarifado
 */
class PedidoTransferenciaItemAdminController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function getCentroCustoDestinoAction(Request $request)
    {
        $codItem = $_GET['codItem'];
        $codAlmoxarifado = $_GET['codAlmoxarifado'];
        $numCgm = $_GET['numCgm'];

        $em = $this->getDoctrine()->getManager();

        $ptiModel = new PedidoTransferenciaItemModel($em);
        $ptItens = $ptiModel->getCentroCustoDestino($numCgm, $codItem, $codAlmoxarifado);

        $dados = array();
        foreach ($ptItens as $item) {
            $dados['cod_centro'][$item['cod_centro']] = $item['descricao'];
        }

        $response = new Response();
        $response->setContent(json_encode($dados));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
