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

class ConcederDecimoAdminController extends CRUDController
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
        $action = $this->getRequest()->request->get('action');
        $template = null;
        if ($action == 'concederDecimo') {
            $template = 'RecursosHumanosBundle:Sonata:FolhaPagamento/CalculoDecimo/CRUD/concederDecimo.html.twig';
        } else {
            $template = 'RecursosHumanosBundle:Sonata:FolhaPagamento/CalculoDecimo/CRUD/cancelarDecimo.html.twig';
        }

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
     */
    public function batchActionConcederDecimo()
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

        /** @var ConcessaoDecimoModel $concessaoDecimoModel */
        $concessaoDecimoModel = new ConcessaoDecimoModel($em);
        $rsContratos = $concessaoDecimoModel->montaRecuperaContratosConcessaoDecimo($periodoFinal->getCodPeriodoMovimentacao());
        $contratosArray = $arContratosErro = $arContratos = [];

        foreach ($contratos as $contrato) {
            foreach ($rsContratos as $key => $rsContrato) {
                if ($rsContrato['cod_contrato'] == $contrato) {
                    $contratosArray[] = $rsContrato;
                }
            }
        }

        try {
            if ($concessao['desdobramento'] == 'C') {
                $stFiltro = " AND ultimo_registro_evento_decimo.desdobramento = 'D'";
                $stFiltro .= " AND registro_evento_decimo.cod_periodo_movimentacao = " . $periodoFinal->getCodPeriodoMovimentacao();

                /** @var UltimoRegistroEventoDecimoModel $ultimoRegistroEventoDecimoModel */
                $ultimoRegistroEventoDecimoModel = new UltimoRegistroEventoDecimoModel($em);
                $rsUltimoRegistro = $ultimoRegistroEventoDecimoModel->montaRecuperaRegistrosDeEventoSemCalculo($stFiltro);
                if (!empty($rsUltimoRegistro)) {
                    $arContratosErro[] = $rsUltimoRegistro["cod_contrato"];
                    $arContratosErro = implode($arContratosErro, ',');
                    $arContratos = implode($arContratos, ',');

                    $arContratosErro = (empty($arContratosErro)) ? 0 : $arContratosErro;
                    $arContratos = (empty($arContratos)) ? 0 : $arContratos;
                    $this->addFlash('sonata_flash_success', $this->trans('label.concessao13Sucesso'));

                    return new RedirectResponse(
                        $this->admin->generateUrl('show', ['id' => $contratos[0], 'codContratos' => $arContratos, 'contratosErro' => $arContratosErro])
                    );
                }
            }

            foreach ($contratosArray as $contrato) {
                $filtro = " WHERE cod_contrato = " . $contrato["cod_contrato"];
                $filtro .= "   AND cod_periodo_movimentacao <= " . $periodoFinal->getCodPeriodoMovimentacao();
                $filtro .= "   AND cod_periodo_movimentacao >= " . $periodoFinal->getCodPeriodoMovimentacao();
                $filtro .= "   AND desdobramento = '" . $concessao['desdobramento'] . "'";

                $rsConcessao = $concessaoDecimoModel->montaRecuperaTodos($filtro);

                if (empty($rsConcessao)) {
                    $arContratos[] = $contrato["cod_contrato"];

                    /** @var Contrato $contratoObject */
                    $contratoObject = $em->getRepository(Contrato::class)->findOneBy(
                        [
                            'codContrato' => $contrato['cod_contrato']
                        ]
                    );

                    /** @var ConcessaoDecimo $concessaoDecimo */
                    $concessaoDecimo = new ConcessaoDecimo();
                    $concessaoDecimo->setFkPessoalContrato($contratoObject);
                    $concessaoDecimo->setFkFolhapagamentoPeriodoMovimentacao($periodoFinal);
                    $concessaoDecimo->setDesdobramento($concessao['desdobramento']);

                    $folhaSalario = ($concessao['folha_salario'] == 0) ? false : true;
                    $concessaoDecimo->setFolhaSalario($folhaSalario);

                    /** @var ConfiguracaoAdiantamento $configuracaoAdiantamento */
                    $configuracaoAdiantamento = new ConfiguracaoAdiantamento();
                    $configuracaoAdiantamento->setFkFolhapagamentoConcessaoDecimo($concessaoDecimo);
                    $configuracaoAdiantamento->setVantagensFixas($concessao['vantagens_fixas']);
                    $configuracaoAdiantamento->setPercentual(str_replace(",", ".", $concessao['percentual']));
                    $concessaoDecimo->setFkFolhapagamentoConfiguracaoAdiantamento($configuracaoAdiantamento);

                    $vantagensFixas = ($concessao['vantagens_fixas'] == 0) ? false : true;
                    $configuracaoAdiantamento->setVantagensFixas($vantagensFixas);
                    $concessaoDecimoModel->save($concessaoDecimo);

                    if ($concessao['desdobramento'] == 'A') {
                        $concessaoDecimoModel->montaGeraRegistroDecimo(
                            $contrato['cod_contrato'],
                            $periodoFinal->getCodPeriodoMovimentacao(),
                            $concessao['desdobramento'],
                            ''
                        );
                    }
                } else {
                    $arContratosErro[] = $contrato["cod_contrato"];
                }
            }

            $arContratosErro = implode($arContratosErro, ',');
            $arContratos = implode($arContratos, ',');

            $arContratosErro = (empty($arContratosErro)) ? 0 : $arContratosErro;
            $arContratos = (empty($arContratos)) ? 0 : $arContratos;
        } catch (Exception $e) {
            $this->addFlash('sonata_flash_error', $this->admin->trans('label.contratosCalculadosFalha'));

            return new RedirectResponse(
                $this->admin->generateUrl('list', $this->admin->getFilterParameters())
            );
        }

        $this->addFlash('sonata_flash_success', $this->trans('label.concessao13Sucesso'));

        return new RedirectResponse(
            $this->admin->generateUrl('show', ['id' => $contratos[0], 'codContratos' => $arContratos, 'contratosErro' => $arContratosErro])
        );
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
        $stCodContratos = "";
        $stCodContratos = implode($contratos, ',');
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
            /** @var ContratoModel $contratoModel */
            $contratoModel = new ContratoModel($em);
            /** @var ConcessaoDecimoModel $concessaoDecimoModel */
            $concessaoDecimoModel = new ConcessaoDecimoModel($em);

            /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
            $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
            $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
            /** @var PeriodoMovimentacao $periodoFinal */
            $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

            $contratos = [];

            // FILTRO GERAL
            if (isset($filter['tipo']['value']) && ($filter['tipo']['value'] == 'geral')) {
                $arrayContratos = $concessaoDecimoModel->montaRecuperaContratosConcessaoDecimo($periodoFinal->getCodPeriodoMovimentacao());
                foreach ($arrayContratos as $contrato) {
                    $contratos[] = $contrato['cod_contrato'];
                }
            }

            // FILTRO POR LOTAÇÃO
            if ($filter['tipo']['value'] == 'lotacao') {
                if (isset($filter['lotacao']['value'])) {
                    $lotacao = implode(",", $filter['lotacao']['value']);
                } else {
                    /** @var OrganogramaModel $organogramaModel */
                    $organogramaModel = new OrganogramaModel($em);
                    /** @var OrgaoModel $orgaoModel */
                    $orgaoModel = new OrgaoModel($em);

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

                $arrayContratos = $concessaoDecimoModel->montaRecuperaContratosConcessaoDecimo($periodoFinal->getCodPeriodoMovimentacao(), $lotacao);
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

                $arrayContratos = $concessaoDecimoModel->montaRecuperaContratosConcessaoDecimo($periodoFinal->getCodPeriodoMovimentacao(), false, $local);
                foreach ($arrayContratos as $contrato) {
                    $contratos[] = $contrato['cod_contrato'];
                }
            }

            //FILTRO POR MATRICULA
            if ($filter['tipo']['value'] == 'cgm_contrato') {
                if (!empty($filter['codContrato']['value'])) {
                    $contratos = $filter['codContrato']['value'];
                } else {
                    $contratoList = $concessaoDecimoModel->montaRecuperaContratosConcessaoDecimo($periodoFinal->getCodPeriodoMovimentacao());

                    $contratos = [];

                    foreach ($contratoList as $contrato) {
                        array_push(
                            $contratos,
                            $contrato['cod_contrato']
                        );
                    }
                }
            }
        } else {
            $contratos = $request->idx;
        }

        return $contratos;
    }
}
