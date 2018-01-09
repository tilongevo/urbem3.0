<?php

namespace Urbem\CoreBundle\Resources\config\Sonata\Filter\Stn;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Orcamento\Receita;
use Urbem\CoreBundle\Repository\Orcamento\ReceitaRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Class ReceitaAdmin
 * @service core.admin.filter.stn_receita
 * @package Urbem\CoreBundle\Resources\config\Sonata\Filter\Stn
 */
class ReceitaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_core_filter_stn_receita';
    protected $baseRoutePattern = 'core/filter/stn_receita';

    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, Receita::class, $baseControllerName);
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
            'class' => Receita::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (ReceitaRepository $repo, $term, Request $request) {
                return $repo->getReceitaByTermAsQueryBuilder($this->getExercicio(), $term);
            },
        ]);
    }
}

