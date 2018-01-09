<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Economico\Elemento;
use Urbem\CoreBundle\Helper\BreadCrumbsHelper;

class ElementoAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function baixarAction(Request $request)
    {
        $id = $this->admin->getIdParameter();
        $this->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));

        $container = $this->container;

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        try {
            $id = $request->get($this->admin->getIdParameter());

            $elemento = $em->getRepository(Elemento::class)
                -> findOneBy([
                    'codElemento' => $id
                ]);

            $form = $this->createForm(
                'Urbem\TributarioBundle\Form\Economico\Elemento\BaixarType',
                null,
                array('action' => $this->generateUrl('tributario_economico_elemento_baixar'))
            );

            $form->handleRequest($request);

            return $this->render('TributarioBundle::Economico/Elemento/baixar.html.twig', array(
                'elemento' => $elemento,
                'form' => $form->createView(),
                'errors' => $form->getErrors()
            ));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.economicoElemento.erroBaixar'));
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
}
