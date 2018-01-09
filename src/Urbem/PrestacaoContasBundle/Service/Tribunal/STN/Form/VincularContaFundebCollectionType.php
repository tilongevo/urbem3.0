<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;
use Urbem\PrestacaoContasBundle\Form\Type\EntidadeType;

/**
 * Class VincularContaFundebCollectionType
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Form
 */
class VincularContaFundebCollectionType extends AbstractType
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

        $builder->add('codPlano', AutoCompleteType::class, [
            'label' => 'Conta de Banco',
            'class' => PlanoAnalitica::class,
            'json_from_admin_code' => 'core.admin.filter.stn_plano_conta_analitica',
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