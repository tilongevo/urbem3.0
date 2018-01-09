<?php

namespace Urbem\FinanceiroBundle\Controller\Empenho;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

class ReemitirEmpenhoAdminController extends Controller
{
    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);
    }
    
    public function reemitirEmpenhoAction(Request $request)
    {
        $codPreEmpenho = $request->query->get('codPreEmpenho');
        $exercicio = $request->query->get('exercicio');
        
        $entityManager = $this->getDoctrine()->getManager();
        
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        
        $dadosEmpenho = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getDadosEmpenho($codPreEmpenho, $exercicio);

        $data = explode('/', $dadosEmpenho['dtEmpenho']->format('d/m/Y'));
        $hora = explode(':', $dadosEmpenho['hora']->format('H:i:s'));
        $emissaoEmpenho = new \DateTime();
        $emissaoEmpenho->setDate($data[2], $data[1], $data[0]);
        $emissaoEmpenho->setTime($hora[0], $hora[1], $hora[2]);

        $html = $this->renderView(
            'FinanceiroBundle:Empenho/Empenho:reemitirEmpenho.html.twig',
            array(
                'logoTipo' => $this->container->get('urbem.configuracao')->getLogoTipo(),
                'dadosEmpenho' => $dadosEmpenho,
                'usuario' => $currentUser,
                'entidade' => $this->get('urbem.entidade')->getEntidade(),
                'modulo' => 'Empenho',
                'subModulo' => 'Empenho',
                'funcao' => 'Nota de Empenho',
                'dtEmissao' => $emissaoEmpenho,
                'nomRelatorio' => 'Empenho N. ' . $dadosEmpenho['empenho'] . ' REEMISSÃO',
                'versao' => '3.0.0'
            )
        );
        
        $filename = "NotaDeEmpenho_" . (new \DateTime())->format("Ymd_His") . ".pdf";
        
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
