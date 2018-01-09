<?php

namespace Urbem\AdministrativoBundle\Controller;

use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Model\Administracao\ModuloModel;

class SistemaController extends ControllerCore\BaseController
{
    /**
     * Home Configuracao
     *
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('AdministrativoBundle::Administracao/Sistema/home.html.twig');
    }

    /**
     * Home responsável por módulo
     */
    public function responsavelModuloAction()
    {
        $this->setBreadCrumb();

        $em = $this->getDoctrine()->getManager();

        $moduloModel = new ModuloModel($em);
        $modulos = $moduloModel->getAllModulos();

        return $this->render('AdministrativoBundle::Administracao/Sistema/modulo.html.twig', array(
            'modulos' => $modulos,
        ));
    }
}
