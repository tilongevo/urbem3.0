<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Urbem\CoreBundle\Form\Type\DynamicCollectionType;

class ConfiguracaoRiscosFiscaisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('registros', DynamicCollectionType::class, [
            'dynamic_type' => ConfiguracaoRiscosFiscaisCollectionType::class,
            'label' => 'Dados do Demonstrativo'
        ]);
    }
}