<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoClassificacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemMarcaModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\EstoqueMaterialModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\InventarioItensModel;
use Urbem\CoreBundle\Model\Patrimonial\Frota\ItemModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class InventarioItensAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado
 */
class InventarioItensAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_inventario_item';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/inventario/item';

    protected $includeJs = [
        '/patrimonial/javascripts/almoxarifado/catalogo-classificacao-component.js',
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/patrimonial/javascripts/almoxarifado/inventario_item.js',
    ];

    /**
     * @return Almoxarifado\Inventario
     */
    final private function getInventario()
    {
        /**
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        $codAlmoxarifadoRouteKey = $this->getRequest()->get('cod_almoxarifado');

        $codAlmoxarifadoRouteKey = (isset($codAlmoxarifadoRouteKey) ? $codAlmoxarifadoRouteKey : $this->getAdminRequestId());

        if (is_null($codAlmoxarifadoRouteKey)) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $compositeKey[] = $formData['exercicio'];
            $compositeKey[] = $formData['codAlmoxarifado'];
            $compositeKey[] = $formData['codInventario'];
        } else {
            $compositeKey = explode("~", $codAlmoxarifadoRouteKey);
        }
        /**
         * @var Almoxarifado\Inventario $inventario
         */
        $inventario = $entityManager
            ->getRepository(Almoxarifado\Inventario::class)
            ->find([
                'exercicio' => $compositeKey[0],
                'codAlmoxarifado' => $compositeKey[1],
                'codInventario' => $compositeKey[2]
            ]);


        return $inventario;
    }

    /**
     * @param ErrorElement $errorElement
     * @param Almoxarifado\InventarioItens $inventarioItens
     */
    public function validate(ErrorElement $errorElement, $inventarioItens)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $inventarioItensModel = new InventarioItensModel($entityManager);

        $container = $this->getConfigurationPool()->getContainer();

        $formData = $this->getForm();

        /**
         * @var Almoxarifado\Inventario $inventario
         */
        $inventario = $entityManager
            ->getRepository(Almoxarifado\Inventario::class)
            ->find([
                'exercicio' => $formData->get('exercicio')->getData(),
                'codInventario' => $formData->get('codInventario')->getData(),
                'codAlmoxarifado' => $formData->get('codAlmoxarifado')->getData()
            ]);

        $inventarioItens->setFkAlmoxarifadoInventario($inventario);

        $inventarioItensAlreadySaved = $inventarioItensModel->checkIfExistsInventarioItens($inventarioItens);

        if (!is_null($inventarioItensAlreadySaved) && is_null($this->getAdminRequestId())) {
            $message = $this->trans('almoxarifado_inventario.errors.already_registered', [], 'validators');

            $container->get('session')
                ->getFlashBag()
                ->add('error', $message);

            (new RedirectResponse($this->request->headers->get('referer')))->send();
        }
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $edicao = false;
        $route = $this->getRequest()->get('_sonata_name');
        $inventario = !is_null($route) ? $this->getInventario() : null;

        $formMapperOptions = [];

        $formMapperOptions['codCatalogo'] = [
            'attr' => ['class' => 'select2-parameters '],
            'choice_label' => 'descricao',
            'choice_value' => 'codCatalogo',
            'class' => Almoxarifado\Catalogo::class,
            'label' => 'label.catalogoItem.codCatalogo',
            'mapped' => false,
            'placeholder' => 'label.selecione'
        ];

        $formMapperOptions['codClassificacao'] = [
            'attr' => ['class' => 'select2-parameters '],
            'label' => 'label.catalogoItem.codClassificacao',
            'placeholder' => 'Selecione o Catálogo',
            'multiple' => false,
            'mapped' => false,
            'route' => ['name' => 'urbem_patrimonial_almoxarifado_catalogo_classificacao_search'],
            'req_params' => [
                'codCatalogo' => 'varJsCodCatalogo'
            ]
        ];

        $formMapperOptions['codCatalogoItem'] = [
            'attr' => ['class' => 'select2-parameters '],
            'label' => 'label.almoxarifado.item',
            'multiple' => false,
            'class' => Almoxarifado\CatalogoItem::class,
            'mapped' => false,
            'route' => ['name' => 'urbem_patrimonial_almoxarifado_catalogo_item_autocomplete']
        ];

        $formMapperOptions['codMarca'] = [
            'attr' => ['class' => 'select2-parameters '],
            'label' => 'label.almoxarifado.marca',
            'multiple' => false,
            'class' => Almoxarifado\Marca::class,
            'mapped' => false,
            'route' => ['name' => 'urbem_patrimonial_almoxarifado_marca_autocomplete']
        ];

        $formMapperOptions['codCentro'] = [
            'class' => Almoxarifado\CentroCusto::class,
            'attr' => ['class' => 'select2-parameters '],
            'label' => 'label.inventario.itens.codCentro',
            'placeholder' => 'label.selecione',
            'mapped' => false
        ];

        $formMapperOptions['quantidade'] = [
            'attr' => ['class' => 'quantity ']
        ];

        $formMapperOptions['justificativa'] = [];

        $formMapperOptions['codInventario'] = [
            'data' => $inventario->getCodInventario(),
            'mapped' => false
        ];

        $formMapperOptions['codAlmoxarifado'] = [
            'data' => $inventario->getCodAlmoxarifado(),
            'mapped' => false
        ];

        $formMapperOptions['exercicio'] = [
            'data' => $inventario->getExercicio(),
            'mapped' => false
        ];

        $formMapperOptions['codEstrutural'] = [
            'mapped' => false,
            'required' => false,
        ];

        $formMapperOptions['atributosDinamicos'] = [
            'mapped' => false,
            'required' => false
        ];

        $formMapperOptions['codItem'] = [
            'mapped' => false,
            'required' => false,
        ];

        if ($route == "urbem_patrimonial_almoxarifado_inventario_item_edit") {
            /** @var Almoxarifado\InventarioItens $inventarioItens */
            $inventarioItens = $this->getSubject();
            $edicao = true;
            $catalogoItemModel = new CatalogoItemModel($entityManager);
            /** @var Almoxarifado\CatalogoItem $catalogoItem */
            $catalogoItem = $catalogoItemModel->getOneByCodItem($inventarioItens->getCodItem());
            $catalogoClassificacao = $catalogoItem->getFkAlmoxarifadoCatalogoClassificacao();
            $formMapperOptions['codCatalogo']['data'] = $catalogoClassificacao->getFkAlmoxarifadoCatalogo();
            $formMapperOptions['codEstrutural']['data'] = $catalogoClassificacao->getCodEstrutural();
            $formMapperOptions['codItem']['data'] = $inventarioItens->getCodItem();
            $formMapperOptions['codCatalogoItem']['data'] = $catalogoItem;
            $formMapperOptions['codCatalogoItem']['disabled'] = true;

            $marca = $this->modelManager->find(Almoxarifado\Marca::class, $inventarioItens->getCodMarca());
            $formMapperOptions['codMarca']['data'] = $marca;
            $formMapperOptions['codMarca']['disabled'] = true;

            $centro = $this->modelManager->find(Almoxarifado\CentroCusto::class, $inventarioItens->getCodCentro());
            $formMapperOptions['codCentro']['data'] = $centro;
            $formMapperOptions['codCentro']['disabled'] = true;
        }

        $formMapper
            ->with('label.catalogoItem.dadosCatalogo')
                ->add('codCatalogo', 'entity', $formMapperOptions['codCatalogo'])
            ->end()
            ->with(
                'label.item.tipoCadastroLoteClassificacao',
                [
                    'class' => 'catalogoClassificacaoContainer'
                ]
            )
                ->add(
                    'catalogoClassificacaoPlaceholder',
                    'text',
                    [
                        'mapped' => false,
                        'required' => false
                    ]
                )
            ->end()
            ->with('label.bem.atributo', ['class' => 'atributoDinamicoWith'])
            ->add(
                'atributosDinamicos',
                'text',
                $formMapperOptions['atributosDinamicos']
            )
            ->add(
                'codEstrutural',
                'hidden',
                $formMapperOptions['codEstrutural']
            )
            ->add('edicao', 'hidden', ['data' => $edicao, 'mapped' => false])
            ->add('codItem', 'hidden', $formMapperOptions['codItem'])
            ->end()
            ->with('Dados do Item')
                ->add('codCatalogoItem', 'autocomplete', $formMapperOptions['codCatalogoItem'])
                ->add('codMarca', 'autocomplete', $formMapperOptions['codMarca'])
                ->add('fkAlmoxarifadoCentroCusto', 'entity', $formMapperOptions['codCentro'])
                ->add('quantidade', 'number', $formMapperOptions['quantidade'])
                ->add('justificativa', 'textarea', $formMapperOptions['justificativa'])

                ->add('codAlmoxarifado', 'hidden', $formMapperOptions['codAlmoxarifado'])
                ->add('codInventario', 'hidden', $formMapperOptions['codInventario'])
                ->add('exercicio', 'hidden', $formMapperOptions['exercicio'])
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->add('quantidade')
            ->add('justificativa');
    }
    /**
     * @param Almoxarifado\InventarioItens $inventarioItens
     */
    public function prePersist($inventarioItens)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $inventarioItens->setTimestamp(new DateTimeMicrosecondPK());

        $exercicio = $this->getForm()->get('exercicio')->getData();
        $codInventario = $this->getForm()->get('codInventario')->getData();
        $codAlmoxarifado = $this->getForm()->get('codAlmoxarifado')->getData();
        $item = $this->getForm()->get('codCatalogoItem')->getData()->getCodItem();
        $marca = $this->getForm()->get('codMarca')->getData()->getCodMarca();
        $centroCusto = $this->getForm()->get('fkAlmoxarifadoCentroCusto')->getData()->getCodCentro();
        $almoxarifado = $this->getForm()->get('codAlmoxarifado')->getData();

        $estoqueMaterialModel = new EstoqueMaterialModel($entityManager);
        $estoqueMaterial = $estoqueMaterialModel->findOrCreateEstoqueMaterial($item, $marca, $centroCusto, $almoxarifado);

        /**
         * @var Almoxarifado\Inventario $inventario
         */
        $inventario = $entityManager
            ->getRepository(Almoxarifado\Inventario::class)
            ->find([
                'exercicio' => $exercicio,
                'codInventario' => $codInventario,
                'codAlmoxarifado' => $codAlmoxarifado
            ]);

        $inventarioItens->setFkAlmoxarifadoInventario($inventario);
        $inventarioItens->setFkAlmoxarifadoEstoqueMaterial($estoqueMaterial);
    }

    /**
     * @param Almoxarifado\Inventario $inventario
     */
    public function redirect(Almoxarifado\Inventario $inventario)
    {
        $pageId = $this->getObjectKey($inventario);
        $this->forceRedirect("/patrimonial/almoxarifado/inventario/{$pageId}/show");
    }

    /**
     * @param Almoxarifado\InventarioItens $inventarioItens
     */
    public function postPersist($inventarioItens)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $catalogoItemMarcaModel = new CatalogoItemMarcaModel($entityManager);
        $catalogoItemMarca = $catalogoItemMarcaModel->findOrCreateCatalogoItemMarca($inventarioItens->getCodItem(), $inventarioItens->getCodMarca());

        /**
         * @var Almoxarifado\Almoxarifado $almoxarifado
         */
        $almoxarifado = $entityManager
            ->getRepository(Almoxarifado\Almoxarifado::class)
            ->find($this->getForm()->get('codAlmoxarifado')->getData());

        $estoqueMaterialModel = new EstoqueMaterialModel($entityManager);
        $estoqueMaterial = $estoqueMaterialModel->findOrCreateEstoqueMaterial($inventarioItens->getCodItem(), $inventarioItens->getCodMarca(), $inventarioItens->getCodCentro(), $almoxarifado);

        $this->redirect($inventarioItens->getFkAlmoxarifadoInventario());
    }

    /**
     * @param Almoxarifado\InventarioItens $inventarioItens
     */
    public function postUpdate($inventarioItens)
    {
        $this->redirect($inventarioItens->getFkAlmoxarifadoInventario());
    }

    /**
     * @param Almoxarifado\InventarioItens $inventarioItens
     */
    public function postRemove($inventarioItens)
    {
        $this->redirect($inventarioItens->getFkAlmoxarifadoInventario());
    }
}
