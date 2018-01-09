<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model\Economico\ServicoModel;

class RelatorioServicosAdminController extends CRUDController
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

        $servicoModel = (new ServicoModel($em));

        $params =  $request->query->all();

        $servicos = $servicoModel->getServicoByCodAndVigencia($params);

        $entidade = $this->get('urbem.entidade')->getEntidade();

        $html = $this->renderView(
            'TributarioBundle:Economico/Relatorios:servicos.html.twig',
            [
                'servicos' => $servicos,
                'entidade' => $entidade,
                'modulo' => 'Cadastro Econômico',
                'subModulo' => 'Relatórios',
                'funcao' => 'Serviços',
                'nomRelatorio' => 'Relatório de Serviços',
                'dtEmissao' => new \DateTime(),
                'usuario' => $usuario,
                'versao' => $container->getParameter('version')
            ]
        );

        $filename = sprintf('RelatorioServicos_%s.pdf', date('Y-m-d'));

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
