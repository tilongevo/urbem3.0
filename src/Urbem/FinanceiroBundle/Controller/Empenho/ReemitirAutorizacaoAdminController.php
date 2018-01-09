<?php

namespace Urbem\FinanceiroBundle\Controller\Empenho;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReemitirAutorizacaoAdminController extends Controller
{

    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);
    }


    /**
     * @param Request $request
     * @return bool|Response
     */
    public function reemitirAutorizacaoAction(Request $request)
    {
        $codAutorizacao = $request->query->get('codAutorizacao');
        $exercicio = $request->query->get('exercicio');

        $entityManager = $this->getDoctrine()->getManager();

        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        $dadosAutorizacao = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
            ->getDadosAutorizacaoEmpenho($codAutorizacao, $exercicio);

        $emissaoDocumento = new \DateTime('now');

        $html = $this->renderView(
            'FinanceiroBundle:Empenho/Empenho:reemitirAutorizacao.html.twig',
            array(
                'dadosEmpenho' => $dadosAutorizacao,
                'usuario' => $currentUser,
                'modulo' => 'Empenho',
                'subModulo' => 'Empenho',
                'funcao' => 'Autorização de Empenho',
                'nomRelatorio' => sprintf('Autorização de Empenho N. %s', $dadosAutorizacao->empenho),
                'versao' => '3.0.0',
                'emissaoDocumento' => $emissaoDocumento
            )
        );

        $filename = "ReemitirAutorizacao_" . $emissaoDocumento->format("Ymd_His") . ".pdf";

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
        return true;
    }
}
