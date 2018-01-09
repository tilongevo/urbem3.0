<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Calendario;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class FeriadosReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_calendario_relatorios_feriados';
    protected $baseRoutePattern = 'recursoshumanos/calendario/relatorios/feriados';
//    protected $layoutDefaultReport = '/bundles/report/gestaoFinanceira/fontes/RPT/contabilidade/report/design/relatorioConfiguracaoLancamentoDespesa.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar Relatório'];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create'));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $exercicio = $this->getExercicio();

        $feriadosOpt = [
            'label.calendario_feriado.fixo' => 'F',
            'label.calendario_feriado.variavel' => 'V',
            'label.calendario_feriado.pontofacultativo' => 'P',
            'label.calendario_feriado.diacompensado' => 'D'
        ];

        $fieldOptions = [];

        $fieldOptions['dtFeriado'] = [
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
            'label' => 'label.calendario_feriado.dataEvento'
        ];
        $fieldOptions['tipoferiado'] = [
            'choices' => $feriadosOpt,
            'expanded' => true,
            'mapped' => false,
            'multiple' => false,
            'label' => 'label.calendario_feriado.tipoEvento',
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata'
            ]
        ];

        $fieldOptions['abrangencia'] = [
            'choices' => [
                'label.calendario_feriado.federal' => 'F',
                'label.calendario_feriado.estadual' => 'E',
                'label.calendario_feriado.municipal' => 'M',
            ],
            'label' => "label.calendario_feriado.abrangencia",
            'required' => false,
            'multiple' => false,
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        ];

        $formMapper
            ->add('dtFeriado', 'sonata_type_date_picker', $fieldOptions['dtFeriado'])
            ->add('tipoferiado', 'choice', $fieldOptions['tipoferiado'])
            ->add('abrangencia', 'choice', $fieldOptions['abrangencia'])
        ;
    }
}
