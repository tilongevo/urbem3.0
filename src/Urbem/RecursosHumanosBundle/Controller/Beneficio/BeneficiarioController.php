<?php

namespace Urbem\RecursosHumanosBundle\Controller\Beneficio;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbem\CoreBundle\Entity\Beneficio\Beneficiario;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Entity\Beneficio\LayoutFornecedor;

/**
 * Beneficio\Beneficiario controller.
 *
 */
class BeneficiarioController extends ControllerCore\BaseController
{
    /**
     * Lists all Beneficio\Beneficiario entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $this->setBreadCrumb();

        $beneficio = $em->getRepository('CoreBundle:Beneficio\Beneficiario')->findAll();

        return $this->render('RecursosHumanosBundle::Beneficio/Beneficiario/index.html.twig', array(
            'beneficios' => $beneficio,
        ));
    }
}
