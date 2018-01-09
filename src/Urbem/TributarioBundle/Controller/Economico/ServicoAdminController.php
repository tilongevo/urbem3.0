<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Helper\BreadCrumbsHelper;
use Urbem\CoreBundle\Model\Economico\AliquotaServicoModel;
use Urbem\CoreBundle\Model\Economico\NivelServicoModel;
use Urbem\CoreBundle\Model\Economico\NivelServicoValorModel;
use Urbem\CoreBundle\Model\Economico\ServicoModel;

/**
 * Class ServicoAdminController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class ServicoAdminController extends CRUDController
{
    /**
     * @param Request $request
     */
    public function aliquotaAction(Request $request)
    {
        $id = $this->admin->getIdParameter();
        $this->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));

        $container = $this->container;
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        $form = $request->request->get('form');
        $codServico = $request->get($this->admin->getIdParameter());

        $nivelServicoValor = (new NivelServicoValorModel($em))
            ->getNivelServicoValorByCodServico($codServico);

        $nivelServico = null;
        if ($nivelServicoValor) {
            $nivelServico = (new NivelServicoModel($em))
                ->getNivelServico($nivelServicoValor->getCodNivel());
        }

        $servico = (new ServicoModel($em))
            ->getServicoByCodServico($codServico);

        $aliquota = (new AliquotaServicoModel($em))
            ->getAliquota($codServico);

        $form = $this->createForm('Urbem\TributarioBundle\Form\Economico\ServicoType', $aliquota, ['action' => $this->generateUrl('tributario_economico_servico_salvar', ['id' => $codServico])]);

        return $this->render('TributarioBundle::Economico/aliquota.html.twig', array(
            'servico' => $servico,
            'nivel' => $nivelServico,
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
