<?php

namespace Urbem\PatrimonialBundle\Controller\Compras;

use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;

use Symfony\Component\Form\Form;

use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Compras\Solicitacao;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoItem;
use Urbem\CoreBundle\Entity\Orcamento\ContaDespesa;
use Urbem\CoreBundle\Entity\Orcamento\Despesa;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Orcamento\DespesaModel;
use Urbem\CoreBundle\Model\Orcamento\ReservaSaldosModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoHomologadaModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoHomologadaReservaModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoItemDotacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class SolicitacoesItensAdminController
 *
 * @package Urbem\PatrimonialBundle\Controller\Compras
 */
class IncluirOutraSolicitacaoController extends CRUDController
{
    /** @var AbstractSonataAdmin */
    protected $admin;

    /**
     * @return Form
     */
    protected function getForm()
    {
        $request = $this->getRequest();
        $id = $request->get($this->admin->getIdParameter());

        $existingObject = $this->admin->getObject($id);

        $this->admin->setSubject($existingObject);

        /** @var $form Form */
        $form = $this->admin->getForm();
        $form->setData($existingObject);
        $form->handleRequest($request);

        return $form;
    }

    public function incluirAction()
    {
        /** @var Form $form */
        $form = $this->getForm();

        if ($form->isSubmitted()) {
            $exercicio = $this->admin->getExercicio();

            $formData = $this->getRequest()->get($this->admin->getUniqid());

            /** @var ModelManager $modelManager */
            $modelManager = $this->admin->getModelManager();
            $entityManager = $modelManager->getEntityManager(Solicitacao::class);

            $solicitacaoHomologadaReservaModel = new SolicitacaoHomologadaReservaModel($entityManager);
            $solicitacaoItemDotacaoModel = new SolicitacaoItemDotacaoModel($entityManager);
            $solicitacaoHomologadaModel = new SolicitacaoHomologadaModel($entityManager);
            $solicitacaoItemModel = new SolicitacaoItemModel($entityManager);
            $configuracaoModel = new ConfiguracaoModel($entityManager);
            $solicitacaoModel = new SolicitacaoModel($entityManager);
            $despesaModel = new DespesaModel($entityManager);

            /** @var Solicitacao $solicitacao */
            $solicitacao = $form->getData();

            /** @var Solicitacao $solicitacaoAnterior */
            $solicitacaoAnterior = $modelManager->find(Solicitacao::class, $formData['codSolicitacao']);

            $flashBag = $this->container->get('session')->getFlashBag();

            $entityManager->getConnection()->beginTransaction();
            try {
                $solicitacaoItens = $solicitacaoModel->montaRecuperaItemSolicitacao(
                    $solicitacaoAnterior->getCodSolicitacao(),
                    $solicitacaoAnterior->getCodEntidade(),
                    $solicitacaoAnterior->getExercicio()
                );

                foreach ($solicitacaoItens as $solicitacaoItem) {
                    $itemCadastrado = $solicitacao->getFkComprasSolicitacaoItens()->exists(
                        function ($index, SolicitacaoItem $solicitacaoItemCatadastrada) use ($solicitacaoItem) {
                            return $solicitacaoItemCatadastrada->getCodItem() == $solicitacaoItem->cod_item;
                        }
                    );

                    if (false == $itemCadastrado) {
                        $codItem = $solicitacaoItem->cod_item;

                        /** @var SolicitacaoItem $solicitacaoItemOriginal */
                        $solicitacaoItemOriginal = $entityManager
                            ->getRepository(SolicitacaoItem::class)
                            ->findOneBy([
                                'codSolicitacao' => $solicitacaoItem->cod_solicitacao,
                                'codEntidade'    => $solicitacaoItem->cod_entidade,
                                'exercicio'      => $solicitacaoItem->exercicio_solicitacao,
                                'codItem'        => $solicitacaoItem->cod_item,
                                'codCentro'      => $solicitacaoItem->cod_centro,
                            ]);

                        /** @var SolicitacaoItem $solicitacaoItemCopia */
                        $solicitacaoItemCopia = $solicitacaoItemModel->buildOneBasedOnSolicitacaoItem($solicitacaoItemOriginal, $solicitacao);

                        $vlReserva = (is_null($solicitacaoItem->vl_reserva)) ? $solicitacaoItem->vl_total : $solicitacaoItem->vl_reserva;
                        $quantidade = $solicitacaoItem->quantidade;

                        $despesa = null;
                        $codDespesa = $this->getRequest()->get('codDespesa_' . $codItem);
                        $codEstrutural = $this->getRequest()->get('codEstrutural_' . $codItem);

                        if (!empty($codDespesa) && !empty($codEstrutural)) {
                            list($codConta, $exercicioContaDespesa) = explode('-', $codEstrutural);

                            /** @var Despesa $despesa */
                            $despesa = $despesaModel->getOneDespesaByCodDespesaAndExercicio($codDespesa, $exercicio);

                            $solicitacaoItemDotacao = $solicitacaoItemDotacaoModel->buildOneSolicitacaoItemDotacao($solicitacaoItemCopia, $despesa, $vlReserva, $quantidade, true);
                            $solicitacaoItemCopia->addFkComprasSolicitacaoItemDotacoes($solicitacaoItemDotacao);

                            if (!empty($codConta) && !is_null($despesa)) {
                                /** @var ContaDespesa $contaDespesa */
                                $contaDespesa = $modelManager->findOneBy(ContaDespesa::class, [
                                    'exercicio' => $exercicioContaDespesa,
                                    'codConta'  => $codConta,
                                ]);

                                $solicitacaoItemDotacao = $solicitacaoItemDotacaoModel->salvaSolicitacaoItemDotacao($solicitacaoItemCopia, $contaDespesa, $despesa);
                            }
                        }

                        $reservaRigida = filter_var($configuracaoModel->getConfiguracao('reserva_rigida', Modulo::MODULO_PATRIMONIAL_COMPRAS, true, $exercicio), FILTER_VALIDATE_BOOLEAN);
                        $homologacaoAutomatica = filter_var($configuracaoModel->getConfiguracao('homologacao_automatica', Modulo::MODULO_PATRIMONIAL_COMPRAS, true, $exercicio), FILTER_VALIDATE_BOOLEAN);

                        if (true == $solicitacao->getRegistroPrecos()) {
                            $reservaRigida = false;
                        }

                        $nuVlReserva = str_replace(',', '.', str_replace('.', '', $solicitacaoItemCopia->getVlTotal()));
                        $motivo = "Entidade: " . $solicitacao->getFkOrcamentoEntidade()->getCodEntidade() . " - " . $solicitacao->getFkOrcamentoEntidade()->getFkSwCgm()->getNomCgm() . ", solicitação de compras: " . $solicitacao->getCodSolicitacao() . "/" . $exercicio . ', Item:' . $solicitacaoItemCopia->getCodItem();
                        $dataFinal = new \DateTime($exercicio . '-12-31');

                        $orcamentoReservaSaldo = null;
                        $temReserva = false;
                        $codReserva = null;

                        if (false == is_null($despesa)) {
                            if ($nuVlReserva > 0 && $solicitacao->getRegistroPrecos() == false) {
                                $reservaSaldosModel = new ReservaSaldosModel($entityManager);

                                $data = $solicitacao->getTimestamp();
                                $dataInicial = new \DateTime($data);

                                $orcamentoReservaSaldo = $reservaSaldosModel
                                    ->saveReservaSaldos($exercicio, $despesa, $solicitacao, $motivo, $nuVlReserva, $dataInicial, $dataFinal);

                                if ($homologacaoAutomatica && $reservaRigida) {
                                    $codReserva = ($solicitacaoModel->getProximaCodReservaSaldo()) > 0 ? $solicitacaoModel->getProximaCodReservaSaldo() : 1;
                                    if ($solicitacaoModel->montaincluiReservaSaldo($codReserva, $exercicio, $despesa->getCodDespesa(), $solicitacao->getTimestamp(), $dataFinal, $nuVlReserva, 'A', $motivo)) {
                                        $temReserva = true;
                                    }
                                }
                            }
                        }

                        $solicitacaoHomologada = null;
                        if ($homologacaoAutomatica && false == is_null($codReserva)) {
                            $solicitacaoHomologada = $solicitacaoHomologadaModel->salvaSolicitacaoHomologada($exercicio, $solicitacao);
                        }

                        if (false == is_null($solicitacaoHomologada)
                            && $solicitacao->getRegistroPrecos() == false
                            && $reservaRigida == true
                            && $nuVlReserva > 0
                            && $temReserva == true
                        ) {
                            $solicitacaoHomologadaReservaModel->salvaSolicitacaoHomologadaReserva($exercicio, $solicitacao, $solicitacaoItemCopia, $orcamentoReservaSaldo, $solicitacaoItemDotacao, $despesa);
                        }
                    }
                }

                $entityManager->flush();
                $entityManager->getConnection()->commit();

                $flashMessage = $this->trans('solicitacao_compra.success.itensIncluidos', [], 'validators');
                $flashBag->add('success', $flashMessage);
            } catch (\Exception $exception) {
                $flashMessage = $this->trans('solicitacao_compra.errors.exception', [], 'validators');
                $flashBag->add('error', $flashMessage);
                $entityManager->getConnection()->rollback();
            }

            return $this->redirectToRoute('urbem_patrimonial_compras_solicitacao_show', [
                'id' => $this->admin->id($solicitacao),
            ]);
        }

        return $this->editAction();
    }
}
