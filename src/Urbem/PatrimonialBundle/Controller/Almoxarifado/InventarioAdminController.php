<?php

namespace Urbem\PatrimonialBundle\Controller\Almoxarifado;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\InventarioModel;

class InventarioAdminController extends CRUDController
{
    public function processarInventarioAction(Request $request)
    {
        list($exercicio, $codAlmoxarifado, $codInventario) = explode("~", $request->get('id'));
        $entityManager = $this->getDoctrine()->getManager();

        /** @var Almoxarifado\Inventario $inventario */
        $inventario = $entityManager
            ->getRepository(Almoxarifado\Inventario::class)
            ->findOneBy([
                'exercicio' => $exercicio,
                'codInventario' => $codInventario,
                'codAlmoxarifado' => $codAlmoxarifado
            ]);

        $inventarioModel = new InventarioModel($entityManager);
//        $isProcessadoSaida = $inventarioModel->processarInventario($inventario, $this->getUser(), 'S');
        $isProcessado = $inventarioModel->processarInventario($inventario, $this->getUser(), 'E');

        $container = $this->container;

        if (!$isProcessado) {
            $message = $this->admin->trans('inventario.processar.naoProcessado', [], 'flashes');

            $container->get('session')->getFlashBag()->add('error', $message);
            $status = 302;
        } else {
            $message = $this->admin->trans('inventario.processar.processado', [], 'flashes');

            $container->get('session')->getFlashBag()->add('success', $message);
            $status = 201;
        }

        return $this->redirectToRoute(
            'urbem_patrimonial_almoxarifado_inventario_show',
            ['id' => $request->get('id')],
            $status
        );
    }
}
