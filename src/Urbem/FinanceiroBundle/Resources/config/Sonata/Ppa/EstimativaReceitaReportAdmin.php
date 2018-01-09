<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Ppa;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class EstimativaReceitaReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_ppa_relatorios_estimativa_receita';
    protected $baseRoutePattern = 'financeiro/plano-plurianual/ppa/relatorios/estimativa-receita';
    protected $layoutDefaultReport = '/bundles/report/gestaoFinanceira/fontes/RPT/ppa/report/design/estimativaReceitaPPA.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar estimativa'];

    public function prePersist($object)
    {
        $entity = $object->getPpa();
        $fileName = $this->parseNameFile("estimativaReceitaPPA");
        $params = [
            'ano_inicio' => $entity->getAnoInicio(),
            'cod_ppa' => $entity->getCodPpa(),
            'exercicio' => $this->getExercicio(),
            'cod_acao' => '1512'
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
