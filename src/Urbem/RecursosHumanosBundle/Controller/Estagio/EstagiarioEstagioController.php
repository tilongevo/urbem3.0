<?php

namespace Urbem\RecursosHumanosBundle\Controller\Estagio;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;

use Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio;
use Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioBolsa;
use Urbem\CoreBundle\Repository\RecursosHumanos\Estagio;

/**
 * Estagio\EstagiarioEstagio controller.
 */
class EstagiarioEstagioController extends ControllerCore\BaseController
{
    const VIEW_PATH = "RecursosHumanosBundle::Estagio/Estagiarios";

    /**
     * Lists all Estagio\EstagiarioEstagio entities.
     *
     */
    public function indexAction(Request $request)
    {
        $this->setBreadcrumb();

        $em = $this->getDoctrine()->getManager();

        $estagiarios = $em->getRepository('CoreBundle:Estagio\EstagiarioEstagio')->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $estagiarios,
            $request->query->get('page', 1),
            $this->itensPerPage
        );

        return $this->render(
            self::VIEW_PATH . '/index.html.twig',
            array('estagiarios' => $pagination)
        );
    }

    /**
     * Creates a new Estagio\EstagiarioEstagio entity.
     *
     */
    public function newAction(Request $request)
    {
        $this->setBreadcrumb();

        $estagiario = new EstagiarioEstagio();
        $form = $this->createForm('Urbem\RecursosHumanosBundle\Form\Estagio\EstagiarioEstagioType', $estagiario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($estagiario->getEstagiarioEstagioBolsa() as $estagiarioEstagioBolsa) {
                $estagiarioEstagioBolsa->setCodEstagio($estagiario);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($estagiario);
            $em->flush();

            return $this->redirectToRoute('estagio_estagiario_show', array('id' => $estagiario->getId()));
        }

        return $this->render(
            self::VIEW_PATH . '/new.html.twig',
            array(
                'estagiario' => $estagiario,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a Estagio\EstagiarioEstagio entity.
     *
     */
    public function showAction(EstagiarioEstagio $estagiario)
    {
        $this->setBreadcrumb(array('id' => $estagiario->getId()));

        $deleteForm = $this->createDeleteForm($estagiario);

        return $this->render(
            self::VIEW_PATH . '/show.html.twig',
            array(
                'estagiario' => $estagiario,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing Estagio\EstagiarioEstagio entity.
     *
     */
    public function editAction(Request $request, EstagiarioEstagio $estagiario)
    {
        $this->setBreadcrumb(array('id' => $estagiario->getId()));

        $deleteForm = $this->createDeleteForm($estagiario);
        $editForm = $this->createForm('Urbem\RecursosHumanosBundle\Form\Estagio\EstagiarioEstagioType', $estagiario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($estagiario);
            $em->flush();

            return $this->redirectToRoute('estagio_estagiario_edit', array('id' => $estagiario->getId()));
        }

        return $this->render(
            self::VIEW_PATH . '/edit.html.twig',
            array(
                'estagiario' => $estagiario,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a Estagio\EstagiarioEstagio entity.
     *
     */
    public function deleteAction(Request $request, EstagiarioEstagio $estagiario)
    {
        $form = $this->createDeleteForm($estagiario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($estagiario);
            $em->flush();
        }

        return $this->redirectToRoute('estagio_estagiario_index');
    }

    /**
     * Creates a form to delete a Estagio\EstagiarioEstagio entity.
     *
     * @param EstagiarioEstagio $estagiario The Estagio\EstagiarioEstagio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EstagiarioEstagio $estagiario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('estagio_estagiario_delete', array('id' => $estagiario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function findGrauByInstituicaoEnsinoAction(Request $request)
    {
        $instituicaoEnsinoId = $request->get('instituicao_ensino');

        if (empty($instituicaoEnsinoId)) {
            return new Response();
        }

        $instituicaoEnsino = $this->getDoctrine()
            ->getRepository('CoreBundle:Estagio\InstituicaoEnsino')
            ->find($instituicaoEnsinoId);

        $swCgmPessoasJuridicas = $this->getDoctrine()
            ->getRepository('CoreBundle:Estagio\InstituicaoEnsino')
            ->findBy(array('numcgm' => $instituicaoEnsino->getNumcgm()));

        $grauCollection = array();

        foreach ($swCgmPessoasJuridicas as $swCgmPessoaJuridica) {
            $grau = $swCgmPessoaJuridica->getCodCurso()->getCodGrau();
            $grauArr = array(
                'cod_grau'  => $grau->getCodGrau(),
                'descricao' => $grau->getDescricao()
            );

            if (!in_array($grauArr, $grauCollection)) {
                array_push($grauCollection, $grauArr);
            }
        }

        $response = new Response();
        $response->setContent(json_encode($grauCollection));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function findCursoByInstituicaoEnsinoAndCursoAction(Request $request)
    {
        $instituicaoEnsinoId = $request->get('instituicao_ensino');
        $grauId = $request->get('grau');

        if (empty($instituicaoEnsinoId) || empty($grauId)) {
            return new Response();
        }

        $instituicaoEnsino = $this->getDoctrine()
            ->getRepository('CoreBundle:Estagio\InstituicaoEnsino')
            ->find($instituicaoEnsinoId);

        $swCgmPessoasJuridicas = $this->getDoctrine()
            ->getRepository('CoreBundle:Estagio\InstituicaoEnsino')
            ->findBy(array('numcgm' => $instituicaoEnsino->getNumcgm()));

        $cursoCollection = array();

        foreach ($swCgmPessoasJuridicas as $swCgmPessoaJuridica) {
            $curso = $swCgmPessoaJuridica->getCodCurso();
            if ($curso->getCodGrau()->getId() == $grauId) {
                $cursoArr = array(
                    'cod_curso' => $curso->getCodCurso(),
                    'nom_curso' => $curso->getNomCurso()
                );

                if (!in_array($cursoArr, $cursoCollection)) {
                    array_push($cursoCollection, $cursoArr);
                }
            }
        }

        $response = new Response();
        $response->setContent(json_encode($cursoCollection));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function findAgenciaByBancoAction(Request $request)
    {
        $bancoId = $request->get('banco');

        if (empty($bancoId)) {
            return new Response();
        }

        $banco = $this->getDoctrine()
            ->getRepository('CoreBundle:Monetario\Banco')
            ->find($bancoId);

        $agencias = $this->getDoctrine()
            ->getRepository('CoreBundle:Monetario\Agencia')
            ->findBy(array('codBanco' => $banco));

        $agenciaCollection = array();

        foreach ($agencias as $agencia) {
            array_push($agenciaCollection, array(
                'id' => $agencia->getId(),
                'num_agencia_nom_agencia' => $agencia->getNumAgencia() . ' - ' . $agencia->getNomAgencia()
            ));
        }

        $response = new Response();
        $response->setContent(json_encode($agenciaCollection));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function findCgmAction(Request $request)
    {
        $swnumcgm = $request->request->get('cgm');

        $swCgm = $this->getDoctrine()
            ->getRepository('CoreBundle:SwCgmPessoaFisica')
            ->findOneByNumcgm($swnumcgm);

        $dados = array();
        $dados['cpf']       = $swCgm->getCpf();
        $dados['rg']        = $swCgm->getRg();
        $dados['endereco']  = $swCgm->getNumcgm()->getLogradouro()
                              . ', '
                              . $swCgm->getNumcgm()->getNumero()
                              . ' - '
                              . $swCgm->getNumcgm()->getBairro()
                              . ' - '
                              . $swCgm->getNumcgm()->getCodMunicipio()->getNomMunicipio();
        $dados['telefone']  = $swCgm->getNumcgm()->getFoneResidencial();
        $dados['celular']   = $swCgm->getNumcgm()->getFoneCelular();
        $dados['email']     = $swCgm->getNumcgm()->getEmail();

        $response = new Response();
        $response->setContent(json_encode($dados));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function findValorBolsaByCursoAction(Request $request)
    {

        $instituicaoEnsino = $this->getDoctrine()
            ->getRepository('CoreBundle:Estagio\InstituicaoEnsino')
            ->findOneById($request->get('cgm'));

        $cursoArr = array();

        if (!is_null($instituicaoEnsino)) {
            $cursoArr = array(
                'vl_bolsa' => $instituicaoEnsino->getVlBolsa()
            );
        }

        $response = new Response();
        $response->setContent(json_encode($cursoArr));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function findGradeAction(Request $request)
    {
        $product = [];

        if (($request->get('grade')) != ""){
            $em = $this->getDoctrine()->getManager();
            $product = $em->getRepository('CoreBundle:Pessoal\FaixaTurno')->getFaixaTurno($request->get('grade'));
        }

        $response = new Response();
        $response->setContent(json_encode($product));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function findSecretariaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('CoreBundle:Organograma\Orgao')->findSecretaria();

        /**
         * @TODO Tarefa incompleta, o @Elton estava trabalhando nisso parou no meio...
         * por ser tratar de um erro de PSR e não deveria estar na master, estamos lançando uma exception =/
         */
        throw new \RuntimeException($product);
        exit();

        return $product;
    }
}
