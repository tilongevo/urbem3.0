<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Exception;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\DecimoEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\FeriasEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\Fgts;
use Urbem\CoreBundle\Entity\Folhapagamento\PensaoEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia;
use Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamilia;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\FolhaComplementarModel;
use Urbem\CoreBundle\Model\Folhapagamento\LogErroCalculoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoPeriodoModel;
use Urbem\CoreBundle\Model\Folhapagamento\TabelaIrrfModel;
use Urbem\CoreBundle\Model\Organograma\OrganogramaModel;
use Urbem\CoreBundle\Model\Organograma\OrgaoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoModel;

class CalculoSalarioAdminController extends CRUDController
{
    protected $layoutDefaultReport = '/bundles/report/gestaoRH/fontes/RPT/folhaPagamento/report/design/consultaFichaFinanceira.rptdesign';

    /**
     * @param ProxyQueryInterface $selectedModelQuery
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function batchActionCalcularSalario(ProxyQueryInterface $selectedModelQuery)
    {
        $request = $this->admin->getRequest()->request->get('data');
        $request = json_decode($request);

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $container = $this->container;

        $paramsBo["boAtivos"] = true;
        $paramsBo["boAposentados"] = true;
        $paramsBo["boRescindidos"] = false;
        $paramsBo["boPensionistas"] = true;
        $paramsBo["stTipoFolha"] = ContratoModel::TIPO_FOLHA_SALARIO;

        $contratos = $this->retornaContratos($request, $em, $paramsBo);

        $contratoStr = implode($contratos, ',');
        try {
            $message = $this->validaCalculoSalario($em);

            if (!is_null($message)) {
                $this->addFlash('sonata_flash_error', $message);

                return new RedirectResponse(
                    $this->admin->generateUrl('list', $this->admin->getFilterParameters())
                );
            }

            $contratoErrors = $contratosSuccess = [];

            /** @var ContratoModel $contratoModel */
            $contratoModel = new ContratoModel($em);
            $retorno = $contratoModel->calcularFolha($contratoModel::TIPO_FOLHA_SALARIO, $contratos, $this->admin->getExercicio());
            if (isset($retorno['contratoErrors'])) {
                $contratoErrors = $retorno['contratoErrors'];
            }
            if (isset($retorno['contratosSuccess'])) {
                $contratosSuccess = $retorno['contratosSuccess'];
            }
        } catch (Exception $e) {
            throw $e;
            $this->addFlash('sonata_flash_error', $this->admin->trans('label.contratosCalculadosFalha'));

            return new RedirectResponse(
                $this->admin->generateUrl('list', $this->admin->getFilterParameters())
            );
        }

        $this->addFlash('sonata_flash_success', $this->admin->trans('label.contratosCalculadosComSucessoSalario'));

        $contratoErrors = (!empty($contratoErrors)) ?  implode($contratoErrors, ',') : '';
        $contratosSuccess = (!empty($contratosSuccess)) ?  implode($contratosSuccess, ',') : '';

        return new RedirectResponse(
            $this->admin->generateUrl(
                'show',
                [
                    'id' => $contratos[0],
                    'codContratos' => $contratoStr,
                    'errors' => $contratoErrors,
                    'success' => $contratosSuccess
                ]
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function recalcularAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $codPeriodoMovimentacao = $periodoFinal->getCodPeriodoMovimentacao();

        /** @var LogErroCalculoModel $logErroCalculoModel */
        $logErroCalculoModel = new LogErroCalculoModel($em);

        $stFiltro = " AND cod_periodo_movimentacao = ".$codPeriodoMovimentacao;
        $orderBy = " nom_cgm,numcgm";
        $contratoListErrors = $logErroCalculoModel->recuperaErrosDoContrato($stFiltro, $orderBy);

        foreach ($contratoListErrors as $contrato) {
            $contratos[] = $contrato->cod_contrato;
        }

        $contratoErrors = $contratosSuccess = $contratoStr = [];

        if (!empty($contratos)) {
            /** @var ContratoModel $contratoModel */
            $contratoModel = new ContratoModel($em);
            $retorno = $contratoModel->calcularFolha($contratoModel::TIPO_FOLHA_SALARIO, $contratos, $this->admin->getExercicio());
            if (isset($retorno['contratoErrors'])) {
                $contratoErrors = $retorno['contratoErrors'];
            }
            if (isset($retorno['contratosSuccess'])) {
                $contratosSuccess = $retorno['contratosSuccess'];
            }

            $contratoErrors = (!empty($contratoErrors)) ? implode($contratoErrors, ',') : '';
            $contratosSuccess = (!empty($contratosSuccess)) ? implode($contratosSuccess, ',') : '';
        }

        $this->addFlash('sonata_flash_success', $this->admin->trans('label.contratosCalculadosComSucessoSalario'));
        return new RedirectResponse(
            $this->admin->generateUrl(
                'show',
                [
                    'id' => 1,
                    'codContratos' => $contratoStr,
                    'errors' => $contratoErrors,
                    'success' => $contratosSuccess
                ]
            )
        );
    }

    /**
     * @return null|string
     */
    public function validaCalculoSalario(EntityManager $em)
    {
        $message = null;

        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        //VERIFICA SE EXISTE CÁLCULO DE PENSÃO ALIMENTÍCIA CONFIGURADA
        /** @var PensaoEvento $pensaoEvento */
        $pensaoEvento = $em->getRepository(PensaoEvento::class)->findAll();

        if (empty($pensaoEvento)) {
            $message = 'Configuração do Cálculo de Pensão Alimentícia inexistente!';
        }

        //VERIFICA SE EXISTE CÁLCULO DE FÉRIAS
        /** @var FeriasEvento $feriasEvento */
        $feriasEvento = $em->getRepository(FeriasEvento::class)->findAll();

        if (empty($feriasEvento)) {
            $message = 'Configuração do Cálculo de Férias inexistente!';
        }

        //VERIFICA SE EXISTE CÁLCULO DE 13º
        /** @var DecimoEvento $decimoEvento */
        $decimoEvento = $em->getRepository(DecimoEvento::class)->findAll();

        if (empty($decimoEvento)) {
            $message = 'Configuração Cálculo de 13º Salário inexistente!';
        }

        //VERIFICA SE O CÁLCULO PREVIDÊNCIA ESTÁ EM VIGÊNCIA
        /** @var PrevidenciaPrevidencia $previdenciaPrevidencia */
        $previdenciaPrevidencia = $em->getRepository(PrevidenciaPrevidencia::class)->findAll();
        $previdenciaPrevidencia = end($previdenciaPrevidencia);

        if ($previdenciaPrevidencia->getVigencia() > $periodoFinal->getDtFinal() || $previdenciaPrevidencia->getVigencia() == "" || is_null($previdenciaPrevidencia)) {
            $message = "Configuração da Previdência inexistente ou não está em vigor para competência!";
        }

        //VERIFICA SE O CÁLCULO PREVIDÊNCIA ESTÁ EM VIGÊNCIA
        /** @var SalarioFamilia $salarioFamilia */
        $salarioFamilia = $em->getRepository(SalarioFamilia::class)->findAll();
        $salarioFamilia = end($salarioFamilia);

        if ($salarioFamilia->getVigencia() > $periodoFinal->getDtFinal() || $salarioFamilia->getVigencia() == "" || is_null($salarioFamilia)) {
            $message = "Configuração do Salário Família inexistente ou não está em vigor para competência!";
        }

        //VERIFICA SE O CÁLCULO IRRF ESTÁ EM VIGOR
        /** @var TabelaIrrfModel $tabelaIrrfModel */
        $tabelaIrrfModel = new TabelaIrrfModel($em);
        $tabelaIrrf = $tabelaIrrfModel->montaRecuperaUltimaVigencia();

        if ($tabelaIrrf[0]->vigencia > $periodoFinal->getDtFinal() || $tabelaIrrf[0]->vigencia == "" || is_null($tabelaIrrf[0])) {
            $message = "Configuração da Tabela IRRF inexistente ou não está em vigor para competência!";
        }

        //VERIFICA SE O CÁLCULO DO FGTS ESTÁ EM VIGOR
        /** @var Fgts $pagamentoFgts */
        $pagamentoFgts = $em->getRepository(Fgts::class)->findAll();
        $pagamentoFgts = end($pagamentoFgts);

        if ($pagamentoFgts->getVigencia() > $periodoFinal->getDtFinal() || $pagamentoFgts->getVigencia() == "" || is_null($pagamentoFgts)) {
            $message = "Configuração do FGTS inexistente ou não está em vigor para competência!";
        }

        return $message;
    }

    /**
     * @param ProxyQueryInterface $selectedModelQuery
     *
     * @return RedirectResponse
     */
    public function batchActionCalcularFerias(ProxyQueryInterface $selectedModelQuery)
    {
        $request = $this->admin->getRequest()->request->get('data');
        $request = json_decode($request);

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $contratos = $request->idx;

        $contratoStr = implode($contratos, ',');

        try {
            //Contratos selecionados pelo usuário
            $contratos = $request->idx;

            /** @var ContratoModel $contratoModel */
            $contratoModel = new ContratoModel($em);
            $contratoModel->calcularFolha($contratoModel::TIPO_FOLHA_FERIAS, $contratos, $this->admin->getExercicio());
        } catch (Exception $e) {
            $this->addFlash('sonata_flash_error', $this->admin->trans('label.contratosCalculadosFalha'));

            return new RedirectResponse(
                $this->admin->generateUrl('list', $this->admin->getFilterParameters())
            );
        }

        $this->addFlash('sonata_flash_success', $this->admin->trans('label.contratosCalculadosSucesso'));

        return new RedirectResponse(
            $this->admin->generateUrl('show', ['id' => $contratos[0], 'codContratos' => $contratoStr])
        );
    }

    /**
     * @param ProxyQueryInterface $selectedModelQuery
     *
     * @return RedirectResponse
     */
    public function batchActionCalcularDecimo(ProxyQueryInterface $selectedModelQuery)
    {
        $request = $this->admin->getRequest()->request->get('data');
        $request = json_decode($request);

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $paramsBo["boAtivos"] = true;
        $paramsBo["boAposentados"] = true;
        $paramsBo["boRescindidos"] = false;
        $paramsBo["boPensionistas"] = true;
        $paramsBo["stTipoFolha"] = ContratoModel::TIPO_FOLHA_DECIMO;

        $contratos = $this->retornaContratosDecimo($request, $em, $paramsBo);

        if (!empty($contratos)) {
            foreach ($contratos as $contrato) {
                $contratoArray[] = (is_numeric($contrato)) ? $contrato : $contrato['cod_contrato'];
            }
        }
        $contratoStr = implode(",", $contratoArray);

        try {
            $inMesPagamentoSaldo = $inMesCompetencia = 0;

            $configuracaoModel = new ConfiguracaoModel($em);
            $inMesPagamentoSaldo = (int) $configuracaoModel->getConfiguracao(
                'mes_calculo_decimo',
                27,
                true
            );

            /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
            $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
            $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
            /** @var PeriodoMovimentacao $periodoFinal */
            $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);
            $inMesCompetencia = (int) $periodoFinal->getDtFinal()->format('m');

            $desdobramento = [];

            if ($inMesCompetencia == 12) {
                $desdobramento = ['D', 'C'];
            } elseif ($inMesCompetencia < $inMesPagamentoSaldo) {
                $desdobramento = ['A'];
            } elseif ($inMesCompetencia == $inMesPagamentoSaldo) {
                $desdobramento = ['D'];
            }

            /** @var ContratoModel $contratoModel */
            $contratoModel = new ContratoModel($em);

            $retorno = $contratoModel->calcularFolhaDesdobramento($desdobramento, $contratoModel::TIPO_FOLHA_DECIMO, $contratoArray, $this->admin->getExercicio());
            if (isset($retorno['contratoErrors'])) {
                $contratoErrors = $retorno['contratoErrors'];
            }
            if (isset($retorno['contratosSuccess'])) {
                $contratosSuccess = $retorno['contratosSuccess'];
            }
        } catch (Exception $e) {
            $this->addFlash('sonata_flash_error', $this->admin->trans('label.contratosCalculadosFalha'));

            return new RedirectResponse(
                $this->admin->generateUrl('list', $this->admin->getFilterParameters())
            );
        }

        $this->addFlash('sonata_flash_success', $this->admin->trans('label.contratosCalculadosSucesso13'));

        $contratoErrors = (!empty($contratoErrors)) ?  implode($contratoErrors, ',') : '';
        $contratosSuccess = (!empty($contratosSuccess)) ?  implode($contratosSuccess, ',') : '';

        return new RedirectResponse(
            $this->admin->generateUrl(
                'show',
                [
                    'id' => $contratoArray[0],
                    'codContratos' => $contratoStr,
                    'errors' => $contratoErrors,
                    'success' => $contratosSuccess,
                ]
            )
        );
    }


    /**
     * @param ProxyQueryInterface $selectedModelQuery
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function batchActionCalcularRescisao(ProxyQueryInterface $selectedModelQuery)
    {
        $request = $this->admin->getRequest()->request->get('data');
        $request = json_decode($request);

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $contratos = $request->idx;

        $contratoStr = implode($contratos, ',');
        try {
            $contratoErrors = $contratosSuccess = [];

            //Contratos selecionados pelo usuário
            $contratos = $request->idx;

            /** @var ContratoModel $contratoModel */
            $contratoModel = new ContratoModel($em);
            $retorno = $contratoModel->calcularFolha($contratoModel::TIPO_FOLHA_RESCISAO, $contratos, $this->admin->getExercicio());
            if (isset($retorno['contratoErrors'])) {
                $contratoErrors = $retorno['contratoErrors'];
            }
            if (isset($retorno['contratosSuccess'])) {
                $contratosSuccess = $retorno['contratosSuccess'];
            }
        } catch (Exception $e) {
            throw $e;
            $this->addFlash('sonata_flash_error', $this->admin->trans('label.contratosCalculadosFalha'));

            return new RedirectResponse(
                $this->admin->generateUrl('list', $this->admin->getFilterParameters())
            );
        }

        $this->addFlash('sonata_flash_success', 'Contratos recebidos com sucesso');

        $contratoErrors = (!empty($contratoErrors)) ?  implode($contratoErrors, ',') : '';
        $contratosSuccess = (!empty($contratosSuccess)) ?  implode($contratosSuccess, ',') : '';

        return new RedirectResponse(
            $this->admin->generateUrl(
                'show',
                [
                    'id' => $contratos[0],
                    'codContratos' => $contratoStr,
                    'errors' => $contratoErrors,
                    'success' => $contratosSuccess,
                    'inCodAcao' => 1667
                ]
            )
        );
    }

    /**
     * @param Request $request
     */
    public function geraRelatorioFichaFinanceiraAction(Request $request)
    {
        $codPeriodoMovimentacao = $this->getRequest()->get('codPeriodoMovimentacao');
        $codContratos = $this->getRequest()->get('codContratos');
        $stCompetencia = $this->getRequest()->get('stCompetencia');
        $inCodConfiguracao = $this->getRequest()->get('inCodConfiguracao');
        $inCodAcao = $this->getRequest()->get('inCodAcao');
        $fileName = $this->admin->parseNameFile('consultaFichaFinanceira');
        $params = [
            'term_user' => 'suporte',
            'cod_acao' => (string) $inCodAcao,
            'exercicio' => (string) $this->admin->getExercicio(),
            'inCodGestao' => (string) Gestao::GESTAO_RECURSOS_HUMANOS,
            'inCodModulo' => (string) ConfiguracaoModel::MODULO_RH_FOLHAPAGAMENTO,
            'inCodRelatorio' => '10',
            'stEntidade' => '',
            'entidade' => '2',
            'stTipoFiltro' => 'contrato',
            'stCodigos' => (string) $codContratos,
            'inCodPeriodoMovimentacao' => (string) $codPeriodoMovimentacao,
            'stCompetencia' => (string) $stCompetencia,
            'inCodConfiguracao' => (string) $inCodConfiguracao,
            'inCodComplementar' => '0',
            'stOrdenacaoEventos' => 'codigo',
        ];

        $apiService = $this->admin->getReportService();
        $apiService->setReportNameFile($fileName);
        $apiService->setLayoutDefaultReport($this->layoutDefaultReport);
        $res = $apiService->getReportContent($params);

        $this->admin->parseContentToPdf(
            $res->getBody()->getContents(),
            $fileName
        );
    }

    /**
     * @param ProxyQueryInterface $selectedModelQuery
     *
     * @return RedirectResponse
     */
    public function batchActionConsultaRegistroEventos(ProxyQueryInterface $selectedModelQuery)
    {
        $request = $this->admin->getRequest()->request->get('data');
        $request = json_decode($request);

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $contratos = $request->idx;

        $contratoStr = implode($contratos, ',');

        $this->addFlash('sonata_flash_success', $this->admin->trans('label.contratosCalculadosSucesso'));

        return new RedirectResponse(
            $this->admin->generateUrl('show', ['id' => $contratos[0], 'codContratos' => $contratoStr])
        );
    }

    /**
     * @param $request
     * @param EntityManager $em
     * @param $paramsBo
     *
     * @return array
     */
    public function retornaContratos($request, $em, $paramsBo)
    {
        $filter = $this->admin->getRequest()->request->get('filter');
        /** @var ContratoModel $contratoModel */
        $contratoModel = new ContratoModel($em);

        /** @var RegistroEventoPeriodoModel $registroEventoPeriodoModel */
        $registroEventoPeriodoModel = new RegistroEventoPeriodoModel($em);

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);
        $contratos = [];
        if ($request->all_elements == 'on') {
            // FILTRO GERAL
            if (isset($filter['tipo']['value']) && ($filter['tipo']['value'] == 'geral')) {
                $contratoList = $registroEventoPeriodoModel->montaRecuperaContratosAutomaticos($periodoFinal->getCodPeriodoMovimentacao());

                foreach ($contratoList as $contrato) {
                    array_push(
                        $contratos,
                        $contrato->cod_contrato
                    );
                }
            }

            // FILTRO POR LOTAÇÃO
            if ($filter['tipo']['value'] == 'lotacao') {
                if (isset($filter['lotacao']['value'])) {
                    $contratos = implode(",", $filter['lotacao']['value']);
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

                    $contratosArray = $contratoModel->montaRecuperaContratosCalculoFolha(
                        $paramsBo,
                        $periodoFinal->getCodPeriodoMovimentacao(),
                        '',
                        [],
                        $lotacaoArray,
                        []
                    );

                    foreach ($contratosArray as $contrato) {
                        array_push(
                            $contratos,
                            $contrato['cod_contrato']
                        );
                    }
                }
            }

            // FILTRO POR LOCAL
            if (isset($filter['local']['value'])) {
                $contratosArray = $contratoModel->montaRecuperaContratosCalculoFolha(
                    $paramsBo,
                    $periodoFinal->getCodPeriodoMovimentacao(),
                    '',
                    $filter['local']['value'],
                    [],
                    []
                );

                foreach ($contratosArray as $contrato) {
                    array_push(
                        $contratos,
                        $contrato['cod_contrato']
                    );
                }
            }

            // FILTRO POR EVENTO
            if (!empty($filter['evento']['value'])) {
                $contratosArray = $contratoModel->montaRecuperaContratosCalculoFolha(
                    $paramsBo,
                    $periodoFinal->getCodPeriodoMovimentacao(),
                    '',
                    [],
                    [],
                    $filter['evento']['value']
                );

                foreach ($contratosArray as $contrato) {
                    array_push(
                        $contratos,
                        $contrato['cod_contrato']
                    );
                }
            }

            // FILTRO POR MATRICULA
            if ($filter['tipo']['value'] == 'cgm_contrato') {
                if (!empty($filter['codContrato']['value'])) {
                    $contratoSelected = $filter['codContrato']['value'];
                    foreach ($contratoSelected as $contrato) {
                        $filtro = " AND contrato.cod_contrato = $contrato";
                        $cgm = $contratoModel->recuperaCgmDoRegistro($filtro);
                        array_push(
                            $contratos,
                            $cgm[0]['numcgm']
                        );
                    }
                } else {
                    $contratoList = $entityManager->getRepository("CoreBundle:Pessoal\Contrato")
                        ->getContratoNotRescindido('');

                    foreach ($contratoList as $contrato) {
                        $filtro = " AND contrato.registro = $contrato->getRegistro()";
                        $cgm = $contratoModel->recuperaCgmDoRegistro($filtro);
                        array_push(
                            $contratos,
                            $cgm[0]['numcgm']
                        );
                    }
                }

                $contratos = implode(",", $contratos);
                $contratoList = $registroEventoPeriodoModel->montaRecuperaContratosAutomaticos($periodoFinal->getCodPeriodoMovimentacao(), $contratos);
                $contratos = [];
                foreach ($contratoList as $contrato) {
                    array_push(
                        $contratos,
                        $contrato['cod_contrato']
                    );
                }
            }
        } else {
            $contratos = $request->idx;
        }

        return $contratos;
    }

    public function retornaContratosDecimo($request, $em, $paramsBo)
    {
        $filter = $this->admin->getRequest()->request->get('filter');
        /** @var ContratoModel $contratoModel */
        $contratoModel = new ContratoModel($em);

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);
        $contratos = [];
        if ($request->all_elements == 'on') {
            // FILTRO GERAL
            if (isset($filter['tipo']['value']) && ($filter['tipo']['value'] == 'geral')) {
                $contratoList = $contratoModel->montaRecuperaContratosCalculoFolha(
                    $paramsBo,
                    $periodoFinal->getCodPeriodoMovimentacao(),
                    '',
                    [],
                    [],
                    []
                );

                foreach ($contratoList as $contrato) {
                    $contratos[] =  $contrato['cod_contrato'];
                }
            }

            // FILTRO POR LOTAÇÃO
            if ($filter['tipo']['value'] == 'lotacao') {
                if (isset($filter['lotacao']['value'])) {
                    $contratos = implode(",", $filter['lotacao']['value']);
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

                    $contratosArray = $contratoModel->montaRecuperaContratosCalculoFolha(
                        $paramsBo,
                        $periodoFinal->getCodPeriodoMovimentacao(),
                        '',
                        [],
                        $lotacaoArray,
                        []
                    );

                    foreach ($contratosArray as $contrato) {
                        array_push(
                            $contratos,
                            $contrato['cod_contrato']
                        );
                    }
                }
            }

            // FILTRO POR LOCAL
            if (isset($filter['local']['value'])) {
                $contratosArray = $contratoModel->montaRecuperaContratosCalculoFolha(
                    $paramsBo,
                    $periodoFinal->getCodPeriodoMovimentacao(),
                    '',
                    $filter['local']['value'],
                    [],
                    []
                );

                foreach ($contratosArray as $contrato) {
                    array_push(
                        $contratos,
                        $contrato['cod_contrato']
                    );
                }
            }

            // FILTRO POR EVENTO
            if (!empty($filter['evento']['value'])) {
                $contratosArray = $contratoModel->montaRecuperaContratosCalculoFolha(
                    $paramsBo,
                    $periodoFinal->getCodPeriodoMovimentacao(),
                    '',
                    [],
                    [],
                    $filter['evento']['value']
                );

                foreach ($contratosArray as $contrato) {
                    array_push(
                        $contratos,
                        $contrato['cod_contrato']
                    );
                }
            }

            // FILTRO POR MATRICULA
            if ($filter['tipo']['value'] == 'cgm_contrato') {
                if (!empty($filter['codContrato']['value'])) {
                    $contratos = $filter['codContrato']['value'];
                } else {
                    $contratoList = $contratoModel->montaRecuperaContratosCalculoFolha(
                        $paramsBo,
                        $periodoFinal->getCodPeriodoMovimentacao(),
                        '',
                        [],
                        [],
                        []
                    );

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
