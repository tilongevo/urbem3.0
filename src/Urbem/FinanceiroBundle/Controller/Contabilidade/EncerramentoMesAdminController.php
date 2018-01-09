<?php

namespace Urbem\FinanceiroBundle\Controller\Contabilidade;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Helper;

class EncerramentoMesAdminController extends CRUDController
{
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
     * @return Response
     */
    public function permissaoAction(Request $request)
    {
        $id = $request->get('id');

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $message = $this->trans('financeiro.encerrarMes.desabilitado', [], 'flashes');
        $messageAcao = $this->trans('acaoNaoPermitida');

        $parametros = array(
            'titulo' => $messageAcao,
            'mensagem' => $message,
            'voltar' => '/financeiro/contabilidade/configuracao/gestao',
        );

        return $this->render('FinanceiroBundle::Orcamento/Configuracao/configuracao.html.twig', array(
            'parametro'  => $parametros
        ));
    }

    /**
     * @param array $param
     * @param null $route
     */
    public function setBreadCrumb($param = [], $route = null)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $request = $this->getRequest();
        $route = $request->attributes->get('_route');

        Helper\BreadCrumbsHelper::getBreadCrumb(
            $this->get("white_october_breadcrumbs"),
            $this->get("router"),
            $route,
            $entityManager,
            $param
        );
    }
}
