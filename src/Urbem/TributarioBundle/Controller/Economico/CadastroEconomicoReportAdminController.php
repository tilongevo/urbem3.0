<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Model\Economico\AtividadeCadastroEconomicoModel;
use Urbem\CoreBundle\Model\Economico\CadastroEconomicoModel;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model\Economico\SociedadeModel;

/**
 * Class CadastroEconomicoReportAdminController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class CadastroEconomicoReportAdminController extends CRUDController
{
    const RELATORIO_ANALITICO = 'analitico';
    const TIPO_RELATORIO_DIREITO = 'direito';

    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     * @return Response
     */
    public function relatorioAction(Request $request)
    {
        $container = $this->container;

        $em = $this->getDoctrine()->getManager();

        $params = $request->query->all();

        $results = array();
        try {
            $cadastroEconomicoModel = new CadastroEconomicoModel($em);
            $atividadeCadastroEconomicoModel = new AtividadeCadastroEconomicoModel($em);
            $atributoDinamicoModel = new AtributoDinamicoModel($em);
            $sociedadeModel = new SociedadeModel($em);

            $cadastros = $cadastroEconomicoModel->getCadastroEconomicoReport($params);

            foreach ($cadastros as $cadastro) {
                // Filtra situacao_cadastro
                if ($params['situacao'] == 'Todos' || $cadastro['situacao_cadastro'] == $params['situacao']) {
                    if ($params['tipoRelatorio'] == self::RELATORIO_ANALITICO) {
                        $atividades = $atividadeCadastroEconomicoModel->getAtividadeCadastroEconomicoReport(
                            array('inscricao_economica' => $cadastro['inscricao_economica'])
                        );
                        $cadastro['atividades'] = $atividades;

                        $atributos = $atributoDinamicoModel->getAtributoDinamicoCadastroEconomico(
                            array('inscricao_economica' => $cadastro['inscricao_economica'])
                        );
                        $cadastro['atributos'] = $atributos;
                    }

                    if (isset($params['tipoInscricao']) && $params['tipoInscricao'] == self::TIPO_RELATORIO_DIREITO) {
                        $numSocios = str_replace('}', '', str_replace('{', '', $cadastro['sociedade']));
                        $socios = $sociedadeModel->getSociedadeCadastroEconomico(
                            array('numSocios' => $numSocios, 'numcgm' => $cadastro['numcgm'])
                        );
                        $cadastro['socios'] = $socios;
                    }

                    $results[] = $cadastro;
                }
            }
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));
            throw $e;
        }

        $html = $this->renderView(
            'TributarioBundle:Economico/Relatorios:cadastroEconomico.html.twig',
            [
                'filtros' => $params,
                'results' => $results,
                'entidade' => $this->get('urbem.entidade')->getEntidade(),
                'modulo' => 'Cadastro Econômico',
                'subModulo' => 'Relatórios',
                'funcao' => 'Cadastro Econômico',
                'nomRelatorio' => 'Relatório de Cadastro Econômico',
                'dtEmissao' => new \DateTime(),
                'usuario' => $container->get('security.token_storage')->getToken()->getUser(),
                'versao' => $container->getParameter('version')
            ]
        );

        $filename = sprintf('CadastroEconomico_%s.pdf', date('Y-m-d'));

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
