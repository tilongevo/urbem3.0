<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Imobiliario\BaixaFaceQuadra;
use Urbem\CoreBundle\Entity\Imobiliario\FaceQuadra;
use Urbem\CoreBundle\Helper\BreadCrumbsHelper;
use Urbem\CoreBundle\Model\Imobiliario\FaceQuadraModel;

class FaceQuadraAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function consultaFaceQuadraTrechoAction(Request $request)
    {
        $existe = (new FaceQuadraModel($this->getDoctrine()->getEntityManager()))
            ->consultaFaceQuadraTrecho(
                $request->request->get('codLocalizacao'),
                $request->request->get('codTrecho'),
                $request->request->get('codLogradouro'),
                $request->request->get('codFace')
            );

        $response = new Response();
        $response->setContent(json_encode($existe));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function baixarAction(Request $request)
    {
        $id = $request->get('id');
        $this->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));

        $form = $this->createForm('Urbem\TributarioBundle\Form\Imobiliario\BaixarFaceQuadraType', null, array( 'action' => $this->generateUrl('urbem_tributario_imobiliario_face_quadra_baixar_face_quadra')));
        $form->handleRequest($request);

        list($codFace, $codLocalizacao) = explode('~', $id);
        $params = array('codFace' => $codFace, 'codLocalizacao' => $codLocalizacao);
        /** @var FaceQuadra $faceQuadra */
        $faceQuadra = $this->getDoctrine()->getRepository(FaceQuadra::class)->findOneBy($params);

        return $this->render('TributarioBundle::Imobiliario/FaceQuadra/baixar_face_quadra.html.twig', array(
            'faceQuadra' => $faceQuadra,
            'form' => $form->createView(),
            'errors' => $form->getErrors()
        ));
    }

    /**
     * @param Request $request
     */
    public function baixarFaceQuadraAction(Request $request)
    {
        $form = $request->get('baixar_face_quadra');
        $container = $this->container;

        try {
            $em = $this->getDoctrine()->getEntityManager();
            /** @var FaceQuadra $faceQuadra */
            $faceQuadra = $em->getRepository(FaceQuadra::class)->findOneBy(
                array(
                    'codFace' => $request->get('codFace'),
                    'codLocalizacao' => $request->get('codLocalizacao')
                )
            );

            $baixaFaceQuadra = new BaixaFaceQuadra();
            $baixaFaceQuadra->setDtInicio(new \DateTime());
            $baixaFaceQuadra->setJustificativa($form['justificativa']);
            $baixaFaceQuadra->setFkImobiliarioFaceQuadra($faceQuadra);
            $em->persist($baixaFaceQuadra);
            $em->flush();
            $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.imobiliarioFaceQuadra.msgBaixar'));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));
        }
        (new RedirectResponse($this->generateUrl('urbem_tributario_imobiliario_face_quadra_list')))->send();
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function reativarAction(Request $request)
    {
        $id = $request->get('id');
        $this->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));

        $form = $this->createForm('Urbem\TributarioBundle\Form\Imobiliario\ReativarFaceQuadraType', null, array( 'action' => $this->generateUrl('urbem_tributario_imobiliario_face_quadra_reativar_face_quadra')));
        $form->handleRequest($request);

        list($codFace, $codLocalizacao) = explode('~', $id);
        $params = array('codFace' => $codFace, 'codLocalizacao' => $codLocalizacao);
        /** @var FaceQuadra $faceQuadra */
        $faceQuadra = $this->getDoctrine()->getRepository(FaceQuadra::class)->findOneBy($params);

        return $this->render('TributarioBundle::Imobiliario/FaceQuadra/reativar_face_quadra.html.twig', array(
            'faceQuadra' => $faceQuadra,
            'form' => $form->createView(),
            'errors' => $form->getErrors()
        ));
    }

    /**
     * @param Request $request
     */
    public function reativarFaceQuadraAction(Request $request)
    {
        $form = $request->get('reativar_face_quadra');
        $container = $this->container;

        try {
            $em = $this->getDoctrine()->getEntityManager();
            /** @var FaceQuadra $faceQuadra */
            $faceQuadra = $em->getRepository(FaceQuadra::class)->findOneBy(
                array(
                    'codFace' => $request->get('codFace'),
                    'codLocalizacao' => $request->get('codLocalizacao')
                )
            );

            /** @var BaixaFaceQuadra $baixaFaceQuadra */
            $baixaFaceQuadra = $faceQuadra->getFkImobiliarioBaixaFaceQuadras()->last();
            $baixaFaceQuadra->setDtTermino(new \DateTime());
            $baixaFaceQuadra->setJustificativaTermino($form['justificativaTermino']);
            $baixaFaceQuadra->setFkImobiliarioFaceQuadra($faceQuadra);
            $em->persist($baixaFaceQuadra);
            $em->flush();
            $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.imobiliarioFaceQuadra.msgReativar'));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));
        }
        (new RedirectResponse($this->generateUrl('urbem_tributario_imobiliario_face_quadra_list')))->send();
    }

    public function caracteristicasAction(Request $request)
    {
        $id = $request->get('id');
        $this->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));

        list($codFace, $codLocalizacao) = explode('~', $id);
        $params = array('codFace' => $codFace, 'codLocalizacao' => $codLocalizacao);
        /** @var FaceQuadra $faceQuadra */
        $faceQuadra = $this->getDoctrine()->getRepository(FaceQuadra::class)->findOneBy($params);

        return $this->render('TributarioBundle::Imobiliario/FaceQuadra/alterar_caracteristicas.html.twig', array(
            'faceQuadra' => $faceQuadra
        ));
    }

    /**
     * @param Request $request
     */
    public function alterarCaracteristicasAction(Request $request)
    {
        $container = $this->container;

        $em = $this->getDoctrine()->getEntityManager();
        /** @var FaceQuadra $faceQuadra */
        $faceQuadra = $em->getRepository(FaceQuadra::class)->findOneBy(
            array(
                'codFace' => $request->get('codFace'),
                'codLocalizacao' => $request->get('codLocalizacao')
            )
        );

        $retorno = (new FaceQuadraModel($em))->atributoDinamico($faceQuadra, $request->request->get('atributoDinamico'));

        if ($retorno !== true) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));
        } else {
            $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.imobiliarioFaceQuadra.msgCaracteristicas'));
        }
        (new RedirectResponse($this->generateUrl('urbem_tributario_imobiliario_face_quadra_list')))->send();
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
}
