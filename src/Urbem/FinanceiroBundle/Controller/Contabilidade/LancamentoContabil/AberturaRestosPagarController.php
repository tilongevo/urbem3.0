<?php

namespace Urbem\FinanceiroBundle\Controller\Contabilidade\LancamentoContabil;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Contabilidade\ContaCredito;
use Urbem\CoreBundle\Entity\Contabilidade\ContaDebito;
use Urbem\CoreBundle\Entity\Contabilidade\ValorLancamento;
use Urbem\CoreBundle\Model\Contabilidade\LancamentoModel;
use Urbem\CoreBundle\Model\Contabilidade\LoteModel;

class AberturaRestosPagarController extends BaseController
{
    public function indexAction(Request $request)
    {
        $this->setBreadCrumb();

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('contabilidade_lancamento_contabil_abertura_restos_pagar'))
            ->getForm();

        $form->handleRequest($request);

        $lancamentoModel = new LancamentoModel($this->getDoctrine()->getManager());

        $canGenerate = $lancamentoModel->podeGerarAberturaRestosPagar($this->getExercicio());
        $message = ($canGenerate ? 'label.AberturaRestosPagar.mensagem.permitido' : 'label.AberturaRestosPagar.mensagem.naoPermitido');

        if (true === $canGenerate && true === $form->isSubmitted() && true === $form->isValid()) {
            $response = [
                'type' => 'error',
                'message' => 'label.AberturaRestosPagar.mensagem.naoGerado'
            ];
            try {
                if ($lancamentoModel->gerarAberturaRestosPagar($this->getExercicio())) {
                    $response['type'] = 'success';
                    $response['message'] = 'label.AberturaRestosPagar.mensagem.gerado';
                }
            } catch (\Exception $e) {
            }

            $this->container->get('session')->getFlashBag()->add($response['type'], $this->get('translator')->trans($response['message']));
        }

        return $this->render('FinanceiroBundle::Contabilidade/LancamentoContabil/AberturaRestosPagar/index.html.twig', [
            'form' => $form->createView(),
            'message' => $this->get('translator')->trans($message),
            'canGenerate' => $canGenerate
        ]);
    }
}
