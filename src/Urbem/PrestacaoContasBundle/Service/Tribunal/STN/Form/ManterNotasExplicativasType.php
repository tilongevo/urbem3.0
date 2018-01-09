<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Urbem\CoreBundle\Form\Type\DynamicCollectionType;

/**
 * Class ManterNotasExplicativasType
 * @package Urbem\PrestacaoContasBundle\Form\Type
 */
class ManterNotasExplicativasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('itens', DynamicCollectionType::class, [
            'dynamic_type' => ManterNotasExplicativasCollectionType::class,
            'label' => 'Itens Incluídos',
        ]);
    }

}
