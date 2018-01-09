<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM;

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\FormMapper;

use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Compras;

use Urbem\CoreBundle\Model\Empenho\ItemPreEmpenhoModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemMarcaModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\EstoqueMaterialModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\LancamentoOrdemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\LancamentoPerecivelModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\PerecivelModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\OrdemItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\OrdemModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class LancamentoMaterialAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado
 */
class LancamentoMaterialAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_lancamento_material';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/lancamento-material';

    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoExcluir = false;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create']);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $ordemObjectId = null;
        $catalogoItemObjectId = null;
        $naturezaLancamentoObjectId = null;

        if (false == $this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $ordemObjectId = $formData['ordem'];
            $catalogoItemObjectId = $formData['item'];
            $naturezaLancamentoObjectId = $formData['lancamento'];
        } elseif (false == is_null($this->request->get('item')) && false == is_null($this->request->get('ordem'))) {
            $ordemObjectId = $this->request->get('ordem');
            $catalogoItemObjectId = $this->request->get('item');
            $naturezaLancamentoObjectId = $this->request->get('lancamento');
        }

        /** @var Compras\Ordem $ordem */
        $ordem = $this->modelManager->find(Compras\Ordem::class, $ordemObjectId);

        /** @var Almoxarifado\CatalogoItem $catalogoItem */
        $catalogoItem = $this->modelManager->find(Almoxarifado\CatalogoItem::class, $catalogoItemObjectId);

        $fieldOptions['codItem']['data'] = $catalogoItem->getCodItem();
        $fieldOptions['valorUnit']['data'] = false;

        $fieldOptions['codAlmoxarifado'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Almoxarifado\Almoxarifado::class,
            'label' => 'label.almoxarifado.modulo'
        ];

        $fieldOptions['codCentro'] = [
            'class' => Almoxarifado\CentroCusto::class,
            'attr' => ['class' => 'select2-parameters '],
            'label' => 'label.almoxarifado.codCentro',
            'required' => true
        ];

        $fieldOptions['codMarca'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Almoxarifado\Marca::class,
            'label' => 'label.almoxarifado.marca',
            'mapped' => false,
            'multiple' => false,
            'route' => ['name' => 'urbem_patrimonial_almoxarifado_marca_autocomplete']
        ];

        $fieldOptions['complemento'] = [
            'label' => 'label.complemento',
            'required' => false
        ];

        $fieldOptions['quantidade'] = [
            'attr' => ['class' => 'quantity '],
            'label' => 'label.patrimonial.almoxarifado.implantacao.quantidade',
        ];

        $fieldOptions['valorUnit'] = [
            'attr' => [
                'class' => 'money ',
                'readonly' => true
            ],
            'label' => 'label.itens.valorUnitario',
            'mapped' => false
        ];

        $fieldOptions['lancamento'] = [
            'data' => $naturezaLancamentoObjectId,
            'mapped' => false,
        ];

        $fieldOptions['ordem'] = [
            'data' => $ordemObjectId,
            'mapped' => false,
        ];

        $fieldOptions['item'] = [
            'data' => $catalogoItemObjectId,
            'mapped' => false,
        ];

        $ordemModel = new OrdemModel($entityManager);
        $item = $ordemModel->getItemEntrada($ordem, $catalogoItem);

        $fieldOptions['valorUnit']['data'] = number_format($item->vl_empenhado, 2);
        $fieldOptions['quantidade']['data'] = number_format($item->qtde_disponivel_oc, 4);

        $wLabel = $this->trans('label.saidaEstorno.detalhe', ['%tem%' => $item->nom_item]);

        $formMapper
            ->with($wLabel)
                ->add('codAlmoxarifado', 'entity', $fieldOptions['codAlmoxarifado'])
                ->add('codCentro', 'entity', $fieldOptions['codCentro'])
                ->add('codMarca', 'autocomplete', $fieldOptions['codMarca'])
                ->add('quantidade', 'text', $fieldOptions['quantidade'])
                ->add('valorUnit', 'text', $fieldOptions['valorUnit'])
                ->add('complemento', 'textarea', $fieldOptions['complemento'])

                ->add('lancamento', 'hidden', $fieldOptions['lancamento'])
                ->add('ordem', 'hidden', $fieldOptions['ordem'])
                ->add('item', 'hidden', $fieldOptions['item'])
            ->end()
        ;

        if ('pericivel' == $catalogoItem->getFkAlmoxarifadoTipoItem()->getAlias()) {
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
                ->with('label.saidaEstorno.itemPerecível')
                    ->add('lote', 'number', $fieldOptions['lote'])
                    ->add('dtFabricacao', 'sonata_type_date_picker', $fieldOptions['dtFabricacao'])
                    ->add('dtValidade', 'sonata_type_date_picker', $fieldOptions['dtValidade'])
                ->end();
        }
    }

    /**
     * @param Almoxarifado\LancamentoMaterial $lancamentoMaterial
     */
    public function prePersist($lancamentoMaterial)
    {
        $form = $this->getForm();
        $catalogoItemObjectId = $form->get('item')->getData();
        $naturezaLancamentoObjectId = $form->get('lancamento')->getData();

        /** @var ORM\EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        /** @var Almoxarifado\CatalogoItem $catalogoItem */
        $catalogoItem = $this->modelManager->find(Almoxarifado\CatalogoItem::class, $catalogoItemObjectId);

        /** @var Almoxarifado\NaturezaLancamento $naturezaLancamento */
        $naturezaLancamento =
            $this->modelManager->find(Almoxarifado\NaturezaLancamento::class, $naturezaLancamentoObjectId);

        /** @var Almoxarifado\Marca $marca */
        $marca = $form->get('codMarca')->getData();

        /** @var Almoxarifado\CentroCusto $centro */
        $centro = $form->get('codCentro')->getData();

        /** @var Almoxarifado\Almoxarifado $almoxarifado */
        $almoxarifado = $form->get('codAlmoxarifado')->getData();

        /*
         * Verifica se ha um cadastro em almoxarifado.catalogo_item_marca,
         * se nao o codigo abaixo efetua o cadastro
         */
        $catalogoItemMarcaModel = new CatalogoItemMarcaModel($entityManager);
        $catalogoItemMarcaModel->findOrCreateCatalogoItemMarca($catalogoItem->getCodItem(), $marca->getCodMarca());

        /*
         * Verifica se ha um cadastro em almoxarifado.estoque_material,
         * se nao o codigo abaixo efetua o cadastro
         */
        $estoqueMaterialModel = new EstoqueMaterialModel($entityManager);
        $estoqueMaterial = $estoqueMaterialModel->findOrCreateEstoqueMaterial(
            $catalogoItem->getCodItem(),
            $marca->getCodMarca(),
            $centro->getCodCentro(),
            $almoxarifado->getCodAlmoxarifado()
        );

        $lancamentoMaterial->setFkAlmoxarifadoNaturezaLancamento($naturezaLancamento);
        $lancamentoMaterial->setFkAlmoxarifadoEstoqueMaterial($estoqueMaterial);
        $lancamentoMaterial->setFkAlmoxarifadoCatalogoItem($catalogoItem);

        $lancamentoMaterial->setValorMercado($form->get('valorUnit')->getData());
    }

    /**
     * @param Almoxarifado\LancamentoMaterial $lancamentoMaterial
     */
    public function postPersist($lancamentoMaterial)
    {
        $form = $this->getForm();
        $catalogoItemObjectId = $form->get('item')->getData();
        $ordemObjectId = $form->get('ordem')->getData();

        /** @var ORM\EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        /** @var Almoxarifado\CatalogoItem $catalogoItem */
        $catalogoItem = $this->modelManager->find(Almoxarifado\CatalogoItem::class, $catalogoItemObjectId);

        /** @var Almoxarifado\CentroCusto $centro */
        $centroCusto = $form->get('codCentro')->getData();

        /** @var Almoxarifado\Marca $marca */
        $marca = $form->get('codMarca')->getData();

        /** @var Compras\Ordem $ordem */
        $ordem = $this->modelManager->find(Compras\Ordem::class, $ordemObjectId);

        $alias = $catalogoItem->getFkAlmoxarifadoTipoItem()->getAlias();

        if ('perecivel' == $alias) {
            $perecivelModel = new PerecivelModel($entityManager);
            $perecivel = $perecivelModel->findOrCreatePerecivel(
                $lancamentoMaterial->getFkAlmoxarifadoEstoqueMaterial(),
                $form->get('dtFabricacao'),
                $form->get('dtValidade'),
                $form->get('lote')
            );

            $lancamentoPerecivel = new LancamentoPerecivelModel($entityManager);
            $lancamentoPerecivel->findOrCreateLancamentoPerecivel($lancamentoMaterial, $perecivel);
        }

        if ('patrimonio' == $alias) {
            // TODO Regra para itens de patrimonio
        }

        $catalogoItemMarcaModel = new CatalogoItemMarcaModel($entityManager);
        $catalogoItemMarca =
            $catalogoItemMarcaModel->findOrCreateCatalogoItemMarca($catalogoItem->getCodItem(), $marca->getCodMarca());

        $preEmpenho = $ordem->getFkEmpenhoEmpenho()->getFkEmpenhoPreEmpenho();

        $itemPreEmpenhoModel = new ItemPreEmpenhoModel($entityManager);
        $itemPreEmpenho = $itemPreEmpenhoModel->findByPreEmpenhoAndItemDescricao($preEmpenho, $catalogoItem);

        $itemPreEmpenhoModel->checkAndUpdateItemPreEmpenhoWithCatalogoItem($itemPreEmpenho, $catalogoItem);
        $itemPreEmpenhoModel->checkAndUpdateItemPreEmpenhoWithCentroCusto($itemPreEmpenho, $centroCusto);
        $itemPreEmpenhoModel->checkAndUpdateItemPreEmpenhoWithMarca($itemPreEmpenho, $marca);

        $ordemItemModel = new OrdemItemModel($entityManager);
        $ordemItem = $ordemItemModel->findByOrdemAndItemPreEmpenho($ordem, $itemPreEmpenho);

        $ordemItemModel->checkAndUpdateItemPreEmpenhoWithCatalogoItemMarca($ordemItem, $catalogoItemMarca);
        $ordemItemModel->checkAndUpdateItemPreEmpenhoWithCentroCusto($ordemItem, $centroCusto);

        $lancamentoOrdemModel = new LancamentoOrdemModel($entityManager);
        $lancamentoOrdem = $lancamentoOrdemModel->findOrCreateLancamentoOrdem($lancamentoMaterial, $ordemItem);
    }
}
