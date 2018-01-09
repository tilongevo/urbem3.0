<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\PedidoTransferenciaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Urbem\CoreBundle\Entity\Almoxarifado;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class SaidaTransferenciaAdmin
 */
class SaidaTransferenciaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_saida_transferencia';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/saida/transferencia';

    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoEditar = false;

    public $tipoNatureza = 'S';

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->clearExcept(['list', 'show']);

        $routeCollection->add('processar', '{id}/{tipoNatureza}/processar', [
            '_controller' => 'PatrimonialBundle:Almoxarifado/PedidoTransferenciaAdmin:processarPedidos'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicio', null, [
                'label' => 'label.saidaTransferencia.exercicio'
            ])

            // Almoxarifado Origem
            ->add('fkAlmoxarifadoAlmoxarifado', null, [
                'label' => 'label.saidaTransferencia.almoxarifadoOrigem'
            ], null)

            // Almoxarifado Destino
            ->add('fkAlmoxarifadoAlmoxarifado1', null, [
                'label' => 'label.saidaTransferencia.almoxarifadoDestino'
            ], null)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list')
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $query = parent::createQuery($context);
        $query = (new PedidoTransferenciaModel($entityManager))->getPedidosTransferiencia($query, $this->tipoNatureza);

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb([]);

        $codTransferenciaTemplate =
            'PatrimonialBundle:Sonata/Almoxarifado/SaidaTransferencia/CRUD:list__codTransferencia.html.twig';

        $listMapper
            ->add('codTransferencia', 'string', [
                'label' => 'label.saidaTransferencia.codigo',
                'template' => $codTransferenciaTemplate
            ])
            ->add('fkAlmoxarifadoAlmoxarifado', null, [
                'label' => 'label.saidaTransferencia.almoxarifadoOrigem'
            ])
            ->add('fkAlmoxarifadoAlmoxarifado1', null, [
                'label' => 'label.saidaTransferencia.almoxarifadoDestino'
            ])
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $objectId = $this->getAdminRequestId();
        $this->setBreadCrumb(['id' => $objectId]);

        /** @var Almoxarifado\PedidoTransferencia $pedidoTransferencia */
        $pedidoTransferencia = $this->getObject($objectId);

        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $pedidoTransferenciaModel = new PedidoTransferenciaModel($entityManager);
        $pedidoTransferenciaModel->getSaldoOrigemItem($pedidoTransferencia);
    }
}
