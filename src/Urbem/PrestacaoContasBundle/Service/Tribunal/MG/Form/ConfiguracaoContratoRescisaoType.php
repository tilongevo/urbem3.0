<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Tcemg\ContratoRescisao;
use Urbem\CoreBundle\Form\Type\CurrencyType;
use Urbem\PrestacaoContasBundle\Form\Type\DatePickerType;
use Urbem\PrestacaoContasBundle\Form\Type\Tcemg\ContratoType;

class ConfiguracaoContratoRescisaoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fkTcemgContrato', ContratoType::class, [
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        $builder->add('dataRescisao', DatePickerType::class, [
            'label' => 'Data da Rescisão',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        $builder->add('valorRescisao', CurrencyType::class, [
            'label' => 'Valor da Rescisão',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', ContratoRescisao::class);
        $resolver->setDefault('show_error', true);
    }
}