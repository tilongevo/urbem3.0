<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ModalidadeLancamentoController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class ModalidadeLancamentoBaixaController extends CRUDController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function baixaAction(Request $request)
    {
        $this->em = $this->getDoctrine()->getEntityManager();

        $id = $request->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);

        if (!$object) {
            return $this->redirect($request->server->get('HTTP_REFERER'));
        }

        return $this->editAction();
    }
}
