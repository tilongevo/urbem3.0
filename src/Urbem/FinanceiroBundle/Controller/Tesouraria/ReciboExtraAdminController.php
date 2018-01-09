<?php

namespace Urbem\FinanceiroBundle\Controller\Tesouraria;

use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReciboExtraAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function dataEmissaoAction(Request $request)
    {
        $exercicio = $request->request->get('exercicio');
        $codEntidade = $request->request->get('codEntidade');
        $tipoRecibo = $request->request->get('tipoRecibo');

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:Tesouraria\ReciboExtra');
        $data = $repository->getProximoTimestamp($exercicio, $codEntidade, $tipoRecibo);

        if ($data) {
            $data = new \DateTime($data);
            $data = $data->format('d/m/Y');
        }

        $response = new Response();
        $response->setContent(json_encode(['data' => $data]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function contaBancoAction(Request $request)
    {
        $exercicio = $request->request->get('exercicio');
        $codEntidade = $request->request->get('codEntidade');
        
        $contas = array();
        
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:Tesouraria\ReciboExtra');
        $codContaBancos = $repository->getCodContaBanco($exercicio, $codEntidade);

        foreach ($codContaBancos as $codContaBanco) {
            $contas[$codContaBanco['cod_plano'] . ' - ' . $codContaBanco['nom_conta']] = $codContaBanco['cod_plano'];
        }

        $response = new Response();
        $response->setContent(json_encode($contas));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function contaReceitaAction(Request $request)
    {
        $exercicio = $request->request->get('exercicio');

        $contas = array();

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:Tesouraria\ReciboExtra');
        $codContaReceitas = $repository->getCodContaReceita($exercicio);

        foreach ($codContaReceitas as $codContaReceita) {
            $contas[$codContaReceita['cod_plano'] . ' - ' . $codContaReceita['nom_conta']] = $codContaReceita['cod_plano'];
        }

        $response = new Response();
        $response->setContent(json_encode($contas));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function assinaturaAction(Request $request)
    {
        $exercicio = $request->request->get('exercicio');
        $codEntidade = $request->request->get('codEntidade');

        $assinaturas = array();

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:Tesouraria\ReciboExtra');
        $adminAssinaturas = $repository->getAssinaturas($exercicio, $codEntidade);

        foreach ($adminAssinaturas as $assinatura) {
            $assinaturas[$assinatura['numcgm'] . ' - ' . $assinatura['nom_cgm'] . ' | ' . $assinatura['cargo']] = $assinatura['numcgm'];
        }

        $response = new Response();
        $response->setContent(json_encode($assinaturas));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function relatorioAction(Request $request)
    {
        $codReciboExtra = $request->query->get('codReciboExtra');
        $exercicio = $request->query->get('exercicio');
        $codEntidade = $request->query->get('codEntidade');
        $tipoRecibo = $request->query->get('tipoRecibo');

        $container = $this->container;

        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $reciboExtra = $em->getRepository('CoreBundle:Tesouraria\ReciboExtra')
            -> findOneBy([
                'codReciboExtra' => $codReciboExtra,
                'exercicio' => $exercicio,
                'codEntidade' => $codEntidade,
                'tipoRecibo' => $tipoRecibo
            ]);

        $dtEmissao = $reciboExtra->getTimestamp();

        $entidade = $reciboExtra->getFkOrcamentoEntidade();
        $cgmPessoaJuridica = $em->getRepository('CoreBundle:SwCgmPessoaJuridica')->find($entidade->getNumcgm());

        $codRecurso = $reciboExtra->getFkTesourariaReciboExtraRecurso()->getCodRecurso();
        $recurso = $em->getRepository('CoreBundle:Orcamento\Recurso')
            ->findOneBy([
                'exercicio' => $reciboExtra->getExercicio(),
                'codRecurso' => $codRecurso
            ]);

        $conta = $reciboExtra->getFkContabilidadePlanoAnalitica()->getFkContabilidadePlanoConta();
        $contaReceita = [];
        $contaReceita['codEstrutural'] = $conta->getCodEstrutural();
        $contaReceita['codPlano'] = $reciboExtra->getCodPlano();
        $contaReceita['nomConta'] = $conta->getNomConta();

        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        $dtInclusao = $reciboExtra->getTimestamp();
        date_default_timezone_set('America/Sao_Paulo');
        $dtRecibo = strftime('%d de %B de %Y', strtotime($dtInclusao->format('Y-m-d')));


        $stBarCode = '';

        $stBarCode = str_pad('', 8, '0');
        $stBarCode .= str_pad($reciboExtra->getCodReciboExtra(), (6 - strlen($reciboExtra->getCodReciboExtra())), '0', STR_PAD_LEFT);
        $stBarCode .= $reciboExtra->getExercicio();
        $stBarCode .= str_pad($reciboExtra->getCodEntidade(), (3 - strlen($reciboExtra->getCodEntidade())), '0', STR_PAD_LEFT) . '0';

        $barcode = new BarcodeGenerator();
        $barcode->setText($stBarCode);
        $barcode->setType(BarcodeGenerator::I25);

        $barcode->setScale(1);
        $barcode->setThickness(60);
        $barcode->setFontSize(10);
        $code = $barcode->generate();

        $html = $this->renderView(
            'FinanceiroBundle:Tesouraria/ReciboExtra:pdf.html.twig',
            [
                'object' => $reciboExtra,
                'contaReceita' => $contaReceita,
                'recurso' => $recurso,
                'dtRecibo' => $dtRecibo,
                'modulo' => 'Tesouraria',
                'codebar' => $code,
                'subModulo' => 'Recibo de Receita\Despesa Extra',
                'funcao' => 'Emitir Recibo',
                'nomRelatorio' => 'Recibo de Receita Extra-Orçamentária - Nro. ' . $reciboExtra->getCodReciboExtraComposto(),
                'dtEmissao' => $dtEmissao,
                'usuario' => $usuario,
                'versao' => $container->getParameter('version')
            ]
        );

        $filename = sprintf('EmitirRecibo-%s.pdf', date('Y-m-d'));

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

    public function buscaSwCgmAction(Request $request)
    {
        $parameter = $request->get('q');

        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository('CoreBundle:SwCgm');

        $qb = $repository->createQueryBuilder('o');
        $qb->where('LOWER(o.nomCgm) LIKE :nomCgm');
        $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($parameter)));

        $cgm = [];
        foreach ($qb->getQuery()->getResult() as $value) {
            array_push($cgm, ['id' => $value->getNumcgm(), 'label' => (string) $value]);
        }
        return new JsonResponse(['items' => $cgm]);
    }
}
