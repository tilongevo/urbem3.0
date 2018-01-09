<?php

namespace Urbem\TributarioBundle\Controller\DividaAtiva;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Divida\DividaAtiva;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Repository\Tributario\DividaAtiva\EstornarDividaAtivaRepository;

/**
 * Class EstornarDividaAtivaAdminController
 * @package Urbem\TributarioBundle\Controller\DividaAtiva
 */
class EstornarDividaAtivaAdminController extends CRUDController
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
            $redirectUrl = $this->generateUrl('urbem_tributario_divida_ativa_estornar_divida_ativa_create', $object);

            return (new RedirectResponse($redirectUrl, RedirectResponse::HTTP_TEMPORARY_REDIRECT))->send();
        }

        list($exercicio, $codInscricao) = explode('~', $request->get('dividaAtiva'));
        $dividaAtiva = $em->getRepository(DividaAtiva::class)->findOneBy(['codInscricao' => $codInscricao, 'exercicio' => $exercicio]);
        if (!$dividaAtiva) {
            $redirectUrl = $this->generateUrl('urbem_tributario_divida_ativa_estornar_divida_ativa_create', $object);

            return (new RedirectResponse($redirectUrl, RedirectResponse::HTTP_TEMPORARY_REDIRECT))->send();
        }

        $this->admin->emitirDocumentos($dividaAtiva);

        return $this->render(
            'TributarioBundle::DividaAtiva/EstornarDividaAtiva/lista_downloads.html.twig',
            [
                'admin' => $this->admin,
                'dividaAtiva' => $dividaAtiva,
            ]
        );
    }
}
