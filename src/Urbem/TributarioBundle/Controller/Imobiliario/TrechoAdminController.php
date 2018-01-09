<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Imobiliario\BaixaTrecho;
use Urbem\CoreBundle\Entity\Imobiliario\Trecho;
use Urbem\CoreBundle\Helper\BreadCrumbsHelper;
use Urbem\CoreBundle\Model\Imobiliario\TrechoModel;

class TrechoAdminController extends CRUDController
{
    const SEQUENCIA_INICIAL = 1;

    public function consultarProximaSequenciaAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $sequencia = self::SEQUENCIA_INICIAL;

        /** @var Trecho $trecho */
        $trecho = $em
            ->getRepository(Trecho::class)
            ->findOneByCodLogradouro(
                $request->request->get('codLogradouro'),
                array('sequencia' => 'DESC')
            );
        if ($trecho) {
            $sequencia = $trecho->getSequencia() + 1;
        }

        $response = new Response();
        $response->setContent(json_encode($sequencia));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultarSequenciaAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $codTrecho = $request->request->get('codTrecho');
        $codLogradouro = $request->request->get('codLogradouro');
        $sequencia = $request->request->get('sequencia');

        $sequenciaAtual = null;
        if ($codTrecho != '') {
            /** @var Trecho $trecho */
            $trecho = $em
                ->getRepository(Trecho::class)
                ->find(
                    array(
                        'codTrecho' => $codTrecho,
                        'codLogradouro' => $codLogradouro
                    )
                );
            $sequenciaAtual = $trecho->getSequencia();
        }

        $existe = false;
        if ($sequencia != $sequenciaAtual) {
            /** @var Trecho $trecho */
            $trecho = $em
                ->getRepository(Trecho::class)
                ->findOneBy(
                    array(
                        'codLogradouro' => $codLogradouro,
                        'sequencia' => $sequencia
                    )
                );
            if ($trecho) {
                $existe = true;
            }
        }

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

        $form = $this->createForm('Urbem\TributarioBundle\Form\Imobiliario\BaixarTrechoType', null, array( 'action' => $this->generateUrl('urbem_tributario_imobiliario_trecho_baixar_trecho')));
        $form->handleRequest($request);

        list($codTrecho, $codLogradouro) = explode('~', $id);
        $params = array('codTrecho' => $codTrecho, 'codLogradouro' => $codLogradouro);
        /** @var Trecho $trecho */
        $trecho = $this->getDoctrine()->getRepository(Trecho::class)->findOneBy($params);

        return $this->render('TributarioBundle::Imobiliario/Trecho/baixar_trecho.html.twig', array(
            'trecho' => $trecho,
            'form' => $form->createView(),
            'errors' => $form->getErrors()
        ));
    }

    /**
     * @param Request $request
     */
    public function baixarTrechoAction(Request $request)
    {
        $form = $request->get('baixar_trecho');
        $container = $this->container;

        try {
            $em = $this->getDoctrine()->getEntityManager();
            /** @var Trecho $trecho */
            $trecho = $em->getRepository(Trecho::class)->findOneBy(
                array(
                    'codTrecho' => $request->get('codTrecho'),
                    'codLogradouro' => $request->get('codLogradouro')
                )
            );

            $baixaTrecho = new BaixaTrecho();
            $baixaTrecho->setDtInicio(new \DateTime());
            $baixaTrecho->setJustificativa($form['justificativa']);
            $baixaTrecho->setFkImobiliarioTrecho($trecho);
            $em->persist($baixaTrecho);
            $em->flush();
            $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.imobiliarioTrecho.msgBaixar'));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));
        }
        (new RedirectResponse($this->generateUrl('urbem_tributario_imobiliario_trecho_list')))->send();
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

        $form = $this->createForm('Urbem\TributarioBundle\Form\Imobiliario\ReativarTrechoType', null, array( 'action' => $this->generateUrl('urbem_tributario_imobiliario_trecho_reativar_trecho')));
        $form->handleRequest($request);

        list($codTrecho, $codLogradouro) = explode('~', $id);
        $params = array('codTrecho' => $codTrecho, 'codLogradouro' => $codLogradouro);
        /** @var Trecho $trecho */
        $trecho = $this->getDoctrine()->getRepository(Trecho::class)->findOneBy($params);

        return $this->render('TributarioBundle::Imobiliario/Trecho/reativar_trecho.html.twig', array(
            'trecho' => $trecho,
            'form' => $form->createView(),
            'errors' => $form->getErrors()
        ));
    }

    /**
     * @param Request $request
     */
    public function reativarTrechoAction(Request $request)
    {
        $form = $request->get('reativar_localizacao');
        $container = $this->container;

        try {
            $em = $this->getDoctrine()->getEntityManager();
            /** @var Trecho $trecho */
            $trecho = $em->getRepository(Trecho::class)->findOneBy(
                array(
                    'codTrecho' => $request->get('codTrecho'),
                    'codLogradouro' => $request->get('codLogradouro')
                )
            );

            /** @var BaixaTrecho $baixaTrecho */
            $baixaTrecho = $trecho->getFkImobiliarioBaixaTrechos()->last();
            $baixaTrecho->setDtTermino(new \DateTime());
            $baixaTrecho->setJustificativaTermino($form['justificativaTermino']);
            $baixaTrecho->setFkImobiliarioTrecho($trecho);
            $em->persist($baixaTrecho);
            $em->flush();
            $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.imobiliarioTrecho.msgReativar'));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));
        }
        (new RedirectResponse($this->generateUrl('urbem_tributario_imobiliario_trecho_list')))->send();
    }

    public function caracteristicasAction(Request $request)
    {
        $id = $request->get('id');
        $this->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));

        list($codTrecho, $codLogradouro) = explode('~', $id);
        $params = array('codTrecho' => $codTrecho, 'codLogradouro' => $codLogradouro);
        /** @var Trecho $trecho */
        $trecho = $this->getDoctrine()->getRepository(Trecho::class)->findOneBy($params);

        return $this->render('TributarioBundle::Imobiliario/Trecho/alterar_caracteristicas.html.twig', array(
            'trecho' => $trecho
        ));
    }

    /**
     * @param Request $request
     */
    public function alterarCaracteristicasAction(Request $request)
    {
        $container = $this->container;

        $em = $this->getDoctrine()->getEntityManager();
        /** @var Trecho $trecho */
        $trecho = $em->getRepository(Trecho::class)->findOneBy(
            array(
                'codTrecho' => $request->get('codTrecho'),
                'codLogradouro' => $request->get('codLogradouro')
            )
        );

        $retorno = (new TrechoModel($em))->atributoDinamico($trecho, $request->request->get('atributoDinamico'));

        if ($retorno !== true) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));
        } else {
            $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.imobiliarioTrecho.msgCaracteristicas'));
        }
        (new RedirectResponse($this->generateUrl('urbem_tributario_imobiliario_trecho_list')))->send();
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
