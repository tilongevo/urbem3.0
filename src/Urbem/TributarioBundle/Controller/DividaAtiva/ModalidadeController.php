<?php

namespace Urbem\TributarioBundle\Controller\DividaAtiva;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Model\Tributaria\DividaAtiva\Modalidade\ModalidadeConsolidacaoModel;
use Urbem\CoreBundle\Model\Tributaria\DividaAtiva\Modalidade\ModalidadeInscricaoDividaModel;
use Urbem\CoreBundle\Model\Tributaria\DividaAtiva\Modalidade\ModalidadeModel;
use Urbem\CoreBundle\Model\Tributaria\DividaAtiva\Modalidade\ModalidadeParcelamentoModel;

class ModalidadeController extends BaseController
{
    /**
     * Home
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::DividaAtiva/Modalidade/home.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function filtroAction(Request $request)
    {
        $this->setBreadCrumb();

        $form = $this->generateForm();
        $form->handleRequest($request);

        $result = ['form' => $form->createView()];
        $retorno = $this->render(
            'TributarioBundle::DividaAtiva/Modalidade/filtro.html.twig',
            $result
        );

        if ($form->isSubmitted() && $request->getMethod() == 'POST') {
            $request = $request->request->get('form');
            switch ($request['filtroHome']) {
                case ModalidadeInscricaoDividaModel::MODALIDADE:
                    return $this->redirect($this->generateUrl('urbem_tributario_divida_ativa_modalidade_inscricao_divida_list'));
                    break;
                case ModalidadeConsolidacaoModel::MODALIDADE:
                    return $this->redirect($this->generateUrl('urbem_tributario_divida_ativa_modalidade_consolidacao_list'));
                    break;
                case ModalidadeParcelamentoModel::MODALIDADE:
                    return $this->redirect($this->generateUrl('urbem_tributario_divida_ativa_modalidade_parcelamento_list'));
                    break;
            }
            return $retorno;
        } else {
            return $retorno;
        }
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function generateForm()
    {
        $rotas = new ModalidadeModel($this->getDoctrine()->getEntityManager());
        $form = $this->createFormBuilder([])
            ->add(
                'filtroHome',
                ChoiceType::class,
                [
                    'label' => 'label.dividaAtivaModalidade.dadosParaModalidade',
                    'placeholder' => 'label.selecione',
                    'choices' => array_flip($rotas->getTipoModalidades()->toArray()),
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->setAction($this->generateUrl('tributario_divida_ativa_modalidade_home'))
            ->getForm();

        return $form;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getCreditoAction(Request $request)
    {
        $id = $request->attributes->get('_id');

        $model = new ModalidadeInscricaoDividaModel($this->getDoctrine()->getManager());
        $credito = $model->findModalidadeCredito($id);
        $response = new Response();
        $response->setContent(json_encode(['data' => $credito]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getDocumentoAction(Request $request)
    {
        $id = $request->attributes->get('_id');
        $ids = explode('-', $id);
        $model = new ModalidadeInscricaoDividaModel($this->getDoctrine()->getManager());
        $credito = $model->findOneDocumento($ids[0], $ids[1]);
        $response = new Response();
        $response->setContent(json_encode(['data' => $credito]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
