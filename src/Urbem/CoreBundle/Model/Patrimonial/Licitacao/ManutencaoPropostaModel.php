<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Licitacao;

use Doctrine\ORM;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\ParameterBag;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Licitacao;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CotacaoModel;

/**
 * Class ManutencaoPropostaModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Licitacao
 */
class ManutencaoPropostaModel extends AbstractModel
{
    /** @var ORM\EntityManager|null $entityManager */
    protected $entityManager = null;
    /** @var ORM\EntityRepository|null|\Urbem\CoreBundle\Repository\Patrimonio\Licitacao\LicitacaoRepository $repository */
    protected $repository = null;

    /**
     * ManutencaoPropostaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Licitacao\Licitacao::class);
    }

    /**
     * @param $exercicio
     * @param Form $form
     * @return Compras\Cotacao
     */
    public function saveCotacao($exercicio, $form)
    {
        $cotacaoModel = new CotacaoModel($this->entityManager);

        $cotacao = new Compras\Cotacao();
        $cotacao->setExercicio($exercicio);
        $cotacao->setCodCotacao($cotacaoModel->getProximoCodCotacao($exercicio));
        $cotacao->setTimestamp($form->get('dtManutencao')->getData());

        $this->save($cotacao);
        return $cotacao;
    }

    /**
     * @param Compras\Cotacao $cotacao
     * @param Licitacao\Licitacao $licitacao
     * @return Compras\MapaCotacao
     */
    public function saveMapaCotacao($cotacao, $licitacao)
    {
        $mapaCotacao = new Compras\MapaCotacao();

        $mapaCotacao->setFkComprasMapa($licitacao->getFkComprasMapa());
        $mapaCotacao->setFkComprasCotacao($cotacao);

        $this->save($mapaCotacao);
        return $mapaCotacao;
    }

    /**
     * @param Compras\Cotacao $cotacao
     * @param ParameterBag $request
     * @param Compras\MapaItem $item
     * @return Compras\CotacaoItem
     */
    public function findOrCreateCotacaoItem($cotacao, $request, $item)
    {
        /** @var Compras\CotacaoItem $cotacaoItem */
        $cotacaoItem = $this->entityManager->getRepository(Compras\CotacaoItem::class)->findOneBy([
            'exercicio' => $cotacao->getExercicio(),
            'codCotacao' => $cotacao->getCodCotacao(),
            'codItem' => $item->getCodItem(),
            'lote' => $item->getLote()
        ]);

        if (is_null($cotacaoItem)) {
            $cotacaoItem = new Compras\CotacaoItem();

            $cotacaoItem->setLote($item->getLote());
            $cotacaoItem->setQuantidade($request->get('item_quantidade')[$item->getCodItem()]);
            $cotacaoItem->setFkComprasCotacao($cotacao);
            $cotacaoItem->setFkAlmoxarifadoCatalogoItem(
                $item->getFkComprasSolicitacaoItem()->getFkAlmoxarifadoCatalogoItem()
            );

            $this->save($cotacaoItem);
        }
        return $cotacaoItem;
    }

    /**
     * @param Compras\CotacaoItem $cotacaoItem
     * @param ParameterBag $request
     * @param CatalogoItemMarca $catalogoItemMarca
     * @param Form $form
     * @return Compras\CotacaoFornecedorItem
     */
    public function saveCotacaoFornecedorItem($cotacaoItem, $request, $catalogoItemMarca, $form)
    {
        $cotacaoFornecedorItem = new Compras\CotacaoFornecedorItem();
        $cotacaoFornecedorItem->setDtValidade(
            \DateTime::createFromFormat('d/m/Y', $request->get('item_data')[$cotacaoItem->getCodItem()])
        );
        $cotacaoFornecedorItem->setVlCotacao($request->get('item_valorTotal')[$cotacaoItem->getCodItem()]);
        $cotacaoFornecedorItem->setFkAlmoxarifadoCatalogoItemMarca($catalogoItemMarca);
        $cotacaoFornecedorItem->setFkComprasCotacaoItem($cotacaoItem);
        $cotacaoFornecedorItem->setFkComprasFornecedor($form->get('participantes')->getData());

        $this->save($cotacaoFornecedorItem);
        return $cotacaoFornecedorItem;
    }

    /**
     * @param Compras\CotacaoFornecedorItem $cotacaoFornecedorItem
     * @param Licitacao\Licitacao $licitacao
     * @return Licitacao\CotacaoLicitacao
     */
    public function saveCotacaoLicitacao($cotacaoFornecedorItem, $licitacao)
    {
        $cotacaoLicitacao = new Licitacao\CotacaoLicitacao();

        $cotacaoLicitacao->setFkLicitacaoLicitacao($licitacao);
        $cotacaoLicitacao->setFkComprasCotacaoFornecedorItem($cotacaoFornecedorItem);

        $this->save($cotacaoLicitacao);
        return $cotacaoLicitacao;
    }
}
