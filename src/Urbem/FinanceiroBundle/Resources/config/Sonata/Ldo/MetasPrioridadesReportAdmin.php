<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Ldo;

use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class MetasPrioridadesReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_ldo_metas_prioridades_report';
    protected $baseRoutePattern = 'financeiro/ldo/metas-prioridades-report';
    protected $layoutDefaultReport = '/bundles/report/gestaoFinanceira/fontes/RPT/ldo/report/design/LDOAnexoI.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar relatório'];
    protected $includeJs = ['/financeiro/javascripts/ldo/metas-prioridades-report.js'];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('programas_por_cod_ppa', 'programas-por-cod-ppa');
        $collection->add('exercicio_ldo_por_cod_ppa', 'exercicio-por-cod-ppa');
    }

    public function prePersist($object)
    {

        $ldo = [];
        if ($object->getExercicioLdo()) {
            $entityManager = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
            $repository = $entityManager->getRepository('CoreBundle:Ldo\Ldo');
            $ldoEntity = $repository->findOneBy(['codPpa' =>  $object->getPpa(), 'ano' => $object->getExercicioLdo()]);
            $ldo['ano'] = $object->getExercicioLdo();
            $ldo['ano_ldo'] = $ldoEntity->getTimestamp()->format('Y');
        }

        $entity = $object->getPpa();
        $fileName = $this->parseNameFile("LDOAnexoI");
        $params = [
            'ano_inicio' => $entity->getAnoInicio(),
            'cod_ppa' => $entity->getCodPpa(),
            'exercicio' => $this->getExercicio(),
            'term_user' => $this->getCurrentUser()->getUserName(),
            'cod_acao' => '2740',
            'inCodGestao' => 2,
            'inCodModulo' => 44,
            'inCodRelatorio' => 1,
            'exibe_nao_orcamentaria' => $object->getDemonstrarNaoOrcamentaria(),
            'cod_programa' => $object->getPrograma(),
            'cod_acao_ini' => $object->getAcaoDe(),
            'cod_acao_fim' => $object->getAcaoAte()
        ];

        $params = array_merge($params, $ldo);

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
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $entityManager = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $repository = $entityManager->getRepository('CoreBundle:Ldo\MetasPrioridadesReport');
        $allProgramas = ArrayHelper::parseArrayToChoice($repository->findAllProgramasPorCodPpa(), 'identificacao', 'num_programa');
        $allExerciciosLdo = ArrayHelper::parseArrayToChoice($repository->findAllExercicioLdoPorCodPpa(), 'exercicio', 'ano');

        $translator = $this->getConfigurationPool()->getContainer()->get('translator.default');
        $demonstrarNaoOrcamentaria = [
            $translator->transChoice('sim', 0, [], 'messages')=>1,
            $translator->transChoice('nao', 0, [], 'messages')=>2
        ];

        $formMapper
            ->add(
                'ppa',
                'entity',
                array(
                    'required' => false,
                    'class' => 'CoreBundle:Ppa\Ppa',
                    'label' => 'label.ppa.ppa',
                    'placeholder' => 'label.selecione',
                    'attr' => [
                        'class' => 'select2-parameters ppa-ppa'
                    ],
                )
            )
            ->add(
                'exercicioLdo',
                'choice',
                [
                    'required' => false,
                    'choices' => $allExerciciosLdo,
                    'label' => 'label.validacaoAcoes.slExercicioLDO',
                    'choice_value' => function ($value) {
                        return $value;
                    },
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'programa',
                'choice',
                [
                    'required' => false,
                    'choices' => $allProgramas,
                    'label' => 'label.programas.numPrograma',
                    'choice_value' => function ($value) {
                        return $value;
                    },
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'demonstrarNaoOrcamentaria',
                'choice',
                [
                    'required' => false,
                    'choices' => $demonstrarNaoOrcamentaria,
                    'label' => 'label.demonstrarNaoOrcamentarias',
                    'choice_value' => function ($value) {
                        return $value;
                    },
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'acaoDe',
                'text',
                [
                    'label' => 'label.ldo.relatorios.acaoDe',
                    'required' => false,
                ]
            )
            ->add(
                'acaoAte',
                'text',
                [
                    'label' => 'label.ldo.relatorios.acaoAte',
                    'required' => false,
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
