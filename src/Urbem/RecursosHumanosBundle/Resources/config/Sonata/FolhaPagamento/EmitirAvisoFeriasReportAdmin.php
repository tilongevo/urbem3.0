<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class EmitirAvisoFeriasReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_relatorios_emitir_aviso_ferias';

    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/relatorios/emitir-aviso-ferias';

    protected $layoutDefaultReport = '/bundles/report/gestaoRH/fontes/RPT/pessoal/report/design/EmitirAvisoFerias.rptdesign';

    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar aviso'];

    public function prePersist($object)
    {
        $filtro = $this->configureFilters($object);
        $fileName = $this->parseNameFile("emitirAvisoFerias");
        $params = [
            // Códigos contidos no menu
            'cod_acao' => '1512',
            'exercicio' => $this->getExercicio(),
            'inCodGestao' => '4',
            'inCodModulo' => '22',
            'inCodRelatorio' => '4',
            'stEntidade' => '',
            'stcodEntidade' => '',
            // Entidade escolhida no combo de RH
            'mesCompetencia' => $object->getCompetencia()->format("m"),
            'anoCompetencia' => $object->getCompetencia()->format("Y"),
            'OrderBy' => null,
            'codSubDivisao' => $filtro['subdivisao'],
            'codRegime' => $filtro['regime'],
            'codMatricula' => $filtro['matricula'],
            'codLotacao' => $filtro['lotacao'],
            'codLocal' => $filtro['local']
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

    private function configureFilters($object)
    {
        if ($object->getTipoFiltro() == 1) { // Matricula
            $matriculas = $object->getMatricula();
            $matriculasString = ArrayHelper::parseCollectionToString($matriculas, 'getNumCgm', ',');
            return [
                'matricula' => $matriculasString,
                'local' => null,
                'subdivisao' => null,
                'lotacao' => null,
                'regime' => null,
            ];
        }

        if ($object->getTipoFiltro() == 2) { // Lotacao
            $lotacoes = $object->getLotacao();
            $lotacoesString = ArrayHelper::parseCollectionToString($lotacoes, 'getCodOrgao', ',');
            return [
                'matricula' => null,
                'local' => null,
                'subdivisao' => null,
                'lotacao' => $lotacoesString,
                'regime' => null,
            ];
        }

        if ($object->getTipoFiltro() == 3) { // Local
            $locais = $object->getLocal();

            $locaisString = ArrayHelper::parseCollectionToString($locais, 'getCodLocal', ',');
            return [
                'matricula' => null,
                'local' => $locaisString,
                'subdivisao' => null,
                'lotacao' => null,
                'regime' => null,
            ];
        }

        if ($object->getTipoFiltro() == 4) { // Regime/Subdivisao
            $regimes = $object->getRegime();
            $regimesString = ArrayHelper::parseCollectionToString($regimes, 'getCodRegime', ',');

            $subidvisoes = $object->getSubdivisao();
            $subidvisoesString = ArrayHelper::parseCollectionToString($subidvisoes, 'getCodSubDivisao', ',');
            return [
                'matricula' => null,
                'local' => null,
                'subdivisao' => $subidvisoesString,
                'lotacao' => null,
                'regime' => $regimesString,
            ];
        }

        return [
            'matricula' => null,
            'local' => null,
            'subdivisao' => null,
            'lotacao' => null,
            'regime' => null,
        ];
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codFakeEmitirAvisoFerias')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $formMapper

            ->with("label.emitirAvisoFerias")
            ->add(
                'competencia',
                'date',
                array(
                    'label' => 'Competência',
                    'widget' => 'single_text',
                    'html5' => false,
                    'attr' => array(
                        'data-provide' => 'datepicker',
                        'class' => 'datepicker '
                    ),
                    'mapped' => false,
                    'format' => 'MM/dd/yyyy',
                )
            )
            ->end()
            ->with("Filtro")
            ->add(
                'tipoFiltro',
                'choice',
                [
                    'required' => true,
                    'choices' => [
                        'label.matricula' => 1,
                        'label.lotacao' => 2,
                        'label.local' => 3,
                        'label.regimeSubdivisao' => 4,
                    ],
                    'label' => 'label.tipoFiltro',
                    'mapped' => false,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'matricula',
                'entity',
                array(
                    'class' => 'CoreBundle:SwCgmPessoaFisica',
                    'choice_label' => function ($cgmPessoa) {
                        return $cgmPessoa->getNumCgm() . ' - ' . $cgmPessoa->getFkSwCgm()->getNomCgm();
                    },
                    'label' => 'Matrícula',
                    'multiple' => true,
                    'required' => false,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                    'mapped' => false
                )
            )
            ->add(
                'lotacao',
                'entity',
                array(
                    'class' => 'CoreBundle:Organograma\Orgao',
                    'choice_label' => 'siglaOrgao',
                    'label' => 'Lotação',
                    'multiple' => true,
                    'required' => false,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                    'mapped' => false
                )
            )
            ->add(
                'local',
                'entity',
                array(
                    'class' => 'CoreBundle:Organograma\Local',
                    'choice_label' => 'descricao',
                    'label' => 'Locais',
                    'multiple' => true,
                    'required' => false,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                    'mapped' => false
                )
            )
            ->add(
                'regime',
                'entity',
                array(
                    'class' => 'CoreBundle:Pessoal\Regime',
                    'choice_label' => 'descricao',
                    'label' => 'label.regime',
                    'multiple' => true,
                    'required' => false,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                    'mapped' => false
                )
            )
            ->add(
                'subdivisao',
                'entity',
                array(
                    'class' => 'CoreBundle:Pessoal\SubDivisao',
                    'choice_label' => 'descricao',
                    'label' => 'label.subdivisao',
                    'multiple' => true,
                    'required' => false,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                    'mapped' => false
                )
            )
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codFakeEmitirAvisoFerias')
        ;
    }
}
