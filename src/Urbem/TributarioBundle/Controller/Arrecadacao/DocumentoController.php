<?php

namespace Urbem\TributarioBundle\Controller\Arrecadacao;

use Urbem\CoreBundle\Controller\BaseController;

/**
 * Class DocumentoController
 * @package Urbem\TributarioBundle\Controller\Arrecadacao
 */
class DocumentoController extends BaseController
{
    /**
     * Home
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::Arrecadacao/Documento/home.html.twig');
    }
}
