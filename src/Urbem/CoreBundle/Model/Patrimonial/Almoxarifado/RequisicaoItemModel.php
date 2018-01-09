<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\Marca;
use Urbem\CoreBundle\Entity\Almoxarifado\Requisicao;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoHomologada;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem;
use Urbem\CoreBundle\Entity\Frota;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\RequisicaoItemRepository;

/**
 * Class RequisicaoItemModel
 */
class RequisicaoItemModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var RequisicaoItemRepository|EntityRepository $repository */
    protected $repository = null;

    /**
     * RequisicaoItemModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager
            ->getRepository(RequisicaoItem::class);
    }

    /**
     * @param Requisicao $requisicao
     */
    public function removeAll(Requisicao $requisicao)
    {
        /** @var RequisicaoItem $requisicaoItem */
        foreach ($requisicao->getFkAlmoxarifadoRequisicaoItens() as $requisicaoItem) {
            (new RequisicaoItensAnulacaoModel($this->entityManager))->removeAll($requisicaoItem);
            $this->remove($requisicaoItem);
        }
    }

    /**
     * @param RequisicaoItem $requisicaoItem
     * @return boolean
     */
    public function canRemove(RequisicaoItem $requisicaoItem)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('requisicaoHomologada')
            ->from(RequisicaoHomologada::class, 'requisicaoHomologada')
            ->where('requisicaoHomologada.exercicio = :exercicio')
            ->andWhere('requisicaoHomologada.codRequisicao = :codRequisicao')
            ->andWhere('requisicaoHomologada.codAlmoxarifado = :codAlmoxarifado')
            ->andWhere('requisicaoHomologada.homologada = :isHomologada')
            ->setParameters([
                'exercicio' => $requisicaoItem->getExercicio(),
                'codRequisicao' => $requisicaoItem->getCodRequisicao(),
                'codAlmoxarifado' => $requisicaoItem->getCodAlmoxarifado(),
                'isHomologada' => true
            ])
        ;

        $result = $queryBuilder->getQuery()->getResult();

        return count($result) == 0 ;
    }

    /**
     * @param Almoxarifado $almoxarifado
     * @return QueryBuilder
     */
    public function searchCatalogoItemForRequisicaoQuery(Almoxarifado $almoxarifado)
    {
        $results = $this->repository->getItemByCodAlmoxarfidado($almoxarifado->getCodAlmoxarifado());

        $codItemArray = [];
        foreach ($results as $result) {
            $codItemArray[] = $result['cod_item'];
        }

        $codItemArray = true == empty($codItemArray) ? 0 : $codItemArray ;

        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('catalogoItem')
            ->from(CatalogoItem::class, 'catalogoItem')
            ->where(
                $queryBuilder->expr()->in('catalogoItem.codItem', $codItemArray)
            )
            ->orderBy('catalogoItem.descricao')
        ;

        return $queryBuilder;
    }

    /**
     * @param Almoxarifado $almoxarifado
     * @param CatalogoItem $catalogoItem
     * @return QueryBuilder
     */
    public function searchMarcasForRequisicaoQuery(Almoxarifado $almoxarifado, CatalogoItem $catalogoItem)
    {
        $results = $this->repository
            ->getMarcaCatalogo($catalogoItem->getCodItem(), $almoxarifado->getCodAlmoxarifado());

        $codMarcaArray = [];
        foreach ($results as $result) {
            $codMarcaArray[] = $result['cod_marca'];
        }

        $codMarcaArray = true == empty($codMarcaArray) ? 0 : $codMarcaArray ;

        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('marca')
            ->from(Marca::class, 'marca')
            ->where(
                $queryBuilder->expr()->in('marca.codMarca', $codMarcaArray)
            )
            ->orderBy('marca.descricao')
        ;

        return $queryBuilder;
    }

    /**
     * @param Almoxarifado $almoxarifado
     * @param CatalogoItem $catalogoItem
     * @return ArrayCollection
     */
    public function searchMarcasForRequisicao(Almoxarifado $almoxarifado, CatalogoItem $catalogoItem)
    {
        $result = $this
            ->searchMarcasForRequisicaoQuery($almoxarifado, $catalogoItem)
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_SIMPLEOBJECT)
        ;

        return new ArrayCollection($result);
    }

    /**
     * @param Almoxarifado $almoxarifado
     * @param CatalogoItem $catalogoItem
     * @param Marca $marca
     * @param Usuario $usuario
     * @return QueryBuilder
     */
    public function searchCentrosCustoForRequisicaoQuery(
        Almoxarifado $almoxarifado,
        CatalogoItem $catalogoItem,
        Marca $marca,
        Usuario $usuario
    ) {
        $results = $this->repository
            ->getCentroCustoCatalogo(
                $marca->getCodMarca(),
                $catalogoItem->getCodItem(),
                $almoxarifado->getCodAlmoxarifado(),
                $usuario->getNumcgm()
            );

        $codCentrosCustoArray = [];
        foreach ($results as $result) {
            $codCentrosCustoArray[] = $result['cod_centro'];
        }

        $codCentrosCustoArray = (true == empty($codCentrosCustoArray)) ? 0 : $codCentrosCustoArray;

        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('centroCusto')
            ->from(CentroCusto::class, 'centroCusto')
            ->where(
                $queryBuilder->expr()->in('centroCusto.codCentro', $codCentrosCustoArray)
            )
            ->orderBy('centroCusto.descricao')
        ;

        return $queryBuilder;
    }

    /**
     * @param Almoxarifado $almoxarifado
     * @param CatalogoItem $catalogoItem
     * @param Marca $marca
     * @return QueryBuilder
     */
    public function searchCentrosCustoGeralForRequisicaoQuery(
        Almoxarifado $almoxarifado,
        CatalogoItem $catalogoItem,
        Marca $marca
    ) {
        $results = $this->repository
            ->getCentroCustoCatalogoGeral(
                $marca->getCodMarca(),
                $catalogoItem->getCodItem(),
                $almoxarifado->getCodAlmoxarifado()
            );

        $codCentrosCustoArray = [];
        foreach ($results as $result) {
            $codCentrosCustoArray[] = $result['cod_centro'];
        }

        $codCentrosCustoArray = (true == empty($codCentrosCustoArray)) ? 0 : $codCentrosCustoArray;

        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('centroCusto')
            ->from(CentroCusto::class, 'centroCusto')
            ->where(
                $queryBuilder->expr()->in('centroCusto.codCentro', $codCentrosCustoArray)
            )
            ->orderBy('centroCusto.descricao')
        ;

        return $queryBuilder;
    }

    /**
     * @param Almoxarifado $almoxarifado
     * @param CatalogoItem $catalogoItem
     * @param Marca $marca
     * @param Usuario $usuario
     * @return ArrayCollection
     */
    public function searchCentrosCustoForRequisicao(
        Almoxarifado $almoxarifado,
        CatalogoItem $catalogoItem,
        Marca $marca,
        Usuario $usuario
    ) {
        $result = $this
            ->searchCentrosCustoForRequisicaoQuery($almoxarifado, $catalogoItem, $marca, $usuario)
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_SIMPLEOBJECT)
        ;

        return new ArrayCollection($result);
    }

    /**
     * @param Almoxarifado $almoxarifado
     * @param CatalogoItem $catalogoItem
     * @param Marca $marca
     * @return ArrayCollection
     */
    public function searchCentrosCustoGeralForRequisicao(
        Almoxarifado $almoxarifado,
        CatalogoItem $catalogoItem,
        Marca $marca
    ) {
        $result = $this
            ->searchCentrosCustoGeralForRequisicaoQuery($almoxarifado, $catalogoItem, $marca)
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_SIMPLEOBJECT)
        ;

        return new ArrayCollection($result);
    }

    /**
     * @param Almoxarifado $almoxarifado
     * @param CatalogoItem $catalogoItem
     * @param Marca $marca
     * @param CentroCusto $centroCusto
     * @return array
     */
    public function getSaldoEstoque(
        Almoxarifado $almoxarifado,
        CatalogoItem $catalogoItem,
        Marca $marca,
        CentroCusto $centroCusto
    ) {
        return $this->repository->getSaldoEstoque(
            $marca->getCodMarca(),
            $catalogoItem->getCodItem(),
            $almoxarifado->getCodAlmoxarifado(),
            $centroCusto->getCodCentro()
        );
    }

    /**
     * @param RequisicaoItem $requisicaoItem
     * @return array [] {
     *      @option string "saldo_requisitado"
     * }
     */
    public function getSaldoRequisitado(RequisicaoItem $requisicaoItem)
    {
        $saldoRequisitado = $this->repository->getSaldoRequisitado(
            $requisicaoItem->getExercicio(),
            $requisicaoItem->getCodAlmoxarifado(),
            $requisicaoItem->getCodRequisicao(),
            $requisicaoItem->getCodItem(),
            $requisicaoItem->getCodMarca(),
            $requisicaoItem->getCodCentro()
        );

        return ['saldo_requisitado' => $saldoRequisitado];
    }

    /**
     * @param RequisicaoItem $requisicaoItem
     * @return array [] {
     *      @option string "saldo_atendido"
     * }
     */
    public function getSaldoAtendido(RequisicaoItem $requisicaoItem)
    {
        $saldoAtendido = $this->repository->getSaldoAtendido(
            $requisicaoItem->getExercicio(),
            $requisicaoItem->getCodAlmoxarifado(),
            $requisicaoItem->getCodRequisicao(),
            $requisicaoItem->getCodItem(),
            $requisicaoItem->getCodMarca(),
            $requisicaoItem->getCodCentro()
        );

        return ['saldo_atendido' => $saldoAtendido];
    }

    /**
     * @param RequisicaoItem $requisicaoItem
     * @return array [] {
     *      @option string "saldo_devolvido"
     * }
     */
    public function getSaldoDevolvido(RequisicaoItem $requisicaoItem)
    {
        $saldoAtendido = $this->repository->getSaldoDevolvido(
            $requisicaoItem->getExercicio(),
            $requisicaoItem->getCodAlmoxarifado(),
            $requisicaoItem->getCodRequisicao(),
            $requisicaoItem->getCodItem(),
            $requisicaoItem->getCodMarca(),
            $requisicaoItem->getCodCentro()
        );

        return ['saldo_devolvido' => $saldoAtendido];
    }

    /**
     * @param RequisicaoItem $requisicaoItem
     * @return array [] {
     *      @option string "saldo_estoque"
     *      @option string "saldo_requisitado"
     *      @option string "saldo_atendido"
     * }
     */
    public function getSaldoEstoqueRequisitadoAtendido(RequisicaoItem $requisicaoItem)
    {
        $almoxarifado = $requisicaoItem->getFkAlmoxarifadoEstoqueMaterial()->getFkAlmoxarifadoAlmoxarifado();

        /** @var CatalogoItem $catalogoItem */
        $catalogoItem = $this->entityManager->find(CatalogoItem::class, $requisicaoItem->getCodItem());

        /** @var CentroCusto $centroCusto */
        $centroCusto = $this->entityManager->find(CentroCusto::class, $requisicaoItem->getCodCentro());

        /** @var Marca $marca */
        $marca = $this->entityManager->find(Marca::class, $requisicaoItem->getCodMarca());

        $saldoEstoqueResult = $this->getSaldoEstoque($almoxarifado, $catalogoItem, $marca, $centroCusto);
        $saldoEstoque = $saldoEstoqueResult[0];

        $saldoRequisitado = $this->getSaldoRequisitado($requisicaoItem);
        $saldoDevolvido = $this->getSaldoDevolvido($requisicaoItem);
        $saldoAtendido = $this->getSaldoAtendido($requisicaoItem);

        return array_merge($saldoEstoque, $saldoRequisitado, $saldoAtendido, $saldoDevolvido);
    }

    /**
     * @param RequisicaoItem $requisicaoItem
     * @return array|mixed
     */
    public function getQtdeAnuladaAtendidaRequisitada(RequisicaoItem $requisicaoItem)
    {
        $result = $this->repository->getSaldosParaAnulacao(
            $requisicaoItem->getCodAlmoxarifado(),
            $requisicaoItem->getCodRequisicao(),
            $requisicaoItem->getExercicio(),
            $requisicaoItem->getCodItem()
        );

        return $result;
    }

    /**
     * @param RequisicaoItem $requisicaoItem
     * @return bool
     */
    public function isFrotaItem(RequisicaoItem $requisicaoItem)
    {
        $catalogoItemModel = new CatalogoItemModel($this->entityManager);
        $catalogoItem = $catalogoItemModel->getOneByCodItem($requisicaoItem->getCodItem());

        $frotaItem = $this->entityManager
            ->getRepository(Frota\Item::class)
            ->find($catalogoItem);


        return !is_null($frotaItem);
    }

    /**
    * @param array $params
    * @return int
    */
    public function getSaldoEstoqueByParams(array $params = [])
    {
        $requisicaoItem = new RequisicaoItem();

        if (!empty($params['codAlmoxarifado'])) {
            $requisicaoItem->setCodAlmoxarifado($params['codAlmoxarifado']);
        }

        if (!empty($params['codItem'])) {
            $requisicaoItem->setCodItem($params['codItem']);
        }

        if (!empty($params['codMarca'])) {
            $requisicaoItem->setCodMarca($params['codMarca']);
        }

        if (!empty($params['codCentro'])) {
            $requisicaoItem->setCodCentro($params['codCentro']);
        }
        //dump($requisicaoItem);exit;
        return $this->getSaldoEstoqueByRequisicaoItem($requisicaoItem);
    }

    /**
    * @param RequisicaoItem $requisicaoItem
    * @return int
    */
    public function getSaldoEstoqueByRequisicaoItem(RequisicaoItem $requisicaoItem)
    {
        $qtdLancamentoMaterial = $this->getQtdLancamentoMaterial($requisicaoItem);
        $qtdAprovadaRequisicaoItem = $this->getQtdAprovadaRequisicaoItem($requisicaoItem);

        return max($qtdLancamentoMaterial - $qtdAprovadaRequisicaoItem, 0);
    }

    /**
    * @param RequisicaoItem $requisicaoItem
    * @return int
    */
    public function getQtdLancamentoMaterial(RequisicaoItem $requisicaoItem)
    {
        $qb = $this->entityManager->getRepository(LancamentoMaterial::class)->createQueryBuilder('lm');

        $qb->andWhere('lm.codAlmoxarifado = :codAlmoxarifado');
        $qb->setParameter('codAlmoxarifado', $requisicaoItem->getCodAlmoxarifado());

        $qb->andWhere('lm.codItem = :codItem');
        $qb->setParameter('codItem', $requisicaoItem->getCodItem());

        $qb->andWhere('lm.codMarca = :codMarca');
        $qb->setParameter('codMarca', $requisicaoItem->getCodMarca());

        $qb->andWhere('lm.codCentro = :codCentro');
        $qb->setParameter('codCentro', $requisicaoItem->getCodCentro());

        $qb->resetDqlPart('select');
        $qb->addSelect('SUM(lm.quantidade) AS quantidade');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    /**
    * @param RequisicaoItem $requisicaoItem
    * @return int
    */
    public function getQtdAprovadaRequisicaoItem(RequisicaoItem $requisicaoItem)
    {
        $qb = $this->repository->createQueryBuilder('ri');

        $qb->join('ri.fkAlmoxarifadoRequisicao', 'r');

        $qb->andWhere(
            sprintf(
                'r.status IN (\'%s\', \'%s\')',
                Requisicao::STATUS_AUTORIZADA_TOTAL,
                Requisicao::STATUS_AUTORIZADA_PARCIAL
            )
        );

        $qb->andWhere('ri.codAlmoxarifado = :codAlmoxarifado');
        $qb->setParameter('codAlmoxarifado', $requisicaoItem->getCodAlmoxarifado());

        $qb->andWhere('ri.codItem = :codItem');
        $qb->setParameter('codItem', $requisicaoItem->getCodItem());

        $qb->andWhere('ri.codMarca = :codMarca');
        $qb->setParameter('codMarca', $requisicaoItem->getCodMarca());

        $qb->andWhere('ri.codCentro = :codCentro');
        $qb->setParameter('codCentro', $requisicaoItem->getCodCentro());

        $qb->resetDqlPart('select');
        $qb->addSelect('SUM(ri.quantidadeAprovada) AS quantidade');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
}
