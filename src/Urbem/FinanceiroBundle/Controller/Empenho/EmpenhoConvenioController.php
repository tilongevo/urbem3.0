<?php

namespace Urbem\FinanceiroBundle\Controller\Empenho;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Urbem\FinanceiroBundle\Form\Empenho\ConvenioType;

class EmpenhoConvenioController extends CRUDController
{
    public function criarVinculoAction(Request $request, $id)
    {
        $this->get('breadcrumb.helper')->generate();

        $convenio = $this->admin->getSubject();

        $form = $this->createForm(ConvenioType::class, $convenio, [
            'user' => $this->getUser(),
            'exercicio' => date('Y'),
            'authorization_checker' => $this->get('security.authorization_checker')
        ]);

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if (true === $form->isSubmitted() && true === $form->isValid()) {
                $this->getDoctrine()->getManager()->persist($form->getData());
                $this->getDoctrine()->getManager()->flush();
            }

            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('empenhoConvenio.alterado'));
        }

        return $this->render('FinanceiroBundle:Empenho/Empenho/Convenio:form.html.twig', [
            'convenio' => $convenio,
            'form' => $form->createView(),
            'id' => $id
        ]);
    }
}
