<?php

namespace Urbem\CoreBundle\Form\Type\Compras;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Beneficio\Fornecedor;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;

class FornecedorType extends AbstractType
{
    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('class', Fornecedor::class);
        $resolver->setDefault('label', 'Fornecedor');
        $resolver->setDefault('attr', ['class' => 'select2-parameters ']);
        $resolver->setDefault('route', [
            'name' => AutoCompleteType::ROUTE_AUTOCOMPLETE_DEFAULT,
            'parameters' => [
                'json_from_admin_field' => 'autocomplete_field' // FornecedorAdmin
            ]
        ]);
        $resolver->setDefault('json_from_admin_code', 'core.admin.filter.fornecedor');
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return AutoCompleteType::class;
    }
}
