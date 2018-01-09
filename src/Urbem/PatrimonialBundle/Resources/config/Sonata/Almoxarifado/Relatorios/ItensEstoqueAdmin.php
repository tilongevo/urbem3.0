<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado\Relatorios;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

use Sonata\AdminBundle\Form\FormMapper;

use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\Catalogo;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Entity\Almoxarifado\Natureza;
use Urbem\CoreBundle\Entity\Almoxarifado\TipoItem;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\AlmoxarifadoModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CentroCustoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class AlmoxarifadoRelatoriosAdmin
 *
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado
 */
class ItensEstoqueAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_relatorios';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/relatorios';

    protected $legendButtonSave = [
        'icon' => 'receipt',
        'text' => 'Gerar Relatório'
    ];

    protected $includeJs = [
        '/patrimonial/javascripts/almoxarifado/catalogo-classificacao-component.js',
        '/patrimonial/javascripts/almoxarifado/relatorios/item-estoque.js'
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create']);

        $collection->add('itens_estoque', 'itens-estoque');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setLabel('label.almoxarifado.relatorios.relatorioItens');

        $this->setBreadCrumb();

        $entityManager = $this->getEntityManager();

        $centroCustoModel = new CentroCustoModel($entityManager);
        $almoxarifadoModel = new AlmoxarifadoModel($entityManager);

        $swCgm = $this->getCurrentUser()->getFkSwCgm();

        $fieldOptions = [];
        $fieldOptions['almoxarifados'] = [
            'attr'        => ['class' => 'select2-parameters select2-multiple-options-custom'],
            'class'       => Almoxarifado::class,
            'data'        => new ArrayCollection($almoxarifadoModel->getAlmoxarifadosPadrao()),
            'label'       => 'label.almoxarifado.relatorios.almoxarifados',
            'mapped'      => false,
            'multiple'    => true,
            'placeholder' => 'label.selecione',
            'required'    => false,
        ];

        $fieldOptions['centrosCusto'] = [
            'attr'        => ['class' => 'select2-parameters '],
            'class'       => CentroCusto::class,
            'label'       => 'label.almoxarifado.relatorios.centrosCusto',
            'mapped'      => false,
            'multiple'    => true,
            'placeholder' => 'label.selecione',
            'required'    => false,
        ];

        $fieldOptions['catalogo'] = [
            'attr'         => ['class' => 'select2-parameters '],
            'class'        => Catalogo::class,
            'choice_value' => 'codCatalogo',
            'label'        => 'label.fornecedor.catalogo',
            'mapped'       => false,
            'placeholder'  => 'label.selecione',
            'required'     => true,
        ];

        $fieldOptions['centrosCusto'] = [
            'attr'        => ['class' => 'select2-parameters select2-multiple-options-custom '],
            'class'       => CentroCusto::class,
            'data'        => new ArrayCollection($centroCustoModel->findCentroCustoPermissaoByCgm($swCgm)),
            'label'       => 'label.almoxarifado.relatorios.centrosCusto',
            'mapped'      => false,
            'multiple'    => true,
            'placeholder' => 'label.selecione',
            'required'    => false,
        ];

        $fieldOptions['item'] = [
            'attr'                 => ['class' => 'select2-parameters '],
            'class'                => CatalogoItem::class,
            'label'                => 'label.almoxarifado.relatorios.itemDe',
            'json_choice_label'    => function (CatalogoItem $catalogoItem) {
                return sprintf(
                    '%09d - %s - %s',
                    $catalogoItem->getCodItem(),
                    $catalogoItem->getFkAdministracaoUnidadeMedida()->getNomUnidade(),
                    $catalogoItem->getDescricao()
                );
            },
            'json_from_admin_code' => $this->code,
            'json_query_builder'   =>
                function (EntityRepository $repo, $term, Request $request) {
                    $queryBuilder = $repo->createQueryBuilder('catalogoItem');

                    $queryBuilder
                        ->join('catalogoItem.fkAdministracaoUnidadeMedida', 'unidadeMedida')
                        ->join('catalogoItem.fkAlmoxarifadoTipoItem', 'tipoItem')
                        ->join('catalogoItem.fkAlmoxarifadoCatalogoClassificacao', 'catalogoClassificacao')
                        ->join('catalogoClassificacao.fkAlmoxarifadoCatalogo', 'catalogo');

                    $queryBuilder
                        ->where(
                            $queryBuilder->expr()->like(
                                $queryBuilder->expr()->lower('catalogoItem.descricao'),
                                $queryBuilder->expr()->lower(':descricao')
                            )
                        )
                    ->setParameter('descricao', "%{$term}%");

                    if (intval($term) > 0) {
                        $queryBuilder->orWhere(
                            $queryBuilder->expr()->eq("catalogoItem.codItem", ":codItem")
                            )
                            ->setParameter('codItem', $term);
                    }

                    return $queryBuilder;
                },
            'mapped'               => false,
            'required'             => false,

        ];

        $fieldOptions['itemDescricao'] = [
            'label'    => 'label.almoxarifado.relatorios.descricaoItem',
            'mapped'   => false,
            'required' => false,
        ];

        $fieldOptions['tipoItem'] = [
            'attr'         => ['class' => 'select2-parameters '],
            'class'        => TipoItem::class,
            'data'         => $this->modelManager->find(TipoItem::class, 0),
            'choice_label' => function (TipoItem $tipoItem) {
                if ($tipoItem->getCodTipo() == 0) {
                    return 'Todos';
                }

                return $tipoItem->getDescricao();
            },
            'choices'      => $this->getEntityManager()->getRepository(TipoItem::class)->findBy([], ['codTipo' => 'ASC']),
            'label'        => 'label.almoxarifado.relatorios.tipo',
            'mapped'       => false,
            'multiple'     => false,
            'required'     => true,
        ];

        $fieldOptions['natureza'] = [
            'attr'          => ['class' => 'select2-parameters '],
            'class'         => Natureza::class,
            'query_builder' => function (EntityRepository $repository) {
                return $repository
                    ->createQueryBuilder('natureza')
                    ->where('natureza.tipoNatureza = :tipoNatureza')
                    ->andWhere('natureza.codNatureza != 4')
                    ->setParameter('tipoNatureza', Natureza::ENTRADA);
            },
            'label'         => 'label.almoxarifado.relatorios.natureza',
            'mapped'        => false,
            'multiple'      => false,
            'placeholder'   => 'label.selecione',
            'required'      => false,
        ];

        $fieldOptions['situacao'] = [
            'data'   => new \Datetime(),
            'format' => 'dd/MM/yyyy',
            'label'  => 'label.almoxarifado.relatorios.situacao',
            'mapped' => false,
        ];

        $fieldOptions['ordenar'] = [
            'attr'     => ['class' => 'select2-parameters '],
            'choices'  => [
                'label.almoxarifado.relatorios.sort.classificacao' => 'catalogo_classificacao.cod_classificacao',
                'label.almoxarifado.relatorios.sort.item'          => 'catalogo_item.cod_item',
                'label.almoxarifado.relatorios.sort.descricaoItem' => 'catalogo_item.descricao',
            ],
            'data'     => 'classificacao',
            'label'    => 'label.almoxarifado.relatorios.sort.ordenarPor',
            'mapped'   => false,
            'required' => true,
        ];

        $fieldOptions['saldo'] = [
            'attr'     => ['class' => 'select2-parameters '],
            'choices'  => [
                'todos' => 'todos',
                'sim'   => 'sim',
                'nao'   => 'nao',
            ],
            'data'     => 'sim',
            'label'    => 'label.almoxarifado.relatorios.saldo',
            'mapped'   => false,
            'required' => true,
        ];

        $fieldOptions['tipoQuebra'] = [
            'attr'     => ['class' => 'select2-parameters '],
            'choices'  => [
                'label.almoxarifado.item' => 'item',
                'label.itens.centroCusto' => 'centro_custo',
            ],
            'data'     => 'centro_custo',
            'label'    => 'label.almoxarifado.relatorios.tipoQuebra',
            'mapped'   => false,
            'required' => true,
        ];

        $formMapper
            ->with('label.almoxarifado.relatorios.filtro')
            ->add('almoxarifados', 'entity', $fieldOptions['almoxarifados'])
            ->add('centrosCusto', 'entity', $fieldOptions['centrosCusto'])
            ->end();

        $formMapper
            ->with('label.fornecedor.catalogo')
            ->add('catalogo', 'entity', $fieldOptions['catalogo'])
            ->end();

        $formMapper
            ->with('label.item.tipoCadastroLoteClassificacao', [
                'class' => 'catalogoClassificacaoContainer',
            ])
            ->add('catalogoClassificacaoPlaceholder', 'text', [
                'mapped'   => false,
                'required' => false,
            ])
            ->end();

        $formMapper
            ->with('label.almoxarifado.relatorios.item')
            ->add('itemDe', 'autocomplete', $fieldOptions['item'])
            ->add('itemPara', 'autocomplete', array_merge($fieldOptions['item'], ['label' => 'label.almoxarifado.relatorios.itemPara']))
            ->add('itemDescricao', 'text', $fieldOptions['itemDescricao'])
            ->add('tipoItem', 'entity', $fieldOptions['tipoItem'])
            ->add('natureza', 'entity', $fieldOptions['natureza'])
            ->add('situacao', 'sonata_type_date_picker', $fieldOptions['situacao'])
            ->add('ordenar', 'choice', $fieldOptions['ordenar'])
            ->add('saldo', 'choice', $fieldOptions['saldo'])
            ->add('tipoQuebra', 'choice', $fieldOptions['tipoQuebra']);

        $formMapper
            ->getFormBuilder()
            ->setAction('itens_estoque');
    }
}
