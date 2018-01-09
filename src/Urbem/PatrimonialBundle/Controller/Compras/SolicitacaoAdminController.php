<?php

namespace Urbem\PatrimonialBundle\Controller\Compras;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoHomologadaModel;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoModel;

class SolicitacaoAdminController extends Controller
{
    const COD_MODULO_COMPRAS = 35;


    /**
     * @param Request $request
     */
    public function gerarRelatorioAction(Request $request)
    {

        $id = $request->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);

        $container = $this->container;
        $usuario = $container->get('security.token_storage')->getToken()->getUser();
        $registroPrecos = ($object->getRegistroPrecos() == true || $object->getRegistroPrecos() == 1) ? "Sim" : "Não";
        $assinaturas = $request->get('assinatura');
        $dtEmissao = (new \DateTime())->format('Y-m-d H:i:s');

        $assinatura = null;
        if (!empty($request->get('assinatura'))) {
            foreach ($request->get('assinatura') as $index) {
                $assinatura['nomCgm'][$index] = $request->get('nomCgm')[$index];
                $assinatura['cargo'][$index] = $request->get('cargo')[$index];
            }
        }

        $html = $this->renderView(
            'PatrimonialBundle:Compras/SolicitacaoCompra:pdf.html.twig',
            [
                'object' => $object,
                'registroPrecos' => $registroPrecos,
                'assinaturas' => $assinaturas,
                'assinatura' => $assinatura,
                'modulo' => 'Patrimonial',
                'subModulo' => 'Compras\Solicitacao',
                'funcao' => 'Emitir Relatório Compras Solicitação',
                'nomRelatorio' => 'Relatório Compras Solicitação',
                'dtEmissao' => $dtEmissao,
                'usuario' => $usuario,
                'versao' => $container->getParameter('version')
            ]
        );

        $filename = sprintf('Relatorio-Compras-Solicitacao-%s.pdf', date('Y-m-d'));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $html,
                [
                    'encoding' => 'utf-8',
                    'enable-javascript' => false,
                    'footer-line' => true,
                    'footer-left' => 'URBEM - CNM',
                    'footer-right' => '[page]',
                    'footer-center' => 'www.cnm.org.br'
                ]
            ),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
            ]
        );
    }

    /**
     * @param Request $request
     */
    public function homologarSolicitacaoAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $id = $request->get($this->admin->getIdParameter());
        list($exercicio, $codEntidade, $codSolicitacao) = explode("~", $id);
        /** @var Compras\Solicitacao $object */
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw $this->createNotFoundException(sprintf('Impossível encontrar a solicitacao com o id : %s', $id));
        }

        /** @var Compras\SolicitacaoHomologadaAnulacao $solicitacaoHomologadaAnulacao */
        $solicitacaoHomologadaAnulacao = $entityManager
            ->getRepository(Compras\SolicitacaoHomologadaAnulacao::class)
            ->findOneBy(
                [
                    'exercicio' => $exercicio,
                    'codEntidade' => $codEntidade,
                    'codSolicitacao' => $codSolicitacao,
                ]
            );

        /** @var Compras\SolicitacaoHomologada $solicitacaoHomologada */
        $solicitacaoHomologada = $entityManager
            ->getRepository(Compras\SolicitacaoHomologada::class)
            ->findOneBy(
                [
                    'exercicio' => $exercicio,
                    'codEntidade' => $codEntidade,
                    'codSolicitacao' => $codSolicitacao,
                ]
            );

        try {
            $solicitacaoModel = new SolicitacaoModel($entityManager);
            $recuperaRelacionamentoItemHomologacao = $solicitacaoModel->recuperaRelacionamentoItemHomologacao($codEntidade, $codSolicitacao, $exercicio);

            $coModel = new ConfiguracaoModel($entityManager);
            $inExercicio = $this->admin->getExercicio();

            list($ano, $mes, $dia) = explode("-", substr($object->getTimestamp(), 0, 10));

            $boReservaRigida = ($object->getRegistroPrecos()) ? false : true;

            $stMensagem = false;
            $reservaSaldosModel = new Model\Orcamento\ReservaSaldosModel($entityManager);
            foreach ($recuperaRelacionamentoItemHomologacao as $rsListaItens) {
                if (($boReservaRigida) and (!$stMensagem)) {
                    if ($rsListaItens->cod_despesa && $rsListaItens->vl_item_solicitacao > 0.00) {
                        $motivo = "Entidade: " . $object->getCodEntidade() . " - " . $object->getFkOrcamentoEntidade()->getFkSwCgm()->getNomCgm() . ", solicitação de compras: " . $object->getCodSolicitacao() . "/" . $object->getExercicio() . ', Item:' . $rsListaItens->cod_item;
                        $codReserva = $reservaSaldosModel->getProximoCodReserva($inExercicio);
                        $reservaInserida = $reservaSaldosModel->montaincluiReservaSaldo($codReserva, $inExercicio, $rsListaItens->cod_despesa, $dia . "/" . $mes . "/" . $ano, '31/12/' . $rsListaItens->exercicio, $rsListaItens->vl_item_solicitacao, 'A', $motivo);
                        if ($reservaInserida[0]['fn_reserva_saldo'] == false) {
                            $stMensagem = " Não foi possivel efetuar reserva de saldos para o item ";
                            $stMensagem .= $rsListaItens->cod_item . " - " . $rsListaItens->descricao_resumida;
                            $stMensagem .= " a dotação " . $rsListaItens->cod_despesa . ' não possui saldo suficiente.';
                        } else {
                            $rsListaItens->cod_reserva = $codReserva;
                        }
                    }
                }
            }

            if ((!$boReservaRigida) or ($boReservaRigida and !$stMensagem)) {
                foreach ($recuperaRelacionamentoItemHomologacao as $rsListaItens) {
                    if ($rsListaItens->cod_reserva) {
                        $solicitacaoHomologadaReserva = new Model\Patrimonial\Compras\SolicitacaoHomologadaReservaModel($entityManager);
                        $solicitacaoItemDotacaoModel = new Model\Patrimonial\Compras\SolicitacaoItemDotacaoModel($entityManager);
                        $solicitacaoItemDotacao = $solicitacaoItemDotacaoModel->getOneSolicitacaoItemDotacao($exercicio, $codEntidade, $codSolicitacao, $rsListaItens->cod_centro, $rsListaItens->cod_item, $rsListaItens->cod_conta, $rsListaItens->cod_despesa);
                        $reservaSaldos = $reservaSaldosModel->getOneReservaSaldos($rsListaItens->cod_reserva, $rsListaItens->exercicio);

                        if (!is_null($solicitacaoHomologada)) {
                            $solicitacaoHomologadaReserva->saveReservaSaldosObject($solicitacaoHomologada, $solicitacaoItemDotacao, $reservaSaldos);
                        }
                    }
                }

                if (is_null($solicitacaoHomologada)) {
                    $solicitacaoHomologacao = new SolicitacaoHomologadaModel($entityManager);
                    /** @var Compras\SolicitacaoHomologada $solicitacaoHomologada */
                    $solicitacaoHomologacao->salvaSolicitacaoHomologada($this->admin->getExercicio(), $object);
                } else {
                    if (!is_null($solicitacaoHomologadaAnulacao)) {
                        $solicitacaoModel->remove($solicitacaoHomologadaAnulacao);
                    }
                }
            }

            if ($stMensagem) {
                $this->container->get('session')
                    ->getFlashBag()
                    ->add('error', $stMensagem);
                (new RedirectResponse($request->headers->get('referer')))->send();
            } else {
                $message = $this->admin->trans('patrimonial.solicitacao_compra.homologacao', [], 'flashes');
                $this->container->get('session')
                    ->getFlashBag()
                    ->add('success', $message);
            }
        } catch (Exception $e) {
            $message = $this->admin->trans('patrimonial.solicitacao_compra.homologacao_error', [], 'flashes');
            $this->container->get('session')
                ->getFlashBag()
                ->add('error', $message);
        }
        (new RedirectResponse($request->headers->get('referer')))->send();
    }

    /**
     * @param Request $request
     */
    public function anularHomologacaoSolicitacaoAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $id = $request->get($this->admin->getIdParameter());
        list($exercicio, $codEntidade, $codSolicitacao) = explode("~", $id);
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw $this->createNotFoundException(sprintf('Impossível encontrar a solicitacao com o código : %s', $codSolicitacao));
        }

        $solicitacao = new SolicitacaoModel($entityManager);
        $permissao = $solicitacao->montaRecuperaPermissaoAnularHomologacao($codSolicitacao, $object->getCodEntidade(), $object->getExercicio());

        if ($permissao) {
            $rsReservas = $solicitacao->montaRecuperaTodosNomEntidade($object->getExercicio(), $object->getCodEntidade(), $codSolicitacao);
            try {
                if (count($rsReservas) > 0) {
                    $solicitacaoHomologadaReserva = $entityManager
                        ->getRepository(Compras\SolicitacaoHomologadaReserva::class)
                        ->findBy(
                            [
                                'exercicio' => $exercicio,
                                'codEntidade' => $codEntidade,
                                'codSolicitacao' => $codSolicitacao,
                            ]
                        );

                    foreach ($solicitacaoHomologadaReserva as $itemReserva) {
                        $solicitacaoReserva = $entityManager
                            ->getRepository(Orcamento\ReservaSaldos::class)
                            ->findOneByCodReserva($itemReserva->getCodReserva());

                        $entityManager->remove($itemReserva);
                        $entityManager->flush();

                        $obReservaSaldoAnulada = new Entity\Orcamento\ReservaSaldosAnulada();

                        $stMsgAnulacao = " Anulação Automática. Entidade: " . $object->getCodEntidade() . " - " . $object->getFkSwCgm()->getNomCgm() . ",";
                        $stMsgAnulacao .= " Solicitação de Compras: " . $codSolicitacao . "/" . $object->getExercicio();

                        $obReservaSaldoAnulada->setExercicio($object->getExercicio());
                        $obReservaSaldoAnulada->setMotivoAnulacao($stMsgAnulacao);
                        $obReservaSaldoAnulada->setFkOrcamentoReservaSaldos($solicitacaoReserva);

                        $entityManager->persist($obReservaSaldoAnulada);
                    }
                }

                //solicitacao_homologada_anulacao
                $solicitacaoHomologadaAnulacao = new Compras\SolicitacaoHomologadaAnulacao();
                $solicitacaoHomologadaAnulacao->setNumcgm($this->admin->getCurrentUser()->getNumCgm());
                $solicitacaoHomologadaAnulacao->setFkComprasSolicitacaoHomologada($object->getFkComprasSolicitacaoHomologada());

                $entityManager->persist($solicitacaoHomologadaAnulacao);
                $entityManager->flush();

                $message = $this->admin->trans('patrimonial.solicitacao_compra.anular_homologacao', [], 'flashes');

                $this->container->get('session')
                    ->getFlashBag()
                    ->add('success', $message);
            } catch (Exception $e) {
                $message = $this->admin->trans('patrimonial.solicitacao_compra.anular_homologacao_erro', [], 'flashes');

                $this->container->get('session')
                    ->getFlashBag()
                    ->add('error', $message);
            }
        } else {
            $message = $this->admin->trans('patrimonial.solicitacao_compra.anular_homologacao_mapa_error', [], 'flashes');

            $this->container->get('session')
                ->getFlashBag()
                ->add('error', $message);
        }
        (new RedirectResponse($request->headers->get('referer')))->send();
    }
}
