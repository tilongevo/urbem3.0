<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * Class LancamentoMaterialEstornoModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class LancamentoMaterialEstornoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * LancamentoMaterialEstornoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Almoxarifado\LancamentoMaterialEstorno::class);
    }

    /**
     * Persist na tabela Lancamento Material Estorno
     *
     * @param Almoxarifado\LancamentoMaterial $lancamentoMaterialEstorno
     * @param Almoxarifado\LancamentoMaterial $lancamentoMaterial
     * @return Almoxarifado\LancamentoMaterialEstorno
     */
    public function buildOneLancamentoMaterialEstorno(
        Almoxarifado\LancamentoMaterial $lancamentoMaterialEstorno,
        Almoxarifado\LancamentoMaterial $lancamentoMaterial
    ) {
    
        $objLancamentoMaterialEstorno = new Almoxarifado\LancamentoMaterialEstorno();
        $objLancamentoMaterialEstorno->setFkAlmoxarifadoLancamentoMaterial($lancamentoMaterialEstorno);
        $objLancamentoMaterialEstorno->setFkAlmoxarifadoLancamentoMaterial1($lancamentoMaterial);

        $this->save($objLancamentoMaterialEstorno);
        return $objLancamentoMaterialEstorno;
    }

    /**
     * @param Almoxarifado\CatalogoItem $catalogoItem
     * @param Almoxarifado\Marca $marca
     * @param Almoxarifado\CentroCusto $centroCusto
     * @return mixed
     */
    public function getSaldoEstornado(Almoxarifado\CatalogoItem $catalogoItem, Almoxarifado\Marca $marca, Almoxarifado\CentroCusto $centroCusto)
    {
        $queryBuilder = $this->repository->createQueryBuilder('lme');
        $queryBuilder
            ->select('SUM(lm.quantidade) * -1')
            ->leftJoin('lme.fkAlmoxarifadoLancamentoMaterial1', 'lm')
            ->where('lm.codItem = :cod_item')
            ->andWhere('lm.codMarca = :cod_marca')
            ->andWhere('lm.codCentro = :cod_centro')
            ->setParameters([
                'cod_item' => $catalogoItem->getCodItem(),
                'cod_marca' => $marca->getCodMarca(),
                'cod_centro' => $centroCusto->getCodCentro()
            ])
        ;

        return $queryBuilder->getQuery()->getSingleResult(ORM\AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }
}
