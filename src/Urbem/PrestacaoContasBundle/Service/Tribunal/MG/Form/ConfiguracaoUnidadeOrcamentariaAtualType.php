<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Orcamento\Unidade;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\Tcemg\Uniorcam;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;

class ConfiguracaoUnidadeOrcamentariaAtualType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoUnidadeOrcamentaria.php:115 */
        $builder->add('fkOrcamentoOrgao', TextType::class, [
            'label' => 'Orgão',
            'attr' => [
                'readonly' => true,
            ],
            'disabled' => true
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoUnidadeOrcamentaria.php:120 */
        $builder->add('fkOrcamentoUnidade', TextType::class, [
            'label' => 'Unidade',
            'attr' => [
                'readonly' => true,
            ],
            'disabled' => true
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoUnidadeOrcamentaria.php:140 */
        $builder->add('identificador', ChoiceType::class, [
            'label' => 'Identificador',
            'placeholder' => 'Selecione',
            'attr' => ['class' => 'select2-parameters select2-unidade-orcamentarial-atual '],
            'choices' => [
                /* @see gestaoFinanceira/fontes/PHP/exportacao/classes/negocio/RExportacaoTCEMGArqUniOrcam.class.php:96 */
                'FUNDEB' => 1,
                'FMS - Fundo Municipal de Saúde' => 2,
                'Controle FMAS - Fundo Municipal de Assitência Social' => 3,
                'FMCA - Fundo Municipal da Criança e do Adolescente' => 4,
                'Outros Fundos' => 99
            ],
            'required' => false,
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoUnidadeOrcamentaria.php:158 */
        $builder->add('fkSwCgm', AutoCompleteType::class, [
            'label' => 'Ordenador de Despesa',
            'class' => SwCgm::class,
            'json_from_admin_code' => 'core.admin.filter.sw_cgm',
            'attr' => ['class' => 'select2-parameters select2-unidade-orcamentarial-atual '],
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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', Uniorcam::class);
    }
}