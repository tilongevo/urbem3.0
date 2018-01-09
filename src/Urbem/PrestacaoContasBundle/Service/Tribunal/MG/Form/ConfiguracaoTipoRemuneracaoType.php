<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Class ConfiguracaoTipoRemuneracaoType
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form
 */
class ConfiguracaoTipoRemuneracaoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('remuneracao', TipoRemuneracaoType::class, [
            'placeholder' => 'Selecione',
            'label' => 'Tipo de Remuneração',
            'attr' => ['class' => 'select2-parameters '],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        $builder->add('evento', EventoType::class, [
            'label' => 'Evento',
            'attr' => ['class' => ' select2-parameters '],
            'multiple' => true,
            'required' => true,
            'constraints' => [new NotNull()],
        ]);
    }
}