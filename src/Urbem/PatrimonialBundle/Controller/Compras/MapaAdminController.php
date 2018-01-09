<?php
namespace Urbem\PatrimonialBundle\Controller\Compras;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Orcamento;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MapaAdminController extends Controller
{
    private $layoutDefaultReport = '/bundles/report/gestaoPatrimonial/fontes/RPT/compras/report/design/mapaCompra.rptdesign';

    public function salvarRelatorioAction(Request $request)
    {
        // Para gerar a data por extenso no PHP e em português
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        $ids = $request->attributes->get('id');

        $id = explode('~', $ids);

        $params = array(
            'inCodGestao' => 3,
            'inCodModulo' => 35,
            'inCodRelatorio' => 4,
            'codMapaCompra' => $id[0],
            'stExercicioMapaCompra' => $id[1],
            'boMostraDado' => true
        );

        $apiService = $this->admin->getReportService();
        $filename = "acoesNaoOrcamentarias";
        $apiService->setReportNameFile("acoesNaoOrcamentarias");
        $apiService->setLayoutDefaultReport($this->layoutDefaultReport);
        $res = $apiService->getReportContent($params);

        $response = new Response();
        $response->setStatusCode(200);
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '.pdf";');
        $response->setContent($res->getBody()->getContents());
        $response->sendHeaders();
        $response->send();
    }

    public function anularAllSolicitacoesAction(Request $request)
    {
        list($exercicio,$codMapa) = explode("~", $request->attributes->get('id'));

        $em = $this->getDoctrine()->getManager();

        $mAnulacao = $em->getRepository('CoreBundle:Compras\Mapa')->recuperaMapasAnulacao($codMapa, $exercicio);

        if (count($mAnulacao) > 0) {
            try {
                $mapaSolicitacoes = $em
                    ->getRepository(Compras\MapaSolicitacao::class)
                    ->findBy([
                        'codMapa' =>$mAnulacao->cod_mapa,
                        'exercicio' =>$mAnulacao->exercicio
                    ]);

                $mapa = $em
                    ->getRepository(Compras\Mapa::class)
                    ->findOneBy([
                        'codMapa' =>$mAnulacao->cod_mapa,
                        'exercicio' =>$mAnulacao->exercicio
                    ]);

                foreach ($mapaSolicitacoes as $mapaSolicitacao) {
                    $mensagem = "Anulação Automática";

                    $mapaSolicitacaoAnulacao = new Compras\MapaSolicitacaoAnulacao();
                    $mapaSolicitacaoAnulacao->setFkComprasMapaSolicitacao($mapaSolicitacao);
                    $mapaSolicitacaoAnulacao->setMotivo($mensagem);
                    $em->persist($mapaSolicitacaoAnulacao);
                    $em->flush();

                    $mapaSolicitacoesItens = $em
                        ->getRepository(Compras\SolicitacaoItem::class)
                        ->findBy([
                            'codSolicitacao' =>$mapaSolicitacao->getCodSolicitacao(),
                            'exercicio' => $mAnulacao->exercicio
                        ]);

                    foreach ($mapaSolicitacoesItens as $solicitacaoItem) {
                        $recuperaItem = $em->getRepository('CoreBundle:Compras\MapaItem')->montaRecuperaItensMapa(
                            $solicitacaoItem->getExercicio(),
                            $mapa->getCodMapa()
                        );

                        $dotacao = $solicitacaoItem->getFkComprasMapaItens()->last()->getFkComprasMapaItemDotacoes()->last();

                        $mapaItemAnulacao = new Compras\MapaItemAnulacao();
                        $mapaItemAnulacao->setFkComprasMapaItem($solicitacaoItem->getFkComprasMapaItens()->first());
                        $mapaItemAnulacao->setFkComprasMapaSolicitacaoAnulacao($mapaSolicitacaoAnulacao);
                        $mapaItemAnulacao->setVlTotal($solicitacaoItem->getVlTotal());
                        $mapaItemAnulacao->setQuantidade($solicitacaoItem->getQuantidade());
                        $mapaItemAnulacao->setLote($recuperaItem->lote);
                        $mapaItemAnulacao->setFkComprasMapaItemDotacao($dotacao);
                        $em->persist($mapaItemAnulacao);
                        $em->flush();

                        // Verificar se tem reserva de saldos, se tiver altera a reserva ou anula a reserva, dependendo do valor setado no programa.
                        if (is_numeric($recuperaItem->cod_reserva) && ($solicitacaoItem->getVlTotal() > 0)) {
                            $reservaSaldos = $em
                                ->getRepository(Orcamento\ReservaSaldos::class)
                                ->findOneBy([
                                    'codReserva' => $recuperaItem->cod_reserva,
                                    'exercicio' => $recuperaItem->exercicio_reserva
                                ]);

                            $nuSaldoAtual = $reservaSaldos->getVlReserva();

                            if ($nuSaldoAtual > $solicitacaoItem->getVlTotal()) {
                                $reservaSaldos->setVlReserva($nuSaldoAtual - $solicitacaoItem->getVlTotal());
                            } else {
                                $reservaAnulada = $em
                                    ->getRepository(Orcamento\ReservaSaldosAnulada::class)
                                    ->findOneBy([
                                        'codReserva' => $recuperaItem->cod_reserva,
                                        'exercicio' => $recuperaItem->exercicio_reserva
                                    ]);

                                if (is_null($reservaAnulada)) {
                                    $stMsgReservaAnulada  = "Entidade: ".$mapaSolicitacao->getCodEntidade()->getNumCgm()->getNomCgm().", ";
                                    $stMsgReservaAnulada .= "Mapa de Compras: ".$mapa->getCodMapa()."/".$mapa->getExercicio().", ";
                                    $stMsgReservaAnulada .= "Item: ".$recuperaItem->cod_item.", ";
                                    $stMsgReservaAnulada .= "Centro de Custo: ".$recuperaItem->cod_centro." ";

                                    $reservaSaldosAnulada = new Orcamento\ReservaSaldosAnulada();
                                    $reservaSaldosAnulada->setExercicio($recuperaItem->exercicio_reserva);
                                    $reservaSaldosAnulada->setMotivoAnulacao($stMsgReservaAnulada);
                                    $reservaSaldosAnulada->setFkOrcamentoReservaSaldos($reservaSaldos);
                                    $em->persist($reservaSaldosAnulada);
                                    $em->flush();
                                }
                            }

                            if (is_numeric($recuperaItem->cod_reserva_solicitacao) && is_numeric($recuperaItem->exercicio_reserva_solicitacao)) {
                                $reservaAnuladaSolicitacao = $em
                                    ->getRepository(Orcamento\ReservaSaldosAnulada::class)
                                    ->findOneBy([
                                        'codReserva' => $recuperaItem->cod_reserva_solicitacao,
                                        'exercicio' => $recuperaItem->exercicio_reserva_solicitacao
                                    ]);

                                $reservaSaldoSolicitacao = $em
                                    ->getRepository(Orcamento\ReservaSaldos::class)
                                    ->findOneBy([
                                        'codReserva' => $recuperaItem->cod_reserva_solicitacao,
                                        'exercicio' => $recuperaItem->exercicio_reserva_solicitacao
                                    ]);

                                if (!is_null($reservaAnuladaSolicitacao)) {
                                    //remove
                                    $em->remove($reservaAnuladaSolicitacao);
                                    $em->flush();
                                    $reservaSaldoSolicitacao->setVlReserva($solicitacaoItem->getVlTotal());
                                } else {
                                    $reservaSaldoSolicitacao->setVlReserva($reservaSaldoSolicitacao->getVlReserva() + $solicitacaoItem->getVlTotal());
                                }
                                $em->persist($reservaSaldoSolicitacao);
                                $em->flush();
                            }
                        }
                    }
                }

                $message = $this->admin->trans('patrimonial.anulacaoRequisicaoItem.anular', [], 'flashes');

                $this->container->get('session')
                    ->getFlashBag()
                    ->add('success', $message);
            } catch (Exception $e) {
                throw $e;
                $message = $this->admin->trans('anulacao_item.errors', [], 'validators');

                $this->container->get('session')
                    ->getFlashBag()
                    ->add('error', $message);
            }
        } else {
            $compraDireta = $em->getRepository('CoreBundle:Compras\CompraDireta')->getRecuperaTodos($codMapa, $exercicio);

            if (count($compraDireta) > 0) {
                $message = $this->admin->trans('anulacao_mapa.errors.compra_direta', ['%compraDireta%' => $compraDireta[0]->cod_compra_direta], 'validators');

                $this->container->get('session')
                    ->getFlashBag()
                    ->add('error', $message);
            } else {
                $licitacao = $em->getRepository('CoreBundle:Licitacao\Licitacao')->getRecuperaTodos($codMapa, $exercicio);
                if (count($licitacao) > 0) {
                    $message = $this->admin->trans('anulacao_mapa.errors.licitacao', ['%licitacao%' => $licitacao[0]->cod_licitacao], 'validators');

                    $this->container->get('session')
                        ->getFlashBag()
                        ->add('error', $message);
                }
            }
        }

        (new RedirectResponse($request->headers->get('referer')))->send();
    }
}
