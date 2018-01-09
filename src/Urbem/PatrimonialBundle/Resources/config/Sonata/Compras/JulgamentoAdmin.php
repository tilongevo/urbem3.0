<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManager;
use DateTime;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\BooleanType;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Administracao\Assinatura;
use Urbem\CoreBundle\Entity\Administracao\AssinaturaModulo;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Compras\CompraDireta;
use Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItemDesclassificacao;
use Urbem\CoreBundle\Entity\Compras\CotacaoItem;
use Urbem\CoreBundle\Entity\Compras\Fornecedor;
use Urbem\CoreBundle\Entity\Compras\Julgamento;
use Urbem\CoreBundle\Entity\Compras\JulgamentoItem;
use Urbem\CoreBundle\Entity\Compras\Mapa;
use Urbem\CoreBundle\Entity\Compras\MapaItem;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class JulgamentoAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Compras
 */
class JulgamentoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_julgamento';
    protected $baseRoutePattern = 'patrimonial/compras/julgamento';
    protected $includeJs = [
        '/patrimonial/javascripts/compras/julgamento-proposta.js',
    ];

    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoEditar = false;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list', 'show']);
    }

    /**
     * @param string $context
     * @return ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder|ProxyQueryInterface $proxyQuery */
        $proxyQuery = parent::createQuery($context);
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $proxyQuery = $em->getRepository('CoreBundle:Compras\CompraDireta')
            ->getJulgamento($proxyQuery, $this->getExercicio());
        return $proxyQuery;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $exercicio = $this->getExercicio();

        $fieldOptions['fkOrcamentoEntidade']['label'] = [
            'label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.codEntidade'
        ];
        $fieldOptions['fkOrcamentoEntidade']['class'] = [
            'class' => Entidade::class,
            'choice_label' => 'fkSwCgm.nomCgm',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'query_builder' => function (EntidadeRepository $em) use ($exercicio) {
                return $em->findAllByExercicioAsQueryBuilder($exercicio);
            },
            'placeholder' => 'label.selecione'
        ];
        $fieldOptions['fkOrcamentoEntidade']['adminCode'] = [
            'admin_code' => 'financeiro.admin.entidade'
        ];


        $datagridMapper
            ->add('fkOrcamentoEntidade', 'composite_filter', $fieldOptions['fkOrcamentoEntidade']['label'], null, $fieldOptions['fkOrcamentoEntidade']['class'], $fieldOptions['fkOrcamentoEntidade']['adminCode'])
            ->add('fkComprasModalidade', 'composite_filter', [
                'label' => 'label.comprasDireta.codModalidade'
            ], null, [
                'class' => Compras\Modalidade::class,
                'choice_label' => 'descricao',
                'placeholder' => 'label.selecione'
            ])
            ->add('codCompraDireta', null, ['label' => 'label.comprasDireta.codCompraDireta'])
            ->add('timestamp', 'doctrine_orm_callback', [
                'callback' => function ($queryBuilder, $alias, $field, $value) {
                    if (!$value['value']) {
                        return;
                    }

                    $date = $value['value']->format('Y-m-d');

                    $queryBuilder
                        ->andWhere("DATE({$alias}.timestamp) = :timestamp")
                        ->setParameter('timestamp', $date);

                    return true;
                },
                'label' => 'label.comprasDireta.timestamp'
            ], 'sonata_type_date_picker', [
                'format' => 'dd/MM/yyyy',
            ])
            ->add('fkComprasMapa', 'composite_filter', [
                'label' => 'label.comprasDireta.codMapa'
            ], null, [
                'class' => Compras\Mapa::class,
                'choice_label' => function (Compras\Mapa $mapa) {
                    $exercicio = $mapa->getExercicio();

                    return "{$exercicio} | {$mapa->getCodMapa()}";
                },
                'placeholder' => 'label.selecione',
            ]);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $listMapper
            ->add(
                'codEntidade',
                null,
                [
                    'label' => 'label.patrimonial.compras.julgamento.codEntidade',
                    'admin_code' => 'financeiro.admin.entidade',
                ]
            )
            ->add(
                'codModalidade',
                null,
                [
                    'label' => 'label.patrimonial.compras.julgamento.codModalidade'
                ]
            )
            ->add(
                'codCompraDireta',
                null,
                [
                    'label' => 'label.patrimonial.compras.julgamento.codCompraDireta'
                ]
            )
            ->add(
                'timestamp',
                null,
                [
                    'label' => 'label.patrimonial.compras.julgamento.timestamp'
                ]
            )
            ->add(
                'codMapa.codMapa',
                null,
                [
                    'label' => 'label.patrimonial.compras.julgamento.codMapa.codMapa'
                ]
            );
        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        /**
         * @TODO: Some mandatory parameters are missing to generate a URL fo route
         * O erro a cima acontece  caso o parametro não é passado. Isso pode ser
         * uma falta de tratamento ou um erro de responsabilidade quanto a rota.
         */
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $cd = $em->getRepository('CoreBundle:Compras\CompraDireta')->find($id);


        $formMapper
            ->add(
                'dtJulgamento',
                'sonata_type_date_picker',
                [
                    'label' => 'Data do Julgamento',
                    'format' => 'dd/MM/yyyy',
                    'mapped' => false,
                ]
            )
            ->add(
                'hrJulgamento',
                'text',
                [
                    'label' => 'Hora do Julgamento',
                    'mapped' => false,
                    'attr' => [
                        'class' => 'hora'
                    ]
                ]
            );

        switch ($cd->getCodMapa()->getCodTipoLicitacao()->getCodTipoLicitacao()) {
            case 1: //Por Item
                $formMapper->add(
                    'item',
                    'choice',
                    [
                        'choice_label' => function (MapaItem $mi) {
                            return $mi->getCodItem()->getCodItem()
                            . ' - ' . $mi->getCodItem()->getDescricao()
                            . ' - ' . $mi->getQuantidade()
                            . ' - R$ ' . $mi->getVlTotal();
                        },
                        'choices' => $this->getLotes($cd),
                        'mapped' => false,
                        'attr' => [
                            'class' => 'select2-parameters'
                        ]
                    ]
                );
                break;
            case 2: //Por Lote
            case 3: //Por Preço Global
                $formMapper->add(
                    'item',
                    'choice',
                    [
                        'choice_label' => function (MapaItem $mi) {
                            return $mi->getCodItem()->getCodItem()
                            . ' - ' . $mi->getCodItem()->getDescricao()
                            . ' - ' . $mi->getQuantidade()
                            . ' - R$ ' . $mi->getVlTotal();
                        },

                        'choices' => call_user_func(function () use ($cd) {
                            /** @var MapaItem $item */
                            foreach ($cd->getCodMapa()->getMapaItem() as $item) {
                                if ($item->getCodMapa()->getCodMapaCotacao()->getCodCotacao()->hasCotacaoAnulada()) {
                                    continue;
                                }
                                $atLeastOneFornecedorItem = false;
                                /** @var CotacaoItem $cotacaoItem */
                                foreach ($item->getCodMapa()->getCodMapaCotacao()->getCodCotacao()->getCodCotacaoItem() as $cotacaoItem) {
                                    if ($cotacaoItem->getCodCotacaoFornecedorItem()) {
                                        $atLeastOneFornecedorItem = true;
                                        break;
                                    }
                                }
                                if (!$atLeastOneFornecedorItem) {
                                    continue;
                                }

                                yield $item;
                            }
                        }),
                        'choices' => $this->getItens($cd),
                        'mapped' => false,
                        'attr' => [
                            'class' => 'select2-parameters'
                        ]
                    ]
                );
                break;
        }
        $formMapper
            ->add(
                'incluir_assinaturas',
                'sonata_type_boolean',
                [
                    'label' => 'Incluir Assinaturas',
                    'mapped' => false,
                    'multiple' => false,
                    'expanded' => true,
                    'data' => false,
                ]
            )
            ->add(
                'assinatura',
                'choice',
                [
                    'choice_label' => function (Assinatura $a) {
                        return $a->getCodEntidade()->getCodEntidade()
                        . ' - ' . $a->getNumcgm()->getNumcgm()->getNomCgm()
                        . ' - ' . $a->getCargo();
                    },
                    'choices' => $this->getAssinaturas($cd),
                    'mapped' => false,
                    'multiple' => true,
                    'expanded' => false,
                    'attr' => [
                        'class' => 'select2-parameters'
                    ]
                ]
            );
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $lancamentoMaterial
     */
    public function validate(ErrorElement $errorElement, $lancamentoMaterial)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $cd = $em->getRepository('CoreBundle:Compras\CompraDireta')->find($this->getAdminRequestId());

        $hasAdjudicacao = $em->getRepository('CoreBundle:Compras\Mapa')
            ->hasAdjudicacao($this->getExercicio(), $cd->getCodMapa()->getCodMapa());
        if ($hasAdjudicacao) {
            $errorElement->addViolation('julgamento_proposta.errors.has_Adjudicacao');
        }

        /** @var MapaItem $item */
        $item = $this->getItens($cd)[$formData['item']];
        $hasFornecedoresInativos = $em->getRepository('CoreBundle:Compras\Fornecedor')
            ->hasFornecedoresInativos(
                $this->getExercicio(),
                $cd->getCodMapa()->getCodMapa(),
                $item->getCodItem()->getCodItem(),
                $item->getLote()
            );
        if ($hasFornecedoresInativos) {
            $fornecedoresInativos = $em->getRepository('CoreBundle:Compras\Fornecedor')->getFornecedoresInativos(
                $this->getExercicio(),
                $cd->getCodMapa()->getCodMapa(),
                $item->getCodItem()->getCodItem(),
                $item->getLote()
            )[0];
            $errorElement->addViolation(
                'julgamento_proposta.errors.has_fornecedor_inativo',
                "{$fornecedoresInativos['nom_cgm']}"
            );
        }

        $itensEmpatados = [];
        $fornecedores = $em->getRepository('CoreBundle:Compras\Fornecedor')->getFornecedores(
            $this->getExercicio(),
            $cd->getCodMapa()->getCodMapa(),
            $item->getCodItem()->getCodItem(),
            $item->getLote()
        );
        /** @var Fornecedor $fornecedor */
        foreach ($fornecedores as $fornecedor) {
            if (3 == $cd->getCodMapa()->getCodTipoLicitacao()->getCodTipoLicitacao()) {
                if (!$fornecedor['lote']) {
                    continue;
                }
            }
            $fornecedoresCompare = $fornecedores;
            foreach ($fornecedoresCompare as $fornecedorCompare) {
                if ($fornecedor['vl_total'] == $fornecedorCompare['vl_total']
                    && $fornecedor['vl_total'] == 0
                    && $fornecedor['status'] == "empatado"
                ) {
                    if (1 == $cd->getCodMapa()->getCodTipoLicitacao()->getCodTipoLicitacao()) {
                        $itensEmpatados[] = $fornecedor['item'];
                    } else {
                        $itensEmpatados[] = $fornecedor['lote'];
                    }
                }
            }
        }

        /** Regra 1.4 */
        $itensEmpatados = array_unique($itensEmpatados);
        if (count($itensEmpatados)) {
            $itemTipo = 'Lote(s)';
            if (1 == $cd->getCodMapa()->getCodTipoLicitacao()->getCodTipoLicitacao()) {
                $itemTipo = 'Item(ns)';
            }
            $errorElement->addViolation(
                'julgamento_proposta.errors.empatados',
                [$itemTipo, implode(',', $itensEmpatados)]
            );
        }
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $cd = $em->getRepository('CoreBundle:Compras\CompraDireta')->find($this->getAdminRequestId());
        $cotacao = $cd->getCotacao();

        /** Regra 2 */
        $julgamento = $em->getRepository('CoreBundle:Compras\Julgamento')->findOneBy([
            'codCotacao' => $cotacao->getCodCotacao(),
            'exercicio' => $cotacao->getExercicio(),
        ]);
        if (!$julgamento) {
            $julgamento = new Julgamento();
        }
        $julgamento
            ->setCodCotacao($cotacao)
            ->setExercicio($cotacao->getExercicio())
            ->setTimestamp(DateTime::createFromFormat(
                'd/m/Y h:i',
                "{$formData['dtJulgamento']} {$formData['hrJulgamento']}"
            ))
            ->setObservacao('');
        $em->persist($julgamento);

        /** Regra 3 */
        $cfids = $em->getRepository('CoreBundle:Compras\CotacaoFornecedorItemDesclassificacao')->findBy([
            'codCotacao' => $cotacao->getCodCotacao(),
            'exercicio' => $cotacao->getExercicio(),
        ]);
        foreach ($cfids as $cfid) {
            $em->remove($cfid);
        }

        /** Rega 4 */
        $julgamentoItens = $em->getRepository('CoreBundle:Compras\JulgamentoItem')->findBy([
            'codCotacao' => $cotacao->getCodCotacao(),
            'exercicio' => $cotacao->getExercicio(),
        ]);
        foreach ($julgamentoItens as $julgamentoItem) {
            $em->remove($julgamentoItem);
        }

        switch ($cd->getCodMapa()->getCodTipoLicitacao()->getCodTipoLicitacao()) {
            case 1:
                /** @var MapaItem $item */
                $item = $this->getItens($cd)[$formData['item']];
                $fornecedores = $em->getRepository('CoreBundle:Compras\Fornecedor')->getFornecedores(
                    $this->getExercicio(),
                    $cd->getCodMapa()->getCodMapa(),
                    $item->getCodItem()->getCodItem(),
                    $item->getLote()
                );
                foreach ($fornecedores as $fornecedor) {
                    if ('classificado' == $fornecedor['status']) {
                        $cotacaoFornecedorItem = $em->getRepository('CoreBundle:Compras\CotacaoFornecedorItem')->findOneBy([
                            'exercicio' => $cd->getCotacao()->getExercicio(),
                            'codCotacao' => $cd->getCotacao()->getCodCotacao(),
                            'lote' => $fornecedor['lote'],
                            'codItem' => $item->getCodItem()->getCodItem(),
                            'cgmFornecedor' => $fornecedor['cgm_fornecedor']
                        ]);
                        $julgamentoItem = new JulgamentoItem();
                        $julgamentoItem
                            ->setFkComprasJulgamentoItem($cotacaoFornecedorItem)
                            ->setCodCotacao($cd->getCotacao()->getCodCotacao())
                            ->setExercicio($cd->getCotacao()->getExercicio())
                            ->setCodItem($item->getCodItem()->getCodItem())
                            ->setCgmFornecedor($fornecedor['cgm_fornecedor'])
                            ->setOrdem($fornecedor['ordem'])
                            ->setLote($fornecedor['lote'])
                            ->setJustificativa($fornecedor['justificativa']);
                        $em->persist($julgamentoItem);
                    } else {
                        $cfid = new CotacaoFornecedorItemDesclassificacao();
                        $cfid
                            ->setCodCotacao($cd->getCotacao()->getCodCotacao())
                            ->setExercicio($cd->getCotacao()->getExercicio())
                            ->setCodItem($item->getCodItem()->getCodItem())
                            ->setCgmFornecedor($fornecedor['cgm_fornecedor'])
                            ->setLote($fornecedor['lote'])
                            ->setJustificativa($fornecedor['justificativa']);
                        $em->persist($cfid);
                    }
                }
                break;
            case 2:
            case 3:
                /** @var MapaItem $item */
                $item = $this->getLotes($cd)[$formData['item']];
                $fornecedores = $em->getRepository('CoreBundle:Compras\Fornecedor')->getFornecedores(
                    $this->getExercicio(),
                    $cd->getCodMapa()->getCodMapa(),
                    $item->getCodItem()->getCodItem(),
                    $item->getLote()
                );
                foreach ($fornecedores as $fornecedor) {
                    $cotacaoFornecedoresItens = $em->getRepository('CoreBundle:Compras\CotacaoFornecedorItem')->findBy([
                        'exercicio' => $this->getExercicio(),
                        'codCotacao' => $cd->getCotacao()->getCodCotacao(),
                        'cgmFornecedor' => $fornecedor['cgm_fornecedor'],
                        'lote' => $item->getLote(),
                    ]);
                    foreach ($cotacaoFornecedoresItens as $cotacaoFornecedorItem) {
                        if ('classificado' == $fornecedor['status']) {
                            $julgamentoItem = new JulgamentoItem();
                            $julgamentoItem->setCodCotacao($cotacaoFornecedorItem->getCodCotacao())
                                ->setExercicio($cotacaoFornecedorItem->getExercicio())
                                ->setCodItem($cotacaoFornecedorItem->getCodItem())
                                ->setCgmFornecedor($cotacaoFornecedorItem->getCgmFornecedor())
                                ->setLote($cotacaoFornecedorItem->getLote())
                                ->setOrdem($fornecedor['ordem'])
                                ->setJustificativa($fornecedor['justificativa']);
                            $em->persist($julgamentoItem);
                        } else {
                            $cfid = new CotacaoFornecedorItemDesclassificacao();
                            $cfid->setCodCotacao($cotacaoFornecedorItem->getCodCotacao())
                                ->setExercicio($cotacaoFornecedorItem->getExercicio())
                                ->setCodItem($cotacaoFornecedorItem->getCodItem())
                                ->setCgmFornecedor($cotacaoFornecedorItem->getCgmFornecedor())
                                ->setLote($cotacaoFornecedorItem->getLote())
                                ->setJustificativa($fornecedor['justificativa']);
                            $em->persist($cfid);
                        }
                    }
                }
                break;
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $compraDireta = $this->getObject($id);
    }

    protected function getLotes(CompraDireta $cd)
    {
        $itens = [];
        if ($cd->getCotacao()->hasCotacaoAnulada()) {
            //return $itens;
        }
        /** @var MapaItem $item */
        foreach ($cd->getCodMapa()->getMapaItem() as $item) {
            $atLeastOneFornecedorItem = false;
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());
            $qb = $em->getRepository('CoreBundle:Compras\CotacaoItem')
                ->createQueryBuilder('ci');
            $qb->join('CoreBundle:Compras\Cotacao', 'c', 'WITH', 'ci.codCotacao = c.codCotacao')
                ->join('c.codMapaCotacao', 'mc')
                ->join('mc.codMapa', 'm')
                ->where('ci.lote = :lote')
                ->andWhere('ci.exercicio = :exercicio')
                ->andWhere('m.codMapa = :codMapa')
//                ->groupBy('ci.exercicio', 'ci.codCotacao', 'ci.lote')
                ->setParameter('codMapa', $item->getCodMapa()->getCodMapa())
                ->setParameter('exercicio', $item->getExercicio())
                ->setParameter('lote', $item->getLote());
            /** @var CotacaoItem $cotacaoItem */
            foreach ($qb->getQuery()->getResult() as $cotacaoItem) {
                if ($cotacaoItem->getCodCotacaoFornecedorItem()) {
                    $atLeastOneFornecedorItem = true;
                    break;
                }
            }
            if (!$atLeastOneFornecedorItem) {
                continue;
            }

            $itens[] = $item;
        }
        return $itens;
    }

    protected function getItens(CompraDireta $cd)
    {
        $itens = [];
        if ($cd->getCotacao()->hasCotacaoAnulada()) {
            //return $itens;
        }
        /** @var MapaItem $item */
        foreach ($cd->getCodMapa()->getMapaItem() as $item) {
            $atLeastOneFornecedorItem = false;
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());
            $qb = $em->getRepository('CoreBundle:Compras\CotacaoItem')
                ->createQueryBuilder('ci');
            $qb->join('CoreBundle:Compras\Cotacao', 'c', 'WITH', 'ci.codCotacao = c.codCotacao')
                ->join('c.codMapaCotacao', 'mc')
                ->join('mc.codMapa', 'm')
                ->where('m.codMapa = :codMapa')
                ->setParameter('codMapa', $item->getCodMapa()->getCodMapa());
            /** @var CotacaoItem $cotacaoItem */
            foreach ($qb->getQuery()->getResult() as $cotacaoItem) {
                if ($cotacaoItem->getCodCotacaoFornecedorItem()) {
                    $atLeastOneFornecedorItem = true;
                    break;
                }
            }
            if (!$atLeastOneFornecedorItem) {
                continue;
            }

            $itens[] = $item;
        }
        return $itens;
    }

    protected function getAssinaturas(CompraDireta $cd)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $qb = $em->getRepository('CoreBundle:Administracao\AssinaturaModulo')
            ->createQueryBuilder('am');
        $subQuery = $qb
            ->select('am.numcgm')
            ->where('am.exercicio = :exercicio')
            ->andWhere('am.codEntidade = :entidade')
            ->andWhere('am.timestamp = (SELECT MAX(am1.timestamp) FROM CoreBundle:Administracao\AssinaturaModulo am1 WHERE am1.exercicio = :exercicio)')
            ->setParameter('exercicio', $this->getExercicio())
            ->setParameter('entidade', $cd->getCodEntidade()->getCodEntidade())
            ->getDQL();

        $qb = $em->getRepository('CoreBundle:Administracao\Assinatura')
            ->createQueryBuilder('a');
        $assinaturas = $qb
            ->select('a')
            ->where('a.exercicio = :exercicio')
            ->andWhere('a.codEntidade = :entidade')
            ->andWhere('a.timestamp = (SELECT MAX(a1.timestamp) FROM CoreBundle:Administracao\Assinatura a1 WHERE a1.exercicio = :exercicio)')
            ->andWhere('a.numcgm IN (' . $subQuery . ')')
            ->setParameter('exercicio', $this->getExercicio())
            ->setParameter('entidade', $cd->getCodEntidade()->getCodEntidade())
            ->getQuery()
            ->getResult();

        return $assinaturas;
    }

    protected function explodeId($id)
    {
        $id = explode('~', $id);
        return [
            'codCompraDireta' => $id[0],
            'codEntidade' => $id[1],
            'exercicioEntidade' => $id[2],
            'codModalidade' => $id[3],
        ];
    }
}
