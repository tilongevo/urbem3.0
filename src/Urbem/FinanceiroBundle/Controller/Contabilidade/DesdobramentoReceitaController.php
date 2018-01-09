<?php

namespace Urbem\FinanceiroBundle\Controller\Contabilidade;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Orcamento\Receita;

/**
 * Class DesdobramentoReceitaController
 * @package Urbem\FinanceiroBundle\Controller\Contabilidade
 */
class DesdobramentoReceitaController extends BaseController
{

    public function filtroAction(Request $request)
    {
        $this->setBreadCrumb();

        $form = $this->generateForm();
        $form->handleRequest($request);

        $result = ['form' => $form->createView()];
        if ($form->isSubmitted() && $request->getMethod() == 'POST') {
            $request = $request->request->get('form');
            return $this->redirect($this->generateUrl('urbem_financeiro_contabilidade_configuracao_desdobramento_receita_list', array('codReceita' => $request['receita'])));
        } else {
            return $this->render(
                'FinanceiroBundle::Contabilidade/Configuracao/DesdobramentoReceita/filtro.html.twig',
                $result
            );
        }
    }

    private function generateForm()
    {
        $form = $this->createFormBuilder([])
            ->add(
                'receita',
                EntityType::class,
                [
                    'class' => Receita::class,
                    'label' => false,
                    'choice_value' => 'codReceita',
                    'placeholder' => 'label.selecione',
                    'query_builder' => function ($em) {
                        $qb = $em->createQueryBuilder('r');
                        $qb->where('r.exercicio = :exercicio');
                        $qb->setParameter('exercicio', $this->getExercicio());
                        $qb->orderBy('r.codReceita', 'ASC');
                        return $qb;
                    },
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->setAction($this->generateUrl('financeiro_contabilidade_configuracao_desdobramento_receita_filtro'))
            ->getForm();

        return $form;
    }
}
