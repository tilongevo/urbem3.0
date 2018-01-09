<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Exception;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\DatagridBundle\ProxyQuery\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Inflector\Inflector;
use Urbem\CoreBundle\Entity\Folhapagamento\ConcessaoDecimo;
use Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAdiantamento;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Model\Folhapagamento\ConcessaoDecimoModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoCalculadoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoPeriodoModel;
use Urbem\CoreBundle\Model\Folhapagamento\UltimoRegistroEventoDecimoModel;
use Urbem\CoreBundle\Model\Folhapagamento\UltimoRegistroEventoModel;
use Urbem\CoreBundle\Model\Organograma\OrganogramaModel;
use Urbem\CoreBundle\Model\Organograma\OrgaoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoModel;

class CancelarDecimoAdminController extends CRUDController
{

    /**
     * Batch action.
     *
     * @return RedirectResponse|Response
     * @internal param Request $request
     *
     */
    public function batchAction()
    {
        $custom = $this->getConfigBatchCustomized();
        $template = $custom['template'];
        $formCustomized = $custom['formCustomized'];

        $request = $this->getRequest();

        $restMethod = $this->getRestMethod();

        if ('POST' !== $restMethod) {
            throw $this->createNotFoundException(sprintf('Invalid request type "%s", POST expected', $restMethod));
        }

        // check the csrf token
        $this->validateCsrfToken('sonata.batch');

        $confirmation = $request->get('confirmation', false);

        if ($data = json_decode($request->get('data'), true)) {
            $action = $data['action'];
            $idx = $data['idx'];
            $allElements = $data['all_elements'];

            $request->request->replace(array_merge($request->request->all(), $data));
        } else {
            $request->request->set('idx', $request->get('idx', []));
            $request->request->set('all_elements', $request->get('all_elements', false));
            $action = $request->get('action');
            $idx = $request->get('idx');
            $allElements = $request->get('all_elements');
            $data = $request->request->all();

            unset($data['_sonata_csrf_token']);
        }
        // customizado
        $data['template'] = $template;

        $batchActions = $this->admin->getBatchActions();
        if (!array_key_exists($action, $batchActions)) {
            throw new \RuntimeException(sprintf('The `%s` batch action is not defined', $action));
        }

        $camelizedAction = Inflector::classify($action);
        $isRelevantAction = sprintf('batchAction%sIsRelevant', $camelizedAction);

        if (method_exists($this, $isRelevantAction)) {
            $nonRelevantMessage = call_user_func([$this, $isRelevantAction], $idx, $allElements);
        } else {
            $nonRelevantMessage = count($idx) != 0 || $allElements; // at least one item is selected
        }

        if (!$nonRelevantMessage) { // default non relevant message (if false of null)
            $nonRelevantMessage = 'flash_batch_empty';
        }

        $datagrid = $this->admin->getDatagrid();
        $datagrid->buildPager();

        if (true !== $nonRelevantMessage) {
            $this->addFlash('sonata_flash_info', $nonRelevantMessage);

            return new RedirectResponse(
                $this->admin->generateUrl(
                    'list',
                    ['filter' => $this->admin->getFilterParameters()]
                )
            );
        }

        $askConfirmation = isset($batchActions[$action]['ask_confirmation']) ?
            $batchActions[$action]['ask_confirmation'] :
            true;

        if ($askConfirmation && $confirmation != 'ok') {
            $translationDomain = (!empty($batchActions[$action]['translation_domain']) ?: $this->admin->getTranslationDomain());
            $actionLabel = $this->admin->trans($batchActions[$action]['label'], [], $translationDomain);

            $formView = $datagrid->getForm()->createView();

            return $this->render($this->admin->getTemplate('batch_confirmation'), [
                'action' => 'list',
                'action_label' => $actionLabel,
                'datagrid' => $datagrid,
                'form' => $formView,
                'data' => $data,
                'csrf_token' => $this->getCsrfToken('sonata.batch'),
                // customizado
                'formCustomized' => $formCustomized,
            ], null);
        }

        // execute the action, batchAction
        $finalAction = sprintf('batchAction%s', $camelizedAction);

        if (!is_callable([$this, $finalAction])) {
            throw new \RuntimeException(sprintf('A `%s::%s` method must be callable', get_class($this), $finalAction));
        }

        $query = $datagrid->getQuery();

        $query->setFirstResult(null);
        $query->setMaxResults(null);

        $this->admin->preBatchAction($action, $query, $idx, $allElements);

        if (count($idx) > 0) {
            $this->admin->getModelManager()->addIdentifiersToQuery($this->admin->getClass(), $query, $idx);
        } elseif (!$allElements) {
            $query = null;
        }

        return call_user_func([$this, $finalAction], $query);
    }

    /**
     * @return array
     */
    protected function getConfigBatchCustomized()
    {
        $template = 'RecursosHumanosBundle:Sonata:FolhaPagamento/CalculoDecimo/CRUD/cancelarDecimo.html.twig';

        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();
        $formEncaminhar = $this->createForm(
            'Urbem\RecursosHumanosBundle\Form\FolhaPagamento\ConcessaoDecimoType',
            null,
            ['em' => $entityManager]
        );

        return [
            'template' => $template,
            'formCustomized' => $formEncaminhar->createView()
        ];
    }

    /**
     * @return RedirectResponse
     * @throws Exception
     */
    public function batchActionCancelarDecimo()
    {
        $request = $this->admin->getRequest()->request->get('data');
        $request = json_decode($request);
        $concessao = $this->admin->getRequest()->request->get('concessao_decimo');

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Contratos selecionados pelo usuário
        $contratos = $this->retornaContratos($request, $em);

        if (!empty($contratos)) {
            foreach ($contratos as $contrato) {
                $contratoArray[] = (is_numeric($contrato)) ? $contrato : $contrato['cod_contrato'];
            }
        }

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $contratosArray = $arContratosErro = $arContratos = [];

        try {
            foreach ($contratos as $contrato) {
                $rsDeducaoDependente = $em->getRepository(DeducaoDependente::class)->findOneBy(
                    [
                        'codContrato' => $contrato,
                        'codPeriodoMovimentacao' => $periodoFinal->getCodPeriodoMovimentacao(),
                        'codTipo' => 4
                    ]
                );

                if (!is_null($rsDeducaoDependente)) {
                    $contratosArray[] = ['cod_contrato' => $rsDeducaoDependente['cod_contrato']];
                }
                $this->deletarConcessaoDecimo($contrato, $periodoFinal->getCodPeriodoMovimentacao());
            }
            $this->addFlash('sonata_flash_success', $this->trans('label.cancelar13Scucesso'));

            $this->recalcularSalario($contratos);
        } catch (Exception $exception) {
            throw $exception;
            $this->addFlash('sonata_flash_error', $this->trans('flash_delete_error'));
        }

        return new RedirectResponse(
            $this->admin->generateUrl('list')
        );
    }

    /**
     * @param $codContrato
     * @param $codPeriodoMovimentacao
     */
    public function deletarConcessaoDecimo($codContrato, $codPeriodoMovimentacao)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var UltimoRegistroEventoDecimoModel $ultimoRegistroEventoDecimoModel */
        $ultimoRegistroEventoDecimoModel = new UltimoRegistroEventoDecimoModel($em);
        /** @var UltimoRegistroEventoModel $ultimoRegistroEventoModel */
        $ultimoRegistroEventoModel = new UltimoRegistroEventoModel($em);
        $rsRegistros = $ultimoRegistroEventoDecimoModel->montaRecuperaRegistrosEventoDecimoDoContrato(
            $codContrato,
            $codPeriodoMovimentacao
        );

        foreach ($rsRegistros as $registro) {
            $ultimoRegistroEventoDecimoModel->montaDeletarUltimoRegistroEvento(
                $registro['cod_registro'],
                $registro['cod_evento'],
                $registro['desdobramento'],
                $registro['timestamp'],
                ''
            );
        }

        /** @var ConcessaoDecimo $rsConcessoDecimoFolhaSalario */
        $rsConcessoDecimoFolhaSalario = $em->getRepository(ConcessaoDecimo::class)->findBy(
            [
                'codContrato' => $codContrato,
                'codPeriodoMovimentacao' => $codPeriodoMovimentacao,
                'desdobramento' => 'A',
                'folhaSalario' => true
            ]
        );

        /** @var ConcessaoDecimo $concessao */
        foreach ($rsConcessoDecimoFolhaSalario as $concessao) {
            $eventosCalculadosModel = new EventoCalculadoModel($em);
            $filtro = " AND cod_contrato = $codContrato
            AND cod_periodo_movimentacao = $codPeriodoMovimentacao
            AND desdobramento = 'I'";
            $rsEventosCalculados = $eventosCalculadosModel->montaRecuperaEventosCalculados($filtro);

            foreach ($rsEventosCalculados as $eventosCalculado) {
                $ultimoRegistroEventoModel->montaDeletarUltimoRegistro(
                    $eventosCalculado['cod_registro'],
                    $eventosCalculado['cod_evento'],
                    $eventosCalculado['desdobramento'],
                    $eventosCalculado['timestamp']
                );
            }
        }

        /** @var ConfiguracaoAdiantamento $configuracaoAdiantamento */
        $configuracaoAdiantamento = $em->getRepository(ConfiguracaoAdiantamento::class)->findOneBy(
            [
                'codContrato' => $codContrato,
                'codPeriodoMovimentacao' => $codPeriodoMovimentacao
            ]
        );

        if (is_object($configuracaoAdiantamento)) {
            $ultimoRegistroEventoDecimoModel->remove($configuracaoAdiantamento);
        }

        /** @var ConcessaoDecimo $rsConcessoDecimo */
        $rsConcessoDecimo = $em->getRepository(ConcessaoDecimo::class)->findOneBy(
            [
                'codContrato' => $codContrato,
                'codPeriodoMovimentacao' => $codPeriodoMovimentacao,
            ]
        );
        $ultimoRegistroEventoModel->remove($rsConcessoDecimo);
    }

    /**
     * @param $contratos
     */
    public function recalcularSalario($contratos)
    {
        //Recalcula folha salário de contratos com dependente
        //isso serve para no caso do cancelamento de um décimo onde está
        //sendo incorporado a dedução de dependente, essa dedução passe para
        //a folha salário do contrato
        $stCodContratos = implode(",", $contratos);
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $registroEventoPeriodo = new RegistroEventoPeriodoModel($em);
        $registroEventoPeriodo->deletarInformacoesCalculo($stCodContratos, 'S', 0, '');

        foreach ($contratos as $contrato) {
            /** @var ContratoModel $contratoModel */
            $contratoModel = new ContratoModel($em);
            $contratoModel->montaCalculaFolha(
                $contrato,
                ContratoModel::FOLHA_COD_CONFIGURACAO_SALARIO,
                'false',
                '',
                $this->admin->getExercicio()
            );
        }
    }

    /**
     * @param $request
     * @param $em
     *
     * @return array
     */
    public function retornaContratos($request, $em)
    {
        if ($request->all_elements == 'on') {
            $filter = $this->admin->getRequest()->request->get('filter');
            /** @var ConcessaoDecimoModel $concessaoDecimoModel */
            $concessaoDecimoModel = new ConcessaoDecimoModel($em);

            $params['stConfiguracao'] = 'cgm,oo,f,ef,l';
            $params['entidade'] = '';
            $params['exercicio'] = $this->admin->getExercicio();

            /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
            $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
            $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();


            $situacao = (isset($filter['folha']['value']) && $filter['folha']['value'] == 0) ? 'false' : 'true';

            /** @var PeriodoMovimentacao $periodoFinal */
            $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);
            $stFiltro  = " WHERE concessao_decimo.cod_periodo_movimentacao = ".$periodoFinal->getCodPeriodoMovimentacao();
            $stFiltro .= "   AND concessao_decimo.folha_salario IS ".$situacao;

            // FILTRO GERAL
            if (isset($filter['tipo']['value']) && ($filter['tipo']['value'] == 'geral')) {
                unset($filter['lotacao']['value']);
                unset($filter['codContrato']['value']);
                unset($filter['local']['value']);

                $params['stTipoFiltro'] = 'geral';
                $params['stValoresFiltro']  = '1';

                $contratoList = $concessaoDecimoModel->montaRecuperaContratosConcessaoDecimo($periodoFinal->getCodPeriodoMovimentacao());

                foreach ($contratoList as $contrato) {
                    array_push(
                        $contratos,
                        $contrato['cod_contrato']
                    );
                }
            }

            // FILTRO POR LOTAÇÃO
            if ($filter['tipo']['value'] == 'lotacao') {
                if (isset($filter['lotacao']['value'])) {
                    $lotacao = implode(",", $filter['lotacao']['value']);
                } else {

                    /** @var OrganogramaModel $organogramaModel */
                    $organogramaModel = new OrganogramaModel($entityManager);
                    /** @var OrgaoModel $orgaoModel */
                    $orgaoModel = new OrgaoModel($entityManager);

                    $resOrganograma = $organogramaModel->getOrganogramaVigentePorTimestamp();
                    $codOrganograma = $resOrganograma['cod_organograma'];
                    $dataFinal = $resOrganograma['dt_final'];
                    $lotacoes = $orgaoModel->montaRecuperaOrgaos($dataFinal, $codOrganograma);

                    $lotacaoArray = [];
                    foreach ($lotacoes as $lotacao) {
                        $key = $lotacao->cod_orgao;
                        $value = $lotacao->cod_estrutural . " - " . $lotacao->descricao;
                        $lotacaoArray[$value] = $key;
                    }
                    $lotacao = implode(",", $lotacaoArray);
                }

                $params['stTipoFiltro'] = 'lotacao';
                $params['stValoresFiltro']  = $lotacao;

                $arrayContratos = $concessaoDecimoModel->recuperaContratosParaCancelar($params, $stFiltro);
                foreach ($arrayContratos as $contrato) {
                    $contratos[] = $contrato['cod_contrato'];
                }
            }

            // FILTRO POR LOCAL
            if ($filter['tipo']['value'] == 'local') {
                if (isset($filter['local']['value'])) {
                    $local = implode(",", $filter['local']['value']);
                } else {
                    /** @var Local $locais */
                    $locais = $em->getRepository(Local::class)->findAll();
                    foreach ($locais as $local) {
                        $localArray[] = $local->getCodLocal();
                    }
                    $local = implode(",", $localArray);
                }

                $params['stTipoFiltro'] = 'local';
                $params['stValoresFiltro']  = $local;

                $arrayContratos = $concessaoDecimoModel->recuperaContratosParaCancelar($params, $stFiltro);
                foreach ($arrayContratos as $contrato) {
                    $contratos[] = $contrato['cod_contrato'];
                }
            }

            // FILTRO POR MATRICULA
            if ($filter['tipo']['value'] == 'cgm_contrato') {
                if (!empty($filter['codContrato']['value'])) {
                    $contratos = $filter['codContrato']['value'];
                } else {
                    $contratoList = $concessaoDecimoModel->montaRecuperaContratosConcessaoDecimo($periodoFinal->getCodPeriodoMovimentacao());

                    $contratos = array();

                    foreach ($contratoList as $contrato) {
                        array_push(
                            $contratos,
                            $contrato['cod_contrato']
                        );
                    }
                }
                $params['stTipoFiltro'] = 'contrato';
                $params['stValoresFiltro']  = $contratos;
                $contratos = $concessaoDecimoModel->recuperaContratosParaCancelar($params, $stFiltro);
            }
        } else {
            $contratos = $request->idx;
        }

        return $contratos;
    }
}
