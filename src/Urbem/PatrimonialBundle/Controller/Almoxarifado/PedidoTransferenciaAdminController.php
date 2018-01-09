<?php
namespace Urbem\PatrimonialBundle\Controller\Almoxarifado;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\ORMException;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Urbem\CoreBundle\Entity\Administracao;
use Urbem\CoreBundle\Entity\Almoxarifado;

use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\LancamentoMaterialModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\NaturezaLancamentoModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\PedidoTransferenciaModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\TransferenciaAlmoxarifadoItemModel;

/**
 * Class PedidoTransferenciaAdminController
 * @package Urbem\PatrimonialBundle\Controller\Almoxarifado
 */
class PedidoTransferenciaAdminController extends Controller
{
    public function anularPedidoTransferenciaAction(Request $request)
    {
        list($exercicio, $codTransferencia) = explode('~', $request->attributes->get('id'));
        $em = $this->getDoctrine()->getManager();

        try {
            $pedidoTransferencia = $em
                ->getRepository(Almoxarifado\PedidoTransferencia::class)
                ->findOneBy([
                    'codTransferencia' => $codTransferencia,
                    'exercicio' => $exercicio
                ]);

            $ptModel = new PedidoTransferenciaModel($em);
            $ptModel->anularPedidoTransferencia($pedidoTransferencia);

            $message = $this->admin->trans('patrimonial.almoxarifado.pedidoTransferencia.anular', [], 'flashes');
            $this->container->get('session')
                ->getFlashBag()
                ->add('success', $message);

        } catch (UniqueConstraintViolationException $e) {
            $message = $this->admin->trans('pedido_transferencia.errors.ja_anulado', [], 'validators');
            $this->container->get('session')
                ->getFlashBag()
                ->add('error', $message);

        } catch (\Exception $e) {
            $message = $this->admin->trans('pedido_transferencia.errors.anulacao', [], 'validators');
            $this->container->get('session')
                ->getFlashBag()
                ->add('error', $message);
        }

        (new RedirectResponse($request->headers->get('referer')))->send();
    }

    /**
     * Processa todos os PedidoTransferenciaItem dentro de PedidoTransferencia
     * efetuando a transferência de itens de um Almoxarifado para outro
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function processarPedidosAction(Request $request)
    {
        $objectId = $this->getRequest()->get('id');
        $tipoNatureza = $this->getRequest()->get('tipoNatureza');

        $objectIds['exercicio'] = explode('~', $objectId)[0];
        $objectIds['codTransferencia'] = explode('~', $objectId)[1];

        $entityManager = $this->getDoctrine()->getEntityManager();

        $naturezaLancamentoModel = new NaturezaLancamentoModel($entityManager);
        $lancamentoMaterialModel = new LancamentoMaterialModel($entityManager);
        $transferenciaAlmoxarifadoItemModel = new TransferenciaAlmoxarifadoItemModel($entityManager);

        /** @var Almoxarifado\PedidoTransferencia $pedidoTransferencia */
        $pedidoTransferencia = $entityManager
            ->getRepository(Almoxarifado\PedidoTransferencia::class)
            ->find($objectIds);

        /** @var Administracao\Usuario $usuario */
        $usuario = $this->getUser();

        try {
            $naturezaLancamento =
                $naturezaLancamentoModel->buildOne($usuario->getFkSwCgm(), $objectIds['exercicio'], $tipoNatureza, 2);

            $pedidoTransferenciaItens = $pedidoTransferencia->getFkAlmoxarifadoPedidoTransferenciaItens();

            $naturezaLancamentoModel->save($naturezaLancamento);

            /** @var Almoxarifado\PedidoTransferenciaItem $pedidoTransferenciaItem */
            foreach ($pedidoTransferenciaItens as $pedidoTransferenciaItem) {
                $lancamentoMaterial = $lancamentoMaterialModel
                    ->buildOneBasedPedidoTransferenciaItem($pedidoTransferenciaItem, $naturezaLancamento);

                $transferenciaAlmoxarifadoItem = $transferenciaAlmoxarifadoItemModel
                    ->buildOneBasedPedidoTransferenciaItem($pedidoTransferenciaItem, $lancamentoMaterial);
            }

            $message = $this->admin->trans('saidaTransferencia.transferencia.success', [], 'flashes');

            $this->container->get('session')
                ->getFlashBag()
                ->add('success', $message);
        } catch (ORMException $exception) {
            $message = $this->admin->trans('saidaTransferencia.transferencia.error', [
                '%errorMessage%' => $exception->getMessage()
            ], 'flashes');

            $this->container->get('session')
                ->getFlashBag()
                ->add('error', $message);
        }

        return $this->redirectToRoute('urbem_patrimonial_almoxarifado_saida_transferencia_list');
    }
}
