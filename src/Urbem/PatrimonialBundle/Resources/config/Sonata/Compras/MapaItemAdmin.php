<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints as Assert;

use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Compras\MapaItem;
use Urbem\CoreBundle\Entity\Compras\MapaItemDotacao;
use Urbem\CoreBundle\Entity\Compras\Solicitacao;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoAnulacao;
use Urbem\CoreBundle\Entity\Orcamento\Despesa;
use Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Orcamento\DespesaModel;
use Urbem\CoreBundle\Model\Orcamento\ReservaSaldosAnuladaModel;
use Urbem\CoreBundle\Model\Orcamento\ReservaSaldosModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CentroCustoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaItemDotacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaItemReservaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class MapaItemAdmin
 *
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Compras
 */
class MapaItemAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_mapa_item_mapa';
    protected $baseRoutePattern = 'patrimonial/compras/mapa/mapa-item';

    /**
     * @param MapaItem $mapaItem
     *
     * @return object
     */
    protected function getSolicitacaoItemData(MapaItem $mapaItem)
    {
        $mapaItemModel = new MapaItemModel($this->getEntityManager());
        $solicitacaoItem = $mapaItem->getFkComprasSolicitacaoItem();

        $items = $mapaItemModel->montaRecuperaItemSolicitacaoMapa(
            $solicitacaoItem->getCodSolicitacao(),
            $solicitacaoItem->getCodEntidade(),
            $solicitacaoItem->getExercicio(),
            $solicitacaoItem->getCodItem(),
            $solicitacaoItem->getCodCentro(),
            $mapaItem->getCodMapa(),
            $mapaItem->getExercicio()
        );

        return (object) reset($items);
    }

    /**
     * @return bool
     */
    protected function hasReservaRigida()
    {
        $reservaRigida = (new ConfiguracaoModel($this->getEntityManager()))->getConfiguracao(
            'reserva_rigida',
            Modulo::MODULO_PATRIMONIAL_COMPRAS,
            true,
            $this->getExercicio()
        );

        return filter_var($reservaRigida, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFieldsDotacaoOrcamentaria(FormMapper $formMapper)
    {
        $entityManager = $this->getEntityManager();

        /** @var MapaItem $mapaItem */
        $mapaItem = $this->getSubject();

        $exercicio = $this->getExercicio();

        $itemSolicitacao = $this->getSolicitacaoItemData($mapaItem);

        $centroCustoModel = new CentroCustoModel($entityManager);

        $numcgm = $this->getCurrentUser()->getNumcgm();

        $centroCustoModel->getDotacaoByEntidade($itemSolicitacao->cod_item, $exercicio, $numcgm);

        $ccDotacaoChoices = [];
        foreach ($centroCustoModel->getDotacaoByEntidade($itemSolicitacao->cod_entidade, $exercicio, $numcgm) as $dotacao) {
            $descricao = $dotacao['descricao'];
            $mascara = $dotacao['mascara_classificacao'];
            $choiceValue = $dotacao['cod_despesa'];
            $choiceKey = $descricao;
            $ccDotacaoChoices[$choiceValue . ' - ' . $choiceKey] = $choiceValue;
        }

        $fieldOptions['codDespesa'] = [
            'attr'        => ['class' => 'select2-parameters ',],
            'choices'     => $ccDotacaoChoices,
            'label'       => 'label.patrimonial.compras.solicitacao.dotacaoorcamentaria',
            'mapped'      => false,
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions['codEstrutural'] = [
            'attr'        => ['class' => 'select2-parameters ',],
            'choices'     => [],
            'label'       => 'label.patrimonial.compras.solicitacao.desdobramento',
            'mapped'      => false,
            'placeholder' => 'label.selecione',
            'required'    => true,
        ];

        $fieldOptions['saldoDotacao'] = [
            'disabled' => true,
            'label'    => 'label.patrimonial.compras.mapaItem.saldoDotacao',
            'mapped'   => false,
        ];

        $formMapper
            ->add('codSolicitacao', 'hidden', [
                'data'   => $this->id($mapaItem->getFkComprasSolicitacaoItem()->getFkComprasSolicitacao()),
                'mapped' => false,
            ])
            ->add('codDespesa', 'choice', $fieldOptions['codDespesa'])
            ->add('codEstrutural', 'choice', $fieldOptions['codEstrutural'])
            ->add('saldoDotacao', 'number', $fieldOptions['saldoDotacao']);

        $formMapper
            ->getFormBuilder()
            ->addEventListener(
                FormEvents::PRE_SUBMIT,
                function (FormEvent $formEvent) use ($formMapper, $exercicio, $fieldOptions, $entityManager) {
                    $form = $formEvent->getForm();
                    $data = $formEvent->getData();

                    if (isset($data['codDespesa']) && !empty($data['codDespesa'])) {
                        $arrCodEstrutural = (new DespesaModel($entityManager))
                            ->recuperaCodEstrutural($exercicio, $data['codDespesa']);

                        $arrChoicesCodEstrutural = [];
                        if (is_array($arrCodEstrutural)) {
                            foreach ($arrCodEstrutural as $codEstrutural) {
                                $value = sprintf('%s-%s', $codEstrutural->cod_conta, $codEstrutural->exercicio);
                                $label = sprintf('%s - %s', $codEstrutural->cod_estrutural, $codEstrutural->descricao);

                                $arrChoicesCodEstrutural[$label] = $value;
                            }
                        }

                        $fieldOptions['codEstrutural']['auto_initialize'] = false;
                        $fieldOptions['codEstrutural']['choices'] = $arrChoicesCodEstrutural;

                        $comCodEstrutural = $formMapper
                            ->getFormBuilder()
                            ->getFormFactory()
                            ->createNamed('codEstrutural', 'choice', null, $fieldOptions['codEstrutural']);

                        $form->add($comCodEstrutural);
                    }
                }
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->addToIncludeJs('/patrimonial/javascripts/compras/mapaItem.js');

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $entityManager = $this->getEntityManager();

        $exercicio = $this->getExercicio();

        /** @var MapaItem $mapaItem */
        $mapaItem = $this->getSubject();

        $mapaItemModel = new MapaItemModel($entityManager);

        $itemSolicitacao = $this->getSolicitacaoItemData($mapaItem);

        $saldoDotacao = null;
        $saldoDisponivelDotacao = null;
        $valorReserva = null;

        if ($itemSolicitacao->boDotacao == 'T') {
            $saldoDotacao = $mapaItemModel
                ->montaRecuperaSaldoAnterior($exercicio, $itemSolicitacao->cod_despesa);

            $saldoDisponivelDotacao = $mapaItemModel->montaRecuperaSaldoDisponivelDotacao($itemSolicitacao, $exercicio);
            $valorReserva = $mapaItemModel->montaRecuperaValorReserva($itemSolicitacao);
        }

        $fieldOptions = [];
        $fieldOptions['items'] = [
            'data'     => [
                'item'                   => $itemSolicitacao,
                'saldoDotacao'           => $saldoDotacao,
                'saldoDisponivelDotacao' => $saldoDisponivelDotacao,
                'valorReserva'           => $valorReserva,
            ],
            'label'    => false,
            'mapped'   => false,
            'template' => '@Patrimonial/Sonata/Compras/Mapa/CRUD/field_custom__items.html.twig',
        ];

        $fieldOptions['valorUnitario'] = [
            'attr'        => ['class' => ' money '],
            'constraints' => [new Assert\GreaterThan([
                'message' => $this->trans('mapaItem.errors.valorUnitarioIgualZero', [], 'validators'),
                'value'   => 0,
            ])],
            'data'        => bcdiv($mapaItem->getVlTotal(), $mapaItem->getQuantidade(), 2),
            'label'       => 'label.patrimonial.compras.mapaItem.valorUnitario',
            'mapped'      => false,
            'required'    => false,
        ];

        $fieldOptions['quantidade'] = [
            'attr'        => ['class' => 'quantity '],
            'constraints' => [new Assert\GreaterThan([
                'message' => $this->trans('mapaItem.errors.quantidadeIgualZero', [], 'validators'),
                'value'   => 0,
            ])],
            'label'       => 'label.patrimonial.compras.mapaItem.qtdMapa',
            'required'    => false,
        ];

        $fieldOptions['vlTotal'] = [
            'attr'        => ['class' => ' money '],
            'constraints' => [new Assert\GreaterThan([
                'message' => $this->trans('mapaItem.errors.valorTotalIgualZero', [], 'validators'),
                'value'   => 0,
            ])],
            'label'       => 'label.patrimonial.compras.mapaItem.vlTotal',
            'required'    => false,
        ];

        $formMapper
            ->add('items', 'customField', $fieldOptions['items'])
            ->add('valorUnitario', 'number', $fieldOptions['valorUnitario']);

        if ($itemSolicitacao->boDotacao == 'T') {
            $formMapper->add('quantidade', 'text', $fieldOptions['quantidade']);
        }

        $formMapper->add('vlTotal', 'number', $fieldOptions['vlTotal']);

        if ($itemSolicitacao->boDotacao == 'F') {
            $this->configureFormFieldsDotacaoOrcamentaria($formMapper);
        }
    }

    /**
     * @param ErrorElement $errorElement
     * @param MapaItem     $mapaItem
     */
    public function validate(ErrorElement $errorElement, $mapaItem)
    {
        $entityManager = $this->getEntityManager();

        $mapaItemModel = new MapaItemModel($entityManager);
        $itemSolicitacao = $itemSolicitacao = $this->getSolicitacaoItemData($mapaItem);

        $form = $this->getForm();

        $saldoDotacao = 0;
        if (!$form->has('codDespesa')) {
            $saldoDotacao = $mapaItemModel
                ->montaRecuperaSaldoAnterior($itemSolicitacao->exercicio_reserva, $itemSolicitacao->cod_despesa);
        }

        $valorReserva = $mapaItemModel->montaRecuperaValorReserva($itemSolicitacao);

        if ($saldoDotacao > 0
            && $form->get('vlTotal')->getData() > $saldoDotacao
            && !$itemSolicitacao->isRegistroPreco
            && $this->hasReservaRigida()
        ) {
            $message = $this->trans('mapaItem.errors.valorTotalMaiorSaldoDotacao', [], 'validators');

            $errorElement->with('vlTotal')->addViolation($message)->end();
        }

        if ($saldoDotacao == 0
            && $valorReserva > 0
            && !$itemSolicitacao->isRegistroPreco
            && $this->hasReservaRigida()
        ) {
            $message = $this->trans('mapaItem.errors.valorTotalMaiorSaldoDotacao', [], 'validators');

            $errorElement->with('vlTotal')->addViolation($message)->end();
        }

        if ($form->has('quantidade')
            && $form->get('quantidade')->getData() > $itemSolicitacao->quantidade_solicitada) {
            $message = $this->trans('mapaItem.errors.qtdeSolicitadaMaior', [], 'validators');

            $errorElement->with('quantidade')->addViolation($message)->end();
        }

        if ($form->has('codDespesa')) {
            $exercicio = $this->getExercicio();
            $codEntidade = $itemSolicitacao->cod_entidade;

            $codDespesa = $form->get('codDespesa')->getData();
            $saldoDotacao = (new DespesaModel($entityManager))
                ->recuperaSaldoDotacaoDataEmpenho($exercicio, $codDespesa, $codEntidade);

            $saldoDotacao = filter_var($saldoDotacao['saldo_anterior'], FILTER_VALIDATE_FLOAT);

            if ($form->get('vlTotal')->getData() > $saldoDotacao) {
                $message = $this->trans('mapaItem.errors.valorTotalMaiorSaldoDotacao', [], 'validators');

                $errorElement->with('vlTotal')->addViolation($message)->end();
            }
        }
    }

    /**
     * @param int        $codReserva
     * @param string|int $exercicio
     * @param float      $vlReserva
     *
     * @throws \Exception
     */
    public function updateReservaSaldo($codReserva, $exercicio, $vlReserva, $codItem)
    {
        $entityManager = $this->getEntityManager();

        $reservaSaldosAnuladaModel = new ReservaSaldosAnuladaModel($entityManager);
        $reservaSaldosModel = new ReservaSaldosModel($entityManager);

        $reservaSaldosAnuladaModel->removeOneByCodReservaAndExercicio($codReserva, $exercicio);

        try {
            $reservaSaldosModel->alteraReservaSaldo($codReserva, $exercicio, $vlReserva);
        } catch (\Exception $exception) {
            $message = $this->trans('patrimonial.mapa.mapaItem.errors.atualizarReservaSaldo', [
                'cod_item' => $codItem,
            ], 'flashes');

            throw new \Exception($message, $exception->getCode());
        }
    }

    /**
     * @param Solicitacao     $solicitacao
     * @param MapaItemDotacao $mapaItemDotacao
     * @param                 $item
     *
     * @throws \Exception
     */
    protected function persistReservaSaldos(Solicitacao $solicitacao, MapaItemDotacao $mapaItemDotacao, $item)
    {
        $entityManager = $this->getEntityManager();

        $entidade = $solicitacao->getFkOrcamentoEntidade();

        /** @var Despesa $despesa */
        $despesa = $this->modelManager->findOneBy(Despesa::class, [
            'exercicio'  => $item->exercicio_solicitacao,
            'codDespesa' => $item->cod_despesa,
        ]);

        $dtValidadeInicial = (new \DateTime())
            ->format('d/m/Y');

        $dtValidadeFinal = (new \DateTime())
            ->modify('last day of December')
            ->format('d/m/Y');

        $motivo = sprintf("Entidade: %s, ", $entidade);
        $motivo .= sprintf("Solicitação de Compras: %s, ", $solicitacao);
        $motivo .= sprintf("Item: %d, ", $item->cod_item);
        $motivo .= sprintf("Centro de Custo: %d ", $item->cod_centro);
        $motivo .= "(Origem da criação: Alterar Mapa).";

        try {
            $reservaSaldosModel = new ReservaSaldosModel($entityManager);

            $codReserva = $reservaSaldosModel->getProximoCodReserva($mapaItemDotacao->getExercicio());

            $reservaSaldosModel
                ->montaincluiReservaSaldo(
                    $codReserva,
                    $despesa->getExercicio(),
                    $despesa->getCodDespesa(),
                    $dtValidadeInicial,
                    $dtValidadeFinal,
                    $item->vl_reserva,
                    'A',
                    $motivo
                );

            /** @var ReservaSaldos $reservaSaldos */
            $reservaSaldos = $this->modelManager->findOneBy(ReservaSaldos::class, [
                'codReserva' => $codReserva,
                'exercicio' => $despesa->getExercicio()
            ]);

            $mapaItemReserva = (new MapaItemReservaModel($entityManager))
                ->buildOne($mapaItemDotacao, $reservaSaldos);
        } catch (\Exception $exception) {
            $message = $this->trans('patrimonial.mapa.mapaItem.errors.reservaSaldo', [
                'solicitacao' => (string) $solicitacao,
                'cod_item'    => $item->cod_item,
            ], 'flashes');

            throw new \Exception($message, $exception->getCode());
        }
    }

    /**
     * @param Solicitacao $solicitacao
     * @param object      $item
     */
    protected function persistReservaSaldosAnulada(Solicitacao $solicitacao, $item, $codReserva, $exercicio)
    {
        /** @var ReservaSaldos $reservaSaldos */
        $reservaSaldos = $this->modelManager->findOneBy(ReservaSaldos::class, [
            'codReserva' => $codReserva,
            'exercicio'  => $exercicio,
        ]);

        $reservaSaldosAnulada = $reservaSaldos->getFkOrcamentoReservaSaldosAnulada();

        if (is_null($reservaSaldosAnulada)) {
            $entityManager = $this->getEntityManager();

            $entidade = $solicitacao->getFkOrcamentoEntidade();

            $motivoAnulacao = sprintf("Entidade: %s, ", $entidade);
            $motivoAnulacao .= sprintf("Solicitação de Compras: %s, ", $solicitacao);
            $motivoAnulacao .= sprintf("Item: %d, ", $item->cod_item);
            $motivoAnulacao .= sprintf("Centro de Custo: %d ", $item->cod_centro);
            $motivoAnulacao .= "(Origem da anulação: Alterar Mapa).";

            $reservaSaldosAnulada = (new ReservaSaldosAnuladaModel($entityManager))
                ->buildOne($reservaSaldos, new \DateTime(), $motivoAnulacao);
        }
    }

    /**
     * @param MapaItem $mapaItem
     */
    public function preUpdate($mapaItem)
    {
        $entityManager = $this->getEntityManager();

        $entityManager->getConnection()->beginTransaction();
        try {
            /** @var MapaItemDotacao $mapaItemDotacao */
            $mapaItemDotacao = $mapaItem->getFkComprasMapaItemDotacoes()->current();

            $itemSolicitacao = $this->getSolicitacaoItemData($mapaItem);

            $mapaItemDotacaoModel = new MapaItemDotacaoModel($entityManager);
            $mapaItemDotacao = $mapaItemDotacaoModel
                ->updateMapaItemDotacao($mapaItemDotacao, $mapaItem->getQuantidade(), $mapaItem->getVlTotal());

            $solicitacao = $mapaItem->getFkComprasSolicitacaoItem()->getFkComprasSolicitacao();

            if (is_numeric($itemSolicitacao->cod_reserva_solicitacao)
                && !$itemSolicitacao->isRegistroPreco
                && $this->hasReservaRigida()
            ) {
                $itemSolicitacao->quantidade_mapa = $mapaItem->getQuantidade();
                $itemSolicitacao->valor_total_mapa = $mapaItem->getVlTotal();

                if ($itemSolicitacao->quantidade_mapa != $itemSolicitacao->quantidade_mapa_original
                    || $mapaItem->getVlTotal() != $itemSolicitacao->valor_total_mapa_original
                ) {
                    $qtdeSaldoSolicitacao = bcsub($itemSolicitacao->quantidade_solicitada, $itemSolicitacao->quantidade_atendida, 4);
                    $qtdeSaldoSolicitacao = bcsub($qtdeSaldoSolicitacao, $itemSolicitacao->quantidade_mapa, 4);

                    $vlSaldoSolicitacao = bcdiv($itemSolicitacao->valor_total_mapa, $itemSolicitacao->quantidade_mapa, 2);
                    $vlSaldoSolicitacao = bcmul($vlSaldoSolicitacao, $qtdeSaldoSolicitacao, 2);

                    if ($qtdeSaldoSolicitacao > 0) {
                        if ($itemSolicitacao->cod_reserva != $itemSolicitacao->cod_reserva_solicitacao) {
                            if ($itemSolicitacao->valor_total_mapa > $itemSolicitacao->valor_total_mapa_original) {
                                $this->updateReservaSaldo($itemSolicitacao->cod_reserva_solicitacao, $itemSolicitacao->exercicio_reserva_solicitacao, $vlSaldoSolicitacao, $itemSolicitacao->cod_item);
                                $this->updateReservaSaldo($itemSolicitacao->cod_reserva, $itemSolicitacao->exercicio_reserva, $itemSolicitacao->valor_total_mapa, $itemSolicitacao->cod_item);
                            } else {
                                $this->updateReservaSaldo($itemSolicitacao->cod_reserva, $itemSolicitacao->exercicio_reserva, $itemSolicitacao->valor_total_mapa, $itemSolicitacao->cod_item);
                                $this->updateReservaSaldo($itemSolicitacao->cod_reserva_solicitacao, $itemSolicitacao->exercicio_reserva_solicitacao, $vlSaldoSolicitacao, $itemSolicitacao->cod_item);
                            }
                        } else {
                            $this->updateReservaSaldo($itemSolicitacao->cod_reserva_solicitacao, $itemSolicitacao->exercicio_reserva_solicitacao, $vlSaldoSolicitacao, $itemSolicitacao->cod_item);

                            $this->persistReservaSaldos($solicitacao, $mapaItemDotacao, $itemSolicitacao);
                        }
                    } elseif ($qtdeSaldoSolicitacao == 0) {
                        $this->persistReservaSaldosAnulada($solicitacao, $itemSolicitacao, $itemSolicitacao->cod_reserva_solicitacao, $itemSolicitacao->exercicio_reserva_solicitacao);

                        if ($itemSolicitacao->cod_reserva == $itemSolicitacao->cod_reserva_solicitacao) {
                            $this->persistReservaSaldos($solicitacao, $mapaItemDotacao, $itemSolicitacao);
                        } else {
                            $this->updateReservaSaldo($itemSolicitacao->cod_reserva, $itemSolicitacao->exercicio_reserva, $itemSolicitacao->valor_total_mapa, $itemSolicitacao->cod_item);
                        }
                    }
                }
            } else {
                if ($itemSolicitacao->valor_total_mapa > 0
                    && !is_numeric($itemSolicitacao->cod_reserva)
                    && !$itemSolicitacao->isRegistroPreco
                    && $this->hasReservaRigida()
                ) {
                    $this->persistReservaSaldos($solicitacao, $mapaItemDotacao, $itemSolicitacao);
                } elseif ($itemSolicitacao->valor_total_mapa > 0
                    && is_numeric($itemSolicitacao->cod_reserva)
                    && !$itemSolicitacao->isRegistroPreco
                    && $this->hasReservaRigida()
                ) {
                    $this->updateReservaSaldo($itemSolicitacao->cod_reserva, $itemSolicitacao->exercicio_reserva, $itemSolicitacao->valor_total_mapa, $itemSolicitacao->cod_item);
                }
            }

            if (!$this->hasReservaRigida()
                && (is_numeric($itemSolicitacao->cod_reserva_solicitacao) || is_numeric($itemSolicitacao->cod_reserva))
            ) {
                if (is_numeric($itemSolicitacao->cod_reserva_solicitacao)) {
                    $this->persistReservaSaldosAnulada($solicitacao, $itemSolicitacao, $itemSolicitacao->cod_reserva_solicitacao, $itemSolicitacao->exercicio_reserva_solicitacao);
                }

                if (is_numeric($itemSolicitacao->cod_reserva)) {
                    $this->persistReservaSaldosAnulada($solicitacao, $itemSolicitacao, $itemSolicitacao->cod_reserva, $itemSolicitacao->exercicio_reserva);
                }
            }

            $entityManager->flush();
            $entityManager->getConnection()->commit();
        } catch (\Exception $exception) {
            $entityManager->getConnection()->rollBack();

            $this->getContainer()
                ->get('session')
                ->getFlashBag()
                ->add('error', $exception->getMessage());
        }

        $this->redirectByRoute('urbem_patrimonial_compras_mapa_show', [
            'id' => $this->id($mapaItem->getFkComprasMapaSolicitacao()->getFkComprasMapa()),
        ]);
    }

    /**
     * @param MapaItem $mapaItem
     *
     * @return bool
     */
    public function preRemove($mapaItem)
    {
        $entityManager = $this->getEntityManager();

        $mapaItemDotacoes = $mapaItem->getFkComprasMapaItemDotacoes();
        $mapaItemReservas = $mapaItemDotacoes->map(function (MapaItemDotacao $mapaItemDotacao) {
            return $mapaItemDotacao->getFkComprasMapaItemReserva();
        });
        $mapaItemAnulacoes = $mapaItem->getFkComprasMapaItemAnulacoes();

        $solicitacao = $mapaItem->getFkComprasSolicitacaoItem()->getFkComprasSolicitacao();

        $itemData = $this->getSolicitacaoItemData($mapaItem);

        $entityManager->getConnection()->beginTransaction();
        try {
            if ($mapaItemReservas->count() > 0 && is_numeric($itemData->cod_reserva)) {
                $this->persistReservaSaldosAnulada($solicitacao, $itemData, $itemData->cod_reserva, $itemData->exercicio_reserva);
            }

            $reservaSaldosAnuladaModel = new ReservaSaldosAnuladaModel($entityManager);
            $reservaSaldosModel = new ReservaSaldosModel($entityManager);

            if (is_numeric($itemData->cod_reserva_solicitacao)) {
                if (is_numeric($itemData->cod_reserva)) {
                    $vlReservaSaldoSolicitacao = 0;

                    $reservaSaldosAnulada = $reservaSaldosAnuladaModel->getOneByCodReservaAndExercicio($itemData->cod_reserva_solicitacao, $itemData->exercicio_reserva_solicitacao);

                    if (!is_null($reservaSaldosAnulada)) {
                        $reservaSaldosAnuladaModel->removeOneByCodReservaAndExercicio($itemData->cod_reserva_solicitacao, $itemData->exercicio_reserva_solicitacao);

                        $vlReservaSaldoSolicitacao = $itemData->vl_reserva;
                    } else {
                        $reservaSaldos = $reservaSaldosModel->getOneReservaSaldos($itemData->cod_reserva_solicitacao, $itemData->exercicio_reserva_solicitacao);
                        $vlReservaSaldoSolicitacao = bcadd($reservaSaldos->getVlReserva(), $itemData->vl_reserva, 2);
                    }

                    $reservaSaldosModel->alteraReservaSaldo($itemData->cod_reserva_solicitacao, $itemData->exercicio_reserva_solicitacao, $vlReservaSaldoSolicitacao);
                }
            }

            foreach ($mapaItemReservas as $mapaItemReserva) {
                if (!is_null($mapaItemReserva)) {
                    $entityManager->remove($mapaItemReserva);
                }
            }

            foreach ($mapaItemDotacoes as $mapaItemDotacao) {
                if (!is_null($mapaItemDotacao)) {
                    $entityManager->remove($mapaItemDotacao);
                }
            }

            foreach ($mapaItemAnulacoes as $mapaItemAnulacao) {
                if (!is_null($mapaItemAnulacao)) {
                    $entityManager->remove($mapaItemAnulacao);
                }
            }

            $entityManager->flush();
            $entityManager->getConnection()->commit();
        } catch (\Exception $exception) {
            $entityManager->getConnection()->rollBack();

            $message = $this->trans('patrimonial.mapa.mapaItem.errors.remocaoItem', [
                'cod_item' => $itemData->cod_item,
            ], 'flashes');

            $this->getContainer()
                ->get('session')
                ->getFlashBag()
                ->add('error', $message);

            $this->redirectByRoute('urbem_patrimonial_compras_mapa_show', [
                'id' => $this->id($mapaItem->getFkComprasMapaSolicitacao()->getFkComprasMapa()),
            ]);

            return false;
        }

        return true;
    }

    /**
     * @param MapaItem $mapaItem
     */
    public function postRemove($mapaItem)
    {
        $entityManager = $this->getEntityManager();

        if ($mapaItem->getFkComprasMapaSolicitacao()->getFkComprasMapaItens()->count() == 0) {
            $solicitacao = $mapaItem->getFkComprasSolicitacaoItem()->getFkComprasSolicitacao();

            /** @var SolicitacaoAnulacao $solicitacaoAnulacao */
            foreach ($solicitacao->getFkComprasSolicitacaoAnulacoes() as $solicitacaoAnulacao) {
                $entityManager->remove($solicitacaoAnulacao);
            }

            $entityManager->remove($solicitacao);
        }

        $entityManager->flush();

        $this->redirectByRoute('urbem_patrimonial_compras_mapa_show', [
            'id' => $this->id($mapaItem->getFkComprasMapaSolicitacao()->getFkComprasMapa()),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function toString($mapaItem)
    {
        return $mapaItem->getFkComprasSolicitacaoItem()->getFkAlmoxarifadoCatalogoItem()->getDescricao();
    }
}
