<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Urbem\CoreBundle\Form\Type\DynamicCollectionType;

/**
 * Class VincularReceitaSaudeAnexo12Type
 * @package Urbem\PrestacaoContasBundle\Form\Type
 */
class VincularReceitaSaudeAnexo12Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('receitas', DynamicCollectionType::class, [
            'dynamic_type' => VincularReceitaSaudeAnexo12CollectionType::class,
            'label' => 'Receitas Vinculadas',
        ]);
    }
}
