<?php

namespace Urbem\FinanceiroBundle\Controller\Empenho;

use DateTime;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho;

/**
 * Class ConsultarEmpenhoAdminController
 * @package Urbem\FinanceiroBundle\Controller\Empenho
 */
class ConsultarEmpenhoAdminController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getUnidadeNumOrgaoAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $unidadeChoices = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
            ->getUnidadeNumOrgao(
                $request->request->get('exercicio'),
                $request->request->get('numOrgao')
            );

        return new JsonResponse($unidadeChoices);
    }

    /**
     * @param Request $request
     * @return string|Response
     */
    public function relatorioAction(Request $request)
    {
        $container = $this->container;
        $entityManager = $this->getDoctrine()->getManager();

        try {
            $id = $request->get($this->admin->getIdParameter());
            list($codEmpenho, $codEntidade, $exercicio) = explode('~', $id);

            $preEmpenhoModel = (new \Urbem\CoreBundle\Model\Empenho\EmpenhoModel($entityManager));

            $filters = [
                'exercicio' => $exercicio,
                'cod_entidade' => $codEntidade,
                'cod_empenho' => $codEmpenho
            ];

            $razaoEmpenho = $preEmpenhoModel->getRazaoEmpenho($filters);
            $itensPreEmpenho = $entityManager->getRepository(ItemPreEmpenho::class)->findBy(array('codPreEmpenho' => $razaoEmpenho['cod_pre_empenho'], 'exercicio' => $exercicio));
            $razaoEmpenhoLancamentos = $preEmpenhoModel->getRazaoEmpenhoLancamentos($filters);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $html = $this->renderView(
            'FinanceiroBundle:Empenho/Empenho:relatorio_razao_empenho.html.twig',
            [
                'modulo' => 'Empenho',
                'subModulo' => 'Empenho',
                'funcao' => 'Consultar Empenho',
                'nomRelatorio' => 'Empenho N. ' . reset($razaoEmpenhoLancamentos)['complemento'],
                'dtEmissao' => new DateTime(),
                'usuario' => $container->get('security.token_storage')->getToken()->getUser(),
                'versao' => $container->getParameter('version'),
                'logoTipo' => $this->container->get('urbem.configuracao')->getLogoTipo(),
                'entidade' => $this->get('urbem.entidade')->getEntidade(),
                'razaoEmpenho' => $razaoEmpenho,
                'itensPreEmpenho' => $itensPreEmpenho,
                'razaoEmpenhoLancamentos' => $razaoEmpenhoLancamentos
            ]
        );

        $now = new DateTime();
        $filename = sprintf('RelatorioRazãoEmpenho_%s.pdf', $now->format('Y-m-d_His'));

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
                    'orientation' => 'Portrait'
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
