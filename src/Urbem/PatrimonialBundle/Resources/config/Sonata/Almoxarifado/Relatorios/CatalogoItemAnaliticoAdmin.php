<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado\Relatorios;

use DateInterval;
use DateTime;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\Catalogo;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Entity\Almoxarifado\TipoItem;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado\Relatorios\CatalogoItemAdmin;

/**
 * Class CatalogoItemAnaliticoAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado\Relatorios
 */
class CatalogoItemAnaliticoAdmin extends CatalogoItemAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_relatorios_catalogo_item_analitico';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/relatorios/catalogo-item/analitico';
    protected $legendButtonSave = ['icon' => 'search', 'text' => 'Consultar'];
    protected $includeJs = [
        '/patrimonial/javascripts/almoxarifado//relatorios/catalogo-item-analitico.js',
    ];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create', 'export']);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb();

        $fieldOptions = [];
        $fieldOptions['categoria'] = [
            'mapped' => false,
            'choices' => array_flip($this::CATEGORIAS),
            'required' => false,
            'data' => $this::CATEGORIA_TODOS,
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.categoria',
        ];

        $fieldOptions['prioridade'] = [
            'mapped' => false,
            'choices' => array_flip(CatalogoItemAdmin::PRIORIDADES),
            'required' => false,
            'placeholder' => 'Todas',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.prioridade',
        ];

        $fieldOptions['tipoItem'] = [
            'mapped' => false,
            'class' => TipoItem::class,
            'query_builder' => $this->getTiposItem(),
            'required' => false,
            'placeholder' => 'Todos',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.tipoItem',
        ];

        $fieldOptions['periodo'] = [
            'mapped' => false,
            'choices' => array_flip($this::PERIODOS),
            'required' => false,
            'placeholder' => 'Todos',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.periodo',
        ];

        $fieldOptions['periodoInicial'] = [
            'mapped' => false,
            'pk_class' => DatePK::class,
            'format' => 'dd/MM/yyyy',
            'required' => false,
            'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.periodoInicial',
        ];

        $fieldOptions['periodoFinal'] = [
            'mapped' => false,
            'pk_class' => DatePK::class,
            'format' => 'dd/MM/yyyy',
            'required' => false,
            'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.periodoFinal',
        ];

        $fieldOptions['almoxarifado'] = [
            'mapped' => false,
            'class' => Almoxarifado::class,
            'multiple' => true,
            'required' => false,
            'placeholder' => 'Todos',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.almoxarifadoRelatoriosCatalogoItemAnalitico.almoxarifado',
        ];

        $fieldOptions['catalogo'] = [
            'mapped' => false,
            'class' => Catalogo::class,
            'multiple' => true,
            'required' => false,
            'placeholder' => 'Todos',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.almoxarifadoRelatoriosCatalogoItemAnalitico.catalogo',
        ];

        $fieldOptions['centroCusto'] = [
            'mapped' => false,
            'class' => CentroCusto::class,
            'multiple' => true,
            'required' => false,
            'placeholder' => 'Todos',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.almoxarifadoRelatoriosCatalogoItemAnalitico.centroCusto',
        ];

        $fieldOptions['item'] = [
            'mapped' => false,
            'route' => ['name' => 'urbem_patrimonial_almoxarifado_relatorios_catalogo_item_sintetico_api_item'],
            'multiple' => true,
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.almoxarifadoRelatoriosCatalogoItemSintetico.item',
        ];

        $fieldOptions['agrupar'] = [
            'mapped' => false,
            'choices' => array_flip($this::AGRUPAR),
            'data' => $this::AGRUPAR_ITEM,
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.almoxarifadoRelatoriosCatalogoItemAnalitico.agruparPor',
        ];

        $formMapper
            ->with('label.almoxarifadoRelatoriosCatalogoItemAnalitico.cabecalhoFiltro')
                ->add('categoria', 'choice', $fieldOptions['categoria'])
                ->add('prioridade', 'choice', $fieldOptions['prioridade'])
                ->add('tipoItem', 'entity', $fieldOptions['tipoItem'])
                ->add('periodo', 'choice', $fieldOptions['periodo'])
                ->add('periodoInicial', 'datepkpicker', $fieldOptions['periodoInicial'])
                ->add('periodoFinal', 'datepkpicker', $fieldOptions['periodoFinal'])
                ->add('almoxarifado', 'entity', $fieldOptions['almoxarifado'])
                ->add('catalogo', 'entity', $fieldOptions['catalogo'])
                ->add('centroCusto', 'entity', $fieldOptions['centroCusto'])
                ->add('item', 'autocomplete', $fieldOptions['item'])
                ->add('agrupar', 'choice', $fieldOptions['agrupar'])
            ->end();

        $formMapper->getFormBuilder()->setAction('export');
    }
}
