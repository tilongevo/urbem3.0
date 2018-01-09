<?php

namespace Urbem\PrestacaoContasBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;

class NormaType extends AbstractType
{
    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('class', Norma::class);
        $resolver->setDefault('label', 'Norma');

        /* @see src/Urbem/CoreBundle/Resources/config/Sonata/Filter/Normas/NormaAdmin.php */
        $resolver->setDefault('json_from_admin_code', 'core.admin.filter.normas_norma');

        $resolver->setDefault('route', [
            'name' => AutoCompleteType::ROUTE_AUTOCOMPLETE_DEFAULT,
            'parameters' => [
                'json_from_admin_field' => 'autocomplete_field' // NormaAdmin autocomplete_field field
            ]
        ]);
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return AutoCompleteType::class;
    }
}
