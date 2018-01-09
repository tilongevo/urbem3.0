<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CotacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\JulgamentoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaItemModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class CotacaoItemAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Compras
 */
class CotacaoItemAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_julgamento_proposta_cotacao';
    protected $baseRoutePattern = 'patrimonial/licitacao/julgamento-proposta/cotacao';

    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoEditar  = false;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['show']);
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

        /** @var Compras\CotacaoItem $cotacaoItem */
        $cotacaoItem = $this->getSubject();

        $catalogoItemModel = new CatalogoItemModel($entityManager);
        $julgamentoModel = new JulgamentoModel($entityManager);
        $mapaItemModel = new MapaItemModel($entityManager);

        $cotacao = $cotacaoItem->getFkComprasCotacao();
        $catalogoItem = $cotacaoItem->getFkAlmoxarifadoCatalogoItem();
        $catalogoItem = $catalogoItemModel->montaValorUltimaCompra($catalogoItem);
        $mapaItem = $entityManager->getRepository(Compras\MapaItem::class)->findOneBy([
            'codMapa' => $cotacao->getFkComprasMapaCotacoes()->last()->getCodMapa(),
            'exercicio' => $cotacao->getFkComprasMapaCotacoes()->last()->getExercicioMapa(),
            'codItem' => $catalogoItem->getCodItem()
        ]);

        $mapaItem = $mapaItemModel->montaValorReferencia($mapaItem);

        $arrCotacaoFornecedorItem = $cotacaoItem->getFkComprasCotacaoFornecedorItens()->toArray();

        usort($arrCotacaoFornecedorItem, function ($a, $b) {
            /**
             * @var Compras\CotacaoFornecedorItem $a
             * @var Compras\CotacaoFornecedorItem $b
             */
            if ($a->getVlCotacao() == $b->getVlCotacao()) {
                return 0;
            }
            return ($a->getVlCotacao() < $b->getVlCotacao()) ? -1 : 1;
        });

        for ($i = 0; $i < count($arrCotacaoFornecedorItem); $i++) {
            $arrCotacaoFornecedorItem[$i] =
                $catalogoItemModel->montaValorUnitario($arrCotacaoFornecedorItem[$i]);
        }
        $cotacaoItem->cotacaoFornecedorItens = $arrCotacaoFornecedorItem;

        $cotacaoItem->setFkAlmoxarifadoCatalogoItem($catalogoItem);
        $cotacaoItem->setFkComprasCotacao($cotacao);

        $cotacaoItem->julgamento = $julgamentoModel->findOne($cotacao);
        $cotacaoItem->julgamentoRef = sprintf("%s~%d", $cotacao->getExercicio(), $cotacao->getCodCotacao());
        $cotacaoItem->mapaItem = $mapaItem;
    }
}
