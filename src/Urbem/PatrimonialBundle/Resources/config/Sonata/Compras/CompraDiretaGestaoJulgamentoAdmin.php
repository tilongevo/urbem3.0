<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Urbem\CoreBundle\Entity\Compras\CompraDireta;
use Urbem\CoreBundle\Entity\Compras\Cotacao;
use Urbem\CoreBundle\Entity\Compras\CotacaoItem;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CompraDiretaModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\JulgamentoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaItemModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CompraDiretaGestaoJulgamentoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_compra_direta_gestao_julgamento';
    protected $baseRoutePattern = 'patrimonial/compras/compra-direta/gestao-julgamento';
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoEditar = false;

    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->remove('batch');
        $routeCollection->remove('export');
    }

    public function createQuery($context = 'list')
    {
        $ids = [0];
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $julgamentoPropostas = $entityManager
            ->getRepository('CoreBundle:Compras\CompraDireta')
            ->getJulgamentoPropostas($this->getExercicio());
        if (!empty($julgamentoPropostas)) {
            $ids = array_column($julgamentoPropostas, 'cod_compra_direta');
        }

        $qb = parent::createQuery($context);
        $qb->where(sprintf('o.codCompraDireta IN (%s)', implode(",", $ids)));

        return $qb;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codCompraDireta',
                null,
                ['label' => 'Compra direta']
            )
            ->add(
                'exercicioEntidade',
                null,
                ['label' => 'Exercício']
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $this->addActionsGrid($listMapper);
        $listMapper
            ->add(
                'codCompraDireta',
                null,
                ['label' => 'Compra direta']
            )
            ->add(
                'exercicioEntidade',
                null,
                ['label' => 'Exercício']
            )
            ->add(
                'dtEntregaProposta',
                null,
                ['label' => 'Entrega proposta']
            )
            ->add(
                'dtValidadeProposta',
                null,
                ['label' => 'Validade proposta']
            )
            ->add(
                'condicoesPagamento',
                null,
                ['label' => 'Condiçoes pagamento']
            )
            ->add('prazoEntrega')
            ->remove('_action')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                )
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
        $showMapper
            ->with("Excluir julgamento compra direta")
                ->add(
                    'codCompraDireta',
                    null,
                    ['label' => 'Compra direta']
                )
                ->add(
                    'exercicioEntidade',
                    null,
                    ['label' => 'Exercício']
                )
                ->add(
                    'dtEntregaProposta',
                    null,
                    ['label' => 'Entrega proposta']
                )
                ->add(
                    'dtValidadeProposta',
                    null,
                    ['label' => 'Validade proposta']
                )
                ->add(
                    'condicoesPagamento',
                    null,
                    ['label' => 'Condições pagamento']
                )
                ->add('prazoEntrega')
            ->end()
        ;
    }

    /**
     * @param CompraDireta  $object
     */
    public function preRemove($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        /** @var Cotacao $cotacao */
        $cotacao = $object->getFkComprasMapa()->getFkComprasMapaCotacoes()->first()->getFkComprasCotacao();
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $em->getConnection()->beginTransaction();
            $compraDiretaModel = new CompraDiretaModel($em);

            /** @var CotacaoItem $cotacaoItem */
            foreach ($cotacao->getFkComprasCotacaoItens() as $cotacaoItem) {
                $cgmFornecedor = $cotacaoItem->getFkComprasCotacaoFornecedorItens()->first()->getCgmFornecedor();
                $compraDiretaModel->deleteJulgamentoCompraDireta($cotacaoItem->getCodCotacao(), $cotacaoItem->getExercicio(), $cotacaoItem->getCodItem(), $cgmFornecedor, $cotacaoItem->getLote());

                $julgamentoModel = new JulgamentoModel($em);
                $julgamentoModel->removeJulgamento($cotacaoItem->getCodCotacao(), $cotacaoItem->getExercicio());
            }
            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', 'Erro ao Excluir o item selecionado: ' . $e->getMessage());
            $em->getConnection()->rollback();
        }

        (new RedirectResponse("/patrimonial/compras/compra-direta/gestao-julgamento/list"))->send();
    }
}
