<?php

namespace Urbem\FinanceiroBundle\Controller\Contabilidade;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Helper;

class PlanoContaAdminController extends CRUDController
{
    protected $breadcrumb;

    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);
        $this->breadcrumb = $this->get("white_october_breadcrumbs");
    }

    public function encerramentoAction(Request $request)
    {
        $id = $this->admin->getIdParameter();
        $this->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));

        $container = $this->container;

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        try {
            $usuario = $container->get('security.token_storage')->getToken()->getUser()->getId();

            $form = $request->request->get('form');
            $acao = $form['acao'];

            $idPlanoConta = $request->get($this->admin->getIdParameter());
            $idPlanoConta = explode('~', $idPlanoConta);

            $planoContaRepository = $em->getRepository('CoreBundle:Contabilidade\PlanoConta');
            $planoConta = $planoContaRepository->findBy(
                array('exercicio' => $idPlanoConta[1], 'codConta' => $idPlanoConta[0])
            )[0];

            $form = $this->createForm('Urbem\FinanceiroBundle\Form\Contabilidade\PlanoConta\EncerramentoType', null, array( 'action' => $this->generateUrl('financeiro_contabilidade_planoconta_encerramento')));
            $form->handleRequest($request);

            return $this->render('FinanceiroBundle::Contabilidade/PlanoConta/encerramento.html.twig', array(
                'planoconta' => $planoConta,
                'tipo' => 'encerramento',
                'form' => $form->createView(),
                'errors' => $form->getErrors()
            ));

            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', 'Erro ao realizar o encerramento de conta.');
            throw $e;
        }

        (new RedirectResponse("/financeiro/contabilidade/planoconta/list"))->send();
        exit;
    }

    public function cancelaEncerramentoAction(Request $request)
    {
        $id = $this->admin->getIdParameter();
        $this->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));

        $container = $this->container;

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        try {
            $usuario = $container->get('security.token_storage')->getToken()->getUser()->getId();

            $form = $request->request->get('form');
            $acao = $form['acao'];

            $idPlanoConta = $request->get($this->admin->getIdParameter());
            $idPlanoConta = explode('~', $idPlanoConta);

            $planoContaRepository = $em->getRepository('CoreBundle:Contabilidade\PlanoConta');
            $planoConta = $planoContaRepository->findBy(
                array('exercicio' => $idPlanoConta[1], 'codConta' => $idPlanoConta[0])
            )[0];

            $planoContaEncerradaRepository = $em->getRepository('CoreBundle:Contabilidade\PlanoContaEncerrada');
            $planoContaEncerrada = $planoContaEncerradaRepository->findBy(
                array('exercicio' => $idPlanoConta[1], 'codConta' => $idPlanoConta[0])
            )[0];

            $form = $this->createForm('Urbem\FinanceiroBundle\Form\Contabilidade\PlanoConta\EncerramentoCancelamentoType', array('planocontaencerrada' => $planoContaEncerrada), array( 'action' => $this->generateUrl('financeiro_contabilidade_planoconta_cancela_encerramento')));
            $form->handleRequest($request);

            return $this->render('FinanceiroBundle::Contabilidade/PlanoConta/encerramento.html.twig', array(
                'planoconta' => $planoConta,
                'tipo' => 'cancelamento',
                'form' => $form->createView(),
                'errors' => $form->getErrors()
            ));

            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', 'Erro ao realizar o encerramento de conta.');
            throw $e;
        }

        (new RedirectResponse("/financeiro/contabilidade/planoconta/list"))->send();
        exit;
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
