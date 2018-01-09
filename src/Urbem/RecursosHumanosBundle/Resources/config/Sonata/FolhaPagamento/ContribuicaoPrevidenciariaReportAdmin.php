<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\Pessoal\Regime;
use Urbem\CoreBundle\Entity\Pessoal\SubDivisao;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PrevidenciaModel;
use Urbem\CoreBundle\Model\Organograma\OrganogramaModel;
use Urbem\CoreBundle\Model\Organograma\OrgaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ContribuicaoPrevidenciariaReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_relatorios_contribuicao_previdenciaria';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/relatorios/contribuicao-previdenciaria';
    protected $layoutDefaultReport = '/bundles/report/gestaoRH/fontes/RPT/folhaPagamento/report/design/contribuicaoPrevidenciaria.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar Relatório'];
    protected $includeJs = array(
        '/recursoshumanos/javascripts/folhapagamento/contribuicaoPrevidenciaria.js',
        '/recursoshumanos/javascripts/pessoal/ferias/emitir-aviso.js'
    );

    const COD_ACAO = '1491';

    const OPCOES_CGM = 'cgmMatricula';
    const OPCOES_LOTACAO = 'lotacao';
    const OPCOES_LOCAL = 'local';
    const OPCOES_SUBDIVISAO = 'subDivisao';
    const OPCOES_GERAL = 'geral';
    const OPCOES = [
        self::OPCOES_CGM => 'label.emitirFerias.cgmMatricula',
        self::OPCOES_LOTACAO => 'label.emitirFerias.lotacao',
        self::OPCOES_LOCAL => 'label.emitirFerias.local',
        self::OPCOES_SUBDIVISAO => 'label.emitirFerias.subDivisaoRegime',
        self::OPCOES_GERAL => 'label.relatorios.termoRescisao.geral',
    ];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create'));
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $fileName = $this->parseNameFile("contribuicaoPrevidenciaria");

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
        $complementar = $form->get('inCodComplementar')->getData();
        $inCodConfiguracao = $form->get('tipoCalculo')->getData();
        $stOrdem = $form->get('ordenacao')->getData();
        $stTipoFiltro = $form->get('tipo')->getData();
        $contratos = $form->get('cgmMatricula')->getData();
        $inCodLotacaoSelecionados = $form->get('lotacao')->getData();
        $inCodLocalSelecionados = $form->get('local')->getData();
        $stSituacao = $form->get('stSituacao')->getData();
        $previdencia = $form->get('previdencia')->getData();
        $boAgrupar = $form->get('boAgrupar')->getData();

        $boAgrupar['agrupar'] = (in_array('agrupar', $boAgrupar)) ? true : null;
        if ($boAgrupar['agrupar']) {
            $inCodRelatorio = Relatorio::RECURSOS_HUMANOS_FOLHAPAGAMENTO_CONTRIBUICAOPREVIDENCIARIA_AGRUPAR; // Muda o codRelatorio para 20, caso a opção AGRUPAR esteja habilitada
            $boAgrupar['quebrar'] = isset($boAgrupar[1]) ? true : null;
        } else {
            $inCodRelatorio = Relatorio::RECURSOS_HUMANOS_FOLHAPAGAMENTO_CONTRIBUICAOPREVIDENCIARIA;
            $boAgrupar['quebrar'] = null;
        }

        $stAcumularSalCompl = $form->get('boAcumularSalCompl')->getData();

        $inCodMes = ($form->get('mes')->getData() > 9) ? $form->get('mes')->getData() : "0" . $form->get('mes')->getData();

        $dtCompetencia = $inCodMes . "/" . $form->get('ano')->getData();

        /** @var PeriodoMovimentacao $periodoMovimentacao */
        $inCodPeriodoMovimentacao = $em->getRepository(PeriodoMovimentacao::class)
            ->consultaPeriodoMovimentacaoCompetencia($dtCompetencia);

        $stFiltro = " AND previdencia_regime_rat.cod_previdencia = ".$previdencia;

        /** @var PrevidenciaModel $previdenciaModel */
        $previdenciaModel = new PrevidenciaModel($em);
        $rsRat = $previdenciaModel->getPrevidenciaRat($stFiltro);

        $stFiltro = " WHERE cod_previdencia = ".$previdencia;
        $stFiltro.= " AND vigencia <= TO_DATE('".$inCodPeriodoMovimentacao['dt_final']."','DD/MM/YYYY')";
        $stFiltro.= " ORDER BY vigencia_ordenacao DESC, timestamp DESC LIMIT 1";

        $rsPrevidenciaPrevidencia = $previdenciaModel->getPrevidenciaPrevidencia($stFiltro);

        $stFiltroContratos = $stRegime = null;

        switch ($stTipoFiltro) {
            case "cgmMatricula":
                $stTipoFiltro = 'cgm_contrato_todos';
                foreach ($contratos as $arContrato) {
                    $stFiltroContratos .= $arContrato->getCodContrato() . ",";
                }
                $stFiltroContratos = substr($stFiltroContratos, 0, -1);
                break;
            case "geral":
                break;
            case "lotacao":
                $stTipoFiltro = 'lotacao_grupo';
                foreach ($inCodLotacaoSelecionados as $inCodOrgao) {
                    $stFiltroContratos .= $inCodOrgao . ",";
                }
                $stFiltroContratos = substr($stFiltroContratos, 0, -1);
                break;
            case "local":
                $stTipoFiltro = 'local_grupo';
                /** @var Local $inCodLocal */
                foreach ($inCodLocalSelecionados as $inCodLocal) {
                    $stFiltroContratos .= $inCodLocal->getCodLocal() . ",";
                }
                $stFiltroContratos = substr($stFiltroContratos, 0, -1);
                break;
            case "subDivisao":
                $stTipoFiltro = 'sub_divisao_grupo';
                $stRegime .= implode(",", $form->get("regime")->getData());
                $stFiltroContratos .= implode(",", $form->get("subDivisao")->getData());
                $stRegime = substr($stRegime, 0, -2);
                $stFiltroContratos = substr($stFiltroContratos, 0, -2);
                break;
        }

        $params = [
            'term_user' => $this->getCurrentUser()->getUserName(),
            'cod_acao' => self::COD_ACAO,
            'exercicio' => $this->getExercicio(),
            'inCodGestao' => Gestao::GESTAO_RECURSOS_HUMANOS,
            'inCodModulo' => Modulo::MODULO_FOLHAPAGAMENTO,
            'inCodRelatorio' => $inCodRelatorio,
            'boAgrupar' => $boAgrupar['agrupar'],
            'boQuebrar' => $boAgrupar['quebrar'],
            'entidade' => $codEntidadePrefeitura,
            'stEntidade' => '',
            'cod_periodo_movimentacao' =>  $inCodPeriodoMovimentacao['cod_periodo_movimentacao'],
            'cod_previdencia' => $previdencia,
            'cod_configuracao' => $inCodConfiguracao,
            'ordenacao' => $stOrdem,
            'stTipoFiltro' => $stTipoFiltro,
            'stRegime' => $stRegime,
            'stCodigos' => $stFiltroContratos,
            'periodo_inicial' => $inCodPeriodoMovimentacao['dt_inicial'],
            'periodo_final' => $inCodPeriodoMovimentacao['dt_final'],
            'aliquota_rat' => ($rsRat["aliquota_rat"] != '' ? number_format($rsRat["aliquota_rat"], 4, '.', '') : ''),
            'aliquota_fap' => ($rsRat["aliquota_fap"] != '' ? number_format($rsRat["aliquota_fap"], 4, '.', '') : ''),
            'aliquota_patronal' => $rsPrevidenciaPrevidencia['aliquota'],
            'stSituacaoCadastro' => $stSituacao,
            'stAcumularSalCompl' => $stAcumularSalCompl,
            'inCodComplementar' => (is_null($complementar)) ? 0 : $complementar
        ];

        $apiService = $this->getReportService();
        $apiService->setReportNameFile($fileName);
        $apiService->setLayoutDefaultReport($this->layoutDefaultReport);
        $res = $apiService->getReportContent($params);

        $this->parseContentToPdf(
            $res->getBody()->getContents(),
            $fileName
        );
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
                'Rescisão' => 4,
            ],
            'label' => 'label.recursosHumanos.ima.tipoCalculo',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'mapped' => false,
            'data' => 1
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

        $fieldOptions['stSituacao'] = [
            'choices' => [
                'Ativo' => 'ativo',
                'Inativo' => 'inativo',
                'Rescindido' => 'rescindido',
                'Pensionista' => 'pensionista',
                'Todos' => 'todos'
            ],
            'label' => 'label.recursosHumanos.relatorios.folha.customizavelEventos.stSituacao',
            'expanded' => false,
            'multiple' => false,
            'attr' => ['class' => 'select2-parameters'],
            'mapped' => false,
            'data' => 'ativos',
        ];

        $fieldOptions['ordenacao'] = [
            'choices' => [
                'Alfabética' => 'nom_cgm',
                'Numérica' => 'registro',
            ],
            'expanded' => true,
            'multiple' => false,
            'label_attr' => ['class' => 'checkbox-sonata '],
            'attr' => ['class' => 'checkbox-sonata '],
            'mapped' => false,
            'data' => 'nom_cgm',
            'label' => 'label.recursosHumanos.relatorios.folha.contraCheque.ordenacao'
        ];

        $fieldOptions['boAgrupar'] = [
            'label' => 'label.recursosHumanos.relatorios.folha.customizavelEventos.boAgrupar',
            'mapped' => false,
            'choices' => [
                'Agrupar' => 'agrupar',
                'Quebrar Página' => 'quebrar',
            ],
            'data' => ['valor'],
            'expanded' => true,
            'multiple' => true,
            'label_attr' => ['class' => 'checkbox-sonata '],
            'attr' => ['class' => 'checkbox-sonata '],
            'required' => false
        ];

        /** @var PrevidenciaModel $previdenciaModel */
        $previdenciaModel = new PrevidenciaModel($entityManager);
        $previdencias = $previdenciaModel->getPrevidenciaChoices(true);
        $fieldOptions['previdencia'] = [
            'choices' => $previdencias,
            'mapped' => false,
            'label' => 'label.recursosHumanos.relatorios.folha.contribuicaoPrevidenciaria.previdencia',
            'attr' => ['class' => 'select2-parameters']
        ];

        $fieldOptions['boAcumularSalCompl'] = [
            'label' => 'label.recursosHumanos.relatorios.folha.contribuicaoPrevidenciaria.boAcumularSalCompl',
            'mapped' => false,
            'choices' => [
                'label_type_yes' => 'sim',
                'label_type_no' => 'nao',
            ],
            'data' => 'nao',
            'expanded' => true,
            'multiple' => false,
            'label_attr' => ['class' => 'checkbox-sonata '],
            'attr' => ['class' => 'checkbox-sonata '],
            'required' => true
        ];

        $fieldOptions['tipo'] = [
            'label' => 'label.recursosHumanos.folhas.grid.tipo',
            'mapped' => false,
            'choices' => array_flip($this::OPCOES),
            'expanded' => false,
            'required' => true,
            'placeholder' => 'label.selecione',
            'attr' => [
                'required' => true,
                'class' => 'select2-parameters '
            ],
        ];

        $fieldOptions['cgmMatricula'] = [
            'label' => 'label.cgmmatricula',
            'class' => Contrato::class,
            'route' => [
                'name' => 'carrega_contrato_nao_rescindido'
            ],
            'multiple' => true,
            'json_choice_label' => function ($contrato) use ($entityManager) {
                if (!is_null($contrato->getFkPessoalContratoServidor())) {
                    $nomcgm = $contrato->getFkPessoalContratoServidor()
                        ->getFkPessoalServidorContratoServidores()->last()
                        ->getFkPessoalServidor()
                        ->getFkSwCgmPessoaFisica()
                        ->getFkSwCgm()
                        ->getNomcgm();
                } else {
                    $nomcgm = "Não localizado";
                }

                return $nomcgm;
            },
            'attr'        => ['class' => 'select2-parameters select2-multiple-options-custom '],
            'mapped' => false,
            'required' => false,
        ];

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

        $fieldOptions['lotacao'] = [
            'label' => 'label.recursosHumanos.folhas.grid.lotacao',
            'required' => false,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom ',
            ],
            'choices' => $lotacaoArray,
            'expanded' => false,
            'multiple' => true
        ];

        $fieldOptions['local'] = [
            'label' => 'label.recursosHumanos.folhas.grid.local',
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom '
            ],
            'class' => Local::class,
            'expanded' => false,
            'required' => false,
            'multiple' => true
        ];

        /** @var Regime $regimes */
        $regimes = $entityManager->getRepository(Regime::class)->findAll();
        $regimesArray = [];
        /** @var Regime $regime */
        foreach ($regimes as $regime) {
            $regimesArray[$regime->getCodRegime() . " - " . $regime->getDescricao()] = $regime->getCodRegime();
        }

        $fieldOptions['regime'] = [
            'choices' => $regimesArray,
            'label' => 'label.recursosHumanos.relatorios.folha.customizavelEventos.regime',
            'expanded' => false,
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom '],
            'mapped' => false,
            'multiple' => true,
            'required' => false,
        ];

        /** @var SubDivisao $subDivisoes */
        $subDivisoes = $entityManager->getRepository(SubDivisao::class)->findAll();
        $subDivisoesArray = [];
        /** @var SubDivisao $subDivisao */
        foreach ($subDivisoes as $subDivisao) {
            $subDivisoesArray[$subDivisao->getCodSubDivisao() . " - " . $subDivisao->getDescricao()] = $subDivisao->getCodSubDivisao();
        }

        $fieldOptions['subDivisao'] = [
            'choices' => $subDivisoesArray,
            'label' => 'label.recursosHumanos.relatorios.folha.customizavelEventos.subdivisao',
            'expanded' => false,
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom '],
            'mapped' => false,
            'required' => false,
            'multiple' => true,
        ];

        $formMapper
            ->with("label.recursosHumanos.relatorios.folha.contribuicaoPrevidenciaria.titulo")
            ->add('ano', 'number', $fieldOptions['ano'])
            ->add('mes', 'choice', $fieldOptions['mes'])
            ->add('tipoCalculo', 'choice', $fieldOptions['tipoCalculo'])
            ->add('inCodComplementar', 'choice', $fieldOptions['inCodComplementar'])
            ->add('boAcumularSalCompl', 'choice', $fieldOptions['boAcumularSalCompl'])
            ->end();
        $formMapper
            ->with("label.recursosHumanos.relatorios.folha.contribuicaoPrevidenciaria.filtros")
            ->add('tipo', 'choice', $fieldOptions['tipo'])
            ->add('cgmMatricula', 'autocomplete', $fieldOptions['cgmMatricula'])
            ->add('lotacao', 'choice', $fieldOptions['lotacao'])
            ->add('local', 'entity', $fieldOptions['local'])
            ->add('regime', 'choice', $fieldOptions['regime'])
            ->add('subDivisao', 'choice', $fieldOptions['subDivisao'])
            ->add('boAgrupar', 'choice', $fieldOptions['boAgrupar'])
            ->add('previdencia', 'choice', $fieldOptions['previdencia'])
            ->end()
        ;
        $formMapper
            ->with('')
            ->add('stSituacao', 'choice', $fieldOptions['stSituacao'])
            ->add('ordenacao', 'choice', $fieldOptions['ordenacao'])
            ->end();
    }
}
