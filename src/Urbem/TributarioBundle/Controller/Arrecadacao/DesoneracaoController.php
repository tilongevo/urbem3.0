<?php

namespace Urbem\TributarioBundle\Controller\Arrecadacao;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Arrecadacao\Desonerado;

/**
 * Class DesoneracaoController
 * @package Urbem\TributarioBundle\Controller\Arrecadacao
 */
class DesoneracaoController extends BaseController
{
    const FILTRO_TIPO_CONTRIBUINTE = 'contribuinte';
    const FILTRO_TIPO_GRUPO = 'grupo';

    /**
     * Home
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::Arrecadacao/Desoneracao/home.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function filtroAction(Request $request)
    {
        $this->setBreadCrumb();

        $form = $this->generateForm();
        $form->handleRequest($request);

        $result = ['form' => $form->createView()];

        if ($form->isSubmitted() && $request->getMethod() == 'POST') {
            $request = $request->request->get('form');
            $tipo = $request['concessao'];

            if ($tipo == self::FILTRO_TIPO_CONTRIBUINTE) {
                return $this->redirect($this->generateUrl('urbem_tributario_arrecadacao_desoneracao_conceder_desoneracao_create'));
            } elseif ($tipo == self::FILTRO_TIPO_GRUPO) {
                return $this->redirect($this->generateUrl('urbem_tributario_arrecadacao_desoneracao_conceder_desoneracao_grupo_create'));
            }
        } else {
            return $this->render(
                'TributarioBundle::Arrecadacao/Desoneracao/Conceder/filtro.html.twig',
                $result
            );
        }
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function generateForm()
    {
        $tipos = [
            self::FILTRO_TIPO_CONTRIBUINTE => 'label.concederDesoneracao.contribuinte',
            self::FILTRO_TIPO_GRUPO => 'label.concederDesoneracao.grupo',
        ];

        $tipos = array_flip($tipos);
        $form = $this->createFormBuilder([])
            ->add(
                'concessao',
                ChoiceType::class,
                [
                    'label' => 'label.concederDesoneracao.concessaoPor',
                    'placeholder' => 'label.selecione',
                    'choices' => $tipos,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->setAction($this->generateUrl('tributario_arrecadacao_conceder_desoneracao_filtro'))
            ->getForm();

        return $form;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function prorrogarAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        try {
            $dataForm = $request->request->all();

            $codDesoneracao = $dataForm['codDesoneracao'];
            $numcgm = $dataForm['numcgm'];
            $ocorrencia = $dataForm['ocorrencia'];

            $params = array('codDesoneracao' => $codDesoneracao, 'numcgm' => $numcgm, 'ocorrencia' => $ocorrencia);

            $desonerado = $em->getRepository(Desonerado::class)->findOneBy($params);

            if ($this->isValidProrrogar($request, $desonerado)) {
                $desonerado->setDataProrrogacao(\DateTime::createFromFormat('d/m/Y', $dataForm['prorrogar']['dataProrrogacao']));

                $em->persist($desonerado);
                $em->flush();

                $this->container->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans(
                        'label.prorrogarDesoneracao.sucesso',
                        array('%desoneracao%' => $codDesoneracao)
                    )
                );
                return (new RedirectResponse($this->generateUrl('urbem_tributario_arrecadacao_desoneracao_conceder_desoneracao_list')))->send();
            } else {
                return (new RedirectResponse($this->generateUrl('urbem_tributario_arrecadacao_desoneracao_conceder_desoneracao_prorrogar', ['id' => implode('~', $params)])))->send();
            }
        } catch (\Exception $e) {
            $this->container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.prorrogarDesoneracao.erro'));
            return (new RedirectResponse($this->generateUrl('urbem_tributario_arrecadacao_desoneracao_conceder_desoneracao_prorrogar', ['id' => implode('~', $params)])))->send();
        }
    }

    /**
     * @param Request $request
     * @param Desonerado $desonerado
     * @return bool
     */
    private function isValidProrrogar(Request $request, Desonerado $desonerado)
    {
        $dataForm = $request->request->all();

        $termino = null;
        $valid = true;

        if ($desonerado->getFkArrecadacaoDesoneracao()) {
            $termino = $desonerado->getFkArrecadacaoDesoneracao()->getTermino()->format('Y-m-d');
        }

        $dataProrrogacaoAtual = $desonerado->getDataProrrogacao();

        $dataProrrogacao = \DateTime::createFromFormat('d/m/Y', $dataForm['prorrogar']['dataProrrogacao']);

        if (!is_null($dataProrrogacaoAtual) && $dataProrrogacao->format('Y-m-d') <= $dataProrrogacaoAtual->format('Y-m-d')) {
            $this->container->get('session')->getFlashBag()->add(
                'error',
                $this->get('translator')->trans(
                    'label.prorrogarDesoneracao.erroDataInvalida',
                    array('%dataprorrogacaoAtual%' => $dataProrrogacaoAtual->format('d/m/Y'))
                )
            );
            $valid = false;
        }

        if (is_null($termino) || $dataProrrogacao->format('Y-m-d') < $termino) {
            $this->container->get('session')->getFlashBag()->add(
                'error',
                $this->get('translator')->trans(
                    'label.prorrogarDesoneracao.erroDataProrrogacao',
                    array('%termino%' => $desonerado->getFkArrecadacaoDesoneracao()->getTermino()->format('d/m/Y'))
                )
            );
            $valid = false;
        }

        return $valid;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function revogarAction(Request $request)
    {
        $container = $this->container;
        $em = $this->getDoctrine()->getManager();

        try {
            $dataForm = $request->request->all();

            $codDesoneracao = $dataForm['codDesoneracao'];
            $numcgm = $dataForm['numcgm'];
            $ocorrencia = $dataForm['ocorrencia'];

            $params = array('codDesoneracao' => $codDesoneracao, 'numcgm' => $numcgm, 'ocorrencia' => $ocorrencia);

            $desonerado = $em->getRepository(Desonerado::class)->findOneBy($params);

            $dataRevogacao = \DateTime::createFromFormat('d/m/Y', $dataForm['revogar']['dataRevogacao']);

            $desonerado->setDataRevogacao($dataRevogacao);

            $em->persist($desonerado);
            $em->flush();

            $container->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans(
                    'label.revogarDesoneracao.sucesso',
                    array('%desoneracao%' => $codDesoneracao)
                )
            );
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.revogarDesoneracao.erro'));
            return (new RedirectResponse($this->generateUrl('urbem_tributario_arrecadacao_desoneracao_conceder_desoneracao_revogar', ['id' => implode('~', $params)])))->send();
        }

        return (new RedirectResponse($this->generateUrl('urbem_tributario_arrecadacao_desoneracao_conceder_desoneracao_list')))->send();
    }
}
