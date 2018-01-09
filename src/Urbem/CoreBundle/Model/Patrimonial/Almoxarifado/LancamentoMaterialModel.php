<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\Marca;
use Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento;
use Urbem\CoreBundle\Entity\Frota\Item;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\LancamentoMaterialRepository;

/**
 * Class LancamentoMaterialModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class LancamentoMaterialModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var EntityRepository|LancamentoMaterialRepository $repository */
    protected $repository = null;

    /**
     * LancamentoMaterialModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(LancamentoMaterial::class);
    }

    /**
     * @return int $lastCodLancamento
     */
    public function buildCodLancamentoMaterial()
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select(
                $queryBuilder->expr()->max("lancamentoMaterial.codLancamento") . " AS codLancamento"
            )
            ->from(LancamentoMaterial::class, 'lancamentoMaterial')
        ;

        $result = $queryBuilder->getQuery()->getSingleResult();

        $lastCodLancamento = $result["codLancamento"] + 1;

        return $lastCodLancamento;
    }

    /**
     * @param Almoxarifado\RequisicaoItem $requisicaoItem
     * @param Almoxarifado\LancamentoRequisicao $lancamentoRequisicao
     * @param $quantidade
     * @return string
     */
    public function getValorMercado(
        Almoxarifado\RequisicaoItem $requisicaoItem,
        Almoxarifado\LancamentoRequisicao $lancamentoRequisicao,
        $quantidade
    ) {
        $requisicaoItemModel = new RequisicaoItemModel($this->entityManager);
        $saldoAtendido = $requisicaoItemModel->getSaldoAtendido($requisicaoItem);

        $valorUnitario = 0;
        $resto = 0;

        if ($quantidade == $saldoAtendido['saldo_atendido']) {
            $valorUnitario = $this->getSaldoValorUnitarioRequisicao($lancamentoRequisicao);
            $resto = 0;
        } else {
            $valorUnitario = $this->getSaldoValorUnitarioRequisicao($lancamentoRequisicao, true);
            $resto = $this->getRecuperaRestoValorUnitario($lancamentoRequisicao);
        }

        return ($valorUnitario * $quantidade) + $resto;
    }

    /**
     * @param Almoxarifado\RequisicaoItem $requisicaoItem
     * @param Almoxarifado\LancamentoRequisicao $lancamentoRequisicao
     * @param Almoxarifado\NaturezaLancamento $naturezaLancamento
     * @param float $quantidade
     * @param string $complemento
     * @return LancamentoMaterial
     */
    public function buildOneBasedRequisicaoItem(
        Almoxarifado\RequisicaoItem $requisicaoItem,
        Almoxarifado\LancamentoRequisicao $lancamentoRequisicao,
        Almoxarifado\NaturezaLancamento $naturezaLancamento,
        $quantidade,
        $complemento
    ) {
        $codLancamentoMaterial = $this->buildCodLancamentoMaterial();

        $lancamentoMaterial = new LancamentoMaterial();
        $lancamentoMaterial->setCodLancamento($codLancamentoMaterial);
        $lancamentoMaterial->setFkAlmoxarifadoEstoqueMaterial($requisicaoItem->getFkAlmoxarifadoEstoqueMaterial());
        $lancamentoMaterial->setFkAlmoxarifadoNaturezaLancamento($naturezaLancamento);

        $lancamentoMaterial->setQuantidade($quantidade);
        $lancamentoMaterial->setComplemento($complemento);

        $valorMercado = $this->getValorMercado($requisicaoItem, $lancamentoRequisicao, $quantidade);
        $lancamentoMaterial->setValorMercado($valorMercado);

        $lancamentoRequisicao->setFkAlmoxarifadoLancamentoMaterial($lancamentoMaterial);

        return $lancamentoMaterial;
    }

    /**
     * @param Almoxarifado\InventarioItens $inventarioItens
     * @param Almoxarifado\NaturezaLancamento $naturezaLancamento
     * @return LancamentoMaterial
     */
    public function buildOneBasedInventarioItem(
        Almoxarifado\InventarioItens $inventarioItens,
        Almoxarifado\NaturezaLancamento $naturezaLancamento
    ) {
        $catalogoItemModel = new CatalogoItemModel($this->entityManager);
        /** @var Almoxarifado\CatalogoItem $catalogoItem */
        $catalogoItem = $catalogoItemModel->getOneByCodItem($inventarioItens->getCodItem());
        $valorUnitario = $this->getSaldoValorItem($catalogoItem);
        $valorMercado = $valorUnitario * $inventarioItens->getQuantidade();

        $lancamentoMaterial = new Almoxarifado\LancamentoMaterial();
        $lancamentoMaterial->setFkAlmoxarifadoEstoqueMaterial($inventarioItens->getFkAlmoxarifadoEstoqueMaterial());
        
        $lancamentoMaterial->setFkAlmoxarifadoNaturezaLancamento($naturezaLancamento);

        $lancamentoMaterial->setQuantidade($inventarioItens->getQuantidade());
        $lancamentoMaterial->setCodNatureza($naturezaLancamento->getCodNatureza());
        $lancamentoMaterial->setValorMercado($valorMercado);

        return $lancamentoMaterial;
    }

    /**
     * Constrói uma Entity LancamentoMaterial com base em um PedidoTranferenciaItem
     *
     * @param Almoxarifado\PedidoTransferenciaItem $pedidoTransferenciaItem
     * @param Almoxarifado\NaturezaLancamento $naturezaLancamento
     * @return LancamentoMaterial
     */
    public function buildOneBasedPedidoTransferenciaItem(
        Almoxarifado\PedidoTransferenciaItem $pedidoTransferenciaItem,
        Almoxarifado\NaturezaLancamento $naturezaLancamento
    ) {
        $codAlmoxarifado = $pedidoTransferenciaItem
                ->getFkAlmoxarifadoPedidoTransferencia()
                ->getFkAlmoxarifadoAlmoxarifado()
                ->getCodAlmoxarifado();

        $estoqueMaterial = $this->entityManager
            ->getRepository(Almoxarifado\EstoqueMaterial::class)
            ->findOneBy([
                'codItem' => $pedidoTransferenciaItem->getCodItem(),
                'codMarca' => $pedidoTransferenciaItem->getCodMarca(),
                'codCentro' => $pedidoTransferenciaItem->getCodCentro(),
                'codAlmoxarifado' => $codAlmoxarifado
            ]);

        $valorUnitario = $this->getSaldoValorItem($pedidoTransferenciaItem->getFkAlmoxarifadoCatalogoItem());
        $valorMercado = $valorUnitario * $pedidoTransferenciaItem->getQuantidade();

        $codLancamentoMaterial = $this->buildCodLancamentoMaterial();

        $lancamentoMaterial = new LancamentoMaterial();
        $lancamentoMaterial->setCodLancamento($codLancamentoMaterial);
        $lancamentoMaterial->setFkAlmoxarifadoEstoqueMaterial($estoqueMaterial);
        $lancamentoMaterial->setFkAlmoxarifadoCatalogoItem($pedidoTransferenciaItem->getFkAlmoxarifadoCatalogoItem());
        $lancamentoMaterial->setFkAlmoxarifadoNaturezaLancamento($naturezaLancamento);
        $lancamentoMaterial->setQuantidade($pedidoTransferenciaItem->getQuantidade());
        $lancamentoMaterial->setValorMercado($valorMercado);

        $this->entityManager->persist($lancamentoMaterial);

        return $lancamentoMaterial;
    }

    /**
     * @param Form $form
     * @param Almoxarifado\NaturezaLancamento $naturezaLancamento
     * @return LancamentoMaterial
     */
    public function buildOneBasedNaturezaLancamento(
        Form $form,
        Almoxarifado\NaturezaLancamento $naturezaLancamento
    ) {
        $codItem = $form->get('codItem')->getData();
        $codProcesso = $form->get('codProcesso');

        $catalogoItem = $this->entityManager->getRepository(Almoxarifado\CatalogoItem::class)
            ->findOneBy([
                'codItem' => $codItem->getCodItem()
            ]);
        $valorUnitario = $this->getSaldoValorItem($catalogoItem);
        $valorMercado = $valorUnitario * $codItem->getQuantidade();

        $codLancamentoMaterial = $this->buildCodLancamentoMaterial();

        $lancamentoMaterial = new LancamentoMaterial();
        $lancamentoMaterial->setCodLancamento($codLancamentoMaterial);
        $lancamentoMaterial->setFkAlmoxarifadoCatalogoItem($catalogoItem);
        $lancamentoMaterial->setFkAlmoxarifadoEstoqueMaterial($codItem->getFkEstoqueMaterial());
        $lancamentoMaterial->setFkAlmoxarifadoNaturezaLancamento($naturezaLancamento);

        $lancamentoMaterial->setQuantidade($codItem->getQuantidade());
        $lancamentoMaterial->setCodNatureza($naturezaLancamento->getCodNatureza());
        $lancamentoMaterial->setValorMercado($valorMercado);

        $doacaoEmprestimoModel = new DoacaoEmprestimoModel($this->entityManager);
        $lancamentoMaterial->setFkAlmoxarifadoLancamentoMaterialAlmoxarifadoDoacaoEmprestimo(
            $doacaoEmprestimoModel->buildOne($lancamentoMaterial, $codProcesso->getData())
        );

        return $lancamentoMaterial;
    }

    /**
     * @param Almoxarifado\CatalogoItem $item
     * @return string
     */
    public function getSaldoValorItem(Almoxarifado\CatalogoItem $item)
    {
        $sql = <<<SQL
SELECT 
  CASE WHEN SUM(quantidade) <> 0 THEN 
    SUM(valor_mercado) / SUM(quantidade) 
  END AS valor_unitario 
FROM almoxarifado.lancamento_material
WHERE lancamento_material.tipo_natureza = :tipo_natureza
      AND lancamento_material.cod_item = :cod_item;
SQL;

        $params['tipo_natureza'] = "E";
        $params['cod_item'] = $item->getCodItem();

        $connection = $this->entityManager->getConnection();
        $statement = $connection->prepare($sql);
        $statement->execute($params);

        $result = $statement->fetch();

        return number_format($result['valor_unitario'], 2);
    }

    /**
     * @param Almoxarifado\LancamentoRequisicao $lancamentoRequisicao
     * @param bool $truncated
     * @return string
     */
    public function getSaldoValorUnitarioRequisicao(
        Almoxarifado\LancamentoRequisicao $lancamentoRequisicao,
        $truncated = false
    ) {
        if ($truncated) {
            $sql = <<<SQL
SELECT 
  CASE WHEN SUM(quantidade) <> 0 THEN 
    COALESCE(TRUNC(SUM(valor_mercado) / SUM(quantidade), 2), 0)
  ELSE 0 END AS valor_unitario 
SQL;
        } else {
            $sql = <<<SQL
SELECT 
  CASE WHEN SUM(quantidade) <> 0 THEN 
    SUM(valor_mercado) / SUM(quantidade) 
  END AS valor_unitario 
SQL;
        }

        $sql .= <<<SQL
FROM almoxarifado.lancamento_material
  INNER JOIN almoxarifado.lancamento_requisicao
     ON lancamento_requisicao.cod_lancamento = lancamento_material.cod_lancamento
    AND lancamento_requisicao.cod_item = lancamento_material.cod_item
    AND lancamento_requisicao.cod_centro = lancamento_material.cod_centro 
    AND lancamento_requisicao.cod_marca = lancamento_material.cod_marca
    AND lancamento_requisicao.cod_almoxarifado = lancamento_material.cod_almoxarifado
WHERE lancamento_material.tipo_natureza = ?
SQL;

        $params[] = "S";
        if (!empty($lancamentoRequisicao->getExercicio())) {
            $sql .= " AND lancamento_requisicao.exercicio = ?";
            $params[] = $lancamentoRequisicao->getExercicio();
        }

        if (!is_null($lancamentoRequisicao->getCodRequisicao())) {
            $sql .= " AND lancamento_requisicao.cod_requisicao = ?";
            $params[] = $lancamentoRequisicao->getCodRequisicao();
        }

        if (!is_null($lancamentoRequisicao->getCodItem())) {
            $sql .= " AND lancamento_requisicao.cod_item = ?" ;

            $params[] = $lancamentoRequisicao->getCodItem();
        }

        $connection = $this->entityManager->getConnection();
        $statement = $connection->prepare($sql);
        $statement->execute($params);

        $result = $statement->fetch();

        return number_format($result['valor_unitario'], 2);
    }

    /**
     * @param Almoxarifado\LancamentoRequisicao $lancamentoRequisicao
     * @return string
     */
    public function getRecuperaRestoValorUnitario(Almoxarifado\LancamentoRequisicao $lancamentoRequisicao)
    {
        $sql = <<<SQL
SELECT 
  CASE WHEN SUM(quantidade) <> 0 THEN
    SUM(valor_mercado) - TRUNC(TRUNC(SUM(valor_mercado)/SUM(quantidade), 2) * SUM(quantidade), 2)
  ELSE 
    0
  END AS resto
FROM almoxarifado.lancamento_material 
SQL;

        $params = [];

        if (!is_null($lancamentoRequisicao->getCodItem())) {
            $codItem = $lancamentoRequisicao->getCodItem();

            $sql .= "WHERE cod_item = ?";
            $params[] = $codItem;
        }

        $connection = $this->entityManager->getConnection();
        $statement = $connection->prepare($sql);
        $statement->execute($params);

        $result = $statement->fetch();

        return number_format($result['resto'], 2);
    }

    /**
     * @param Almoxarifado\CatalogoItem $item
     * @param Almoxarifado\NaturezaLancamento $naturezaLancamento
     * @param $form
     * @return LancamentoMaterial
     */
    public function buildOneBasedLancamentoPerecivel(
        Almoxarifado\CatalogoItem $item,
        Almoxarifado\NaturezaLancamento $naturezaLancamento,
        $form
    ) {

        $quantidade = $form['quantidade'];
        $valorMercado = $quantidade * $form['valorMercado'];

        $codLancamentoMaterial = $this->buildCodLancamentoMaterial();

        $lancamentoMaterial = new LancamentoMaterial();
        $lancamentoMaterial->setCodLancamento($codLancamentoMaterial);
        $lancamentoMaterial->setFkAlmoxarifadoCatalogoItem($item);
        $lancamentoMaterial->setFkAlmoxarifadoEstoqueMaterial($item->getFkEstoqueMaterial());
        $lancamentoMaterial->setFkAlmoxarifadoNaturezaLancamento($naturezaLancamento);

        $lancamentoMaterial->setQuantidade($quantidade);
        $lancamentoMaterial->setCodNatureza($naturezaLancamento->getCodNatureza());
        $lancamentoMaterial->setValorMercado($valorMercado);

        $this->save($lancamentoMaterial);

        return $lancamentoMaterial;
    }

    /**
     * @param CatalogoItem|Item $item
     * @return string|float
     */
    public function getSaldoValorUnitario($item)
    {
        $result = $this->repository->getSaldoValorUnitario($item->getCodItem());

        return $result['valor_unitario'];
    }

    /**
     * @param CatalogoItem|Item $item
     * @return string|float
     */
    public function getRestoValor($item)
    {
        $result = $this->repository->getRestoValor($item->getCodItem());

        return $result['resto'];
    }

    /**
     * @param Almoxarifado\CatalogoItem $item
     * @param Almoxarifado\NaturezaLancamento $naturezaLancamento
     * @param $form
     * @param Almoxarifado\EstoqueMaterial $estoqueMaterial
     * @return LancamentoMaterial
     */
    public function buildOneBasedAutorizacaoAbastecimento(
        Almoxarifado\CatalogoItem $item,
        Almoxarifado\NaturezaLancamento $naturezaLancamento,
        $form,
        Almoxarifado\EstoqueMaterial $estoqueMaterial
    ) {

        $quantidade = $form['quantidade'];
        $valorMercado = $quantidade * $form['valorMercado'];

        $codLancamentoMaterial = $this->buildCodLancamentoMaterial();

        $lancamentoMaterial = new LancamentoMaterial();
        $lancamentoMaterial->setCodLancamento($codLancamentoMaterial);
        $lancamentoMaterial->setFkAlmoxarifadoCatalogoItem($item);
        $lancamentoMaterial->setFkAlmoxarifadoEstoqueMaterial($estoqueMaterial);
        $lancamentoMaterial->setFkAlmoxarifadoNaturezaLancamento($naturezaLancamento);

        $lancamentoMaterial->setQuantidade($quantidade);
        $lancamentoMaterial->setCodNatureza($naturezaLancamento->getCodNatureza());
        $lancamentoMaterial->setValorMercado($valorMercado);

        $this->save($lancamentoMaterial);

        return $lancamentoMaterial;
    }

    /**
     * Recupera o Lancamento Material
     *
     * @param int $codItem
     * @param int $codMarca
     * @param int $codAlmoxarifado
     * @param int $codCentro
     * @param string $exercicioLancamento
     * @param int $numLancamento
     * @param int $codNatureza
     * @param string $tipoNatureza
     * @return LancamentoMaterial
     */
    public function getLancamentoMaterial(
        $codItem,
        $codMarca,
        $codAlmoxarifado,
        $codCentro,
        $exercicioLancamento,
        $numLancamento,
        $codNatureza,
        $tipoNatureza
    ) {
    
        return $this->entityManager->getRepository(LancamentoMaterial::class)
            ->findOneBy([
                'codItem' => $codItem,
                'codMarca' => $codMarca,
                'codAlmoxarifado' => $codAlmoxarifado,
                'codCentro' => $codCentro,
                'exercicioLancamento' => $exercicioLancamento,
                'numLancamento' => $numLancamento,
                'codNatureza' => $codNatureza,
                'tipoNatureza' => $tipoNatureza
            ]);
    }

    /**
     * @param Almoxarifado\EstoqueMaterial      $estoqueMaterial
     * @param Almoxarifado\CatalogoItem         $catalogoItem
     * @param Almoxarifado\NaturezaLancamento   $naturezaLancamento
     * @param float                             $quantidade
     * @param float                             $valorMercado
     * @return LancamentoMaterial
     */
    public function findOrCreateLancamentoMaterial(
        Almoxarifado\EstoqueMaterial $estoqueMaterial,
        Almoxarifado\CatalogoItem $catalogoItem,
        Almoxarifado\NaturezaLancamento $naturezaLancamento,
        $quantidade,
        $valorMercado
    ) {
        $lancamentoMaterial = $this->repository->findOneBy([
            'fkAlmoxarifadoEstoqueMaterial' => $estoqueMaterial,
            'fkAlmoxarifadoCatalogoItem' => $catalogoItem,
            'fkAlmoxarifadoNaturezaLancamento' => $naturezaLancamento
        ]);

        if (true == is_null($lancamentoMaterial)) {
            $lancamentoMaterial = new LancamentoMaterial();
            $lancamentoMaterial->setFkAlmoxarifadoEstoqueMaterial($estoqueMaterial);
            $lancamentoMaterial->setFkAlmoxarifadoCatalogoItem($catalogoItem);
            $lancamentoMaterial->setFkAlmoxarifadoNaturezaLancamento($naturezaLancamento);
            $lancamentoMaterial->setQuantidade($quantidade);
            $lancamentoMaterial->setValorMercado($valorMercado);

            $this->save($lancamentoMaterial);
        }

        return $lancamentoMaterial;
    }

    /**
     * @param EstoqueMaterial $estoqueMaterial
     * @param NaturezaLancamento $naturezaLancamento
     * @param LancamentoMaterial|null $exceptLancamentoMaterial
     * @return null|LancamentoMaterial
     */
    public function findLancamentoMaterial(EstoqueMaterial $estoqueMaterial,
                                           NaturezaLancamento $naturezaLancamento,
                                           LancamentoMaterial $exceptLancamentoMaterial = null) {

        $queryBuilder = $this->repository->createQueryBuilder('lancamentoMaterial');
        $queryBuilder
            ->where('lancamentoMaterial.codItem = :cod_item')
            ->andWhere('lancamentoMaterial.codMarca = :cod_marca')
            ->andWhere('lancamentoMaterial.codCentro = :cod_centro')
            ->andWhere('lancamentoMaterial.codAlmoxarifado = :cod_almoxarifado')
            ->andWhere('lancamentoMaterial.exercicioLancamento = :exercicio_lancamento')
            ->andWhere('lancamentoMaterial.numLancamento = :num_lancamento')
            ->andWhere('lancamentoMaterial.codNatureza = :cod_natureza')
            ->andWhere('lancamentoMaterial.tipoNatureza = :tipo_natureza')
            ->setParameters([
                'cod_item' => $estoqueMaterial->getCodItem(),
                'cod_marca' => $estoqueMaterial->getCodMarca(),
                'cod_centro' => $estoqueMaterial->getCodCentro(),
                'cod_almoxarifado' => $estoqueMaterial->getCodAlmoxarifado(),
                'exercicio_lancamento' => $naturezaLancamento->getExercicioLancamento(),
                'num_lancamento' => $naturezaLancamento->getNumLancamento(),
                'cod_natureza' => $naturezaLancamento->getCodNatureza(),
                'tipo_natureza' => $naturezaLancamento->getTipoNatureza(),
            ])
        ;

        if (false == is_null($exceptLancamentoMaterial)) {
            $queryBuilder
                ->andWhere('lancamentoMaterial.codLancamento <> :cod_lancamento')
                ->setParameter('cod_lancamento', $exceptLancamentoMaterial->getCodLancamento())
            ;
        }

        return $queryBuilder->getQuery()->getSingleResult();
    }
}
