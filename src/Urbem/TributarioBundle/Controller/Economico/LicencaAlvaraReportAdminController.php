<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model\Economico\LicencaModel;

/**
 * Class LicencaAlvaraReportAdminController
 * @package Urbem\TributarioBundle\Controller\Arrecadacao
 */
class LicencaAlvaraReportAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function relatorioAction(Request $request)
    {
        $container = $this->container;

        $em = $this->getDoctrine()->getManager();

        $params = $request->query->all();

        try {
            $licencaModel = new LicencaModel($em);

            $results = $licencaModel->getLicencaAlvara($params);
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));
            throw $e;
        }

        $html = $this->renderView(
            'TributarioBundle:Economico/Relatorios:licencaAlvara.html.twig',
            [
                'filtros' => $params,
                'results' => $results,
                'entidade' => $this->get('urbem.entidade')->getEntidade(),
                'modulo' => 'Cadastro Econômico',
                'subModulo' => 'Relatórios',
                'funcao' => 'Licenças/Alvarás',
                'nomRelatorio' => 'Relatório de Licenças/Alvarás',
                'dtEmissao' => new \DateTime(),
                'usuario' => $container->get('security.token_storage')->getToken()->getUser(),
                'versao' => $container->getParameter('version')
            ]
        );

        $filename = sprintf('RelatorioDeLicencasEAlvaras_%s.pdf', date('Y-m-d'));

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
