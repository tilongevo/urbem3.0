<?php

namespace Urbem\FinanceiroBundle\Controller\Orcamento;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model\Orcamento\ReservaSaldosModel;

class ReservaSaldosAdminController extends Controller
{
    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);
    }

    public function consultarDespesasAction(Request $request)
    {
        $codEntidade = $request->request->get('codEntidade');
        $exercicio = $request->request->get('exercicio');

        $em = $this->getDoctrine()->getManager();
        $despesas = $em->getRepository('CoreBundle:Orcamento\Despesa')
            ->findBy([
                'codEntidade' => $codEntidade,
                'exercicio' => $exercicio,
            ], ['codDespesa' => 'ASC']);

        $lista = [];
        foreach ($despesas as $despesa) {
            $lista[$despesa->getCodDespesa()] = sprintf('%s-%s', $despesa->getCodDespesa(), $despesa->getFkOrcamentoContaDespesa()->getDescricao());
        }

        $response = new Response();
        $response->setContent(json_encode($lista));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function consultarSaldoAction(Request $request)
    {
        $exercicio = $request->request->get('exercicio');
        $codDespesa = $request->request->get('codDespesa');
        $dataEmpenho = $request->request->get('dataEmpenho');
        $codEntidade = $request->request->get('codEntidade');
        $tipo = $request->request->get('tipo');

        $em = $this->getDoctrine()->getManager();
        $reservaSaldosModel = new ReservaSaldosModel($em);

        $saldo = $reservaSaldosModel->getSaldoDotacao($exercicio, $codDespesa, $dataEmpenho, $codEntidade, $tipo);

        $response = new Response();
        $response->setContent(json_encode($saldo));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function relatorioAction(Request $request)
    {
        $reserva = $request->query->get('reserva');
        $exercicio = $request->query->get('exercicio');

        $container = $this->container;

        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $reservaSaldos = $em->getRepository('CoreBundle:Orcamento\ReservaSaldos')
            -> findOneBy([
                'exercicio' => $exercicio,
                'codReserva' => $reserva
            ]);

        $entidade = $reservaSaldos->getFkOrcamentoDespesa()->getFkOrcamentoEntidade();

        $html = $this->renderView(
            'FinanceiroBundle:Orcamento/ReservaSaldos:pdf.html.twig',
            [
                'entidade' => $entidade,
                'object' => $reservaSaldos,
                'modulo' => 'label.reservaSaldos.modulo',
                'subModulo' => 'label.reservaSaldos.subModulo',
                'funcao' => 'label.reservaSaldos.funcao',
                'nomRelatorio' => 'label.reservaSaldos.nomRelatorio',
                'dtEmissao' => $reservaSaldos->getDtInclusao(),
                'usuario' => $usuario,
                'versao' => $container->getParameter('version')
            ]
        );

        $filename = sprintf('RelatorioDeReservaDeSaldos-%s.pdf', date('Y-m-d'));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $html,
                [
                    'encoding' => 'utf-8',
                    'enable-javascript' => true,
                    'footer-line' => true,
                    'footer-left' => 'URBEM - CNM',
                    'footer-right' => '[page]',
                    'footer-center' => 'www.cnm.org.br'
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
