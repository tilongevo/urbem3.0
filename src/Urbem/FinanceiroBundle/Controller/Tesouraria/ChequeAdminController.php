<?php

namespace Urbem\FinanceiroBundle\Controller\Tesouraria;

use Doctrine\Common\Collections\ArrayCollection;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoAnulada;
use Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoBaixa;
use Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoBaixaAnulada;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

class ChequeAdminController extends Controller
{
    private $routeBase = 'urbem_financeiro_tesouraria_cheque';

    /**
     * @param Request $request
     * @return Response
     */
    public function agenciasPorBancoAction(Request $request)
    {
        $codBanco = $request->request->get('banco');
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:Tesouraria\Cheque');
        $agencias = $repository->findAllAgenciasPorBancoExercicio($codBanco, $this->admin->getExercicio());
        $agencias = ArrayHelper::parseArrayToChoice($agencias, 'cod_agencia', 'nom_agencia');

        $response = new Response();
        $response->setContent(json_encode(['dados' => $agencias]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Busca as contas correntes por banco e agencia
     * Retorno JSON
     * @param Request $request
     * @return Response
     */
    public function ccPorAgenciaAction(Request $request)
    {
        $codBanco = $request->request->get('banco');
        $codAgencia = $request->request->get('agencia');

        $em = $this->getDoctrine()->getManager();
        $repositoryBanco = $em->getRepository('CoreBundle:Monetario\Banco');
        $banco = $repositoryBanco->findOneBy(['codBanco' => $codBanco]);

        $repositoryAgencia = $em->getRepository('CoreBundle:Monetario\Agencia');
        $agencia = $repositoryAgencia->findOneBy(['codAgencia' => $codAgencia, 'codBanco' => $banco->getCodBanco()]);

        $repository = $em->getRepository('CoreBundle:Tesouraria\Cheque');
        $contaCorrente = $repository->findAllContasCorrentePorBancoAgenciaExercicio($banco->getNumBanco(), $agencia->getNumAgencia(), $this->admin->getExercicio());

        $contaCorrente = ArrayHelper::parseArrayToChoice($contaCorrente, 'cod_conta_corrente', 'num_conta_corrente');

        $response = new Response();
        $response->setContent(json_encode(['dados' => $contaCorrente]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Busca o ultimo cheque cadastrado para um determinado banco, agencia e conta corrente
     * Retorn Json
     * @param Request $request
     * @return Response
     */
    public function ultimoChequeAction(Request $request)
    {
        $codContaCorrente = $request->request->get('contaCorrente');
        $codBanco = $request->request->get('banco');
        $codAgencia = $request->request->get('agencia');

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:Tesouraria\Cheque');

        $cheque = $repository->findOneBy(['codContaCorrente' => $codContaCorrente, 'codBanco' => $codBanco, 'codAgencia' => $codAgencia], ['numCheque' => 'DESC']);
        $numCheque = 0;
        if (!empty($cheque)) {
            $numCheque = $cheque->getNumCheque();
        }
        $response = new Response();
        $response->setContent(json_encode(['value' => $numCheque]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Busca cheques para um determinado banco, agencia e conta corrente
     * @param Request $request
     * @return Response
     */
    public function chequesPorCcAction(Request $request)
    {
        $codContaCorrente = $request->request->get('contaCorrente');
        $codBanco = $request->request->get('banco');
        $codAgencia = $request->request->get('agencia');
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:Tesouraria\Cheque');
        $cheques = ArrayHelper::parseArrayToChoice($repository->findByCheques($codBanco, $codAgencia, $codContaCorrente), 'numCheque', 'numCheque');
        $response = new Response();
        $response->setContent(json_encode(['dados' => $cheques]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function anularEmissaoAction(Request $request)
    {
        list($codAgencia, $codBanco, $codContaCorrente, $numCheque) = explode("~", $request->attributes->get('id'));

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:Tesouraria\Cheque');
        $status = $repository->findChequeEmitido($codBanco, $codAgencia, $codContaCorrente, $numCheque);
        $container = $this->container;
        if (!empty($status)) {
            $cheque = $repository->findOneBy(['codContaCorrente' =>  $codContaCorrente, 'codBanco' => $codBanco, 'codAgencia' => $codAgencia, 'numCheque' => $numCheque]);

            $chequeEmissaoAnulada = new ChequeEmissaoAnulada();
            $chequeEmissaoAnulada->setFkTesourariaCheque($cheque);
            $chequeEmissaoAnulada->setTimestampEmissao($cheque->getFkTesourariaChequeEmissoes()->first()->getTimestampEmissao());

            try {
                $em->persist($chequeEmissaoAnulada);
                $em->flush();
                $container->get('session')->getFlashBag()->add('success', 'Emissão anulada com sucesso!');
            } catch (\Exception $e) {
                $container->get('session')->getFlashBag()->add('error', 'Erro ao anular a emissão.');
            }
        }

        return $this->redirectToRoute($this->routeBase . '_list');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function emissaoBaixarAction(Request $request)
    {
        list($codAgencia, $codBanco, $codContaCorrente, $numCheque) = explode("~", $request->attributes->get('id'));

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:Tesouraria\Cheque');
        $chequeEmissao = $repository->findChequeEmitido($codBanco, $codAgencia, $codContaCorrente, $numCheque);
        $container = $this->container;

        if (!empty($chequeEmissao)) {
            $repository = $em->getRepository('CoreBundle:Tesouraria\ChequeEmissao');
            $cheque = $repository->findOneBy([
                'codContaCorrente' => $codContaCorrente,
                'codBanco' => $codBanco,
                'codAgencia' => $codAgencia,
                'numCheque' => $numCheque
            ]);

            $chequeEmissaoBaixa = new ChequeEmissaoBaixa();
            $chequeEmissaoBaixa->setTimestampEmissao(new DateTimeMicrosecondPK($chequeEmissao['timestamp_emissao']));
            $chequeEmissaoBaixa->setFkTesourariaCheque($cheque->getFkTesourariaCheque());

            try {
                $em->persist($chequeEmissaoBaixa);
                $em->flush();
                $container->get('session')->getFlashBag()->add('success', 'Cheque baixado com sucesso!');
            } catch (\Exception $e) {
                $container->get('session')->getFlashBag()->add('error', 'Erro ao baixar o cheque.');
            }
        }

        return $this->redirectToRoute($this->routeName(), ['id' => $request->query->get('transferencia')]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function emissaoAnularBaixaAction(Request $request)
    {
        list($codAgencia, $codBanco, $codContaCorrente, $numCheque) = explode("~", $request->attributes->get('id'));

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:Tesouraria\Cheque');
        $chequeEmissao = $repository->findChequeEmitido($codBanco, $codAgencia, $codContaCorrente, $numCheque);
        $container = $this->container;

        if (!empty($chequeEmissao)) {
            $repository = $em->getRepository('CoreBundle:Tesouraria\ChequeEmissaoBaixa');
            $cheque = $repository->findOneBy([
                'codContaCorrente' => $codContaCorrente,
                'codBanco' => $codBanco,
                'codAgencia' => $codAgencia,
                'numCheque' => $numCheque
            ]);

            $chequeEmissaoBaixa = new ChequeEmissaoBaixaAnulada();
            $chequeEmissaoBaixa->setFkTesourariaCheque($cheque->getFkTesourariaCheque());
            $chequeEmissaoBaixa->setTimestampEmissao(new DateTimeMicrosecondPK($chequeEmissao['timestamp_emissao']));
            $chequeEmissaoBaixa->setTimestampBaixa($cheque->getTimestampBaixa());

            try {
                $em->persist($chequeEmissaoBaixa);
                $em->flush();
                $container->get('session')->getFlashBag()->add('success', 'Baixa Anulada com sucesso!');
            } catch (\Exception $e) {
                $container->get('session')->getFlashBag()->add('error', 'Erro ao anular a baixa.');
            }
        }

        return $this->redirectToRoute($this->routeName(), ['id' => $request->query->get('transferencia')]);
    }

    /**
     * Retorna o routeName, dependendo da origem do request
     * @return null
     */
    protected function routeName()
    {
        $reference = new ArrayCollection();
        $arrayTransferencia = clone $reference;
        $arrayOrdemPagamento = clone $reference;

        $arrayTransferencia->set('routeName', 'urbem_financeiro_tesouraria_cheque_emissao_transferencia_edit');
        $arrayTransferencia->set('reference', 'emissao-transferencia');
        $arrayOrdemPagamento->set('routeName', 'urbem_financeiro_tesouraria_cheque_emissao_ordem_pagamento_edit');
        $arrayOrdemPagamento->set('reference', 'emissao-ordem-pagamento');

        $reference->set('transferencia', $arrayTransferencia);
        $reference->set('ordem-pagamento', $arrayOrdemPagamento);
        $routeName = null;
        foreach ($reference as $key => $item) {
            if (strpos($this->getRequest()->headers->get('referer'), $item->get('reference'))) {
                $routeName = $item->get('routeName');
                break;
            }
        }
        return $routeName;
    }
}
