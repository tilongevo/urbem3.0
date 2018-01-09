<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\AtributoValorPadrao;
use Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEvento;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Model\Folhapagamento\FolhaComplementarModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\Filter\Pessoal\GeneralFilterAdmin as AbstractAdmin;
use Urbem\RecursosHumanosBundle\Helper\Constants\Folhapagamento\FolhaAnaliticaSinteticaReport as FolhaAnaliticaSinteticaReportConstants;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\AdministrativoBundle\Helper\Constants\TipoAtributo;

/**
 * Class FolhaAnaliticaSinteticaReportAdmin
 * @package Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento
 */
class FolhaAnaliticaSinteticaReportAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_relatorios_folha_analitica_sintetica';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/relatorios/folha-analitica-sintetica';

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->clearExcept(array('create'))
            ->add('imprimir', 'imprimir', [], [], [], '', [], ['POST'])
            ->add('folha_complementar_competencia', 'folha-complementar-competencia', [], [], [], '', [], ['POST'])
        ;
    }

    /**
     * Constrói campos de atributo dinamico para edição.
     *
     * @param FormMapper       $formMapper
     * @param AtributoDinamico $atributoDinamico
     * @param array            $options
     */
    public function configureFormFieldsAtributoDinamico(FormMapper $formMapper, AtributoDinamico $atributoDinamico, array $options = [])
    {
        $baseFieldOptions = [
            'label'    => $atributoDinamico->getNomAtributo(),
            'mapped'   => false,
            'required' => true
        ];

        $fieldName = sprintf('%s_atributoDinamico', $atributoDinamico->getCodAtributo());

        switch ($atributoDinamico->getCodTipo()) {
            case TipoAtributo::NUMERICO:
                $options = array_merge($options, $baseFieldOptions);

                if (isset($options['data'])) {
                    $options['data'] = abs($options['data']);
                }

                $formMapper->add($fieldName, 'number', $options);
                break;
            case TipoAtributo::TEXTO:
                $options = array_merge($options, $baseFieldOptions);

                $formMapper->add($fieldName, 'text', $options);
                break;
            case TipoAtributo::LISTA:
            case TipoAtributo::LISTA_MULTIPLA:
                $choices = [];

                /** @var AtributoValorPadrao $atributoValorPadrao */
                foreach ($atributoDinamico->getFkAdministracaoAtributoValorPadroes() as $atributoValorPadrao) {
                    $optionLabel = $atributoValorPadrao->getValorPadrao();
                    $optionValue = $atributoValorPadrao->getCodValor();

                    $choices[$optionLabel] = $optionValue;
                }

                $baseFieldOptions['choices'] = $choices;
                $baseFieldOptions['multiple'] = ($atributoDinamico->getCodTipo() == TipoAtributo::LISTA_MULTIPLA);

                $options = array_merge($options, $baseFieldOptions);

                $formMapper->add($fieldName, 'choice', $options);
                break;
            case TipoAtributo::DATA:
                $baseFieldOptions['format'] = 'dd/MM/yyyy';

                $options = array_merge($options, $baseFieldOptions);

                if (isset($options['data'])) {
                    $options['data'] = \DateTime::createFromFormat('d/m/Y', $options['data']);
                }

                $formMapper->add($fieldName, 'sonata_type_date_picker', $options);
                break;
            case TipoAtributo::NUMERICO_2:
                $options = array_merge($options, $baseFieldOptions);

                if (isset($options['data'])) {
                    $options['data'] = abs($options['data']);
                }

                $formMapper->add($fieldName, 'text', $options);
                break;
            case TipoAtributo::TEXTO_LONGO:
                $baseFieldOptions['attr']['class'] = 'money ';

                $options = array_merge($options, $baseFieldOptions);

                $formMapper->add($fieldName, 'textarea', $options);
                break;
        }
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $this->setIncludeJs(array_merge(parent::getIncludeJs(), [
            '/recursoshumanos/javascripts/folhapagamento/folhaAnaliticaSintetica.js'
        ]));

        $entityManager = $this->getDoctrine();

        $atributosDinamicos = $entityManager->getRepository(AtributoDinamico::class)
        ->findBy([
            'codCadastro' => FolhaAnaliticaSinteticaReportConstants::CODCADASTRO,
            'codModulo' => FolhaAnaliticaSinteticaReportConstants::CODMODULO
        ]);

        $inCodAtributoChoices = [];
        foreach ($atributosDinamicos as $atributoDinamico) {
            $inCodAtributoChoices[$atributoDinamico->getNomAtributo()] = $atributoDinamico->getCodAtributo();
        }

        $fieldOptions = [];

        $fieldOptions['stFolha'] = [
            'label' => 'label.folhaAnaliticaSintetica.stFolha',
            'choices' => [
                'label.folhaAnaliticaSintetica.stFolhaChoices.analítica_resumida' => 'analítica_resumida',
                'label.folhaAnaliticaSintetica.stFolhaChoices.analítica' => 'analítica',
                'label.folhaAnaliticaSintetica.stFolhaChoices.sintética' => 'sintética'
            ],
            'mapped' => false,
            'expanded' => true,
            'required' => false,
            'data' => 'analítica_resumida',
            'placeholder' => false,
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata'
            ]
        ];

        $fieldOptions['inAno'] = [
            'label' => 'label.ferias.ano',
            'mapped' => false,
            'attr' => [
                'class' => 'numero '
            ],
            'data' => $this->getExercicio()
        ];

        $inCodMesChoices = (new PeriodoMovimentacaoModel($entityManager))
        ->getMesCompetenciaFolhaPagamento($this->getExercicio());

        $inCodMesData = array_values($inCodMesChoices);

        $fieldOptions['inCodMes'] = [
            'label' => 'label.ferias.mes',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'choices' => $inCodMesChoices,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'data' => end($inCodMesData)
        ];

        $fieldOptions['boFiltrarFolhaComplementar'] = [
            'label' => 'label.folhaAnaliticaSintetica.boFiltrarFolhaComplementar',
            'mapped' => false,
            'required' => false,
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata'
            ]
        ];

        $inCodComplementarChoices = (new FolhaComplementarModel($entityManager))
        ->listaFolhaPagamentoComplementar($this->getExercicio(), end($inCodMesData), true);

        $fieldOptions['inCodComplementar'] = [
            'label' => 'label.folhaAnaliticaSintetica.inCodComplementar',
            'mapped' => false,
            'required' => false,
            'choices' => $inCodComplementarChoices,
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['inCodConfiguracao'] = [
            'class' => ConfiguracaoEvento::class,
            'choice_label' => 'descricao',
            'label' => 'label.folhaAnaliticaSintetica.inCodConfiguracao',
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['stTipoFiltro'] = [
            'label' => 'label.tipoFiltro',
            'choices' => [
                'matricula' => 'cgm_contrato',
                'atributo' => 'atributo'
            ],
            'mapped' => false,
        ];

        $fieldOptions['inContrato'] = [
            'label' => 'label.recursosHumanos.folhas.grid.matricula',
            'class' => Contrato::class,
            'route' => [
                'name' => 'carrega_contrato_nao_rescindido'
            ],
            'multiple' => true,
            'json_choice_label' => function ($contrato) {
                if (! is_null($contrato->getFkPessoalContratoServidor())) {
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
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'mapped' => false,
        ];

        $fieldOptions['inCodAtributo'] = [
            'label' => 'atributo',
            'choices' => $inCodAtributoChoices,
            'placeholder' => 'label.selecione',
            'mapped' => false,
        ];

        $fieldOptions['boAtributoDinamico'] = [
            'label' => 'label.folhaAnaliticaSintetica.boAtributoDinamico',
            'mapped' => false,
            'required' => false,
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata'
            ]
        ];

        $fieldOptions['boEmitirTotais'] = [
            'label' => 'label.folhaAnaliticaSintetica.boEmitirTotais',
            'mapped' => false,
            'required' => false,
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata'
            ]
        ];

        $fieldOptions['boEmitirRelatorio'] = [
            'label' => 'label.folhaAnaliticaSintetica.boEmitirRelatorio',
            'mapped' => false,
            'required' => false,
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata'
            ]
        ];

        $fieldOptions['stOrdenacao'] = [
            'label' => 'label.folhaAnaliticaSintetica.stOrdenacao',
            'choices' => [
                'Alfabética' => 'alfabetica',
                'Numérica' => 'numérica'
            ],
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata'
            ],
            'mapped' => false,
            'expanded' => true,
            'data' => 'alfabetica',
            'placeholder' => false,
            'required' => false,
        ];

        $fieldOptions['stOrdenacaoEventos'] = [
            'label' => 'label.folhaAnaliticaSintetica.stOrdenacaoEventos',
            'choices' => [
                'Código do Evento' => 'codigo',
                'Sequência de Cálculo' => 'sequencia'
            ],
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata'
            ],
            'mapped' => false,
            'expanded' => true,
            'data' => 'codigo',
            'placeholder' => false,
            'required' => false,
        ];

        $formMapper
            ->with('selecaoFiltro')
                ->add(
                    'stFolha',
                    'choice',
                    $fieldOptions['stFolha']
                )
                ->add(
                    'inAno',
                    'number',
                    $fieldOptions['inAno']
                )
                ->add(
                    'inCodMes',
                    'choice',
                    $fieldOptions['inCodMes']
                )
                ->add(
                    'boFiltrarFolhaComplementar',
                    'checkbox',
                    $fieldOptions['boFiltrarFolhaComplementar']
                )
                ->add(
                    'inCodComplementar',
                    'choice',
                    $fieldOptions['inCodComplementar']
                )
                ->add(
                    'inCodConfiguracao',
                    'entity',
                    $fieldOptions['inCodConfiguracao']
                )
                ->add(
                    'stTipoFiltro',
                    'choice',
                    $fieldOptions['stTipoFiltro']
                )
                ->add(
                    'inCodAtributo',
                    'choice',
                    $fieldOptions['inCodAtributo']
                )
            ->end()
            ->with('filtroMatricula')
                ->add(
                    'inContrato',
                    'autocomplete',
                    $fieldOptions['inContrato']
                )
            ->end()
            ->with('label.atributos')
        ;

        foreach ($atributosDinamicos as $atributoDinamico) {
            $this->configureFormFieldsAtributoDinamico($formMapper, $atributoDinamico);
        }

        $formMapper
                ->add(
                    'boAtributoDinamico',
                    'checkbox',
                    $fieldOptions['boAtributoDinamico']
                )
                ->add(
                    'boEmitirTotais',
                    'checkbox',
                    $fieldOptions['boEmitirTotais']
                )
                ->add(
                    'boEmitirRelatorio',
                    'checkbox',
                    $fieldOptions['boEmitirRelatorio']
                )
            ->end()
            ->with('label.ordenacao')
                ->add(
                    'stOrdenacao',
                    'choice',
                    $fieldOptions['stOrdenacao']
                )
                ->add(
                    'stOrdenacaoEventos',
                    'choice',
                    $fieldOptions['stOrdenacaoEventos']
                )
            ->end()
        ;

        $formMapper->getFormBuilder()->setAction('imprimir');
    }
}
