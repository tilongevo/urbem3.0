<?php

namespace Urbem\CoreBundle\Resources\config\Sonata\Filter\Almoxarifado;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Repository\Almoxarifado\CatalogoItemRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

// service: core.admin.filter.almoxarifado.catalogo_item
class CatalogoItemAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_core_filter_almoxarifado_catalogo_item';
    protected $baseRoutePattern = 'core/filter/almoxarifado_catalogo_item';

    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, CatalogoItem::class, $baseControllerName);
    }

    /**
     * @param RouteCollection $routeCollection
     */
    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->clearExcept([]);
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('autocomplete_field', 'autocomplete', [
            'class' => CatalogoItem::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (CatalogoItemRepository $repo, $term, Request $request) {
                return $repo->getByTermAsQueryBuilder($term);
            },
        ]);
    }
}
