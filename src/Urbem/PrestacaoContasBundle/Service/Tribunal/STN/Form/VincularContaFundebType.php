<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Urbem\CoreBundle\Form\Type\DynamicCollectionType;

/**
 * Class VincularContaFundebType
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Form
 */
class VincularContaFundebType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('contas', DynamicCollectionType::class, [
            'dynamic_type' => VincularContaFundebCollectionType::class,
            'label' => 'Conta Caixa das Entidades'
        ]);
    }
}