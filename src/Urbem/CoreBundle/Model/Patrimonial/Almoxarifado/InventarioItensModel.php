<?php
/**
 * Created by PhpStorm.
 * User: gabrielvie
 * Date: 05/10/16
 * Time: 14:03
 */

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado;

class InventarioItensModel extends AbstractModel
{
    protected $entityManager;

    /**
     * @var \Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\InventarioItensRepository $repository
     */
    protected $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Almoxarifado\InventarioItens::class);
    }

    /**
     * @param Almoxarifado\InventarioItens $inventarioItens
     * @return Almoxarifado\InventarioItens
     */
    public function getItemSaldo(Almoxarifado\InventarioItens $inventarioItens)
    {
        $result = $this->repository->getItemSaldo([
            'cod_item'          => $inventarioItens->getCodItem(),
            'cod_marca'         => $inventarioItens->getCodMarca(),
            'exercicio'         => $inventarioItens->getExercicio(),
            'cod_centro'        => $inventarioItens->getCodCentro(),
            'cod_almoxarifado'  => $inventarioItens->getCodAlmoxarifado()
        ]);

        $inventarioItens->saldo = $result['saldo'];

        return $inventarioItens;
    }

    public function checkIfExistsInventarioItens(Almoxarifado\InventarioItens $inventarioItens)
    {
        $foundedInventarioItens = $this->repository->findOneBy([
            'codInventario' => $inventarioItens->getCodInventario(),
            'codItem'       => $inventarioItens->getCodItem(),
            'codMarca'      => $inventarioItens->getCodMarca(),
            'codCentro'     => $inventarioItens->getCodCentro()
        ]);

        return $foundedInventarioItens;
    }

    /**
     * @param $cod_item
     * @param $cod_marca
     * @param $cod_almoxarifado
     * @param $cod_centro
     * @param $exercicio
     * @return array
     */
    public function montaVerificaItensInventarioNaoProcessado($cod_item, $cod_marca, $cod_almoxarifado, $cod_centro, $exercicio)
    {
        return $this->repository->montaVerificaItensInventarioNaoProcessado($cod_item, $cod_marca, $cod_almoxarifado, $cod_centro, $exercicio);
    }
}
