<?php

namespace Urbem\TributarioBundle\Controller\DividaAtiva;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

/**
 * Class DevedoresReportController
 * @package Urbem\TributarioBundle\Controller\DividaAtiva
 */
class DevedoresReportController extends BaseController
{

    const CREDITO = 'Crédito';
    const GRUPO_CREDITO = 'Grupo Crédito';
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::DividaAtiva/Relatorios/home.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function filtroAction(Request $request)
    {
        $this->setBreadCrumb();

        $form = $this->generateForm();
        $form->handleRequest($request);

        $result = ['form' => $form->createView()];

        if ($form->isSubmitted() && $request->getMethod() == 'POST') {
            $request = $request->request->get('form');
            $tipo = $request['filtro'];
            if ($tipo == strtolower(self::CREDITO)) {
                return $this->redirect($this->generateUrl('urbem_tributario_divida_ativa_relatorio_devedores_credito'));
            } elseif ($tipo == strtolower(self::GRUPO_CREDITO)) {
                return $this->redirect($this->generateUrl('urbem_tributario_divida_ativa_relatorio_devedores_grupo_credito'));
            }
        } else {
            return $this->render('TributarioBundle::DividaAtiva/Relatorios/Devedores/filtro.html.twig', $result);
        }
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function generateForm()
    {
        $tipos =  [
            strtolower(self::GRUPO_CREDITO) => self::GRUPO_CREDITO,
            strtolower(self::CREDITO) => self::CREDITO
        ];
        $tipos = array_flip($tipos);
        $form = $this->createFormBuilder([])
            ->add(
                'filtro',
                ChoiceType::class,
                [
                    'label' => 'label.dividaAtivaDevedoresReport.filtroPor',
                    'placeholder' => 'label.selecione',
                    'choices' => $tipos,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->setAction($this->generateUrl('tributario_divida_ativa_relatorio_devedores_filtro'))
            ->getForm();

        return $form;
    }
}
