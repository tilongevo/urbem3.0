<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model\Imobiliario\CorretagemModel;

/**
 * Class CorretagemReportAdminController
 * @package Urbem\TributarioBundle\Controller\Imobiliario
 */
class CorretagemReportAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function relatorioAction(Request $request)
    {
        $container = $this->container;

        $em = $this->getDoctrine()->getManager();
        $corretagemModel = new CorretagemModel($em);

        $params = $request->query->all();

        $corretagens = $corretagemModel->getCorretagemReport($params);

        $html = $this->renderView(
            'TributarioBundle:Imobiliario/Relatorios:corretagem.html.twig',
            [
                'corretagens' => $corretagens,
                'filtros' => $params,
                'entidade' => $this->get('urbem.entidade')->getEntidade(),
                'modulo' => 'Cadastro Imobiliário',
                'subModulo' => 'Relatórios',
                'funcao' => 'Corretagem',
                'nomRelatorio' => 'Relatório de Corretagem',
                'dtEmissao' => new \DateTime(),
                'usuario' => $container->get('security.token_storage')->getToken()->getUser(),
                'versao' => $container->getParameter('version')
            ]
        );

        $filename = sprintf('Corretagem_%s.pdf', date('Y-m-d'));

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
                    'orientation'=>'Landscape'
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
