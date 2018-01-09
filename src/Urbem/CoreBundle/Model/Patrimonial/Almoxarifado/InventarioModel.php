<?php
/**
 * Created by PhpStorm.
 * User: gabrielvie
 * Date: 28/09/16
 * Time: 11:04
 */

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Administracao;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\AlmoxarifadoRepository;

class InventarioModel extends AbstractModel
{
    protected $entityManager = null;

    /**
     * @var \Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\InventarioRepository $repository
     */
    protected $repository = null;

    /**
     * InventarioModel constructor.
     *
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Almoxarifado\Inventario::class);
    }

    /**
     * Pega um cod_inventario disponivel
     *
     * @param Almoxarifado\Inventario $inventario
     * @return Almoxarifado\Inventario
     */
    public function applyCodInventario(Almoxarifado\Inventario $inventario)
    {
        $codInventario = $this->repository->getAvailableCodInventario();

        $inventario->setCodInventario($codInventario);

        return $inventario;
    }

    public function getAlmoxarifadosAlreadyInUse(AlmoxarifadoRepository $almoxarifadoRepository)
    {
        $queryBuilderAlmoxarifado = $almoxarifadoRepository->createQueryBuilder('almoxarifado');
        $queryBuilderAlmoxarifado
            ->join(Almoxarifado\Inventario::class, 'inventario', 'WITH', 'almoxarifado.codAlmoxarifado = inventario.codAlmoxarifado')
        ;

        return $queryBuilderAlmoxarifado;
    }

    /**
     * @param Almoxarifado\Inventario $inventario
     * @param Administracao\Usuario $usuario
     * @param string $tipoNatureza
     * @return bool
     */
    public function processarInventario(Almoxarifado\Inventario $inventario, Administracao\Usuario $usuario, $tipoNatureza)
    {
        $em = $this->entityManager;

        $inventario->setProcessado(true);

        $naturezaLancamentoModel = new NaturezaLancamentoModel($em);

        $naturezaLancamento = $naturezaLancamentoModel->buildOne($usuario->getFkSwCgm(), $inventario->getExercicio(), $tipoNatureza, 5);

        $lancamentoMaterialModel = new LancamentoMaterialModel($em);

        $lancamentoInventarioItensModel = new LancamentoInventarioItensModel($em);

        $inventarioItensCollection = $inventario->getFkAlmoxarifadoInventarioItens();
        $lancamentoMaterialCollection = new ArrayCollection();
        $lancamentoInventarioItensCollection = new ArrayCollection();

        /**
         * @var Almoxarifado\InventarioItens $inventarioItens
         */
        foreach ($inventarioItensCollection as $inventarioItens) {
            $lancamentoMaterial = $lancamentoMaterialModel->buildOneBasedInventarioItem($inventarioItens, $naturezaLancamento);
            $lancamentoInventarioItens = $lancamentoInventarioItensModel->findOrCreateInventarioItens($inventarioItens, $lancamentoMaterial);

            $lancamentoMaterialCollection->add($lancamentoMaterial);
            $lancamentoInventarioItensCollection->add($lancamentoInventarioItens);
        }

        try {
            $em->beginTransaction();

            $em->persist($inventario);
            $em->persist($naturezaLancamento);

            $lancamentoMaterialCollection->map(function (Almoxarifado\LancamentoMaterial $lancamentoMaterial) use ($em) {
                $em->persist($lancamentoMaterial);
            });

            $lancamentoInventarioItensCollection->map(function (Almoxarifado\LancamentoInventarioItens $lancamentoInventarioItens) use ($em) {
                $em->persist($lancamentoInventarioItens);
            });

            $em->commit();
            $em->flush();
        } catch (DBALException $exception) {
            return false;
        }

        return true;
    }
}
