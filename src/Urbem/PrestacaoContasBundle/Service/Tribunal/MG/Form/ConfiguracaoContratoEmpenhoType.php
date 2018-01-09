<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Empenho\Empenho;
use Urbem\CoreBundle\Entity\Tcemg\ContratoEmpenho;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;

class ConfiguracaoContratoEmpenhoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterContrato.php:316 */
        $builder->add('fkEmpenhoEmpenho', AutoCompleteType::class, [
            'label' => 'Empenho',
            'class' => Empenho::class,
            'route' => [
                'name' => AutoCompleteType::ROUTE_AUTOCOMPLETE_DEFAULT,
                'parameters' => [
                    'json_from_admin_field' => 'autocomplete_empenho_complementar_field', // EmpenhoAdmin
                    'cascade_exercicio' => $options['exercicio'],
                ],
            ],
            'cascade_fields' => [
                [
                    'search_column' => 'entidade',
                    'from_field' => 'configuracao_contrato_fkOrcamentoEntidade',
                ],
            ],
            'json_from_admin_code' => 'core.admin.filter.empenho_empenho',
            'minimum_input_length' => 1,
            'attr' => ['class' => 'select2-parameters'],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', ContratoEmpenho::class);
        $resolver->setRequired(['exercicio']);
    }
}