<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Urbem\CoreBundle\Form\Type\DynamicCollectionType;

/**
 * Class ConfiguracaoAnexo3RCLType
 * @package Urbem\PrestacaoContasBundle\Form\Type
 */
class ConfiguracaoAnexo3RCLType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('registros', DynamicCollectionType::class, [
            'dynamic_type' => ConfiguracaoAnexo3RCLCollectionType::class,
            'label' => 'Vincular Receitas',
        ]);
    }

}
