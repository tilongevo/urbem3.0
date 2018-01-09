<?php

namespace Urbem\FinanceiroBundle\Controller\Tesouraria;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;

/**
 * Financeiro\Tesouraria\Pagamentos controller.
 *
 */
class PagamentosController extends ControllerCore\BaseController
{
    /**
     * Home Pagamentos
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('FinanceiroBundle::Tesouraria/Pagamentos/home.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function permissaoAction(Request $request)
    {
        $codigo = md5(uniqid(rand(), true));

        $parametros = array(
            'titulo' => $this->get('translator')->trans('acessoNegado'),
            'mensagem' => $this->get('translator')->trans('permissaoTerminal'),
            'voltar' => $this->generateUrl('financeiro_tesouraria_pagamentos_home'),
            'codigo' => $codigo
        );

        $this->setBreadCrumb();
        return $this->render('FinanceiroBundle::Tesouraria/OrcamentariaPagamentos/permissao.html.twig', array(
            'parametro' => $parametros
        ));
    }
}
