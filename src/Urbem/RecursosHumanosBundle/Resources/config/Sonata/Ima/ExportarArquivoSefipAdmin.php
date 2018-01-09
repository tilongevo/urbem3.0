<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Ima;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Ima\CategoriaSefip;
use Urbem\CoreBundle\Entity\Ima\Recolhimento;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausa;
use Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaCategoria;
use Urbem\CoreBundle\Entity\Pessoal\Sefip;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Economico\CnaeFiscalModel;
use Urbem\CoreBundle\Model\Folhapagamento\DescontoExternoPrevidenciaModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoCalculadoModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoComplementarCalculadoModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoDecimoCalculadoModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoFeriasCalculadoModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoRescisaoCalculadoModel;
use Urbem\CoreBundle\Model\Folhapagamento\FgtsEventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PrevidenciaEventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\SalarioFamiliaEventoModel;
use Urbem\CoreBundle\Model\Ima\CategoriaSefipModel;
use Urbem\CoreBundle\Model\Ima\PrevidenciaRegimeRatModel;
use Urbem\CoreBundle\Model\Pessoal\AdidoCedidoModel;
use Urbem\CoreBundle\Model\Pessoal\Assentamento\AssentamentoGeradoModel;
use Urbem\CoreBundle\Model\Pessoal\Assentamento\MovSefipSaidaMovSefipRetornoModel;
use Urbem\CoreBundle\Model\Pessoal\AssentamentoMovSefipSaidaModel;
use Urbem\CoreBundle\Model\Pessoal\CausaRescisaoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoServidorCasoCausaModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoServidorModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoServidorPrevidenciaModel;
use Urbem\CoreBundle\Model\SwCgmModel;
use Urbem\CoreBundle\Resources\config\Sonata\Filter\Pessoal\GeneralFilterAdmin;

class ExportarArquivoSefipAdmin extends GeneralFilterAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_ima_configuracao_exportar_sefip';
    protected $baseRoutePattern = 'recursos-humanos/ima/exportar-sefip';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Exportar Arquivo'];
    public $rsEventoCalculadosDecimo = '';
    public $inDoencaDias;
    public $inAcidenteTrabalho;
    public $inLicencaMaternidade;
    public $inRescisoes;
//    protected $includeJs = array('/recursoshumanos/javascripts/ima/exportarArquivoIpers.js');

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('detalhe', 'detalhe');
        $collection->add('report', 'report/{id}');
        $collection->add('download', 'download/{id}');
        $collection->clearExcept(array('create', 'detalhe', 'report', 'download'));
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

        $fieldOptions = [];
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

        $mes = '';
        $fieldOptions['mes'] = [
            'label' => 'label.ferias.mes',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'choices' => $periodoMovimentacaoModel->getMesCompetenciaFolhaPagamento($this->getExercicio()),
            'attr' => [
                'data-mes' => $mes,
            ],
            'attr' => ['class' => 'select2-parameters '],
        ];

        $fieldOptions['inTipoRemessa'] = [
            'label' => 'label.recursosHumanos.ima.tipoRemessa',
            'mapped' => false,
            'choices' => [
                'GFIP' => 1,
                'DERF' => 2,
            ],
        ];

        $recolhimentos = $entityManager->getRepository(Recolhimento::class)->findAll();
        $recolhentosArray = [];
        foreach ($recolhimentos as $recolhimento) {
            $recolhentosArray[$recolhimento->getCodRecolhimento() . " - " . $recolhimento->getDescricao()] = $recolhimento->getCodRecolhimento();
        }

        $fieldOptions['inCodRecolhimento'] = [
            'label' => 'label.recursosHumanos.ima.inCodRecolhimento',
            'choices' => $recolhentosArray,
            'mapped' => false,
        ];

        $fieldOptions['inCodIndicadorRecolhimento'] = [
            'label' => 'label.recursosHumanos.ima.inCodIndicadorRecolhimento',
            'choices' => [
                'GRF no prazo' => 1,
                'GRF em atraso' => 2
            ],
            'mapped' => false,
        ];

        $fieldOptions['dtRecolhimentoFGTS'] = [
            'label' => 'label.recursosHumanos.ima.dtRecolhimentoFGTS',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['inCodIndicadorRecolhimentoPrevidencia'] = [
            'label' => 'label.recursosHumanos.ima.inCodIndicadorRecolhimentoPrevidencia',
            'choices' => [
                'GRF no prazo' => 1,
                'GRF em atraso' => 2
            ],
            'mapped' => false,
        ];

        $fieldOptions['dtRecolhimentoPrevidencia'] = [
            'label' => 'label.recursosHumanos.ima.dtRecolhimentoPrevidencia',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['boArrecadouFGTS'] = [
            'label' => 'label.recursosHumanos.ima.boArrecadouFGTS',
            'mapped' => false,
            'choices' => [
                'Sim' => 'sim',
                'Não' => 'nao',
            ],
            'data' => 'sim',
            'expanded' => true,
            'multiple' => false,
            'label_attr' => ['class' => 'checkbox-sonata '],
            'attr' => ['class' => 'checkbox-sonata '],
            'required' => true
        ];

        $fieldOptions['boSefipRetificadora'] = [
            'label' => 'label.recursosHumanos.ima.boSefipRetificadora',
            'mapped' => false,
            'choices' => [
                'Sim' => 'sim',
                'Não' => 'nao',
            ],
            'data' => 'nao',
            'expanded' => true,
            'multiple' => false,
            'label_attr' => ['class' => 'checkbox-sonata '],
            'attr' => ['class' => 'checkbox-sonata '],
            'required' => true
        ];

        $exercicio = $this->getExercicio();

        /** @var ConfiguracaoModel $configuracaoModel */
        $configuracaoModel = new ConfiguracaoModel($entityManager);
        $cnaeFiscal = $configuracaoModel->getConfiguracao('cnae_fiscal', Modulo::MODULO_IMA, true, $exercicio);

        $valorComposto = '';

        if ($cnaeFiscal != '') {
            /** @var CnaeFiscalModel $cnaeFiscalModel */
            $cnaeFiscalModel = new CnaeFiscalModel($entityManager);
            $cnaeFiscais = $cnaeFiscalModel->findCnaeFiscal($cnaeFiscal);
            $valorComposto = $cnaeFiscais[0]['valor_composto'];
        }

        $centralizacao = $configuracaoModel->getConfiguracao('centralizacao', Modulo::MODULO_IMA, true, $exercicio);
        $fpas = $configuracaoModel->getConfiguracao('fpas', Modulo::MODULO_IMA, true, $exercicio);
        $gps = $configuracaoModel->getConfiguracao('gps', Modulo::MODULO_IMA, true, $exercicio);

        $fieldOptions['valorComposto'] = [
            'label' => 'label.recursosHumanos.ima.configuracaoSefip.cnaeFiscal',
            'mapped' => false,
            'attr' => [
                'readonly' => 'readonly'
            ],
            'data' => $valorComposto
        ];

        $fieldOptions['centralizacao'] = [
            'label' => 'label.recursosHumanos.ima.configuracaoSefip.centralizacao',
            'mapped' => false,
            'attr' => [
                'readonly' => 'readonly'
            ],
            'data' => $centralizacao
        ];

        $fieldOptions['fpas'] = [
            'label' => 'label.recursosHumanos.ima.configuracaoSefip.fpas',
            'mapped' => false,
            'attr' => [
                'readonly' => 'readonly'
            ],
            'data' => $fpas
        ];

        $fieldOptions['gps'] = [
            'label' => 'label.recursosHumanos.ima.configuracaoSefip.gps',
            'mapped' => false,
            'attr' => [
                'readonly' => 'readonly'
            ],
            'data' => $gps
        ];

        $formMapper
            ->with("Filtro");
        parent::configureFields($formMapper, ['reg_sub_car_esp_grupo', 'padrao', 'funcao', 'matricula']);
        $formMapper
            ->add('ano', 'number', $fieldOptions['ano'])
            ->add('mes', 'choice', $fieldOptions['mes'])
            ->add('inTipoRemessa', 'choice', $fieldOptions['inTipoRemessa'])
            ->add('inCodRecolhimento', 'choice', $fieldOptions['inCodRecolhimento'])
            ->add('inCodIndicadorRecolhimento', 'choice', $fieldOptions['inCodIndicadorRecolhimento'])
            ->add('dtRecolhimentoFGTS', 'sonata_type_date_picker', $fieldOptions['dtRecolhimentoFGTS'])
            ->add('inCodIndicadorRecolhimentoPrevidencia', 'choice', $fieldOptions['inCodIndicadorRecolhimentoPrevidencia'])
            ->add('dtRecolhimentoPrevidencia', 'sonata_type_date_picker', $fieldOptions['dtRecolhimentoPrevidencia'])
            ->add('valorComposto', 'text', $fieldOptions['valorComposto'])
            ->add('centralizacao', 'text', $fieldOptions['centralizacao'])
            ->add('fpas', 'text', $fieldOptions['fpas'])
            ->add('gps', 'text', $fieldOptions['gps'])
            ->add('boArrecadouFGTS', 'choice', $fieldOptions['boArrecadouFGTS'])
            ->add('boSefipRetificadora', 'choice', $fieldOptions['boSefipRetificadora'])
            ->end();
    }

    public function prePersist($object)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        /** @var ConfiguracaoModel $configuracaoModel */
        $configuracaoModel = new ConfiguracaoModel($entityManager);
        $codEntidadePrefeitura = $configuracaoModel->getConfiguracao(
            'cod_entidade_prefeitura',
            Modulo::MODULO_ORCAMENTO,
            true,
            $this->getExercicio()
        );

        /** @var Entidade $entidade */
        $entidade = $entityManager->getRepository(Entidade::class)->findOneBy(
            [
                'codEntidade' => $codEntidadePrefeitura,
                'exercicio' => $this->getExercicio()
            ]
        );

        $exercicio = $this->getExercicio();

        $form = $this->getForm();
        $stTipoFiltro = $form->get('tipo')->getData();
        $inCodMes = ($form->get('mes')->getData() > 9) ? $form->get('mes')->getData() : "0" . $form->get('mes')->getData();
        $gps = $form->get('gps')->getData();
        $boCompetencia13 = false;//($form->get('boCompetencia13')) ? $form->get('boCompetencia13')->getData() : false;
        $ano = $form->get('ano')->getData();
        $dtCompetencia = $inCodMes . "/" . $ano;
        $inCodRecolhimento = $form->get("inCodRecolhimento")->getData();
        $inTipoRemessa = $form->get("inTipoRemessa")->getData();
        $boSefipRetificadora = $form->get("boSefipRetificadora")->getData();
        $dtRecolhimentoPrevidencia = $form->get("dtRecolhimentoPrevidencia")->getData();
        $dtRecolhimentoFGTS = $form->get("dtRecolhimentoFGTS")->getData();
        $inCodIndicadorRecolhimento = $form->get("inCodIndicadorRecolhimento")->getData();
        $inCodIndicadorRecolhimentoPrevidencia = $form->get("inCodIndicadorRecolhimentoPrevidencia")->getData();

        /** @var PeriodoMovimentacao $periodoMovimentacao */
        $inCodPeriodoMovimentacao = $entityManager->getRepository(PeriodoMovimentacao::class)
            ->consultaPeriodoMovimentacaoCompetencia($dtCompetencia);

        $arCompetencia = explode("/", $inCodPeriodoMovimentacao["dt_final"]);
        $boDezembro = ($arCompetencia[1] == 12) ? true : false;

        $filtro = $this->processarFiltro($stTipoFiltro);

        /** @var ContratoServidorModel $contratoServidorModel */
        $contratoServidorModel = new ContratoServidorModel($entityManager);
        $arContratos = $contratoServidorModel->recuperaContratosSEFIP($filtro['stJoin'], $filtro['stFiltro']);

        $stCodContratos = "";
        foreach ($arContratos as $contrato) {
            $stCodContratos .= $contrato->cod_contrato . ",";
        }
        $stCodContratos = substr($stCodContratos, 0, strlen($stCodContratos) - 1);
        if (trim($stCodContratos) == "") {
            $stCodContratos = "null";
        }

        $inIndexArquivo = 1;

        /** @var CategoriaSefipModel $categoriaSefipModel */
        $categoriaSefipModel = new CategoriaSefipModel($entityManager);
        $rsModalidades = $categoriaSefipModel->recuperaModalidades();

        foreach ($rsModalidades as $modalidade) {
            $stModalidade = ($modalidade->sefip === "0") ? "" : $modalidade->sefip;
            $boAdicionarFiltroExtra = false;

            $rsCategoriasModalidades = $entityManager->getRepository(CategoriaSefip::class)->findBy(
                [
                    'codModalidade' => $modalidade->cod_modalidade
                ]
            );

            $stCodCategorias = "";

            /** @var CategoriaSefip $catModalidade */
            foreach ($rsCategoriasModalidades as $catModalidade) {
                $stCodCategorias .= $catModalidade->getCodCategoria() . ",";
            }
            $stCodCategorias = substr($stCodCategorias, 0, strlen($stCodCategorias) - 1);
//
//            if (trim($stCodCategorias)!="") {
//                Sessao::write("stFiltroRegistroTrabalhadoresExtra", Sessao::read("stFiltroRegistroTrabalhadoresExtra") . " AND contrato_servidor.cod_categoria IN (".$stCodCategorias.")");
//            }

            if ($form->get('boSefipRetificadora') == 'sim') {
                $inIndexArquivo = 9;
            }

            $stNomePrefeitura = $entidade->getFkSwCgm()->getNomCgm();
            $stLogradouro = $entidade->getFkSwCgm()->getLogradouro() . " " . $entidade->getFkSwCgm()->getNumero();
            $stBairro = $entidade->getFkSwCgm()->getBairro();
            $inCep = $entidade->getFkSwCgm()->getCep();
            $inCNPJ = $entidade->getFkSwCgm()->getFkSwCgmPessoaJuridica()->getCnpj();
            $stCodigoOutrasEntidades = $configuracaoModel->getConfiguracao('codigo_outras_entidades_sefip', Modulo::MODULO_IMA, true, $exercicio);
            $stPessoaContato = $configuracaoModel->getConfiguracao('nome_pessoa_contato_sefip', Modulo::MODULO_IMA, true, $exercicio);
            $stTelefoneContato = $configuracaoModel->getConfiguracao('telefone_pessoa_contato_sefip', Modulo::MODULO_IMA, true, $exercicio);
            $stDDDContato = $configuracaoModel->getConfiguracao('DDD_pessoa_contato_sefip', Modulo::MODULO_IMA, true, $exercicio);
            $stEmailContato = $configuracaoModel->getConfiguracao('mail_pessoa_contato_sefip', Modulo::MODULO_IMA, true, $exercicio);
            $cnaeFiscal = $configuracaoModel->getConfiguracao('cnae_fiscal', Modulo::MODULO_IMA, true, $exercicio);
            $centralizacao = $configuracaoModel->getConfiguracao('centralizacao', Modulo::MODULO_IMA, true, $exercicio);
            $fpas = $configuracaoModel->getConfiguracao('fpas', Modulo::MODULO_IMA, true, $exercicio);
            $gps = $configuracaoModel->getConfiguracao('gps', Modulo::MODULO_IMA, true, $exercicio);
            $municipio = $entidade->getFkSwCgm()->getFkSwMunicipio()->getNomMunicipio();
            $uf = $entidade->getFkSwCgm()->getFkSwMunicipio()->getFkSwUf()->getSiglaUf();

            //HEADER ARQUIVO
            $params = [
                'inTipoRemessa' => $inTipoRemessa,
                'inCNPJ' => $inCNPJ,
                'stNomePrefeitura' => $stNomePrefeitura,
                'stPessoaContato' => $stPessoaContato,
                'stLogradouro' => $stLogradouro,
                'stBairro' => $stBairro,
                'inCep' => $inCep,
                'municipio' => $municipio,
                'uf' => $uf,
                'stDDDContato' => $stDDDContato,
                'stTelefoneContato' => $stTelefoneContato,
                'stEmailContato' => $stEmailContato,
                'boCompetencia13' => $boCompetencia13,
                'ano' => $ano,
                'inCodMes' => $inCodMes,
                'boSefipRetificadora' => $boSefipRetificadora,
                'dtRecolhimentoPrevidencia' => $dtRecolhimentoPrevidencia,
                'dtRecolhimentoFGTS' => $dtRecolhimentoFGTS,
                'inCodRecolhimento' => $inCodRecolhimento,
                'inCodIndicadorRecolhimento' => $inCodIndicadorRecolhimento,
                'stModalidade' => $stModalidade,
                'inCodIndicadorRecolhimentoPrevidencia' => $inCodIndicadorRecolhimentoPrevidencia,
                'exercicio' => $exercicio
            ];

            $arHeaderArquivo = $this->geraHeaderArquivo($params);
            $arHeader = $this->formataHeaderArquivo($arHeaderArquivo);
            //FIM HEADER ARQUIVO

            /** @var SalarioFamiliaEventoModel $salarioFamiliaEventoModel */
            $salarioFamiliaEventoModel = new SalarioFamiliaEventoModel($entityManager);

            $stFiltroSalEvento = "   AND fsfe.cod_regime_previdencia = 1 \n";
            $stFiltroSalEvento .= "  AND fsfe.cod_tipo = 1               \n";
            $rsSalarioEvento = $salarioFamiliaEventoModel->recuperaRelacionamento($stFiltroSalEvento);
            $stCodContratosAdidosCedidos = $nuTotalSalarioFamilia = $nuTotalSalarioMaternidade = $nuTotalSalarioMaternidade13 = '';
            $arInformacoesAdicionais = [];

            //TOMADOR DE SERVIÇO
            if (in_array($inCodRecolhimento, array(130, 135, 150, 155, 211, 317, 337, 608))) {
                $inIndex = 0;
                $arTomadorServico = [];
                $adidoCedidoModel = new AdidoCedidoModel($entityManager);
                $rsAdidoCedido = $adidoCedidoModel->recuperaAdidosCedidosSEFIP();

                foreach ($rsAdidoCedido as $adidoCedido) {
                    $stFiltroAdidoCedido = " AND adido_cedido.cgm_cedente_cessionario = " . $adidoCedido["cgm_cedente_cessionario"];
                    $rsAdidoCedidoContratos = $adidoCedidoModel->recuperaAdidosCedidosSEFIPContratos($stFiltroAdidoCedido);
                    if ($boCompetencia13) {
                        $nuTotalSalarioFamilia = 0;
                    } else {
                        foreach ($rsAdidoCedidoContratos as $rsAdidoContratos) {
                            $arContratosAdidosCedidosTomador[$rsAdidoContratos["cod_contrato"]] = $rsAdidoCedido["cnpj"];
                            $stCodContratosAdidosCedidos .= $rsAdidoContratos["cod_contrato"] . ",";

                            $stFiltroEvento = " AND evento.cod_evento = " . $rsSalarioEvento->cod_evento;
                            $stFiltroEvento .= " AND cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao["cod_periodo_movimentacao"];
                            $stFiltroEvento .= " AND cod_contrato = " . $rsAdidoContratos["cod_contrato"];

                            $nuTotalSalarioFamilia = $this->geraSomaValoresMaternidadeSalarioFamilia(
                                $stFiltroEvento,
                                $entityManager,
                                $nuTotalSalarioFamilia
                            );
                        }
//                        Sessao::write("nuSalarioFamilia", Sessao::read("nuSalarioFamilia") + $nuTotalSalarioFamilia);
                    }

                    $arTomadorServico[$inIndex]['tipo_registro'] = 20;
                    $arTomadorServico[$inIndex]['tipo_inscricao'] = 1;
                    $arTomadorServico[$inIndex]['inscricao_empresa'] = $inCNPJ;
                    $arTomadorServico[$inIndex]['tipo_inscricao_tomador'] = 1;
                    $arTomadorServico[$inIndex]['inscricao_tomador'] = $rsAdidoCedido["cnpj"];
                    $arTomadorServico[$inIndex]['zeros'] = 0;
                    $arTomadorServico[$inIndex]['nome_tomador'] = $this->removeAcentuacao($adidoCedido["nom_cgm"]);
                    $arTomadorServico[$inIndex]['logradouro'] = $this->removeAcentuacao($adidoCedido["logradouro"] . " " . $adidoCedido["numero"] . " " . $adidoCedido["complemento"]);
                    $arTomadorServico[$inIndex]['bairro'] = $this->removeAcentuacao($adidoCedido["bairro"]);
                    $arTomadorServico[$inIndex]['cep'] = $this->removeAcentuacao($adidoCedido["cep"]);
                    $arTomadorServico[$inIndex]['cidade'] = $this->removeAcentuacao($adidoCedido["nom_municipio"]);
                    $arTomadorServico[$inIndex]['unid_federal'] = $adidoCedido["sigla"];
                    $arTomadorServico[$inIndex]['gps'] = $gps;
                    $arTomadorServico[$inIndex]['salario_familia'] = str_replace(".", "", number_format($nuTotalSalarioFamilia, 2, ".", ""));
                    $arTomadorServico[$inIndex]['contribuicao'] = 0;
                    $arTomadorServico[$inIndex]['indicador'] = 0;
                    $arTomadorServico[$inIndex]['valor_devido'] = 0;
                    $arTomadorServico[$inIndex]['valor_retencao'] = 0;
                    $arTomadorServico[$inIndex]['valor_fatura'] = 0;
                    $arTomadorServico[$inIndex]['zeros'] = 0;
                    $arTomadorServico[$inIndex]['brancos'] = "";
                    $arTomadorServico[$inIndex]['final'] = "*";
                    $inIndex++;
                }
                $stCodContratosAdidosCedidos = substr($stCodContratosAdidosCedidos, 0, strlen($stCodContratosAdidosCedidos) - 1);
            }
            //TOMADOR DE SERVIÇO

            $params['cnaeFiscal'] = $cnaeFiscal;
            $params['stCodigoOutrasEntidades'] = $stCodigoOutrasEntidades;
            $params['centralizacao'] = $centralizacao;
            $params['fpas'] = $fpas;
            $params['gps'] = $gps;
            $params['cod_periodo_movimentacao'] = $inCodPeriodoMovimentacao['cod_periodo_movimentacao'];
            $params['stCodContratos'] = $stCodContratos;
            $params['stCodContratosAdidosCedidos'] = $stCodContratosAdidosCedidos;
            $params['nuTotalSalarioFamilia'] = $nuTotalSalarioFamilia;
            $params['nuTotalSalarioMaternidade'] = $nuTotalSalarioMaternidade;

            //HEADER EMPRESA
            $arHeaderEmpresa = $this->geraHeaderEmpresa($params, $rsSalarioEvento, $entidade);
            $arHeaderEmp = $this->formataHeaderEmpresa($arHeaderEmpresa);
            //FIM HEADER EMPRESA

            //REGISTRO INFORMAÇÕES ADICIONAIS DO RECOLHIMENTO DA EMPRESA
            if ($boCompetencia13) {
                $nuTotalSalarioMaternidade13 = 0;
                if (is_object($this->rsEventoCalculadosDecimo)) {
                    foreach ($this->rsEventoCalculadosDecimo as $rsEventoDecimoCalculados) {
                        $nuTotalSalarioMaternidade13 += $rsEventoDecimoCalculados["valor"];
                    }
                }

                $arInformacoesAdicionais[0]['tipo_registro'] = 12;
                $arInformacoesAdicionais[0]['tipo_inscricao'] = 1;
                $arInformacoesAdicionais[0]['inscricao_empresa'] = $inCNPJ;
                $arInformacoesAdicionais[0]['zeros'] = 0;
                $arInformacoesAdicionais[0]['deducao_13'] = str_replace('.', '', number_format($nuTotalSalarioMaternidade13, 2, '.', ''));
                $arInformacoesAdicionais[0]['brancos'] = "";
                $arInformacoesAdicionais[0]['final'] = "*";
            }

            //REGISTRO DO TRABALHADOR
            $stFiltroEventoFGTS = " AND cod_tipo = 3";
            /** @var FgtsEventoModel $fgtsEventoModel */
            $fgtsEventoModel = new FgtsEventoModel($entityManager);
            $rsEventoFgts = $fgtsEventoModel->recuperaRelacionamento($stFiltroEventoFGTS);

            /** @var AssentamentoGeradoModel $assentamentoGeradoModel */
            $assentamentoGeradoModel = new AssentamentoGeradoModel($entityManager);

            /** @var EventoRescisaoCalculadoModel $eventoRescisaoCalculadoModel */
            $eventoRescisaoCalculadoModel = new EventoRescisaoCalculadoModel($entityManager);

            /** @var CausaRescisaoModel $causaRescisaoModel */
            $causaRescisaoModel = new CausaRescisaoModel($entityManager);

            /** @var AssentamentoMovSefipSaidaModel $assentamentoMovSefipSaidaModel */
            $assentamentoMovSefipSaidaModel = new AssentamentoMovSefipSaidaModel($entityManager);

            /** @var MovSefipSaidaMovSefipRetornoModel $movSefipSaidaRetornoModel */
            $movSefipSaidaRetornoModel = new MovSefipSaidaMovSefipRetornoModel($entityManager);

            $paramsContratoServidor['cod_periodo_movimentacao'] = $inCodPeriodoMovimentacao['cod_periodo_movimentacao'];
            $paramsContratoServidor['entidade'] = '';
            $stOrdem = " ORDER BY servidor_pis_pasep,dt_admissao_n_formatado,cod_categoria";

            $stFiltroRegistroTrabalhadores = $this->processarFiltro($stTipoFiltro);
            $rsContratos = $contratoServidorModel->recuperaRegistroTrabalhadoresSEFIP($stFiltroRegistroTrabalhadores, $paramsContratoServidor, $stOrdem);

            $arrayCategoria = ["01", "02", "03", "04", "05", "06", "07", "11", "12", "19", "20", "21", "26"];

            //movimentação DO TRABALHADOR
            if (!$boCompetencia13 && !(in_array($inCodRecolhimento, [145, 307, 317, 327, 337, 345]))) {
                //Linha 605 do arquivo PRExportarSEFIP

                $arCompetencia = explode("/", $inCodPeriodoMovimentacao["dt_final"]);
                $stCompetencia1 = $arCompetencia[2] . "-" . $arCompetencia[1];
                $stCompetencia2 = date("Y-m", mktime(0, 0, 0, $arCompetencia[1] - 1, $arCompetencia[0], $arCompetencia[2]));
                $inIndex = 0;
                foreach ($rsContratos as $rsContrato) {
                    $stFiltroAssentamento = " AND assentamento_gerado_contrato_servidor.cod_contrato = " . $rsContrato->cod_contrato;
                    $stFiltroAssentamento .= " AND (cod_tipo = 2 OR cod_tipo = 3)\n";

                    $paramsSefip['dtCompetencia1'] = $stCompetencia1;
                    $paramsSefip['dtCompetencia2'] = $stCompetencia2;

                    $rsAssentamentoSEFIP = $assentamentoGeradoModel->recuperaAssentamentoSEFIP($paramsSefip, $stFiltroAssentamento);

                    $stFiltro = " AND cod_contrato = " . $rsContrato->cod_contrato;
                    $stFiltro .= " AND cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao['cod_periodo_movimentacao'];
                    $rsEventoRescisaoCalculado = $eventoRescisaoCalculadoModel->recuperaEventoRescisaoCalculado($stFiltro);

                    if (!empty($rsAssentamentoSEFIP) && in_array($rsContrato->cod_categoria, $arrayCategoria)) {
                        $arPeriodoMoviInicial = explode("/", $inCodPeriodoMovimentacao["dt_inicial"]);
                        $arPeriodoMoviFinal = explode("/", $inCodPeriodoMovimentacao["dt_final"]);
                        $dtPeriodoMoviInicial = $arPeriodoMoviInicial[2] . "-" . $arPeriodoMoviInicial[1] . "-" . $arPeriodoMoviInicial[0];
                        $dtPeriodoMoviFinal = $arPeriodoMoviFinal[2] . "-" . $arPeriodoMoviFinal[1] . "-" . $arPeriodoMoviFinal[0];
                        foreach ($rsAssentamentoSEFIP as $rsSefip) {
                            if (!($rsSefip['cod_tipo'] == 3 && empty($rsEventoRescisaoCalculado))) {
                                $inCodSefipSaida = "";
                                if ($rsSefip['cod_tipo'] == 3) {

                                    //Busca o cod_sefip_saida para assentamentos do tipo afastamento permanente
                                    $stFiltroSefipSaida = " AND contrato_servidor_caso_causa.cod_contrato = " . $rsContrato->cod_contrato;
                                    $rsSefipSaida = $causaRescisaoModel->recuperaSefipRescisao($stFiltroSefipSaida);
                                    $inCodSefipSaida = $rsSefipSaida->cod_sefip_saida;
                                }
                                if ($rsSefip['cod_tipo'] == 2) {
                                    //Busca o cod_sefip_saida para assentamentos do tipo afastamento temporário
                                    $stFiltroSefipSaida = " AND PAS.cod_assentamento  = " . $rsSefip['cod_assentamento'];
                                    $rsSefipSaida = $assentamentoMovSefipSaidaModel->recuperaRelacionamento($stFiltroSefipSaida);
                                    $inCodSefipSaida = $rsSefipSaida->cod_sefip_saida;
                                }

                                if ($inCodSefipSaida != "") {
                                    /** @var Sefip $rsSefip */
                                    $rsSefips = $entityManager->getRepository(Sefip::class)->findOneBy(
                                        [
                                            'codSefip' => $inCodSefipSaida
                                        ]
                                    );

                                    $inNumSefip = trim($rsSefips->getNumSefip());

                                    //indicativo_recolhimento_fgts
                                    $rsCategoriaMovimentacao = $entityManager->getRepository(MovSefipSaidaCategoria::class)->findBy(
                                        [
                                            'codSefipSaida' => $inCodSefipSaida,
                                            'codCategoria' => $rsContrato->cod_categoria
                                        ]
                                    );

                                    $boPeriodoInicial = false;
                                    $boPeriodoFinal = false;
                                    if ($rsSefip['cod_tipo'] == 3) {
                                        $boPeriodoInicial = true;
                                    } else {
                                        //Periodo inicial compreendido dentro do periodo de movimentação deverá entrar na sefip
                                        if ($rsSefip['periodo_inicial'] >= $dtPeriodoMoviInicial &&
                                            $rsSefip['periodo_inicial'] <= $dtPeriodoMoviFinal) {
                                            $boPeriodoInicial = true;
                                        }
                                        /*Periodo final compreendido dentro do periodo de movimentação deverá entrar na sefip
                                        também deverá entrar o periodo inicial na sefip*/
                                        if ($rsSefip['periodo_final'] >= $dtPeriodoMoviInicial &&
                                            $rsSefip['periodo_final'] <= $dtPeriodoMoviFinal) {
                                            $boPeriodoInicial = true;
                                            $boPeriodoFinal = true;
                                        }
                                        /*Periodo inicial não compeendido dentro do periodo de movimentação e menor que a data inicial do periodo de movimentação
                                        Periodo final não compeendido dentro do periodo de movimentação e maior que a data final do periodo de movimentação
                                        Timestamp do assentamento gerado compeendido dentro do periodo de movimentação*/
                                        $arTimestamp = explode(" ", $rsSefip['timestamp']);
                                        if ($rsSefip['periodo_inicial'] < $dtPeriodoMoviInicial &&
                                            $rsSefip['periodo_inicial'] < $dtPeriodoMoviFinal &&
                                            $rsSefip['periodo_final'] > $dtPeriodoMoviInicial &&
                                            $rsSefip['periodo_final'] > $dtPeriodoMoviFinal &&
                                            $arTimestamp[0] >= $dtPeriodoMoviInicial &&
                                            $arTimestamp[0] <= $dtPeriodoMoviFinal
                                        ) {
                                            $boPeriodoInicial = true;
                                        }

                                        if ($rsSefips->getRepetirMensal() == true &&
                                            $dtPeriodoMoviFinal >= $rsSefip['periodo_inicial'] &&
                                            $dtPeriodoMoviFinal <= $rsSefip['periodo_final']
                                        ) {
                                            $boPeriodoInicial = true;
                                        }
                                    }

                                    if ($boPeriodoInicial || $boPeriodoFinal) {
                                        $arIncluidoMovimentacao[$rsContrato->cod_contrato] = true;
                                        //Contador para Doença +15 dias
                                        if ($inNumSefip == "P1") {
                                            $this->inDoencaDias += 1;
                                        }
                                        //Contador para Acidente trabalho
                                        if (in_array($inNumSefip, ['O2', 'O3', 'U2', 'Z2', 'Z3', 'O1'])) {
                                            $this->inAcidenteTrabalho += 1;
                                        }
                                        //Contador para Licença Maternidade
                                        if (in_array($inNumSefip, ["Q2", "Q4", "Q5", "Q6", "Z1", "Q1"])) {
                                            $this->inLicencaMaternidade += 1;
                                        }
                                        //Contador para movimentação Definitiva
                                        if ($rsSefip['cod_tipo'] == 3) {
                                            $this->inRescisoes += 1;
                                        }
                                    }

                                    //Campo 12 - Indicativo de recolhimento do FGTS
                                    $arTemp = explode("-", $dtPeriodoMoviFinal);
                                    $stIndicativoRecolhimentoFgts = "";
                                    if (!empty($rsCategoriaMovimentacao)) {
                                        if (($arTemp[0] . "-" . $arTemp[1]) > "1998-01") {
                                            if (($rsCategoriaMovimentacao->indicativo == "S" || $rsCategoriaMovimentacao->indicativo == "N") && in_array($inNumSefip, ["I1", "I2", "I3", "I4", "L"])) {
                                                $stIndicativoRecolhimentoFgts = $rsCategoriaMovimentacao->indicativo;
                                            }
                                        } else {
                                            if ($rsCategoriaMovimentacao->indicativo != "S" && $rsCategoriaMovimentacao->indicativo != "N") {
                                                $stIndicativoRecolhimentoFgts = $rsCategoriaMovimentacao->indicativo;
                                            }
                                        }
                                        if (($rsCategoriaMovimentacao->indicativo == "S" || $rsCategoriaMovimentacao->indicativo == "N" || $rsCategoriaMovimentacao->indicativo == "C") && $boCompetencia13) {
                                            $stIndicativoRecolhimentoFgts = "";
                                        }
                                    }

                                    /*Verifica se deve ser informado a data de admissão - Só deverá ser informada a data de admissão
                                    para contratos que possuirem uma das seguinte categorias (01,03,04,05,06,07,11,12,19,20,21,26)*/
                                    if (in_array($rsContrato->cod_categoria, [01, 03, 04, 05, 06, 07, 11, 12, 19, 20, 21, 26])) {
                                        $dtAdmissao = $rsContrato->dt_admissao;
                                        $dtAdmissaoFormatada = str_replace("-", "", $rsContrato->dt_admissao_n_formatado);
                                    } else {
                                        $dtAdmissao = "";
                                        $dtAdmissaoFormatada = "";
                                    }

                                    if ($boPeriodoInicial) {
                                        $arPeriodoInicial = explode("-", $rsSefip['periodo_inicial']);
                                        $dtPeriodoInicial = $arPeriodoInicial[2] . $arPeriodoInicial[1] . $arPeriodoInicial[0];
                                        $arMovimentacaoTrabalhador[$inIndex]['tipo_registro'] = 32;
                                        $arMovimentacaoTrabalhador[$inIndex]['tipo_inscricao'] = 1;
                                        $arMovimentacaoTrabalhador[$inIndex]['inscricao_empresa'] = $inCNPJ;
                                        $arMovimentacaoTrabalhador[$inIndex]['tipo_inscricao_tomador'] = (in_array($inCodRecolhimento, [130, 135, 150, 155, 608])) ? 1 : "";
                                        $arMovimentacaoTrabalhador[$inIndex]['inscricao_tomador'] = (in_array($inCodRecolhimento, [130, 135, 150, 155, 608])) ? $arContratosAdidosCedidosTomador[$rsContrato->cod_contrato] : "";
                                        $arMovimentacaoTrabalhador[$inIndex]['pis_pasep'] = preg_replace("/[A-Za-z.\-]/", "", $rsContrato->servidor_pis_pasep);
                                        $arMovimentacaoTrabalhador[$inIndex]['data_admissao'] = $dtAdmissao;
                                        $arMovimentacaoTrabalhador[$inIndex]['data_admissao_n_formatado'] = $dtAdmissaoFormatada;
                                        $arMovimentacaoTrabalhador[$inIndex]['categoria_trabalhador'] = $rsContrato->cod_categoria;
                                        $arMovimentacaoTrabalhador[$inIndex]['nome_trabalhador'] = $this->removeAcentuacao($rsContrato->nom_cgm);
                                        /*Esse campo não é utilizado no arquivo da sefip
                                        serve apenas para a procura da informação mais abaixo no programa*/
                                        $arMovimentacaoTrabalhador[$inIndex]['registro'] = $rsContrato->registro;
                                        $arMovimentacaoTrabalhador[$inIndex]['cod_movimentacao'] = $inNumSefip;
                                        /*No arquivo da sefip, quando informar registros do tipo 32 - movimentacao do trabalhador,
                                        e nesse registro tratar-se de assentamento de afastamento temporário, o sistema deve
                                        informar na data de início do afastamento o dia imediatamente inferior ao dia registrado no
                                        assentamento. Esta regra (consta no layout) serve para todos os assentamentos de afastamento
                                        temporário e somente na data de início.*/
                                        if ($rsSefip['cod_tipo'] == 2) {
                                            $arMovimentacaoTrabalhador[$inIndex]['data_movimentacao'] = date("dmY", mktime(0, 0, 0, $arPeriodoInicial[1], $arPeriodoInicial[2] - 1, $arPeriodoInicial[0]));
                                        } else {
                                            $arMovimentacaoTrabalhador[$inIndex]['data_movimentacao'] = $dtPeriodoInicial;
                                        }
                                        $arMovimentacaoTrabalhador[$inIndex]['indicativo_recolhimento_fgts'] = $stIndicativoRecolhimentoFgts;
                                        $arMovimentacaoTrabalhador[$inIndex]['brancos'] = "";
                                        $arMovimentacaoTrabalhador[$inIndex]['final'] = "*";

                                        $inIndex++;
                                    }

                                    if ($boPeriodoFinal) {
                                        $stFiltroSefipRetorno = " AND cod_sefip_saida = " . $inCodSefipSaida;
                                        $rsMovSefipRetorno = $movSefipSaidaRetornoModel->recuperaMovSefipRetorno($stFiltroSefipRetorno);
                                        $arPeriodoFinal = explode("-", $rsAssentamentoSEFIP->getCampo("periodo_final"));
                                        $dtPeriodoFinal = $arPeriodoFinal[2] . $arPeriodoFinal[1] . $arPeriodoFinal[0];
                                        $arMovimentacaoTrabalhador[$inIndex]['tipo_registro'] = 32;
                                        $arMovimentacaoTrabalhador[$inIndex]['tipo_inscricao'] = 1;
                                        $arMovimentacaoTrabalhador[$inIndex]['inscricao_empresa'] = $inCNPJ;
                                        $arMovimentacaoTrabalhador[$inIndex]['tipo_inscricao_tomador'] = (in_array($inCodRecolhimento, [130, 135, 150, 155, 608])) ? 1 : "";
                                        $arMovimentacaoTrabalhador[$inIndex]['inscricao_tomador'] = (in_array($inCodRecolhimento, [130, 135, 150, 155, 608])) ? $arContratosAdidosCedidosTomador[$rsContrato->cod_contrato] : "";
                                        $arMovimentacaoTrabalhador[$inIndex]['pis_pasep'] = preg_replace("/[A-Za-z.\-]/", "", $rsContrato->servidor_pis_pasep);
                                        $arMovimentacaoTrabalhador[$inIndex]['data_admissao'] = $dtAdmissao;
                                        $arMovimentacaoTrabalhador[$inIndex]['data_admissao_n_formatado'] = $dtAdmissaoFormatada;
                                        $arMovimentacaoTrabalhador[$inIndex]['categoria_trabalhador'] = $rsContrato->cod_categoria;
                                        $arMovimentacaoTrabalhador[$inIndex]['nome_trabalhador'] = $this->removeAcentuacao($rsContrato->nom_cgm);
                                        //Esse campo não é utilizado no arquivo da sefip
                                        //serve apenas para a procura da informação mais abaixo no programa
                                        $arMovimentacaoTrabalhador[$inIndex]['registro'] = $rsContrato->registro;
                                        $arMovimentacaoTrabalhador[$inIndex]['cod_movimentacao'] = $rsMovSefipRetorno->num_sefip;
                                        $arMovimentacaoTrabalhador[$inIndex]['data_movimentacao'] = $dtPeriodoFinal;
                                        $arMovimentacaoTrabalhador[$inIndex]['indicativo_recolhimento_fgts'] = $stIndicativoRecolhimentoFgts;
                                        $arMovimentacaoTrabalhador[$inIndex]['brancos'] = "";
                                        $arMovimentacaoTrabalhador[$inIndex]['final'] = "*";
                                        $inIndex++;
                                    }
                                }
                            }
                        }
                    }
                }
            }

            //INICIO REGISTRO INFORMAÇÕES ADICIONAIS DO RECOLHIMENTO DA EMPRESA
            if ($boCompetencia13) {
                $ar = 0;//retirar
            }
            //FIM REGISTRO INFORMAÇÕES ADICIONAIS DO RECOLHIMENTO DA EMPRESA

            //INICIO TOMADOR DE SERVIÇO
            if (in_array($inCodRecolhimento, [130, 135, 150, 155, 211, 317, 337, 608])) {
                $ar = 0;//retirar
            }
            //FIM TOMADOR DE SERVIÇO

            /** @var ContratoServidorPrevidenciaModel $contratoServidorPrevidenciaModel */
            $contratoServidorPrevidenciaModel = new ContratoServidorPrevidenciaModel($entityManager);

            /** @var EventoCalculadoModel $eventoCalculadoModel */
            $eventoCalculadoModel = new EventoCalculadoModel($entityManager);

            /** @var EventoComplementarCalculadoModel $eventoComplementarCalculadoModel */
            $eventoComplementarCalculadoModel = new EventoComplementarCalculadoModel($entityManager);

            /** @var EventoRescisaoCalculadoModel $eventoRescisaoCalculadoModel */
            $eventoRescisaoCalculadoModel = new EventoRescisaoCalculadoModel($entityManager);

            /** @var EventoFeriasCalculadoModel $eventoFeriasCalculadoModel */
            $eventoFeriasCalculadoModel = new EventoFeriasCalculadoModel($entityManager);

            /** @var EventoDecimoCalculadoModel $eventoDecimoCalculadoModel */
            $eventoDecimoCalculadoModel = new EventoDecimoCalculadoModel($entityManager);

            /** @var PrevidenciaEventoModel $previdenciaEventoModel */
            $previdenciaEventoModel = new PrevidenciaEventoModel($entityManager);

            /** @var ContratoServidorCasoCausaModel $contratoServidorCasoCausaModel */
            $contratoServidorCasoCausaModel = new ContratoServidorCasoCausaModel($entityManager);

            //INICIO MOVIMENTAÇÃO DO TRABALHADOR
            $inIndex = $arEventoSalarioCalculado = $arEventoComplementarCalculado = $arEventoRescisaoCalculado =
            $arEventoRescisaoCalculadoDesDecimo = $arEventoFeriasCalculado = $arEventosDecimoCalculadosDesD =
            $nuEventoBaseCalculadoPrevidenciaDecimoDesD = $arEventosDecimoCalculados = $arEventosCalculados = 0;
            $arRegistroTrabalhador = $arAuxRegistroCategoria13 = [];

            $stFiltroRegistroTrabalhadores = $this->processarFiltro($stTipoFiltro);
            $rsContratos = $contratoServidorModel->recuperaRegistroTrabalhadoresSEFIP($stFiltroRegistroTrabalhadores, $paramsContratoServidor, $stOrdem);

            foreach ($rsContratos as $rsContrato) {
                $nuEventoBaseCalculadoRescisaoDesD = $nuBaseCalculo1323 = $nuValorDescontado = $nuRemuneracaoBase = $nuRemuneracao13
                    = $nuRemuneracaoSem13 = $nuEventoCalculadoPrevidencia = $nuEventoBaseCalculadoPrevidencia = $nuEventoDescontoCalculadoPrevidencia
                    = $nuEventoBaseCalculadoFGTS = $nuEventoBaseCalculadoFGTSDecimo = $nuEventoRescisaoCalculadoDesDecimo = $nuEventoBaseCalculadoPrevidencia
                    = $nuEventoBaseCalculadoPrevidenciaDecimoDesD = $nuEventoBaseCalculadoRescisaoDesD = $nuEventoDescontoCalculadoPrevidencia
                    = $nuEventoDescontoCalculadoPrevidenciaDecimo = 0;

                /*EVENTO DE BASE DE FGTS
                EVENTO CALCULADOS (SALÁRIO/COMPLEMENTAR/RESCISÃO/FÉRIAS) DE FGTS*/

                $stFiltro = " AND cod_contrato = " . $rsContrato->cod_contrato;
                $stFiltro .= " AND evento_calculado.cod_evento = " . $rsEventoFgts->cod_evento;
                $stFiltro .= " AND cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao["cod_periodo_movimentacao"];
                $rsEventoCalculados = $eventoCalculadoModel->montaRecuperaEventosCalculados($stFiltro);

                $stFiltro = " AND cod_contrato = " . $rsContrato->cod_contrato;
                $stFiltro .= " AND evento_complementar_calculado.cod_evento = " . $rsEventoFgts->cod_evento;
                $stFiltro .= " AND cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao["cod_periodo_movimentacao"];
                $stFiltro .= " AND evento_complementar_calculado.cod_configuracao != 3";
                $rsEventoComplementarCalculado = $eventoComplementarCalculadoModel->recuperaEventoComplementarCalculadoParaRelatorio($stFiltro);

                $stFiltro = " AND cod_contrato = " . $rsContrato->cod_contrato;
                $stFiltro .= " AND evento_rescisao_calculado.cod_evento = " . $rsEventoFgts->cod_evento;
                $stFiltro .= " AND cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao["cod_periodo_movimentacao"];
                $stFiltro .= " AND evento_rescisao_calculado.desdobramento != 'D'";
                $rsEventoRescisaoCalculado = $eventoRescisaoCalculadoModel->recuperaEventoRescisaoCalculado($stFiltro);

                $stFiltro = " AND cod_contrato = " . $rsContrato->cod_contrato;
                $stFiltro .= " AND evento_ferias_calculado.cod_evento = " . $rsEventoFgts->cod_evento;
                $stFiltro .= " AND cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao["cod_periodo_movimentacao"];
                $stFiltro .= " AND (evento_ferias_calculado.desdobramento = 'F' OR evento_ferias_calculado.desdobramento = 'A')";
                $rsEventoFeriasCalculado = $eventoFeriasCalculadoModel->montaRecuperaEventosCalculados($stFiltro);

                $valorEventoComplementarCalculado = (!empty($rsEventoComplementarCalculado)) ? $rsEventoComplementarCalculado['valor'] : 0;
                $valorEventoCalculados = (!empty($rsEventoCalculados)) ? $rsEventoCalculados->valor : 0;
                $valorEventoRescisaoCalculado = (!empty($rsEventoRescisaoCalculado)) ? $rsEventoRescisaoCalculado['valor'] : 0;
                $valorEventoFeriasCalculado = (!empty($rsEventoFeriasCalculado)) ? $rsEventoFeriasCalculado['valor'] : 0;

                $nuEventoBaseCalculadoFGTS = $valorEventoCalculados + $valorEventoComplementarCalculado + $valorEventoRescisaoCalculado + $valorEventoFeriasCalculado;

                /*EVENTO CALCULADOS (SALÁRIO/COMPLEMENTAR/RESCISÃO/FÉRIAS) DE FGTS
                EVENTO CALCULADOS (DÉCIMO) DE FGTS*/
                $stFiltro = " AND cod_contrato = " . $rsContrato->cod_contrato;
                $stFiltro .= " AND evento_decimo_calculado.cod_evento = " . $rsEventoFgts->cod_evento;
                $stFiltro .= " AND cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao["cod_periodo_movimentacao"];
                $stFiltro .= " AND evento_decimo_calculado.desdobramento = 'A'";
                $rsEventosDecimoCalculados = $eventoDecimoCalculadoModel->montaRecuperaEventosCalculados($stFiltro);

                $nuEventoBaseCalculadoFGTSDecimo = ($rsEventosDecimoCalculados) ? $rsEventosDecimoCalculados->valor : 0;
                /*EVENTO CALCULADOS (DÉCIMO) DE FGTS
                EVENTO DE BASE DE FGTS*/
                $arPeriodoMoviInicial = explode("/", $inCodPeriodoMovimentacao["dt_inicial"]);
                $arPeriodoMoviFinal = explode("/", $inCodPeriodoMovimentacao["dt_final"]);
                $dtPeriodoMoviInicial = $arPeriodoMoviInicial[2] . "-" . $arPeriodoMoviInicial[1] . "-" . $arPeriodoMoviInicial[0];
                $dtPeriodoMoviFinal = $arPeriodoMoviFinal[2] . "-" . $arPeriodoMoviFinal[1] . "-" . $arPeriodoMoviFinal[0];

                //PREVIDÊNCIA
                $stFiltroPrevidencia = " AND contrato_servidor_previdencia.cod_contrato = " . $rsContrato->cod_contrato;
                $stFiltroPrevidencia .= " AND contrato_servidor_previdencia.bo_excluido  = 'f'";
                $stFiltroPrevidencia .= " AND (SELECT true
                                                 FROM folhapagamento.previdencia_previdencia
                                                    , (  SELECT cod_previdencia
                                                              , max(timestamp) as timestamp
                                                           FROM folhapagamento.previdencia_previdencia
                                                          WHERE previdencia_previdencia.vigencia <= '" . $dtPeriodoMoviFinal . "'
                                                       GROUP BY cod_previdencia) as max_previdencia_previdencia
                                                WHERE previdencia_previdencia.cod_previdencia  = max_previdencia_previdencia.cod_previdencia
                                                  AND previdencia_previdencia.timestamp        = max_previdencia_previdencia.timestamp
                                                  AND previdencia_previdencia.tipo_previdencia = 'o'
                                                  AND previdencia_previdencia.cod_previdencia  = contrato_servidor_previdencia.cod_previdencia)";

                $rsPrevidencia = $contratoServidorPrevidenciaModel->recuperaRelacionamento($stFiltroPrevidencia);

                //EVENTO DE BASE DE PREVIDÊNCIA
                if (!empty($rsPrevidencia)) {
                    $stFiltroEventoPrevidencia = " AND contrato_servidor_previdencia.cod_contrato = " . $rsContrato->cod_contrato;
                    $stFiltroEventoPrevidencia .= " AND contrato_servidor_previdencia.cod_previdencia = " . $rsPrevidencia->cod_previdencia;
                    $stFiltroEventoPrevidencia .= " AND cod_tipo = 2";
                    $rsEventoPrevidencia = $previdenciaEventoModel->recuperaEventosDePrevidenciaPorContrato($stFiltroEventoPrevidencia);

                    //EVENTO CALCULADOS (SALÁRIO/COMPLEMENTAR/RESCISÃO/FÉRIAS) DE PREVIDÊNCIA
                    $stFiltro = " AND cod_contrato = " . $rsContrato->cod_contrato;
                    $stFiltro .= " AND evento_calculado.cod_evento = " . $rsEventoPrevidencia['cod_evento'];
                    $stFiltro .= " AND cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao['cod_periodo_movimentacao'];
                    $stFiltro .= " AND (desdobramento IS NULL OR desdobramento = 'F')";
                    $rsEventosCalculados = $eventoCalculadoModel->montaRecuperaEventosCalculados($stFiltro);
                    if (!empty($rsEventoCalculados)) {
                        $arEventoSalarioCalculado .= $rsEventosCalculados["valor"];
                    }

                    $stFiltro = " AND cod_contrato = " . $rsContrato->cod_contrato;
                    $stFiltro .= " AND evento_complementar_calculado.cod_evento = " . $rsEventoPrevidencia['cod_evento'];
                    $stFiltro .= " AND cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao['cod_periodo_movimentacao'];
                    $stFiltro .= " AND evento_complementar_calculado.cod_configuracao != 3";
                    $rsEventoComplementarCalculado = $eventoComplementarCalculadoModel->recuperaEventoComplementarCalculadoParaRelatorio($stFiltro);
                    if (!empty($rsEventoComplementarCalculado)) {
                        $arEventoComplementarCalculado .= $rsEventoComplementarCalculado["valor"];
                    }

                    $stFiltro = " AND cod_contrato = " . $rsContrato->cod_contrato;
                    $stFiltro .= " AND evento_rescisao_calculado.cod_evento = " . $rsEventoPrevidencia['cod_evento'];
                    $stFiltro .= " AND cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao['cod_periodo_movimentacao'];
                    $stFiltro .= " AND evento_rescisao_calculado.desdobramento != 'D'";
                    $rsEventoRescisaoCalculado = $eventoRescisaoCalculadoModel->recuperaEventoRescisaoCalculado($stFiltro);
                    if (!empty($rsEventoRescisaoCalculado)) {
                        $arEventoRescisaoCalculado .= $rsEventoRescisaoCalculado["valor"];
                    }

                    $stFiltro = " WHERE cod_contrato = " . $rsContrato->cod_contrato;
                    $stFiltro .= " AND dt_rescisao BETWEEN to_date('" . $inCodPeriodoMovimentacao["dt_inicial"] . "','dd-mm-yyyy') AND to_date('" . $inCodPeriodoMovimentacao["dt_final"] . "','dd-mm-yyyy')";
                    $rsContratoRescisao = $contratoServidorCasoCausaModel->recuperaTodos($stFiltro);

                    foreach ($rsContratoRescisao as $contratoRescisao) {
                        $stFiltro = " AND cod_contrato = " . $rsContrato->cod_contrato;
                        $stFiltro .= " AND evento_rescisao_calculado.cod_evento = " . $rsEventoPrevidencia['cod_evento'];
                        $stFiltro .= " AND cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao['cod_periodo_movimentacao'];
                        $stFiltro .= " AND evento_rescisao_calculado.desdobramento = 'D'";
                        $rsEventoRescisaoCalculado = $eventoRescisaoCalculadoModel->recuperaEventoRescisaoCalculado($stFiltro);
                        if (!empty($rsEventoRescisaoCalculado)) {
                            $arEventoRescisaoCalculadoDesDecimo .= $rsEventoRescisaoCalculado["valor"];
                            $nuEventoRescisaoCalculadoDesDecimo = $rsEventoRescisaoCalculado["valor"];
                        }
                        if ($nuEventoRescisaoCalculadoDesDecimo == '0' || $nuEventoRescisaoCalculadoDesDecimo == '0.00' || $nuEventoRescisaoCalculadoDesDecimo == "") {
                            $nuEventoRescisaoCalculadoDesDecimo = "0.01";
                        }
                    }

                    $stFiltro = " AND cod_contrato = " . $rsContrato->cod_contrato;
                    $stFiltro .= " AND evento_ferias_calculado.cod_evento = " . $rsEventoPrevidencia['cod_evento'];
                    $stFiltro .= " AND cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao['cod_periodo_movimentacao'];
                    $stFiltro .= " AND (evento_ferias_calculado.desdobramento = 'F' OR evento_ferias_calculado.desdobramento = 'A')";
                    $rsEventoFeriasCalculado = $eventoFeriasCalculadoModel->montaRecuperaEventosCalculados($stFiltro);
                    if (!empty($rsEventoFeriasCalculado)) {
                        $arEventoFeriasCalculado .= $rsEventoFeriasCalculado["valor"];
                    }

                    $nuEventoBaseCalculadoPrevidencia = $arEventoSalarioCalculado["valor"] + $arEventoComplementarCalculado["valor"] + $arEventoRescisaoCalculado["valor"] + $arEventoFeriasCalculado["valor"];
                    //EVENTO CALCULADOS (SALÁRIO/COMPLEMENTAR/RESCISÃO/FÉRIAS) DE PREVIDÊNCIA

                    //EVENTO CALCULADOS (DECIMO) DE PREVIDÊNCIA
                    $stFiltro = " AND cod_contrato = " . $rsContrato->cod_contrato;
                    $stFiltro .= " AND evento_decimo_calculado.cod_evento = " . $rsEventoPrevidencia['cod_evento'];
                    $stFiltro .= " AND cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao['cod_periodo_movimentacao'];
                    $stFiltro .= " AND evento_decimo_calculado.desdobramento = 'D'";
                    $rsEventosDecimoCalculadosDesD = $eventoDecimoCalculadoModel->montaRecuperaEventosCalculados($stFiltro);
                    if (!empty($rsEventosDecimoCalculadosDesD)) {
                        $arEventosDecimoCalculadosDesD .= $rsEventosDecimoCalculadosDesD["valor"];
                        $nuEventoBaseCalculadoPrevidenciaDecimoDesD = $arEventosDecimoCalculadosDesD["valor"];
                    }

                    if ($boCompetencia13) {
//                        Sessao::write("nuBasePrevidencia13",Sessao::read("nuBasePrevidencia13")+$nuEventoBaseCalculadoPrevidenciaDecimoDesD);
                    }
                    //EVENTO CALCULADOS (DECIMO) DE PREVIDÊNCIA

                    //EVENTO CALCULADOS (RESCISÃO) DE PREVIDÊNCIA
                    $stFiltro = " AND contrato_servidor_caso_causa.cod_contrato = " . $rsContrato->cod_contrato;
                    $rsSefipContratoRescisao = $contratoServidorCasoCausaModel->recuperaSefipContrato($stFiltro);
                    if (trim($rsSefipContratoRescisao->num_sefip) != 'H') {
                        $stFiltro = " AND cod_contrato = " . $rsContrato->cod_contrato;
                        $stFiltro .= " AND evento_rescisao_calculado.cod_evento = " . $rsEventoPrevidencia['cod_evento'];
                        $stFiltro .= " AND evento_rescisao_calculado.desdobramento = 'D'";
                        $stFiltro .= " AND cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao['cod_periodo_movimentacao'];
                        $rsEventoRescisaoCalculado = $eventoRescisaoCalculadoModel->recuperaEventoRescisaoCalculado($stFiltro);
                        if (!empty($rsEventoRescisaoCalculado)) {
                            $arEventoRescisaoCalculado .= $rsEventoRescisaoCalculado["valor"];
                            $nuEventoBaseCalculadoRescisaoDesD = $arEventoRescisaoCalculado["valor"];
                        }
                    }
                    //EVENTO CALCULADOS (RESCISÃO) DE PREVIDÊNCIA
                }
                //EVENTO DE BASE DE PREVIDÊNCIA
                //EVENTO DE DESCONTO DE PREVIDÊNCIA
                if (!empty($rsPrevidencia)) {
                    $stFiltroEventoPrevidencia = " AND contrato_servidor_previdencia.cod_contrato = " . $rsContrato->cod_contrato;
                    $stFiltroEventoPrevidencia .= " AND contrato_servidor_previdencia.cod_previdencia = " . $rsPrevidencia->cod_previdencia;
                    $stFiltroEventoPrevidencia .= " AND cod_tipo = 1";
                    $rsEventoPrevidencia = $previdenciaEventoModel->recuperaEventosDePrevidenciaPorContrato($stFiltroEventoPrevidencia);

                    //EVENTO CALCULADOS (SALÁRIO/COMPLEMENTAR/RESCISÃO/FÉRIAS) DE PREVIDÊNCIA
                    $stFiltro = " AND cod_contrato = " . $rsContrato->cod_contrato;
                    $stFiltro .= " AND evento_calculado.cod_evento = " . $rsEventoPrevidencia['cod_evento'];
                    $stFiltro .= " AND cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao['cod_periodo_movimentacao'];
                    $rsEventosCalculados = $eventoCalculadoModel->montaRecuperaEventosCalculados($stFiltro);
                    if (!empty($rsEventoCalculados)) {
                        $arEventosCalculados .= $rsEventosCalculados["valor"];
                    }

                    $stFiltro = " AND cod_contrato = " . $rsContrato->cod_contrato;
                    $stFiltro .= " AND evento_complementar_calculado.cod_evento = " . $rsEventoPrevidencia['cod_evento'];
                    $stFiltro .= " AND cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao['cod_periodo_movimentacao'];
                    $stFiltro .= " AND evento_complementar_calculado.cod_configuracao != 3";
                    $rsEventoComplementarCalculado = $eventoComplementarCalculadoModel->recuperaEventoComplementarCalculadoParaRelatorio($stFiltro);
                    if (!empty($rsEventoComplementarCalculado)) {
                        $arEventoComplementarCalculado .= $rsEventoComplementarCalculado["valor"];
                    }

                    $stFiltro = " AND cod_contrato = " . $rsContrato->cod_contrato;
                    $stFiltro .= " AND evento_rescisao_calculado.cod_evento = " . $rsEventoPrevidencia['cod_evento'];
                    $stFiltro .= " AND cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao['cod_periodo_movimentacao'];
                    $stFiltro .= " AND evento_rescisao_calculado.desdobramento != 'D'";
                    $rsEventoRescisaoCalculado = $eventoRescisaoCalculadoModel->recuperaEventoRescisaoCalculado($stFiltro);
                    if (!empty($rsEventoRescisaoCalculado)) {
                        $arEventoRescisaoCalculado .= $rsEventoRescisaoCalculado["valor"];
                    }

                    $stFiltro = " AND cod_contrato = " . $rsContrato->cod_contrato;
                    $stFiltro .= " AND evento_ferias_calculado.cod_evento = " . $rsEventoPrevidencia['cod_evento'];
                    $stFiltro .= " AND cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao['cod_periodo_movimentacao'];
                    $stFiltro .= " AND (evento_ferias_calculado.desdobramento = 'F' OR evento_ferias_calculado.desdobramento = 'A')";
                    $rsEventoFeriasCalculado = $eventoFeriasCalculadoModel->montaRecuperaEventosCalculados($stFiltro);
                    if (!empty($rsEventoFeriasCalculado)) {
                        $arEventoFeriasCalculado .= $rsEventoFeriasCalculado["valor"];
                    }

                    $nuEventoDescontoCalculadoPrevidencia = $arEventosCalculados['valor'] + $arEventoComplementarCalculado["valor"] + $arEventoRescisaoCalculado["valor"] + $arEventoFeriasCalculado["valor"];
                    //EVENTO CALCULADOS (SALÁRIO/COMPLEMENTAR/RESCISÃO/FÉRIAS) DE PREVIDÊNCIA
                    //EVENTO CALCULADOS (DECIMO) DE PREVIDÊNCIA
                    $stFiltro = " AND cod_contrato = " . $rsContrato->cod_contrato;
                    $stFiltro .= " AND evento_decimo_calculado.cod_evento = " . $rsEventoPrevidencia['cod_evento'];
                    $stFiltro .= " AND cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao['cod_periodo_movimentacao'];
                    $stFiltro .= " AND evento_decimo_calculado.desdobramento = 'D'";
                    $rsEventosDecimoCalculados = $eventoDecimoCalculadoModel->montaRecuperaEventosCalculados($stFiltro);
                    if (!empty($rsEventosDecimoCalculados)) {
                        $arEventosDecimoCalculados .= $rsEventosDecimoCalculados["valor"];
                        $nuEventoDescontoCalculadoPrevidenciaDecimo = $arEventosDecimoCalculados["valor"];
                    }

                    //EVENTO CALCULADOS (DECIMO) DE PREVIDÊNCIA
                }
                //EVENTO DE DESCONTO DE PREVIDÊNCIA
                //PREVIDÊNCIA
                if ($boCompetencia13) {
                    $nuTotalLinha = $nuEventoBaseCalculadoFGTSDecimo + $nuEventoBaseCalculadoPrevidenciaDecimoDesD + $nuEventoDescontoCalculadoPrevidenciaDecio;
                } else {
                    $nuTotalLinha = $nuEventoBaseCalculadoFGTS + $nuEventoBaseCalculadoFGTSDecimo + $nuEventoBaseCalculadoPrevidencia + $nuEventoBaseCalculadoPrevidenciaDecimoDesD + $nuEventoBaseCalculadoRescisaoDesD + $nuEventoDescontoCalculadoPrevidencia + $nuEventoDescontoCalculadoPrevidenciaDecimo;
                }

                if ($nuTotalLinha > 0) {
                    $stFiltroRescisao = " WHERE cod_contrato = " . $rsContrato->cod_contrato;
                    $rsRescisao = $contratoServidorCasoCausaModel->recuperaTodos($stFiltroRescisao);

                    //remuneracao_sem_13
                    $nuRemuneracaoSem13 = $nuEventoBaseCalculadoFGTS;
//                    Sessao::write("nuBaseFGTS", Sessao::read("nuBaseFGTS")+$nuEventoBaseCalculadoFGTS);

                    $nuRemuneracaoSem13 = $nuEventoBaseCalculadoPrevidencia;
//                    Sessao::write("nuBasePrevidenciaS13", Sessao::read("nuBasePrevidenciaS13")+$nuEventoBaseCalculadoPrevidencia);

                    if (!strpos($nuRemuneracaoSem13, ".")) {
                        $nuRemuneracaoSem13 .= ".00";
                    }
                    //remuneracao_sem_13
                    //remuneracao_13
                    $nuRemuneracao13 = $nuEventoBaseCalculadoFGTSDecimo;
//                    Sessao::write("nuBaseFGTS13", Sessao::read("nuBaseFGTS13")+$nuEventoBaseCalculadoFGTSDecimo);
                    if ($nuRemuneracao13 == 0) {
                        $nuRemuneracao13 = $nuEventoBaseCalculadoPrevidenciaDecimoDesD;
//                        Sessao::write("nuBasePrevidencia13", Sessao::read("nuBasePrevidencia13") + $nuEventoBaseCalculadoPrevidenciaDecimoDesD);
                    }
                    //remuneracao_13
                    //Verificação de assentamento de afastamento temporário para maternidade (Q1,Q2,Q3,Q4,Q5,Q6) para o contrato
                    $stFiltroAssentamento = " AND assentamento_mov_sefip_saida.cod_sefip_saida IN (18,19,20,21,22,23)\n";
                    $stFiltroAssentamento .= " AND assentamento_gerado_contrato_servidor.cod_contrato = " . $rsContrato->cod_contrato;
                    $stFiltroAssentamento .= " AND cod_tipo = 2 \n";
                    $stFiltroAssentamento .= " AND (to_char(periodo_inicial,'yyyy-mm-dd')::date BETWEEN to_date('" . $inCodPeriodoMovimentacao["dt_inicial"] . "','dd-mm-yyyy')
                                                                                            AND to_date('" . $inCodPeriodoMovimentacao["dt_final"] . "','dd-mm-yyyy')\n";
                    $stFiltroAssentamento .= "   OR (to_char(periodo_final,'yyyy-mm-dd'))::date  BETWEEN to_date('" . $inCodPeriodoMovimentacao["dt_inicial"] . "','dd-mm-yyyy')
                                                                                            AND to_date('" . $inCodPeriodoMovimentacao["dt_final"] . "','dd-mm-yyyy'))\n";
                    $params['dtCompetencia1'] = $stCompetencia1;
                    $params['dtCompetencia2'] = $stCompetencia2;
                    $rsAssentamentoSEFIP = $assentamentoGeradoModel->recuperaAssentamentoTemporario($params, $stFiltroAssentamento);

                    $boMultiploVinculo = false;
                    if (empty($rsAssentamentoSEFIP)) {
                        $stFiltroContratosCGM = " AND numcgm = " . $rsContrato->numcgm;
                        $contratoModel = new ContratoModel($entityManager);
                        $rsContratosCGM = $contratoModel->recuperaCgmDoRegistro($stFiltroContratosCGM);

                        if (count($rsContratosCGM) >= 2) {
                            foreach ($rsContratosCGM as $contratosCGM) {
                                if ($contratosCGM['cod_contrato'] != $rsContrato->cod_contrato) {
                                    //EVENTO CALCULADOS (DÉCIMO) DE PREVIDÊNCIA
                                    $stFiltro = " AND cod_contrato = " . $rsContrato->cod_contrato;
                                    $stFiltro .= " AND cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao['cod_periodo_movimentacao'];
                                    $rsEventoDecimoCalculado = $eventoDecimoCalculadoModel->montaRecuperaEventosCalculados($stFiltro);
                                    if (!empty($rsEventoDecimoCalculado)) {
                                        $boMultiploVinculo = true;
                                        break;
                                    }
                                    //EVENTO CALCULADOS (DÉCIMO) DE PREVIDÊNCIA

                                    //EVENTO CALCULADOS (SALÁRIO/COMPLEMENTAR/RESCISÃO/FÉRIAS) DE PREVIDÊNCIA
                                    $stFiltro = " AND cod_contrato = " . $contratosCGM['cod_contrato'];
                                    $stFiltro .= " AND cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao['cod_periodo_movimentacao'];
                                    $rsEventosCalculados = $eventoCalculadoModel->montaRecuperaEventosCalculados($stFiltro);
                                    if (!empty($rsEventosCalculados)) {
                                        $boMultiploVinculo = true;
                                        break;
                                    }
                                    $stFiltro = " AND cod_contrato = " . $contratosCGM['cod_contrato'];
                                    $stFiltro .= " AND cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao['cod_periodo_movimentacao'];
                                    $stFiltro .= " AND evento_complementar_calculado.cod_configuracao != 3";
                                    $rsEventoComplementarCalculado = $eventoComplementarCalculadoModel->recuperaEventoComplementarCalculadoParaRelatorio($stFiltro);
                                    if (!empty($rsEventoComplementarCalculado)) {
                                        $boMultiploVinculo = true;
                                        break;
                                    }
                                    $stFiltro = " AND cod_contrato = " . $contratosCGM['cod_contrato'];
                                    $stFiltro .= " AND cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao['cod_periodo_movimentacao'];
                                    $stFiltro .= " AND evento_rescisao_calculado.desdobramento != 'D'";
                                    $rsEventoRescisaoCalculado = $eventoRescisaoCalculadoModel->recuperaEventoRescisaoCalculado($stFiltro);
                                    if (!empty($rsEventoRescisaoCalculado)) {
                                        $boMultiploVinculo = true;
                                        break;
                                    }
                                    $stFiltro = " AND cod_contrato = " . $contratosCGM['cod_contrato'];
                                    $stFiltro .= " AND cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao['cod_periodo_movimentacao'];
                                    $rsEventoFeriasCalculado = $eventoFeriasCalculadoModel->montaRecuperaEventosCalculados($stFiltro);
                                    if (!empty($rsEventoFeriasCalculado)) {
                                        $boMultiploVinculo = true;
                                        break;
                                    }
                                    //EVENTO CALCULADOS (SALÁRIO/COMPLEMENTAR/RESCISÃO/FÉRIAS) DE PREVIDÊNCIA
                                }
                            }
                        }
                    }

                    if (count($rsPrevidencia) == 1) {
                        /** @var DescontoExternoPrevidenciaModel $descontoExternoPrevidenciaModel */
                        $descontoExternoPrevidenciaModel = new DescontoExternoPrevidenciaModel($entityManager);
                        $stFiltro = " AND desconto_externo_previdencia.timestamp <= ";
                        $stFiltro .= " (ultimotimestampperiodomovimentacao(" . $inCodPeriodoMovimentacao['cod_periodo_movimentacao'];
                        $stFiltro .= " ,'')::timestamp)";

                        $params["cod_contrato"] = $rsContrato->cod_contrato;
                        $params["vigencia"] = $inCodPeriodoMovimentacao["dt_inicial"];
                        $rsDescontoExternoPrevidencia = $descontoExternoPrevidenciaModel->recuperaRelacionamento($params, $stFiltro);

                        if (!empty($rsDescontoExternoPrevidencia)) {
                            $boMultiploVinculo = true;
                        }
                    }

                    if (!empty($rsAssentamentoSEFIP) || $boMultiploVinculo) {
                        if ($boCompetencia13) {
                            if ($boMultiploVinculo) {
                                $nuValorDescontado = number_format($nuEventoDescontoCalculadoPrevidenciaDecimo, 2, '.', '');
                            }
                        } else {
                            $nuValorDescontado = number_format($nuEventoDescontoCalculadoPrevidencia, 2, '.', '');
                        }
//                        Sessao::write("nuDescontoPrevidenciaS13", Sessao::read("nuDescontoPrevidenciaS13")+$nuEventoDescontoCalculadoPrevidencia);
                    } else {
                        $nuValorDescontado = 0;
                        //Contratos calculados que não possuem multiplos vinculos ou SALÁRIO maternidade
//                        Sessao::write("nuDescontoPrevidenciaS13DemaisOcor", Sessao::read("nuDescontoPrevidenciaS13DemaisOcor")+$nuEventoDescontoCalculadoPrevidencia);
                    }
                    //valor_descontado
                    //ocorrencia
                    $stOcorrencia = ($boMultiploVinculo && $rsContrato->cod_categoria != 13) ? "05" : $rsContrato->num_ocorrencia;
                    //ocorrencia
                    //remuneracao_base
                    $nuRemuneracaoBase = 0;
                    if ($arIncluidoMovimentacao[$rsContrato->cod_contrato]) {
                        $stFiltroMovSefip = " AND cod_tipo = 2";
                        $stFiltroMovSefip .= " AND num_sefip IN ('O1','O2','R','Z2','Z3','Z4')";
                        $stFiltroMovSefip .= " AND assentamento_gerado_contrato_servidor.cod_contrato = " . $rsContrato->cod_contrato;
                        $rsAssentamentoMovSefip = $assentamentoMovSefipSaidaModel->recuperaAfastamentoTemporarioSefip($stFiltroMovSefip);

                        $nuRemuneracaoBase = 0;
                        if (count($rsPrevidencia) == 1 && !empty($rsAssentamentoMovSefip)) {
                            $nuRemuneracaoBase = $nuEventoBaseCalculadoPrevidencia;
                        }
                    }
                    //remuneracao_base
                    //base_calculo_13_22
                    $nuBaseCalculo1322 = $nuEventoBaseCalculadoRescisaoDesD;
                    //base_calculo_13_22
                    //base_calculo_13_23
                    $nuBaseCalculo1323 = 0;
                    if (count($rsPrevidencia) == 1 && $boDezembro && empty($rsRescisao)) {
                        $nuBaseCalculo1323 = $nuEventoBaseCalculadoPrevidenciaDecimoDesD;
                    }
                    //base_calculo_13_23
                    //inscricao_tomador
                    if (in_array($inCodRecolhimento, [130, 135, 150, 155, 211, 317, 337, 608]) && $arContratosAdidosCedidosTomador[$rsContrato->cod_contrato] != "") {
                        $inTipoInscricaoTomador = 1;
                    } else {
                        $inTipoInscricaoTomador = "";
                    }
                    //inscricao_tomador
                    //data_opcao
                    $dtOpcao = $rsContrato->dt_opcao_fgts;

                    $nuDataAdmissao = $rsContrato->dt_opcao_fgts;
                    $nuDataAdmissao = substr($nuDataAdmissao, 4, 4) . substr($nuDataAdmissao, 2, 2) . substr($nuDataAdmissao, 0, 2);
                    if ($dtOpcao == "") {
                        if ($nuDataAdmissao > 19881005) {
                            $dtOpcao = $rsContrato->dt_admissao;
                        } else {
                            $dtOpcao = '05101988';
                        }
                    } else {
                        $nuDataOpcao = $rsContrato->dt_opcao_fgts;
                        $nuDataOpcao = substr($nuDataOpcao, 4, 4) . substr($nuDataOpcao, 2, 2) . substr($nuDataOpcao, 0, 2);

                        if ($nuDataOpcao > $nuDataAdmissao) {
                            if ($nuDataOpcao <= 19881005) {
                                $dtOpcao = '05101988';
                            }
                        } else {
                            if ($nuDataOpcao > 19881005) {
                                $dtOpcao = $rsContrato->dt_admissao;
                            } else {
                                $dtOpcao = '05101988';
                            }
                        }
                    }
                    //data_opcao
                    //No caso da matricula, consta no layout que a informação NÃO deve constar em casos de trabalhadores
                    //com categoria = 06,13,14,15,16,17,18,22,23,24,25. Para os demais casos pode constar.
                    if (!in_array($rsContrato->cod_categoria, [06, 13, 14, 15, 16, 17, 18, 22, 23, 24, 25])) {
                        $inRegistro = $rsContrato->registro;
                    } else {
                        $inRegistro = "";
                    }
                    //Verifica se deve ser informado a data de admissão - Só deverá ser informada a data de admissão
                    //para contratos que possuirem uma das seguinte categorias (01,03,04,05,06,07,11,12,19,20,21,26)
                    if (in_array($rsContrato->cod_categoria, [01, 03, 04, 05, 06, 07, 11, 12, 19, 20, 21, 26])) {
                        $dtAdmissao = $rsContrato->dt_admissao;
                        $dtAdmissaoFormatada = str_replace("-", "", $rsContrato->dt_admissao_n_formatado);
                    } else {
                        $dtAdmissao = "";
                        $dtAdmissaoFormatada = "";
                    }

                    if (!empty($rsAssentamentoSEFIP) || $boMultiploVinculo) {
                        if ($boCompetencia13) {
                            if ($boMultiploVinculo) {
                                $nuValorDescontado = number_format($nuEventoDescontoCalculadoPrevidenciaDecimo, 2, '.', '');
                            }
                        } else {
                            $nuValorDescontado = number_format($nuEventoDescontoCalculadoPrevidencia, 2, '.', '');
                        }
//                        Sessao::write("nuDescontoPrevidenciaS13", Sessao::read("nuDescontoPrevidenciaS13")+$nuEventoDescontoCalculadoPrevidencia);
                    } else {
                        $nuValorDescontado = 0;
                        //Contratos calculados que não possuem multiplos vinculos ou SALÁRIO maternidade
//                        Sessao::write("nuDescontoPrevidenciaS13DemaisOcor", Sessao::read("nuDescontoPrevidenciaS13DemaisOcor")+$nuEventoDescontoCalculadoPrevidencia);
                    }
                    //valor_descontado
                    //ocorrencia
                    $stOcorrencia = ($boMultiploVinculo && $rsContrato->cod_categoria != 13) ? "05" : $rsContrato->num_ocorrencia;
                    //ocorrencia
                    //remuneracao_base
                    $nuRemuneracaoBase = 0;
                    if ($arIncluidoMovimentacao[$rsContrato->cod_contrato]) {
                        $stFiltroMovSefip = " AND cod_tipo = 2";
                        $stFiltroMovSefip .= " AND num_sefip IN ('O1','O2','R','Z2','Z3','Z4')";
                        $stFiltroMovSefip .= " AND assentamento_gerado_contrato_servidor.cod_contrato = " . $rsContrato->cod_contrato;
                        $rsAssentamentoMovSefip = $assentamentoMovSefipSaidaModel->recuperaAfastamentoTemporarioSefip($stFiltroMovSefip);

                        $nuRemuneracaoBase = 0;
                        if (count($rsPrevidencia) == 1 && !empty($rsAssentamentoMovSefip)) {
                            $nuRemuneracaoBase = $nuEventoBaseCalculadoPrevidencia;
                        }
                    }
                    //remuneracao_base
                    //base_calculo_13_22
                    $nuBaseCalculo1322 = $nuEventoBaseCalculadoRescisaoDesD;
                    //base_calculo_13_22
                    //base_calculo_13_23
                    $nuBaseCalculo1323 = 0;
                    if (count($rsPrevidencia) == 1 && $boDezembro && empty($rsRescisao)) {
                        $nuBaseCalculo1323 = $nuEventoBaseCalculadoPrevidenciaDecimoDesD;
                    }
                    //base_calculo_13_23
                    //inscricao_tomador
                    if (in_array($inCodRecolhimento, [130, 135, 150, 155, 211, 317, 337, 608]) && $arContratosAdidosCedidosTomador[$rsContrato->cod_contrato] != "") {
                        $inTipoInscricaoTomador = 1;
                    } else {
                        $inTipoInscricaoTomador = "";
                    }
                    //inscricao_tomador
                    //data_opcao
                    $dtOpcao = $rsContrato->dt_opcao_fgts;

                    $nuDataAdmissao = $rsContrato->dt_opcao_fgts;
                    $nuDataAdmissao = substr($nuDataAdmissao, 4, 4) . substr($nuDataAdmissao, 2, 2) . substr($nuDataAdmissao, 0, 2);
                    if ($dtOpcao == "") {
                        if ($nuDataAdmissao > 19881005) {
                            $dtOpcao = $rsContrato->dt_admissao;
                        } else {
                            $dtOpcao = '05101988';
                        }
                    } else {
                        $nuDataOpcao = $rsContrato->dt_opcao_fgts;
                        $nuDataOpcao = substr($nuDataOpcao, 4, 4) . substr($nuDataOpcao, 2, 2) . substr($nuDataOpcao, 0, 2);

                        if ($nuDataOpcao > $nuDataAdmissao) {
                            if ($nuDataOpcao <= 19881005) {
                                $dtOpcao = '05101988';
                            }
                        } else {
                            if ($nuDataOpcao > 19881005) {
                                $dtOpcao = $rsContrato->dt_admissao;
                            } else {
                                $dtOpcao = '05101988';
                            }
                        }
                    }
                    //data_opcao
                    //No caso da matricula, consta no layout que a informação NÃO deve constar em casos de trabalhadores
                    //com categoria = 06,13,14,15,16,17,18,22,23,24,25. Para os demais casos pode constar.
                    if (!in_array($rsContrato->cod_categoria, [06, 13, 14, 15, 16, 17, 18, 22, 23, 24, 25])) {
                        $inRegistro = $rsContrato->registro;
                    } else {
                        $inRegistro = "";
                    }
                    //Verifica se deve ser informado a data de admissão - Só deverá ser informada a data de admissão
                    //para contratos que possuirem uma das seguinte categorias (01,03,04,05,06,07,11,12,19,20,21,26)
                    if (in_array($rsContrato->cod_categoria, [01, 03, 04, 05, 06, 07, 11, 12, 19, 20, 21, 26])) {
                        $dtAdmissao = $rsContrato->dt_admissao;
                        $dtAdmissaoFormatada = str_replace("-", "", $rsContrato->dt_admissao_n_formatado);
                    } else {
                        $dtAdmissao = "";
                        $dtAdmissaoFormatada = "";
                    }

                    $rsContratoRescisao = $entityManager->getRepository(ContratoServidorCasoCausa::class)
                        ->findOneBy(
                            [
                                'codContrato' => $rsContrato->cod_contrato,
                            ]
                        );

                    $arRegistroTrabalhador[$inIndex]['tipo_registro'] = 30;
                    $arRegistroTrabalhador[$inIndex]['tipo_inscricao'] = 1;
                    $arRegistroTrabalhador[$inIndex]['inscricao_empresa'] = $inCNPJ;
                    $arRegistroTrabalhador[$inIndex]['tipo_inscricao_tomador'] = $inTipoInscricaoTomador;
                    $arRegistroTrabalhador[$inIndex]['inscricao_tomador'] = (in_array($inCodRecolhimento, [130, 135, 150, 155, 211, 317, 337, 608])) ? $arContratosAdidosCedidosTomador[$rsContrato->cod_contrato] : "";
                    $arRegistroTrabalhador[$inIndex]['pis_pasep'] = preg_replace("[A-Za-z.\-]", "", $rsContrato->servidor_pis_pasep);
                    $arRegistroTrabalhador[$inIndex]['data_admissao'] = $dtAdmissao;
                    $arRegistroTrabalhador[$inIndex]['data_admissao_n_formatado'] = $dtAdmissaoFormatada;
                    $arRegistroTrabalhador[$inIndex]['categoria_trabalhador'] = $rsContrato->cod_categoria;
                    $arRegistroTrabalhador[$inIndex]['nome_trabalhador'] = $this->removeAcentuacao($rsContrato->nom_cgm);
                    $arRegistroTrabalhador[$inIndex]['matricula_empregado'] = $inRegistro;
                    $arRegistroTrabalhador[$inIndex]['numero_ctps'] = (in_array($rsContrato->cod_categoria, [1, 2, 3, 4, 6, 7, 26])) ? str_pad(trim($rsContrato->numero), 7, "0", STR_PAD_LEFT) : "";
                    $arRegistroTrabalhador[$inIndex]['serie_ctps'] = (in_array($rsContrato->cod_categoria, [1, 2, 3, 4, 6, 7, 26])) ? str_pad(trim($rsContrato->serie), 5, "0", STR_PAD_LEFT) : "";
                    $arRegistroTrabalhador[$inIndex]['data_opcao'] = (in_array($rsContrato->cod_categoria, [1, 3, 4, 5, 6, 7])) ? $dtOpcao : "";
                    $arRegistroTrabalhador[$inIndex]['data_nascimento'] = (in_array($rsContrato->cod_categoria, [1, 2, 3, 4, 6, 7, 12, 19, 20, 21, 26])) ? $rsContrato->dt_nascimento : "";
                    $arRegistroTrabalhador[$inIndex]['cbo'] = "0" . substr($rsContrato->cbo, 0, strlen($rsContrato->cbo) - 1);
                    $arRegistroTrabalhador[$inIndex]['remuneracao_sem_13'] = (!$boCompetencia13) ? str_replace(".", "", number_format($nuRemuneracaoSem13, 2, ".", "")) : "";
                    $arRegistroTrabalhador[$inIndex]['remuneracao_13'] = (!$boCompetencia13) ? (empty($rsContratoRescisao)) ? str_replace(".", "", number_format($nuRemuneracao13, 2, ".", "")) : "" : "";
                    $arRegistroTrabalhador[$inIndex]['classe_contribuicao'] = "";
                    $arRegistroTrabalhador[$inIndex]['ocorrencia'] = ($stOcorrencia == 0) ? "" : str_pad($stOcorrencia, 2, "0", STR_PAD_LEFT);

                    if ($rsContrato->cod_categoria != 13) {
                        $arRegistroTrabalhador[$inIndex]['valor_descontado'] = str_replace(".", "", number_format($nuValorDescontado, 2, ".", ""));
                    } else {
                        $arRegistroTrabalhador[$inIndex]['valor_descontado'] = 0;
                    }
                    $arRegistroTrabalhador[$inIndex]['remuneracao_base'] = (!$boCompetencia13) ? str_replace(".", "", number_format($nuRemuneracaoBase, 2, ".", "")) : "";

                    if (in_array($rsContrato->cod_categoria, [1, 2, 4, 6, 7, 12, 13, 19, 20, 21, 26])) {
                        if ($boCompetencia13) {
                            $arRegistroTrabalhador[$inIndex]['base_calculo_13_22'] = str_replace(".", "", number_format($nuEventoBaseCalculadoPrevidenciaDecimoDesD, 2, ".", ""));
                        } else {
                            if ($rsContratos->getCampo('cod_categoria') != 13) {
                                //Campo somente preenchido para contratos rescindidos
                                $arRegistroTrabalhador[$inIndex]['base_calculo_13_22'] = ($rsContratoRescisao->getNumLinhas() == 1) ? str_replace(".", "", number_format($nuEventoRescisaoCalculadoDesDecimo, 2, ".", "")) : "";
                            } else {
                                $arRegistroTrabalhador[$inIndex]['base_calculo_13_22'] = 0;
                            }
                        }
                    } else {
                        $arRegistroTrabalhador[$inIndex]['base_calculo_13_22'] = 0;
                    }

                    $arRegistroTrabalhador[$inIndex]['base_calculo_13_23'] = (!$boCompetencia13) ? str_replace(".", "", number_format($nuBaseCalculo1323, 2, ".", "")) : "";
                    $arRegistroTrabalhador[$inIndex]['brancos'] = "";
                    $arRegistroTrabalhador[$inIndex]['final'] = "*";

//                    Sessao::write("inTotalServidoresArquivo", Sessao::read("inTotalServidoresArquivo")+1);

                    //Booleano para controlar contratos de categoria 13 e com miltiplas matriculas ja foi inserido no array
                    $boRegistroRepetido = $boPularRegistro = false;
                    //Controlar contratos de categoria 13 e com miltiplas matriculas somando seus valores
                    //1946 e 1802 , 1738 e 1948
                    if ($rsContrato->cod_categoria == 13) {
                        $stPisPasepContratoAnterior = $rsContrato->servidor_pis_pasep;
                        //Avança um registro para verificar se existe outra matricula para o mesmo servidor
                        if (next($rsContratos)) {
                            if ($boRegistroRepetido == true) {
                                $arRegistroTrabalhador[0]['remuneracao_sem_13'] = $arRegistroTrabalhador[0]['remuneracao_sem_13'] + $arAuxRegistroCategoria13[0]['remuneracao_sem_13'];
                                $arRegistroTrabalhador[0]['remuneracao_13'] = $arRegistroTrabalhador[0]['remuneracao_13'] + $arAuxRegistroCategoria13[0]['remuneracao_13'];
                                $arRegistroTrabalhador[0]['remuneracao_base'] = $arRegistroTrabalhador[0]['remuneracao_base'] + $arAuxRegistroCategoria13[0]['remuneracao_base'];
                                $arRegistroTrabalhador[0]['base_calculo_13_23'] = $arRegistroTrabalhador[0]['base_calculo_13_23'] + $arAuxRegistroCategoria13[0]['base_calculo_13_23'];
                                $boRegistroRepetido = false;
                                $boPularRegistro = false;
                            } else {
                                if ($stPisPasepContratoAnterior == $rsContrato->servidor_pis_pasep) {
                                    $arAuxRegistroCategoria13 = $arRegistroTrabalhador;
                                    $boPularRegistro = true;
                                    $boRegistroRepetido = true;
                                }
                            }
                            //Volta para o registro corrente
                            current($rsContratos);
                        } else {
                            //Verifica se o ultimo registro é o repetido
                            if ($boRegistroRepetido == true) {
                                $arRegistroTrabalhador[0]['remuneracao_sem_13'] = $arRegistroTrabalhador[0]['remuneracao_sem_13'] + $arAuxRegistroCategoria13[0]['remuneracao_sem_13'];
                                $arRegistroTrabalhador[0]['remuneracao_13'] = $arRegistroTrabalhador[0]['remuneracao_13'] + $arAuxRegistroCategoria13[0]['remuneracao_13'];
                                $arRegistroTrabalhador[0]['remuneracao_base'] = $arRegistroTrabalhador[0]['remuneracao_base'] + $arAuxRegistroCategoria13[0]['remuneracao_base'];
                                $arRegistroTrabalhador[0]['base_calculo_13_23'] = $arRegistroTrabalhador[0]['base_calculo_13_23'] + $arAuxRegistroCategoria13[0]['base_calculo_13_23'];
                            }
                            $boRegistroRepetido = false;
                            $boPularRegistro = false;
                        }
                    }

                    if ($boPularRegistro == false) {
//                        addRegistroTrabalhador($obExportador,$arRegistroTrabalhador);
                    }

                    if (is_array($arMovimentacaoTrabalhador)) {
                        foreach ($arMovimentacaoTrabalhador as $inIndexTrab => $arDados) {
                            if ($arDados["registro"] == $rsContrato->registro) {
                                //addMovimentacaoTrabalhador($obExportador,array($arDados));
                                unset($arMovimentacaoTrabalhador[$inIndexTrab]);
                                reset($arMovimentacaoTrabalhador);
                            }
                        }
                    }
                }
            }
            //REGISTRO DO TRABALHADOR
            //REGISTRO TOTALIZADOR DO ARQUIVO
            $inIndex = 0;
            $arFinal[$inIndex]['tipo_registro'] = 90;
            $arFinal[$inIndex]['marca'] = str_pad("9", 51, "9");
            $arFinal[$inIndex]['brancos'] = str_pad("", 306);
            $arFinal[$inIndex]['final'] = "*";
            $arFinalTrailer[0] = $arFinal[$inIndex];
            //REGISTRO TOTALIZADOR DO ARQUIVO


            if (in_array($rsContrato->cod_categoria, [1, 2, 4, 6, 7, 12, 13, 19, 20, 21, 26])) {
                if ($boCompetencia13) {
                    $arRegistroTrabalhador[$inIndex]['base_calculo_13_22'] = str_replace(".", "", number_format($nuEventoBaseCalculadoPrevidenciaDecimoDesD, 2, ".", ""));
                } else {
                    if ($rsContratos->getCampo('cod_categoria') != 13) {
                        //Campo somente preenchido para contratos rescindidos
                        $arRegistroTrabalhador[$inIndex]['base_calculo_13_22'] = ($rsContratoRescisao->getNumLinhas() == 1) ? str_replace(".", "", number_format($nuEventoRescisaoCalculadoDesDecimo, 2, ".", "")) : "";
                    } else {
                        $arRegistroTrabalhador[$inIndex]['base_calculo_13_22'] = 0;
                    }
                }
            }

            $arRegistroTrabalhador[$inIndex]['base_calculo_13_23'] = (!$boCompetencia13) ? str_replace(".", "", number_format($nuBaseCalculo1323, 2, ".", "")) : "";
            $arRegistroTrabalhador[$inIndex]['brancos'] = "";
            $arRegistroTrabalhador[$inIndex]['final'] = "*";

//                    Sessao::write("inTotalServidoresArquivo", Sessao::read("inTotalServidoresArquivo")+1);

            $arquivos = array_merge($arHeader, $arHeaderEmp);
            //REGISTRO DO TRABALHADOR
            //REGISTRO TOTALIZADOR DO ARQUIVO
            $inIndex = 0;
            $arFinal[$inIndex]['tipo_registro'] = 90;
            $arFinal[$inIndex]['marca'] = str_pad("9", 51, "9");
            $arFinal[$inIndex]['brancos'] = str_pad("", 306);
            $arFinal[$inIndex]['final'] = "*";
            $arFinalTrailer[0] = $arFinal[$inIndex];
            //REGISTRO TOTALIZADOR DO ARQUIVO

            $arquivos = array_merge($arHeader, $arHeaderEmp, $arFinalTrailer);
            $date = new \DateTime();
            $filename = sprintf('SEFIP_%s_%s.re', $inIndexArquivo, $date->format('YmdHis'));

            $fp = fopen('/tmp/' . $filename, 'w');

            foreach ($arquivos as $arquivo) {
                fwrite($fp, implode("", $arquivo));
            }
            fclose($fp);
            $inIndexArquivo++;
        }
    }

    /**
     * @param $stFiltroEvento
     * @param $entityManager
     * @param $nuTotal
     *
     * @return mixed
     */
    public function geraSomaValoresMaternidadeSalarioFamilia($stFiltroEvento, $entityManager, $nuTotal)
    {

        /** @var EventoCalculadoModel $eventoCalculadoModel */
        $eventoCalculadoModel = new EventoCalculadoModel($entityManager);
        $rsEventoCalculados = $eventoCalculadoModel->montaRecuperaEventosCalculados($stFiltroEvento);

        $arTotalSalarioMaternidade = (!empty($rsEventoCalculados["valor"])) ? $rsEventoCalculados["valor"] : 0;
        $nuTotal += $arTotalSalarioMaternidade["valor"];

        /** @var EventoComplementarCalculadoModel $eventoComplementarCalculadoModel */
        $eventoComplementarCalculadoModel = new EventoComplementarCalculadoModel($entityManager);
        $rsEventoCalculados = $eventoComplementarCalculadoModel->montaRecuperaEventosCalculados($stFiltroEvento);

        $arTotalSalarioMaternidade = (!empty($rsEventoCalculados["valor"])) ? $rsEventoCalculados["valor"] : 0;
        $nuTotal += $arTotalSalarioMaternidade["valor"];

        /** @var EventoDecimoCalculadoModel $eventoDecimoCalculadoModel */
        $eventoDecimoCalculadoModel = new EventoDecimoCalculadoModel($entityManager);
        $this->rsEventoCalculadosDecimo = $eventoDecimoCalculadoModel->montaRecuperaEventosCalculados($stFiltroEvento);

        $arTotalSalarioMaternidade = (!empty($rsEventoCalculadosDecimo["valor"])) ? $rsEventoCalculadosDecimo["valor"] : 0;
        $nuTotal += $arTotalSalarioMaternidade["valor"];

        /** @var EventoFeriasCalculadoModel $eventoFericasCalculadoModel */
        $eventoFericasCalculadoModel = new EventoFeriasCalculadoModel($entityManager);
        $rsEventoCalculados = $eventoFericasCalculadoModel->montaRecuperaEventosCalculados($stFiltroEvento);

        $arTotalSalarioMaternidade = (!empty($rsEventoCalculados["valor"])) ? $rsEventoCalculados["valor"] : 0;
        $nuTotal += $arTotalSalarioMaternidade["valor"];

        /** @var EventoRescisaoCalculadoModel $eventoRescisaoCalculadoModel */
        $eventoRescisaoCalculadoModel = new EventoRescisaoCalculadoModel($entityManager);
        $rsEventoCalculados = $eventoRescisaoCalculadoModel->recuperaEventoRescisaoCalculado($stFiltroEvento);

        $arTotalSalarioMaternidade = (!empty($rsEventoCalculados["valor"])) ? $rsEventoCalculados["valor"] : 0;
        $nuTotal += $arTotalSalarioMaternidade["valor"];

        return $nuTotal;
    }

    /**
     * @param $str
     *
     * @return string
     */
    public function removeAcentuacao($str)
    {
        $from = 'ÀÁÃÂÉÊÍÓÕÔÚÜÇàáãâéêíóõôúüç';
        $to = 'AAAAEEIOOOUUCaaaaeeiooouuc';

        return strtr($str, $from, $to);
    }

    /**
     * @param $stTipoFiltro
     *
     * @return array
     */
    public function processarFiltro($stTipoFiltro)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $form = $this->getForm();
        $contratos = $form->get('codContrato')->getData();
        $inCodLotacaoSelecionados = $form->get('lotacao')->getData();
        $inCodLocalSelecionados = $form->get('local')->getData();
        $stFiltro = $stJoin = '';
        $inCodMes = ($form->get('mes')->getData() > 9) ? $form->get('mes')->getData() : "0" . $form->get('mes')->getData();

        $dtCompetencia = $inCodMes . "/" . $form->get('ano')->getData();

        /** @var PeriodoMovimentacao $periodoMovimentacao */
        $inCodPeriodoMovimentacao = $entityManager->getRepository(PeriodoMovimentacao::class)
            ->consultaPeriodoMovimentacaoCompetencia($dtCompetencia);

        switch ($stTipoFiltro) {
            case "cgm_contrato":
            case "matricula":
                foreach ($contratos as $arContrato) {
                    $arr[] = $arContrato->getCodContrato();
                }

                $stCodContrato = implode(",", $arr);
                if (count($arr) > 1) {
                    $stCodContrato = substr($stCodContrato, 0, strlen($stCodContrato) - 1);
                }
                $stFiltro = " AND contrato.cod_contrato IN (" . $stCodContrato . ")";
                break;
            case "lotacao":
                $stFiltroContratos = implode(",", $inCodLotacaoSelecionados);
                $stFiltro .= " AND contrato_servidor_orgao.cod_orgao in (" . $stFiltroContratos . ") \n";
                break;
            case "local":
                foreach ($inCodLocalSelecionados as $inCodLocal) {
                    $local[] = $inCodLocal->getCodLocal();
                    $stFiltroContratos = implode(",", $local);
                }
                $stJoin = "    INNER JOIN (SELECT contrato_servidor_local.* 
                                        FROM pessoal.contrato_servidor_local
                                        INNER JOIN ( SELECT cod_contrato
                                                            ,cod_local
                                                            , MAX(timestamp) as timestamp
                                                        FROM pessoal.contrato_servidor_local
                                                        WHERE timestamp <= (ultimotimestampperiodomovimentacao(" . $inCodPeriodoMovimentacao['cod_periodo_movimentacao'] . ",'')::timestamp)
                                                        GROUP BY 1,2
                                                    )as max
                                            ON max.cod_contrato = contrato_servidor_local.cod_contrato
                                            AND max.cod_local = contrato_servidor_local.cod_local
                                            AND max.timestamp = contrato_servidor_local.timestamp
                            ) as contrato_servidor_local \n";
                $stJoin .= "       ON contrato.cod_contrato = contrato_servidor_local.cod_contrato         \n";
                $stJoin .= "      AND contrato_servidor_local.cod_local IN (" . $stFiltroContratos . ")               \n";
                break;
        }
//        $stFiltro .= Sessao::read("stFiltroRegistroTrabalhadoresExtra");
        $filtro = ['stFiltro' => $stFiltro, 'stJoin' => $stJoin];

        return $filtro;
    }

    /**
     * @param $arHeaderArquivo
     *
     * @return mixed
     */
    public function formataHeaderArquivo($arHeaderArquivo)
    {
        $arHeader[0]['tipo_registro'] = str_pad($arHeaderArquivo['tipo_registro'], 2);
        $arHeader[0]['brancos'] = $arHeaderArquivo['brancos'];
        $arHeader[0]['tipo_remessa'] = str_pad($arHeaderArquivo['tipo_remessa'], 1);
        $arHeader[0]['tipo_inscricao'] = str_pad($arHeaderArquivo['tipo_inscricao'], 1);
        $arHeader[0]['inscricao_resp'] = str_pad($arHeaderArquivo['inscricao_resp'], 14);
        $nomeResp = substr($arHeaderArquivo['nome_resp'], 0, 30);
        $arHeader[0]['nome_resp'] = str_pad($nomeResp, 30);
        $nomePessoaContato = substr($arHeaderArquivo['nome_pessoa_contato'], 0, 20);
        $arHeader[0]['nome_pessoa_contato'] = str_pad($nomePessoaContato, 20);
        $stLogradouro = substr($arHeaderArquivo['logradouro'], 0, 50);
        $arHeader[0]['logradouro'] = str_pad($stLogradouro, 50);
        $stBairro = substr($arHeaderArquivo['bairro'], 0, 20);
        $arHeader[0]['bairro'] = str_pad($stBairro, 20);
        $arHeader[0]['cep'] = str_pad($arHeaderArquivo['cep'], 8);
        $cidade = substr($arHeaderArquivo['cidade'], 0, 20);
        $arHeader[0]['cidade'] = str_pad($cidade, 20);
        $arHeader[0]['unid_federal'] = str_pad($arHeaderArquivo['unid_federal'], 2);
        $arHeader[0]['fone_contato'] = str_pad($arHeaderArquivo['fone_contato'], 12);
        $arHeader[0]['email'] = str_pad($arHeaderArquivo['email'], 60);
        $arHeader[0]['competencia'] = str_pad($arHeaderArquivo['competencia'], 6);
        $arHeader[0]['recolhimento'] = str_pad($arHeaderArquivo['recolhimento'], 3);
        $arHeader[0]['ind_recolhimento'] = str_pad($arHeaderArquivo['ind_recolhimento'], 1);
        $arHeader[0]['modalidade'] = str_pad($arHeaderArquivo['modalidade'], 1);
        $arHeader[0]['data_recolhimento_fgts'] = str_pad($arHeaderArquivo['data_recolhimento_fgts'], 8);
        $arHeader[0]['ind_recolhimento_previdencia'] = str_pad($arHeaderArquivo['ind_recolhimento_previdencia'], 1);
        $arHeader[0]['data_recolhimento_previdencia'] = str_pad($arHeaderArquivo['data_recolhimento_previdencia'], 8);
        $arHeader[0]['indice_recolhimento'] = str_pad($arHeaderArquivo['indice_recolhimento'], 7);
        $arHeader[0]['tipo_inscricao_fornecedor'] = str_pad($arHeaderArquivo['tipo_inscricao_fornecedor'], 1);
        $arHeader[0]['inscricao_fornecedor'] = str_pad($arHeaderArquivo['inscricao_fornecedor'], 14);
        $arHeader[0]['brancos2'] = str_pad($arHeaderArquivo['brancos2'], 18);
        $arHeader[0]['final'] = str_pad($arHeaderArquivo['final'], 1);
        $arHeader[0]['quebra'] = "\r\n";

        return $arHeader;
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
        $arHeaderArquivo['tipo_registro'] = "00";
        $arHeaderArquivo['brancos'] = str_pad('', 51);
        $arHeaderArquivo['tipo_remessa'] = $params["inTipoRemessa"];
        $arHeaderArquivo['tipo_inscricao'] = 1;
        $arHeaderArquivo['inscricao_resp'] = $params["inCNPJ"];
        $arHeaderArquivo['nome_resp'] = $params["stNomePrefeitura"];
        $arHeaderArquivo['nome_pessoa_contato'] = substr($params["stPessoaContato"], 0, 20);
        $arHeaderArquivo['logradouro'] = substr(str_replace(".", "", $params["stLogradouro"]), 0, 50);
        $arHeaderArquivo['bairro'] = substr($params["stBairro"], 0, 20);
        $arHeaderArquivo['cep'] = $params["inCep"];
        $arHeaderArquivo['cidade'] = $this->removeAcentuacao($params["municipio"]);
        $arHeaderArquivo['unid_federal'] = $params["uf"];
        $arHeaderArquivo['fone_contato'] = $params["stDDDContato"] . $params["stTelefoneContato"];
        $arHeaderArquivo['email'] = substr($params["stEmailContato"], 0, 60);

        if ($params["boCompetencia13"]) {
            $dtCompetencia = $params["ano"] . "13";
        } else {
            $inMes = $params["inCodMes"];
            $inMes = str_pad($inMes, 2, "0", STR_PAD_LEFT);
            $dtCompetencia = $params["ano"] . $inMes;
        }

        if ($params["boSefipRetificadora"] == "sim") {
            $params["stModalidade"] = 9;
        }

        $form = $this->getForm();
        $dtRecolimentoPrevidencia = (!empty($params["dtRecolhimentoPrevidencia"])) ? $form->get("dtRecolhimentoPrevidencia")->getData()->format('d/m/Y') : $params["dtRecolhimentoPrevidencia"];
        $dtRecolhimentoFGTS = (!empty($params["dtRecolhimentoFGTS"])) ? $form->get("dtRecolhimentoFGTS")->getData()->format('d/m/Y') : $params["dtRecolhimentoFGTS"];

        $arHeaderArquivo['competencia'] = $dtCompetencia;
        $arHeaderArquivo['recolhimento'] = $params["inCodRecolhimento"];
        $arHeaderArquivo['ind_recolhimento'] = $params["inCodIndicadorRecolhimento"];
        $arHeaderArquivo['modalidade'] = $params["stModalidade"];
        $arHeaderArquivo['data_recolhimento_fgts'] = str_replace("/", "", $dtRecolhimentoFGTS);
        $arHeaderArquivo['ind_recolhimento_previdencia'] = $params["inCodIndicadorRecolhimentoPrevidencia"];
        $arHeaderArquivo['data_recolhimento_previdencia'] = str_replace("/", "", $dtRecolimentoPrevidencia);
        $arHeaderArquivo['indice_recolhimento'] = "";

        /** @var ConfiguracaoModel $configuracaoModel */
        $configuracaoModel = new ConfiguracaoModel($this->getEntityManager());
        $tipoInscricao = $configuracaoModel->getConfiguracao('tipo_inscricao', Modulo::MODULO_IMA, true, $params["exercicio"]);
        $arHeaderArquivo['tipo_inscricao_fornecedor'] = $tipoInscricao;
        $inscricaoFornecedor = $configuracaoModel->getConfiguracao('inscricao_fornecedor', Modulo::MODULO_IMA, true, $params["exercicio"]);

        switch ($tipoInscricao) {
            case 1:
                $swCgmModel = new SwCgmModel($this->getEntityManager());
                /** @var SwCgm $cgm */
                $cgm = $swCgmModel->findOneByNumcgm($inscricaoFornecedor);
                $stInscricao = $cgm->getFkSwCgmPessoaJuridica()->getCnpj();
                break;
            case 2:
                $stInscricao = $inscricaoFornecedor;
                break;
            case 3:
                $swCgmModel = new SwCgmModel($this->getEntityManager());
                /** @var SwCgm $cgm */
                $cgm = $swCgmModel->findOneByNumcgm($inscricaoFornecedor);
                $stInscricao = $cgm->getFkSwCgmPessoaFisica()->getCpf();
                break;
        }

        $arHeaderArquivo['inscricao_fornecedor'] = $stInscricao;
        $arHeaderArquivo['brancos2'] = "";
        $arHeaderArquivo['final'] = "*";

        return $arHeaderArquivo;
    }

    /**
     * @param array $params
     * @param       $rsSalarioEvento
     * @param       $entidade
     *
     * @return array
     */
    public function geraHeaderEmpresa(array $params, $rsSalarioEvento, Entidade $entidade)
    {
        $arHeaderEmpresa = [];
        $arHeaderEmpresa['tipo_registro'] = 10;
        $arHeaderEmpresa['tipo_inscricao'] = 1;
        $arHeaderEmpresa['inscricao_empresa'] = $params["inCNPJ"];
        $arHeaderEmpresa['zeros'] = 0;
        $arHeaderEmpresa['nome_empresa'] = substr($params["stNomePrefeitura"], 0, 40);
        $arHeaderEmpresa['logradouro'] = str_replace(".", "", substr($params["stLogradouro"], 0, 50));
        $arHeaderEmpresa['bairro'] = substr($params["stBairro"], 0, 20);
        $arHeaderEmpresa['cep'] = $params["inCep"];
        $arHeaderEmpresa['cidade'] = $this->removeAcentuacao($params["municipio"]);
        $arHeaderEmpresa['unid_federal'] = $params["uf"];
        $fone = (trim($entidade->getFkSwCgm()->getFoneResidencial()) != "") ? trim($entidade->getFkSwCgm()->getFoneResidencial()) : trim($entidade->getFkSwCgm()->getFoneComercial());
        $arHeaderEmpresa['fone'] = $fone;
        $arHeaderEmpresa['indicador_alteracao'] = "n";
        $arHeaderEmpresa['cnae_fiscal'] = preg_replace("/[A-Za-z.\/-]/", "", $params["cnaeFiscal"]);
        $arHeaderEmpresa['indicador_alteracao_cnae'] = "n";

        /** @var PrevidenciaRegimeRatModel $previdenciaRegimeRatModel */
        $previdenciaRegimeRatModel = new PrevidenciaRegimeRatModel($this->getEntityManager());
        $rsRat = $previdenciaRegimeRatModel->recuperaAliquotaSefip();

        $arHeaderEmpresa['aliquota_rat'] = str_replace('.', '', $rsRat->aliquota_rat);

//      Sessao::write("aliquota_rat", $rsRat->getCampo("aliquota_rat"));
        $arHeaderEmpresa['centralizacao'] = $params["centralizacao"];
        $arHeaderEmpresa['simples'] = 1;
        $arHeaderEmpresa['fpas'] = $params["fpas"];
        $dtCompetenciaFPas = $params["ano"] . "-" . $params["inCodMes"];
        $arHeaderEmpresa['outras_entidades'] = ($params["fpas"] == 582 and $dtCompetenciaFPas >= "1998-10") ? $params['stCodigoOutrasEntidades'] : "";
        $arHeaderEmpresa['gps'] = $params["gps"];
        $arHeaderEmpresa['filantropia'] = "";

        if ($params["boCompetencia13"]) {
            $params['nuTotalSalarioFamilia'] = 0;
        } else {
            $stFiltroEvento = " AND evento.cod_evento = " . $rsSalarioEvento->cod_evento;
            $stFiltroEvento .= " AND cod_periodo_movimentacao = " . $params["cod_periodo_movimentacao"];
            $stFiltroEvento .= " AND cod_contrato IN (" . $params["stCodContratos"] . ")";
            if ($params["stCodContratosAdidosCedidos"] != "") {
                $stFiltroEvento .= " AND cod_contrato NOT IN (" . $params["stCodContratosAdidosCedidos"] . ")";
            }

            $nuTotalSalarioFamilia = $this->geraSomaValoresMaternidadeSalarioFamilia(
                $stFiltroEvento,
                $this->getEntityManager(),
                $params['nuTotalSalarioFamilia']
            );
//                        Sessao::write("nuSalarioFamilia", Sessao::read("nuSalarioFamilia") + $nuTotalSalarioFamilia);
        }

        $arHeaderEmpresa['salario_familia'] = str_replace('.', '', number_format($nuTotalSalarioFamilia, 2, '.', ''));

        $stFiltroEventoMaternidade = " AND assentamento_assentamento.cod_motivo = 7";
        $stFiltroEventoMaternidade .= " AND assentamento_gerado_contrato_servidor.cod_contrato IN (" . $params['stCodContratos'] . ")";

        /** @var AssentamentoGeradoModel $assentamentoGeradoModel */
        $assentamentoGeradoModel = new AssentamentoGeradoModel($this->getEntityManager());
        $rsEventoMaternidade = $assentamentoGeradoModel->recuperaEventosAssentamento($stFiltroEventoMaternidade);

        if (!empty($rsEventoMaternidade)) {
            $arEventoMaternidade = array();
            foreach ($rsEventoMaternidade as $maternidade) {
                $arEventoMaternidade[] = $maternidade->cod_evento;
            }

            $arEventoMaternidade = array_unique($arEventoMaternidade);
            $stEventoMaternidade = implode(",", $arEventoMaternidade);

            $stFiltroEvento = " AND evento.cod_evento IN (" . $stEventoMaternidade . ")";
            $stFiltroEvento .= " AND cod_periodo_movimentacao = " . $params["cod_periodo_movimentacao"];
            $stFiltroEvento .= " AND cod_contrato IN (" . $params['stCodContratos'] . ")";

            $nuTotalSalarioMaternidade = $this->geraSomaValoresMaternidadeSalarioFamilia(
                $stFiltroEvento,
                $this->getEntityManager(),
                $params['nuTotalSalarioMaternidade']
            );
//          Sessao::write("nuTotalSalarioMaternidade", Sessao::read("nuTotalSalarioMaternidade") + $nuTotalSalarioMaternidade);
        }

        $arHeaderEmpresa['salario_maternidade'] = ($params['boCompetencia13']) ?
            str_replace('.', '', number_format($nuTotalSalarioMaternidade, 2, '.', ''))
            : 0;

        $arHeaderEmpresa['contribuicao'] = 0;
        $arHeaderEmpresa['indicador'] = 0;
        $arHeaderEmpresa['valor_devido'] = 0;
        $arHeaderEmpresa['banco'] = "";
        $arHeaderEmpresa['agencia'] = "";
        $arHeaderEmpresa['conta_corrente'] = "";
        $arHeaderEmpresa['zeros2'] = 0;
        $arHeaderEmpresa['brancos'] = "";
        $arHeaderEmpresa['final'] = "*";

        return $arHeaderEmpresa;
    }

    /**
     * @param $arHeaderEmpresa
     *
     * @return array
     */
    public function formataHeaderEmpresa($arHeaderEmpresa)
    {
        $arHeaderEmp = [];
        $arHeaderEmp[0]['tipo_registro'] = str_pad($arHeaderEmpresa['tipo_registro'], 2);
        $arHeaderEmp[0]['tipo_inscricao'] = str_pad($arHeaderEmpresa['tipo_inscricao'], 1);
        $arHeaderEmp[0]['inscricao_empresa'] = str_pad($arHeaderEmpresa['inscricao_empresa'], 14);
        $arHeaderEmp[0]['zeros'] = str_pad($arHeaderEmpresa['zeros'], 36, 0, STR_PAD_LEFT);
        $arHeaderEmp[0]['nome_empresa'] = str_pad($arHeaderEmpresa['nome_empresa'], 40);
        $arHeaderEmp[0]['logradouro'] = str_pad($arHeaderEmpresa['logradouro'], 50);
        $arHeaderEmp[0]['bairro'] = str_pad($arHeaderEmpresa['bairro'], 20);
        $arHeaderEmp[0]['cep'] = str_pad($arHeaderEmpresa['cep'], 8);
        $arHeaderEmp[0]['cidade'] = str_pad($arHeaderEmpresa['cidade'], 20);
        $arHeaderEmp[0]['unid_federal'] = str_pad($arHeaderEmpresa['unid_federal'], 2);
        $arHeaderEmp[0]['fone'] = str_pad($arHeaderEmpresa['fone'], 12, " ", STR_PAD_LEFT);
        $arHeaderEmp[0]['indicador_alteracao'] = str_pad($arHeaderEmpresa['indicador_alteracao'], 1);
        $arHeaderEmp[0]['cnae_fiscal'] = str_pad($arHeaderEmpresa['cnae_fiscal'], 7);
        $arHeaderEmp[0]['indicador_alteracao_cnae'] = str_pad($arHeaderEmpresa['indicador_alteracao_cnae'], 1);
        $aliquota_rat = substr($arHeaderEmpresa['aliquota_rat'], 0, 2);
        $arHeaderEmp[0]['aliquota_rat'] = str_pad($aliquota_rat, 2);
        $arHeaderEmp[0]['centralizacao'] = str_pad($arHeaderEmpresa['centralizacao'], 1);
        $arHeaderEmp[0]['simples'] = str_pad($arHeaderEmpresa['simples'], 1);
        $arHeaderEmp[0]['fpas'] = str_pad($arHeaderEmpresa['fpas'], 3);
        $arHeaderEmp[0]['outras_entidades'] = str_pad($arHeaderEmpresa['outras_entidades'], 4);
        $gps = substr($arHeaderEmpresa['gps'], 0, 4);
        $arHeaderEmp[0]['gps'] = str_pad($gps, 4);
        $arHeaderEmp[0]['filantropia'] = str_pad($arHeaderEmpresa['filantropia'], 5);
        $arHeaderEmp[0]['salario_familia'] = str_pad($arHeaderEmpresa['salario_familia'], 15, 0, STR_PAD_LEFT);
        $arHeaderEmp[0]['salario_maternidade'] = str_pad($arHeaderEmpresa['salario_maternidade'], 15, 0, STR_PAD_LEFT);
        $arHeaderEmp[0]['contribuicao'] = str_pad($arHeaderEmpresa['contribuicao'], 15, 0, STR_PAD_LEFT);
        $arHeaderEmp[0]['indicador'] = str_pad($arHeaderEmpresa['indicador'], 1);
        $arHeaderEmp[0]['valor_devido'] = str_pad($arHeaderEmpresa['valor_devido'], 14, 0, STR_PAD_LEFT);
        $arHeaderEmp[0]['banco'] = str_pad($arHeaderEmpresa['banco'], 3);
        $arHeaderEmp[0]['agencia'] = str_pad($arHeaderEmpresa['agencia'], 4);
        $arHeaderEmp[0]['conta_corrente'] = str_pad($arHeaderEmpresa['conta_corrente'], 9);
        $arHeaderEmp[0]['zeros2'] = str_pad($arHeaderEmpresa['zeros2'], 45, 0, STR_PAD_LEFT);
        $arHeaderEmp[0]['brancos'] = str_pad($arHeaderEmpresa['brancos'], 4);
        $arHeaderEmp[0]['final'] = str_pad($arHeaderEmpresa['final'], 1);
        $arHeaderEmp[0]['quebra'] = "\r\n";

        return $arHeaderEmp;
    }
}
