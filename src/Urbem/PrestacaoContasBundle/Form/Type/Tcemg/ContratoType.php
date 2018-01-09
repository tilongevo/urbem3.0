<?php

namespace Urbem\PrestacaoContasBundle\Form\Type\Tcemg;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Tcemg\Contrato;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;

class ContratoType extends AbstractType
{
    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('class', Contrato::class);
        /* @see src/Urbem/CoreBundle/Resources/config/Sonata/Filter/Tcemg/ContratoAdminObjeto.php */
        $resolver->setDefault('json_from_admin_code', 'core.admin.filter.tcemg_contrato');

        $resolver->setDefault('minimum_input_length', 1);

        $resolver->setDefault('route', [
            'name' => AutoCompleteType::ROUTE_AUTOCOMPLETE_DEFAULT,
            'parameters' => [
                'json_from_admin_field' => 'autocomplete_field' // ContratoAdmin autocomplete_field field
            ]
        ]);

        $resolver->setDefault('label', 'Contrato');
    }

    public function getParent()
    {
        return AutoCompleteType::class;
    }
}
