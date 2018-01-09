<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Ldo;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\Model;

class TipoIndicadoresAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_ldo_tipo_indicadores';
    protected $baseRoutePattern = 'financeiro/ldo/tipo-indicadores';
    protected $model = Model\Ldo\TipoIndicadoresModel::class;
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'descricao',
                null,
                array(
                    'label' => 'label.tipoIndicadores.descricao'
                )
            )
            ->add(
                'codUnidade',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.tipoIndicadores.codUnidade'
                ),
                'entity',
                array(
                    'label' => 'label.tipoIndicadores.codUnidade',
                    'class' => 'CoreBundle:Administracao\UnidadeMedida',
                    'choice_label' => 'nomUnidade',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->where('u.codUnidade > 0')
                            ->orderBy('u.nomUnidade', 'ASC');
                    },
                    'choice_value' => function ($unidade) {
                        if ($unidade) {
                            return $unidade->getCodUnidade() . "-" . $unidade->getFkAdministracaoGrandeza()->getCodGrandeza();
                        }
                    },
                    'placeholder' => '',
                    'attr' => array(
                        'class' => 'select2-parameters'
                    )
                )
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

        if ($filter['codUnidade']['value'] != '') {
            $unidadeArray = explode("-", $filter['codUnidade']['value']);

            $entityManager = $this->modelManager->getEntityManager($this->getClass());

            $ids = (new \Urbem\CoreBundle\Model\Ldo\TipoIndicadoresModel($entityManager))
            ->getIdsFiltro($unidadeArray);

            array_push($ids, 0);
            $queryBuilder->andWhere(
                "{$alias}.codTipoIndicador IN (" . implode(",", $ids) . ")"
            );
        }

        return true;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove("show");
    }

    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                )
            ))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'codTipoIndicador',
                null,
                array(
                    'label' => 'label.codigo'
                )
            )
            ->add(
                'descricao',
                null,
                array(
                    'label' => 'label.tipoIndicadores.descricao'
                )
            )
            ->add(
                'fkAdministracaoUnidadeMedida.nomUnidade',
                null,
                array(
                    'label' => 'label.tipoIndicadores.codUnidade'
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

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $formOptions = array();

        $formOptions['descricao'] = array(
            'label' => 'label.tipoIndicadores.descricao'
        );

        $formOptions['fkAdministracaoUnidadeMedida'] = array(
            'label' => 'label.tipoIndicadores.codUnidade',
            'class' => 'CoreBundle:Administracao\UnidadeMedida',
            'query_builder' => function ($em) {
                $queryBuilder = $em->createQueryBuilder('o');
                $queryBuilder->where('o.codUnidade > 0');
                $queryBuilder->orderBy('o.nomUnidade', 'ASC');
                return $queryBuilder;
            },
            'choice_label' => 'nomUnidade',
            'placeholder' => '',
            'attr' => array(
                'class' => 'select2-parameters'
            )
        );

        $formMapper
            ->with('label.tipoIndicadores.dadosIncluirTipoIndicador')
                ->add(
                    'descricao',
                    'text',
                    $formOptions['descricao']
                )
                ->add(
                    'fkAdministracaoUnidadeMedida',
                    'entity',
                    $formOptions['fkAdministracaoUnidadeMedida']
                )
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codTipoIndicador')
            ->add('descricao')
        ;
    }
}
