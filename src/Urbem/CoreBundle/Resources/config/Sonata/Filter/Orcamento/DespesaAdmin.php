<?php

namespace Urbem\CoreBundle\Resources\config\Sonata\Filter\Orcamento;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class DespesaAdmin extends AbstractAdmin
{
    /**
     * @param RouteCollection $routeCollection
     */
    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->clearExcept([]);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicio')
            ->add('codDespesa')
            ->add('codEntidade')
            ->add('codPrograma')
            ->add('codConta')
            ->add('numPao')
            ->add('numOrgao')
            ->add('numUnidade')
            ->add('codRecurso')
            ->add('codFuncao')
            ->add('codSubfuncao')
            ->add('vlOriginal')
            ->add('dtCriacao')
            ->add(
                'codDespesaDescricao',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter')
                )
            )
        ;
    }

    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        $filter = $this->getDataGrid()->getValues();

        if (!count($value['value'])) {
            return;
        }

        if ($filter['codDespesaDescricao']['value'] != '') {
            $queryBuilder->join('o.fkOrcamentoContaDespesa', 'cd');
            $queryBuilder->andWhere($queryBuilder->expr()->orX(
                $queryBuilder->expr()->eq('o.codDespesa', ':codDespesa'),
                $queryBuilder->expr()->like('lower(cd.descricao)', ':descricao')
            ));
            $queryBuilder->setParameter('codDespesa', (int) $filter['codDespesaDescricao']['value']);
            $queryBuilder->setParameter('descricao', '%' . strtolower($filter['codDespesaDescricao']['value']) . '%');
        }
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('exercicio')
            ->add('codDespesa')
            ->add('codEntidade')
            ->add('codPrograma')
            ->add('codConta')
            ->add('numPao')
            ->add('numOrgao')
            ->add('numUnidade')
            ->add('codRecurso')
            ->add('codFuncao')
            ->add('codSubfuncao')
            ->add('vlOriginal')
            ->add('dtCriacao')
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
            ->add('exercicio')
            ->add('codDespesa')
            ->add('codEntidade')
            ->add('codPrograma')
            ->add('codConta')
            ->add('numPao')
            ->add('numOrgao')
            ->add('numUnidade')
            ->add('codRecurso')
            ->add('codFuncao')
            ->add('codSubfuncao')
            ->add('vlOriginal')
            ->add('dtCriacao')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('exercicio')
            ->add('codDespesa')
            ->add('codEntidade')
            ->add('codPrograma')
            ->add('codConta')
            ->add('numPao')
            ->add('numOrgao')
            ->add('numUnidade')
            ->add('codRecurso')
            ->add('codFuncao')
            ->add('codSubfuncao')
            ->add('vlOriginal')
            ->add('dtCriacao')
        ;
    }
}
