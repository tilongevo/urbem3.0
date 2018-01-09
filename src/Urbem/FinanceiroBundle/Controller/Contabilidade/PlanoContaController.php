<?php

namespace Urbem\FinanceiroBundle\Controller\Contabilidade;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Monetario\Agencia;
use Urbem\CoreBundle\Model\Contabilidade\PlanoContaEncerradaModel;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoContaEncerrada;
use Urbem\CoreBundle\Model\Contabilidade\PlanoContaModel;

class PlanoContaController extends BaseController
{
    public function homeAction()
    {
        $this->setBreadCrumb();

        return $this->render('FinanceiroBundle::Contabilidade/PlanoConta/home.html.twig');
    }

    public function escolhaAction(Request $request)
    {
        $this->setBreadCrumb();

        $model = new PlanoContaModel($this->getDoctrine()->getManager());

        $versao = $model->getVersoesPlanoContaGeralDisponiveis($this->getExercicio());
        $last = $model->getUltimoPlanoContaGeral($this->getExercicio());

        $label = 0 < count($versao) ? array_keys($versao) : ['-'];
        $label = reset($label);

        $form = $this->createFormBuilder();
        $form->add('versao', 'choice', [
            'label' => $label,
            'compound' => false,
            'placeholder' => 'label.selecione',
            'choices' => (!empty($versao) ? reset($versao) : []),
            'choice_label' => function ($value) {
                return $value['versao'];
            },
            'choice_value' => function ($value) {
                return $value['key'];
            },
            'data' => new \ArrayObject(['key' => $last['key']]),
            'attr' => [
                'style' => 'display:block'
            ]
        ]);

        $form = $form->getForm();

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);
            if (true === $form->isValid()) {
                try {
                    $model->savePlanoContaGeral($form->get('versao')->getData());

                    $this->container->get('session')->getFlashBag()->add('success', 'Plano de contas escolhido com sucesso');
                } catch (\Exception $e) {
                    $this->container->get('session')->getFlashBag()->add('error', $e->getMessage());
                }
            }
        }

        return $this->render('FinanceiroBundle::Contabilidade/PlanoConta/escolha.html.twig', [
            'form' => $form->createView(),
            'last' => $last,
        ]);
    }

    public function retornaAgenciaAction(Request $request)
    {
        $codBanco = $request->attributes->get('id');

        $em = $this->getDoctrine()->getManager();
        $agencias = $em->getRepository('CoreBundle:Monetario\\Agencia')->findByCodBanco($codBanco);

        $agenciasArr = [];
        foreach ($agencias as $agencia) {
            $agenciasArr[$agencia->getCodAgencia()] = $agencia->getNomAgencia();
        }

        $response = new Response();
        $response->setContent(json_encode($agenciasArr));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function retornaContaCorrenteAction(Request $request)
    {
        $codAgencia = $request->attributes->get('id');

        $em = $this->getDoctrine()->getManager();
        $contas = $em->getRepository('CoreBundle:Monetario\\ContaCorrente')->findByCodAgencia($codAgencia);

        $contasArr = [];
        foreach ($contas as $conta) {
            $contasArr[$conta->getCodContaCorrente() . '/' . $conta->getNumContaCorrente()] = $conta->getNumContaCorrente();
        }

        $response = new Response();
        $response->setContent(json_encode($contasArr));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function getPlanoContaByExercicioAndEntidadeAndCodEstruturaAction(Request $request)
    {
        $exercicio = $request->query->get('exercicio');
        $entidade = $request->query->get('entidade');
        $codEstrutura = $request->query->get('codEstrutura');

        $planoContas = $this->getDoctrine()
            ->getRepository('CoreBundle:Contabilidade\PlanoConta')
            ->getPlanoContaByExercicioAndEntidadeAndCodEstrutura($exercicio, $entidade, $codEstrutura);

        $listContas = array();
        foreach ($planoContas as $planoConta) {
            $codConta = $planoConta['cod_plano'];
            $codEstrutural = $planoConta['cod_estrutural'];
            $choiceValue = $planoConta['cod_plano'];
            $choiceKey = $codEstrutural . " | " . $codConta . " | " . $planoConta['nom_conta'];
            $listContas[$choiceValue] = $choiceKey;
        }

        $response = new Response();
        $response->setContent(json_encode($listContas));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function encerramentoAction(Request $request)
    {
        $container = $this->container;

        $em = $this->getDoctrine()->getManager();

        try {
            $dataForm = $request->request->all();

            $planoconta_encerrada_model = (new \Urbem\CoreBundle\Model\Contabilidade\PlanoContaEncerradaModel($em));

            $planocontaencerrada = new PlanoContaEncerrada();
            $planocontaencerrada->setCodConta($dataForm['codConta']);
            $planocontaencerrada->setExercicio($dataForm['exercicio']);
            $planocontaencerrada->setTimestamp(new \Datetime());
            $planocontaencerrada->setDtEncerramento(new \Datetime($dataForm['encerramento']['dtEncerramento']));
            $planocontaencerrada->setMotivo($dataForm['encerramento']['motivo']);

            $planoconta_encerrada_model->save($planocontaencerrada);

            $container->get('session')->getFlashBag()->add('success', 'Encerramento de conta realizado com sucesso.');
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', 'Erro ao realizar o encerramento de conta.');
            throw $e;
        }

        $this->redirect('/financeiro/contabilidade/planoconta/list');
    }

    public function cancelaEncerramentoAction(Request $request)
    {
        $container = $this->container;

        $em = $this->getDoctrine()->getManager();

        try {
            $dataForm = $request->request->all();

            $planoContaEncerradaRepository = $em->getRepository('CoreBundle:Contabilidade\PlanoContaEncerrada');
            $planoContaEncerrada = $planoContaEncerradaRepository->findBy(
                array('exercicio' => $dataForm['exercicio'], 'codConta' => $dataForm['codConta'])
            )[0];

            $em->remove($planoContaEncerrada);
            $em->flush();

            $container->get('session')->getFlashBag()->add('success', 'Encerramento de conta realizado com sucesso.');
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', 'Erro ao realizar o encerramento de conta.');
            throw $e;
        }

        $this->redirect('/financeiro/contabilidade/planoconta/list');
    }
}
