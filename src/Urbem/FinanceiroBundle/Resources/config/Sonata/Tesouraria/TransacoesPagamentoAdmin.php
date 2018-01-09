<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Sonata\AdminBundle\Form\FormMapper;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class TransacoesPagamentoAdmin
 * @package Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria
 */
class TransacoesPagamentoAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapperOptions['codTipo'] = [
            'attr' => ['class' => 'select2-parameters '],
            'choices' => [
                "Não Informado" => "1",
                "Transferência - C/C" => "2",
                "Transferência - Poupança" => "3",
                "DOC" => "4",
                "TED" => "5",
            ],
            'label' => 'label.bordero.tipo'
        ];

        $formMapper
            ->add('codTipo', 'choice', $formMapperOptions['codTipo'])
        ;
    }
}
