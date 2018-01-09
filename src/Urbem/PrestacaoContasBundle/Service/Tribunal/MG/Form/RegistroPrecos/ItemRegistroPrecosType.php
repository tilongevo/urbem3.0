<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form\RegistroPrecos;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;
use Urbem\CoreBundle\Form\Type\CurrencyType;
use Urbem\CoreBundle\Form\Type\PercentType;
use Urbem\PrestacaoContasBundle\Form\Type\DatePickerType;
use Urbem\PrestacaoContasBundle\Form\Type\SwCgmType;

class ItemRegistroPrecosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPrecoItem.php:52 */
        $builder->add('numItem', TextType::class, [
            'label' => 'Número do Item no Lote',
            'constraints' => [new Length(['min' => 1])]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPrecoItem.php:84 */
        $builder->add('precoUnitario', CurrencyType::class, [
            'label' => 'Preço Unitário',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPrecoItem.php:78 */
        $builder->add('dataCotacao', DatePickerType::class, [
            'label' => 'Data da Cotação',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPrecoItem.php:66 */
        /* gestaoAdministrativa/fontes/PHP/framework/componentes/HTML/IMontaQuantidadeValores.class.php:73 */
        $builder->add('vlCotacaoPrecoUnitario', CurrencyType::class, [
            'label' => 'Valor da Cotação Unitária',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPrecoItem.php:66 */
        /* gestaoAdministrativa/fontes/PHP/framework/componentes/HTML/IMontaQuantidadeValores.class.php:76 */
        $builder->add('quantidadeCotacao', TextType::class, [
            'label' => 'Quantidade',
            'required' => true,
            'constraints' => [new Length(['min' => 1])]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPrecoItem.php:93 */
        $builder->add('quantidadeLicitada', TextType::class, [
            'label' => 'Quantidade Licitada',
            'required' => true,
            'constraints' => [new NotNull(), new Length(['min' => 1, 'max' => 23])]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPrecoItem.php:93 */
        $builder->add('quantidadeAderida', TextType::class, [
            'label' => 'Quantidade Aderida',
            'required' => true,
            'constraints' => [new NotNull(), new Length(['min' => 1, 'max' => 23])]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPrecoItem.php:177 */
        $builder->add('percentualDesconto', PercentType::class, [
            'label' => 'Percentual por Lote',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPrecoItem.php:139 */
        $builder->add('ordemClassificacaoFornecedor', TextType::class, [
            'label' => 'Ordem de Classificação do Fornecedor',
            'required' => true,
            'constraints' => [new NotNull(), new Length(['min' => 1, 'max' => 2])]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPrecoItem.php:128 */
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterRegistroPreco.php:417 */
        $builder->add('fkAlmoxarifadoCatalogoItem', AutoCompleteType::class, [
            'class' => CatalogoItem::class,
            'label' => 'Item',
            'json_from_admin_code' => 'core.admin.filter.almoxarifado_catalogo_item',
            'minimum_input_length' => 1,
            'route' => [
                'name' => AutoCompleteType::ROUTE_AUTOCOMPLETE_DEFAULT,
                'parameters' => [
                    'json_from_admin_field' => 'autocomplete_field' // LicitacaoAdmin autocomplete_field field
                ]
            ],
            'attr' => ['class' => 'select2-parameters update-registro-orgao ItemRegistroPrecosType_fkAlmoxarifadoCatalogoItem '],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPrecoItem.php:128 */
        $builder->add('fkSwCgm', SwCgmType::class, [
            'label' => 'CGM Vencedor do Registro de Preço',
            'required' => true,
            'attr' => ['class' => 'select2-parameters update-registro-orgao ItemRegistroPrecosType_fkSwCgm '],
            'constraints' => [new NotNull()]
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', ItemRegistroPrecos::class);
        $resolver->setRequired('registroPrecos');
    }
}