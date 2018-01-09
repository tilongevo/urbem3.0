<?php

namespace Urbem\AdministrativoBundle\Controller\Administracao;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Administracao\Funcao;
use Urbem\CoreBundle\Helper;
use Urbem\CoreBundle\Model\Administracao\FuncaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PensaoFuncaoPadraoModel;

class FuncaoAdminController extends Controller
{
    protected $breadcrumb;

    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);
        $this->breadcrumb = $this->get("white_october_breadcrumbs");
    }

    public function consultarBibliotecaAction(Request $request)
    {
        $modulo = $request->attributes->get('id');

        $bibliotecas = $this->getDoctrine()
            ->getRepository('CoreBundle:Administracao\Biblioteca')
            ->findByCodModulo($modulo, array('nomBiblioteca' => 'ASC'));

        $listBibliotecas = array();
        foreach ($bibliotecas as $biblioteca) {
            $listBibliotecas[$biblioteca->getNomBiblioteca()] = $biblioteca->getId();
        }

        $response = new Response();
        $response->setContent(json_encode($listBibliotecas));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function duplicarAction(Request $request)
    {
        $id = $this->admin->getIdParameter();
        $this->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));

        $container = $this->container;

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        try {
            $usuario = $container->get('security.token_storage')->getToken()->getUser()->getId();

            $form = $request->request->get('form');
            $acao = $form['acao'];
            $idParams = $request->get($this->admin->getIdParameter());

            list($codModulo, $codBiblioteca, $codFuncao) = explode('~', $idParams);
            $data = array('codFuncao' => $codFuncao);

            $funcao = $em->getRepository('CoreBundle:Administracao\Funcao')->findOneBycodFuncao($codFuncao);
            $funcaoExterna = $em->getRepository('CoreBundle:Administracao\FuncaoExterna')->findOneByCodFuncao($codFuncao);

            $form = $this->createForm('Urbem\AdministrativoBundle\Form\Administrativo\Administracao\DuplicarFuncaoType', null, array( 'action' => $this->generateUrl('administracao_funcao_duplicar')));
            $form->handleRequest($request);

            return $this->render('AdministrativoBundle::Administracao/duplicar.html.twig', array(
                'funcao' => $funcao,
                'funcaoExterna' => $funcaoExterna,
                'form' => $form->createView(),
                'errors' => $form->getErrors()
            ));

            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', 'Erro ao duplicar função');
            throw $e;
        }

        (new RedirectResponse("/administrativo/administracao/gerador-calculo/funcao/list"))->send();
    }

    public function setBreadCrumb($param = [], $route = null)
    {
        $entityManager = $this->getDoctrine()->getManager();

        Helper\BreadCrumbsHelper::getBreadCrumb(
            $this->get("white_october_breadcrumbs"),
            $this->get("router"),
            $route,
            $entityManager,
            $param
        );
    }

    public function consultarFuncaoPadraoAction()
    {
        $em = $this->getDoctrine()->getManager();
        $funcaoPadrao = (new PensaoFuncaoPadraoModel($em))
                                                ->recuperaPensaoFuncaoPadrao();
        /** @var Funcao $funcao */
        $funcao = (new FuncaoModel($em))
                        ->recuperaFuncao($funcaoPadrao[0]);

        $result = new JsonResponse([
            'id' => $this->admin->getObjectKey($funcao),
            'label' => (string) $funcao
        ]);

        return $result;
    }
}
