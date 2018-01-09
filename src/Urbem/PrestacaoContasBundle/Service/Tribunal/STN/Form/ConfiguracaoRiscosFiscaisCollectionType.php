<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\PrestacaoContasBundle\Form\Type\EntidadeType;

class ConfiguracaoRiscosFiscaisCollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('entidade', EntidadeType::class, [
            'placeholder' => 'Selecione',
            'label' => 'Entidade',
            'fix_option_value' => true,
            'attr' => ['class' => 'select2-parameters '],
            'multiple' => true,
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        $builder->add('descricao', TextType::class, [
            'label' => 'Descrição do Risco',
            'required' => true,
        ]);

        $builder->add('valor', 'currency', [
            'label' => 'Valor Risco Fiscal',
            'required' => true,
        ]);

        $builder->add('codIdentificador', 'prestacao_contas_stn_identificador_risco_fiscal', [
            'label' => 'Identificador do Risco Fiscal',
            'required' => false,
        ]);
    }
}