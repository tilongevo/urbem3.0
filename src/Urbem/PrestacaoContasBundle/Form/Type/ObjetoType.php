<?php

namespace Urbem\PrestacaoContasBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Compras\Objeto;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;

class ObjetoType extends AbstractType
{
    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('class', Objeto::class);
        /* @see src/Urbem/CoreBundle/Resources/config/Sonata/Filter/Compras/Objeto.php */
        $resolver->setDefault('json_from_admin_code', 'core.admin.filter.compras_objeto');

        $resolver->setDefault('minimum_input_length', 1);

        $resolver->setDefault('route', [
            'name' => AutoCompleteType::ROUTE_AUTOCOMPLETE_DEFAULT,
            'parameters' => [
                'json_from_admin_field' => 'autocomplete_field' // ObjetoAdmin autocomplete_field field
            ]
        ]);

        $resolver->setDefault('label', 'Objeto');
    }

    public function getParent()
    {
        return AutoCompleteType::class;
    }
}
