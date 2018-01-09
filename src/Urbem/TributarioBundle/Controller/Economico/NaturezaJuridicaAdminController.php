<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Helper\BreadCrumbsHelper;

/**
 * Class NaturezaJuridicaAdminController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class NaturezaJuridicaAdminController extends CRUDController
{
    protected $breadcrumb;

    /**
     * @param array $configs
     * @param ContainerBuilder $containerBuilder
     */
    public function load(array $configs, ContainerBuilder $containerBuilder)
    {
        parent::load($configs, $containerBuilder);
        $this->breadcrumb = $this->get("white_october_breadcrumbs");
    }

    /**
     * @param Request $request
     */
    public function baixarAction(Request $request)
    {
        $id = $this->admin->getIdParameter();
        $this->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));

        $container = $this->container;
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        $form = $request->request->get('form');
        $codNatureza = $request->get($this->admin->getIdParameter());
        $naturezaJuridicaRepository = $em->getRepository('CoreBundle:Economico\NaturezaJuridica');
        $naturezaJuridica = $naturezaJuridicaRepository->findOneByCodNatureza($codNatureza);

        $form = $this->createForm('Urbem\TributarioBundle\Form\Economico\NaturezaJuridicaType', null, ['action' => $this->generateUrl('tributario_economico_natureza_juridica_salvar', ['id' => $codNatureza])]);

        return $this->render('TributarioBundle::Economico/baixarNatureza.html.twig', array(
            'naturezaJuridica' => $naturezaJuridica,
            'form' => $form->createView(),
            'errors' => $form->getErrors()
        ));
    }

    /**
     * @param array $param
     * @param null $route
     */
    public function setBreadCrumb($param = [], $route = null)
    {
        $em = $this->getDoctrine()->getManager();
        BreadCrumbsHelper::getBreadCrumb($this->get("white_october_breadcrumbs"), $this->get("router"), $route, $em, $param);
    }
}
