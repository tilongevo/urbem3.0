<?php

namespace Urbem\TributarioBundle\Controller\DividaAtiva;

use DateTime;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class EmitirCarneAdminController
 * @package Urbem\TributarioBundle\Controller\DividaAtiva
 */
class EmitirCarneAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filtroAction(Request $request)
    {
        $request->query->set('filtro', 1);

        return parent::createAction();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction()
    {
        $request = $this->getRequest();

        if ($request->get('filtro')) {
            $this->admin->filtro = $request->get($request->get('uniqid'));

            $request->query->set('filtro', 0);
            $request->request->replace([]);

            return parent::createAction();
        }

        $form = $this->admin->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && !$request->get('filtro')) {
            $this->admin->reemitirParcelas();

            return;
        }

        return new RedirectResponse('/tributario/divida-ativa/emissao-documentos/emitir-carne/filtro');
    }
}
