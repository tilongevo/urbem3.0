<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Folhapagamento\DecimoEvento;

class CalculoDecimoAdminController extends CalculoSalarioAdminController
{
    /**
     * @return RedirectResponse
     */
    public function listAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $container = $this->container;
        $decimoEvento = $em->getRepository(DecimoEvento::class)->findAll();

        if (empty($decimoEvento)) {
            $container->get('session')->getFlashBag()->add('error', $this->admin->trans('rh.folhas.folhaDecimo.errors.configuracaoInexistente', [], 'validators'));

            return new RedirectResponse(
                $this->redirectToRoute('folha_pagamento_folhas_index')
            );
        }
        return parent::listAction();
    }
}
