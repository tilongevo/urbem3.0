<?php

namespace Urbem\FinanceiroBundle\Controller\Ppa;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;

class ConfiguracaoController extends BaseController
{
    const PARAMETRO_FONTES_RECURSO = 'fontes_recurso';
    /**
     * Home
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('FinanceiroBundle::Ppa/Configuracao/home.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function parametrosAction(Request $request)
    {
        $this->setBreadCrumb();

        $em = $this->getDoctrine()->getEntityManager();
        $configuracaoModel = new ConfiguracaoModel($em);

        $data = false;
        $fontesRecurso = $configuracaoModel->pegaConfiguracao(self::PARAMETRO_FONTES_RECURSO, Modulo::MODULO_PPA, $this->getExercicio());
        if (count($fontesRecurso)) {
            if ($fontesRecurso[0]['valor'] == 'true') {
                $data = true;
            }
        }

        $form = $this->createFormBuilder([])
            ->add(
                'fontesRecurso',
                CheckboxType::class,
                array(
                    'label' => 'label.configuracaoPpa.habilitarFonteRecurso',
                    'required' => false,
                    'data' => $data
                )
            )
            ->setAction($this->generateUrl('financeiro_ppa_parametros'))
            ->getForm();

        $form->handleRequest($request);

        $retorno = ['form' => $form->createView()];
        if ($form->isSubmitted() && $request->getMethod() == 'POST') {
            $request = $request->request->get('form');
            $valor = (isset($request['fontesRecurso'])) ? 'true' : 'false';
            $retorno = $configuracaoModel
                ->salvarConfiguracaoPpa(
                    self::PARAMETRO_FONTES_RECURSO,
                    Modulo::MODULO_PPA,
                    $this->getExercicio(),
                    $valor
                );
            $container = $this->container;
            if ($retorno === true) {
                $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.configuracaoPpa.msgSucesso'));
                return $this->redirect($this->generateUrl('financeiro_ppa_parametros'));
            } else {
                $container->get('session')->getFlashBag()->add('error', 'contactSupport');
                $container->get('session')->getFlashBag()->add('error', $retorno->getMessage());
                return $this->redirect($this->generateUrl('financeiro_ppa_parametros'));
            }
        } else {
            return $this->render(
                'FinanceiroBundle::Ppa/Configuracao/fonteRecurso.html.twig',
                $retorno
            );
        }
    }
}
