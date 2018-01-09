<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Monetario\Credito;

use Datetime;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class CreditoNormaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_monetario_credito_norma';
    protected $baseRoutePattern = 'tributario/cadastro-monetario/credito-norma';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codEspecie')
            ->add('codGenero')
            ->add('codNatureza')
            ->add('codCredito')
            ->add('codNorma');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codEspecie')
            ->add('codGenero')
            ->add('codNatureza')
            ->add('codCredito')
            ->add('codNorma');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $fieldOptions['fkNormasNorma'] = [
            'label' => 'label.monetarioCreditoNorma.codNorma',
            'class' => Norma::class,
            'property' => 'codNorma',
            'required' => true,
            'route' => ['name' => 'administrativo_normas_norma_carrega_norma'],
            'placeholder' => 'Selecione',
        ];

        $now = new DateTime();
        $formMapperOptions['dtInicioVigencia'] = [
            'pk_class' => DatePK::class,
            'dp_default_date' => $now->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'required' => true,
            'label' => 'label.monetarioCreditoNorma.dtInicioVigencia',
        ];

        $formMapper
            ->add('fkNormasNorma', 'sonata_type_model_autocomplete', $fieldOptions['fkNormasNorma'], ['admin_code' => 'administrativo.admin.norma'])
            ->add('dtInicioVigencia', 'datepkpicker', $formMapperOptions['dtInicioVigencia']);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codEspecie')
            ->add('codGenero')
            ->add('codNatureza')
            ->add('codCredito')
            ->add('codNorma');
    }
}
