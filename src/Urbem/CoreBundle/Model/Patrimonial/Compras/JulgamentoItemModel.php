<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Licitacao;
use Urbem\CoreBundle\Repository;

class JulgamentoItemModel extends AbstractModel
{
    protected $entityManager = null;

    /**
     * @var Repository\Patrimonio\Compras\JulgamentoItemRepository $repository
     */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Compras\JulgamentoItem::class);
    }

    public function montaRecuperaClassificacaoItens($exercicio, $cod_cotacao, $cod_item, $cgm_fornecedor)
    {
        return $this->repository->montaRecuperaClassificacaoItens($exercicio, $cod_cotacao, $cod_item, $cgm_fornecedor);
    }

    /**
     * @param Licitacao\Edital $edital
     * @return array|null
     */
    public function getItensDeFonecedoresQueGanharam(Licitacao\Edital $edital)
    {
        $result = $this->repository->getItensDeFonecedoresQueGanharam([
            'cod_cotacao' => $edital->getFkLicitacaoLicitacao()->getFkComprasMapa()->getFkComprasMapaCotacoes()->first()->getCodCotacao(),
            'exercicio' => $edital->getExercicio()
        ]);

        return $result;
    }

    /**
     * @param $codCotacao
     * @param $exercicio
     * @param $codItem
     * @param $cgmFornecedor
     * @param $lote
     * @return array
     */
    public function removeJulgamentoItem($codCotacao, $exercicio, $codItem, $cgmFornecedor, $lote)
    {
        return $this->repository->removeJulgamentoItem($codCotacao, $exercicio, $codItem, $cgmFornecedor, $lote);
    }

    /**
     * @param array $params
     * @return Compras\JulgamentoItem
     */
    public function buildOne(array $params)
    {
        $julgamentoItem = new Compras\JulgamentoItem();

        $cotacaoFornecedorItemModel = new CotacaoFornecedorItemModel($this->entityManager);
        $cotacaoFornecedorItem = $cotacaoFornecedorItemModel->getOne([
            'exercicio' => $params['exercicio'],
            'codCotacao' => $params['codCotacao'],
            'codItem' => $params['codItem'],
            'cgmFornecedor' => $params['cgmFornecedor'],
            'lote' => $params['lote']
        ]);

        $julgamentoItem->setFkComprasCotacaoFornecedorItem($cotacaoFornecedorItem);
        $julgamentoItem->setJustificativa($params['justificativa']);
        $julgamentoItem->setOrdem($params['status']);

        $this->save($julgamentoItem);

        return $julgamentoItem;
    }

    /**
     * @param $codCotacao
     * @param $exercicio
     * @param $codItem
     * @return null|object
     */
    public function getOneJulgamentoItem($exercicio, $codCotacao, $codItem, $cgmFornecedor, $lote)
    {
        return $this->repository->findOneBy([
            'exercicio' => $exercicio,
            'codCotacao' => $codCotacao,
            'codItem' => $codItem,
            'cgmFornecedor' => $cgmFornecedor,
            'lote' => $lote
        ]);
    }
}
