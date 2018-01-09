<?php

namespace Urbem\TributarioBundle\Controller\Arrecadacao;

use DateTime;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Arrecadacao\Lote;

/**
 * Class ConsultaLoteAdminController
 * @package Urbem\TributarioBundle\Controller\Arrecadacao
 */
class ConsultaLoteAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function consultarAction(Request $request)
    {
        return $this->showAction();
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function relatorioBaixaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $container = $this->container;

        $id = $request->get($this->admin->getIdParameter());
        $loteArquivo = $this->admin->getObject($id);

        $html = $this->renderView(
            'TributarioBundle:Arrecadacao/ConsultaLote:relatorio_baixa.html.twig',
            [
                'modulo' => 'Arrecadação',
                'subModulo' => 'Consultas',
                'funcao' => 'Lote',
                'nomRelatorio' => 'Relatório de Baixa do Lote',
                'dtEmissao' => new DateTime(),
                'usuario' => $container->get('security.token_storage')->getToken()->getUser(),
                'versao' => $container->getParameter('version'),
                'entidade' => $this->get('urbem.entidade')->getEntidade(),
                'loteArquivo' => $loteArquivo,
                'lote' => $loteArquivo->getFkArrecadacaoLote(),
                'loteInfo' => $em->getRepository(Lote::class)->getLoteInfo($loteArquivo->getFkArrecadacaoLote()),
                'pagamentosCredito' => $em->getRepository(Lote::class)->getPagamentosCredito($loteArquivo->getFkArrecadacaoLote()),
                'pagamentos' => $em->getRepository(Lote::class)->getPagamentos($loteArquivo->getFkArrecadacaoLote()),
                'inconsistencias' => $em->getRepository(Lote::class)->getInconsistencias($loteArquivo->getFkArrecadacaoLote()),
                'inconsistenciasSemVinculo' => $em->getRepository(Lote::class)->getInconsistenciasSemVinculo($loteArquivo->getFkArrecadacaoLote()),
            ]
        );

        $now = new DateTime();
        $filename = sprintf('RelatorioDeBaixaDoLote_%d_%d_%s.pdf', $loteArquivo->getCodLote(), $loteArquivo->getExercicio(), $now->format('Y-m-d'));

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
                'Content-Description' => 'File Transfer',
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function relatorioRegistroAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $container = $this->container;

        $id = $request->get($this->admin->getIdParameter());
        $loteArquivo = $this->admin->getObject($id);

        $html = $this->renderView(
            'TributarioBundle:Arrecadacao/ConsultaLote:relatorio_registros.html.twig',
            [
                'modulo' => 'Arrecadação',
                'subModulo' => 'Consultas',
                'funcao' => 'Lote',
                'nomRelatorio' => 'Relatório de Baixa do Lote',
                'dtEmissao' => new DateTime(),
                'usuario' => $container->get('security.token_storage')->getToken()->getUser(),
                'versao' => $container->getParameter('version'),
                'entidade' => $this->get('urbem.entidade')->getEntidade(),
                'loteArquivo' => $loteArquivo,
                'lote' => $loteArquivo->getFkArrecadacaoLote(),
                'loteInfo' => $em->getRepository(Lote::class)->getLoteInfo($loteArquivo->getFkArrecadacaoLote()),
                'pagamentosGrupoCredito' => $em->getRepository(Lote::class)->getPagamentosGrupoCredito($loteArquivo->getFkArrecadacaoLote()),
                'pagamentos' => $em->getRepository(Lote::class)->getPagamentos($loteArquivo->getFkArrecadacaoLote()),
                'inconsistencias' => $em->getRepository(Lote::class)->getInconsistencias($loteArquivo->getFkArrecadacaoLote()),
                'inconsistenciasSemVinculo' => $em->getRepository(Lote::class)->getInconsistenciasSemVinculo($loteArquivo->getFkArrecadacaoLote()),
            ]
        );

        $now = new DateTime();
        $filename = sprintf('RelatorioDeRegistrosDoLote_%d_%d_%s.pdf', $loteArquivo->getCodLote(), $loteArquivo->getExercicio(), $now->format('Y-m-d'));

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
                'Content-Description' => 'File Transfer',
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
            ]
        );
    }
}
