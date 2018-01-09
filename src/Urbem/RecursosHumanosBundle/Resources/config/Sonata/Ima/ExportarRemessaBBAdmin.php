<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Ima;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbLocal;
use Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbOrgao;
use Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBb;
use Urbem\CoreBundle\Entity\Ima\Recolhimento;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Economico\CnaeFiscalModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoCalculadoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Ima\ConfiguracaoBbContaModel;
use Urbem\CoreBundle\Resources\config\Sonata\Filter\Pessoal\GeneralFilterAdmin;
use ZipArchive;

class ExportarRemessaBBAdmin extends GeneralFilterAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_ima_exportar_remessa_bb';
    protected $baseRoutePattern = 'recursos-humanos/ima/exportar-remessa-bb';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Exportar Arquivo'];
    protected $includeJs = array('/recursoshumanos/javascripts/ima/exportarRemessaBB.js');

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('detalhe', 'detalhe');
        $collection->add('report', 'report/{id}');
        $collection->add('download', 'download/{id}');
        $collection->add('carrega_contas_convenio', 'carrega-contas-convenio');
        $collection->clearExcept(array('create', 'detalhe', 'report', 'download', 'carrega_contas_convenio'));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        /** @var PeriodoMovimentacaoModel $periodoMovimentacaoModel */
        $periodoMovimentacaoModel = new PeriodoMovimentacaoModel($entityManager);

        /** @var ConfiguracaoModel $configuracaoModel */
        $configuracaoModel = new ConfiguracaoModel($entityManager);

        /** @var ConfiguracaoConvenioBb $configuracaoConvenioBB */
        $configuracaoConvenioBB = array_shift($entityManager->getRepository(ConfiguracaoConvenioBb::class)->findAll());

        $exercicio = $this->getExercicio();

        $rsUltimaMovimentacao = $periodoMovimentacaoModel->montaRecuperaUltimaMovimentacao();
        $arPeriodoMovimentacaoAtual = explode("/", $rsUltimaMovimentacao['dt_final']);
        $dtPeriodoMovimentacaoAtual = $arPeriodoMovimentacaoAtual[2] . $arPeriodoMovimentacaoAtual[1];

        $arDataConfiguracao = $configuracaoModel->getConfiguracao('dt_num_sequencial_arquivo_bb', Modulo::MODULO_IMA, true, $exercicio);

        $arDataConfiguracao = explode("-", $arDataConfiguracao);
        $dtConfiguracao = $arDataConfiguracao[0] . $arDataConfiguracao[1];

        if ($dtPeriodoMovimentacaoAtual > $dtConfiguracao) {
            $inNumeroSequencial = 1;
        } else {
            $inNumeroSequencial = $configuracaoModel->getConfiguracao('num_sequencial_arquivo_bb', Modulo::MODULO_IMA, true, $exercicio);
        }

        $fieldOptions = [];
        $fieldOptions['stSituacao'] = [
            'choices' => [
                'Ativos' => 'ativos',
                'Rescindidos' => 'rescindidos',
                'Aposentados' => 'aposentados',
                'Pensionistas' => 'pensionistas',
                'Todos' => 'todos'
            ],
            'label' => 'label.recursosHumanos.ima.cadastro',
            'expanded' => false,
            'multiple' => false,
            'attr' => ['class' => 'select2-parameters'],
            'mapped' => false,
            'data' => 'ativos',
        ];

        $fieldOptions['tipoCalculo'] = [
            'choices' => [
                'Complementar' => 0,
                'Salário' => 1,
                'Férias' => 2,
                '13o Salário' => 3,
                'Rescisao' => 4,
            ],
            'label' => 'label.recursosHumanos.ima.tipoCalculo',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'mapped' => false,
            'data' => 1
        ];

        $fieldOptions['ano'] = [
            'label' => 'label.ferias.ano',
            'mapped' => false,
            'attr' => [
                'value' => $this->getExercicio(),
                'class' => 'numero '
            ],
        ];

        $mes = $periodoMovimentacaoModel->getMesCompetenciaFolhaPagamento($this->getExercicio());

        $fieldOptions['mes'] = [
            'label' => 'label.ferias.mes',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'choices' => $mes,
            'data' => (is_array($mes)) ? end($mes) : $mes,
            'attr' => [
                'data-mes' => (is_array($mes)) ? end($mes) : $mes,
            ],
            'attr' => ['class' => 'select2-parameters '],
        ];

        $fieldOptions['nuValorLiquidoInicial'] = [
            'label' => 'label.recursosHumanos.ima.nuValorLiquidoInicial',
            'mapped' => false,
            'attr' => [
                'class' => 'money '
            ],
            'data' => '0,01'
        ];

        $fieldOptions['nuValorLiquidoFinal'] = [
            'label' => 'label.recursosHumanos.ima.nuValorLiquidoFinal',
            'mapped' => false,
            'attr' => [
                'class' => 'money '
            ],
            'data' => '99.999.999,99'
        ];

        $fieldOptions['nuPercentualPagar'] = [
            'label' => 'label.recursosHumanos.ima.nuPercentualPagar',
            'mapped' => false,
            'attr' => [
                'class' => 'percent ',
                'maxlength' => 6
            ],
            'data' => '100'
        ];

        $fieldOptions['codConvenio'] = [
            'label' => 'label.recursosHumanos.ima.codConvenio',
            'mapped' => false,
            'attr' => [
                'readonly' => 'readonly',
            ],
            'data' => $configuracaoConvenioBB->getCodConvenioBanco(),
        ];

        $today = new \DateTime();

        $fieldOptions['dtGeracaoArquivo'] = [
            'label' => 'label.recursosHumanos.ima.dtGeracaoArquivo',
            'mapped' => false,
            'format' => 'dd/MM/yyyy',
            'data' => $today
        ];

        $fieldOptions['dtPagamento'] = [
            'label' => 'label.recursosHumanos.ima.dtPagamento',
            'mapped' => false,
            'format' => 'dd/MM/yyyy',
            'data' => $today
        ];

        $fieldOptions['inNumeroSequencial'] = [
            'label' => 'label.recursosHumanos.ima.inNumeroSequencial',
            'mapped' => false,
            'attr' => [
                'class' => 'number ',
            ],
            'data' => $inNumeroSequencial
        ];

        $formMapper
            ->with("Filtro")
            ->add('stSituacao', 'choice', $fieldOptions['stSituacao']);
        parent::configureFields($formMapper, ['reg_sub_car_esp_grupo', 'padrao', 'funcao', 'matricula']);
        $formMapper
            ->add('ano', 'number', $fieldOptions['ano'])
            ->add('mes', 'choice', $fieldOptions['mes'])
            ->add('tipoCalculo', 'choice', $fieldOptions['tipoCalculo'])
            ->end();
        $formMapper->with("label.recursosHumanos.ima.informacoesGerais")
            ->add('nuValorLiquidoInicial', 'text', $fieldOptions['nuValorLiquidoInicial'])
            ->add('nuValorLiquidoFinal', 'text', $fieldOptions['nuValorLiquidoFinal'])
            ->add('nuPercentualPagar', 'percent', $fieldOptions['nuPercentualPagar'])
            ->add('codConvenio', 'text', $fieldOptions['codConvenio'])
            ->end();
        $formMapper->with("label.recursosHumanos.ima.grupoContas", [
            'class' => 'col s12 grupoContas box-body'
        ])
            ->end();
        $formMapper->with("label.recursosHumanos.ima.geracaoArquivo")
            ->add('dtGeracaoArquivo', 'sonata_type_date_picker', $fieldOptions['dtGeracaoArquivo'])
            ->add('dtPagamento', 'sonata_type_date_picker', $fieldOptions['dtPagamento'])
            ->add('inNumeroSequencial', 'number', $fieldOptions['inNumeroSequencial'])
            ->end();
    }

    public function prePersist($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        /** @var ConfiguracaoModel $configuracaoModel */
        $configuracaoModel = new ConfiguracaoModel($em);
        $codEntidadePrefeitura = $configuracaoModel->getConfiguracao(
            'cod_entidade_prefeitura',
            Modulo::MODULO_ORCAMENTO,
            true,
            $this->getExercicio()
        );

        /** @var Entidade $entidade */
        $entidade = $em->getRepository(Entidade::class)->findOneBy(
            [
                'codEntidade' => $codEntidadePrefeitura,
                'exercicio' => $this->getExercicio()
            ]
        );

        $form = $this->getForm();
        $inCodComplementar = "";
        $stDesdobramento = "";
        $inNumeroSequencial = $form->get('inNumeroSequencial')->getData();
        $nuValorLiquidoInicial = $form->get('nuValorLiquidoInicial')->getData();
        $nuValorLiquidoFinal = $form->get('nuValorLiquidoFinal')->getData();
        $nuPercentualPagar = $form->get('nuPercentualPagar')->getData();
        $stSituacao = $form->get('stSituacao')->getData();
        $stTipoFiltro = $form->get('tipo')->getData();
        $inCodConfiguracao = $form->get('tipoCalculo')->getData();
//        $stDesdobramento = ($form->get('stDesdobramento')->getData()) ? $form->get('stDesdobramento')->getData() : '';
        $dtPagamento = $form->get('dtPagamento')->getData();
        $dtGeracaoArquivo = $form->get('dtGeracaoArquivo')->getData();
        $inCodBanco = 001;
        $exercicio = $this->getExercicio();

        $inCodMes = ($form->get('mes')->getData() > 9) ? $form->get('mes')->getData() : "0" . $form->get('mes')->getData();

        $dtCompetencia = $inCodMes . "/" . $form->get('ano')->getData();
        $stCompetencia = $inCodMes . $form->get('ano')->getData();

        // COMPETENCIA SELECIONADA
        /** @var PeriodoMovimentacao $periodoMovimentacao */
        $rsPeriodoMovimentacao = $em->getRepository(PeriodoMovimentacao::class)
            ->consultaPeriodoMovimentacaoCompetencia($dtCompetencia);

        /** @var ConfiguracaoConvenioBb $configuracaoConvenioBB */
        $configuracaoConvenioBB = array_shift($em->getRepository(ConfiguracaoConvenioBb::class)->findAll());

        $stFiltro = " WHERE vigencia <= to_date('" . $rsPeriodoMovimentacao["dt_final"] . "','dd/mm/yyyy')";
        $stOrdem = " ORDER BY dt_vigencia DESC LIMIT 1";
        /** @var ConfiguracaoBbContaModel $configuracaoBBContaModel */
        $configuracaoBBContaModel = new ConfiguracaoBbContaModel($em);
        $rsVigencia = $configuracaoBBContaModel->recuperaVigencias($stFiltro, $stOrdem);
        $params['vigencia'] = $rsVigencia->vigencia;
        $rsContas = $configuracaoBBContaModel->recuperaRelacionamento($params);

        /** @var EventoCalculadoModel $eventoCalculadoModel */
        $eventoCalculadoModel = new EventoCalculadoModel($em);

        $zip = new \ZipArchive;
        $date = new \DateTime();
        $arquivoName = sprintf('BB%s.zip', $date->format('Ymdhis'));
        $opened = $zip->open('/tmp/' . $arquivoName, ZipArchive::OVERWRITE | ZipArchive::CREATE);
        $arquivoGerado = false;
        foreach ($rsContas as $rsContasConvenio) {
            //Busca os orgões cadastrados na configuração de cada conta individualmente
            //esses códigos devem ser incluídos no filtro fixo junto com o filtro de banco
            /** @var ConfiguracaoBbOrgao $rsOrgaos */
            $rsOrgaos = $em->getRepository(ConfiguracaoBbOrgao::class)->findBy(
                [
                    "codConvenio" => $rsContasConvenio->cod_convenio,
                    "codAgencia" => $rsContasConvenio->cod_agencia,
                    "codBanco" => $rsContasConvenio->cod_banco,
                    "codContaCorrente" => $rsContasConvenio->cod_conta_corrente,
                    "timestamp" => $rsContasConvenio->timestamp,
                ]
            );

            $stCodOrgaos = "";
            foreach ($rsOrgaos as $orgao) {
                $stCodOrgaos .= $orgao->getCodOrgao() . ",";
            }

            $stCodOrgaos = substr($stCodOrgaos, 0, strlen($stCodOrgaos) - 1);

            /** @var ConfiguracaoBbLocal $rsLocais */
            $rsLocais = $em->getRepository(ConfiguracaoBbLocal::class)->findBy(
                [
                    "codConvenio" => $rsContasConvenio->cod_convenio,
                    "codAgencia" => $rsContasConvenio->cod_agencia,
                    "codBanco" => $rsContasConvenio->cod_banco,
                    "codContaCorrente" => $rsContasConvenio->cod_conta_corrente,
                    "timestamp" => $rsContasConvenio->timestamp,
                ]
            );

            $stCodLocais = "";
            foreach ($rsLocais as $local) {
                $stCodLocais .= $local->getCodLocal() . ",";
            }
            if (strlen($stCodLocais) > 0) {
                $stCodLocais = substr($stCodLocais, 0, strlen($stCodLocais) - 1);
            }
            // EXPORTADOR //

            // Criando objeto que monta arquivo de remessa
            $arConta = $this->separarDigito($rsContasConvenio->num_conta_corrente);
            $stNomeArquivo = "BB" . $arConta[0] . ".TXT";
            $arArquivoDadosExtras[$stNomeArquivo]['descricao'] = $rsContasConvenio->descricao;
            $arArquivoDadosExtras[$stNomeArquivo]['seq'] = $inNumeroSequencial;

//            $obExportador->addArquivo($stNomeArquivo);
//            $obExportador->roUltimoArquivo->setTipoDocumento("RemessaBancoBrasil");
            // COMPETENCIA ATUAL
            /** @var PeriodoMovimentacaoModel $periodoMovimentacaoModel */
            $periodoMovimentacaoModel = new PeriodoMovimentacaoModel($em);
            $rsUltimaMovimentacao = $periodoMovimentacaoModel->montaRecuperaUltimaMovimentacao();

            if ($nuValorLiquidoInicial != "" && $nuValorLiquidoFinal != "") {
                $nuValorLiquidoFinal = str_replace(".", "", $nuValorLiquidoFinal);
                $nuValorLiquidoFinal = str_replace(",", ".", $nuValorLiquidoFinal);

                $nuValorLiquidoInicial = str_replace(".", "", $nuValorLiquidoInicial);
                $nuValorLiquidoInicial = str_replace(",", ".", $nuValorLiquidoInicial);
            }

            if ($nuPercentualPagar != "") {
                $nuPercentualPagar = str_replace(".", "", $nuPercentualPagar);
                $nuPercentualPagar = str_replace(",", ".", $nuPercentualPagar);
            } else {
                $nuPercentualPagar = 0;
            }

            $filtros = $this->processaFiltro($stSituacao, $stTipoFiltro, $stCodLocais, $stCodOrgaos);

            if (in_array($stSituacao, ['ativos', 'aposentados', 'rescindidos', 'pensionistas', 'todos'])) {
                $params = [
                    "inCodPeriodoMovimentacao" => $rsPeriodoMovimentacao['cod_periodo_movimentacao'],
                    "stSituacao" => $stSituacao,
                    "inCodConfiguracao" => $inCodConfiguracao,
                    "inCodComplementar" => ($inCodComplementar == "") ? 0 : $inCodComplementar,
                    "stTipoFiltro" => $stTipoFiltro,
                    "stValoresFiltro" => $filtros['stValoresFiltro'],
                    "stDesdobramento" => $stDesdobramento,
                    "inCodBanco" => $inCodBanco,
                    "nuLiquidoMinimo" => $nuValorLiquidoInicial,
                    "nuLiquidoMaximo" => $nuValorLiquidoFinal,
                    "nuPercentualPagar" => $nuPercentualPagar
                ];

                $rsContratos = $eventoCalculadoModel->recuperaContratosCalculadosRemessaBancos($params, $exercicio, $filtros['stFiltroContrato']);
            }

            if (in_array($stSituacao, ['estagiarios', 'todos'])) {
                $params = [
                    "inCodPeriodoMovimentacao" => $rsPeriodoMovimentacao['cod_periodo_movimentacao'],
                    "stTipoFiltro" => $stTipoFiltro,
                    "inCodBanco" => $inCodBanco,
                    "stValoresFiltro" => $filtros['stValoresFiltro'],
                    "nuLiquidoMinimo" => $nuValorLiquidoInicial,
                    "nuLiquidoMaximo" => $nuValorLiquidoFinal,
                    "nuPercentualPagar" => $nuPercentualPagar
                ];

                $rsEstagios = $eventoCalculadoModel->recuperaContratosCalculadosRemessaBancos($params, $exercicio, $filtros['stFiltroEstagiario']);
            }

            if (in_array($stSituacao, ['pensao_judicial', 'todos'])) {
                $params = [
                    "inCodPeriodoMovimentacao" => $rsPeriodoMovimentacao['cod_periodo_movimentacao'],
                    "inCodConfiguracao" => $inCodConfiguracao,
                    "inCodComplementar" => ($inCodComplementar == "") ? 0 : $inCodComplementar,
                    "stDesdobramento" => $stDesdobramento,
                    "inCodBanco" => $inCodBanco,
                    "nuLiquidoMinimo" => $nuValorLiquidoInicial,
                    "nuLiquidoMaximo" => $nuValorLiquidoFinal,
                    "nuPercentualPagar" => $nuPercentualPagar
                ];

                $rsPensaoJudiciais = $eventoCalculadoModel->recuperaContratosCalculadosRemessaBancos($params, $exercicio, $filtros['stFiltroPensaoJudicial']);
            }

            $arExportador = $arDetalhes = [];
            $inIndex = $nuVlrLancamentoTotal = 0;
            $inNumSequencial = 1;

            if (!empty($rsContratos)) {
                foreach ($rsContratos as $rsContrato) {
                    $arExportador[$inIndex]["banco"] = 1;
                    $arExportador[$inIndex]["lote"] = 1;
                    $arExportador[$inIndex]["registro_detalhe_lote"] = 3;
                    $arExportador[$inIndex]["numero_sequencial"] = $inNumSequencial;
                    $arExportador[$inIndex]["segmento"] = "A";
                    $arExportador[$inIndex]["tipo_movimento"] = 0;
                    $arExportador[$inIndex]["codigo_instrucao"] = 0;
                    $arExportador[$inIndex]["codigo_camera_centralizadora"] = 0;
                    $arExportador[$inIndex]["numero_banco_favorecido"] = $rsContrato->num_banco;
                    $arAgencia = $this->separarDigito($rsContrato->num_agencia);
                    $arExportador[$inIndex]["numero_agencia"] = $arAgencia[0];
                    $arExportador[$inIndex]["digito_agencia"] = $arAgencia[1];
                    $arConta = $this->separarDigito($rsContrato->nr_conta);
                    $arExportador[$inIndex]["nr_conta"] = $arConta[0];
                    $arExportador[$inIndex]["digito_conta"] = $arConta[1];
                    $arExportador[$inIndex]["digito_agencia_conta"] = "";
                    $arExportador[$inIndex]["nome_favorecido"] = $this->removeAcentos($rsContrato->nom_cgm);
                    $arExportador[$inIndex]["nr_documento"] = $rsContrato->registro;
                    $arExportador[$inIndex]["dt_lancamento"] = str_replace("/", "", $dtPagamento);
                    $arExportador[$inIndex]["tipo_moeda"] = "BRL";
                    $arExportador[$inIndex]["quant_moeda"] = 0;

                    $nuVlrLancamento = number_format($rsContrato->liquido, 2, ".", "");
                    $nuVlrLancamentoTotal += $nuVlrLancamento;
                    $nuVlrLancamento = number_format($nuVlrLancamento, 2, "", "");

                    $arExportador[$inIndex]["vlr_lancamento"] = $nuVlrLancamento;
                    $arExportador[$inIndex]["nr_documento_banco"] = "";
                    $arExportador[$inIndex]["dt_real_efetivacao"] = 0;
                    $arExportador[$inIndex]["vl_real_efetivacao"] = 0;
                    $arExportador[$inIndex]["outras_informacoes"] = "";
                    $arExportador[$inIndex]["cnab"] = "";
                    $arExportador[$inIndex]["aviso_favorecido"] = "";
                    $arExportador[$inIndex]["ocorrencias"] = "";

                    $arDetalhesArquivo = $this->geraDetalheArquivo($arExportador[$inIndex]);
                    $arDetalhes[] = $this->formataDetalheArquivo($arDetalhesArquivo, $inIndex);
                    $inIndex++;
                    $inNumSequencial++;
                }
            }

            if (!empty($rsEstagios)) {
                foreach ($rsEstagios as $rsEstagio) {
                    $arExportador[$inIndex]["banco"] = 1;
                    $arExportador[$inIndex]["lote"] = 1;
                    $arExportador[$inIndex]["registro_detalhe_lote"] = 3;
                    $arExportador[$inIndex]["numero_sequencial"] = $inNumSequencial;
                    $arExportador[$inIndex]["segmento"] = "A";
                    $arExportador[$inIndex]["tipo_movimento"] = 0;
                    $arExportador[$inIndex]["codigo_instrucao"] = 0;
                    $arExportador[$inIndex]["codigo_camera_centralizadora"] = 0;
                    $arExportador[$inIndex]["numero_banco_favorecido"] = $rsEstagio->num_banco;
                    $arAgencia = $this->separarDigito($rsEstagio->num_agencia);
                    $arExportador[$inIndex]["numero_agencia"] = $arAgencia[0];
                    $arExportador[$inIndex]["digito_agencia"] = $arAgencia[1];
                    $arConta = $this->separarDigito($rsEstagio->num_conta);
                    $arExportador[$inIndex]["nr_conta"] = $arConta[0];
                    $arExportador[$inIndex]["digito_conta"] = $arConta[1];
                    $arExportador[$inIndex]["digito_agencia_conta"] = "";
                    $arExportador[$inIndex]["nome_favorecido"] = $this->removeAcentos($rsEstagio->nom_cgm);
                    $arExportador[$inIndex]["nr_documento"] = $rsEstagio->numero_estagio;
                    $arExportador[$inIndex]["dt_lancamento"] = str_replace("/", "", $dtPagamento);
                    $arExportador[$inIndex]["tipo_moeda"] = "BRL";
                    $arExportador[$inIndex]["quant_moeda"] = 0;

                    $nuVlrLancamento = number_format($rsEstagio->liquido, 2, ".", "");
                    $nuVlrLancamentoTotal += $nuVlrLancamento;
                    $nuVlrLancamento = number_format($nuVlrLancamento, 2, "", "");

                    $arExportador[$inIndex]["vlr_lancamento"] = $nuVlrLancamento;
                    $arExportador[$inIndex]["nr_documento_banco"] = "";
                    $arExportador[$inIndex]["dt_real_efetivacao"] = 0;
                    $arExportador[$inIndex]["vl_real_efetivacao"] = 0;
                    $arExportador[$inIndex]["outras_informacoes"] = "";
                    $arExportador[$inIndex]["cnab"] = "";
                    $arExportador[$inIndex]["aviso_favorecido"] = "";
                    $arExportador[$inIndex]["ocorrencias"] = "";

                    $arDetalhesArquivo = $this->geraHeaderLote($arExportador[$inIndex]);
                    $arDetalhes[] = $this->formataHeaderLote($arDetalhesArquivo, $inIndex);
                    $inIndex++;
                    $inNumSequencial++;
                }
            }

            if (!empty($rsPensaoJudiciais)) {
                foreach ($rsPensaoJudiciais as $rsPensaoJudicial) {
                    $arExportador[$inIndex]["banco"] = 1;
                    $arExportador[$inIndex]["lote"] = 1;
                    $arExportador[$inIndex]["registro_detalhe_lote"] = 3;
                    $arExportador[$inIndex]["numero_sequencial"] = $inNumSequencial;
                    $arExportador[$inIndex]["segmento"] = "A";
                    $arExportador[$inIndex]["tipo_movimento"] = 0;
                    $arExportador[$inIndex]["codigo_instrucao"] = 0;
                    $arExportador[$inIndex]["codigo_camera_centralizadora"] = 0;
                    $arExportador[$inIndex]["numero_banco_favorecido"] = $rsPensaoJudicial->num_banco;
                    $arAgencia = $this->separarDigito($rsPensaoJudicial->num_agencia);
                    $arExportador[$inIndex]["numero_agencia"] = $arAgencia[0];
                    $arExportador[$inIndex]["digito_agencia"] = $arAgencia[1];
                    $arConta = $this->separarDigito($rsPensaoJudicial->nr_conta);
                    $arExportador[$inIndex]["nr_conta"] = $arConta[0];
                    $arExportador[$inIndex]["digito_conta"] = $arConta[1];
                    $arExportador[$inIndex]["digito_agencia_conta"] = "";
                    $arExportador[$inIndex]["nome_favorecido"] = $this->removeAcentos($rsPensaoJudicial->nom_cgm);
                    $arExportador[$inIndex]["nr_documento"] = $rsPensaoJudicial->cpf;
                    $arExportador[$inIndex]["dt_lancamento"] = str_replace("/", "", $dtPagamento);
                    $arExportador[$inIndex]["tipo_moeda"] = "BRL";
                    $arExportador[$inIndex]["quant_moeda"] = 0;

                    $nuVlrLancamento = number_format($rsPensaoJudicial->liquido, 2, ".", "");
                    $nuVlrLancamentoTotal += $nuVlrLancamento;
                    $nuVlrLancamento = number_format($nuVlrLancamento, 2, "", "");

                    $arExportador[$inIndex]["vlr_lancamento"] = $nuVlrLancamento;
                    $arExportador[$inIndex]["nr_documento_banco"] = "";
                    $arExportador[$inIndex]["dt_real_efetivacao"] = 0;
                    $arExportador[$inIndex]["vl_real_efetivacao"] = 0;
                    $arExportador[$inIndex]["outras_informacoes"] = "";
                    $arExportador[$inIndex]["cnab"] = "";
                    $arExportador[$inIndex]["aviso_favorecido"] = "";
                    $arExportador[$inIndex]["ocorrencias"] = "";

                    $arDetalhesArquivo = $this->geraHeaderLote($arExportador[$inIndex]);
                    $arDetalhes[] = $this->formataHeaderLote($arDetalhesArquivo, $inIndex);
                    $inIndex++;
                    $inNumSequencial++;
                }
            }

            //CABEÇALHO ARQUIVO
            $arAgenciaConvenio = $this->separarDigito($rsContasConvenio->num_agencia);
            $inDigitoVerificadorAgencia = $arAgenciaConvenio[1];
            $inAgenciaConvenio = $arAgenciaConvenio[0];
            $arContaConvenio = $this->separarDigito($rsContasConvenio->num_conta_corrente);
            $inDigitoVerificadorConta = $arContaConvenio[1];
            $inContaConvenio = $arContaConvenio[0];

            //HEADER ARQUIVO
            $params = [
                'banco' => 1,
                'lote' => 0,
                'registro' => 0,
                'cnab' => "",
                'tipo_inscricao' => 2,
                'numero_inscricao' => $entidade->getFkSwCgm()->getFkSwCgmPessoaJuridica()->getCnpj(),
                'convenio' => $configuracaoConvenioBB->getCodConvenioBanco(),
                'codigo_agencia' => $inAgenciaConvenio,
                'digito_verificador_agencia' => $inDigitoVerificadorAgencia,
                'numero_conta_corrente' => $inContaConvenio,
                'digito_verificador_conta_corrente' => $inDigitoVerificadorConta,
                'digito_verificador_agencia_conta_corrente' => "",
                'nome_empresa' => $this->removeAcentos($entidade->getFkSwCgm()->getNomCgm()),
                'nome_banco' => "Banco do Brasil",
                'codigo_remessa' => 1,
                'data_geracao' => str_replace("/", "", $dtGeracaoArquivo->format('d/m/Y')),
                'hora_geracao' => date("His"),
                'numero_sequencial' => $inNumeroSequencial,
                'numero_versao_layout' => 30,
                'densidade_gravacao_arquivo' => 0,
                'reservado_banco' => "",
                'reservado_empresa' => "",
                'identificacao_cobranca' => "",
                'controle_vans' => "",
                'tipo_servico' => "30",
                'codigos_ocorrencias' => "",
            ];

            $arHeaderArquivo = $this->geraHeaderArquivo($params);
            $arHeader = $this->formataHeaderArquivo($arHeaderArquivo);

            //CABEÇALHO LOTE
            $stCEP = $entidade->getFkSwCgm()->getCep();
            $inCEP1 = substr($stCEP, 0, 5);
            $inCEP2 = substr($stCEP, 4, 3);
            $paramsLote = [
                'banco' => 1,
                'lote' => 1,
                'registro' => 1,
                'operacao' => "C",
                'servico' => 30,
                'forma_lancamento' => 1,
                'layout_lote' => 20,
                'cnab' => "",
                'tipo_inscricao' => 2,
                'numero_inscricao' => $entidade->getFkSwCgm()->getFkSwCgmPessoaJuridica()->getCnpj(),
                'convenio' => $configuracaoConvenioBB->getCodConvenioBanco(),
                'codigo_agencia' => $inAgenciaConvenio,
                'digito_verificador_agencia' => $inDigitoVerificadorAgencia,
                'numero_conta_corrente' => $inContaConvenio,
                'digito_verificador_conta_corrente' => $inDigitoVerificadorConta,
                'digito_verificador_agencia_conta_corrente' => "",
                'nome_empresa' => $this->removeAcentos($entidade->getFkSwCgm()->getNomCgm()),
                'mensagem' => "",
                'logradouro' => $this->removeAcentos($entidade->getFkSwCgm()->getLogradouro()),
                'numero_local' => $entidade->getFkSwCgm()->getNumero(),
                'complemento' => $entidade->getFkSwCgm()->getComplemento(),
                'cidade' => $this->removeAcentos($entidade->getFkSwCgm()->getFkSwMunicipio()->getNomMunicipio()),
                'cep' => $inCEP1,
                'complemento_cep' => $inCEP2,
                'estado' => $entidade->getFkSwCgm()->getFkSwMunicipio()->getFkSwUf()->getSiglaUf(),
                'cnab' => "",
                'ocorrencias' => "",
            ];

            $arHeaderLote = $this->geraHeaderLote($paramsLote);
            $arLote = $this->formataHeaderLote($arHeaderLote);

            $quantMoeda = $quantRegistros = 0;
            foreach ($arExportador as $exportador) {
                $quantMoeda .= $exportador['quant_moeda'];
                $quantRegistros++;
            }

            $inQuantRegistrosLote = (count($arExportador == 0)) ? 0 : count($arExportador);
            $arArquivoDadosExtras[$stNomeArquivo]['qtd'] = $inQuantRegistrosLote;
            $nuLiquidoTotal = number_format($nuVlrLancamentoTotal, 2, ",", ".");
            $arArquivoDadosExtras[$stNomeArquivo]['total'] = $nuLiquidoTotal;
            $nuQuantMoedas = $quantMoeda;

            //RODAPÉ LOTE
            $arRodapeLote[0]['banco'] = str_pad(1, 3, 0);
            $arRodapeLote[0]['lote'] = str_pad(1, 4, 0);
            $arRodapeLote[0]['registro'] = str_pad(5, 1, 0);
            $arRodapeLote[0]['cnab'] = str_pad("", 9);
            $quantRegistros = ($quantRegistros > 0) ? $quantRegistros + 2 : 0;
            $arRodapeLote[0]["quant_registros"] = str_pad($quantRegistros, 6, 0);
            $valorDebitoCredito = str_replace(".", "", number_format($nuVlrLancamentoTotal, 2, ".", ""));
            $arRodapeLote[0]["valor_debito_credito"] = str_pad($valorDebitoCredito, 18, 0);
            $arRodapeLote[0]["quant_moedas"] = str_pad($nuQuantMoedas, 18, 0);
            $arRodapeLote[0]["cnab2"] = str_pad("", 171);
            $arRodapeLote[0]["ocorrencias"] = str_pad("", 10);
            $arRodapeLote[0]['quebra'] = "\r\n";
            //RODAPÉ LOTE

            //RODAPÉ ARQUIVO
            $arRodape[0]['banco'] = str_pad(1, 3, 0);
            $arRodape[0]['lote'] = str_pad(9, 4, 9);
            $arRodape[0]['registro'] = 9;
            $arRodape[0]['cnab'] = str_pad("", 9);
            $arRodape[0]["quant_lotes"] = str_pad(1, 6, 0);
            $arRodape[0]["quant_registros"] = str_pad($inQuantRegistrosLote + 4, 6, 0);
            $arRodape[0]["quant_contas"] = str_pad(0, 6, 0);
            $arRodape[0]["cnab2"] = str_pad("", 205);
            $arRodape[0]['quebra'] = "\r\n";

            $arquivos = array_merge($arHeader, $arLote, $arDetalhes, $arRodapeLote, $arRodape);

            $fp = fopen('/tmp/' . $stNomeArquivo, 'w');

            foreach ($arquivos as $arquivo) {
                fwrite($fp, implode("", $arquivo));
            }
            fclose($fp);
            if ($opened === true) {
                $zip->addFile('/tmp/' . $stNomeArquivo, $stNomeArquivo);
                $arquivoGerado = true;
            }

            $arPeriodoMovimentacaoAtual = explode("/", $rsUltimaMovimentacao['dt_final']);
            $dtPeriodoMovimentacaoAtual = $arPeriodoMovimentacaoAtual[2] . "-" . $arPeriodoMovimentacaoAtual[1] . "-" . $arPeriodoMovimentacaoAtual[0];

            $info = [
                'cod_modulo' => Modulo::MODULO_IMA,
                'valor' => $dtPeriodoMovimentacaoAtual,
                'parametro' => 'dt_num_sequencial_arquivo_bb',
                'exercicio' => $exercicio,
            ];
            $configuracaoModel->updateAtributosDinamicos($info);
            $info = [
                'cod_modulo' => Modulo::MODULO_IMA,
                'valor' => $inNumeroSequencial,
                'parametro' => 'num_sequencial_arquivo_bb',
                'exercicio' => $exercicio,
            ];
            $configuracaoModel->updateAtributosDinamicos($info);
        }

        if ($arquivoGerado) {
            $zip->close();
        } else {
            $zip->addFromString('contratos_nao_encontrados.txt', 'Não há contratos rescindidos');
            $zip->close();
        }

        $paramsView['fileName'] = $arquivoName;
        $paramsView['quantidadeRegistros'] = $quantRegistros;
        $paramsView['stSituacaoCadastro'] = $stSituacao;
        $paramsView['dataGeracao'] = $dtGeracaoArquivo->format('d/m/Y');
        $paramsView['dataPagamento'] = $dtPagamento->format('d/m/Y');
        $paramsView['numeroSequencial'] = $inNumeroSequencial;
        $paramsView['dadosExtra'] = $arArquivoDadosExtras;
        $paramsView["stCompetenciaTitulo"] = substr($stCompetencia, 0, 2) . "/" . substr($stCompetencia, 2);

        $encode = (\GuzzleHttp\json_encode($paramsView));
        $hash = base64_encode($encode);
        $this->forceRedirect('/recursos-humanos/ima/exportar-remessa-bb/detalhe?id=' . $hash);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function geraDetalheArquivo(array $params)
    {
        /** DETALHE */
        $arDetalheArquivo = array();
        $arDetalheArquivo["banco"] = $params["banco"];
        $arDetalheArquivo["lote"] = $params["lote"];
        $arDetalheArquivo["registro_detalhe_lote"] = $params["registro_detalhe_lote"];
        $arDetalheArquivo["numero_sequencial"] = $params["numero_sequencial"];
        $arDetalheArquivo["segmento"] = $params["segmento"];
        $arDetalheArquivo["tipo_movimento"] = $params["segmento"];
        $arDetalheArquivo["codigo_instrucao"] = $params["codigo_instrucao"];
        $arDetalheArquivo["codigo_camera_centralizadora"] = $params["codigo_camera_centralizadora"];
        $arDetalheArquivo["numero_banco_favorecido"] = $params["numero_banco_favorecido"];
        $arDetalheArquivo["numero_agencia"] = $params["numero_agencia"];
        $arDetalheArquivo["digito_agencia"] = $params["digito_agencia"];
        $arDetalheArquivo["nr_conta"] = $params["nr_conta"];
        $arDetalheArquivo["digito_conta"] = $params["digito_conta"];
        $arDetalheArquivo["digito_agencia_conta"] = $params["digito_agencia_conta"];
        $arDetalheArquivo["nome_favorecido"] = $params["nome_favorecido"];
        $arDetalheArquivo["nr_documento"] = $params["nr_documento"];
        $arDetalheArquivo["dt_lancamento"] = $params["dt_lancamento"];
        $arDetalheArquivo["tipo_moeda"] = $params["tipo_moeda"];
        $arDetalheArquivo["quant_moeda"] = $params["quant_moeda"];
        $arDetalheArquivo["vlr_lancamento"] = $params["vlr_lancamento"];
        $arDetalheArquivo["nr_documento_banco"] = $params["nr_documento_banco"];
        $arDetalheArquivo["dt_real_efetivacao"] = $params["dt_real_efetivacao"];
        $arDetalheArquivo["vl_real_efetivacao"] = $params["vl_real_efetivacao"];
        $arDetalheArquivo["outras_informacoes"] = $params["outras_informacoes"];
        $arDetalheArquivo["cnab"] = $params["cnab"];
        $arDetalheArquivo["aviso_favorecido"] = $params["aviso_favorecido"];
        $arDetalheArquivo["ocorrencias"] = $params["ocorrencias"];

        return $arDetalheArquivo;
    }

    /**
     * @param $arDetalheArquivo
     *
     * @return mixed
     */
    public function formataDetalheArquivo($arDetalheArquivo, $index)
    {
        $arDetalhe[$index]["banco"] = str_pad($arDetalheArquivo['banco'], 3, 0);
        $arDetalhe[$index]["lote"] = str_pad($arDetalheArquivo['lote'], 4, 0);
        $arDetalhe[$index]["registro_detalhe_lote"] = str_pad($arDetalheArquivo['registro_detalhe_lote'], 3, 0);
        $arDetalhe[$index]["numero_sequencial"] = str_pad($arDetalheArquivo['numero_sequencial'], 5, 0);
        $arDetalhe[$index]["segmento"] = str_pad($arDetalheArquivo['segmento'], 1, 0);
        $arDetalhe[$index]["tipo_movimento"] = str_pad($arDetalheArquivo['tipo_movimento'], 1, 0);
        $arDetalhe[$index]["codigo_instrucao"] = str_pad($arDetalheArquivo['codigo_instrucao'], 2, 0);
        $arDetalhe[$index]["codigo_camera_centralizadora"] = str_pad($arDetalheArquivo['codigo_camera_centralizadora'], 3, 0);
        $arDetalhe[$index]["numero_banco_favorecido"] = str_pad($arDetalheArquivo['numero_banco_favorecido'], 3, 0);
        $arDetalhe[$index]["numero_agencia"] = str_pad($arDetalheArquivo['numero_agencia'], 5, 0);
        $arDetalhe[$index]["digito_agencia"] = str_pad($arDetalheArquivo['digito_agencia'], 1);
        $arDetalhe[$index]["nr_conta"] = str_pad($arDetalheArquivo['nr_conta'], 12, 0);
        $arDetalhe[$index]["digito_conta"] = str_pad($arDetalheArquivo['digito_conta'], 1, 0);
        $arDetalhe[$index]["digito_agencia_conta"] = str_pad($arDetalheArquivo['digito_agencia_conta'], 1);
        $arDetalhe[$index]["nome_favorecido"] = str_pad($arDetalheArquivo['nome_favorecido'], 30);
        $arDetalhe[$index]["nr_documento"] = str_pad($arDetalheArquivo['nr_documento'], 20);
        $arDetalhe[$index]["dt_lancamento"] = str_pad($arDetalheArquivo['dt_lancamento'], 8);
        $arDetalhe[$index]["tipo_moeda"] = str_pad($arDetalheArquivo['tipo_moeda'], 3);
        $arDetalhe[$index]["quant_moeda"] = str_pad($arDetalheArquivo['quant_moeda'], 15, 0);
        $arDetalhe[$index]["vlr_lancamento"] = str_pad($arDetalheArquivo['vlr_lancamento'], 15, 0);
        $arDetalhe[$index]["nr_documento_banco"] = str_pad($arDetalheArquivo['nr_documento_banco'], 20);
        $arDetalhe[$index]["dt_real_efetivacao"] = str_pad($arDetalheArquivo['dt_real_efetivacao'], 8, 0);
        $arDetalhe[$index]["vl_real_efetivacao"] = str_pad($arDetalheArquivo['vl_real_efetivacao'], 15, 0);
        $arDetalhe[$index]["outras_informacoes"] = str_pad($arDetalheArquivo['outras_informacoes'], 40);
        $arDetalhe[$index]["cnab"] = str_pad($arDetalheArquivo['cnab'], 12);
        $arDetalhe[$index]["aviso_favorecido"] = str_pad($arDetalheArquivo['aviso_favorecido'], 1);
        $arDetalhe[$index]["ocorrencias"] = str_pad($arDetalheArquivo['ocorrencias'], 10);
        $arDetalhe[$index]['quebra'] = "\r\n";

        return $arDetalhe;
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function geraHeaderLote(array $params)
    {
        /** HEADER LOTE */
        $arHeaderLote = array();
        $arHeaderLote['banco'] = $params['banco'];
        $arHeaderLote['lote'] = $params['lote'];
        $arHeaderLote['registro'] = $params["registro"];
        $arHeaderLote['operacao'] = $params["operacao"];
        $arHeaderLote['servico'] = $params['servico'];
        $arHeaderLote['forma_lancamento'] = $params["forma_lancamento"];
        $arHeaderLote['layout_lote'] = $params["layout_lote"];
        $arHeaderLote['cnab'] = $params["cnab"];
        $arHeaderLote['tipo_inscricao'] = $params["tipo_inscricao"];
        $arHeaderLote['numero_inscricao'] = $params["numero_inscricao"];
        $arHeaderLote['convenio'] = $params["convenio"];
        $arHeaderLote['codigo_agencia'] = $params["codigo_agencia"];
        $arHeaderLote['digito_verificador_agencia'] = $params["digito_verificador_agencia"];
        $arHeaderLote['numero_conta_corrente'] = $params["numero_conta_corrente"];
        $arHeaderLote['digito_verificador_conta_corrente'] = $params["digito_verificador_conta_corrente"];
        $arHeaderLote['digito_verificador_agencia_conta_corrente'] = $params["digito_verificador_agencia_conta_corrente"];
        $arHeaderLote['nome_empresa'] = $params["nome_empresa"];
        $arHeaderLote['mensagem'] = $params['mensagem'];
        $arHeaderLote['logradouro'] = $params["logradouro"];
        $arHeaderLote['numero_local'] = $params["numero_local"];
        $arHeaderLote['complemento'] = $params["complemento"];
        $arHeaderLote['cidade'] = $params['cidade'];
        $arHeaderLote['cep'] = $params["cep"];
        $arHeaderLote['complemento_cep'] = $params['complemento_cep'];
        $arHeaderLote['estado'] = $params['estado'];
        $arHeaderLote['cnab'] = $params['cnab'];
        $arHeaderLote['ocorrencias'] = $params['ocorrencias'];

        return $arHeaderLote;
    }

    /**
     * @param $arHeaderLote
     *
     * @return mixed
     */
    public function formataHeaderLote($arHeaderLote)
    {
        $arLote[0]['banco'] = str_pad($arHeaderLote['banco'], 3, 0);
        $arLote[0]['lote'] = str_pad($arHeaderLote['lote'], 4, 0);
        $arLote[0]['registro'] = str_pad($arHeaderLote["registro"], 1, 0);
        $arLote[0]['operacao'] = str_pad($arHeaderLote["operacao"], 1);
        $arLote[0]['servico'] = str_pad($arHeaderLote['servico'], 2, 0);
        $arLote[0]['forma_lancamento'] = str_pad($arHeaderLote["forma_lancamento"], 2, 0);
        $arLote[0]['layout_lote'] = str_pad($arHeaderLote["layout_lote"], 3, 0);
        $arLote[0]['cnab'] = str_pad($arHeaderLote["cnab"], 1);
        $arLote[0]['tipo_inscricao'] = str_pad($arHeaderLote["tipo_inscricao"], 1, 0);
        $arLote[0]['numero_inscricao'] = str_pad($arHeaderLote["numero_inscricao"], 14, 0);
        $convenio = substr($arHeaderLote["convenio"], 0, 20);
        $arLote[0]['convenio'] = str_pad($convenio, 20);
        $arLote[0]['codigo_agencia'] = str_pad($arHeaderLote["codigo_agencia"], 5, 0);
        $arLote[0]['digito_verificador_agencia'] = str_pad($arHeaderLote["digito_verificador_agencia"], 1);
        $arLote[0]['numero_conta_corrente'] = str_pad($arHeaderLote["numero_conta_corrente"], 12, 0);
        $arLote[0]['digito_verificador_conta_corrente'] = str_pad($arHeaderLote["digito_verificador_conta_corrente"], 1, 0);
        $arLote[0]['digito_verificador_agencia_conta_corrente'] = str_pad($arHeaderLote["digito_verificador_agencia_conta_corrente"], 1);
        $nomeEmpresa = substr($arHeaderLote['nome_empresa'], 0, 30);
        $arLote[0]['nome_empresa'] = str_pad($nomeEmpresa, 30);
        $mensagem = substr($arHeaderLote['mensagem'], 0, 40);
        $arLote[0]['mensagem'] = str_pad($mensagem, 40);
        $logradouro = substr($arHeaderLote["logradouro"], 0, 30);
        $arLote[0]['logradouro'] = str_pad($logradouro, 30);
        $arLote[0]['numero_local'] = str_pad($arHeaderLote["numero_local"], 5, 0);
        $arLote[0]['complemento'] = str_pad($arHeaderLote["complemento"], 15);
        $arLote[0]['cidade'] = str_pad($arHeaderLote['cidade'], 20);
        $arLote[0]['cep'] = str_pad($arHeaderLote["cep"], 5, 0);
        $arLote[0]['complemento_cep'] = str_pad($arHeaderLote['complemento_cep'], 3, 0);
        $arLote[0]['estado'] = str_pad($arHeaderLote['estado'], 2);
        $arLote[0]['cnab2'] = str_pad($arHeaderLote['cnab'], 8);
        $arLote[0]['ocorrencias'] = str_pad($arHeaderLote['ocorrencias'], 10);
        $arLote[0]['quebra'] = "\r\n";

        return $arLote;
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function geraHeaderArquivo(array $params)
    {
        /** HEADER ARQUIVO */
        $arHeaderArquivo = array();
        $arHeaderArquivo['banco'] = $params['banco'];
        $arHeaderArquivo['lote'] = $params['lote'];
        $arHeaderArquivo['registro'] = $params["registro"];
        $arHeaderArquivo['convenio'] = $params["convenio"];
        $arHeaderArquivo['cnab'] = $params['cnab'];
        $arHeaderArquivo['tipo_inscricao'] = $params["tipo_inscricao"];
        $arHeaderArquivo['numero_inscricao'] = $params["numero_inscricao"];
        $arHeaderArquivo['codigo_agencia'] = $params["codigo_agencia"];
        $arHeaderArquivo['digito_verificador_agencia'] = $params["digito_verificador_agencia"];
        $arHeaderArquivo['numero_conta_corrente'] = $params["numero_conta_corrente"];
        $arHeaderArquivo['digito_verificador_conta_corrente'] = $params["digito_verificador_conta_corrente"];
        $arHeaderArquivo['digito_verificador_agencia_conta_corrente'] = $params["digito_verificador_agencia_conta_corrente"];
        $arHeaderArquivo['nome_empresa'] = $params["nome_empresa"];
        $arHeaderArquivo['nome_banco'] = $params["nome_banco"];
        $arHeaderArquivo['codigo_remessa'] = $params["codigo_remessa"];
        $arHeaderArquivo['data_geracao'] = $params['data_geracao'];
        $arHeaderArquivo['hora_geracao'] = $params["hora_geracao"];
        $arHeaderArquivo['numero_sequencial'] = $params["numero_sequencial"];
        $arHeaderArquivo['numero_versao_layout'] = $params["numero_versao_layout"];
        $arHeaderArquivo['densidade_gravacao_arquivo'] = $params['densidade_gravacao_arquivo'];
        $arHeaderArquivo['reservado_banco'] = $params["reservado_banco"];
        $arHeaderArquivo['reservado_empresa'] = $params['reservado_empresa'];
        $arHeaderArquivo['identificacao_cobranca'] = $params['identificacao_cobranca'];
        $arHeaderArquivo['controle_vans'] = $params['controle_vans'];
        $arHeaderArquivo['tipo_servico'] = $params['tipo_servico'];
        $arHeaderArquivo['codigos_ocorrencias'] = $params['codigos_ocorrencias'];

        return $arHeaderArquivo;
    }

    /**
     * @param $arHeaderArquivo
     *
     * @return mixed
     */
    public function formataHeaderArquivo($arHeaderArquivo)
    {
        $arHeader[0]['banco'] = str_pad($arHeaderArquivo['banco'], 3, 0);
        $arHeader[0]['lote'] = str_pad($arHeaderArquivo['lote'], 4, 0);
        $arHeader[0]['registro'] = str_pad($arHeaderArquivo['registro'], 1);
        $arHeader[0]['cnab'] = str_pad($arHeaderArquivo['cnab'], 9);
        $arHeader[0]['tipo_inscricao'] = str_pad($arHeaderArquivo['tipo_inscricao'], 1);
        $arHeader[0]['numero_inscricao'] = str_pad($arHeaderArquivo['numero_inscricao'], 14, 0);
        $arHeader[0]['convenio'] = str_pad($arHeaderArquivo['convenio'], 20);
        $arHeader[0]['codigo_agencia'] = str_pad($arHeaderArquivo['codigo_agencia'], 5, 0);
        $arHeader[0]['digito_verificador_agencia'] = str_pad($arHeaderArquivo['digito_verificador_agencia'], 1);
        $arHeader[0]['numero_conta_corrente'] = str_pad($arHeaderArquivo['numero_conta_corrente'], 12, 0);
        $arHeader[0]['digito_verificador_conta_corrente'] = str_pad($arHeaderArquivo['digito_verificador_conta_corrente'], 1);
        $arHeader[0]['digito_verificador_agencia_conta_corrente'] = str_pad($arHeaderArquivo['digito_verificador_agencia_conta_corrente'], 1);
        $nomeEmpresa = substr($arHeaderArquivo['nome_empresa'], 0, 30);
        $arHeader[0]['nome_empresa'] = str_pad($nomeEmpresa, 30);
        $nomeBanco = substr($arHeaderArquivo['nome_banco'], 0, 30);
        $arHeader[0]['nome_banco'] = str_pad($nomeBanco, 30);
        $arHeader[0]['cnab2'] = str_pad($arHeaderArquivo['cnab'], 10);
        $arHeader[0]['codigo_remessa'] = str_pad($arHeaderArquivo['codigo_remessa'], 1);
        $arHeader[0]['data_geracao'] = str_pad($arHeaderArquivo['data_geracao'], 8);
        $arHeader[0]['hora_geracao'] = str_pad($arHeaderArquivo['hora_geracao'], 6);
        $arHeader[0]['numero_sequencial'] = str_pad($arHeaderArquivo['numero_sequencial'], 6, 0);
        $arHeader[0]['numero_versao_layout'] = str_pad($arHeaderArquivo['numero_versao_layout'], 3, 0);
        $arHeader[0]['densidade_gravacao_arquivo'] = str_pad($arHeaderArquivo['densidade_gravacao_arquivo'], 5, 0);
        $arHeader[0]['reservado_banco'] = str_pad($arHeaderArquivo['reservado_banco'], 20);
        $arHeader[0]['reservado_empresa'] = str_pad($arHeaderArquivo['reservado_empresa'], 20);
        $arHeader[0]['cnab3'] = str_pad($arHeaderArquivo['cnab'], 11);
        $arHeader[0]['identificacao_cobranca'] = str_pad($arHeaderArquivo['identificacao_cobranca'], 3, 0);
        $arHeader[0]['controle_vans'] = str_pad($arHeaderArquivo['controle_vans'], 3, 0);
        $arHeader[0]['tipo_servico'] = str_pad($arHeaderArquivo['tipo_servico'], 2);
        $arHeader[0]['codigos_ocorrencias'] = str_pad($arHeaderArquivo['codigos_ocorrencias'], 10);
        $arHeader[0]['quebra'] = "\r\n";

        return $arHeader;
    }


    /**
     * @param $stString
     *
     * @return array
     */
    public function separarDigito($stString)
    {
        $inNumero = preg_replace("/[^0-9a-zA-Z]/", "", $stString);
        $inDigito = $inNumero[strlen($inNumero) - 1];
        $inNumero = substr($inNumero, 0, strlen($inNumero) - 1);

        return array($inNumero, $inDigito);
    }

    /**
     * @param $stSituacao
     * @param $stTipoFiltro
     * @param $stCodLocais
     * @param $stCodOrgaos
     *
     * @return array
     */
    public function processaFiltro($stSituacao, $stTipoFiltro, $stCodLocais, $stCodOrgaos)
    {
        $form = $this->getForm();
        // ATIVOS/APOSENTADOS/PENSIONISTA
        $stFiltroContrato = "\n AND cod_orgao IN (" . $stCodOrgaos . ")";
        if (trim($stCodLocais) != "") {
            $stFiltroContrato .= "\n AND cod_local IN (" . $stCodLocais . ")";
        }

        if ($stSituacao == 'ativos' ||
            $stSituacao == 'aposentados' ||
            $stSituacao == 'rescindidos' ||
            $stSituacao == 'pensionistas' ||
            $stSituacao == 'todos') {
            $stValoresFiltro = "";
            switch ($stTipoFiltro) {
                case "contrato":
                case "contrato_rescisao":
                case "contrato_aposentado":
                case "contrato_todos":
                case "cgm_contrato":
                case "cgm_contrato_rescisao":
                case "cgm_contrato_aposentado":
                case "cgm_contrato_todos":
                    $arContratos = $form->get('codContrato')->getData();
                    foreach ($arContratos as $arContrato) {
                        $stValoresFiltro .= $arContrato->getCodContrato() . ",";
                    }
                    $stValoresFiltro = substr($stValoresFiltro, 0, strlen($stValoresFiltro) - 1);
                    break;
                case "contrato_pensionista":
                case "cgm_contrato_pensionista":
//                    $arPensionistas = Sessao::read("arPensionistas");
                    foreach ($arPensionistas as $arPensionista) {
                        $stValoresFiltro .= $arPensionista["cod_contrato"] . ",";
                    }
                    $stValoresFiltro = substr($stValoresFiltro, 0, strlen($stValoresFiltro) - 1);
                    break;
                case "lotacao":
                    $inCodLotacaoSelecionados = $form->get('lotacao')->getData();
                    $stValoresFiltro = implode(",", $inCodLotacaoSelecionados);
                    break;
                case "local":
                    $inCodLocalSelecionados = $form->get('local')->getData();
                    foreach ($inCodLocalSelecionados as $inCodLocal) {
                        $codLocal[] = $inCodLocal->getCodLocal();
                    }
                    $stValoresFiltro = implode(",", $codLocal);
                    break;
                case "atributo_servidor":
                    $inCodAtributo = $_REQUEST["inCodAtributo"];
                    $inCodCadastro = $_REQUEST["inCodCadastro"];
                    $stNomeAtributo = "Atributo_" . $inCodAtributo . "_" . $inCodCadastro;
                    if (is_array($_REQUEST[$stNomeAtributo . "_Selecionados"])) {
                        $inArray = 1;
                        $stValores = implode(",", $_REQUEST[$stNomeAtributo . "_Selecionados"]);
                    } else {
                        $inArray = 0;
                        $stValores = $_REQUEST[$stNomeAtributo];
                    }
                    $stValoresFiltro = $inArray . "#" . $inCodAtributo . "#" . $stValores;
                    break;
                case "atributo_pensionista":
                    $inCodAtributo = $_REQUEST["inCodAtributo"];
                    $inCodCadastro = $_REQUEST["inCodCadastro"];
                    $stNomeAtributo = "Atributo_" . $inCodAtributo . "_" . $inCodCadastro;
                    if (is_array($_REQUEST[$stNomeAtributo . "_Selecionados"])) {
                        $inArray = 1;
                        $stValores = implode(",", $_REQUEST[$stNomeAtributo . "_Selecionados"]);
                    } else {
                        $inArray = 0;
                        $stValores = $_REQUEST[$stNomeAtributo];
                    }
                    $stValoresFiltro = $inArray . "#" . $inCodAtributo . "#" . $stValores;
                    break;
                case "cargo":
                    $stValoresFiltro = implode(",", $_REQUEST["inCodCargoSelecionados"]);
                    break;
                case "funcao":
                    $stValoresFiltro = implode(",", $_REQUEST["inCodFuncaoSelecionados"]);
                    break;
            }
        }

        // ESTAGIARIOS
        $stFiltroEstagiario = " AND cod_orgao IN (" . $stCodOrgaos . ")";
        if (trim($stCodLocais) != "") {
            $stFiltroEstagiario .= " AND cod_local IN (" . $stCodLocais . ")";
        }

        if ($stSituacao == 'estagiarios' ||
            $stSituacao == 'todos') {
            switch ($stTipoFiltro) {
                case "cgm_codigo_estagio":
                    foreach (Sessao::read('arEstagios') as $arEstagio) {
                        $stCodEstagio .= $arEstagio["inCodigoEstagio"] . ",";
                    }
                    $stCodEstagio = substr($stCodEstagio, 0, strlen($stCodEstagio) - 1);
                    $stFiltroEstagiario .= " AND numero_estagio IN (" . $stCodEstagio . ")";
                    break;
                case "lotacao":
                    $stCodOrgao = implode(",", $_REQUEST["inCodLotacaoSelecionados"]);
                    $stFiltroEstagiario .= " AND cod_orgao in (" . $stCodOrgao . ")";
                    break;
                case "local":
                    $stCodLocal = implode(",", $_POST['inCodLocalSelecionados']);
                    $stFiltroEstagiario .= " AND cod_local in (" . $stCodLocal . ")";
                    break;
                case "atributo_estagiario":
                    $inCodAtributo = $_REQUEST["inCodAtributo"];
                    $inCodCadastro = $_REQUEST["inCodCadastro"];
                    $stNomeAtributo = "Atributo_" . $inCodAtributo . "_" . $inCodCadastro;
                    if (is_array($_REQUEST[$stNomeAtributo . "_Selecionados"])) {
                        $inArray = 1;
                        $stValores = implode(",", $_REQUEST[$stNomeAtributo . "_Selecionados"]);
                    } else {
                        $inArray = 0;
                        $stValores = $_REQUEST[$stNomeAtributo];
                    }
                    $stValoresFiltro = $inArray . "#" . $inCodAtributo . "#" . $stValores;
                    break;
            }
        }

        //PENSAO JUDICIAL
        $stFiltroPensaoJudicial = " AND cod_orgao IN (" . $stCodOrgaos . ")";
        if (trim($stCodLocais) != "") {
            $stFiltroPensaoJudicial .= " AND cod_local IN (" . $stCodLocais . ")";
        }

        //Tipo de Cadastro
        if ($stSituacao == 'todos' ||
            $stSituacao == 'pensao_judicial') {
            switch ($stTipoFiltro) {
                case "cgm_dependente": //IFiltroComponentesDependentes
                    foreach (Sessao::read('arCGMDependentes') as $arCGMDependente) {
                        $stCGMDependente .= "'" . addslashes($arCGMDependente["numcgm"]) . "',";
                    }
                    $stCGMDependente = substr($stCGMDependente, 0, strlen($stCGMDependente) - 1);

                    $stFiltroPensaoJudicial .= " AND contrato.numcgm_dependente IN (" . $stCGMDependente . ")";
                    break;
                case "cgm_servidor_dependente": //IFiltroComponentesDependentes
                    foreach (Sessao::read('arContratos') as $arContrato) {
                        $stCodContrato .= $arContrato["cod_contrato"] . ",";
                    }
                    $stCodContrato = substr($stCodContrato, 0, strlen($stCodContrato) - 1);
                    $stFiltroPensaoJudicial .= " AND cod_contrato IN (" . $stCodContrato . ")";
                    break;
                case "lotacao":
                    $stCodOrgao = implode(",", $_REQUEST["inCodLotacaoSelecionados"]);
                    $stFiltroPensaoJudicial .= " AND cod_orgao in (" . $stCodOrgao . ")";
                    break;
            }
        }

        $retorno = [
            'stFiltroContrato' => $stFiltroContrato,
            'stValoresFiltro' => $stValoresFiltro,
            'stFiltroEstagiario' => $stFiltroEstagiario,
            'stFiltroPensaoJudicial' => $stFiltroPensaoJudicial,
        ];

        return $retorno;
    }

    /**
     * @param $stCampo
     *
     * @return mixed|string
     */
    public function removeAcentos($stCampo)
    {
        $Acentos = "áàãââÁÀÃÂéêÉÊíÍóõôÓÔÕúüÚÜçÇ";
        $Traducao = "aaaaaAAAAeeeeiIoooOOOuuUUcC";
        $tempLog = "";
        for ($i = 0; $i < strlen($stCampo); $i++) {
            $Carac = $stCampo[$i];
            $Posic = strpos($Acentos, $Carac);
            if ($Posic > -1) {
                $tempLog .= $Traducao[$Posic];
            } else {
                $tempLog .= $stCampo[$i];
            }
        }
        $tempLog = str_replace(".", "", $tempLog);
        $tempLog = preg_replace("/[^0-9a-zA-Z ]/", "", $tempLog);

        return $tempLog;
    }
}
