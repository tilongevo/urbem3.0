<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\PedidoTransferenciaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * Class PedidoTransferenciaAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado
 */
class PedidoTransferenciaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_pedido_transferencia';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/pedido-transferencia';
    protected $exibirBotaoExcluir = false;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');

        $collection->add(
            'anular_pedido_transferencia',
            '{id}/anular-pedido-transferencia'
        );
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapperOptions = [];
        $datagridMapperOptions['almoxarifado'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Almoxarifado\Almoxarifado::class,
            'choice_label' => function (Almoxarifado\Almoxarifado $almoxarifado) {
                $numcgm = $almoxarifado->getFkSwCgm()->getNumcgm();
                $nomFantasia = $almoxarifado->getFkSwCgm()->getNomCgm();

                return sprintf('%d - %s', $numcgm, $nomFantasia);
            },
            'placeholder' => 'label.selecione'
        ];

        $datagridMapper
            ->add('exercicio', null, ['label' => 'label.exercicio'])
            ->add('codAlmoxarifadoOrigem', null, [
                'label' => 'label.pedidoTransferencia.codAlmoxarifadoOrigem'
            ], 'entity', $datagridMapperOptions['almoxarifado'])
            ->add('codAlmoxarifadoDestino', null, [
                    'label' => 'label.pedidoTransferencia.codAlmoxarifadoDestino',
            ], 'entity', $datagridMapperOptions['almoxarifado'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb([]);

        $codTransferenciaTemplate =
            'PatrimonialBundle:Sonata/Almoxarifado/SaidaTransferencia/CRUD:list__codTransferencia.html.twig';

        $anularPedidoTransferenciaTemplate =
            'PatrimonialBundle:Sonata/Almoxarifado/PedidoTransferencia/CRUD:list__action_anular.html.twig';

        $listMapper
            ->add('codTransferencia', 'string', [
                'label' => 'label.saidaTransferencia.codigo',
                'template' => $codTransferenciaTemplate
            ])
            ->add('fkAlmoxarifadoAlmoxarifado.fkSwCgm.nomCgm', null, [
                'label' => 'label.saidaTransferencia.almoxarifadoOrigem'
            ])
            ->add('fkAlmoxarifadoAlmoxarifado1.fkSwCgm.nomCgm', null, [
                'label' => 'label.saidaTransferencia.almoxarifadoDestino'
            ])
            ->add('observacao', null, [
                'label' => 'label.pedidoTransferencia.observacao'
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
                    'edit' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'],
                    'anular_pedido_transferencia' => ['template' => $anularPedidoTransferenciaTemplate],
                ]
            ])
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var EntityManager $em */
        $em = $this->getModelManager()->getEntityManager($this->getClass());

        $objectId = $this->getAdminRequestId();

        $exercicio = $this->getExercicio();
        if ($this->id($this->getSubject())) {
            $exercicio = $this->getSubject()->getExercicio();
        }

        $this->setBreadCrumb($objectId ? ['id' => $objectId] : []);

        $fieldOptions = [];
        $fieldOptions['almoxarifado'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Almoxarifado\Almoxarifado::class,
            'choice_label' => function (Almoxarifado\Almoxarifado $almoxarifado) {
                $numcgm = $almoxarifado->getFkSwCgm()->getNumcgm();
                $nomFantasia = $almoxarifado->getFkSwCgm()->getNomCgm();

                return sprintf('%d - %s', $numcgm, $nomFantasia);
            },
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['codAlmoxarifadoOrigem'] = $fieldOptions['almoxarifado'];
        $fieldOptions['codAlmoxarifadoOrigem']['label'] = 'label.pedidoTransferencia.codAlmoxarifadoOrigem';

        $fieldOptions['codAlmoxarifadoDestino'] = $fieldOptions['almoxarifado'];
        $fieldOptions['codAlmoxarifadoDestino']['label'] = 'label.pedidoTransferencia.codAlmoxarifadoDestino';

        $fieldOptions['exercicio'] = [
            'attr' => ['readonly' => true],
            'data' => $exercicio,
            'label' => 'label.pedidoTransferencia.exercicio'
        ];

        $fieldOptions['observacao'] = ['label' => 'label.pedidoTransferencia.observacao'];

        if (sprintf('%s_edit', $this->baseRouteName) == $this->getRequest()->get('_sonata_name')) {
            $this->setIncludeJs(['/patrimonial/javascripts/almoxarifado/pedido-transferencia.js']);

            $fieldOptions['codAlmoxarifadoDestino']['attr']['class'] = 'select2-parameters readonly';
            $fieldOptions['codAlmoxarifadoOrigem']['attr']['class'] = 'select2-parameters readonly';
        }

        $formMapper
            ->with('label.pedidoTransferencia.dadosPedido')
                ->add('exercicio', null, $fieldOptions['exercicio'])
                ->add('fkAlmoxarifadoAlmoxarifado', 'entity', $fieldOptions['codAlmoxarifadoOrigem'])
                ->add('fkAlmoxarifadoAlmoxarifado1', 'entity', $fieldOptions['codAlmoxarifadoDestino'])
                ->add('observacao', 'textarea', $fieldOptions['observacao'])
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $objectId = $this->getAdminRequestId();
        $this->setBreadCrumb(['id' => $objectId]);

        $showMapper
            ->with('label.pedidoTransferencia.dadosPedido')
            ->add('exercicio', null, ['label' => 'label.pedidoTransferencia.exercicio'])
            ->add('fkAlmoxarifadoAlmoxarifado', null, ['label' => 'label.pedidoTransferencia.codAlmoxarifadoOrigem'])
            ->add('fkAlmoxarifadoAlmoxarifado1', null, ['label' => 'label.pedidoTransferencia.codAlmoxarifadoDestino'])
            ->add('observacao', null, ['label' => 'label.pedidoTransferencia.observacao'])
            ->end()
        ;
    }

    /**
     * @param Almoxarifado\PedidoTransferencia $pedidoTransferencia
     */
    public function prePersist($pedidoTransferencia)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        $pedidoTransferenciaModel = new PedidoTransferenciaModel($entityManager);

        $pedidoTransferencia->setCodTransferencia($pedidoTransferenciaModel->generateCodTransferencia());

        $current_user = $this->getCurrentUser()->getNumcgm();
        $cgmAlmoxarife = $entityManager->getRepository(Almoxarifado\Almoxarife::class)->findOneBy([
            'cgmAlmoxarife' => $current_user
        ]);
        $pedidoTransferencia->setFkAlmoxarifadoAlmoxarife($cgmAlmoxarife);
    }
}
