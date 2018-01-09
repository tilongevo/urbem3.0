<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

class ContratoServidorConselhoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_contrato_servidor_conselho';
    protected $baseRoutePattern = 'recursos-humanos/servidor/contrato/conselho';
    protected $model = null;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create','edit']);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $now = new \DateTime();

        $fieldOptions = [];

        $fieldOptions['nrConselho'] = [
            'label' => 'label.numeroConselhoProfissional'
        ];

        $fieldOptions['dtValidade'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.dtValidade'
        ];

        $formMapper
            ->add(
                'nrConselho',
                null,
                $fieldOptions['nrConselho']
            )
            ->add(
                'dtValidade',
                'sonata_type_date_picker',
                $fieldOptions['dtValidade']
            )
        ;
    }
}
