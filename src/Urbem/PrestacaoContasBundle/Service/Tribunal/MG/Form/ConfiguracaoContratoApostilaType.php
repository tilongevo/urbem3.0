<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Tcemg\ContratoApostila;
use Urbem\CoreBundle\Form\Type\CurrencyType;
use Urbem\PrestacaoContasBundle\Form\Type\DatePickerType;
use Urbem\PrestacaoContasBundle\Form\Type\Tcemg\ContratoType;

class ConfiguracaoContratoApostilaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fkTcemgContrato', ContratoType::class, [
            'attr' => ['class' => 'contrato'],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterApostilaContrato.ph:228 */
        $builder->add('codTipo', ChoiceType::class, [
            'label' => 'Tipo de Apostila',
            'placeholder' => 'Selecione',
            'choices' => [
                'Reajuste de preço previsto no contrato' => 1,
                'Atualizações, compensações ou penalizações financeiras decorrentes das condições de pagamento previstas no contrato' => 2,
                'Empenho de dotações orçamentárias suplementares até o limite do seu valor corrigido' => 3

            ],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterApostilaContrato.ph:260 */
        $builder->add('codAlteracao', ChoiceType::class, [
            'label' => 'Tipo de Alteração da Apostila',
            'placeholder' => 'Selecione',
            'choices' => [
                'Acréscimo de valor' => 1,
                'Decréscimo de valor' => 2,
                'Não houve alteração de valor' => 3

            ],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterApostilaContrato.ph:260 */
        $builder->add('descricao', TextareaType::class, [
            'label' => 'Descrição da Apostila',
            'required' => true,
            'constraints' => [new NotNull(), new Length(['min' => 0, 'max' => 250])]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterApostilaContrato.ph:241 */
        $builder->add('dataApostila', DatePickerType::class, [
            'label' => 'Data da Apostila',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterApostilaContrato.ph:284 */
        $builder->add('valorApostila', CurrencyType::class, [
            'label' => 'Valor da Apostila',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', ContratoApostila::class);
        $resolver->setDefault('show_error', true);
    }
}