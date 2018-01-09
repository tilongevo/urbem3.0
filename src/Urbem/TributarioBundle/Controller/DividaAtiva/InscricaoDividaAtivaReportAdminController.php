<?php

namespace Urbem\TributarioBundle\Controller\DividaAtiva;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model\Divida\ConsultaInscricaoDividaModel;
use Urbem\CoreBundle\Model\Divida\DividaAtivaModel;

class InscricaoDividaAtivaReportAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function relatorioAction(Request $request)
    {
        $container = $this->container;

        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $dividaModel = (new DividaAtivaModel($em));

        $params = $request->query->all();

        $dividas = $dividaModel->filtraInscricaoDividaAtiva($params);

        $entidade = $this->get('urbem.entidade')->getEntidade();

        $html = $this->renderView(
            'TributarioBundle:DividaAtiva/Relatorios:inscricaoDividaAtiva.html.twig',
            [
                'dividas' => $dividas,
                'filtros' => $params,
                'entidade' => $entidade,
                'modulo' => 'Dívida Ativa',
                'subModulo' => 'Relatórios',
                'funcao' => 'Inscrição em Dívida Ativa',
                'nomRelatorio' => 'Inscrição em Dívida Ativa',
                'dtEmissao' => new \DateTime(),
                'usuario' => $usuario,
                'versao' => $container->getParameter('version')
            ]
        );

        $filename = sprintf('RelatorioInscricaoDividaAtiva_%s.pdf', date('Y-m-d-His'));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $html,
                [
                    'encoding' => 'utf-8',
                    'enable-javascript' => true,
                    'footer-line' => true,
                    'footer-left' => 'URBEM - CNM',
                    'footer-right' => '[page]',
                    'footer-center' => 'www.cnm.org.br',
                    'orientation'=>'Portrait'
                ]
            ),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
            ]
        );
    }
}
