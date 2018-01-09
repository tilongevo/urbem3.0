<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\Filter\Pessoal\GeneralFilterAdmin;

class FichaFinanceiraReportAdmin extends GeneralFilterAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_relatorios_ficha_financeira';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/relatorios/ficha-financeira';
    protected $layoutDefaultReport = '/bundles/report/gestaoRH/fontes/RPT/folhaPagamento/report/design/relatorioFichaFinanceira.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar Relatório'];
    protected $includeJs = array('/recursoshumanos/javascripts/folhapagamento/fichaFinanceira.js');

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create'));
    }

    public function prePersist($object)
    {
        $fileName = $this->parseNameFile("fichaFinanceira");

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
        $stOrdenacaoEventos = $form->get('ordenacaoEventos')->getData();
        $stTipoFiltro = $form->get('tipo')->getData();
        $contratos = $form->get('codContrato')->getData();
        $inCodLotacaoSelecionados = $form->get('lotacao')->getData();
        $inCodLocalSelecionados = $form->get('local')->getData();
        $inEventoSelecionados = $form->get('evento')->getData();

        $inCodMes = ($form->get('mesInicial')->getData() > 9) ? $form->get('mesInicial')->getData() : "0" . $form->get('mesInicial')->getData();
        $inCodMesFinal = ($form->get('mesFinal')->getData() > 9) ? $form->get('mesFinal')->getData() : "0" . $form->get('mesFinal')->getData();

        $dtCompetenciaInicial = $inCodMes . "/" . $form->get('anoInicial')->getData();
        $dtCompetenciaFinal = $inCodMesFinal . "/" . $form->get('anoFinal')->getData();

        /** @var PeriodoMovimentacao $periodoMovimentacao */
        $inCodPeriodoMovimentacaoInicial = $em->getRepository(PeriodoMovimentacao::class)
            ->consultaPeriodoMovimentacaoCompetencia($dtCompetenciaInicial);

        $inCodPeriodoMovimentacaoFinal = $em->getRepository(PeriodoMovimentacao::class)
            ->consultaPeriodoMovimentacaoCompetencia($dtCompetenciaFinal);

        $stOrdem = "";
        $virgula = "";
        $stFiltroContratos = '';
        switch ($stTipoFiltro) {
            case "cgm_contrato":
                $stOrdem = "nom_cgm";
//                $stFiltroContratos = " AND contrato.cod_contrato IN (";
                foreach ($contratos as $arContrato) {
                    $stFiltroContratos .= $arContrato->getCodContrato() . ",";
                }
                $stFiltroContratos = substr($stFiltroContratos, 0, strlen($stFiltroContratos) - 1);
                break;
            case "geral":
                $stOrdem = "nom_cgm";
                break;
            case "lotacao":
                $stOrdem .= $virgula . "descricao_lotacao,nom_cgm";
//                $stFiltroContratos = " AND cadastros.cod_orgao IN (";
                foreach ($inCodLotacaoSelecionados as $inCodOrgao) {
                    $stFiltroContratos .= $inCodOrgao . ",";
                }
                $stFiltroContratos = substr($stFiltroContratos, 0, strlen($stFiltroContratos) - 1);
                break;
            case "local":
                $stOrdem .= $virgula . "desc_local";

//                $stFiltroContratos = " AND cadastros.cod_local IN (";
                /** @var Local $inCodLocal */
                foreach ($inCodLocalSelecionados as $inCodLocal) {
                    $stFiltroContratos .= $inCodLocal->getCodLocal() . ",";
                }
                $stFiltroContratos = substr($stFiltroContratos, 0, strlen($stFiltroContratos) - 1);
                break;
            case "evento":
                foreach ($inEventoSelecionados as $arEvento) {
                    $stFiltroContratos .= $arEvento->getCodEvento() . ",";
                }
                $stFiltroContratos = substr($stFiltroContratos, 0, -1);
                break;
        }
        if ($stOrdem == '') {
            $stOrdem = 'nom_cgm';
        }

        $params = [
            // Códigos contidos no menu
            'term_user' => 'suporte',
            'cod_acao' => '1362',
            'exercicio' => (string) $this->getExercicio(),
            'inCodGestao' => (string) Gestao::GESTAO_RECURSOS_HUMANOS,
            'inCodModulo' => (string) Modulo::MODULO_FOLHAPAGAMENTO,
            'inCodRelatorio' => (string) Relatorio::RECURSOS_HUMANOS_FOLHAPAGAMENTO_FICHAFINANCEIRA,
            // Entidade escolhida no combo de RH
            'stEntidade' => '',
            'entidade' => $codEntidadePrefeitura,
            // Itens exclusivos deste relatório
            "stTipoFiltro" => (string) ($stTipoFiltro == 'cgm_contrato') ? 'contrato_todos' : $stTipoFiltro,
            'stValoresFiltro' => (string) $stFiltroContratos,
            "inCodPeriodoMovimentacaoInicial" => $inCodPeriodoMovimentacaoInicial['cod_periodo_movimentacao'],
            "inCodPeriodoMovimentacaoFinal" => $inCodPeriodoMovimentacaoFinal['cod_periodo_movimentacao'],
            "inCodConfiguracao" => (string) $inCodConfiguracao,
            "inCodComplementar" => (is_null($complementar)) ? 0 : $complementar,
            "stOrdenacaoEventos" => (string) $stOrdenacaoEventos,
            "stOrdenacaoContratos" => (string) $stOrdem,
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
        $fieldOptions['emitir'] = [
            'choices' => [
                'label.porTipoCalculo' => 'tipo_calculo',
                'label.todasOcorrenciasCalculo' => 'todas_ocorrencias',
            ],
            'label' => 'Emitir',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'mapped' => false
        ];

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

        $fieldOptions['anoInicial'] = [
            'label' => 'label.ferias.anoInicial',
            'mapped' => false,
            'attr' => [
                'value' => $this->getExercicio(),
                'class' => 'numero '
            ],
        ];

        $mes = $periodoMovimentacaoModel->getMesCompetenciaFolhaPagamento($this->getExercicio());
        $fieldOptions['mesInicial'] = [
            'label' => 'label.ferias.mesInicial',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'choices' => $mes,
            'data' => (is_array($mes)) ? end($mes) : $mes,
            'attr' => [
                'data-mes' => $mes,
            ],
            'attr' => ['class' => 'select2-parameters '],
        ];

        $fieldOptions['anoFinal'] = [
            'label' => 'label.ferias.anoFinal',
            'mapped' => false,
            'attr' => [
                'value' => $this->getExercicio(),
                'class' => 'numero '
            ],
        ];

        $fieldOptions['mesFinal'] = [
            'label' => 'label.ferias.mesFinal',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'choices' => $mes,
            'data' => (is_array($mes)) ? end($mes) : $mes,
            'attr' => [
                'data-mes' => $mes,
            ],
            'attr' => ['class' => 'select2-parameters '],
        ];
        $formMapper
            ->with("Parâmetros para consulta")
            ->add('anoInicial', 'number', $fieldOptions['anoInicial'])
            ->add('mesInicial', 'choice', $fieldOptions['mesInicial'])
            ->add('anoFinal', 'number', $fieldOptions['anoFinal'])
            ->add('mesFinal', 'choice', $fieldOptions['mesFinal'])
            ->end()
            ->with("Filtro");
        parent::configureFields($formMapper, GeneralFilterAdmin::RECURSOSHUMANOS_FOLHA_FICHA_FINANCEIRA);
        $formMapper->end()
            ->with("label.emitir")
            ->add('emitir', 'choice', $fieldOptions['emitir'])
            ->add('tipoCalculo', 'choice', $fieldOptions['tipoCalculo'])
            ->add('inCodComplementar', 'choice', $fieldOptions['inCodComplementar'])
            ->end()
            ->with("label.ordenacaoEventos")
            ->add('ordenacaoEventos', 'choice', $fieldOptions['ordenacao'])
            ->end();

        $admin = $this;
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $entityManager, $periodoMovimentacaoModel) {
                $form = $event->getForm();
                $data = $event->getData();

                if (isset($data['tipoCalculo']) && $data['tipoCalculo'] != "") {
                    $mes = ((int) $data['mesFinal'] < 10) ? "0" . $data['mesFinal'] : $data['mesFinal'];
                    $dtFinal = $mes . '/' . $data['anoFinal'];
                    $periodoMovimentacao = $entityManager->getRepository(PeriodoMovimentacao::class)
                        ->consultaPeriodoMovimentacaoCompetencia($dtFinal);

                    /** @var PeriodoMovimentacao $periodo */
                    $periodo = $periodoMovimentacaoModel->findOneByCodPeriodoMovimentacao($periodoMovimentacao['cod_periodo_movimentacao']);

                    $dados = [];
                    $choiceValue = $periodo->getCodPeriodoMovimentacao();
                    $choiceKey = $periodo->getCodPeriodoMovimentacao();
                    $dados[$choiceKey] = $choiceValue;

                    $inCodComplementar = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('inCodComplementar', 'choice', null, [
                            'attr' => ['class' => 'select2-parameters '],
                            'auto_initialize' => false,
                            'choices' => $dados,
                            'label' => 'label.recursosHumanos.relatorios.folha.contraCheque.inCodComplementar',
                            'mapped' => false,
                        ]);

                    $form->add($inCodComplementar);
                }
            }
        );
    }
}
