<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Class ConfiguracaoRequisitoCargoType
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form
 */
class ConfiguracaoRequisitoCargoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('requisito', TipoRequisitoCargoType::class, [
            'placeholder' => 'Selecione',
            'label' => 'Requisito do Cargo',
            'attr' => ['class' => 'select2-parameters '],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        $builder->add('cargo', CargoType::class, [
            'label' => 'Cargo',
            'attr' => ['class' => ' select2-parameters '],
            'multiple' => true,
            'required' => true,
            'constraints' => [new NotNull()],
        ]);
    }
}