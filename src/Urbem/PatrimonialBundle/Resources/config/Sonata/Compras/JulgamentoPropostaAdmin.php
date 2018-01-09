<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\Entity\Compras\Mapa;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Entity\Compras;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Compras\CompraDireta;
use Urbem\CoreBundle\Entity\Compras\CotacaoItem;
use Urbem\CoreBundle\Entity\Compras\MapaItem;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class JulgamentoPropostaAdmin extends AbstractSonataAdmin
{

    protected $baseRouteName = 'urbem_patrimonial_compras_julgamento_proposta';
    protected $baseRoutePattern = 'patrimonial/compras/julgamento-proposta';

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
        $datagridMapper
            ->add('fkOrcamentoEntidade', 'composite_filter', [
                'label' => 'label.comprasDireta.codEntidade',
                'admin_code' => 'financeiro.admin.entidade',
            ], null, [
                'class' => Orcamento\Entidade::class,
                'choice_label' => 'fkSwCgm.nomCgm',
                'query_builder' => function (EntityRepository $entityManager) use ($exercicio) {
                    $qb = $entityManager->createQueryBuilder('entidade');
                    $result = $qb->where('entidade.exercicio = :exercicio')
                        ->setParameter(':exercicio', $exercicio);

                    return $result;
                },
                'placeholder' => 'label.selecione'
            ])
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
                'class' => Mapa::class,
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
            ->add('fkOrcamentoEntidade.fkSwCgm.nomCgm', null, ['label' => 'label.comprasDireta.codEntidade'])
            ->add('fkComprasModalidade.descricao', null, ['label' => 'label.comprasDireta.codModalidade'])
            ->add('codCompraDireta', null, ['label' => 'label.comprasDireta.codCompraDireta'])
            ->add('timestamp', 'date', [
                'label' => 'label.comprasDireta.timestamp',
                'format' => 'd/m/Y',
            ])
            ->add('fkComprasMapa', null, [
                'associated_property' => function (Compras\Mapa $mapa) {
                    $exercicio = $mapa->getExercicio();

                    return "{$exercicio} | {$mapa->getCodMapa()}";
                },
                'label' => 'label.comprasDireta.codMapa'
            ]);
        $this->addActionsGrid($listMapper);
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
        /** @var CompraDireta $compraDireta */
        $compraDireta = $this->getObject($id);

        $mapa = $compraDireta->getFkComprasMapa();

        $mapaModel = new MapaModel($entityManager);
        $mapaItemModel = new MapaItemModel($entityManager);
        $mapaModel->montaValorReferenciaItensMapa($mapa);
        $mapaModel->montaValorUltimaCompraItensMapa($mapa);
        $mapaModel->montaCotacaoItemReference($mapa);
        $compraDireta->mapaItem = $mapaItemModel->getMapaItem($mapa->getCodMapa(), $mapa->getExercicio());
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
