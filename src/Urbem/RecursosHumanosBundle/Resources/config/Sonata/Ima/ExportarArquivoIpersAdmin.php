<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Ima;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\ConfiguracaoIpeModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\Filter\Pessoal\GeneralFilterAdmin;

class ExportarArquivoIpersAdmin extends GeneralFilterAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_ima_configuracao_exportar_ipers';
    protected $baseRoutePattern = 'recursos-humanos/ima/exportar-ipers';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Exportar Arquivo'];
    protected $includeJs = array('/recursoshumanos/javascripts/ima/exportarArquivoIpers.js');

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
        $inCodConfiguracao = $form->get('tipoCalculo')->getData();
        $stTipoFiltro = $form->get('tipo')->getData();
        $stSituacao = $form->get('stSituacao')->getData();
        $stJuntarCalculo = $form->get('stJuntarCalculo')->getData();
        $stJuntarCalculo = ($stJuntarCalculo) ? 'true' : 'false';
        $tipoEmissao = $form->get('tipoEmissao')->getData();
        $contratos = $form->get('codContrato')->getData();
        $inCodLotacaoSelecionados = $form->get('lotacao')->getData();
        $inCodLocalSelecionados = $form->get('local')->getData();
        $complementar = $form->get('inCodComplementar')->getData();

        $inCodMes = ($form->get('mes')->getData() > 9) ? $form->get('mes')->getData() : "0" . $form->get('mes')->getData();

        $dtCompetencia = $inCodMes . "/" . $form->get('ano')->getData();
        $stCompetencia = $inCodMes . $form->get('ano')->getData();

        /** @var PeriodoMovimentacao $periodoMovimentacao */
        $inCodPeriodoMovimentacao = $em->getRepository(PeriodoMovimentacao::class)
            ->consultaPeriodoMovimentacaoCompetencia($dtCompetencia);

        $stFiltroContratos = "";
        switch ($stTipoFiltro) {
            case "cgm_contrato":
                foreach ($contratos as $arContrato) {
                    $stFiltroContratos = implode(",", $arContrato->getCodContrato());
                }
                break;
            case "geral":
                break;
            case "lotacao":
                    $stFiltroContratos = implode(",", $inCodLotacaoSelecionados);
                break;
            case "local":
                /** @var Local $inCodLocal */
                foreach ($inCodLocalSelecionados as $inCodLocal) {
                    $stFiltroContratos = implode(",", $inCodLocal->getCodLocal());
                }
                break;
            case "reg_sub_car_esp_grupo":
                $stFiltroContratos = implode(",", $form->get("regime")->getData()) . "#";
                $stFiltroContratos .= implode(",", $form->get("subdivisao")->getData()) . "#";
                $stFiltroContratos .= implode(",", $form->get("cargo")->getData()) . "#";
                if (is_array($form->get("especialidade")->getData())) {
                    $stFiltroContratos .= implode(",", $form->get("especialidade")->getData());
                }
                break;
            case "funcao":
                $stFiltroContratos = implode(",", $form->get("funcao")->getData());
                break;
            case "padrao":
                $stFiltroContratos .= implode(",", $form->get("padrao")->getData());
                break;
        }

        $params['inCodPeriodoMovimentacao'] = $inCodPeriodoMovimentacao['cod_periodo_movimentacao'];
        $params['entidade'] = '';
        $params['exercicio'] = $this->getExercicio();
        $params['stTipoFiltro'] = $stTipoFiltro;
        $params['stValoresFiltro'] = $stFiltroContratos;
        $params['stSituacaoCadastro'] = $stSituacao;
        $params['inCodTipoEmissao'] = $tipoEmissao;
        $params['inCodFolha'] = $inCodConfiguracao;
        $params['stDesdobramento'] = '';
        $params['inCodComplementar'] = (is_null($complementar)) ? 0 : $complementar;
        $params['boAgruparFolhas'] = (bool) $stJuntarCalculo;

        /** @var ConfiguracaoIpeModel $configuracaoIpeModel */
        $configuracaoIpeModel = new ConfiguracaoIpeModel($em);
        $rsContrato = $configuracaoIpeModel->montaExportarArquivoIpers($params);

        $rsConfiguracaoIpe = $configuracaoIpeModel->montaRecuperaTodosVigencia($params['inCodPeriodoMovimentacao']);

        $arExportador = [];
        $inIndex = $nuVlrLancamentoTotal = 0;

        foreach ($rsContrato as $contrato) {
            $inCodSexo = ($contrato["sexo"] == 'm') ? 1 : 2;

            switch ($contrato["cod_estado_civil"]) {
                case 1://Solteiro
                    $inCodEstadoCivil = 1;
                    break;
                case 2://Casado
                    $inCodEstadoCivil = 2;
                    break;
                case 3://Divorciado
                    $inCodEstadoCivil = 5;
                    break;
                case 4://Separado
                    $inCodEstadoCivil = 4;
                    break;
                case 5://Viuvo
                    $inCodEstadoCivil = 3;
                    break;
                default://Outros
                    $inCodEstadoCivil = 6;
                    break;
            }

            $arExportador[$inIndex]["orgao"] = str_pad($rsConfiguracaoIpe['codigo_orgao'], 3, 0, STR_PAD_LEFT);
            $arExportador[$inIndex]["registro"] = str_pad($contrato["registro"], 8, 0, STR_PAD_LEFT);

            $arExportador[$inIndex]["matricula_ipe"] = str_pad($contrato["matricula_ipe"], 13, 0, STR_PAD_LEFT);
            $arExportador[$inIndex]["situacao"] = str_pad($contrato["situacao"], 2, 0, STR_PAD_LEFT);
            $nome = preg_replace('[°]', '', $this->removeAcentuacao($contrato["nom_cgm"]));
            $nome = substr($nome, 0, 32);
            $arExportador[$inIndex]["nome"] = str_pad(trim($nome), 32);
            $endereco = preg_replace('[°]', '', $this->removeAcentuacao($contrato["logradouro"] . ((isset($contrato["numero"])) ? ", " . $contrato["numero"] : "")));
            $endereco = substr($endereco, 0, 40);
            $arExportador[$inIndex]["endereco"] = str_pad(trim($endereco), 40);
            $cep = preg_replace("/[^0-9A-Za-z]/i", "", $contrato["cep"]);
            $arExportador[$inIndex]["cep"] = str_pad($cep, 8);

            $dataIngresso = preg_replace("/[^0-9]/i", "", $contrato["dt_ingresso"]);
            $dataSituacao = preg_replace("/[^0-9]/i", "", $contrato["dt_situacao"]);
            $dataNascimento = preg_replace("/[^0-9]/i", "", $contrato["dt_nascimento"]);

            $arExportador[$inIndex]["data_ingresso"] = str_pad($dataIngresso, 8);
            $arExportador[$inIndex]["data_situacao"] = str_pad($dataSituacao, 8);
            $arExportador[$inIndex]["data_nascimento"] = str_pad($dataNascimento, 8);
            $arExportador[$inIndex]["sexo"] = $inCodSexo;
            $arExportador[$inIndex]["estado_civil"] = $inCodEstadoCivil;

            $rg = preg_replace("/[^0-9]/i", "", $contrato["rg"]);
            $rg = substr($rg, 0, 10);
            $cpf = preg_replace("/[^0-9]/i", "", $contrato["cpf"]);
            $cpf = substr($cpf, 0, 11);
            $arExportador[$inIndex]["rg"] = str_pad($rg, 10, 0, STR_PAD_LEFT);
            $arExportador[$inIndex]["cpf"] = str_pad($cpf, 11, 0, STR_PAD_LEFT);

            $salario = number_format($contrato["valor"], 2, "", "");
            $arExportador[$inIndex]["salario"] = str_pad($salario, 11, 0, STR_PAD_LEFT);
            $arExportador[$inIndex]["vazio"] = str_pad("", 86);
            $arExportador[$inIndex]['quebra'] = "\r\n";

            $nuVlrLancamentoTotal += $contrato["valor"];
            $inIndex++;
        }

        $arCabecalhoArquivo = array();
        $arCabecalhoArquivo[0]['orgao'] = str_pad($rsConfiguracaoIpe["codigo_orgao"], 3, 0, STR_PAD_LEFT);
        $dataMovimento = substr($stCompetencia, 2) . substr($stCompetencia, 0, 2);
        $arCabecalhoArquivo[0]['vazio'] = str_pad("", 8, 0, STR_PAD_LEFT);
        $arCabecalhoArquivo[0]['data_movimento'] = str_pad($dataMovimento, 6, 0, STR_PAD_LEFT);
        $arCabecalhoArquivo[0]['identificador'] = $tipoEmissao;
        $arCabecalhoArquivo[0]['vazio2'] = str_pad("", 232);
        $arCabecalhoArquivo[0]['quebra'] = "\r\n";

        $totalSalario = number_format($nuVlrLancamentoTotal, 2, "", "");

        $arRodape[0]['orgao'] = str_pad($rsConfiguracaoIpe['codigo_orgao'], 3, 0, STR_PAD_LEFT);
        $arRodape[0]['noves'] = str_pad(9, 8, 9, STR_PAD_LEFT);
        $arRodape[0]["quant_registros"] = str_pad($inIndex, 5, 0, STR_PAD_LEFT);
        $arRodape[0]["total_salario"] = str_pad($totalSalario, 17, 0, STR_PAD_LEFT);
        $arRodape[0]["vazio"] = str_pad("", 217);
        $arRodape[0]['quebra'] = "\r\n";

        $arquivos = array_merge($arCabecalhoArquivo, $arExportador, $arRodape);

        $date = new \DateTime();
        $filename = sprintf('ipe_%s.txt', $date->format('YmdHis'));

        $fp = fopen('/tmp/' . $filename, 'w');
        foreach ($arquivos as $arquivo) {
            fwrite($fp, implode("", $arquivo));
        }
        fclose($fp);

        $params['stCompetencia'] = $stCompetencia;
        $params['fileName'] = $filename;
        $params['inCodConfiguracao'] = $inCodConfiguracao;
        $params['tipoEmissao'] = $tipoEmissao;
        $params['entidade'] = $codEntidadePrefeitura;
        $params['stEntidade'] = $entidade->getFkSwCgm()->getNomCgm();
        $params['exercicio'] = $this->getExercicio();
        $params['inCodPeriodoMovimentacao'] = $inCodPeriodoMovimentacao['cod_periodo_movimentacao'];
        $params['stTipoFiltro'] = $stTipoFiltro;
        $params['stValoresFiltro'] = $stFiltroContratos;
        $params['stSituacaoCadastro'] = $stSituacao;
        $params['inCodTipoEmissao'] = $tipoEmissao;
        $params['inCodFolha'] = $inCodConfiguracao;
        $params['stDesdobramento'] = '';
        $params['inCodComplementar'] = (is_null($complementar)) ? 0 : $complementar;
        $params['boAgruparFolhas'] = (bool) $stJuntarCalculo;
        $params['quant_registros'] = $inIndex;
        $params["stCompetenciaTitulo"] = substr($stCompetencia, 0, 2) . "/" . substr($stCompetencia, 2);
        $params["stCodigoOrgao"] = str_pad($rsConfiguracaoIpe['codigo_orgao'], 3, "0", STR_PAD_LEFT);
        $params["inValorPerContPatronal"] = $rsConfiguracaoIpe['contribuicao_pat'];

        $encode = (\GuzzleHttp\json_encode($params));
        $hash = base64_encode($encode);
        $this->forceRedirect('/recursos-humanos/ima/exportar-ipers/detalhe?id='.$hash);
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

        $mes = $periodoMovimentacaoModel->getMesCompetenciaFolhaPagamento($this->getExercicio());
        $fieldOptions['mes'] = [
            'label' => 'label.ferias.mes',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'choices' => $mes,
            'data' => (is_array($mes)) ? end($mes) : $mes,
            'attr' => [
                'data-mes' => $mes,
            ],
            'attr' => ['class' => 'select2-parameters '],
        ];

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
            'data' => 'todos',
        ];

        $fieldOptions['tipoEmissao'] = [
            'choices' => [
                "Manutenção" => 1,
                "Acerto de Manutenção" => 2,
                "Inclusão" => 3,
                "Acerto de inclusão" => 4
            ],
            'label' => 'label.recursosHumanos.ima.tipoEmissao',
            'expanded' => false,
            'multiple' => false,
            'attr' => ['class' => 'select2-parameters'],
            'mapped' => false,
            'data' => 'Manutenção',
        ];

        $fieldOptions['stJuntarCalculo'] = [
            'label' => 'label.recursosHumanos.ima.juntarCalculo',
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

        $fieldOptions['inCodComplementar'] = [
            'label' => 'label.recursosHumanos.relatorios.folha.contraCheque.inCodComplementar',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'choices' => [],
            'attr' => [
                'class' => 'select2-parameters',
                'disabled' => 'disabled'
            ],
        ];

        $formMapper
            ->with("Dados de Emissão do Arquivo")
            ->add('tipoEmissao', 'choice', $fieldOptions['tipoEmissao'])
            ->add('stSituacao', 'choice', $fieldOptions['stSituacao'])
            ->end()
            ->with("Filtro");
        parent::configureFields($formMapper, GeneralFilterAdmin::RECURSOSHUMANOS_IMA_ARQUIVOIPERS);
        $formMapper
            ->add('ano', 'number', $fieldOptions['ano'])
            ->add('mes', 'choice', $fieldOptions['mes'])
            ->add('stJuntarCalculo', 'choice', $fieldOptions['stJuntarCalculo'])
            ->add('tipoCalculo', 'choice', $fieldOptions['tipoCalculo'])
            ->add('inCodComplementar', 'choice', $fieldOptions['inCodComplementar'])
            ->end();
    }

    public function removeAcentuacao($str)
    {
        $from = 'ÀÁÃÂÉÊÍÓÕÔÚÜÇàáãâéêíóõôúüç';
        $to = 'AAAAEEIOOOUUCaaaaeeiooouuc';

        return strtr($str, $from, $to);
    }
}
