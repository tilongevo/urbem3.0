<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;

class ConfiguracaoRecDescExtraType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterExt.php:74
        $builder->add('inCategoria', ChoiceType::class, [
            'label' => 'Categoria',
            'attr' => ['class' => 'select2-parameters '],
            'placeholder' => 'Selecione',
            'choices' => [
                'Receita' => 0,
                'Despesa' => 1,
            ],
            'constraints' => [new NotNull()]
        ]);

        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterExt.php:85
        $builder->add('inTipoLancamento', ChoiceType::class, [
            'label' => 'Tipo do Lançamento',
            'attr' => ['class' => 'select2-parameters '],
            'placeholder' => 'Selecione',
            'choices' => self::getTiposLancamentos(),
            'constraints' => [new NotNull()]
        ]);

        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterExt.php:288
        $addSubTipo = function(FormEvent $event){
            $form = $event->getForm();
            $data = $event->getData();

            $inTipoLancamento = true === empty($data['inTipoLancamento']) ? null : $data['inTipoLancamento'];

            $form->add('inSubTipo', ChoiceType::class, [
                'label' => 'Subtipo',
                'attr' => ['class' => 'select2-parameters '],
                'placeholder' => 'Selecione',
                'choices' => self::getSubTipos($inTipoLancamento),
                'required' => false,
            ]);
        };

        // Dados Iniciais
        $builder->addEventListener(FormEvents::PRE_SET_DATA, $addSubTipo);

        // Dados vindos do form
        $builder->addEventListener(FormEvents::PRE_SUBMIT, $addSubTipo);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
            $form = $event->getForm();

            // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterExt.php:103
            $form->add('inCodConta', AutoCompleteType::class, [
                'label' => 'Conta',
                'json_from_admin_code' => 'core.admin.filter.contabilidade_plano_conta',
                'attr' => ['class' => 'select2-parameters '],
                'route' => [
                    'name' => AutoCompleteType::ROUTE_AUTOCOMPLETE_DEFAULT,
                    'parameters' => [
                        'json_from_admin_field' => 'mg_conta_analitica_estrutural_extmmaa',

                    ]
                ],
                'required' => true,
                'constraints' => [new NotNull()]
            ]);
        });
    }

    public static function getTiposLancamentos()
    {
        return [
            'Depósitos e Consignações' => 1,
            'Débitos de Tesouraria' => 2,
            'Ativo Realizável' => 3,
            'Transferências Financeiras' => 4,
            'Outros' => 99
        ];
    }

    public static function getSubTipos($inTipoLancamento)
    {
        $inTipoLancamento = (int) $inTipoLancamento;

        if (true === empty($inTipoLancamento)) {
            return [];
        }

        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterExt.php:290
        $choices[1] = [
            'INSS' => 1,
            'RPPS' => 2,
            'IRRF' => 3,
            'ISSQN' => 4,
            'Outro' => 999,
        ];

        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterExt.php:309
        $choices[2] = [
            'ARO' => 1,
        ];

        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterExt.php:324
        $choices[3] = [
            'Salário família' => 1,
            'Salário maternidade' => 2,
            'Outros benefícios com mais de um favorecido' => 3,
            'Outro' => 999,
        ];

        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterExt.php:342
        $choices[4] = [
            'Repasse à Câmara' => 1,
            'Devolução de numerário para a prefeitura' => 2,
            'Aporte de Recursos para Cobertura de Insuficiência Financeira para o RPPS' => 3,
            'Aporte de Recursos para Formação de Reserva Financeira para o RPPS' => 4,
            'Outros Aportes Financeiros para o RPPS' => 5,
            'Aporte de Recursos para Cobertura de Déficit Financeiro para o RPPS' => 6,
            'Aporte de Recursos para Cobertura ou Amortização de Déficit Atuarial para o RPPS' => 7,
            'Outros Aportes Previdenciários para o RPPS' => 8,
            'Outro' => 999,
        ];

        return true === empty($choices[$inTipoLancamento]) ? [] : $choices[$inTipoLancamento];
    }
}