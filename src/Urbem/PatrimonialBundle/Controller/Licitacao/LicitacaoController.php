<?php

namespace Urbem\PatrimonialBundle\Controller\Licitacao;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Entity\Licitacao\Adjudicacao;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\AdjudicacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\LicitacaoModel;

/**
 * Licitacao Licitacao controller.
 *
 */
class LicitacaoController extends ControllerCore\BaseController
{
    /**
     * Home Comissao Licitacao
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function perfilAction(Request $request)
    {
        $id = $request->query->get('id');
        list($codLicitacao, $codModalidade, $codEntidade, $exercicio) = explode('~', $id);

        $this->setBreadCrumb();

        /** @var Licitacao $licitacao */
        $licitacao = $this->getDoctrine()
            ->getRepository('CoreBundle:Licitacao\Licitacao')
            ->createQueryBuilder('l')
            ->select('l, m, p, d')
            ->leftJoin('l.fkLicitacaoMembroAdicionais', 'm')
            ->leftJoin('l.fkLicitacaoParticipantes', 'p')
            ->leftJoin('l.fkLicitacaoLicitacaoDocumentos', 'd')
            ->andWhere('l.codLicitacao = :codLicitacao')
            ->andWhere('l.codModalidade = :codModalidade')
            ->andWhere('l.codEntidade = :codEntidade')
            ->andWhere('l.exercicio = :exercicio')
            ->setParameters([
                'codLicitacao' => $codLicitacao,
                'codModalidade' => $codModalidade,
                'codEntidade' => $codEntidade,
                'exercicio' => $exercicio,
            ])
            ->getQuery()
            ->getSingleResult();

        $comissaoLicitacaoMembros = $this->getDoctrine()
            ->getRepository('CoreBundle:Licitacao\ComissaoLicitacaoMembros')
            ->findBy([
                'codLicitacao' => $licitacao->getCodLicitacao(),
                'exercicio' => $licitacao->getExercicio(),
                'codModalidade' => $licitacao->getCodModalidade(),
                'codEntidade' => $licitacao->getCodEntidade(),
            ]);

        $docParticipantes = $this->getDoctrine()
            ->getRepository('CoreBundle:Licitacao\ParticipanteDocumentos')
            ->findBy([
                'codLicitacao' => $licitacao->getCodLicitacao(),
                'exercicio' => $licitacao->getExercicio(),
                'codModalidade' => $licitacao->getCodModalidade(),
                'codEntidade' => $licitacao->getCodEntidade(),
            ]);

        $passivelAdjudicacao = is_null($licitacao->getFkLicitacaoAdjudicacao());
        $passivelHomologacao = !$passivelAdjudicacao;
        $licitacao->orgao = $this->getDoctrine()
            ->getRepository('CoreBundle:Administracao\Orgao')
            ->findOneBy([
                'codOrgao' => $licitacao->getNumOrgao(),
            ]);

        return $this->render('PatrimonialBundle::Licitacao/Licitacao/perfil.html.twig', [
            'licitacao' => $licitacao,
            'documentos' => $licitacao->getFkLicitacaoLicitacaoDocumentos(),
            'comissoesMembros' => $comissaoLicitacaoMembros,
            'membrosAdicionais' => $licitacao->getFkLicitacaoMembroAdicionais(),
            'participantes' => $licitacao->getFkLicitacaoParticipantes(),
            'documentoParticipantes' => $docParticipantes,
            'passivelAdjudicacao' => $passivelAdjudicacao,
            'passivelHomologacao' => $passivelHomologacao,
        ]);
    }

    /**
     * Pega a listagem dos Grupos de Autorizações do Empenho
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response|Response
     */
    public function getGruposAutorizacaoEmpenhoAction(Request $request)
    {
        $exercicio = $request->get('exercicio');
        $codEntidade = $request->get('cod_entidade');
        $codModalidade = $request->get('cod_modalidade');
        $codLicitacao = $request->get('cod_licitacao');

        $mode = is_null($request->get('mode')) ? 'json' : 'table';

        $response = new Response();

        if (is_null($exercicio) && is_null($codEntidade) && is_null($codModalidade) && is_null($codLicitacao)) {
            return $response;
        }

        $entityManager = $this->getDoctrine()->getManager();

        $licitacaoModel = new LicitacaoModel($entityManager);

        $params = [
            'codLicitacao' => $codLicitacao,
            'codModalidade' => $codModalidade,
            'codEntidade' => $codEntidade,
            'exercicio' => $exercicio
        ];

        $grupos = $licitacaoModel->recuperaGrupoAutEmpenho($params);

        if (count($grupos) == 0
            || is_null($grupos)
        ) {
            return $response;
        }

        if ($mode == 'table') {
            return $this->render('PatrimonialBundle::Licitacao/AutorizacaoEmpenho/grupos.html.twig', [
                'grupos' => $grupos,
                'totalMapa' => 0
            ]);
        }

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });

        $serializer = new Serializer([$normalizer], [$encoder]);
        $grupos = $serializer->serialize($grupos, 'json');

        $response->setContent($grupos);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaLicitacaoAction(Request $request)
    {
        $filtro = $request->get('q');
        $codEntidade = (null !== $request->get('codEntidade') ? $request->get('codEntidade') : false);
        $codModalidade = (null !== $request->get('codModalidade') ? $request->get('codModalidade') : false);
        $exercicio = $this->getExercicio();
        $em = $this->getDoctrine()->getManager();

        $ordemModel = new LicitacaoModel($em);
        $queryBuilder = $ordemModel->carregaLicitacaoQuery(strtolower($filtro));
        $queryBuilder
            ->andWhere("{$queryBuilder->getRootAlias()}.exercicio = :exercicio")
            ->andWhere("{$queryBuilder->getRootAlias()}.codEntidade = :codEntidade")
            ->andWhere("{$queryBuilder->getRootAlias()}.codModalidade = :codModalidade")
            ->setParameter('exercicio', $exercicio)
            ->setParameter('codEntidade', $codEntidade)
            ->setParameter('codModalidade', $codModalidade);
        $result = $queryBuilder->getQuery()->getResult();
        $licitacoes = [];

        /** @var \Urbem\CoreBundle\Entity\Licitacao\Licitacao $licitacao */
        foreach ($result as $licitacao) {
            array_push(
                $licitacoes,
                [
                    'id' => $ordemModel->getObjectIdentifier($licitacao),
                    'label' => (string) $licitacao
                ]
            );
        }
        $items = [
            'items' => $licitacoes
        ];
        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function carregaDadosLicitacaoAction(Request $request)
    {
        $exercicio = $request->get('exercicio');
        $codEntidade = $request->get('entidade');
        $codModalidade = $request->get('modalidade');
        $contrato = $request->get('contrato');
        $codLicitacao = $request->get('licitacao');
        $response = new Response();
        if (is_null($exercicio) && is_null($codEntidade) && is_null($codModalidade) && is_null($contrato)) {
            return $response;
        }

        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        /** @var Licitacao $licitacao */
        $licitacao = $entityManager->getRepository(Licitacao::class)->findOneBy(['exercicio' => $exercicio, 'codModalidade' => $codModalidade, 'codEntidade' => $codEntidade, 'codLicitacao' => $codLicitacao]);
        $dados = [];

        $dados['processo'] =
            $licitacao->getFkSwProcesso()->getCodProcesso() . '/' . $licitacao->getFkSwProcesso()->getAnoExercicio() . ' - ' . $licitacao->getFkSwProcesso()->getFkSwAssunto();
        $dados['valor'] = $licitacao->getVlCotado();

        return new JsonResponse($dados);
    }

    /**
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function getLicitacaoCompraDiretaAction(Request $request)
    {
        $exercicio = $request->get('exercicio');
        $codEntidade = $request->get('entidade');
        $codModalidade = $request->get('modalidade');
        $contrato = $request->get('contrato');

        $response = new Response();
        if (is_null($exercicio) && is_null($codEntidade) && is_null($codModalidade) && is_null($contrato)) {
            return $response;
        }

        $entityManager = $this->getDoctrine()->getManager();
        $dados = [];
        if ($contrato == 1) {
            $licitacaoModel = new LicitacaoModel($entityManager);

            $licitacoes = $licitacaoModel->carregaLicitacaoContrato($codModalidade, $codEntidade, $exercicio);

            foreach ($licitacoes as $licitacao) {
                array_push($dados, ['id' => $licitacao->cod_licitacao, 'label' => $licitacao->cod_licitacao . " / " . $licitacao->exercicio . " - " . $licitacao->nom_cgm]);
            }
        }
        return new JsonResponse($dados);
    }

    /**
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function getLicitacaoEditalAction(Request $request)
    {
        $exercicio = $request->get('exercicio');
        $codEntidade = $request->get('entidade');
        $codModalidade = $request->get('modalidade');

        $response = new Response();
        if (is_null($exercicio) && is_null($codEntidade) && is_null($codModalidade)) {
            return $response;
        }

        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();
        $dados = [];
        /** @var LicitacaoModel $licitacaoModel */
        $licitacaoModel = new LicitacaoModel($entityManager);

        $licitacoes = $licitacaoModel->carregaLicitacaoEdital($codModalidade, $codEntidade, $exercicio);

        foreach ($licitacoes as $licitacao) {
            array_push($dados, ['id' => $licitacao->cod_licitacao, 'label' => $licitacao->cod_licitacao . " / " . $licitacao->exercicio . " - " . $licitacao->nom_cgm]);
        }
        return new JsonResponse($dados);
    }

    /**
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function verifyLicitacaoExistsAction(Request $request)
    {
        $exercicio = $request->get('exercicio');
        $codEntidade = $request->get('entidade');
        $codModalidade = $request->get('modalidade');
        $codLicitacao = $request->get('codLicitacao');

        $response = new Response();
        if (is_null($exercicio) && is_null($codEntidade) && is_null($codModalidade) && is_null($codLicitacao)) {
            return $response;
        }

        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        $getLicitacao = $entityManager->getRepository(Licitacao::class)->findOneBy(['exercicio' => $exercicio, 'codModalidade' => $codModalidade, 'codEntidade' => $codEntidade, 'codLicitacao' => $codLicitacao]);
        if (!$getLicitacao) {
            $getLicitacao = ['status' => true];
        }
        return new JsonResponse($getLicitacao);
    }
}
