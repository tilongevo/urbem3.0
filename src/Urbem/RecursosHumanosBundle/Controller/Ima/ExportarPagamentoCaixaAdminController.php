<?php

namespace Urbem\RecursosHumanosBundle\Controller\Ima;

use DateTime;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Ima\ExportarPagamentoCaixaModel;
use Urbem\CoreBundle\Repository\RecursosHumanos\Ima\ExportarPagamentoCaixaRepository;

/**
 * Class ExportarPagamentoCaixaAdminController
 * @package Urbem\RecursosHumanosBundle\Controller\Ima
 */
class ExportarPagamentoCaixaAdminController extends CRUDController
{
    const NUM_SEQUENCIAL_ARQUIVO_KEY = 'num_sequencial_arquivo_caixa';

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filtroAction(Request $request)
    {
        return parent::createAction();
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detalheAction(Request $request)
    {
        setlocale(LC_ALL, 'pt_BR.utf8');

        $admin = $this->admin;

        $admin->setBreadCrumb();

        $em = $this->getDoctrine()->getManager();

        $model = new ExportarPagamentoCaixaModel($em);
        $repository = new ExportarPagamentoCaixaRepository($em);

        $q = $request->get($request->get('uniqid'));
        if (!$q) {
            $redirectUrl = $this->admin->generateObjectUrl('filtro', $this->admin->getSubject());

            (new RedirectResponse($redirectUrl))->send();
        }

        $filtro = array_merge($q, $request->request->all());
        $competencia = (new DateTime)->createFromFormat('m/Y', $filtro['competencia']);
        $model->setValorFiltro($filtro);
        $remessas = $model->getRemessas($filtro);

        $remessas['totalRegistros'] = count($remessas);
        $remessas['totalLiquido'] = array_sum(array_column($remessas, 'liquido'));
        $remessas['numSequencialArquivo'] = $repository->fetchNumSequencialArquivo($this->admin->getExercicio());
        $remessas['nomeArquivo'] = sprintf('ACC%02d01.txt', $competencia->format('m'));
        $remessas['filtro'] = $filtro;

        $repository->updateNumSequencialArquivo($this->admin->getExercicio());


        return $this->render(
            'RecursosHumanosBundle::Ima/ExportarPagamentoCaixa/lista_downloads.html.twig',
            [
                'q' => $q,
                'tipoCadastro' => $admin::TIPOS_CADASTRO[$filtro['tipoCadastro']],
                'tipoFolha' => $admin::TIPOS_FOLHA[$filtro['tipoFolha']],
                'tipoMovimento' => sprintf('%d - %s', $filtro['tipoMovimento'], $admin::TIPOS_MOVIMENTO[$filtro['tipoMovimento']]),
                'competencia' => strftime('%B/%Y', $competencia->getTimestamp()),
                'periodoCompetencia' => $repository->fetchPeriodoMovimentacao($filtro['competencia']),
                'arquivo' => $remessas,
                'totalRegistros' => $remessas['totalRegistros'],
                'totalLiquido' => $remessas['totalLiquido'],
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function downloadAction(Request $request)
    {
        setlocale(LC_ALL, 'pt_BR.utf8');

        $admin = $this->admin;

        $em = $this->getDoctrine()->getManager();

        $model = new ExportarPagamentoCaixaModel($em);
        $repository = new ExportarPagamentoCaixaRepository($em);

        $filtro = json_decode($request->get('q'), true);
        $entidade = $repository->fetchDadosEntidade($this->admin->getExercicio());

        $remessas = $model->getRemessas($filtro);

        $conta = $repository->fetchGrupoDeContas();

        return $this->render(
            'RecursosHumanosBundle::Ima/ExportarPagamentoCaixa/arquivo.html.twig',
            [
                'cabecalhoArquivo' => $model->formatarCabecalhoArquivo($entidade, $filtro, $conta),
                'detalheRemessas' => $model->formatarRemessas($remessas, $filtro, $conta),
                'rodapeArquivo' => $model->formatarRodapeArquivo($entidade, $filtro, $remessas, $conta),
            ],
            new Response(
                '',
                Response::HTTP_OK,
                [
                    'Content-Description' => 'File Transfer',
                    'Content-Type' => 'text/plain',
                    'Content-Disposition' => sprintf('attachment; filename="%s"', $request->get('nomeArquivo')),
                ]
            )
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function apiMatriculaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $results = ['items' => []];
        if (!$request->get('numcgm')) {
            return new JsonResponse($results);
        }

        $qb = $em->getRepository(Contrato::class)->createQueryBuilder('c');
        $qb->join('c.fkPessoalContratoServidor', 'cs');
        $qb->join('cs.fkPessoalServidorContratoServidores', 'scs');
        $qb->join('scs.fkPessoalServidor', 's');
        $qb->join(SwCgm::class, 'cgm', 'WITH', 'cgm.numcgm = s.numcgm');

        $qb->andWhere('cgm.numcgm = :numcgm');
        $qb->setParameter('numcgm', (int) $request->get('numcgm'));

        $qb->orderBy('c.registro', 'ASC');

        foreach ((array) $qb->getQuery()->getResult() as $contrato) {
            $results['items'][] = [
                'id' => $contrato->getCodContrato(),
                'label' => (string) $contrato->getRegistro(),
            ];
        }

        return new JsonResponse($results);
    }
}
