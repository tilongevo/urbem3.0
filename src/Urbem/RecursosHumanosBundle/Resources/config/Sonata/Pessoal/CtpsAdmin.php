<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class CtpsAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_ctps';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/ctps';

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
        $fieldOptions = [];

        $fieldOptions['numero'] = [
            'label' => 'label.servidor.numero',
            'attr' => [
                'class' => 'numeric '
            ],
        ];

        $fieldOptions['serie'] = [
            'label' => 'label.servidor.serie'
        ];

        $fieldOptions['dtEmissao'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.servidor.dtEmissao',
        ];

        $fieldOptions['orgaoExpedidor'] = [
            'label' => 'label.servidor.orgaoExpedidor'
        ];

        $fieldOptions['fkSwUf'] = [
            'class' => 'CoreBundle:SwUf',
            'choice_label' => 'siglaUf',
            'label' => 'label.servidor.estado',
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'required' => false,
        ];

        $formMapper
            ->add(
                'numero',
                null,
                $fieldOptions['numero']
            )
            ->add(
                'serie',
                null,
                $fieldOptions['serie']
            )
            ->add(
                'dtEmissao',
                'sonata_type_date_picker',
                $fieldOptions['dtEmissao']
            )
            ->add(
                'orgaoExpedidor',
                null,
                $fieldOptions['orgaoExpedidor']
            )
            ->add(
                'fkSwUf',
                'entity',
                $fieldOptions['fkSwUf']
            )
        ;
    }
}
