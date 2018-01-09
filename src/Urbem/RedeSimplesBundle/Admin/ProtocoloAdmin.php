<?php

namespace Urbem\RedeSimplesBundle\Admin;

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\RedeSimplesBundle\Model\ProtocoloModel;

class ProtocoloAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'rede_simples_protocolo';

    protected $baseRoutePattern = 'rede-simples/protocolo';

    protected $includeJs = array(
        '/redesimples/javascripts/protocolo/protocolo.js'
    );

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list', 'create', 'show']);
        $collection->add('enviar', 'enviar-protocolo/{protocolo}');
        $collection->add('consultar', 'consultar-protocolo/{protocolo}');
    }

    public function prePersist($object)
    {
        (new ProtocoloModel(
            $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager')
        ))->normalizeObjectByForm($object, $this->getCurrentUser(), $this->getForm());
    }

    public function postPersist($object)
    {
        return $this->redirectByRoute($this->baseRouteName . '_enviar', ['protocolo' => $object->getId()]);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add(
            'protocolo',
            null,
            [
                'label' => 'rede_simples.protocolo'
            ]
        );

        $datagridMapper->add(
            'status',
            'doctrine_orm_string',
            ['label' => 'rede_simples.status'],
            'choice',
            ['choices' => (new ProtocoloModel($this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager')))->getAvailableStatus()]
        );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('protocolo', null, ['label' => 'rede_simples.protocolo'])
            ->add('status', null, ['label' => 'rede_simples.status'])
            ->add('dataCriacao', null, ['label' => 'rede_simples.dataCriacao'])
            ->add('dataUltimaConsulta', null, ['label' => 'rede_simples.dataUltimaConsulta'])
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
                    'consultar' => ['template' => 'RedeSimplesBundle:Sonata\Protocolo\CRUD:action_consultar.html.twig'],
                ]
            ])
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb();

        $this->configurationPool->getContainer()
            ->get('rede_simples.form_create')
            ->build($formMapper);
    }

    protected function configureShowFields(ShowMapper $show)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
    }
}
