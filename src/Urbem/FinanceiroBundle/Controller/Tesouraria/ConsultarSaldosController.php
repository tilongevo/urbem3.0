<?php

namespace Urbem\FinanceiroBundle\Controller\Tesouraria;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Helper\ArrayHelper;

class ConsultarSaldosController extends BaseController
{

    public function consultarAction(Request $request)
    {
        $this->setBreadCrumb();
        $form = $this->generateForm();
        $form->handleRequest($request);

        $retorno = ['form' => $form->createView()];
        if ($form->isSubmitted() && $request->getMethod() == 'POST') {
            $dadosRequest = $request->request->get('form');

            //Retorna os dados que serão exibidos na view
            $dadosRetorno = $this->montaRetornoConta($dadosRequest);
            $retorno['consultaRetorno'] = $dadosRetorno;
        }
        return $this->render(
            'FinanceiroBundle::Tesouraria/Saldos/consultarSaldos.html.twig',
            $retorno
        );
    }

    private function generateForm()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:Tesouraria\\SaldoTesouraria');
        $contas = ArrayHelper::parseArrayToChoice($repository->findAllContasPorEntidade(null, $this->getExercicio()), 'nom_conta', 'cod_plano');
        $entidades =  ArrayHelper::parseArrayToChoice($repository->getEntidadesValidas($this->getUser()->getId(), $this->getExercicio()), 'nom_cgm', 'cod_entidade');
        $form = $this->createFormBuilder([])
            ->add(
                'entidade',
                ChoiceType::class,
                [
                    'required' => true,
                    'choices' => $entidades,
                    'label' => 'label.entidades',
                    'placeholder' => 'label.selecione',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'codPlano',
                ChoiceType::class,
                [
                    'required' => true,
                    'choices' => $contas,
                    'choice_value' => function ($value) {
                        return $value;
                    },
                    'label' => 'label.lote.codConta',
                    'placeholder' => 'label.selecione',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'dtSaldo',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'label.tesouraria.saldos.dataSaldo',
                    'attr' => [
                        'class' => 'datepicker'
                    ]
                ]
            )
            ->add('exercicio', 'hidden', ['data' => $this->getExercicio()])
            ->setAction($this->generateUrl('tesouraria_saldos_consultar'))
            ->getForm();

        return $form;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function buscarContaAction(Request $request)
    {
        $entidade = (int) $request->request->get('entidade');
        $exercicio = $request->request->get('exercicio');
        if (!empty($entidade)) {
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('CoreBundle:Tesouraria\SaldoTesouraria');
            $retornoContas = $repository->findAllContasPorEntidade($entidade, $exercicio);
            $contas = ArrayHelper::parseArrayToChoice($retornoContas, 'cod_plano', 'nom_conta');
        } else {
            $contas = [];
        }
        $response = new Response();
        $response->setContent(json_encode(['contas' => $contas]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Esse metodo tem a função de montar um array com os dados que vai ser exibido na view
     * @param $form
     * @return array
     */
    private function montaRetornoConta($form)
    {
        $retorno = [];
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:Tesouraria\SaldoTesouraria');

        $entidade = $repository->getEntidadesValidas($this->getUser()->getId(), $this->getExercicio(), $form['entidade']);

        if (!empty($entidade)) {
            $retorno['entidade'] = $form['entidade'] . " - " . $entidade['nom_cgm'];
        }

        if (!empty($form['codPlano'])) {
            $conta = $repository->findContaPorPlano($form['codPlano']);
            if (!empty($conta)) {
                $retorno['conta'] = $form['codPlano'] . " - " . $conta['nom_conta'];
            }
        }

        $params = [$this->getExercicio(), (int) $form['codPlano'], "01/01/" . $this->getExercicio(), $form['dtSaldo']];
        $saldo = $repository->consultarSaldo($params);

        $retorno['dataSaldo'] = $form['dtSaldo'];
        $retorno['saldo'] = $saldo['saldo'];

        return $retorno;
    }
}
