<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacaoAnulacao;
use Urbem\CoreBundle\Entity\Orcamento\ReservaSaldosAnulada;
use Urbem\CoreBundle\Helper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Compras\Solicitacao;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoItem;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoItemAnulacao;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoItemAnulacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoItemDotacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemModel;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoAnulacao;
use Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos;

class SolicitacaoAnulacaoAdmin extends AbstractSonataAdmin
{
    /*
     * @TODO Remover duplicidade do FormFields e PrePersit
     */

    protected $baseRouteName = 'urbem_patrimonial_compras_solicitacao_anulacao';
    protected $baseRoutePattern = 'patrimonial/compras/solicitacao/anulacao';

    protected $includeJs = [
        '/patrimonial/javascripts/compras/solicitacaoanulacao.js',
    ];

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->forceRedirect('/patrimonial/compras/solicitacao/list');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->forceRedirect('/patrimonial/compras/solicitacao/list');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $formData = $this->getRequest()->request->get($this->getUniqid());
        if (!$this->getRequest()->isMethod('GET')) {
            $codSolicitacao = $formData['codSolicitacao'];
            $exercicio = $formData['exercicio'];
            $codEntidade = $formData['codEntidade'];
        } else {
            list($exercicio, $codEntidade, $codSolicitacao) = explode("~", $id);
        }


        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Compras\Solicitacao');

        $solicitacao = $entityManager
            ->getRepository(Solicitacao::class)
            ->findOneBy(
                [
                    'exercicio' => $exercicio,
                    'codEntidade' => $codEntidade,
                    'codSolicitacao' => $codSolicitacao,
                ]
            );

        $solicitacaoAnulacao = $entityManager
            ->getRepository(SolicitacaoAnulacao::class)
            ->findOneBy(
                [
                    'exercicio' => $exercicio,
                    'codEntidade' => $codEntidade,
                    'codSolicitacao' => $codSolicitacao,
                ]
            );

        $requisitante = $entityManager
            ->getRepository(SwCgm::class)
            ->findOneBy(
                [
                    'numcgm' => $solicitacao->getCgmRequisitante(),
                ]
            );

        $entidade = $entityManager
            ->getRepository('CoreBundle:Orcamento\Entidade')
            ->findOneByCodEntidade($codEntidade);

        $fieldOptions['dataSolicitacao'] = [
            'label' => 'label.patrimonial.compras.solicitacao.dtSolicitacao',
            'mapped' => false,
            'attr' => [
                'disabled' => 'true'
            ],
            'data' => $solicitacao->getTimestamp()->format('d/m/Y')
        ];

        $fieldOptions['motivo'] = [
            'label' => 'label.patrimonial.compras.solicitacao.motivo',
        ];

        if ($id) {
            if (!is_null($solicitacaoAnulacao)) {
                $fieldOptions['motivo']['data'] = $solicitacaoAnulacao->getMotivo();
            }
        }

        $formMapper
            ->add(
                'exercicio',
                'text',
                [
                    'label' => 'Exercício',
                    'data' => $exercicio,
                    'attr' => [
                        'readonly' => 'readonly'
                    ]
                ]
            )
            ->add(
                'codEntidadeTexto',
                'text',
                [
                    'label' => 'Entidade',
                    'data' => $entidade->getFkSwCgm()->getNumCgm() . ' - ' . $entidade->getFkSwCgm()->getNomCgm(),
                    'attr' => [
                        'readonly' => 'readonly'
                    ],
                    'mapped' => false
                ]
            )
            ->add('codEntidade', 'hidden', ['data' => $codEntidade])
            ->add(
                'codSolicitacao',
                'hidden',
                [
                    'data' => $solicitacao->getCodSolicitacao()
                ]
            )
            ->add(
                'solicitacao',
                'text',
                [
                    'label' => 'Solicitacao',
                    'data' => $solicitacao->getCodSolicitacao(),
                    'attr' => [
                        'disabled' => 'true'
                    ],
                    'mapped' => false
                ]
            )
            ->add(
                'dataSolicitacao',
                'text',
                $fieldOptions['dataSolicitacao']
            )
            ->add(
                'codAlmoxarifado',
                'text',
                [
                    'label' => 'Almoxarifado',
                    'data' => $solicitacao->getFkAlmoxarifadoAlmoxarifado()->getFkSwCgm()->getNomCgm(),
                    'attr' => [
                        'disabled' => 'true'
                    ],
                    'mapped' => false
                ]
            )
            ->add(
                'codObjeto',
                'text',
                [
                    'label' => 'Objeto',
                    'data' => $solicitacao->getFkComprasObjeto()->getCodObjeto() . ' - ' . $solicitacao->getFkComprasObjeto()->getDescricao(),
                    'attr' => [
                        'disabled' => 'true'
                    ],
                    'mapped' => false
                ]
            )
            ->add(
                'codRequisitante',
                'text',
                [
                    'label' => 'Requisitante',
                    'data' => $requisitante->getNumCgm() . ' - ' . $requisitante->getNomCgm(),
                    'attr' => [
                        'disabled' => 'true'
                    ],
                    'mapped' => false
                ]
            )
            ->add(
                'codSolicitante',
                'text',
                [
                    'label' => 'Solicitante',
                    'data' => $solicitacao->getFkSwCgm()->getNumCgm() . ' - ' . $solicitacao->getFkSwCgm()->getNomCgm(),
                    'attr' => [
                        'disabled' => 'true'
                    ],
                    'mapped' => false
                ]
            )
            ->add(
                'motivo',
                'textarea',
                $fieldOptions['motivo']
            )
            ->end();

        $this->criaFormItensAnulacao($solicitacao, $formMapper);
    }

    /**
     * @param $solicitacao
     * @param $formMapper
     */
    protected function criaFormItensAnulacao($solicitacao, $formMapper)
    {
        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Compras\Solicitacao');

        /** @var SolicitacaoItem $item */
        foreach ($solicitacao->getFkComprasSolicitacaoItens() as $item) {
            $codItem = $item->getCodItem();
            $codCentroCusto = $item->getFkAlmoxarifadoCentroCusto()->getCodCentro();

            $catalogoItemModel = new CatalogoItemModel($entityManager);
            $resultNomeUnidade = $catalogoItemModel->carregaAlmoxarifadoCatalogoUnidadeQuery($codItem);
            $unidadeMedida = $resultNomeUnidade == null ? 'Não Informada' : $resultNomeUnidade[0]->nom_unidade;

            $quantidadeAnular = 0;
            $quantidadeItem = $item->getQuantidade();
            $totalItem = $item->getVltotal();

            $solicitacaoAnulacao = $entityManager
                ->getRepository(SolicitacaoItemAnulacao::class)
                ->findOneBy([
                    'exercicio' => $item->getExercicio(),
                    'codSolicitacao' => $item->getCodSolicitacao(),
                    'codEntidade' => $item->getCodEntidade(),
                    'codCentro' => $item->getCodCentro(),
                    'codItem' => $item->getCodItem()
                ]);

            $readonly = false;

            if (!is_null($solicitacaoAnulacao)) {
                $quantidadeItem = $item->getQuantidade() - $solicitacaoAnulacao->getQuantidade();
                $totalItem = $item->getVltotal() - $solicitacaoAnulacao->getVlTotal();
            }
            if ($quantidadeItem == 0) {
                $readonly = 'readonly';
            }

            $fieldOptions['quantidade'] = [
                'label' => 'label.patrimonial.compras.solicitacao.quantidade',
                'mapped' => false,
                'required' => false,
                'data' => $quantidadeItem,
                'attr' => [
                    'readonly'=>'readonly',
                    'class' => 'quantity quantidade-calculo-qnt '
                ]
            ];

            $fieldOptions['quantidadeAnular'] = [
                'label' => 'label.patrimonial.compras.solicitacao.quantidadeAnular',
                'attr' => [
                    'class' => 'quantity quantidade-anulada ',
                    'readonly'=> $readonly,
                ],
                'mapped' => false,
                'required' => false,
                'data' => $quantidadeAnular
            ];

            $fieldOptions['valorTotal'] = [
                'label' => 'label.patrimonial.compras.solicitacao.vlTotal',
                'mapped' => false,
                'required' => false,
                'data' => $totalItem,
                'attr' => [
                    'readonly'=>'readonly',
                    'class' => 'total-calculo-qnt '
                ]
            ];

            $fieldOptions['valorAnular'] = [
                'label' => 'label.patrimonial.compras.solicitacao.vlTotalAnular',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'readonly'=>'readonly',
                    'class' => 'total-anulado '
                ]
            ];

            $fieldOptions['codCentro'] = [
                'data' => $codCentroCusto,
                'mapped' => false
            ];

            $formMapper
                ->with($item->getFkAlmoxarifadoCatalogoItem()->getDescricaoResumida() . ' / Centro de Custo - ' . $item->getFkAlmoxarifadoCentroCusto()->getDescricao() . ' / Unidade Medida - ' . $unidadeMedida)
                ->add(
                    'quantidade_' . $item->getCodItem(),
                    'text',
                    $fieldOptions['quantidade']
                )
                ->add(
                    'quantidadeAnular_' . $item->getCodItem(),
                    'text',
                    $fieldOptions['quantidadeAnular']
                )
                ->add(
                    'valorTotal_' . $item->getCodItem(),
                    'text',
                    $fieldOptions['valorTotal']
                )
                ->add(
                    'valorAnular_' . $item->getCodItem(),
                    'text',
                    $fieldOptions['valorAnular']
                )
                ->add(
                    'codCentro_' . $item->getCodItem(),
                    'hidden',
                    $fieldOptions['codCentro']
                )
                ->end();
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->forceRedirect('/patrimonial/compras/solicitacao/list');
    }

    public function prePersist($object)
    {

        $formData = $this->getRequest()->request->get($this->getUniqid());

        $codSolicitacao = $formData['codSolicitacao'];
        $codEntidade = $formData['codEntidade'];
        $exercicio = $formData['exercicio'];
        $motivo = $formData['motivo'];

        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Compras\Solicitacao');

        /** @var SolicitacaoAnulacao $solicitacaoAnulacao */
        $solicitacaoAnulacao = $entityManager
            ->getRepository(SolicitacaoAnulacao::class)
            ->findOneBy(
                [
                    'exercicio' => $exercicio,
                    'codEntidade' => $codEntidade,
                    'codSolicitacao' => $codSolicitacao,
                ]
            );

        if (!is_null($solicitacaoAnulacao)) {
            $anulacaoModel = new SolicitacaoItemAnulacaoModel($entityManager);
            $anulacaoModel->alteraMotivoAnulacao($solicitacaoAnulacao, $motivo);
        }

        $solicitacao = $entityManager
            ->getRepository(Solicitacao::class)
            ->findOneBy(
                [
                    'exercicio' => $exercicio,
                    'codEntidade' => $codEntidade,
                    'codSolicitacao' => $codSolicitacao,
                ]
            );

        $entidade = $entityManager
            ->getRepository('CoreBundle:Orcamento\Entidade')
            ->findOneByCodEntidade($codEntidade);

        $object->setExercicio($exercicio);

        $object->setTimestamp(new Helper\DateTimeMicrosecondPK());
        $object->setCodEntidade($entidade->getCodEntidade());
        if (!is_null($solicitacao)) {
            $object->setFkComprasSolicitacao($solicitacao);
        }
    }

    /**
     * @param SolicitacaoAnulacao $object
     */
    public function postPersist($object)
    {
        $entityManagerItem = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Compras\SolicitacaoItem');
        $itemModel = new SolicitacaoItemModel($entityManagerItem);

        $formData = $this->getRequest()->request->get($this->getUniqid());

        $codSolicitacao = $formData['codSolicitacao'];
        $codEntidade = $formData['codEntidade'];
        $exercicio = $formData['exercicio'];
        $motivo = $formData['motivo'];

        $stringStart = 'quantidade_'; // Valor da string de start para encontrar valores do codItem dentro do looping recebido
        $itensArray = $this->montaDataFormItens($formData, $stringStart);

        if (sizeof($itensArray) > 0) {
            $this->anularItensSolicitacao($object, $codSolicitacao, $codEntidade, $exercicio, $itensArray);
        }

        // Verifica o valor final da anulação para configurar a mensagem de sucesso
        // Caso a anulação esteja anulada por completo, ou seja, todos os itens anulados, teremos uma mensagem, caso contrário a mensagem é de uma anulação parcial
        $nuTotalVlSolicitado = 0.00;
        $nuTotalVlAnulada = 0.00;
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $solicitacaoModel = new SolicitacaoModel($entityManager);
        $itemsSolicitacao = $solicitacaoModel->montaRecuperaItensConsulta($codSolicitacao, $codEntidade, $exercicio);

        foreach ($itemsSolicitacao as $itens) {
            $nuTotalVlSolicitado = $nuTotalVlSolicitado + $itens->vl_solicitado;
            $nuTotalVlAnulada = $nuTotalVlAnulada + $itens->vl_anulado;
        }
        $message = 'label.patrimonial.compras.solicitacao.messageSucessoAnulacaoParcial';
        if ($nuTotalVlSolicitado <= $nuTotalVlAnulada) {
            $message = 'label.patrimonial.compras.solicitacao.messageSucessoAnulacaoCompleta';
        }

        $container = $this->getConfigurationPool()->getContainer();
        $container->get('session')->getFlashBag()->add('warning', $this->getTranslator()->trans($message));

        /** @var SolicitacaoAnulacao $solicitacaoAnulacao */
        $this->forceRedirect("/patrimonial/compras/solicitacao/{$this->getObjectKey($object->getFkComprasSolicitacao())}/show");
    }


    /**
     * @param $solicitacaoAnulacao
     * @param $codSolicitacao
     * @param $codEntidade
     * @param $exercicio
     * @param $itensArray
     */
    public function anularItensSolicitacao($solicitacaoAnulacao, $codSolicitacao, $codEntidade, $exercicio, $itensArray)
    {
        $entityManagerItemAnulacao = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Compras\SolicitacaoItemAnulacao');
        $anulacaoItemModel = new SolicitacaoItemAnulacaoModel($entityManagerItemAnulacao);
        $anulacaoItemDotacaoModel = new SolicitacaoItemDotacaoModel($entityManagerItemAnulacao);

        foreach ($itensArray['codItem'] as $codItem) {
            if ($itensArray['quantidadeAnular'][$codItem] > 0) {
                $codCentro = $itensArray['codCentro'][$codItem];
                $objItem = $entityManagerItemAnulacao
                    ->getRepository(SolicitacaoItem::class)
                    ->findBy(
                        [
                            'exercicio' => $exercicio,
                            'codEntidade' => $codEntidade,
                            'codSolicitacao' => $codSolicitacao,
                            'codCentro' => $codCentro,
                            'codItem' => $codItem
                        ]
                    );

                $resultAnularItemSolicitacao = $anulacaoItemModel->anularItemSolicitacao($solicitacaoAnulacao, $objItem[0], $codSolicitacao, $codEntidade, $exercicio, $codItem, $itensArray);

                $obTComprasSolicitacao = new SolicitacaoModel($entityManagerItemAnulacao);
                $itensDotacao = $obTComprasSolicitacao->recuperaSolicitacaoItensAnulacao($exercicio, $codEntidade, $codSolicitacao);

                foreach ($itensDotacao as $itemDotacao) {
                    if ($itemDotacao->cod_conta and $itemDotacao->cod_despesa) {
                        $itensDotacaoArray = [];
                        $itensDotacaoArray['timestamp'] = $resultAnularItemSolicitacao->getTimestamp();

                        $itensDotacaoArray['cod_entidade'] = $codEntidade;
                        $itensDotacaoArray['cod_solicitacao'] = $codSolicitacao;
                        $itensDotacaoArray['cod_centro'] = $itemDotacao->cod_centro;
                        $itensDotacaoArray['cod_conta'] = $itemDotacao->cod_conta;
                        $itensDotacaoArray['cod_despesa'] = $itemDotacao->cod_despesa;

                        $anulacaoItemDotacaoModel->anulaSolicitacaoItemDotacao($exercicio, $itensDotacaoArray, $codItem, $itensArray);

                        // Bloco resposável por controlar Saldo reserva
                        $quantidadeAnular = $itensArray['quantidadeAnular'][$codItem];
                        $valorAnular = $itensArray['valorAnular'][$codItem];


                        $resultItemDotacao = $anulacaoItemDotacaoModel->getOneSolicitacaoItemDotacao($exercicio, $codEntidade, $codSolicitacao, $codCentro, $codItem, $itemDotacao->cod_conta, $itemDotacao->cod_despesa);

                        if ($resultItemDotacao) {
                            $nuSaldoReserva = $resultItemDotacao->getVlReserva();
                            $nuVlReserva    = $nuSaldoReserva - $valorAnular;
                            $nuVlReserva    = number_format($nuVlReserva, 2, ".", ",");

                            $nuQuantidade   = $resultItemDotacao->getQuantidade();
                            $nuQntReserva   = $nuQuantidade - $quantidadeAnular;
                            $nuQntReserva   = number_format($nuQntReserva, 4, ".", ",");

                            if ($nuVlReserva > 0) {
                                $rsReservas = $entityManagerItemAnulacao
                                    ->getRepository(ReservaSaldos::class)
                                    ->findBy(
                                        [
                                            'codReserva' => $itemDotacao->cod_reserva,
                                            'exercicio' => $exercicio
                                        ]
                                    );

                                if (sizeof($rsReservas) > 0) {
                                    $obTComprasSolicitacaoItemDotacaoAnulacao = $entityManagerItemAnulacao
                                        ->getRepository(SolicitacaoItemDotacaoAnulacao::class)
                                        ->findBy(
                                            [
                                                'exercicio' => $exercicio,
                                                'cod_entidade' => $codEntidade,
                                                'cod_solicitacao' => $codSolicitacao,
                                                'cod_centro' => $itemDotacao->cod_centro,
                                                'cod_item' => $itemDotacao->cod_item,
                                                'cod_conta' => $itemDotacao->cod_conta,
                                                'cod_despesa' => $itemDotacao->cod_despesa,
                                            ]
                                        );

                                    if (!is_null($obTComprasSolicitacaoItemDotacaoAnulacao)) {
                                        $nuVlTotalAnulacoes = $obTComprasSolicitacaoItemDotacaoAnulacao->getVlAnulacao();
                                        $nuVlReservar = ($nuSaldoReserva - $nuVlTotalAnulacoes) - $valorAnular;
                                    } else {
                                        $nuVlReservar = $nuSaldoReserva - $valorAnular;
                                    }


                                    if ($nuVlReservar > 0.00) {
                                        $OrcamentoReservaSaldos = new SolicitacaoItemDotacaoModel($entityManagerItemAnulacao);
                                        $OrcamentoReservaSaldos->atualizaOrcamentoReservaSaldos($rsReservas, $nuVlReservar);
                                    } else {
                                        $obReservaSaldoAnulada = $entityManagerItemAnulacao
                                            ->getRepository(ReservaSaldosAnulada::class)
                                            ->findBy(
                                                [
                                                    'cod_reserva' => $itemDotacao->cod_reserva,
                                                    'exercicio' => $exercicio
                                                ]
                                            );

                                        if (!is_null($obReservaSaldoAnulada)) {
                                            $motivoAnulacao = $itensArray['motivo'][$codItem];
                                            $dtAnulacao = date('d/m/Y');
                                            $codReserva = $itemDotacao->cod_reserva;

                                            $ReservaSaldoAnulada = new SolicitacaoItemDotacaoModel($entityManagerItemAnulacao);
                                            $ReservaSaldoAnulada->inserirReservaSaldoAnulada($exercicio, $motivoAnulacao, $dtAnulacao, $codReserva);
                                        }
                                    }
                                }
                            } else {
                                if ($itemDotacao->cod_reserva) {
                                    $obReservaSaldoAnulada = $entityManagerItemAnulacao
                                        ->getRepository(ReservaSaldosAnulada::class)
                                        ->findBy(
                                            [
                                                'cod_reserva' => $itemDotacao->cod_reserva,
                                                'exercicio' => $exercicio
                                            ]
                                        );

                                    if (!is_null($obReservaSaldoAnulada)) {
                                        $motivoAnulacao = $itensArray['motivo'][$codItem];
                                        $dtAnulacao = date('d/m/Y');
                                        $codReserva = $itemDotacao->cod_reserva;

                                        $ReservaSaldoAnulada = new SolicitacaoItemDotacaoModel($entityManagerItemAnulacao);
                                        $ReservaSaldoAnulada->inserirReservaSaldoAnulada($exercicio, $motivoAnulacao, $dtAnulacao, $codReserva);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * @param $formData
     * @param $stringStart
     * @return array
     */
    public function montaDataFormItens($formData, $stringStart)
    {
        $valorCodItem = 0; // Valor do codItem encontrado para cada item. Setamos como 0 para podermos verificar se houve alteração e inserção na base de dados
        $ItemAnular = []; // Array que vai receber os valores para inserção

        /**
         * Looping para encontrar os valores segmentados por item
         */
        foreach ($formData as $key => $value) {
            // Encontra a ocorrência da palavra setada para encontrar codItem
            // Caso aconteça teremos alteração na variável $valorCodItem
            // Havendo alteração na variável faremos a construção do array com os valores para a inserção na base de dados
            if (strpos("[".$key."]", $stringStart)) {
                $codItem = explode($stringStart, $key); // Encontra codItem dentro do array recebido $formData
                $valorCodItem = $codItem[1];
                if ($valorCodItem != 0) {
                    if (strpos("[".$key."]", '_')) {
                        $indexArrayItem = explode('_', $key);
                        $ItemAnular['codItem'][] = $valorCodItem;
                        $ItemAnular[$indexArrayItem[0]][$valorCodItem] = $value;
                    }
                }
            } else {
                if ($valorCodItem != 0) {
                    if (strpos("[".$key."]", '_')) {
                        $indexArrayItem = explode('_', $key);
                        if ($indexArrayItem[0] != "") {
                            $ItemAnular[$indexArrayItem[0]][$valorCodItem] = $value;
                        }
                    }
                }
            }
        }
        return $ItemAnular;
    }
}
