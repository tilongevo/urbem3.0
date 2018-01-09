<?php

namespace Urbem\FinanceiroBundle\Controller\Ppa;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Ppa\Ppa;
use Urbem\CoreBundle\Entity\Ppa\PpaPublicacao;
use Urbem\CoreBundle\Helper;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PpaAdminController extends Controller
{
    protected $breadcrumb;

    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);
        $this->breadcrumb = $this->get("white_october_breadcrumbs");
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function homologarAction(Request $request)
    {
        $id = $this->admin->getIdParameter();
        $this->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));

        $container = $this->container;

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        try {
            $form = $request->request->get('form');
            $codPpa = $request->get($this->admin->getIdParameter());
            $ppa = $em->getRepository(Ppa::class)->findOneBycodPpa($codPpa);

            $ppaPublicacao = $em->getRepository(PpaPublicacao::class)->findOneByCodPpa($ppa->getCodPpa());

            if ($ppaPublicacao) {
                $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.ppa.ppaJaHomologado'));
                return $this->redirectToRoute('urbem_financeiro_plano_plurianual_ppa_list');
            }

            $form = $this->createForm('Urbem\FinanceiroBundle\Form\Ppa\HomologarPpaType', null, array( 'action' => $this->generateUrl('financeiro_ppa_ppa_homologar')));
            $form->handleRequest($request);

            return $this->render('FinanceiroBundle::PlanoPlurianual/Ppa/homologar.html.twig', array(
                'ppa' => $ppa,
                'form' => $form->createView(),
                'errors' => $form->getErrors()
            ));

            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.ppa.erroHomologacao'));
            throw $e;
        }

        return $this->redirectToRoute('urbem_financeiro_plano_plurianual_ppa_list');
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function estimativaAction(Request $request)
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
            $codPpa = $request->get($this->admin->getIdParameter());

            $data = array('codPpa' => $codPpa);

            $ppa = $em->getRepository('CoreBundle:Ppa\Ppa')->findOneBycodPpa($codPpa);
            $ppaEstimativaModel = (new \Urbem\CoreBundle\Model\Ppa\EstimativaOrcamentariaBaseModel($em));
            $result = $ppaEstimativaModel->getEstimativaByCodPpa($codPpa);
            $ppaEstimativaArray = array();
            $total = 0;
            for ($i=0; $i < count($result); $i++) {
                if (!is_null($result[$i+1])) {
                    $rResult = $result[$i+1];
                    if ($rResult->getCodReceita() == 25) {
                        $total -= $rResult->getValor();
                    } else {
                        $total += $rResult->getValor();
                    }
                }
                $estimativa = $result[$i];
                $ppaEstimativa = $result[$i+1];
                if (is_null($ppaEstimativa)) {
                    $ppaEstimativa = (new \Urbem\CoreBundle\Entity\Ppa\PpaEstimativaOrcamentariaBase);
                }
                $ppaEstimativaArray[] = array(
                    'estimativa' => $estimativa,
                    'ppaEstimativa' => $ppaEstimativa
                );

                $i++;
            }

            $form = $this->createForm('Urbem\FinanceiroBundle\Form\Ppa\EstimativaPpaType', null, array( 'action' => $this->generateUrl('financeiro_ppa_ppa_estimativa')));
            $form->handleRequest($request);
            return $this->render('FinanceiroBundle::PlanoPlurianual/Ppa/estimativa.html.twig', array(
                'ppa' => $ppa,
                'ppaEstimativa' => $ppaEstimativaArray,
                'total' => $total,
                'form' => $form->createView(),
                'errors' => $form->getErrors()
            ));

            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', 'Erro ao gerar a estimativa do Plano Plurianual');
            throw $e;
        }

        return $this->redirectToRoute('urbem_financeiro_plano_plurianual_ppa_list');
    }

    /**
     * @param array $param
     * @param null $route
     */
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
