<?php

namespace Urbem\FinanceiroBundle\Controller\Contabilidade;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Administracao\Assinatura;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica;
use Urbem\CoreBundle\Helper\BreadCrumbsHelper;
use Urbem\CoreBundle\Model\Contabilidade\LoteModel;

class LoteAdminController extends CRUDController
{
    protected $layoutDefaultReport = '/bundles/report/gestaoFinanceira/fontes/RPT/contabilidade/report/design/notaLancamento.rptdesign';

    const COD_ACAO = 1645;
    const COD_RELATORIO = 9;

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
     * @return Response
     */
    public function consultarAssinaturasAction(Request $request)
    {
        $codEntidade = $request->request->get('codEntidade');
        $exercicio = $request->request->get('exercicio');

        $em = $this->getDoctrine()->getManager();
        $assinaturas = $em->getRepository('CoreBundle:Administracao\Assinatura')
            ->findBy([
                'codEntidade' => $codEntidade,
                'exercicio' => $exercicio
            ]);

        $listAssinaturas = [];
        if (is_array($assinaturas)) {
            foreach ($assinaturas as $assinatura) {
                $listAssinaturas[$assinatura->getCodAssinatura()] = $assinatura->getNumcgm()->getNumcgm()->getNomCgm() . ' - ' . $assinatura->getCargo();
            }
        }

        $response = new Response();
        $response->setContent(json_encode($listAssinaturas));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultarCodLoteAction(Request $request)
    {
        $response = new Response();
        $response->setContent(
            json_encode(
                (new LoteModel($this->getDoctrine()->getManager()))
                    ->getProximoCodLote(
                        $request->request->get('codEntidade'),
                        $request->request->get('tipo'),
                        $request->request->get('exercicio')
                    )
            )
        );
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Função para autocomplete de Contabilidade\PlanoAnalitica
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompletePlanoAnaliticaAction(Request $request)
    {
        $parameter = $request->get('q');
        $exercicio = $request->get('exercicio');
        $codEstrutural = $request->get('codEstrutural');
        $getCodConta = $request->get('getPlanoConta');

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(PlanoAnalitica::class);

        $qb = $repository->createQueryBuilder('pa');
        $qb->innerJoin('CoreBundle:Contabilidade\PlanoConta', 'pc', 'WITH', 'pc.codConta = pa.codConta and pc.exercicio = pa.exercicio');
        $qb->where($qb->expr()->orX(
            $qb->expr()->like('LOWER(pc.nomConta)', ':nomConta'),
            $qb->expr()->eq('pa.codPlano', ':codPlano')
        ));
        $qb->andWhere('pa.exercicio = :exercicio');

        if ($codEstrutural) {
            $orX = $qb->expr()->orX();
            $itens = explode('~', $codEstrutural);
            foreach ($itens as $item) {
                $orX->add($qb->expr()->like('pc.codEstrutural', "$item"));
            }
            $qb->andWhere($qb->expr()->orX($orX));
        }

        $qb->setParameters([
            'nomConta' => sprintf('%%%s%%', strtolower($parameter)),
            'codPlano' => (int) $parameter,
            'exercicio' => $exercicio
        ]);

        $qb->orderBy('pa.codPlano', 'ASC');
        $result = $qb->getQuery()->getResult();

        $normas = [];
        foreach ($result as $value) {
            $id = !empty($getCodConta) && $getCodConta == 1 ?
                    sprintf("%s~%s", $value->getCodConta(), $value->getExercicio()) : $value->getCodPlano();

            array_push($normas, [
                'id' => $id,
                'label' => (string) $value
            ]);
        }

        return new JsonResponse(array('items' => $normas));
    }

    /**
     * Função para autocomplete de Contabilidade\HistoricoContabil
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteHistoricoContabilAction(Request $request)
    {
        $parameter = $request->get('q');
        $exercicio = $request->get('exercicio');

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:Contabilidade\HistoricoContabil');

        $qb = $repository->createQueryBuilder('hc');
        $qb->where($qb->expr()->orX(
            $qb->expr()->like('LOWER(hc.nomHistorico)', ':nomHistorico'),
            $qb->expr()->eq('hc.codHistorico', ':codHistorico')
        ));
        $qb->andWhere('hc.exercicio = :exercicio');
        $qb->setParameters([
            'nomHistorico' => sprintf('%%%s%%', strtolower($parameter)),
            'codHistorico' => (int) $parameter,
            'exercicio' => $exercicio
        ]);
        $qb->orderBy('hc.codHistorico', 'ASC');
        $result = $qb->getQuery()->getResult();

        $normas = [];
        foreach ($result as $value) {
            array_push($normas, [
                'id' => $value->getCodHistorico(),
                'label' => (string) $value
            ]);
        }

        return new JsonResponse(array('items' => $normas));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function verificaMesProcessamentoAction(Request $request)
    {
        $dtLote = $request->get('dtLote');
        $exercicio = $request->get('exercicio');

        $mesProcessamento = (new LoteModel($this->getDoctrine()->getEntityManager()))->verificaMesProcessamento($dtLote, $exercicio);

        $response = new Response();
        $response->setContent(json_encode($mesProcessamento));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function verificaMesEncerramentoAction(Request $request)
    {
        $dtLote = $request->get('dtLote');
        $exercicio = $request->get('exercicio');

        $mesProcessamento = (new LoteModel($this->getDoctrine()->getEntityManager()))->verificaMesEncerramento($dtLote, $exercicio);

        $response = new Response();
        $response->setContent(json_encode($mesProcessamento));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function verificaAnoProcessamentoAction(Request $request)
    {
        $dtLote = $request->get('dtLote');
        $exercicio = $request->get('exercicio');

        $mesProcessamento = (new LoteModel($this->getDoctrine()->getEntityManager()))->verificaAnoProcessamento($dtLote, $exercicio);

        $response = new Response();
        $response->setContent(json_encode($mesProcessamento));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     */
    public function processarCancelarAberturaRestosAPagarAction(Request $request)
    {
        $container = $this->container;
        $exercicio = $this->admin->getExercicio();
        $em = $this->getDoctrine()->getManager();
        $loteModel = new LoteModel($em);
        $retorno = $loteModel->consultarLote($exercicio, true);
        $message = $this->admin->trans($retorno['message'], [], 'flashes');

        $container->get('session')->getFlashBag()->add($retorno['status'], $message);
        $this->admin->forceRedirect('/financeiro/contabilidade/lancamento-contabil/cancelar-abertura-restos-a-pagar/list');
    }

    /**
     * @param array $param
     * @param null $route
     */
    public function setBreadCrumb($param = [], $route = null)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $request = $this->getRequest();
        $route = $request->get('_route');

        BreadCrumbsHelper::getBreadCrumb(
            $this->get("white_october_breadcrumbs"),
            $this->container->get('router'),
            $route,
            $entityManager,
            $param
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function perfilAction(Request $request)
    {
        $id = $request->get('id');

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $id = explode('~', $id);
        list($codLote, $exercicio, $tipo, $codEntidade) = $id;

        $em = $this->getDoctrine()->getManager();

        $lote = $em->getRepository('CoreBundle:Contabilidade\Lote')
            ->findOneBy([
                'codLote' => $codLote,
                'exercicio' => $exercicio,
                'tipo' => $tipo,
                'codEntidade' => $codEntidade
            ]);

        $maxTimestamp = $em
            ->getRepository('CoreBundle:Administracao\AssinaturaModulo')
            ->createQueryBuilder('o')
            ->select('MAX(o.timestamp)')
            ->where('o.exercicio = :exercicio')
            ->setParameter('exercicio', $exercicio)
            ->getQuery()
            ->getSingleScalarResult();


        $qb = $em
            ->getRepository('CoreBundle:Administracao\Assinatura')
            ->createQueryBuilder('a');
        $qb->innerJoin('a.fkAdministracaoAssinaturaModulos', 'o');
        $qb->where('o.exercicio = :exercicio');
        $qb->andWhere('o.codEntidade = :codEntidade');
        $qb->andWhere('o.codModulo = :codModulo');
        $qb->andWhere('o.timestamp = :timestamp');
        $qb->setParameters(
            array(
                'exercicio' => $exercicio,
                'codEntidade' => $codEntidade,
                'codModulo' => 9,
                'timestamp' => $maxTimestamp
            )
        );
        $assinaturas = $qb->getQuery()->getResult();

        return $this->render('FinanceiroBundle::Contabilidade/Lote/perfil.html.twig', array(
            'lote' => $lote,
            'assinaturas' => $assinaturas
        ));
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function gerarNotaAction(Request $request)
    {
        $id = explode('~', $request->get('id'));
        list($codLote, $exercicio, $tipo, $codEntidade) = $id;

        $model = new LoteModel($this->getDoctrine()->getManager());
        list($lote, $dadosEntidade, $contaDebito, $totalDebito, $contaCredito, $totalCredito) = $model->getValoresGerarNota($codLote, $exercicio, $tipo, $codEntidade);
        $emissaoDocumento = new \DateTime('now');

        $container = $this->container;
        $usuario = $container->get('security.token_storage')->getToken()->getUser();
        $version = $container->getParameter('version');
        $logoTipo = $container->get('urbem.configuracao')->getLogoTipo();

        $em = $this->getDoctrine()->getEntityManager();
        $assinaturas = array();
        if (($request->request->get('incluirAssinaturas')) && (count($request->request->get('assinaturas')))) {
            foreach ($request->request->get('assinaturas') as $assinatura) {
                list($exercicio, $codEntidade, $numcgm, $timestamp) = explode('~', $assinatura);
                $assinaturas[] = $em->getRepository(Assinatura::class)->findOneBy([
                    'exercicio' => $exercicio,
                    'codEntidade' => $codEntidade,
                    'numcgm' => $numcgm,
                    'timestamp' => $timestamp
                ]);
            }
        }

        $html = $this->renderView(
            'FinanceiroBundle:Contabilidade/LancamentoContabil/GerarNota:gerarNotaLancamentoContabil.html.twig',
            array(
                'lote' => $lote,
                'contaDebito' => $contaDebito,
                'contaCredito' => $contaCredito,
                'usuario' => $usuario,
                'modulo' => 'Contabilidade',
                'subModulo' => 'Lançamento Contábil',
                'funcao' => 'Nota de Lançamento Contábil',
                'nomRelatorio' => sprintf('Lançamento Contábil N. %s/%s', $codLote, $exercicio),
                'versao' => $version,
                'logoTipo' => $logoTipo,
                'assinaturas' => $assinaturas,
                'emissaoDocumento' => $emissaoDocumento,
                'dadosEntidade' => $dadosEntidade,
                'total' => ['totalDebito' => $totalDebito, 'totalCredito' => $totalCredito]
            )
        );

        $filename = "nota_lancamento_contabil_" . $emissaoDocumento->format("Ymd_His") . ".pdf";

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
