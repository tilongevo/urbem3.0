<?php

namespace Urbem\TributarioBundle\Controller\Arrecadacao;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Arrecadacao\Desonerado;
use Urbem\CoreBundle\Helper\BreadCrumbsHelper;
use Urbem\CoreBundle\Model\Economico\CadastroEconomicoModel;
use Urbem\CoreBundle\Model\Imobiliario\ImovelModel;

/**
 * Class ConcederDesoneracaoAdminController
 * @package Urbem\TributarioBundle\Controller\Arrecadacao
 */
class ConcederDesoneracaoAdminController extends CRUDController
{

    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function buscaCadastroImobiliarioAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $numcgm = $request->get('numcgm');

        $imovelModel = new ImovelModel($em);

        $params = array(
            'numcgm' => $numcgm
        );

        $imoveis = $imovelModel->findImoveis($params);

        $response = [];

        if (!is_null($imoveis)) {
            foreach ($imoveis as $imovel) {
                $response[$imovel['inscricao_municipal']] =  $imovel['inscricao_municipal'];
            }
        }

        return new JsonResponse($response);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function buscaCadastroEconomicoAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $numcgm = $request->get('numcgm');

        $cadastroEconomicoModel = new CadastroEconomicoModel($em);

        $params = array(
            'numcgm' => $numcgm
        );

        $cadastrosEconomico = $cadastroEconomicoModel->findCadastrosEconomico($params);

        $response = [];

        if (!is_null($cadastrosEconomico)) {
            foreach ($cadastrosEconomico as $cadastroEconomico) {
                $response[$cadastroEconomico['inscricao_economica']] =  $cadastroEconomico['inscricao_economica'];
            }
        }

        return new JsonResponse($response);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function prorrogarAction(Request $request)
    {
        $id = $request->get('id');

        $this->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));

        $container = $this->container;

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        try {
            list($codDesoneracao, $numcgm, $ocorrencia) = explode('~', $id);
            $params = array('codDesoneracao' => $codDesoneracao, 'numcgm' => $numcgm, 'ocorrencia' => $ocorrencia);

            $desonerado = $em->getRepository(Desonerado::class)-> findOneBy($params);

            $form = $this->createForm(
                'Urbem\TributarioBundle\Form\Arrecadacao\Desoneracao\ProrrogarType',
                null,
                array('action' => $this->generateUrl('tributario_arrecadacao_desoneracao_prorrogar'))
            );

            $form->handleRequest($request);

            return $this->render('TributarioBundle::Arrecadacao/Desoneracao/Prorrogar/prorrogar.html.twig', array(
                'desonerado' => $desonerado,
                'form' => $form->createView(),
                'errors' => $form->getErrors()
            ));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.prorrogarDesoneracao.erro'));
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

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function revogarAction(Request $request)
    {
        $id = $request->get('id');

        $this->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));

        $container = $this->container;

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        try {
            list($codDesoneracao, $numcgm, $ocorrencia) = explode('~', $id);
            $params = array('codDesoneracao' => $codDesoneracao, 'numcgm' => $numcgm, 'ocorrencia' => $ocorrencia);

            $desonerado = $em->getRepository(Desonerado::class)-> findOneBy($params);

            $form = $this->createForm(
                'Urbem\TributarioBundle\Form\Arrecadacao\Desoneracao\RevogarType',
                null,
                array('action' => $this->generateUrl('tributario_arrecadacao_desoneracao_revogar'))
            );

            $form->handleRequest($request);

            return $this->render('TributarioBundle::Arrecadacao/Desoneracao/Revogar/revogar.html.twig', array(
                'desonerado' => $desonerado,
                'form' => $form->createView(),
                'errors' => $form->getErrors()
            ));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.prorrogarDesoneracao.erro'));
            throw $e;
        }
    }
}
