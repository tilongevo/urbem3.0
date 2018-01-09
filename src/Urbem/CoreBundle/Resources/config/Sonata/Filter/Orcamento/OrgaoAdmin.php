<?php

namespace Urbem\CoreBundle\Resources\config\Sonata\Filter\Orcamento;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Orcamento\Orgao;
use Urbem\CoreBundle\Repository\Orcamento\OrgaoRepository;

// code: core.admin.filter.orcamento_orgao
class OrgaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_core_filter_orcamento_orgao';
    protected $baseRoutePattern = 'core/filter/orcamento_orgao';

    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, Orgao::class, $baseControllerName);
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
            'class' => Orgao::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (OrgaoRepository $repo, $term, Request $request) {
                return $repo->getByTermAsQueryBuilder($term);
            },
        ]);
    }
}
