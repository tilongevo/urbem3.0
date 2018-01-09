<?php

namespace Urbem\FinanceiroBundle\Controller\Ldo;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Urbem\CoreBundle\Controller\BaseController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Ldo\TipoIndicadores;

class IndicadoresAdminController extends Controller
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
            return $this->redirect($this->generateUrl('urbem_financeiro_ldo_indicadores_list', array('id' => $request['fkLdoTipoIndicadores'])));
        } else {
            return $this->render(
                'FinanceiroBundle::Ldo/Configuracao/ConfigurarIndicadores/filtro.html.twig',
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
                'fkLdoTipoIndicadores',
                EntityType::class,
                array(
                    'class' => TipoIndicadores::class,
                    'label' => false,
                    'required' => true,
                    'choice_value' => 'codTipoIndicador',
                    'placeholder' => 'label.selecione',
                    'attr' => array(
                        'class' => 'select2-parameters '
                    ),
                )
            )
            ->setAction($this->generateUrl('urbem_financeiro_ldo_indicadores_filtro'))
            ->getForm();

        return $form;
    }
}
