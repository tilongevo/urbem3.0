<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form\RegistroPrecos;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosLicitacao;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;
use Urbem\PrestacaoContasBundle\Form\Type\ModalidadeType;

class RegistroPrecosLicitacaoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPreco.php:590 */
        $builder->add('exercicioLicitacao', TextType::class, [
            'label' => 'Exercício',
            'required' => true,
            'constraints' => [new NotNull(), new Length(4)]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPreco.php:600 */
        $builder->add('fkComprasModalidade', ModalidadeType::class, [
            /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPreco.php:585 */
            'field_in' => [
                [
                    'column' => 'codModalidade',
                    'value' => [3, 6, 7]
                ]
            ],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPreco.php:661 */
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterRegistroPreco.php:2148 */
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterRegistroPreco.php:109 */
        $builder->add('fkLicitacaoLicitacao', AutoCompleteType::class, [
            'label' => 'Licitação',
            'class' => Licitacao::class,
            'minimum_input_length' => 1,
            'route' => [
                'name' => AutoCompleteType::ROUTE_AUTOCOMPLETE_DEFAULT,
                'parameters' => [
                    'json_from_admin_field' => 'autocomplete_field', // LicitacaoAdmin
                ]
            ],
            'cascade_fields' => [
                [
                    'search_column' => 'exercicio',
                    'from_field' => 'registro_precos_fkTcemgRegistroPrecosLicitacoes_0_exercicioLicitacao',
                ],
                [
                    'search_column' => 'entidade',
                    'from_field' => 'registro_precos_fkOrcamentoEntidade',
                ],
                [
                    'search_column' => 'modalidade',
                    'from_field' => 'registro_precos_fkTcemgRegistroPrecosLicitacoes_0_fkComprasModalidade',
                ],
            ],
            'json_from_admin_code' => 'core.admin.filter.licitacao_licitacao',
            'attr' => ['class' => 'select2-parameters '],
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', RegistroPrecosLicitacao::class);
    }
}