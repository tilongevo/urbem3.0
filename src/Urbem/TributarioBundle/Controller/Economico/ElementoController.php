<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Economico\BaixaElemento;

class ElementoController extends BaseController
{
    /**
     * @param Request $request
     */
    public function baixarAction(Request $request)
    {
        $container = $this->container;
        $em = $this->getDoctrine()->getManager();

        try {
            $dataForm = $request->request->all();

            $codElemento = $dataForm['elemento_id'];

            $baixaElemento = new BaixaElemento();
            $baixaElemento->setCodElemento($codElemento);
            $baixaElemento->setMotivo($dataForm['baixar']['motivo']);
            $baixaElemento->setTimestamp(new \DateTime());

            $em->persist($baixaElemento);
            $em->flush();

            (new RedirectResponse("/tributario/cadastro-economico/elemento/list"))->send();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.economicoElemento.erroBaixar'));
            throw $e;
        }
    }
}
