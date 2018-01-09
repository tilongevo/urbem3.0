<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Urbem\CoreBundle\Model\Folhapagamento\FeriasEventoModel;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;

class FeriasEventoAdminController extends Controller
{
    /**
     * {@inheritdoc}
     */
    protected function preCreate(Request $request, $object)
    {
        if ($request->getMethod() === "POST") {
            $entityManager = $this
            ->get('doctrine')
            ->getManager();

            $formData = $request->request->get($request->query->get('uniqid'));
            
            try {
                $feriasEventoModel = new FeriasEventoModel($entityManager);
                $feriasEventoModel->persistFeriasEvento($formData, $object, $this->admin->getModelManager());
                $this->addFlash('sonata_flash_success', 'flash_edit_success');
            } catch (\Exception $e) {
                $this->addFlash('sonata_flash_error', 'flash_edit_error');
            }
            return $this->redirectToRoute('urbem_recursos_humanos_folha_pagamento_configurar_ferias_create');
        }
    }
}
