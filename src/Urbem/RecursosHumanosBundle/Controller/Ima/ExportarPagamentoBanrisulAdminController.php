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
use Urbem\CoreBundle\Model\Ima\ExportarPagamentoBanrisulModel;
use Urbem\CoreBundle\Repository\RecursosHumanos\Ima\ExportarPagamentoBanrisulRepository;

/**
 * Class ExportarPagamentoBanrisulAdminController
 * @package Urbem\RecursosHumanosBundle\Controller\Ima
 */
class ExportarPagamentoBanrisulAdminController extends CRUDController
{
    const NUM_SEQUENCIAL_ARQUIVO_KEY = 'num_sequencial_arquivo_banrisul';

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

        $model = new ExportarPagamentoBanrisulModel($em);
        $repository = new ExportarPagamentoBanrisulRepository($em);

        $q = $request->get($request->get('uniqid'));
        if (!$q) {
            $redirectUrl = $this->admin->generateObjectUrl('filtro', $this->admin->getSubject());

            (new RedirectResponse($redirectUrl))->send();
        }

        $q = array_merge($q, $request->request->all());

        $grupoContas = $repository->fetchGrupoDeContas();

        $arquivos = [];
        foreach ($grupoContas as $grupoContasId => $grupoConta) {
            if (!empty($q['grupoContas']) && !in_array($grupoContasId, $q['grupoContas'])) {
                continue;
            }

            $filtro = $q;
            $model->setValorFiltro($filtro);
            $filtro['grupoContasId'] = $grupoContasId;
            $filtro['codConvenio'] = $grupoConta['cod_convenio'];
            $filtro['codBanco'] = $grupoConta['cod_banco'];
            $filtro['codAgencia'] = $grupoConta['cod_agencia'];
            $filtro['codContaCorrente'] = $grupoConta['cod_conta_corrente'];
            $filtro['numContaCorrente'] = $grupoConta['num_conta_corrente'];

            $remessas = $model->getRemessas($filtro);

            $remessas['totalRegistros'] = count($remessas);
            $remessas['grupoContasId'] = $grupoContasId;
            $remessas['totalLiquido'] = array_sum(array_column($remessas, 'liquido'));
            $remessas['numSequencialArquivo'] = $repository->fetchNumSequencialArquivo($this->admin->getExercicio());
            $remessas['nomeArquivo'] = sprintf('banrisul%d.rem', $remessas['numSequencialArquivo']);
            $remessas['filtro'] = $filtro;
            $remessas['grupoConta'] = $grupoConta;

            $arquivos[] = $remessas;

            $repository->updateNumSequencialArquivo($this->admin->getExercicio());
        }

        $competencia = (new DateTime)->createFromFormat('m/Y', $filtro['competencia']);

        return $this->render(
            'RecursosHumanosBundle::Ima/ExportarPagamentoBanrisul/lista_downloads.html.twig',
            [
                'q' => $q,
                'tipoCadastro' => $admin::TIPOS_CADASTRO[$filtro['tipoCadastro']],
                'competencia' => strftime('%B/%Y', $competencia->getTimestamp()),
                'periodoCompetencia' => $repository->fetchPeriodoMovimentacao($filtro['competencia']),
                'arquivos' => $arquivos,
                'totalRegistros' => array_sum(array_column($arquivos, 'totalRegistros')),
                'totalLiquido' => array_sum(array_column($arquivos, 'totalLiquido')),
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

        $model = new ExportarPagamentoBanrisulModel($em);
        $repository = new ExportarPagamentoBanrisulRepository($em);

        $filtro = json_decode($request->get('q'), true);
        $entidade = $repository->fetchDadosEntidade($this->admin->getExercicio());

        $remessas = $model->getRemessas($filtro);

        return $this->render(
            'RecursosHumanosBundle::Ima/ExportarPagamentoBanrisul/arquivo.html.twig',
            [
                'cabecalhoArquivo' => $model->formatarCabecalhoArquivo($entidade, $filtro),
                'cabecalhoLote' => $model->formatarCabecalhoLote($entidade, $filtro),
                'detalheRemessas' => $model->formatarRemessas($remessas, $filtro),
                'rodapeLote' => $model->formatarRodapeLote($entidade, $filtro, $remessas),
                'rodapeArquivo' => $model->formatarRodapeArquivo($entidade, $filtro, $remessas),
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
