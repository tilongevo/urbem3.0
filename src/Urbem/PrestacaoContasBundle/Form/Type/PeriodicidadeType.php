<?php

namespace Urbem\PrestacaoContasBundle\Form\Type;

use Sonata\CoreBundle\Form\Type\DateRangeType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PeriodicidadeType extends DateRangeType
{
    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'field_options_start' => [
                "label" => "Ínicio"
            ],
            'field_options_end' => [
                "label" => "Fim"
            ],
            'field_type' => 'prestacao_contas_date_picker'
        ]);
    }
}
