<?php

namespace Urbem\FinanceiroBundle\Controller\Contabilidade\LancamentoContabil;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Model\Contabilidade\LancamentoModel;

class SaldoBalancoController extends BaseController
{
    public function indexAction(Request $request)
    {
        $this->setBreadCrumb();

        $data = array();
        $form = $this->generateForm($data);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $request->getMethod() == 'POST') {
            $container = $this->container;

            $em = $this->getDoctrine()->getManager();

            $lancamentoModel = new LancamentoModel($em);
            $lancamentoModel->gerarSaldosBalanco($this->getExercicio());

            $container->get('session')->getFlashBag()->add('success', 'Saldo de balanço efetuado com sucesso.');
        }

        return $this->render(
            'FinanceiroBundle::Contabilidade/LancamentoContabil/SaldoBalanco/index.html.twig',
            array('form' => $form->createView())
        );
    }

    private function generateForm($data)
    {
        $form = $this->createFormBuilder($data)
            ->setAction($this->generateUrl('contabilidade_lancamento_contabil_saldo_balanco'))
            ->getForm();

        return $form;
    }
}
