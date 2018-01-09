<?php

namespace Urbem\TributarioBundle\Controller\Arrecadacao;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Arrecadacao\TabelaConversao;
use Urbem\CoreBundle\Repository\Arrecadacao\TabelaConversaoRepository;

/**
 * Class RecadastrarTabelaConversaoController
 * @package Urbem\TributarioBundle\Controller\Arrecadacao
 */
class RecadastrarTabelaConversaoController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function indexAction(Request $request)
    {
        $this->setBreadCrumb();

        $data = array();
        $form = $this->generateForm($data);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $request->getMethod() == 'POST') {
            $container = $this->container;

            $formData = $request->request->get('form');

            $em = $this->getDoctrine()->getManager();

            // Valida se o exercicio destino já está cadastrado
            $tabelas = $em->getRepository(TabelaConversao::class)
                ->findBy(array('exercicio' => $formData['exercicioDestino']));

            if (count($tabelas)) {
                $container->get('session')->getFlashBag()
                    ->add('error', $this->get('translator')->trans('label.recadastrarTabelaConversao.erro'));
            } else {
                $filters = array();

                $filters['exercicio'] = $formData['exercicioOrigem'];
                if ($formData['tabela'] != 9999) {
                    $filters['codTabela'] = $formData['tabela'];
                }

                try {
                    $tabelas = $em->getRepository(TabelaConversao::class)
                        ->findBy($filters);

                    foreach ($tabelas as $tabela) {
                        $newTabela = clone $tabela;
                        $newTabela->setExercicio($formData['exercicioDestino']);

                        foreach ($tabela->getFkArrecadacaoTabelaConversaoValoreses() as $tabelaConversaoValores) {
                            $newTabelaConversaoValores = clone $tabelaConversaoValores;
                            $newTabelaConversaoValores->setFkArrecadacaoTabelaConversao($newTabela);

                            $newTabela->addFkArrecadacaoTabelaConversaoValoreses($newTabelaConversaoValores);
                        }

                        $em->persist($newTabela);
                    }
                    $em->flush();

                    $container->get('session')->getFlashBag()
                        ->add('success', $this->get('translator')->trans('label.recadastrarTabelaConversao.sucesso'));
                } catch (\Exception $e) {
                    $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.recadastrarTabelaConversao.erro'));
                    throw $e;
                }

                return $this->redirect($this->generateUrl('tributario_arrecadacao_conversao_valores_recadastrar_tabela_conversao'));
            }
        }

        return $this->render(
            'TributarioBundle::Arrecadacao/ConversaoValores/RecadastrarTabelaConversao/index.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @param $data
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    private function generateForm($data)
    {
        $em = $this->getDoctrine()->getManager();

        $exercicios = $em->getRepository(TabelaConversao::class)
            ->getDistinctExercicios();

        $form = $this->createFormBuilder($data)
            ->add(
                'exercicioOrigem',
                EntityType::class,
                array (
                    'class' => TabelaConversao::class,
                    'label' => 'label.recadastrarTabelaConversao.exercicioOrigem',
                    'required' => true,
                    'placeholder' => 'label.selecione',
                    'attr' => array(
                        'class' => 'select2-parameters ',
                    ),
                    'choices' => $exercicios,
                )
            )
            ->add(
                'tabela',
                ChoiceType::class,
                array (
                    'choices' => array(),
                    'required' => true,
                    'label' => 'label.recadastrarTabelaConversao.tabela',
                )
            )
            ->add(
                'exercicioDestino',
                TextType::class,
                array (
                    'required' => true,
                    'label' => 'label.recadastrarTabelaConversao.exercicioDestino',
                )
            )
            ->setAction($this->generateUrl('tributario_arrecadacao_conversao_valores_recadastrar_tabela_conversao'))
            ->getForm();

        return $form;
    }
}
