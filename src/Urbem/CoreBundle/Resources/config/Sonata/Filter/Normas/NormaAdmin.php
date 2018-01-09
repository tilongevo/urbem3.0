<?php

namespace Urbem\CoreBundle\Resources\config\Sonata\Filter\Normas;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Repository\Normas\NormaRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

// code: core.admin.filter.normas_norma
class NormaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_core_filter_normas_norma';
    protected $baseRoutePattern = 'core/filter/normas_norma';

    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, Norma::class, $baseControllerName);
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
            'class' => Norma::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (NormaRepository $repo, $term, Request $request) {
                return $repo->getByExercicioAnTermAsQueryBuilder($this->getExercicio(), $term);
            },
        ]);
    }
}
