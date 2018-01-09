<?php

namespace Urbem\TributarioBundle\Controller\Arrecadacao;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Arrecadacao\Lancamento;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Model\Arrecadacao\LancamentoModel;

class EfetuarLancamentoManualAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function consultarCreditosAction(Request $request)
    {
        list($codGrupo, $anoExercicio) = explode('~', $request->request->get('codGrupoCredito'));

        $lancamentoModel = new LancamentoModel($this->getDoctrine()->getEntityManager());
        $creditos = $lancamentoModel->getCreditosByGrupoCreditos($codGrupo, $anoExercicio);

        $response = new Response();
        $response->setContent(json_encode($creditos));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultarImovelAction(Request $request)
    {
        $inscricaoMunicipal = $request->request->get('inscricaoMunicipal');

        $consulta = $this->getDoctrine()->getRepository(Imovel::class)->consultar(array('inscricaoMunicipal' => $inscricaoMunicipal), true);

        $response = new Response();
        $response->setContent(json_encode($consulta));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function relatorioAction(Request $request)
    {
        /** @var Lancamento $lancamento */
        $lancamento = $this->getDoctrine()->getRepository(Lancamento::class)->find($request->get('id'));

        $container = $this->container;

        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        $entidade = $this->get('urbem.entidade')->getEntidade();

        $html = $this->renderView(
            'TributarioBundle:Arrecadacao/Calculo/EfetuarLancamentos:relatorio.html.twig',
            [
                'lancamento' => $lancamento,
                'entidade' => $entidade,
                'modulo' => 'Arrecadação',
                'subModulo' => 'Cálculo',
                'nomRelatorio' => sprintf('Exercício - %d', $lancamento->getFkArrecadacaoLancamentoCalculos()->last()->getFkArrecadacaoCalculo()->getExercicio()),
                'dtEmissao' => new \DateTime(),
                'usuario' => $usuario,
                'versao' => $container->getParameter('version'),
                'funcao' => 'Efetuar Lançamentos',
            ]
        );

        $filename = sprintf('EfetuarLancamentos_%s.pdf', date('Y-m-d'));

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
                    'orientation'=>'Landscape',
                    'margin-top'    => 10
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
