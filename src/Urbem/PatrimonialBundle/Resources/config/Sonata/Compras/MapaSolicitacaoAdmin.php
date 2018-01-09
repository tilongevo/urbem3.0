<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Doctrine\ORM\EntityManager;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Compras\Mapa;
use Urbem\CoreBundle\Entity\Compras\MapaItem;
use Urbem\CoreBundle\Entity\Compras\MapaItemAnulacao;
use Urbem\CoreBundle\Entity\Compras\MapaItemDotacao;
use Urbem\CoreBundle\Entity\Compras\MapaItemReserva;
use Urbem\CoreBundle\Entity\Compras\MapaSolicitacao;
use Urbem\CoreBundle\Entity\Compras\MapaSolicitacaoAnulacao;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoItem;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao;
use Urbem\CoreBundle\Entity\Compras\TipoLicitacao;
use Urbem\CoreBundle\Entity\Orcamento\Despesa;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Orcamento\Reserva;
use Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Orcamento\ReservaSaldosAnuladaModel;
use Urbem\CoreBundle\Model\Orcamento\ReservaSaldosModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaItemDotacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaItemReservaModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoItemDotacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class MapaSolicitacaoAdmin
 *
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Compras
 */
class MapaSolicitacaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_mapa_solicitacao';
    protected $baseRoutePattern = 'patrimonial/compras/mapa-solicitacao';

    protected $includeJs = [
        '/patrimonial/javascripts/compras/mapa-solicitacao.js',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('get_solicitacoes_mapa_compra', 'get-solicitacoes-mapa-compra');
        $collection->add('get_item_solicitacao_mapa_compra', 'get-item-solicitacao-mapa-compra');
    }

    /**
     * @param ErrorElement $errorElement
     * @param MapaItem     $mapaSolicitacao
     */
    public function validate(ErrorElement $errorElement, $mapaSolicitacao)
    {
        /** @var EntityManager $em */
        $em = $this->getModelManager()->getEntityManager($this->getClass());
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $form = $this->getForm();

        $exercicio = $this->getExercicio();
        $exercicioSolcitacao = $mapaSolicitacao->getExercicioSolicitacao();
        $codMapa = $mapaSolicitacao->getCodMapa();
        $codEntidade = $formData['codEntidade'];
        $codSolicitacao = $formData['fkComprasSolicitacaoHomologada'];

        $findSolicitacao = $em->getRepository(MapaSolicitacao::class)->findOneBy(['exercicio' => $exercicio, 'codMapa' => $codMapa, 'exercicioSolicitacao' => $exercicioSolcitacao, 'codEntidade' => $codEntidade, 'codSolicitacao' => $codSolicitacao]);

        if (is_object($findSolicitacao)) {
            $message = $this->trans('mapaItem.errors.solicitacaoExists', [], 'validators');
            $errorElement->with('fkComprasSolicitacaoHomologada')->addViolation($message)->end();
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicio')
            ->add('exercicioSolicitacao')
            ->add('codSolicitacao')
            ->add('timestamp');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $id = $this->getAdminRequestId();
        $listMapper
            ->add('exercicioSolicitacao')
            ->add('codSolicitacao');

        $this->addActionsGrid($listMapper);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->getModelManager();
        $entityManager = $modelManager->getEntityManager($this->getClass());

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $codMapa = $formData['codMapa'];
            $exercicio = $formData['exercicioSolicitacao'];
        } else {
            list($exercicio, $codMapa) = explode(ModelManager::ID_SEPARATOR, $id);
        }

        /** @var Mapa $mapa */
        $mapa = $modelManager->findOneBy(Mapa::class, [
            'exercicio' => $exercicio,
            'codMapa'   => $codMapa,
        ]);

        $solicitacoes = $mapa->getFkComprasMapaSolicitacoes();

        $registroPreco = 0;
        if (!$solicitacoes->isEmpty()) {
            $registroPreco = $solicitacoes->first()
                ->getFkComprasSolicitacaoHomologada()
                ->getFkComprasSolicitacao()
                ->getRegistroPrecos();
        }

        $formOptions['registroPreco'] = [
            'attr'       => ['class' => 'checkbox-sonata '],
            'label_attr' => ['class' => 'checkbox-sonata '],
            'label'      => 'label.patrimonial.compras.solicitacao.registro_precos',
            'choices'    => [
                'sim' => 1,
                'nao' => 0,
            ],
            'data'       => $registroPreco,
            'disabled'   => $solicitacoes->isEmpty() ? false : true,
            'expanded'   => true,
            'mapped'     => false,
            'multiple'   => false,
        ];

        $formOptions['exercicioSolicitacao'] = [
            'label' => 'label.mapa.exercicioSolicitacao',
            'data'  => $exercicio,
            'attr'  => [
                'readonly' => 'readonly',
            ],
        ];

        $formOptions['codEntidade'] = [
            'label'        => 'label.patrimonial.compras.contrato.codEntidade',
            'class'        => Entidade::class,
            'required'     => true,
            'mapped'       => false,
            'placeholder'  => 'label.selecione',
            'choice_value' => 'codEntidade',
            'choices'      => $entityManager->getRepository(Entidade::class)->findBy(['exercicio' => $exercicio], ['codEntidade' => 'ASC']),
            'attr'         => ['class' => 'select2-parameters '],
        ];

        $formOptions['fkComprasSolicitacaoHomologada'] = [
            'class'        => SolicitacaoHomologada::class,
            'required'     => true,
            'placeholder'  => 'label.selecione',
            'choice_label' => function (SolicitacaoHomologada $solicitacaoHomologada) {
                $solicitacao = $solicitacaoHomologada->getFkComprasSolicitacao();

                return sprintf("%s / %d", $solicitacao->getExercicio(), $solicitacao->getCodSolicitacao());
            },
            'choices'      => [],
            'label'        => 'label.mapa.codSolicitacao',
            'attr'         => ['class' => 'select2-parameters ',],
        ];

        $formMapper
            ->with($this->getLabel(), ['class' => 'row'])
            ->add('codMapa', 'hidden', ['data' => $codMapa])
            ->add('registroPreco', 'choice', $formOptions['registroPreco'])
            ->add('exercicioSolicitacao', null, $formOptions['exercicioSolicitacao'])
            ->add('codEntidade', 'entity', $formOptions['codEntidade'])
            ->add('fkComprasSolicitacaoHomologada', 'entity', $formOptions['fkComprasSolicitacaoHomologada'])
            ->end()
            ->with('Itens')
            ->add('itens', 'customField', [
                'data'     => null,
                'label'    => false,
                'mapped'   => false,
                'template' => 'PatrimonialBundle:Sonata/MapaSolicitacao/CRUD:customField__itens.html.twig',
            ])
            ->end()

        ;

        $solModel = new SolicitacaoModel($entityManager);
        $admin = $this;
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $solModel, $registroPreco) {
                $form = $event->getForm();
                $data = $event->getData();
                $exercicio = $this->getExercicio();

                if (isset($data['fkComprasSolicitacaoHomologada']) && $data['fkComprasSolicitacaoHomologada'] != "") {
                    $codEntidade = $data['codEntidade'];
                    $exercicio = $data['exercicioSolicitacao'];

                    if (!isset($data['registroPreco'])) {
                        $preco = ($registroPreco == 1) ? 'true' : 'false';
                    } else {
                        $preco = ($data['registroPreco'] == 1) ? 'true' : 'false';
                    }

                    $solicitacoes = $solModel->getSolicitacoesMapaCompra($codEntidade, $exercicio, $preco);

                    $dados = [];
                    foreach ($solicitacoes as $solicitacao) {
                        $key = $solicitacao['cod_solicitacao'] . " / " . $solicitacao['exercicio'];
                        $dados[$key] = $solicitacao['cod_solicitacao'];
                    }

                    $comCompraHomologagada = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('fkComprasSolicitacaoHomologada', 'choice', null, [
                            'mapped'          => false,
                            'label'           => 'label.mapa.codSolicitacao',
                            'required'        => true,
                            'choices'         => $dados,
                            'attr'            => ['class' => 'select2-parameters ',],
                            'expanded'        => false,
                            'auto_initialize' => false,
                        ]);
                    $form->add($comCompraHomologagada);
                }
            }
        );
    }

    /**
     * @param MapaSolicitacao $mapaSolicitacao
     */
    public function prePersist($mapaSolicitacao)
    {
        /** @var ModelManager $modelManager */
        $this->modelManager = $this->getModelManager();
        $entityManager = $this->getEntityManager();

        $formData = $this->getRequest()->get($this->getUniqid());

        /** @var Mapa $mapa */
        $mapa = $this->modelManager->findOneBy(Mapa::class, [
            'exercicio' => $formData['exercicioSolicitacao'],
            'codMapa'   => $formData['codMapa'],
        ]);

        /** @var SolicitacaoHomologada $solicitacaoHomologada */
        $solicitacaoHomologada = $this->modelManager->findOneBy(SolicitacaoHomologada::class, [
            'codSolicitacao' => $formData['fkComprasSolicitacaoHomologada'],
            'codEntidade'    => $formData['codEntidade'],
            'exercicio'      => $formData['exercicioSolicitacao'],
        ]);

        $mapaSolicitacao->setFkComprasMapa($mapa);
        $mapaSolicitacao->setFkComprasSolicitacaoHomologada($solicitacaoHomologada);

        $this->persistFkComprasMapaItens($mapaSolicitacao);
    }

    /**
     * @param MapaSolicitacao $mapaSolicitacao
     */
    protected function persistFkComprasMapaItens(MapaSolicitacao $mapaSolicitacao)
    {
        $entityManager = $this->getEntityManager();

        $reservaRigida = (new ConfiguracaoModel($entityManager))->getConfiguracao(
            'reserva_rigida',
            Modulo::MODULO_PATRIMONIAL_COMPRAS,
            true,
            $this->getExercicio()
        );
        $reservaRigida = filter_var($reservaRigida, FILTER_VALIDATE_BOOLEAN);

        $mapaItemModel = new MapaItemModel($entityManager);

        $items = $mapaItemModel->montaRecuperaItemsSolicitacaoParaMapa(
            $mapaSolicitacao->getCodSolicitacao(),
            $mapaSolicitacao->getCodEntidade(),
            $mapaSolicitacao->getExercicioSolicitacao()
        );

        $itemsAux = $items;

        $tipoLicitacao = $mapaSolicitacao->getFkComprasMapa()->getCodTipoLicitacao();

        foreach ($items as $index => $item) {
            foreach ($itemsAux as $indexAux => $itemAux) {
                if ($index != $indexAux
                    && $itemAux->cod_item == $item->cod_item
                    && $itemAux->cod_centro == $item->cod_centro
                    && $itemAux->cod_solicitacao == $item->cod_solicitacao) {
                    $items[$index]->valor_total_mapa += $item->valor_total_mapa;
                    $items[$index]->quantidade_mapa += $item->quantidade_mapa;

                    unset($items[$indexAux]);
                }
            }
        }

        foreach ($items as $index => $item) {
            /** @var SolicitacaoItem $solicitacaoItem */
            $solicitacaoItem = $this->modelManager->findOneBy(SolicitacaoItem::class, [
                'exercicio'      => $mapaSolicitacao->getExercicio(),
                'codEntidade'    => $mapaSolicitacao->getCodEntidade(),
                'codSolicitacao' => $mapaSolicitacao->getCodSolicitacao(),
                'codCentro'      => $item->cod_centro,
                'codItem'        => $item->cod_item,
            ]);

            $item->lote = 0;
            if ($tipoLicitacao == TipoLicitacao::LOTE) {
                $item->lote = $item->lote ?: TipoLicitacao::ITEM;
            }

            $mapaItem = $mapaItemModel->buildOne(
                $solicitacaoItem,
                $mapaSolicitacao,
                $item->quantidade_mapa,
                $item->valor_total_mapa,
                $item->lote
            );

            $mapaSolicitacao->addFkComprasMapaItens($mapaItem);

            if (is_numeric($item->cod_despesa) && is_numeric($item->cod_conta)) {
                $solicitacaoItemDotacao = $this->persistFkComprasSolicitacaoItemDotacao($solicitacaoItem, $item);

                $mapaItemDotacao = (new MapaItemDotacaoModel($entityManager))
                    ->saveMapaItemDotacao($mapaItem, $solicitacaoItemDotacao);

                $mapaItem->addFkComprasMapaItemDotacoes($mapaItemDotacao);

                $registroPreco = $solicitacaoItem->getFkComprasSolicitacao()->getRegistroPrecos();

                if ($registroPreco == true) {
                    $reservaRigida = false;
                }

                if (is_numeric($item->cod_reserva) && $registroPreco == false && $reservaRigida) {
                    $this->updateReservaSaldos($item, $solicitacaoItem);
                }

                if (is_numeric($item->cod_reserva) && $reservaRigida == false) {
                    $this->persistReservaSaldosAnulada($solicitacaoItem, $item);
                }

                if ($item->vl_reserva > 0 && $registroPreco == false && $reservaRigida == true) {
                    $this->persistReservaSaldos($solicitacaoItem, $mapaItemDotacao, $item);
                }
            }
        }
    }

    /**
     * @param SolicitacaoItem $solicitacaoItem
     * @param object          $item
     *
     * @return SolicitacaoItemDotacao
     */
    protected function persistFkComprasSolicitacaoItemDotacao(SolicitacaoItem $solicitacaoItem, $item)
    {
        $entityManager = $this->getEntityManager();

        $solicitacaoItemDotacaoModel = new SolicitacaoItemDotacaoModel($entityManager);

        /** @var SolicitacaoItemDotacao $solicitacaoItemDotacao */
        $solicitacaoItemDotacao = $this->modelManager->findOneBy(SolicitacaoItemDotacao::class, [
            'exercicio'      => $item->exercicio_solicitacao,
            'codEntidade'    => $item->cod_entidade,
            'codSolicitacao' => $item->cod_solicitacao,
            'codItem'        => $item->cod_item,
            'codCentro'      => $item->cod_centro,
        ]);

        if ($item->boDotacao == 'F' && is_null($solicitacaoItemDotacao)) {
            /** @var Despesa $despesa */
            $despesa = $this->modelManager->findOneBy(Despesa::class, [
                'exercicio'  => $item->exercicio_solicitacao,
                'codDespesa' => $item->cod_despesa,
            ]);

            $solicitacaoItemDotacao = $solicitacaoItemDotacaoModel
                ->buildOneSolicitacaoItemDotacao($solicitacaoItem, $despesa, $item->vl_reserva, $item->quantidade_mapa);
        }

        return $solicitacaoItemDotacao;
    }

    /**
     * @param object          $item
     * @param SolicitacaoItem $solicitacaoItem
     */
    protected function updateReservaSaldos($item, SolicitacaoItem $solicitacaoItem)
    {
        $entityManager = $this->getEntityManager();

        $flValor = bcsub($item->vl_reserva_homologacao, $item->vl_reserva, 2);

        if ($flValor > 0) {
            (new ReservaSaldosModel($entityManager))
                ->alteraReservaSaldo($item->cod_reserva, $item->exercicio_reserva, $flValor);
        } elseif ($flValor <= 0 || $item->quantidade_mapa == $item->quantidade_maxima) {
            $this->persistReservaSaldosAnulada($solicitacaoItem, $item);
        }
    }

    /**
     * @param SolicitacaoItem $solicitacaoItem
     * @param object          $item
     */
    protected function persistReservaSaldosAnulada(SolicitacaoItem $solicitacaoItem, $item)
    {
        /** @var ReservaSaldos $reservaSaldos */
        $reservaSaldos = $this->modelManager->findOneBy(ReservaSaldos::class, [
            'codReserva' => $item->cod_reserva,
            'exercicio'  => $item->exercicio_reserva,
        ]);

        $reservaSaldosAnulada = $reservaSaldos->getFkOrcamentoReservaSaldosAnulada();

        if (is_null($reservaSaldosAnulada)) {
            $entityManager = $this->getEntityManager();

            $solicitacao = $solicitacaoItem->getFkComprasSolicitacao();
            $entidade = $solicitacao->getFkOrcamentoEntidade();

            $motivoAnulacao  = sprintf("Entidade: %s, ", $entidade);
            $motivoAnulacao .= sprintf("Solicitação de Compras: %s, ", $solicitacao);
            $motivoAnulacao .= sprintf("Item: %d, ", $item->cod_item);
            $motivoAnulacao .= sprintf("Centro de Custo: %d ", $item->cod_centro);
            $motivoAnulacao .= "(Origem da anulação: Incluir Mapa).";

            $reservaSaldosAnulada = (new ReservaSaldosAnuladaModel($entityManager))
                ->buildOne($reservaSaldos, new \DateTime(), $motivoAnulacao);
        }
    }

    /**
     * @param SolicitacaoItem $solicitacaoItem
     * @param MapaItemDotacao $mapaItemDotacao
     * @param                 $item
     */
    protected function persistReservaSaldos(SolicitacaoItem $solicitacaoItem, MapaItemDotacao $mapaItemDotacao, $item)
    {
        $entityManager = $this->getEntityManager();

        $solicitacao = $solicitacaoItem->getFkComprasSolicitacao();
        $entidade = $solicitacao->getFkOrcamentoEntidade();

        /** @var MapaSolicitacao $mapaSolicitacao */
        $mapaSolicitacao = $this->getSubject();

        /** @var Despesa $despesa */
        $despesa = $this->modelManager->findOneBy(Despesa::class, [
            'exercicio'  => $mapaSolicitacao->getExercicio(),
            'codDespesa' => $item->cod_despesa,
        ]);

        $dtValidadeInicial = (new \DateTime())
            ->format('d/m/Y');

        $dtValidadeFinal = (new \DateTime())
            ->modify('last day of December')
            ->format('d/m/Y');

        $motivo  = sprintf("Entidade: %s, ", $entidade);
        $motivo .= sprintf("Solicitação de Compras: %s, ", $solicitacao);
        $motivo .= sprintf("Item: %d, ", $item->cod_item);
        $motivo .= sprintf("Centro de Custo: %d ", $item->cod_centro);
        $motivo .= "(Origem da criação: Incluir Mapa).";

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
    }

    /**
     * @param MapaSolicitacao $mapaSolicitacao
     */
    public function postPersist($mapaSolicitacao)
    {
        $objectKey = $this->id($mapaSolicitacao->getFkComprasMapa());

        $this->redirectByRoute('urbem_patrimonial_compras_mapa_show', [
            'id' => $objectKey,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->add('exercicio')
            ->add('exercicioSolicitacao')
            ->add('codSolicitacao');
    }


    /**
     * @param MapaSolicitacao $mapaSolicitacao
     *
     * @return bool
     */
    public function preRemove($mapaSolicitacao)
    {
        $entityManager = $this->getEntityManager();

        $entityManager->getConnection()->beginTransaction();
        try {
            $entityManagerRemove = function ($object) use ($entityManager) {
                if (!is_null($object)) {
                    $entityManager->remove($object);
                }
            };

            /** @var MapaItem $mapaItem */
            foreach ($mapaSolicitacao->getFkComprasMapaItens() as $mapaItem) {
                /** @var MapaItemAnulacao $mapaItemAnulacao */
                foreach ($mapaItem->getFkComprasMapaItemAnulacoes() as $mapaItemAnulacao) {
                    $entityManagerRemove($mapaItemAnulacao);
                }

                $mapaItemDotacoes = $mapaItem->getFkComprasMapaItemDotacoes();
                $mapaItemReservas = $mapaItemDotacoes->map(function (MapaItemDotacao $mapaItemDotacao) {
                    return $mapaItemDotacao->getFkComprasMapaItemReserva();
                });

                /** @var MapaItemReserva $mapaItemReserva */
                foreach ($mapaItemReservas as $mapaItemReserva) {
                    $entityManagerRemove($mapaItemReserva);
                }

                /** @var MapaItemDotacao $mapaItemDotacao */
                foreach ($mapaItemDotacoes as $mapaItemDotacao) {
                    $entityManagerRemove($mapaItemDotacao);
                }

                $entityManagerRemove($mapaItem);
            }

            /** @var MapaSolicitacaoAnulacao $mapaSolicitacaoAnulacao */
            foreach ($mapaSolicitacao->getFkComprasMapaSolicitacaoAnulacoes() as $mapaSolicitacaoAnulacao) {
                $entityManagerRemove($mapaItemAnulacao);
            }

            $entityManager->flush();
            $entityManager->getConnection()->commit();
        } catch (\Exception $exception) {
            $entityManager->getConnection()->rollBack();

            $message = $this->trans('patrimonial.mapa.error', [], 'flashes');
            $this->getContainer()
                ->get('session')
                ->getFlashBag()
                ->add('error', $message);

            return false;
        }

        return true;
    }

    /**
     * @param MapaSolicitacao $mapaSolicitacao
     */
    public function postRemove($mapaSolicitacao)
    {
        $this->redirectByRoute('urbem_patrimonial_compras_mapa_show', [
            'id' => $this->id($mapaSolicitacao->getFkComprasMapa())
        ]);
    }
}
