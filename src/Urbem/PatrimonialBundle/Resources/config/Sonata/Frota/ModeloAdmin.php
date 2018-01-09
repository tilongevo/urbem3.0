<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Frota\Marca;
use Urbem\CoreBundle\Entity\Frota\Modelo;
use Urbem\CoreBundle\Model\Patrimonial\Frota\MarcaModel;
use Urbem\CoreBundle\Model\Patrimonial\Frota\ModeloModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ModeloAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_modelo';
    protected $baseRoutePattern = 'patrimonial/frota/modelo';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'nomModelo',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.modelo.descricao'
                ),
                null
            )
            ->add(
                'codMarca',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.modelo.marca'
                ),
                'entity',
                array(
                    'class' => 'CoreBundle:Frota\Marca',
                    'choice_label' => function ($marca) {
                        /** @var Marca $marca */
                        return $marca->getCodMarca().' - '.$marca->getNomMarca();
                    },
                    'placeholder' => 'label.selecione'
                )
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

        $queryBuilder->resetDQLPart('join');

        if ($filter['nomModelo']['value'] != '') {
            $queryBuilder->andWhere("LOWER({$alias}.nomModelo) LIKE :nomModelo");
            $queryBuilder->setParameter("nomModelo", '%'. strtolower($filter['nomModelo']['value']) .'%');
        }

        if ($filter['codMarca']['value'] != '') {
            $queryBuilder->andWhere("{$alias}.codMarca = :codMarca");
            $queryBuilder->setParameter("codMarca", $filter['codMarca']['value']);
            $queryBuilder->addOrderBy("{$alias}.codMarca");
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
                'codModelo',
                null,
                array(
                    'label' => 'Código do modelo',
                    'sortable' => false
                )
            )
            ->add(
                'nomModelo',
                'string',
                array(
                    'label' => 'label.modelo.descricao',
                    'sortable' => false
                )
            )
            ->add(
                'fkFrotaMarca',
                'entity',
                array(
                    'label' => 'label.modelo.marca',
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
                'fkFrotaMarca',
                'entity',
                array(
                    'class' => 'CoreBundle:Frota\Marca',
                    'choice_label' => function ($marca) {
                        /** @var Marca $marca */
                        return $marca->getCodMarca().' - '.$marca->getNomMarca();
                    },
                    'placeholder' => 'label.selecione',
                    'label' => 'label.modelo.marca',
                    'attr' => array(
                        'class' => 'select2-parameters '
                    ),
                )
            )
            ->add(
                'nomModelo',
                'text',
                array(
                    'label' => 'label.modelo.descricao'
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
                'codModelo',
                null,
                array(
                    'label' => 'Código do modelo'
                )
            )
            ->add(
                'nomModelo',
                null,
                array(
                    'label' => 'label.modelo.descricao'
                )
            )
            ->add(
                'fkFrotaMarca',
                null,
                array(
                    'label' => 'Código da marca'
                )
            )
        ;
    }

    /**
     * @param Modelo $object
     */
    public function prePersist($object)
    {
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $modeloModel = new ModeloModel($entityManager);
        $object->setCodModelo(
            $modeloModel->getAvailableIdentifier($object->getCodMarca())
        );
    }
}
