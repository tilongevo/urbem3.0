<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Urbem\CoreBundle\Form\Type\CurrencyType;
use Urbem\PrestacaoContasBundle\Form\Type\FolhaPagamentoEventoType;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Class ConfiguracaoTipoCargoServidorType
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form
 */
class ConfiguracaoTipoCargoServidorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tipoCargo', TipoCargoServidorType::class, [
            'placeholder' => 'Selecione',
            'label' => 'Tipo de Cargo',
            'attr' => ['class' => 'select2-parameters '],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        $builder->add('regime', RegimeSubdivisaoType::class, [
            'label' => 'Regime/Subdivisão',
            'attr' => ['class' => ' select2-parameters '],
            'multiple' => true,
            'required' => true,
            'constraints' => [new NotNull()],
        ]);

        $builder->add('cargoServidor', CargoType::class, [
            'label' => 'Cargo',
            'attr' => ['class' => ' select2-parameters cargo-adjust-options '],
            'multiple' => true,
            'required' => true,
            'constraints' => [new NotNull()],
        ]);
    }
}