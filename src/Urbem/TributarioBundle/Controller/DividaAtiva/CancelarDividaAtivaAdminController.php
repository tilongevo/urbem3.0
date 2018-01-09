<?php

namespace Urbem\TributarioBundle\Controller\DividaAtiva;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Divida\DividaAtiva;

/**
 * Class CancelarDividaAtivaAdminController
 * @package Urbem\TributarioBundle\Controller\DividaAtiva
 */
class CancelarDividaAtivaAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function detalheAction(Request $request)
    {
        $this->admin->setBreadCrumb();

        $em = $this->getDoctrine()->getManager();

        if (!$request->get('dividaAtiva')) {
            $redirectUrl = $this->generateUrl('urbem_tributario_divida_ativa_cancelar_divida_ativa_create', $object);

            return (new RedirectResponse($redirectUrl, RedirectResponse::HTTP_TEMPORARY_REDIRECT))->send();
        }

        list($exercicio, $codInscricao) = explode('~', $request->get('dividaAtiva'));
        $dividaAtiva = $em->getRepository(DividaAtiva::class)->findOneBy(['codInscricao' => $codInscricao, 'exercicio' => $exercicio]);
        if (!$dividaAtiva) {
            $redirectUrl = $this->generateUrl('urbem_tributario_divida_ativa_cancelar_divida_ativa_create', $object);

            return (new RedirectResponse($redirectUrl, RedirectResponse::HTTP_TEMPORARY_REDIRECT))->send();
        }

        $this->admin->emitirDocumentos($dividaAtiva);

        return $this->render(
            'TributarioBundle::DividaAtiva/CancelarDividaAtiva/lista_downloads.html.twig',
            [
                'admin' => $this->admin,
                'dividaAtiva' => $dividaAtiva,
            ]
        );
    }
}
