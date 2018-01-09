<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM\EntityManager;

use Sonata\AdminBundle\Form\FormMapper;

use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Entity\Almoxarifado\Marca;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class EntradaDiversosItemAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado
 */
class EntradaDiversosItemAdmin extends AbstractAdmin
{
    const COD_MODULO = 6;

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $fieldOptions = [];
        $fieldOptions['item'] = [
            'attr' => ['class' => 'select2-parameters catalogo-item-field '],
            'class' => CatalogoItem::class,
            'label' => 'label.almoxarifado.item',
            'mapped' => false,
            'route' => ['name' => 'urbem_patrimonial_almoxarifado_catalogo_item_autocomplete_ex_servicos']
//            'data' => (!is_null($this->getSubject()) ? $this->getSubject()->getItem() : '')
        ];

        $fieldOptions['marca'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Marca::class,
            'label' => 'label.almoxarifado.marca',
            'mapped' => false,
            'route' => ['name' => 'urbem_patrimonial_almoxarifado_marca_autocomplete']
        ];

        $fieldOptions['codigoBarras'] = [
            'attr' => ['class' => 'only-number '],
            'required' => false,
            'label' => 'label.entradaDiversos.codigoBarras',
            'mapped' => false
        ];

        $fieldOptions['centro'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => CentroCusto::class,
            'label' => 'label.almoxarifado.codCentro',
            'mapped' => false,
            'route' => ['name' => 'urbem_patrimonial_almoxarifado_centro_custo_autocomplete'],
        ];
        $fieldOptions['quantidade'] = [
            'attr' => ['class' => 'quantity '],
            'label' => 'label.entradaDiversos.quantidade'
        ];

        $fieldOptions['valorMercado'] = [
            'attr' => ['class' => 'money '],
            'currency' => 'R$',
            'label' => 'label.entradaDiversos.valorMercado'
        ];

        $formMapper
            ->add('item', 'autocomplete', $fieldOptions['item'])
            ->add('marca', 'autocomplete', $fieldOptions['marca'])
            ->add('codigoBarras', 'text', $fieldOptions['codigoBarras'])
            ->add('centro', 'autocomplete', $fieldOptions['centro'])
            ->add('quantidade', 'number', $fieldOptions['quantidade'])
            ->add('valorMercado', 'money', $fieldOptions['valorMercado']);

        // Campos de Item de Patrimonio
        $fieldOptions['placaIdentificacao'] = [
            'attr' => [
                'class' => 'checkbox-sonata placa-identificacao ',
                'data-show' => 'when-patrimonio'
            ],
            'choices' => [
                'sim' => true,
                'nao' => false,
            ],
            'data' => true,
            'expanded' => true,
            'label' => 'label.bem.identificacao',
            'label_attr' => ['class' => 'checkbox-sonata '],
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['numeroPlaca'] = [
            'attr' => ['data-show' => 'when-patrimonio'],
            'label' => 'label.bem.numPlaca',
            'required' => false,
            'mapped' => false,
        ];

        $configuracaoModel = new ConfiguracaoModel($em);
        $configuracaoPlacaAlfaNumerica = (int) $configuracaoModel
            ->pegaConfiguracao('placa_alfanumerica', self::COD_MODULO, $this->getExercicio(), true);

        $fieldOptions['numeroPlaca']['attr']['class'] =
            $configuracaoPlacaAlfaNumerica ? 'only-alpha ' : 'only-number ';

        $formMapper
            ->add('placaIdentificacao', 'choice', $fieldOptions['placaIdentificacao'])
            ->add('numeroPlaca', 'text', $fieldOptions['numeroPlaca']);

        // Campos de Item Perecivel
        $fieldOptions['lote'] = [
            'attr' => [
                'readonly' => 'readonly only-number ',
                'data-show' => 'when-perecivel'
            ],
            'label' => 'label.patrimonial.almoxarifado.implantacao.lote',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['dtFabricacao'] = [
            'attr' => [
                'readonly' => 'readonly ',
                'data-show' => 'when-perecivel'
            ],
            'label' => 'label.patrimonial.almoxarifado.implantacao.dtFabricacao',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['dtValidade'] = [
            'attr' => [
                'readonly' => 'readonly ',
                'data-show' => 'when-perecivel'
            ],
            'label' => 'label.patrimonial.almoxarifado.implantacao.dtValidade',
            'mapped' => false,
            'required' => false
        ];

        $formMapper
            ->add('lote', 'number', $fieldOptions['lote'])
            ->add('dtFabricacao', 'sonata_type_date_picker', $fieldOptions['dtFabricacao'])
            ->add('dtValidade', 'sonata_type_date_picker', $fieldOptions['dtValidade']);

        // Atributos Dinamicos
        $fieldOptions['atributosDinamicos'] = [
            'attr' => ['data-show' => 'when-atributo-dinamico'],
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['codModulo'] = [
            'data' => Modulo::MODULO_PATRIMONIAL_ALMOXARIFADO,
            'mapped' => false
        ];

        $fieldOptions['codCadastro'] = [
            'data' => Cadastro::CADASTRO_PATRIMONIAL_ALMOXARIFADO_ATRIBUTO_ESTOQUE_MATERIAL_VALOR,
            'mapped' => false
        ];

        $formMapper
            ->add('codModulo', 'hidden', $fieldOptions['codModulo'])
            ->add('codCadastro', 'hidden', $fieldOptions['codCadastro'])
            ->add('atributosDinamicos', 'text', $fieldOptions['atributosDinamicos']);
    }
}
