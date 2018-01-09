<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Doctrine\ORM\QueryBuilder;
use phpDocumentor\Reflection\Types\Boolean;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Imobiliario\BaixaLocalizacao;
use Urbem\CoreBundle\Entity\Imobiliario\Localizacao;
use Urbem\CoreBundle\Entity\Imobiliario\Nivel;
use Urbem\CoreBundle\Entity\Imobiliario\Vigencia;
use Urbem\CoreBundle\Helper\BreadCrumbsHelper;
use Urbem\CoreBundle\Model\Imobiliario\LocalizacaoModel;

class LocalizacaoAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function consultarNivelAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $codVigencia = $request->request->get('codVigencia');

        $listNiveis = array();

        /** @var Vigencia $vigencia */
        $vigencia = $em->getRepository(Vigencia::class)->find($codVigencia);
        if ($vigencia) {
            /** @var Nivel $nivel */
            foreach ($vigencia->getFkImobiliarioNiveis() as $nivel) {
                $listNiveis[$nivel->getCodNivel()] = $nivel->getNomNivel();
            }
        }

        $response = new Response();
        $response->setContent(json_encode($listNiveis));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultarLocalizacaoAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $codVigencia = $request->request->get('codVigencia');
        $codNivel = $request->request->get('codNivel');

        $localizacoes = $em
            ->getRepository(Localizacao::class)
            ->getLocalizacaoByVigenciaNivel($codVigencia, $codNivel);

        $listLocalizacoes = array();
        foreach ($localizacoes as $localizacao) {
            $listLocalizacoes[$localizacao['cod_localizacao']] = sprintf('%s - %s', $localizacao['codigo_composto'], $localizacao['nom_localizacao']);
        }

        $response = new Response();
        $response->setContent(json_encode($listLocalizacoes));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultarCodigoAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $codVigencia = $request->request->get('codVigencia');
        $codNivel = $request->request->get('codNivel');
        $codigo = $request->request->get('codigo');
        $codLocalizacao = $request->request->get('codLocalizacao');

        $localizacao = null;
        if ($codLocalizacao != '') {
            /** @var Localizacao $localizacao */
            $localizacao = $em->getRepository(Localizacao::class)->find($codLocalizacao);
        }

        /** @var Nivel $nivel */
        $nivel = $em->getRepository(Nivel::class)
            ->findOneBy(
                array(
                    'codNivel' => $codNivel,
                    'codVigencia' => $codVigencia
                )
            );

        /** @var Boolean $consulta */
        $consulta = (new LocalizacaoModel($this->getDoctrine()
            ->getEntityManager()))
            ->verificaCodigo(
                $nivel,
                $codigo,
                $localizacao
            );

        $response = new Response();
        $response->setContent(json_encode($consulta));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultarMascaraAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $codVigencia = $request->request->get('codVigencia');
        $codNivel = $request->request->get('codNivel');

        /** @var Nivel $nivel */
        $nivel = $em->getRepository(Nivel::class)
            ->findOneBy(
                array(
                    'codVigencia' => $codVigencia,
                    'codNivel' => $codNivel
                )
            );

        $mascara = '';
        if ($nivel) {
            $mascara = str_pad('0', strlen($nivel->getMascara()), '0', STR_PAD_LEFT);
        }

        $response = new Response();
        $response->setContent(json_encode($mascara));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultarMascaraFiltroAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $codVigencia = $request->request->get('codVigencia');

        $mascara = '';
        /** @var Vigencia $vigencia */
        $vigencia = $em->getRepository(Vigencia::class)->find($codVigencia);
        /** @var Nivel $nivel */
        foreach ($vigencia->getFkImobiliarioNiveis() as $nivel) {
            $mascara .= ($mascara)
                ? sprintf('.%s', str_pad('0', strlen($nivel->getMascara()), '0', STR_PAD_LEFT))
                : str_pad('0', strlen($nivel->getMascara()), '0', STR_PAD_LEFT);
        }

        $response = new Response();
        $response->setContent(json_encode($mascara));
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

        $form = $this->createForm('Urbem\TributarioBundle\Form\Imobiliario\BaixarLocalizacaoType', null, array( 'action' => $this->generateUrl('urbem_tributario_imobiliario_localizacao_baixar_localizacao')));
        $form->handleRequest($request);

        /** @var Localizacao $localizacao */
        $localizacao = $this->getDoctrine()->getRepository(Localizacao::class)->find($id);

        $em = $this->getDoctrine()->getManager();
        $localizacaoModel = new LocalizacaoModel($em);

        $nivel = $localizacaoModel->getNivel($localizacao);
        $data = array(
            'nivel' => $nivel,
            'superior' => $localizacaoModel->getLocalizacaoSuperior($localizacao, $nivel),
            'codigo' => $localizacaoModel->getValorLocalizacao($localizacao)
        );

        return $this->render('TributarioBundle::Imobiliario/Localizacao/baixar_localizacao.html.twig', array(
            'localizacao' => $localizacao,
            'data' => $data,
            'form' => $form->createView(),
            'errors' => $form->getErrors()
        ));
    }

    /**
     * @param Request $request
     */
    public function baixarLocalizacaoAction(Request $request)
    {
        $form = $request->get('baixar_localizacao');
        $container = $this->container;

        try {
            $em = $this->getDoctrine()->getEntityManager();
            /** @var Localizacao $localizacao */
            $localizacao = $em->getRepository(Localizacao::class)->find($request->get('codLocalizacao'));

            $dependentes = (new LocalizacaoModel($em))->verificaDependentes($localizacao);
            if (!$dependentes) {
                $baixaLocalizacao = new BaixaLocalizacao();
                $baixaLocalizacao->setDtInicio(new \DateTime());
                $baixaLocalizacao->setJustificativa($form['justificativa']);
                $baixaLocalizacao->setFkImobiliarioLocalizacao($localizacao);
                $em->persist($baixaLocalizacao);
                $em->flush();
                $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.imobiliarioLocalizacao.msgBaixar'));
            } else {
                $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.imobiliarioLocalizacao.erroBaixar'));
            }
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));
        }
        (new RedirectResponse($this->generateUrl('urbem_tributario_imobiliario_localizacao_list')))->send();
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

        $form = $this->createForm('Urbem\TributarioBundle\Form\Imobiliario\ReativarLocalizacaoType', null, array( 'action' => $this->generateUrl('urbem_tributario_imobiliario_localizacao_reativar_localizacao')));
        $form->handleRequest($request);

        /** @var Localizacao $localizacao */
        $localizacao = $this->getDoctrine()->getRepository(Localizacao::class)->find($id);

        $em = $this->getDoctrine()->getManager();
        $localizacaoModel = new LocalizacaoModel($em);

        $nivel = $localizacaoModel->getNivel($localizacao);
        $data = array(
            'nivel' => $nivel,
            'superior' => $localizacaoModel->getLocalizacaoSuperior($localizacao, $nivel),
            'codigo' => $localizacaoModel->getValorLocalizacao($localizacao),
        );

        return $this->render('TributarioBundle::Imobiliario/Localizacao/reativar_localizacao.html.twig', array(
            'localizacao' => $localizacao,
            'data' => $data,
            'form' => $form->createView(),
            'errors' => $form->getErrors()
        ));
    }

    /**
     * @param Request $request
     */
    public function reativarLocalizacaoAction(Request $request)
    {
        $form = $request->get('reativar_localizacao');
        $container = $this->container;

        try {
            $em = $this->getDoctrine()->getEntityManager();
            /** @var Localizacao $localizacao */
            $localizacao = $em->getRepository(Localizacao::class)->find($request->get('codLocalizacao'));

            /** @var BaixaLocalizacao $baixaLocalizacao */
            $baixaLocalizacao = $localizacao->getFkImobiliarioBaixaLocalizacoes()->last();
            $baixaLocalizacao->setDtTermino(new \DateTime());
            $baixaLocalizacao->setJustificativaTermino($form['justificativaTermino']);
            $baixaLocalizacao->setFkImobiliarioLocalizacao($localizacao);
            $em->persist($baixaLocalizacao);
            $em->flush();
            $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.imobiliarioLocalizacao.msgReativar'));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));
        }
        (new RedirectResponse($this->generateUrl('urbem_tributario_imobiliario_localizacao_list')))->send();
    }

    public function caracteristicasAction(Request $request)
    {
        $id = $request->get('id');
        $this->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));

        /** @var Localizacao $localizacao */
        $localizacao = $this->getDoctrine()->getRepository(Localizacao::class)->find($id);

        $em = $this->getDoctrine()->getManager();
        $localizacaoModel = new LocalizacaoModel($em);

        $nivel = $localizacaoModel->getNivel($localizacao);
        $data = array(
            'nivel' => $nivel,
            'superior' => $localizacaoModel->getLocalizacaoSuperior($localizacao, $nivel),
            'codigo' => $localizacaoModel->getValorLocalizacao($localizacao),
        );

        return $this->render('TributarioBundle::Imobiliario/Localizacao/alterar_caracteristicas.html.twig', array(
            'localizacao' => $localizacao,
            'data' => $data
        ));
    }

    /**
     * @param Request $request
     */
    public function alterarCaracteristicasAction(Request $request)
    {
        $container = $this->container;

        $em = $this->getDoctrine()->getEntityManager();
        /** @var Localizacao $localizacao */
        $localizacao = $em->getRepository(Localizacao::class)->find($request->request->get('codLocalizacao'));

        $retorno = (new LocalizacaoModel($em))->atualizarAtributoDinamico($localizacao, $request->request->get('atributoDinamico'));

        if ($retorno !== true) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));
        } else {
            $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.imobiliarioLocalizacao.msgCaracteristicas'));
        }
        (new RedirectResponse($this->generateUrl('urbem_tributario_imobiliario_localizacao_list')))->send();
    }

    public function autocompleteLocalizacaoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $term = $request->get('q');

        /** @var QueryBuilder $qb */
        $qb = $em->getRepository(Localizacao::class)->createQueryBuilder('o');
        $qb->where('o.codigoComposto LIKE :codigoComposto');
        $qb->setParameter('codigoComposto', sprintf('%%%s%%', strtolower($term)));
        $rlt = $qb->getQuery()->getResult();

        $localizacoes = array();

        /** @var Localizacao $localizacao */
        foreach ($rlt as $localizacao) {
            array_push(
                $localizacoes,
                array(
                    'id' => $localizacao->getCodLocalizacao(),
                    'label' => $localizacao->getCodigoComposto()
                )
            );
        }

        $items = array(
            'items' => $localizacoes
        );

        return new JsonResponse($items);
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
