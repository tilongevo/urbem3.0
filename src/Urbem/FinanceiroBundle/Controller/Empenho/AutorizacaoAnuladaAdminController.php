<?php

namespace Urbem\FinanceiroBundle\Controller\Empenho;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class AutorizacaoAnuladaAdminController extends Controller
{
    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);
    }
    
    public function reemitirAnulacaoAutorizacaoAction(Request $request)
    {
        $codPreEmpenho = $request->query->get('codPreEmpenho');
        $exercicio = $request->query->get('exercicio');
        
        $entityManager = $this->getDoctrine()->getManager();
        
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        
        $dadosAutorizacao = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getDadosAutorizacao($codPreEmpenho, $exercicio);

        $emissaoDocumento = new \DateTime('now');
        
        $html = $this->renderView(
            'FinanceiroBundle:Empenho/PreEmpenho:reemitirAnulacaoAutorizacao.html.twig',
            array(
                'dadosAutorizacao' => $dadosAutorizacao,
                'usuario' => $currentUser,
                'modulo' => 'Autorização',
                'subModulo' => 'Empenho',
                'funcao' => 'Reemitir Anulação Autorização',
                'nomRelatorio' => 'Autorização de Empenho N. ' . $dadosAutorizacao['empenho'],
                'versao' => '3.0.0',
                'emissaoDocumento' => $emissaoDocumento,
            )
        );
        
        $filename = "NotaDeAnulacaoDeAutorizacao_" . $emissaoDocumento->format("Ymd_His") . ".pdf";
        
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
