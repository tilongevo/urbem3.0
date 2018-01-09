<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Orcamento\Receita;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;

/**
 * Class VincularReceitaSaudeAnexo12CollectionType
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Form
 */
class VincularReceitaSaudeAnexo12CollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('exercicio', TextType::class, [
            'label' => 'Exercicio',
            'required' => true,
            'attr' => ['maxlength' => 4],
            'constraints' => [new NotNull()]
        ]);

        $builder->add('codReceita', AutoCompleteType::class, [
            'label' => 'Receita',
            'class' => Receita::class,
            'json_from_admin_code' => 'core.admin.filter.stn_receita',
            'attr' => ['class' => 'select2-parameters '],
            'route' => [
                'name' => AutoCompleteType::ROUTE_AUTOCOMPLETE_DEFAULT,
                'parameters' => [
                    'json_from_admin_field' => 'autocomplete_field'
                ]
            ],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);
    }
}