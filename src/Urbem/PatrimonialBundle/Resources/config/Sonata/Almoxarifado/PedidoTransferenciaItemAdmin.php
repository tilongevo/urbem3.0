<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\PedidoTransferenciaItemDestinoModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\PedidoTransferenciaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Urbem\CoreBundle\Entity\Almoxarifado;

use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\RequisicaoItemModel;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;

/**
 * Class PedidoTransferenciaItemAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado
 */
class PedidoTransferenciaItemAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_pedido_transferencia_item';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/pedido-transferencia-item';

    protected $includeJs = [
        '/patrimonial/javascripts/almoxarifado/pedido-transferencia-item.js',
    ];

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add(
            'get_centro_custo_destino',
            'get-centro-custo-destino/'
        );

        $collection->remove('batch');
        $collection->remove('show');
        $collection->remove('export');
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $pedidoTransferenciaItem
     */
    public function validate(ErrorElement $errorElement, $pedidoTransferenciaItem)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());

        if (is_numeric($formData['saldo']) && $formData['saldo'] < $pedidoTransferenciaItem->getQuantidade()) {
            $message = $this->trans('pedido_transferencia_item.errors.quantidadeMaiorQueOSaldo', [], 'validators');

            $errorElement->with('saldo')->addViolation($message)->end();
        }
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $compositeIdPedidoTransferencia = $this->getAdminRequestId();
            /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $exercicio = '';
        $codTransferencia = '';

        $disabled = '';
        $disabledMarca = '';
        $dataSaldo = '';
        $dataItem = '';

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $codTransferencia = $formData['codTransferencia'];
            $exercicio = $formData['exercicio'];
            $compositeIdPedidoTransferencia = $formData['exercicio'].'~'.$formData['codTransferencia'];
        } else {
            $compositeIdPedidoTransferencia = $this->getRequest()->get('codTransferencia');
        }

        if (sprintf('%s_edit', $this->baseRouteName) == $this->getRequest()->get('_sonata_name')) {
            $objectId = $this->getAdminRequestId();
            $this->setBreadCrumb(['id' => $objectId]);

            /** @var Almoxarifado\PedidoTransferenciaItem $pedidoTransferenciaItem */
            $pedidoTransferenciaItem = $this->getObject($objectId);
            $pedidoTransferencia = $pedidoTransferenciaItem->getFkAlmoxarifadoPedidoTransferencia();

            $codTransferencia = $pedidoTransferencia->getCodTransferencia();
            $exercicio = $pedidoTransferencia->getExercicio();

            $stParametro = 'demonstrar_saldo_estoque';
            $inCodModulo = Modulo::MODULO_PATRIMONIAL_ALMOXARIFADO;
            $inExercicio = $this->getExercicio();

            $quantidade = $pedidoTransferenciaItem->getQuantidade();

            $configuracaoModel = new ConfiguracaoModel($em);
            $saldo = $configuracaoModel->pegaConfiguracao($stParametro, $inCodModulo, $inExercicio);

            $dados['saldo'] = $saldo[0]['valor'];

            $requisicaoItemModel = new RequisicaoItemModel($em);

            if ($dados['saldo'] == true) {
                $val = $requisicaoItemModel->getSaldoEstoque(
                    $pedidoTransferenciaItem->getCodMarca(),
                    $pedidoTransferenciaItem->getCodItem(),
                    $pedidoTransferencia->getFkAlmoxarifadoAlmoxarifado()->getCodAlmoxarifado(),
                    $pedidoTransferenciaItem->getCodCentro()
                );

                $valorSaldo = $val[0]['saldo_estoque'] - $quantidade;
            } else {
                $valorSaldo = 'Configuração não permite a exibição do saldo de estoque.';
            }

            $dados['valor_saldo'] = $valorSaldo;

            $dataSaldo = $dados['valor_saldo'];

           //Catalogo Item
            $disabled = 'disabled';
            $codItem = $this->getSubject()->getCodItem();
            $catalogoItemModel = new CatalogoItemModel($em);
            /** @var Almoxarifado\CatalogoItem $pedidoTransferenciaItemDestino */
            $dataItem = $catalogoItemModel
                ->getOneByCodItem($codItem);
        } else {
            list($exercicio, $codTransferencia) = explode('~', $compositeIdPedidoTransferencia);
            $this->setBreadCrumb();

            $pedidoTransferencia = [
                'exercicio' => $exercicio,
                'codTransferencia' => $codTransferencia
            ];

            $pedidoTransferenciaModel = new PedidoTransferenciaModel($em);
            $pedidoTransferencia = $pedidoTransferenciaModel->find($pedidoTransferencia);
        }

        $codHAlmoxarifado = $pedidoTransferencia->getFkAlmoxarifadoAlmoxarifado()->getCodAlmoxarifado();
        $codDAlmoxarifado = $pedidoTransferencia->getFkAlmoxarifadoAlmoxarifado1()->getCodAlmoxarifado();

        $fieldOptions = [];

        $fieldOptions['codItem'] = [
            'attr' => ['class' => 'select2-parameters '],
            'route' => ['name' => 'nota_transferencia_item_catalogo_item'],
            'req_params' => [
                'codTransferencia' => $pedidoTransferencia->getCodTransferencia()
            ],
            'label' => 'label.almoxarifado.requisicao.itensItem',
            'required' => true,
            'placeholder' => 'Selecione',
            'disabled' => $disabled,
            'data' => $dataItem
        ];

        $fieldOptions['codCentro'] = [
            'attr' => ['class' => 'select2-parameters init-readonly '],
            'choice_label' => function (Almoxarifado\CentroCusto $centroCusto) {
                return sprintf('%d - %s', $centroCusto->getCodCentro(), $centroCusto->getDescricao());
            },
            'label' => 'label.pedidoTransferencia.codCentro',
            'placeholder' => 'Selecione a Marca'
        ];

        $fieldOptions['codMarca'] = [
            'attr' => ['class' => 'select2-parameters init-readonly '],
            'choice_label' => function (Almoxarifado\Marca $marca) {
                return sprintf('%d - %s', $marca->getCodMarca(), $marca->getDescricao());
            },
            'label' => 'label.pedidoTransferencia.codMarca',
            'placeholder' => 'Selecione o Item'
        ];

        $fieldOptions['codCentroDestino'] = [
            'attr' => ['class' => 'select2-parameters init-readonly '],
            'class' => 'CoreBundle:Almoxarifado\CentroCusto',
            'choice_label' => function (Almoxarifado\CentroCusto $centroCusto) {
                return sprintf('%d - %s', $centroCusto->getCodCentro(), $centroCusto->getDescricao());
            },
            'label' => 'label.pedidoTransferencia.codCentroDestino',
            'placeholder' => 'Selecione o Item',
            'mapped' => false
        ];

        $fieldOptions['saldo'] = [
            'attr' => [
                'readonly' => true,
                'class' => 'quantity '
            ],
            'label' => 'label.pedidoTransferencia.saldoEstoque',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['codTransferencia']['data'] = $codTransferencia;
        $fieldOptions['exercicio']['data'] = $exercicio;

        $fieldOptions['quantidade'] = [
            'label' => 'label.pedidoTransferencia.quantidade',
            'attr' => ['class' => 'quantity ']
        ];

        if ($this->id($this->getSubject())) {
            /** @var Almoxarifado\PedidoTransferenciaItemDestino $pedidoTransferenciaItemDestino */
            $pedidoTransferenciaItemDestino = $em->getRepository(Almoxarifado\PedidoTransferenciaItemDestino::class)->findOneBy([
                'exercicio' => $pedidoTransferenciaItem->getExercicio(),
                'codTransferencia' => $pedidoTransferenciaItem->getCodTransferencia(),
                'codItem' => $pedidoTransferenciaItem->getCodItem(),
                'codMarca' => $pedidoTransferenciaItem->getCodMarca(),
                'codCentro' => $pedidoTransferenciaItem->getCodCentro()
            ]);

            $fieldOptions['codCentroDestino']['data'] = $pedidoTransferenciaItemDestino->getFkAlmoxarifadoCentroCusto();
        }

        $formMapper
            ->with('label.pedidoTransferencia.dadosItem')
                ->add('codTransferencia', 'hidden', $fieldOptions['codTransferencia'])
                ->add('exercicio', 'hidden', $fieldOptions['exercicio'])
                ->add('codHAlmoxarifado', 'hidden', [
                    'data' => $codHAlmoxarifado,
                    'mapped' => false
                ])
                ->add('codDAlmoxarifado', 'hidden', [
                    'data' => $codDAlmoxarifado,
                    'mapped' => false
                ])
                ->add('cgmHSolicitante', 'hidden', [
                    'data' => $this->getCurrentUser()->getNumcgm(),
                    'mapped' => false
                ])
                ->add('codItem', 'autocomplete', $fieldOptions['codItem'])
                ->add('fkAlmoxarifadoMarca', null, $fieldOptions['codMarca'])
                ->add('fkAlmoxarifadoCentroCusto', null, $fieldOptions['codCentro'])
            ->end()
            ->with('label.pedidoTransferencia.quantidade')
                ->add('saldo', 'text', $fieldOptions['saldo'])
                ->add('quantidade', 'number', $fieldOptions['quantidade'])
            ->end()
            ->with('label.pedidoTransferencia.codCentroDestino')
                ->add('codCentroDestino', 'entity', $fieldOptions['codCentroDestino'])
            ->end();
    }

    /**
     * @param Almoxarifado\PedidoTransferenciaItem $pedidoTransferenciaItem
     */
    public function saveRelationships($pedidoTransferenciaItem)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $formData = $this->getRequest()->request->get($this->getUniqid());

        $pedidoTransferencia = $pedidoTransferenciaItem->getFkAlmoxarifadoPedidoTransferencia();

        // Caso seja uma criaçao, obviamente este valor sera null
        if (is_null($pedidoTransferencia)) {
           //PedidoTransferencia
            $pedidoTransferenciaModel = new PedidoTransferenciaModel($em);
            $pedidoTransferencia = $pedidoTransferenciaModel->find([
                'exercicio' => $formData['exercicio'],
                'codTransferencia' => $formData['codTransferencia']
            ]);
            $pedidoTransferenciaItem->setFkAlmoxarifadoPedidoTransferencia($pedidoTransferencia);

           //PedidoTransferenciaItemDestino
            /** @var Almoxarifado\CentroCusto $pedidoTransferenciaItemDestino */
            $centroCusto = $this->getForm()->get('codCentroDestino')->getData();
            $pedidoTransferenciaItemDestinoModel = new PedidoTransferenciaItemDestinoModel($em);
            /** @var Almoxarifado\PedidoTransferenciaItemDestino $pedidoTransferenciaItemDestino */
            $pedidoTransferenciaItemDestino = $pedidoTransferenciaItemDestinoModel
                ->buildBasedPedidoTransferenciaItemCentroCusto($pedidoTransferenciaItem, $centroCusto);
            $pedidoTransferenciaItem
                ->addFkAlmoxarifadoPedidoTransferenciaItemDestinos($pedidoTransferenciaItemDestino);

           //Catalogo Item
            $codItem = $this->getForm()->get('codItem')->getData();
            $catalogoItemModel = new CatalogoItemModel($em);
            /** @var Almoxarifado\CatalogoItem $pedidoTransferenciaItemDestino */
            $catalogoItem = $catalogoItemModel
                ->getOneByCodItem($codItem);
            $pedidoTransferenciaItem->setFkAlmoxarifadoCatalogoItem($catalogoItem);
        }
    }

    /**
     * @param Almoxarifado\PedidoTransferenciaItem $pedidoTransferenciaItem
     */
    public function prePersist($pedidoTransferenciaItem)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $this->saveRelationships($pedidoTransferenciaItem);
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect("/almoxarifado/pedido-transferencia-item/create?codTransferencia={$this->getAdminRequestId()}");
        }
    }

    /**
     * @param Almoxarifado\PedidoTransferenciaItem $pedidoTransferenciaItem
     */
    public function preUpdate($pedidoTransferenciaItem)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $this->saveRelationships($pedidoTransferenciaItem);
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_EDIT_DATA);
            $this->forceRedirect("/almoxarifado/pedido-transferencia-item/{$this->getAdminRequestId()}/edit");
        }
    }

    /**
     * @param Almoxarifado\PedidoTransferenciaItem $pedidoTransferenciaItem
     * @param $message
     */
    public function redirect($pedidoTransferenciaItem, $message)
    {
        $pedidoTransferencia = $pedidoTransferenciaItem->getFkAlmoxarifadoPedidoTransferencia()->getCodTransferencia();
        $exercicio = $pedidoTransferenciaItem->getExercicio();

        $container = $this->getConfigurationPool()->getContainer();
        $message = $this->trans($message, [], 'flashes');
        $container->get('session')->getFlashBag()->add('success', $message);

        $this->forceRedirect("/patrimonial/almoxarifado/pedido-transferencia/{$exercicio}~{$pedidoTransferencia}/show");
    }

    /**
     * @param Almoxarifado\PedidoTransferenciaItem $pedidoTransferenciaItem
     */
    public function postPersist($pedidoTransferenciaItem)
    {
        $this->redirect($pedidoTransferenciaItem, 'patrimonial.almoxarifado.pedidoTransferencia.item.persist');
    }

    /**
     * @param Almoxarifado\PedidoTransferenciaItem $pedidoTransferenciaItem
     */
    public function postUpdate($pedidoTransferenciaItem)
    {
        $this->redirect($pedidoTransferenciaItem, 'patrimonial.almoxarifado.pedidoTransferencia.item.update');
    }

    /**
     * @param Almoxarifado\PedidoTransferenciaItem $pedidoTransferenciaItem
     */
    public function postRemove($pedidoTransferenciaItem)
    {
        $this->redirect($pedidoTransferenciaItem, 'patrimonial.almoxarifado.pedidoTransferencia.item.remove');
    }
}
