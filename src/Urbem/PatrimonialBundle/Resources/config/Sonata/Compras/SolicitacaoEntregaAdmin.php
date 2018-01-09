<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model\SwCgmModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\SwCgm;

class SolicitacaoEntregaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_solicitacao_entrega';
    protected $baseRoutePattern = 'patrimonial/compras/solicitacao-entrega';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codSolicitacaoEntrega')
            ->add('exercicio')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codSolicitacaoEntrega')
            ->add('exercicio')
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
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $formMapperOptions = [];

        $formMapperOptions['numcgm'] = [
            'property' => 'nomCgm',
            'label' => 'Localização da Entrega',
            'to_string_callback' => function (SwCgm $swCgm, $property) {
                return strtoupper($swCgm->getNomCgm());
            },
            'callback' => function ($admin, $property, $value) use ($entityManager) {
                $datagrid = $admin->getDatagrid();
                $query = $datagrid->getQuery();

                $swCgmModel = new SwCgmModel($entityManager);
                $swCgmModel->recuperaApenasPessoasFisicasEJuridicas($query);
                $datagrid->setValue($property, null, $value);
            }
        ];

        $formMapper
            ->add('numcgm', 'sonata_type_model_autocomplete', $formMapperOptions['numcgm'], ['admin_code' => 'core.admin.filter.sw_cgm'])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codSolicitacaoEntrega')
            ->add('exercicio')
        ;
    }
}
