<?php

namespace Urbem\CoreBundle\Form\Type\Organograma;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Organograma\Orgao;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;

class OrgaoType extends AbstractType
{
    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('class', Orgao::class);
        $resolver->setDefault('label', 'Órgão');
        $resolver->setDefault('attr', ['class' => 'select2-parameters ']);
        /* @see src/Urbem/CoreBundle/Resources/config/Sonata/Filter/Organamograma/OrgaoAdmin.php */
        $resolver->setDefault('json_from_admin_code', 'core.admin.filter.organograma_orgao');

        $resolver->setDefault('minimum_input_length', 1);

        $resolver->setDefault('route', [
            'name' => AutoCompleteType::ROUTE_AUTOCOMPLETE_DEFAULT,
            'parameters' => [
                'json_from_admin_field' => 'autocomplete_field' // OrgaoAdmin autocomplete_field field
            ]
        ]);
    }

    public function getParent()
    {
        return AutoCompleteType::class;
    }
}