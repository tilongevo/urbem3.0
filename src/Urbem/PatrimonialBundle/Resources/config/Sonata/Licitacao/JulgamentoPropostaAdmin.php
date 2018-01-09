<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Licitacao;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\LicitacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class JulgamentoPropostaAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao
 */
class JulgamentoPropostaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_julgamento_proposta';
    protected $baseRoutePattern = 'patrimonial/licitacao/julgamento-proposta';

    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoEditar  = false;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list', 'show']);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $exercicio = $this->getExercicio();
        $datagridMapper
            ->add('exercicio', null, [
                'label' => 'label.patrimonial.licitacao.exercicio'
            ], null, [

            ])
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
            ->add('codLicitacao', null, ['label' => 'label.julgamentoProposta.codigo'])
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
                'label' => 'label.patrimonial.licitacao.manutencaoProposta.data'
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
     * @param string $context
     * @return ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder|ProxyQueryInterface $proxyQuery */
        $proxyQuery = parent::createQuery($context);
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $exercicio = (!$this->getRequest()->query->get('filter')['exercicio']['value'] ?
            $this->getExercicio() : $this->getRequest()->query->get('filter')['exercicio']['value']);
        $proxyQuery = $em->getRepository('CoreBundle:Licitacao\Licitacao')
            ->getJulgamento($proxyQuery, $exercicio);

        return $proxyQuery;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $listMapper
            ->add('codLicitacaoExercicio', null, ['label' => 'label.patrimonial.licitacao.codLicitacao'])
            ->add('fkOrcamentoEntidade', 'text', ['label' => 'label.comprasDireta.codEntidade', 'admin_code' => 'financeiro.admin.entidade'])
            ->add('fkComprasModalidade', 'text', ['label' => 'label.comprasDireta.codModalidade'])
            ->add('timestamp', 'date', [
                'label' => 'label.patrimonial.licitacao.manutencaoProposta.data',
                'format' => 'd/m/Y',
            ])
            ->add('fkComprasMapa', 'text', [
                'label' => 'label.comprasDireta.codMapa'
            ]);

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $objectId = $this->getAdminRequestId();
        $this->setBreadCrumb(['id' => $objectId]);

        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        /** @var Licitacao\Licitacao $licitacao */
        $licitacao = $this->getObject($objectId);

        $mapa = $licitacao->getFkComprasMapa();

        $mapaModel = new MapaModel($entityManager);
        $mapaItemModel = new MapaItemModel($entityManager);
        $mapaModel->montaValorReferenciaItensMapa($mapa);
        $mapaModel->montaValorUltimaCompraItensMapa($mapa);
        $mapaModel->montaCotacaoItemReference($mapa);
        $licitacao->mapaItem = $mapaItemModel->getMapaItem($mapa->getCodMapa(), $mapa->getExercicio());
    }
}
