<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Contabilidade;
use Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoContaDespesaItem;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Entity\Frota\Item;
use Urbem\CoreBundle\Entity\Orcamento\ContaDespesa;

class ConfiguracaoLancamentoContaDespesaItemModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ConfiguracaoLancamentoContaDespesaItem::class);
    }

    /**
     * Constroi um objeto de ConfiguracaoLancamentoContaDespesaItem
     * usando dados de RequisicaoItem e ContaDespesa.
     *
     * @param Almoxarifado\RequisicaoItem $requisicaoItem
     * @return ConfiguracaoLancamentoContaDespesaItem $configuracaoLancamentoContaDespesaItem
     */
    public function buildOneBasedOnRequisicaoItem(
        Almoxarifado\RequisicaoItem $requisicaoItem,
        Orcamento\ContaDespesa $contaDespesa
    ) {
        $configuracaoLancamentoContaDespesaItem = $this->repository->findOneBy([
            'codItem' => $requisicaoItem->getCodItem(),
            'exercicio' => $requisicaoItem->getExercicio(),
            'codContaDespesa' => $contaDespesa->getCodConta()
        ]);

        if (is_null($configuracaoLancamentoContaDespesaItem)) {
            $codItem = $requisicaoItem->getCodItem();
            $catalogoItemModel = new CatalogoItemModel($this->entityManager);
            $catalogoItem = $catalogoItemModel->getOneByCodItem($codItem);

            $configuracaoLancamentoContaDespesaItem = new ConfiguracaoLancamentoContaDespesaItem();
            $configuracaoLancamentoContaDespesaItem->setFkAlmoxarifadoCatalogoItem($catalogoItem);
            $configuracaoLancamentoContaDespesaItem->setFkOrcamentoContaDespesa($contaDespesa);

            $this->save($configuracaoLancamentoContaDespesaItem);
        }

        return $configuracaoLancamentoContaDespesaItem;
    }

    /**
     * Busca uma instancia de Contabilidade\ConfiguracaoLancamentoContaDespesaItem
     * com base em uma de RequisicaoItem.
     *
     * @param Almoxarifado\RequisicaoItem $requisicaoItem
     * @return null|ConfiguracaoLancamentoContaDespesaItem
     */
    public function findOneByRequisicaoItem(Almoxarifado\RequisicaoItem $requisicaoItem)
    {
        $catalogoItemModel = new CatalogoItemModel($this->entityManager);
        $catalogoItem = $catalogoItemModel->getOneByCodItem($requisicaoItem->getCodItem());

        $configuracaoLancamentoContaDespesaItem = $this->repository->findOneBy([
            'exercicio' => $requisicaoItem->getExercicio(),
            'codItem' => $catalogoItem
        ]);

        return $configuracaoLancamentoContaDespesaItem;
    }

    /**
     * @deprecated
     * @param CatalogoItem $catalogoItem
     * @param ContaDespesa $contaDespesa
     * @return null|ConfiguracaoLancamentoContaDespesaItem
     */
    public function buildOneBasedOnAutorizacaoAbastecimento(CatalogoItem $catalogoItem, ContaDespesa $contaDespesa)
    {
        trigger_error('Deprecated method, change to buildOne');
        return $this->buildOne($catalogoItem, $contaDespesa);
    }

    /**
     * @param CatalogoItem $catalogoItem
     * @param ContaDespesa $contaDespesa
     * @return null|object|ConfiguracaoLancamentoContaDespesaItem
     */
    public function buildOne(CatalogoItem $catalogoItem, ContaDespesa $contaDespesa)
    {
        $configuracaoLancamentoContaDespesaItem = $this->repository->findOneBy([
            'fkAlmoxarifadoCatalogoItem' => $catalogoItem->getCodItem(),
            'fkOrcamentoContaDespesa' => $contaDespesa,
        ]);

        if (is_null($configuracaoLancamentoContaDespesaItem)) {
            $configuracaoLancamentoContaDespesaItem = new Contabilidade\ConfiguracaoLancamentoContaDespesaItem();

            $configuracaoLancamentoContaDespesaItem->setFkAlmoxarifadoCatalogoItem($catalogoItem);
            $configuracaoLancamentoContaDespesaItem->setFkOrcamentoContaDespesa($contaDespesa);

            $this->save($configuracaoLancamentoContaDespesaItem);
        }

        return $configuracaoLancamentoContaDespesaItem;
    }

    /**
     * @param CatalogoItem $catalogoItem
     * @param $exercicio
     * @return null|ConfiguracaoLancamentoContaDespesaItem
     */
    public function findConfiguracaoByCatalogoItemExercicio(CatalogoItem $catalogoItem, $exercicio)
    {
        /** @var null|ConfiguracaoLancamentoContaDespesaItem $configuracaoLancamentoContaDespesaItem */
        $configuracaoLancamentoContaDespesaItem = $this->repository->findOneBy([
            'fkAlmoxarifadoCatalogoItem' => $catalogoItem,
            'exercicio' => $exercicio
        ]);

        return $configuracaoLancamentoContaDespesaItem;
    }
}
