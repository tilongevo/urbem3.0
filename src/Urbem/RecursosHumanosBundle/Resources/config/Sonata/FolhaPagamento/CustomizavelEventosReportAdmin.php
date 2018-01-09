<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Pessoal\Especialidade;
use Urbem\CoreBundle\Entity\Pessoal\Regime;
use Urbem\CoreBundle\Entity\Pessoal\SubDivisao;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Pessoal\CargoModel;
use Urbem\CoreBundle\Resources\config\Sonata\Filter\Pessoal\GeneralFilterAdmin;

class CustomizavelEventosReportAdmin extends GeneralFilterAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_relatorios_customizavel_eventos';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/relatorios/customizavel-eventos';
    protected $layoutDefaultReport = '/bundles/report/gestaoRH/fontes/RPT/folhaPagamento/report/design/customizavelEventos.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar Relatório'];
    protected $includeJs = array('/recursoshumanos/javascripts/folhapagamento/customizavelEventos.js');

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create'));
    }

    public function prePersist($object)
    {
        $fileName = $this->parseNameFile("customizavelEventos");

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
        $contratos = $form->get('codContrato')->getData();
        $inCodLotacaoSelecionados = $form->get('lotacao')->getData();
        $inCodLocalSelecionados = $form->get('local')->getData();
        $stApresentarPorMatricula = $form->get('boApresentarPorMatricula')->getData();
        $stSituacao = $form->get('stSituacao')->getData();
        $eventos = $form->get('eventos')->getData();
        $boAgrupar = $form->get('boAgrupar')->getData();
        $boAgrupar['agrupar'] = (in_array('agrupar', $boAgrupar)) ? 1 : '';
        $boAgrupar['quebrar'] = (in_array('quebrar', $boAgrupar)) ? 1 : '';
        $inApresenta = $form->get('inApresenta')->getData();
        $inApresenta['valor'] = (in_array('valor', $inApresenta)) ? 1 : 0;
        $inApresenta['quantidade'] = (in_array('quantidade', $inApresenta)) ? 1 : 0;

        $arrayEventos = [];
        $countEventos = 0;
        foreach ($eventos as $key => $evento) {
            $countEventos = $key + 1;
            $arrayEventos['cod_evento' . $countEventos] = $evento->getCodEvento();
        }

        $inCodMes = ($form->get('mes')->getData() > 9) ? $form->get('mes')->getData() : "0" . $form->get('mes')->getData();

        $dtCompetencia = $inCodMes . "/" . $form->get('ano')->getData();

        /** @var PeriodoMovimentacao $periodoMovimentacao */
        $inCodPeriodoMovimentacao = $em->getRepository(PeriodoMovimentacao::class)
            ->consultaPeriodoMovimentacaoCompetencia($dtCompetencia);
        $stFiltroContratos = '';
        switch ($stTipoFiltro) {
            case "cgm_contrato":
            case "matricula":
                foreach ($contratos as $arContrato) {
                    $stFiltroContratos .= $arContrato->getCodContrato() . ",";
                }
                $stFiltroContratos = substr($stFiltroContratos, 0, strlen($stFiltroContratos) - 1);
                break;
            case "geral":
                break;
            case "lotacao":
                foreach ($inCodLotacaoSelecionados as $inCodOrgao) {
                    $stFiltroContratos .= $inCodOrgao . ",";
                }
                break;
            case "local":
                /** @var Local $inCodLocal */
                foreach ($inCodLocalSelecionados as $inCodLocal) {
                    $stFiltroContratos .= $inCodLocal->getCodLocal() . ",";
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
            case "padrao":
                $stFiltroContratos .= implode(",", $form->get("padrao")->getData());
                break;
        }

        $params = [
            'term_user' => 'suporte',
            'cod_acao' => 1468,
            'exercicio' => (int) $this->getExercicio(),
            'inCodGestao' => Gestao::GESTAO_RECURSOS_HUMANOS,
            'inCodModulo' => Modulo::MODULO_FOLHAPAGAMENTO,
            'inCodRelatorio' => Relatorio::RECURSOS_HUMANOS_FOLHAPAGAMENTO_CUSTOMIZAVELEVENTOS,
            'stCompetencia' => $dtCompetencia,
            'cod_complementar' => (is_null($complementar)) ? 0 : $complementar,
            'dt_inicial' => $inCodPeriodoMovimentacao['dt_inicial'],
            'dt_final' => $inCodPeriodoMovimentacao['dt_final'],
            'cod_periodo_movimentacao' => $inCodPeriodoMovimentacao['cod_periodo_movimentacao'],
            'stApresentarPorMatricula' => $stApresentarPorMatricula,
            'inApresentaValor' => $inApresenta['valor'],
            'inApresentaQuantidade' => $inApresenta['quantidade'],
            'count_eventos' => $countEventos,
            'stTipoFiltro' => ($stTipoFiltro == 'matricula') ? 'contrato_todos' : $stTipoFiltro,
            'stValoresFiltro' => $stFiltroContratos,
            'cod_configuracao' => $inCodConfiguracao,
            'stSituacao' => $stSituacao,
            'entidade' => (int) $codEntidadePrefeitura,
            'stEntidade' => "",
            'stOrdem' => $stOrdem,
            'dtPeriodoInicial' => $inCodPeriodoMovimentacao['dt_inicial'],
            'dtPeriodoFinal' => $inCodPeriodoMovimentacao['dt_final'],
            'boAgrupar' => $boAgrupar['agrupar'],
            'boQuebrar' => $boAgrupar['quebrar'],
        ];

        $params = array_merge($params, $arrayEventos);

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
                'Rescisao' => 4,
            ],
            'label' => 'Tipo de cálculo',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'mapped' => false,
            'data' => 1
        ];

        $fieldOptions['ordenacao'] = [
            'choices' => [
                'Códigos do evento' => 'codigo',
                'Sequência de cálculo' => 'sequencia',
            ],
            'label' => 'Ordenação dos eventos',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'mapped' => false
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

        /** @var EventoModel $eventoModel */
        $eventoModel = new EventoModel($entityManager);
        $eventoArray = $eventoModel->getEventoByParams(['P', 'I', 'B'], false, false);
        $codEventos = $eventosCadastradosArray = [];
        foreach ($eventoArray as $evento) {
            $codEventos[] = $evento;
        }

        $fieldOptions['eventos'] = [
            'class' => Evento::class,
            'choice_label' => function ($evento) {
                return $evento->getCodigo() . ' - ' . $evento->getDescricao();
            },
            'label' => 'label.recursosHumanos.contratoServidorPeriodo.evento',
            'query_builder' => function (EntityRepository $repo) use ($codEventos) {
                $qb = $repo->createQueryBuilder('e');
                $qb->where(
                    $qb->expr()->In('e.codigo', $codEventos)
                );

                return $qb;
            },
            'multiple' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'required' => true,
            'mapped' => false
        ];

        $fieldOptions['inApresenta'] = [
            'label' => 'label.recursosHumanos.relatorios.folha.customizavelEventos.inApresenta',
            'mapped' => false,
            'choices' => [
                'Valor' => 'valor',
                'Quantidade' => 'quantidade',
            ],
            'data' => ['valor'],
            'expanded' => true,
            'multiple' => true,
            'label_attr' => ['class' => 'checkbox-sonata '],
            'attr' => ['class' => 'checkbox-sonata '],
        ];

        $fieldOptions['boApresentarPorMatricula'] = [
            'label' => 'label.recursosHumanos.relatorios.folha.customizavelEventos.boApresentarPorMatricula',
            'mapped' => false,
            'choices' => [
                'Lotação' => 'lotacao',
                'Local' => 'local',
                'Cargo/Especialidade' => 'cargo',
                'Função/Especialidade' => 'funcao',
                'CPF' => 'cpf',
            ],
            'data' => 'lotacao',
            'attr' => ['class' => 'select2-parameters '],
        ];

        $fieldOptions['stSituacao'] = [
            'choices' => [
                'Ativos' => 'A',
                'Rescindidos' => 'R',
                'Aposentados' => 'P',
                'Pensionistas' => 'E',
                'Todos' => 'T'
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

        $formMapper
            ->with("Parâmetros para consulta")
            ->add('ano', 'number', $fieldOptions['ano'])
            ->add('mes', 'choice', $fieldOptions['mes'])
            ->add('tipoCalculo', 'choice', $fieldOptions['tipoCalculo'])
            ->add('inCodComplementar', 'choice', $fieldOptions['inCodComplementar'])
            ->end()
            ->with("label.eventos")
            ->add('eventos', 'entity', $fieldOptions['eventos'])
            ->add('inApresenta', 'choice', $fieldOptions['inApresenta'])
            ->add('boApresentarPorMatricula', 'choice', $fieldOptions['boApresentarPorMatricula'])
            ->end()
            ->with("Filtro");
        parent::configureFields($formMapper, GeneralFilterAdmin::RECURSOSHUMANOS_FOLHA_CUSTOMIZAVELEVENTOS);
        $formMapper
            ->add('boAgrupar', 'choice', $fieldOptions['boAgrupar']);
        $formMapper->end()
            ->with('')
            ->add('stSituacao', 'choice', $fieldOptions['stSituacao'])
            ->add('ordenacao', 'choice', $fieldOptions['ordenacao'])
            ->end();
    }
}
