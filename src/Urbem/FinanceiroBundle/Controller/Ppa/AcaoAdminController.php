<?php

namespace Urbem\FinanceiroBundle\Controller\Ppa;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Helper\BreadCrumbsHelper;

use Urbem\CoreBundle\Model;
use Urbem\FinanceiroBundle\Resources\config\Sonata\Ppa\AcaoAdmin;

class AcaoAdminController extends Controller
{
    protected $breadcrumb;

    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultarUnidadesAction(Request $request)
    {
        $codOrgao = $request->request->get('codOrgao');
        $exercicio = $this->admin->getExercicio();

        $em = $this->getDoctrine()->getManager();
        $unidadeModel = new Model\Orcamento\UnidadeModel($em);
        $unidades = $unidadeModel
            ->findBy([
                'numOrgao' => $codOrgao,
                'exercicio' => $exercicio
            ]);

        $listUnidades = [];
        if (is_array($unidades)) {
            foreach ($unidades as $unidade) {
                $listUnidades[$unidade->getNumUnidade()] =
                    (string) $unidade;
            }
        }

        $response = new Response();
        $response->setContent(json_encode($listUnidades));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function consultarProgramasAction(Request $request)
    {
        $codPpa = $request->request->get('codPpa');

        $em = $this->getDoctrine()->getManager();
        $programaRepository = $em->getRepository('CoreBundle:Ppa\AcoesNaoOrcamentariasReport');
        $listProgramas = $programaRepository->findAllPrograma($codPpa);

        $response = new Response();
        $response->setContent(json_encode($listProgramas));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function consultarSubtiposAction(Request $request)
    {
        $codTipo = $request->request->get('codTipo');

        if ($codTipo == AcaoAdmin::TIPO_ORCAMENTARIA) {
            $subtipos = array(
                AcaoAdmin::TIPO_PROJETO,
                AcaoAdmin::TIPO_ATIVIDADE,
                AcaoAdmin::TIPO_OPERACAO_ESPECIAL
            );
        } elseif ($codTipo == AcaoAdmin::TIPO_NAO_ORCAMENTARIA) {
            $subtipos = array(
                AcaoAdmin::TIPO_FINANCIAMENTOS,
                AcaoAdmin::TIPO_PARCERIAS,
                AcaoAdmin::TIPO_PLANO_DISPENDIO_ESTATAIS,
                AcaoAdmin::TIPO_RENUNCIA_FISCAL,
                AcaoAdmin::TIPO_OUTRAS_INICIATIVAS_DIRETRIZES
            );
        }

        $em = $this->getDoctrine()->getManager();

        $tipoAcaoRepository = $em->getRepository('CoreBundle:Ppa\TipoAcao');

        $queryBuilder = $tipoAcaoRepository->createQueryBuilder('t');
        $queryBuilder->where($queryBuilder->expr()->in('t.codTipo', $subtipos));
        $subtipos = $queryBuilder->getQuery()->getResult();

        $listSubtipos = [];
        if (is_array($subtipos)) {
            foreach ($subtipos as $subtipo) {
                $listSubtipos[$subtipo->getCodTipo()] = $subtipo->getDescricao();
            }
        }

        $response = new Response();
        $response->setContent(json_encode($listSubtipos));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function consultarNaturezaTemporalAction(Request $request)
    {
        $codPrograma = $request->request->get('codPrograma');
        $codTipo = $request->request->get('codTipo');

        if (($codPrograma == '') || ($codTipo == '')) {
            $return['continuo'] = false;
        } else {
            $em = $this->getDoctrine()->getManager();

            $programa = $em->getRepository('CoreBundle:Ppa\Programa')->find($codPrograma);

            $programaDados = $em->getRepository('CoreBundle:Ppa\ProgramaDados')
                ->findOneBy([
                    'codPrograma' => $programa->getCodPrograma(),
                    'timestampProgramaDados' => $programa->getUltimoTimestampProgramaDados()
                ]);
            if ($programaDados) {
                if (($codTipo == AcaoAdmin::TIPO_PROJETO) && (!$programaDados->getContinuo())) {
                    $return['continuo'] = true;
                } else {
                    $return['continuo'] = false;
                }
            } else {
                $return['continuo'] = false;
            }
        }

        $response = new Response();
        $response->setContent(json_encode($return));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Função para autocomplete de Normas\Norma
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteNormaAction(Request $request)
    {
        $parameter = $request->get('q');

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:Normas\Norma');

        $qb = $repository->createQueryBuilder('n');
        $qb->leftJoin('n.fkNormasTipoNorma', 'tn');
        $qb->where($qb->expr()->orX(
            $qb->expr()->like('LOWER(n.nomNorma)', ':nomNorma'),
            $qb->expr()->like('LOWER(tn.nomTipoNorma)', ':nomTipoNorma'),
            $qb->expr()->like('n.numNorma', ':numNorma'),
            $qb->expr()->eq('n.exercicio', ':exercicio')
        ));
        $qb->setParameters([
            'nomNorma' => sprintf('%%%s%%', strtolower($parameter)),
            'nomTipoNorma' => strtolower($parameter),
            'numNorma' => '%' . $parameter . '%',
            'exercicio' => (string) $parameter
        ]);
        $qb->orderBy('n.numNorma', 'ASC');
        $result = $qb->getQuery()->getResult();

        $normas = [];
        foreach ($result as $value) {
            array_push($normas, ['id' => $value->getCodNorma(), 'label' => (string) $value]);
        }

        return new JsonResponse(array('items' => $normas));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removerRecursoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $container = $this->container;

        $codAcao = $this->getRequest()->get('codAcao');
        $acao = $em->getRepository('CoreBundle:Ppa\Acao')->find($codAcao);
        $codRecurso = $this->getRequest()->get('codAcaoRecurso');

        if (is_null($codAcao) || is_null($codRecurso)) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.ppaAcao.erroRemoverRecurso'));
            return $this->redirectToRoute('urbem_financeiro_ppa_acao_list');
        }

        $acaoModel = new Model\Ppa\AcaoModel($em);
        $recursos = $acaoModel->getRecursosByCodAcaoCodRecurso($codAcao, $codRecurso);
        $validado = false;
        foreach ($recursos as $acaoRecurso) {
            if ($acaoRecurso->getFkPpaAcaoMetaFisicaRealizada()) {
                $validado = true;
            }
        }
        if ($validado) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.ppaAcao.erroRemoverRecursoValidado'));
            return $this->redirectToRoute('urbem_financeiro_ppa_acao_perfil', array('id' => $acao->getCodAcao()));
        }

        try {
            foreach ($recursos as $acaoRecurso) {
                $acaoQuantidade = $em->getRepository('CoreBundle:Ppa\AcaoQuantidade')
                    ->findOneBy([
                        'codAcao' => $acaoRecurso->getCodAcao(),
                        'timestampAcaoDados' => $acaoRecurso->getTimestampAcaoDados(),
                        'ano' => $acaoRecurso->getAno(),
                        'codRecurso' => $acaoRecurso->getCodRecurso(),
                        'exercicioRecurso' => $acaoRecurso->getExercicioRecurso()
                    ]);
                $em->remove($acaoRecurso);
                $em->remove($acaoQuantidade);
            }
            $em->flush();
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.ppaAcao.erroRemoverRecurso'));
            return $this->redirectToRoute('urbem_financeiro_ppa_acao_perfil', array('id' => $acao->getCodAcao()));
        }

        $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.ppaAcao.msgRecursoRemovido'));
        return $this->redirectToRoute('urbem_financeiro_ppa_acao_perfil', array('id' => $acao->getCodAcao()));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultarNumAcaoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $return = array('digito' => false, 'existe' => true);

        $numAcao = $this->getRequest()->get('numAcao');
        $verificaDigito = (new Model\Ppa\AcaoModel($em))
            ->verificaNumAcaoByCodTipo(
                $this->getRequest()->get('codTipo'),
                $this->getRequest()->get('exercicio'),
                $numAcao
            );

        if ($verificaDigito) {
            $return['digito'] = true;

            $qb = $em
                ->getRepository('CoreBundle:Ppa\Acao')
                ->createQueryBuilder('o');
            $qb->select('COUNT(o)');
            $qb->where($qb->expr()->orX(
                $qb->expr()->eq('o.codAcao', ':numAcao'),
                $qb->expr()->eq('o.numAcao', ':numAcao')
            ));
            $qb->setParameter('numAcao', (int) $numAcao);
            $verificaAcao = $qb->getQuery()->getSingleScalarResult();

            if (!$verificaAcao) {
                $return['existe'] = false;
            }
        }

        $response = new Response();
        $response->setContent(json_encode($return));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function setBreadCrumb($param = [], $route = null)
    {
        $entityManager = $this->getDoctrine()->getManager();

        BreadCrumbsHelper::getBreadCrumb(
            $this->get("white_october_breadcrumbs"),
            $this->get("router"),
            $route,
            $entityManager,
            $param
        );
    }
}
