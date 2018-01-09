<?php

namespace Urbem\TributarioBundle\Controller\Arrecadacao;

use Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Helper\BreadCrumbsHelper;
use Urbem\CoreBundle\Model\Arrecadacao\DocumentoEmissaoModel;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DocumentoEmissaoAdminController extends CRUDController
{

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
    public function downloadAction(Request $request)
    {
        $id = $this->admin->getIdParameter();
        $this->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));

        $container = $this->container;

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        try {
            $id = $request->get($this->admin->getIdParameter());
            list($numDocumento, $exercicio) = explode('~', $id);

            return $this->render('TributarioBundle::Arrecadacao/DocumentoEmissao/download.html.twig', array(
                'numDocumento' => $numDocumento,
                'exercicio' => $exercicio,
                'action' => 'geraCertidao'
            ));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.arrecadacaoDocumentoEmissao.erro'));
            throw $e;
        }
    }

    /**
     * @param Request $request
     */
    public function geraCertidaoAction(Request $request)
    {
        $id = $request->get($this->admin->getIdParameter());
        list($numDocumento, $exercicio) = explode('~', $id);

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        $model = new DocumentoEmissaoModel($em);

        $docEmissao = $model->findDocumentoEmissao(array('numDocumento' => $numDocumento, 'exercicio' => $exercicio));

        $dados = $model->dadosDocumentoEmissao($docEmissao);

        $dados['teste'] = 'teste';
        $container = $this->container;

        $tributarioTemplatePath = $container->getParameter('tributariobundle');

        $openTBS = $this->get('opentbs');
        $openTBS->ResetVarRef(false);
        $openTBS->VarRef = $dados;

        // load your template
        $openTBS->LoadTemplate($tributarioTemplatePath['templateOdt'] . 'certidaoNegativaMariana.odt', OPENTBS_ALREADY_UTF8);

        // send the file
        $openTBS->Show(OPENTBS_DOWNLOAD, 'certidaoNegativaMariana.odt');
    }
}
