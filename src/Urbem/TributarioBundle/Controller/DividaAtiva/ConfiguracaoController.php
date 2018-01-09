<?php

namespace Urbem\TributarioBundle\Controller\DividaAtiva;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;

class ConfiguracaoController extends BaseController
{
    /**
     * Home
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::DividaAtiva/Configuracao/home.html.twig');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getConfigurarDocumentoAction(Request $request)
    {
        $id = $request->attributes->get('_id');
        $configuracaoModel = new ConfiguracaoModel($this->getDoctrine()->getManager());
        $configuracoes = $configuracaoModel->gerValoresConfiguracaoDocumentos($id, $this->getExercicio());
        $configuracoes->set('id', $id);
        $response = new Response();
        $response->setContent(json_encode(['dados' => $configuracoes->toArray()]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
