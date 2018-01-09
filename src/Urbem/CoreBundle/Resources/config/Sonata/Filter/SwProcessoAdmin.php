<?php

namespace Urbem\CoreBundle\Resources\config\Sonata\Filter;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Repository\SwProcessoRepository;

// service: core.admin.filter.sw_processo
class SwProcessoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_core_filter_swprocesso';
    protected $baseRoutePattern = 'core/filter/swprocesso';

    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, SwProcesso::class, $baseControllerName);
    }

    /**
     * @param RouteCollection $routeCollection
     */
    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->clearExcept([]);
        $routeCollection->add('autocomplete', 'autocomplete');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codProcesso')
            ->add('anoExercicio')
            ->add('codClassificacao')
            ->add('codAssunto')
            ->add('codUsuario')
            ->add('codSituacao')
            ->add('timestamp')
            ->add('observacoes')
            ->add('confidencial')
            ->add('resumoAssunto')
            ->add('codCentro')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codProcesso')
            ->add('anoExercicio')
            ->add('codClassificacao')
            ->add('codAssunto')
            ->add('codUsuario')
            ->add('codSituacao')
            ->add('timestamp')
            ->add('observacoes')
            ->add('confidencial')
            ->add('resumoAssunto')
            ->add('codCentro')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('codProcesso')
            ->add('anoExercicio')
            ->add('codClassificacao')
            ->add('codAssunto')
            ->add('codUsuario')
            ->add('codSituacao')
            ->add('timestamp')
            ->add('observacoes')
            ->add('confidencial')
            ->add('resumoAssunto')
            ->add('codCentro')
        ;

        $formMapper->add('autocomplete_field', 'autocomplete', [
            'class' => SwProcesso::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (SwProcessoRepository $repo, $term, Request $request) {
                return $repo->getByTermAsQueryBuilder($term);
            },
        ]);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codProcesso')
            ->add('anoExercicio')
            ->add('codClassificacao')
            ->add('codAssunto')
            ->add('codUsuario')
            ->add('codSituacao')
            ->add('timestamp')
            ->add('observacoes')
            ->add('confidencial')
            ->add('resumoAssunto')
            ->add('codCentro')
        ;
    }
}
