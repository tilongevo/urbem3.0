<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\AbstractModel;
use Doctrine\DBAL\Query\QueryBuilder;
use Urbem\CoreBundle\Repository\Patrimonio\Compras\OrdemRepository;

/**
 * Class OrdemModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Compras
 */
class OrdemModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var OrdemRepository|null  */
    protected $repository = null;

    /**
     * OrdemModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Compras\Ordem::class);
    }

    /**
     * @param QueryBuilder $query
     * @param $exercicio
     * @return QueryBuilder
     */
    public function listaOrdensAtivas($query, $exercicio)
    {
        $ordemAnulacoes = $this->entityManager
            ->getRepository(Compras\OrdemAnulacao::class)
            ->findByExercicio($exercicio);

        foreach ($ordemAnulacoes as $ordemAnulacao) {
            /** @var Compras\OrdemAnulacao $ordemAnulacao */
            $query
                ->andWhere($query->expr()->notIn('o.codOrdem', $ordemAnulacao->getFkComprasOrdem()->getCodOrdem()))
                ->andWhere($query->expr()->eq('o.exercicio', "'".$exercicio."'"));
        }
        
        return $query;
    }

    /**
     * @param QueryBuilder $query
     * @param string $exercicio
     * @return QueryBuilder
     */
    public function getListaEntradaComprasOrdem($query, $exercicio)
    {
        $ordens = $this->repository->listaEntradaComprasOrdem($exercicio);

        $ordemIds = [];
        foreach ($ordens as $ordem) {
            $ordemIds[] = $ordem->cod_ordem;
        }

        $ordemIds = empty($ordemIds) ? 0 : $ordemIds ;

        $query->andWhere($query->expr()->in('o.codOrdem', $ordemIds));

        return $query;
    }

    /**
     * @param $exercicio
     * @param string $params
     * @param string $limit
     * @return array
     */
    public function getEmpenhosAtivos($exercicio = false, $params = '', $limit = '')
    {
        return $this->repository->getEmpenhosAtivos($exercicio, $params, $limit);
    }

    /**
     * @param $exercicio
     * @return array
     */
    public function getEmpenhoInfo($exercicio)
    {
        return $this->repository->getEmpenhoInfo($exercicio);
    }

    /**
     * @param $exercicio
     * @param $codEmpenho
     * @param $codEntidade
     * @param $numItem
     * @return array
     */
    public function getItemPreEmpenho($exercicio, $codEmpenho, $codEntidade, $numItem)
    {
        return $this->repository->getItemPreEmpenho($exercicio, $codEmpenho, $codEntidade, $numItem);
    }

    /**
     * @param $exercicio
     * @param $codPreEmpenho
     * @param $numItem
     * @return array
     */
    public function getItemPreEmpenhoInfos($exercicio, $codPreEmpenho, $numItem)
    {
        return $this->repository->getItemPreEmpenhoInfos($exercicio, $codPreEmpenho, $numItem);
    }

    /**
     * @param $params
     * @return bool
     */
    public function updateItemPreEmpenho($params)
    {
        return $this->repository->updateItemPreEmpenho($params);
    }

    /**
     * @param $codOrdem
     */
    public function removeOrdemItem($codOrdem)
    {
        return $this->repository->removeOrdemItem($codOrdem);
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @return mixed
     */
    public function getValorAtendido($exercicio, $codEntidade)
    {
        return $this->repository->getValorAtendido($exercicio, $codEntidade);
    }

    /**
     * @param Compras\Ordem $ordem
     * @param Almoxarifado\CatalogoItem $catalogoItem
     * @return array
     */
    public function getItensEntrada(Compras\Ordem $ordem, Almoxarifado\CatalogoItem $catalogoItem = null)
    {
        $codItem = is_null($catalogoItem) ? null : $catalogoItem->getCodItem();

        return $this->repository->montaRecuperaItensNotaOrdemCompra(
            $ordem->getTipo(),
            $ordem->getExercicio(),
            $ordem->getCodOrdem(),
            $ordem->getCodEntidade(),
            $codItem
        );
    }

    /**
     * Recupera informações adicionais para um ou mais itens de uma Ordem de Compra
     *
     * @param Compras\Ordem $ordem
     * @param Almoxarifado\CatalogoItem $catalogoItem
     * @return object|null
     */
    public function getItemEntrada(Compras\Ordem $ordem, Almoxarifado\CatalogoItem $catalogoItem)
    {
        $result = $this->getItensEntrada($ordem, $catalogoItem);


        return false == empty($result) ? reset($result) : null;
    }

    /**
     * @param $params
     * @return mixed
     */
    public function carregaComprasOrdem($params)
    {
        return $this->repository->carregaComprasOrdem($params);
    }

    /**
     * Pega o próximo identificador disponível
     *
     * @param Compras\Ordem $ordem
     * @return int identifier
     */
    public function getAvailableIdentifier($ordem)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select(
                $queryBuilder->expr()->max("o.codOrdem") . " AS identifier"
            )
            ->from(Compras\Ordem::class, 'o')
            ->where("o.exercicio = '{$ordem->getExercicio()}'")
            ->andWhere("o.codEntidade = {$ordem->getCodEntidade()}")
            ->andWhere("o.tipo = '{$ordem->getTipo()}'")
        ;
        $result = $queryBuilder->getQuery()->getSingleResult();
        $lastCodOrdem = $result["identifier"] + 1;
        return $lastCodOrdem;
    }

    /**
     * @param $tipo
     * @param $exercicio
     * @param $codOrdem
     * @param $codEntidade
     * @return mixed
     */
    public function montaRecuperaItensNotaOrdemCompra($tipo, $exercicio, $codOrdem, $codEntidade, $codItem = null)
    {
        return $this->repository->montaRecuperaItensNotaOrdemCompra($tipo, $exercicio, $codOrdem, $codEntidade, $codItem);
    }
}
