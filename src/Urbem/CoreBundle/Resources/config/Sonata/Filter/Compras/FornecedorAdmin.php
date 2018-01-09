<?php

namespace Urbem\CoreBundle\Resources\config\Sonata\Filter\Compras;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Compras\Fornecedor;
use Urbem\CoreBundle\Repository\Patrimonio\Compras\FornecedorRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

// code: core.admin.filter.fornecedor
class FornecedorAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_core_filter_compras_fornecedor';
    protected $baseRoutePattern = 'core/filter/compras/fornecedor';
    
    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->clearExcept([]);
        $routeCollection->add('autocomplete', 'autocomplete');
    }
    
    /**ti
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'nomCgm',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                ),
                'text',
                null
            )
        ;
    }
    
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (! $value['value']) {
            return;
        }
        
        $filter = $this->getDataGrid()->getValues();
        
        $queryBuilder->resetDQLPart('join');
        
        $queryBuilder->join("CoreBundle:SwCgm", "cgm", "WITH", "cgm.numcgm = {$alias}.cgmFornecedor");
        $queryBuilder->andWhere("LOWER(cgm.nomCgm) LIKE :nomCgm");
        $queryBuilder->setParameter(":nomCgm", '%' . strtolower($filter['nomCgm']['value']) . '%');
        
        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('cgmFornecedor')
            ->add('vlMinimoNf')
            ->add('ativo')
            ->add('tipo')
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
            ->add('cgmFornecedor')
            ->add('vlMinimoNf')
            ->add('ativo')
            ->add('tipo')
        ;

        $formMapper->add('autocomplete_field', 'autocomplete', [
            'class' => Fornecedor::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (FornecedorRepository $repo, $term, Request $request) {
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
            ->add('cgmFornecedor')
            ->add('vlMinimoNf')
            ->add('ativo')
            ->add('tipo')
        ;
    }
}
