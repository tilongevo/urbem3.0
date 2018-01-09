<?php

namespace Urbem\FinanceiroBundle\Controller\Orcamento\Suplementacao;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Helper;

class SuplementacaoAdminController extends CRUDController
{
    protected $breadcrumb;

    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);
        $this->breadcrumb = $this->get("white_october_breadcrumbs");
    }

    public function anularAction(Request $request)
    {
        $id = $this->admin->getIdParameter();
        $this->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));

        $container = $this->container;

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        try {
            $ids = $request->get($this->admin->getIdParameter());

            $form = $this->createForm('Urbem\FinanceiroBundle\Form\Orcamento\Suplementacao\AnularType', null, array( 'action' => $this->generateUrl('financeiro_orcamento_suplementacao_anular')));
            $form->handleRequest($request);

            return $this->render('FinanceiroBundle::Orcamento/CreditoSuplementar/anular.html.twig', array(
                'suplementacao' => $ids,
                'form' => $form->createView(),
                'errors' => $form->getErrors()
            ));
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', 'Erro ao anular a suplementação.');
            throw $e;
        }
    }

    public function setBreadCrumb($param = [], $route = null)
    {
        $entityManager = $this->getDoctrine()->getManager();

        Helper\BreadCrumbsHelper::getBreadCrumb(
            $this->get("white_october_breadcrumbs"),
            $this->get("router"),
            $route,
            $entityManager,
            $param
        );
    }
}
