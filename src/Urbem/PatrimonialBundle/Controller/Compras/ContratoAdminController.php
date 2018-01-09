<?php
namespace Urbem\PatrimonialBundle\Controller\Compras;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;

class ContratoAdminController extends Controller
{

    public function consultaDadosContratoAction(Request $request)
    {

        $numContrato = $request->attributes->get('id');

        $contrato = $this->getDoctrine()
            ->getRepository('CoreBundle:Licitacao\Contrato')
            ->findOneById($numContrato);

        $resultado = array();
        $resultado['codEntidadeContrato'] = $contrato->getCodEntidade();
        $resultado['objetoContrato'] = $contrato->getObjeto();
        $resultado['cgmRepresentanteLegal'] = $contrato->getCgmResponsavelJuridico()->getNomCgm();
        $resultado['cgmContratado'] = $contrato->getCgmContratado()->getCgmFornecedor()->getNomCgm();
        $resultado['dtAssinaturaContrato'] = $contrato->getDtAssinatura()->format('d/m/Y');
        $resultado['vencimento'] = $contrato->getVencimento()->format('d/m/Y');
        $resultado['valorContratadoContrato'] = $contrato->getValorContratado();

        $response = new Response();
        $response->setContent(json_encode($resultado));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
