<?php

namespace Urbem\CoreBundle\Resources\config\Sonata\Filter\Stn;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica;
use Urbem\CoreBundle\Repository\Contabilidade\PlanoAnaliticaRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Class PlanoContaAnaliticaAdmin
 * @service core.admin.filter.stn_plano_conta
 * @package Urbem\CoreBundle\Resources\config\Sonata\Filter\Stn
 */
class PlanoContaAnaliticaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_core_filter_stn_plano_conta_analitica';
    protected $baseRoutePattern = 'core/filter/stn_plano_conta_analitica';

    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, PlanoAnalitica::class, $baseControllerName);
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
            'class' => PlanoAnalitica::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (PlanoAnaliticaRepository $repo, $term, Request $request) {
                return $repo->getPlanoContaByTermAsQueryBuilder($this->getExercicio(), $term);
            },
        ]);
    }
}
