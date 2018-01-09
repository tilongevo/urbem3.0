<?php

namespace Urbem\FinanceiroBundle\Controller\Empenho;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class AnularEmpenhoAdminController extends Controller
{
    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);
    }
    
    public function reemitirAnulacaoEmpenhoAction(Request $request)
    {
        $codPreEmpenho = $request->query->get('codPreEmpenho');
        $exercicio = $request->query->get('exercicio');
        
        $entityManager = $this->getDoctrine()->getManager();

        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        $dadosEmpenho = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getDadosEmpenho($codPreEmpenho, $exercicio);

        $empenhoAnulado = (new \Urbem\CoreBundle\Model\Empenho\EmpenhoModel($entityManager))
        ->getEmpenhoAnulado($codPreEmpenho, $exercicio);
        
        $valorAnulado = (new \Urbem\CoreBundle\Model\Empenho\EmpenhoModel($entityManager))
        ->getValorEmpenhoAnulado($empenhoAnulado);
        
        $emissaoDocumento = new \DateTime('now');

        $html = $this->renderView(
            'FinanceiroBundle:Empenho/Empenho:reemitirAnulacaoEmpenho.html.twig',
            array(
                'dadosEmpenho' => $dadosEmpenho,
                'usuario' => $currentUser,
                'modulo' => 'Empenho',
                'subModulo' => 'Empenho',
                'funcao' => 'Nota de Anulação de Empenho',
                'nomRelatorio' => 'Emissão ' . $dadosEmpenho['empenho'] . ' REEMISSÃO',
                'versao' => '3.0.0',
                'emissaoDocumento' => $emissaoDocumento,
                'empenhoAnulado' => $empenhoAnulado,
                'valorAnulado' => $valorAnulado
            )
        );
        
        $filename = "NotaDeAnulacaoDeEmpenho_" . $emissaoDocumento->format("Ymd_His") . ".pdf";
        
        return new Response(
            $this->get('knp_snappy.pdf')
            ->getOutputFromHtml(
                $html,
                array(
                    'encoding' => 'utf-8',
                    'enable-javascript' => true,
                    'footer-line' => true,
                    'footer-left' => 'URBEM - CNM',
                    'footer-right' => '[page]',
                    'footer-center' => 'www.cnm.org.br',
                )
            ),
            200,
            array(
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
            )
        );
    }
}
