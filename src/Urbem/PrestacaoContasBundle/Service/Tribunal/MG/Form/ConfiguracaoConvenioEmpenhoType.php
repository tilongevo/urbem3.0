<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Empenho\Empenho;
use Urbem\CoreBundle\Entity\Tcemg\ConvenioEmpenho;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;

class ConfiguracaoConvenioEmpenhoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('exercicioEmpenho', TextType::class, [
            'label' => 'Exercício',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConvenio.php:186 */
        $builder->add('fkEmpenhoEmpenho', AutoCompleteType::class, [
            'label' => 'Empenho',
            'class' => Empenho::class,
            'route' => [
                'name' => AutoCompleteType::ROUTE_AUTOCOMPLETE_DEFAULT,
                'parameters' => [
                    'json_from_admin_field' => 'autocomplete_nota_fiscal_empenho_field' // EmpenhoAdmin
                ]
            ],
            'json_from_admin_code' => 'core.admin.filter.empenho_empenho',
            'cascade_fields' => [
                [
                    'search_column' => 'exercicio',
                    'from_field' => 'configuracao_convenio_fkTcemgConvenioEmpenhos___name___exercicioEmpenho',
                ],
                [
                    'search_column' => 'entidade',
                    'from_field' => 'configuracao_convenio_fkTcemgConvenioEmpenhos___name___fkEmpenhoEmpenho_autocomplete_input',
                ],
            ],
            'attr' => ['class' => 'select2-parameters select-empenho'],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', ConvenioEmpenho::class);
    }
}