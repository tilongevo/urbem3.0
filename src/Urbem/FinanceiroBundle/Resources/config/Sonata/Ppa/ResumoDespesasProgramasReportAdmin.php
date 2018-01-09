<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Ppa;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ResumoDespesasProgramasReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_ppa_relatorios_resumo_despesas_programas';
    protected $baseRoutePattern = 'financeiro/plano-plurianual/ppa/relatorios/resumo-despesas-programas';
    protected $layoutDefaultReport = '/bundles/report/gestaoFinanceira/fontes/RPT/ppa/report/design/resumoDespesasProgramas.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar relatório'];

    public function prePersist($object)
    {

        $tipoPrograma = $object->getTipoPrograma()->getCodTipoPrograma();
        $de  = $object->getProgramaDe();
        $ate = $object->getProgramaAte();
        $naturezaTemporal = $object->getNaturezaTemporal();
        $entity = $object->getPpa();

        $fileName = $this->parseNameFile("acoesNaoOrcamentarias");
        $params = [
            'ano_inicio' => $entity->getAnoInicio(),
            'num_programa_ini' => $de,
            'num_programa_fim' => $ate,
            'cod_ppa' => $entity->getCodPpa(),
            'exercicio' => $this->getExercicio(),
            'cod_tipo_programa' => $tipoPrograma,
            'continuo' => $naturezaTemporal,
            'cod_acao' => '2729',
            'inCodGestao' => 2,
            'inCodModulo' => 43,
            'inCodRelatorio' => 4,
            'term_user' => $this->getCurrentUser()->getUserName()
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
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codFake')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codFake')
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
        $this->setBreadCrumb();

        $translator = $this->getConfigurationPool()->getContainer()->get('translator.default');
        $boNatureza = [
            $translator->transChoice('label.programas.choices.boNatureza.continuo', 0, [], 'messages')=>1,
            $translator->transChoice('label.programas.choices.boNatureza.temporario', 0, [], 'messages')=>2,
            $translator->transChoice('label.programas.choices.boNatureza.todos', 0, [], 'messages')=>null
        ];

        $formMapper
            ->add(
                'ppa',
                'entity',
                array(
                    'class' => 'CoreBundle:Ppa\Ppa',
                    'label' => 'label.ppa.ppa',
                    'required' => false,
                    'placeholder' => 'label.selecione',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                )
            )
            ->add(
                'programaDe',
                'text',
                array(
                    'label' => 'label.programas.programaDe',
                    'required' => false,
                )
            )
            ->add(
                'programaAte',
                'text',
                array(
                    'label' => 'label.programas.programaAte',
                    'required' => false,
                )
            )
            ->add(
                'tipoPrograma',
                'entity',
                array(
                    'class' => 'CoreBundle:Ppa\TipoPrograma',
                    'choice_label' => 'descricao',
                    'label' => 'label.programas.inCodTipoPrograma',
                    'required' => false,
                    'placeholder' => 'label.selecione',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                )
            )
            ->add(
                'naturezaTemporal',
                'choice',
                [
                    'required' => false,
                    'choices' => $boNatureza,
                    'label' => 'label.programas.boNatureza',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codFake')
        ;
    }
}
