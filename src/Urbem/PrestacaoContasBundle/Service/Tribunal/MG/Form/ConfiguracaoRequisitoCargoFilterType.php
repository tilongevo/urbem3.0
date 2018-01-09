<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Form\Type\DynamicCollectionType;
use Urbem\PrestacaoContasBundle\Form\Type\EntidadeType;
/**
 * Class ConfiguracaoTipoCargoServidorFilterType
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form
 */
class ConfiguracaoRequisitoCargoFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('entidade', EntidadeType::class, [
            'placeholder' => 'Selecione',
            'label' => 'Entidade',
            'fix_option_value' => true,
            'attr' => ['class' => 'select2-parameters '],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        $builder->add('registros', DynamicCollectionType::class, [
            'dynamic_type' => ConfiguracaoRequisitoCargoType::class,
            'label' => 'Informações do Requisitos de Cargos'
        ]);
    }
}