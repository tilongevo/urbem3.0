<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\OrdemModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class EntradaComprasOrdemItemAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Compras
 */
class EntradaComprasOrdemItemAdmin extends AbstractAdmin
{
    const COD_MODULO = 6;

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        /** @var Compras\OrdemItem $ordemItem */
        $ordemItem = $this->getSubject();
        $ordem = $ordemItem->getFkComprasOrdem();
        $itemPreEmpenho = $ordemItem->getFkEmpenhoItemPreEmpenho();

        $catalagoItemModel = new CatalogoItemModel($em);
        $ordemModel = new OrdemModel($em);

        $catalogoItem = $catalagoItemModel->findCatalogoItemByOrdemItem($ordemItem);
        $item = $em->getRepository(Almoxarifado\CatalogoItem::class)->findOneBy(['codItem' => $ordemItem->getCodItem()]);

        $codItem = '';
        $descricaoItem = '';
        if ($item) {
            $codItem = $item->getCodItem();
            $descricaoItem = $item->getDescricaoFoto();
        }

        $ordemItemInfo = $ordemModel->getItemEntrada($ordem, $catalogoItem);
        $ordemItemInfo ? $codCentroCusto = $ordemItemInfo->cod_centro : $codCentroCusto = null;
        $centroCusto = $this->modelManager->find(Almoxarifado\CentroCusto::class, $codCentroCusto);

        $fieldOptions['incluir'] = [
            'attr' => ['class' => 'checkbox-sonata'],
            'label_attr' => ['class' => 'checkbox-sonata'],
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['codAlmoxarifado'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Almoxarifado\Almoxarifado::class,
            'label' => 'label.almoxarifado.modulo',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['codCentro'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Almoxarifado\CentroCusto::class,
            'data' => $centroCusto,
            'route' => ['name' => 'urbem_patrimonial_almoxarifado_centro_custo_autocomplete'],
            'label' => 'label.almoxarifado.codCentro',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['codMarca'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Almoxarifado\Marca::class,
            'route' => ['name' => 'urbem_patrimonial_almoxarifado_marca_autocomplete'],
            'label' => 'label.almoxarifado.marca',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['quantidade'] = [
            'attr' => ['class' => 'quantity '],
            'data' => $ordemItemInfo->qtde_disponivel_oc,
            'label' => 'label.patrimonial.almoxarifado.implantacao.quantidade',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['valorUnitario'] = [
            'attr' => [
                'class' => 'money ',
                'readonly' => true
            ],
            'data' => number_format($ordemItemInfo->vl_empenhado, 2),
            'label' => 'label.itens.valorUnitario',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['complemento'] = [
            'label' => 'label.complemento',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['foto'] = [
            'label' => 'label.usuario.foto',
            'mapped' => false,
            'required' => false,
            'attr' => ['value' => $codItem.'~'.$descricaoItem]
        ];

        if ($ordemItemInfo->qtde_disponivel_oc <= 0) {
            foreach ($fieldOptions as $key => $value) {
                $fieldOptions[$key]['disabled'] = true;
            }
        }

        $this->label = strtoupper($itemPreEmpenho->getNomItem());

        $formMapper
            ->add('incluir', 'checkbox', $fieldOptions['incluir'])
            ->add('codAlmoxarifado', 'entity', $fieldOptions['codAlmoxarifado'])
            ->add('codCentro', 'autocomplete', $fieldOptions['codCentro'])
            ->add('codMarca', 'autocomplete', $fieldOptions['codMarca'])
            ->add('quantidade', 'text', $fieldOptions['quantidade'])
            ->add('valorUnitario', 'text', $fieldOptions['valorUnitario'])
            ->add('complemento', 'textarea', $fieldOptions['complemento'])
            ->add('foto', 'file', $fieldOptions['foto'])
        ;

        $alias = $catalogoItem->getFkAlmoxarifadoTipoItem() ? $catalogoItem->getFkAlmoxarifadoTipoItem()->getAlias() : null;

        if ('perecivel' == $alias) {
            $fieldOptions['lote'] = [
                'attr' => ['readonly' => 'readonly '],
                'label' => 'label.patrimonial.almoxarifado.implantacao.lote',
                'mapped' => false,
            ];

            $fieldOptions['dtFabricacao'] = [
                'attr' => ['readonly' => 'readonly '],
                'label' => 'label.patrimonial.almoxarifado.implantacao.dtFabricacao',
                'mapped' => false,
            ];

            $fieldOptions['dtValidade'] = [
                'attr' => ['readonly' => 'readonly '],
                'label' => 'label.patrimonial.almoxarifado.implantacao.dtValidade',
                'mapped' => false,
            ];

            $formMapper
                ->add('lote', 'number', $fieldOptions['lote'])
                ->add('dtFabricacao', 'sonata_type_date_picker', $fieldOptions['dtFabricacao'])
                ->add('dtValidade', 'sonata_type_date_picker', $fieldOptions['dtValidade'])
            ;
        }

        if ('patrimonio' == $alias) {
            $fieldOptions['placaIdentificacao'] = [
                'attr' => ['class' => 'checkbox-sonata placa-identificacao '],
                'choices'  => [
                    'sim' => true,
                    'nao' => false,
                ],
                'data' => true,
                'expanded' => true,
                'label' => 'label.bem.identificacao',
                'label_attr' => ['class' => 'checkbox-sonata '],
                'mapped' => false
            ];

            $fieldOptions['numeroPlaca'] = [
                'label' => 'label.bem.numPlaca',
                'required' => false,
                'mapped' => false,
            ];

            $configuracaoModel = new ConfiguracaoModel($em);
            $configuracaoPlacaAlfaNumerica =
               (int) $configuracaoModel->pegaConfiguracao('placa_alfanumerica', self::COD_MODULO, $this->getExercicio(), true);
            
            $fieldOptions['numeroPlaca']['attr']['class'] =
                $configuracaoPlacaAlfaNumerica ? 'only-alpha ' : 'only-number ';

            $formMapper
                ->add('placaIdentificacao', 'choice', $fieldOptions['placaIdentificacao'])
                ->add('numeroPlaca', 'text', $fieldOptions['numeroPlaca'])
            ;
        }

        // TODO Adicionar attr dinamicos
    }
}
