<?php

namespace Urbem\TributarioBundle\Controller\Arrecadacao;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model\Arrecadacao\ExtratoDebitosReportModel;

/**
 * Class ExtratoDebitosReportAdminController
 * @package Urbem\TributarioBundle\Controller\Arrecadacao
 */
class ExtratoDebitosReportAdminController extends CRUDController
{
    const TIPO_ANALITICO = 'analitico';
    const TIPO_SINTETICO = 'sintetico';

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dadosFiltroAction(Request $request)
    {
        $id = $this->admin->getIdParameter();
        $this->admin->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));

        $request = $request->query->all();

        $param = [
            'inscricaoMunicipal' => isset($request['inscricaoMunicipal']) ? $request['inscricaoMunicipal'] : '',
            'inscricaoEconomica' => isset($request['inscricaoEconomica']) ? $request['inscricaoEconomica'] : '',
            'numcgm' => isset($request['numcgm']) ? $request['numcgm'] : '',
            'exercicio' => isset($request['exercicio']) ? $request['exercicio'] : '',
            'contribuinte' => isset($request['contribuinte']) ? $request['contribuinte'] : '',
        ];

        return $this->render(
            'TributarioBundle::Arrecadacao/Relatorios/ExtratoDebitos/dados_parcela_em_aberto.html.twig',
            array(
                'dados' => $param,
                'listaParcelasEmAberto' => $this->getExtratoDebitosModel()->getListaParcelaEmAberto($param),
                'inscricaoEndereco' => $this->getExtratoDebitosModel()->getInscricaoEndereco($param['inscricaoEconomica']),
                'inscricaoLogradouro' => $this->getExtratoDebitosModel()->getConsultaLogradouro($param['inscricaoMunicipal'])
            )
        );
    }

    /**
     * @param $em
     * @return ExtratoDebitosReportModel
     */
    private function getExtratoDebitosModel()
    {
        return (new ExtratoDebitosReportModel($this->getDoctrine()->getManager()));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function relatorioAction(Request $request)
    {
        $param = $request->request->all();

        $listaParcelasEmAberto = $this->getExtratoDebitosModel()
            ->getListaParcelaEmAberto($param);

        $parcelasLancamento = array();
        if ($param['tipoRelatorio'] == self::TIPO_ANALITICO) {
            if (count($listaParcelasEmAberto)) {
                foreach ($listaParcelasEmAberto as $lancamento) {
                    $parcelasLancamento[$lancamento['cod_lancamento']] = $this->getExtratoDebitosModel()->getListaParcelaEmAbertoAnalitico($param, $lancamento['cod_lancamento']);
                }
            }
        }

        $html = $this->renderView(
            sprintf('TributarioBundle:Arrecadacao/Relatorios/ExtratoDebitos:relatorio_extrato_debitos_%s.html.twig', $param['tipoRelatorio']),
            [
                'modulo' => 'Arrecadação',
                'subModulo' => 'Relatórios',
                'funcao' => 'Extrato Debitos',
                'nomRelatorio' => 'Extrato de Débitos',
                'dtEmissao' => new \DateTime(),
                'usuario' => $this->container->get('security.token_storage')->getToken()->getUser(),
                'versao' => $this->container->getParameter('version'),
                'entidade' => $this->get('urbem.entidade')->getEntidade(),
                'logoTipo' => $this->container->get('urbem.configuracao')->getLogoTipo(),
                'dados' => $param,
                'listaParcelasEmAberto' => $listaParcelasEmAberto,
                'parcelasLancamento' => $parcelasLancamento,
                'inscricaoEndereco' => $this->getExtratoDebitosModel()->getInscricaoEndereco($param['inscricaoEconomica']),
                'inscricaoLogradouro' => $this->getExtratoDebitosModel()->getConsultaLogradouro($param['inscricaoMunicipal'])
            ]
        );

        $now = new \DateTime();
        $filename = sprintf('RelatorioExtratoDebitos_%s.pdf', $now->format('Y-m-d_His'));

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
                    'orientation' => 'Landscape'
                ]
            ),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
            ]
        );
    }
}
