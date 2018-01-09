<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Sonata\CoreBundle\Form\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Empenho\Empenho;
use Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao;
use Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenhoLiquidacao;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;
use Urbem\CoreBundle\Form\Type\CurrencyType;
use Urbem\CoreBundle\Repository\Empenho\NotaLiquidacaoRepository;

class ConfiguracaoNotaFiscalEmpenhoLiquidacaoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterNotasFiscais.php:213 */
        $builder->add('fkEmpenhoEmpenho', AutoCompleteType::class, [
            'label' => 'Número do Empenho',
            'class' => Empenho::class,
            'route' => [
                'name' => AutoCompleteType::ROUTE_AUTOCOMPLETE_DEFAULT,
                'parameters' => [
                    'json_from_admin_field' => 'autocomplete_nota_fiscal_empenho_field' // EmpenhoAdmin
                ]
            ],
            'json_from_admin_code' => 'core.admin.filter.empenho_empenho',
            'attr' => ['class' => 'select2-parameters select-empenho'],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);


        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterExt.php:225
        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterNotasFiscais.php:486
        $addSubTipo = function(FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();

            if (true === is_array($data)) {
                $fkEmpenhoEmpenho = true === empty($data['fkEmpenhoEmpenho']) ? null : $data['fkEmpenhoEmpenho'];

            } else {
                $fkEmpenhoEmpenho = true === empty($data) ? null : $data->getFkEmpenhoEmpenho();
            }

            $form->add('fkEmpenhoNotaLiquidacao', EntityType::class, [
                'class' => NotaLiquidacao::class,
                'query_builder' => function (NotaLiquidacaoRepository $repository) use ($fkEmpenhoEmpenho) {
                    return $repository->getByEmpenhoFromMGAsQueryBuilder($fkEmpenhoEmpenho);
                },
                'label' => 'Liquidação',
                'attr' => [
                    'class' => 'select2-parameters select-liquidacao',
                ],
                'placeholder' => 'Selecione',
            ]);
        };

        // Dados Iniciais
        $builder->addEventListener(FormEvents::PRE_SET_DATA, $addSubTipo);

        // Dados vindos do form
        $builder->addEventListener(FormEvents::PRE_SUBMIT, $addSubTipo);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterNotasFiscais.php:116 */
        $builder->add('vlLiquidacao', CurrencyType::class, [
            'label' => 'Valor Total Liquidação',
            'data' => '0.00',
            'attr' => ['disabled' => 'disabled']
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterNotasFiscais.php:116 */
        $builder->add('vlAssociado', CurrencyType::class, [
            'label' => 'Valor Associado',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', NotaFiscalEmpenhoLiquidacao::class);
    }
}