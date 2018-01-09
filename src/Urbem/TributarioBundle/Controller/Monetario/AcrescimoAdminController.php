<?php

namespace Urbem\TributarioBundle\Controller\Monetario;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Economico\Elemento;
use Urbem\CoreBundle\Entity\Monetario\Acrescimo;
use Urbem\CoreBundle\Entity\Monetario\ValorAcrescimo;
use Urbem\CoreBundle\Helper\BreadCrumbsHelper;

class AcrescimoAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function formulaCalculoAction(Request $request)
    {
        $id = $this->admin->getIdParameter();
        $this->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));

        $container = $this->container;

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        try {
            $id = $request->get($this->admin->getIdParameter());
            list($codAcrescimo, $tipo) = explode('~', $id);

            $acrescimo = $em->getRepository(Acrescimo::class)
                -> findOneBy([
                    'codAcrescimo' => $codAcrescimo,
                    'codTipo' => $tipo
                ]);

            $form = $this->createForm(
                'Urbem\TributarioBundle\Form\Monetario\Acrescimo\FormulaCalculoType',
                null,
                array('action' => $this->generateUrl('tributario_monetario_acrescimo_formula_calculo'))
            );

            $form->handleRequest($request);

            return $this->render('TributarioBundle::Monetario/Acrescimo/formula_calculo.html.twig', array(
                'acrescimo' => $acrescimo,
                'form' => $form->createView(),
                'errors' => $form->getErrors()
            ));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.monetarioAcrescimo.erroFormulaCalculo'));
            throw $e;
        }
    }

    /**
     * @param array $param
     * @param null $route
     */
    public function setBreadCrumb($param = [], $route = null)
    {
        $entityManager = $this->getDoctrine()->getManager();

        BreadCrumbsHelper::getBreadCrumb(
            $this->get("white_october_breadcrumbs"),
            $this->get("router"),
            $route,
            $entityManager,
            $param
        );
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function definirValorAction(Request $request)
    {
        $id = $this->admin->getIdParameter();
        $this->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));

        $container = $this->container;

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        try {
            $id = $request->get($this->admin->getIdParameter());
            list($codAcrescimo, $tipo) = explode('~', $id);

            $acrescimo = $em->getRepository(Acrescimo::class)
                -> findOneBy([
                    'codAcrescimo' => $codAcrescimo,
                    'codTipo' => $tipo
                ]);

            $valoresAcrescimo = $em->getRepository(ValorAcrescimo::class)
                ->findBy([
                    'codAcrescimo' => $acrescimo->getCodAcrescimo(),
                    'codTipo' => $acrescimo->getCodTipo()
                ]);

            $form = $this->createForm(
                'Urbem\TributarioBundle\Form\Monetario\Acrescimo\DefinirValorType',
                null,
                array('action' => $this->generateUrl('tributario_monetario_acrescimo_definir_valor'))
            );

            $form->handleRequest($request);

            return $this->render('TributarioBundle::Monetario/Acrescimo/definir_valor.html.twig', array(
                'acrescimo' => $acrescimo,
                'valoresAcrescimo' => $valoresAcrescimo,
                'form' => $form->createView(),
                'errors' => $form->getErrors()
            ));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.monetarioAcrescimo.erroFormulaCalculo'));
            throw $e;
        }
    }
}
