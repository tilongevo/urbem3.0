<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Ppa;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class DespesasPrevistasFuncaoReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_ppa_relatorios_despesas_previstas_funcao';
    protected $baseRoutePattern = 'financeiro/plano-plurianual/ppa/relatorios/despesas-previstas-funcao';
    protected $layoutDefaultReport = '/bundles/report/gestaoFinanceira/fontes/RPT/ppa/report/design/despesasPrevistasFuncao.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar relatório'];

    public function prePersist($object)
    {
        $codFuncao = $object->getFuncao();
        $entity = $object->getPpa();
        $fileName = $this->parseNameFile("despesasPrevistasFuncao");
        $params = [
            'ano_inicio' => $entity->getAnoInicio(),
            'cod_ppa' => $entity->getCodPpa(),
            'exercicio' => $this->getExercicio(),
            'cod_funcao' => $codFuncao,
            'cod_acao' => '2727',
            'inCodGestao' => 2,
            'inCodModulo' => 43,
            'inCodRelatorio' => 3,
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

        $entityManager = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $pmcRepository = $entityManager->getRepository('CoreBundle:Ppa\DespesasPrevistasFuncaoReport');
        $funcoes = $pmcRepository->findAllFuncaoPorExercicio($this->getExercicio());

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
                'funcao',
                'choice',
                [
                    'required' => false,
                    'choices' => $funcoes,
                    'label' => 'label.funcao.modulo',
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
