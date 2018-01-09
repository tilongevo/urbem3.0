<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Model\Economico\ResponsavelTecnicoModel;

/**
 * Class ResponsavelTecnicoController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class ResponsavelTecnicoController extends BaseController
{
    const RESPONSAVEL_TECNICO = 'Profissional';
    const RESPONSAVEL_EMPRESA = 'Empresa';
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function filtroAction(Request $request)
    {
        $this->setBreadCrumb();

        $form = $this->generateForm();
        $form->handleRequest($request);

        $result = ['form' => $form->createView()];
        if ($form->isSubmitted() && $request->getMethod() == 'POST') {
            $request = $request->request->get('form');
            $tipo = $request['responsavelTecnico'];
            if ($tipo == strtolower(self::RESPONSAVEL_TECNICO)) {
                return $this->redirect($this->generateUrl('urbem_tributario_economico_responsavel_tecnico_list'));
            } elseif ($tipo == strtolower(self::RESPONSAVEL_EMPRESA)) {
                return $this->redirect($this->generateUrl('urbem_tributario_economico_responsavel_empresa_list'));
            }
        } else {
            return $this->render(
                'TributarioBundle::Economico/ResponsavelTecnico/filtro.html.twig',
                $result
            );
        }
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function generateForm()
    {
        $tipos =  [
            strtolower(self::RESPONSAVEL_TECNICO) => self::RESPONSAVEL_TECNICO,
            strtolower(self::RESPONSAVEL_EMPRESA) => self::RESPONSAVEL_EMPRESA
        ];
        $tipos = array_flip($tipos);
        $form = $this->createFormBuilder([])
            ->add(
                'responsavelTecnico',
                ChoiceType::class,
                [
                    'label' => 'label.economico.responsavel.tipo',
                    'placeholder' => 'label.selecione',
                    'choices' => $tipos,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->setAction($this->generateUrl('tributario_economico_responsavel_tecnico_home'))
            ->getForm();

        return $form;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getConselhoClasseAction(Request $request)
    {
        $codProfissao = $request->get('codProfissao');
        $em = $this->getDoctrine()->getManager();
        $respModel = new ResponsavelTecnicoModel($em);
        $conselho = $respModel->getProfissao($codProfissao);
        $conselhoClasse = $respModel->getConselhoClasse($conselho->getCodConselho());

        return new JsonResponse($conselhoClasse->getNomConselho());
    }
}
