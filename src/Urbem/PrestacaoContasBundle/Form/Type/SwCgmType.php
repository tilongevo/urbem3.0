<?php

namespace Urbem\PrestacaoContasBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;

class SwCgmType extends AbstractType
{
    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('class', SwCgm::class);
        $resolver->setDefault('label', 'Responsável');

        /* @see src/Urbem/CoreBundle/Resources/config/Sonata/Filter/SwCgmAdmin.php */
        $resolver->setDefault('json_from_admin_code', 'core.admin.filter.sw_cgm');

        $resolver->setDefault('minimum_input_length', 1);

        $resolver->setDefault('route', [
            'name' => AutoCompleteType::ROUTE_AUTOCOMPLETE_DEFAULT,
            'parameters' => [
                'json_from_admin_field' => 'autocomplete_field' // SwCgmAdmin autocomplete_field field
            ]
        ]);
    }

    public function getParent()
    {
        return AutoCompleteType::class;
    }
}