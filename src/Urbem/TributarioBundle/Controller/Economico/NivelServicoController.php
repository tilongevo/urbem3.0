<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Economico\NivelServico;
use Urbem\CoreBundle\Entity\Economico\VigenciaServico;
use Urbem\CoreBundle\Model\Economico\NivelServicoModel;

/**
 * Class NivelServicoController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class NivelServicoController extends BaseController
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
            return $this->redirect($this->generateUrl('urbem_tributario_economico_nivel_servico_list', array('codVigencia' => $request['fkEconomicoVigenciaServico'])));
        } else {
            return $this->render(
                'TributarioBundle::Economico/NivelServico/filtro.html.twig',
                $retorno
            );
        }
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function isNivelSuperiorAction(Request $request)
    {
        $nivelServicoField = $request->query->get('nivel');
        list($codNivel, $nomNivel) = explode('-', $nivelServicoField);
        $em = $this->getDoctrine()->getManager();
        $nivel = $em->getRepository(NivelServico::class)
            ->findOneBy(['codNivel' => trim($codNivel), 'nomNivel' => trim($nomNivel)]);
        if ($nivel) {
            $niveis = $em->getRepository(NivelServico::class)
                ->findByCodVigencia($nivel->getCodVigencia());
            foreach ($niveis as $key => $n) {
                if ($n->getCodNivel() == $nivel->getCodNivel()) {
                    if ($key == 0) {
                        return new JsonResponse(true);
                    } else {
                        return new JsonResponse(false);
                    }
                }
            }
        }
        return new JsonResponse(false);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getNivelSuperiorAction(Request $request)
    {
        $codVigencia = $request->get('codVigencia');

        $em = $this->getDoctrine()->getManager();
        $nivelSuperiorModel =  new NivelServicoModel($em);
        $nivelSuperior = $nivelSuperiorModel->getNivelSuperior($codVigencia);

        return $this->returnJsonResponse($nivelSuperior->getNomNivel());
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    private function generateForm()
    {
        $form = $this->createFormBuilder([])
            ->add(
                'fkEconomicoVigenciaServico',
                EntityType::class,
                array(
                    'class' => VigenciaServico::class,
                    'label' => false,
                    'required' => true,
                    'choice_value' => 'codVigencia',
                    'placeholder' => 'label.selecione',
                    'attr' => array(
                        'class' => 'select2-parameters '
                    ),
                )
            )
            ->setAction($this->generateUrl('urbem_tributario_economico_nivel_servico_filtro'))
            ->getForm();

        return $form;
    }
}
