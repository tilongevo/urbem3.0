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

class SolicitacaoConvenioAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_solicitacao_convenio';
    protected $baseRoutePattern = 'patrimonial/compras/solicitacao-convenio';
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicio')
            ->add('codEntidade')
            ->add('codSolicitacao')
            ->add('numConvenio')
            ->add('exercicioConvenio')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('exercicio')
            ->add('codEntidade')
            ->add('codSolicitacao')
            ->add('numConvenio')
            ->add('exercicioConvenio')
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
            ->add(
                'numConvenio',
                'entity',
                [
                    'class' => 'CoreBundle:Licitacao\Convenio',
                    'label' => 'Convênio',
                    'required' => false,
                    'choice_label' => function ($numConvenio) {
                        return $numConvenio->getNumConvenio() . ' - ' . $numConvenio->getExercicio();
                    },
                    'attr'          => [
                        'class' => 'select2-parameters'
                    ]
                ]
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('exercicio')
            ->add('codEntidade')
            ->add('codSolicitacao')
            ->add('numConvenio')
            ->add('exercicioConvenio')
        ;
    }
}
