<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Repository\Patrimonio\Compras\CotacaoFornecedorItemDesclassificacaoRepository;

/**
 * Class CotacaoFornecedorItemDesclassificacaoModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Compras
 */
class CotacaoFornecedorItemDesclassificacaoModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var CotacaoFornecedorItemDesclassificacaoRepository|null $repository */
    protected $repository = null;

    /**
     * CotacaoFornecedorItemDesclassificacaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Compras\CotacaoFornecedorItemDesclassificacao::class);
    }

    /**
     * @param $codCotacao
     * @param $exercicio
     * @param $codItem
     * @param $cgmFornecedor
     * @param $lote
     * @return array
     */
    public function removeCotacaoFornecedorItemDesclassificacao($codCotacao, $exercicio, $codItem, $cgmFornecedor, $lote)
    {
        return $this->repository->removeCotacaoFornecedorItemDesclassificacao($codCotacao, $exercicio, $codItem, $cgmFornecedor, $lote);
    }

    /**
     * @param array $params
     * @return Compras\CotacaoFornecedorItemDesclassificacao
     */
    public function buildCotacaoFornecedorItemDesclassificacao(array $params)
    {
        $cotacaoFornecedorItemModel = new CotacaoFornecedorItemModel($this->entityManager);
        $cotacaoFornecedorItem = $cotacaoFornecedorItemModel->getOne([
            'exercicio' => $params['exercicio'],
            'codCotacao' => $params['codCotacao'],
            'codItem' => $params['codItem'],
            'cgmFornecedor' => $params['cgmFornecedor'],
            'lote' => $params['lote']
        ]);

        $cotacaoFornecedorItemDesclassificacao = new Compras\CotacaoFornecedorItemDesclassificacao();
        $cotacaoFornecedorItemDesclassificacao->setJustificativa($params['justificativa']);
        $cotacaoFornecedorItemDesclassificacao->setFkComprasCotacaoFornecedorItem($cotacaoFornecedorItem);

        $this->save($cotacaoFornecedorItemDesclassificacao);

        return $cotacaoFornecedorItemDesclassificacao;
    }
}
