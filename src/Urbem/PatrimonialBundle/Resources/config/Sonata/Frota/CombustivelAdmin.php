<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Frota\Combustivel;
use Urbem\CoreBundle\Model\Patrimonial\Frota\CombustivelModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class CombustivelAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Frota
 */
class CombustivelAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_combustivel';

    protected $baseRoutePattern = 'patrimonial/frota/combustivel';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'nomCombustivel',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'Descrição'
                ),
                null
            )
        ;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (! $value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();

        if ($filter['nomCombustivel']['value'] != '') {
            $queryBuilder->andWhere("LOWER({$alias}.nomCombustivel) LIKE :nomCombustivel");
            $queryBuilder->setParameter("nomCombustivel", '%'. strtolower($filter['nomCombustivel']['value']) .'%');
        }

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'codCombustivel',
                'number',
                array(
                    'label' => 'Código do combustível',
                    'sortable' => false
                )
            )
            ->add(
                'nomCombustivel',
                'text',
                array(
                    'label' => 'Descrição',
                    'sortable' => false
                )
            )
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? array('id' => $id) : array());

        $formMapper
            ->add(
                'nomCombustivel',
                null,
                array(
                    'label' => 'Descrição'
                )
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(array('id' => $this->getAdminRequestId()));

        $showMapper
            ->add(
                'codCombustivel',
                null,
                array(
                    'label' => 'Código do combustível'
                )
            )
            ->add(
                'nomCombustivel',
                null,
                array(
                    'label' => 'Descrição'
                )
            )
        ;
    }
}
