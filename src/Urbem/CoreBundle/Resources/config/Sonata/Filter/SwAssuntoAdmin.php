<?php

namespace Urbem\CoreBundle\Resources\config\Sonata\Filter;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class SwAssuntoAdmin
 * @package Urbem\CoreBundle\Resources\config\Sonata\Filter
 */
class SwAssuntoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_core_filter_swassunto';
    protected $baseRoutePattern = 'core/filter/swassunto';

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept([]);
        $collection->add('search_classificacao', 'search/classificacao/{cod_classificacao}');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codAssunto')
            ->add('codClassificacao')
            ->add('nomAssunto')
            ->add('confidencial')
        ;
    }
}
