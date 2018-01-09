<?php

namespace Urbem\CoreBundle\Resources\config\Sonata\Filter\Tcemg;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Tcemg\Contrato;
use Urbem\CoreBundle\Repository\Tcemg\ContratoRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

// service: core.admin.filter.tcemg_contrato
class ContratoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_core_filter_tcemg_contrato';
    protected $baseRoutePattern = 'core/filter/tcemg_contrato';

    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, Contrato::class, $baseControllerName);
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
            'class' => Contrato::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (ContratoRepository $repo, $term, Request $request) {
                return $repo->getByTermAsQueryBuilder($term);
            },
        ]);
    }
}

