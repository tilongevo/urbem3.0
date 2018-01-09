<?php

namespace Urbem\FinanceiroBundle\Controller\Orcamento;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Orcamento\Orgao;

/**
 * Class UnidadeController
 * @package Urbem\FinanceiroBundle\Controller\Orcamento
 */
class UnidadeController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function filtroAction(Request $request)
    {
        $this->setBreadCrumb();

        $form = $this->generateForm();
        $form->handleRequest($request);

        $retorno = ['form' => $form->createView()];
        if ($form->isSubmitted() && $request->getMethod() == 'POST') {
            $request = $request->request->get('form');
            return $this->redirect($this->generateUrl('urbem_financeiro_orcamento_unidade_list', array('numOrgao' => $request['orgao'])));
        } else {
            return $this->render(
                'FinanceiroBundle::Orcamento/Unidade/filtro.html.twig',
                $retorno
            );
        }
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    private function generateForm()
    {
        $form = $this->createFormBuilder([])
            ->add(
                'orgao',
                EntityType::class,
                array(
                    'class' => Orgao::class,
                    'label' => false,
                    'required' => true,
                    'choice_value' => 'numOrgao',
                    'placeholder' => 'label.selecione',
                    'query_builder' => function ($em) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->where('o.exercicio = :exercicio');
                        $qb->setParameter('exercicio', $this->getExercicio());
                        $qb->orderBy('o.numOrgao', 'ASC');
                        return $qb;
                    },
                    'attr' => array(
                        'class' => 'select2-parameters '
                    ),
                )
            )
            ->setAction($this->generateUrl('financeiro_orcamento_unidade_filtro'))
            ->getForm();

        return $form;
    }
}
