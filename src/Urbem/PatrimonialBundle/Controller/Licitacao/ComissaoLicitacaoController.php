<?php

namespace Urbem\PatrimonialBundle\Controller\Licitacao;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Entity\Licitacao\Comissao;
use Urbem\CoreBundle\Entity\Licitacao\TipoMembro;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Model\Normas\NormaModel;

/**
 * Licitacao\Comissao Licitacao controller.
 *
 */
class ComissaoLicitacaoController extends ControllerCore\BaseController
{
    /**
     * Home Comissao Licitacao
     *
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('PatrimonialBundle::Licitacao/ComissaoLicitacao/home.html.twig');
    }

    public function getNormasAction(Request $request)
    {
        $search = $request->get('q');

        $searchSql = is_numeric($search) ?
            sprintf("num_norma = '%s'", $search) :
            sprintf("(lower(nom_norma) LIKE '%%%s%%')", $request->get('q'));

        $params = [$searchSql];
        $normaModel = new NormaModel($this->db);
        $result = $normaModel->getNormasJson($params);
        $response = [];

        foreach ($result as $value) {
            array_push($response, ['id' => $value->cod_norma, 'label' => str_pad($value->num_norma, 6, '0', STR_PAD_LEFT) . '/' . $value->exercicio . ' - ' . $value->nom_norma]);
        }
        $items = [
            'items' => $response
        ];
        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function normaVigenciaAction(Request $request)
    {
        $id = $request->get('id');
        $entityManager = $this->getDoctrine()->getManager();

        /** @var Norma $getNorma */
        $getNorma = $entityManager->getRepository(Norma::class)->findOneBy(["codNorma" => $id]);
        if (!is_null($getNorma->getFkNormasNormaDataTermino()) && !is_null($getNorma->getFkNormasNormaDataTermino()->getDtTermino())) {
            $dateTermino = $getNorma->getFkNormasNormaDataTermino()->getDtTermino()->format("d/m/Y");
        } else {
            $dateTermino = null;
        }

        if (!is_null($getNorma->getDtPublicacao())) {
            $datePublicacao = $getNorma->getDtPublicacao()->format("d/m/Y");
        } else {
            $datePublicacao = null;
        }

        $item = [];
        $item['dateTermino'] = $dateTermino;
        $item['datePublicacao'] = $datePublicacao;

        return new JsonResponse(['item' => $item]);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function getTipoMembroAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        /** @var TipoMembro $getTipoMembros */
        $getTipoMembros = $entityManager->getRepository(TipoMembro::class)->findAll();

        $item = [];
        $item[] = ['value' => '', 'label' => 'Selecione'];
        foreach ($getTipoMembros as $tipoMembro) {
            $addItem = [];
            $addItem['value'] = (string) $tipoMembro->getCodTipoMembro();
            $addItem['label'] = $tipoMembro->getDescricao();
            $item[] = $addItem;
        }


        return new JsonResponse(['item' => $item]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function inativarAction(Request $request)
    {
        $this->setBreadCrumb();
        $id = $request->query->get('id');

        $em = $this->getDoctrine()->getManager();

        $em->getRepository('CoreBundle:Licitacao\Comissao')->inativar($id);

        $container = $this->container;
        $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('comissaoLicitacao.sucessoDesativado'));

        return $this->redirectToRoute('urbem_patrimonial_licitacao_comissao_list');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function ativarAction(Request $request)
    {
        $this->setBreadCrumb();
        $id = $request->query->get('id');

        $em = $this->getDoctrine()->getManager();

        /** @var Comissao $getComissao */
        $getComissao = $em->getRepository(Comissao::class)->findOneBy(["codComissao" => $id]);
        $exercicioComissao = (int) $getComissao->getFkNormasNorma()->getFkNormasNormaDataTermino()->getDtTermino()->format("Y");
        $anoAtual = (int) $this->getExercicio();
        if ($anoAtual <= $exercicioComissao) {
            $container = $this->container;
            $em->getRepository('CoreBundle:Licitacao\Comissao')->ativar($id);
            $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('comissaoLicitacao.sucessoAtivado'));
        } else {
            $container = $this->container;
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('comissaoLicitacao.erroExcluirLicitacao'));
        }

        return $this->redirectToRoute('urbem_patrimonial_licitacao_comissao_list');
    }
}
