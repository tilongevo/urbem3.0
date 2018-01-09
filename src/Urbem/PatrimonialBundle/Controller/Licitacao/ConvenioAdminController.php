<?php
namespace Urbem\PatrimonialBundle\Controller\Licitacao;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ConvenioAdminController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function gerarRelatorioAction(Request $request)
    {
        $id = $request->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);

        $container = $this->container;
        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        $dtEmissao = (new \DateTime())->format('Y-m-d H:i:s');

        $html = $this->renderView(
            'PatrimonialBundle:Licitacao/Convenios:pdf.html.twig',
            [
                'object' => $object,
                'modulo' => 'Patrimonial',
                'subModulo' => 'Licitação\Convênios',
                'funcao' => 'Emitir Relatório Compras Solicitação',
                'nomRelatorio' => 'Relatório Compras Solicitação',
                'dtEmissao' => $dtEmissao,
                'usuario' => $usuario,
                'versao' => $container->getParameter('version')
            ]
        );

        $filename = sprintf('Convenio-%s.pdf', date('Y-m-d'));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $html,
                [
                    'encoding' => 'utf-8',
                    'enable-javascript' => false,
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
