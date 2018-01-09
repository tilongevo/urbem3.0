<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaAnulacao;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\PedidoTransferenciaRepository;

/**
 * Class PedidoTransferenciaModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class PedidoTransferenciaModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var PedidoTransferenciaRepository|null */
    protected $repository = null;

    /**
     * PedidoTransferenciaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager
            ->getRepository(Almoxarifado\PedidoTransferencia::class);
    }

    /**
     * Gera um codigo de transferencia para uso.
     *
     * @return integer|string
     */
    public function generateCodTransferencia()
    {
        $res = $this->repository->recuperaUltimoCodigoTransferencia();

        return $res['cod_transferencia'];
    }

    /**
     * @param Almoxarifado\PedidoTransferencia $pedidoTransferencia
     */
    public function anularPedidoTransferencia(Almoxarifado\PedidoTransferencia $pedidoTransferencia)
    {
        $ptAnulacao = new Almoxarifado\PedidoTransferenciaAnulacao();
        $ptAnulacao->setFkAlmoxarifadoPedidoTransferencia($pedidoTransferencia);

        $this->save($ptAnulacao);
    }

    /**
     * @param Almoxarifado\PedidoTransferencia $pedidoTransferencia
     * @return Almoxarifado\PedidoTransferencia
     */
    public function getSaldoOrigemItem(Almoxarifado\PedidoTransferencia $pedidoTransferencia)
    {
        /** @var Collection $items */
        $pedidoTransferenciaItens = $pedidoTransferencia->getFkAlmoxarifadoPedidoTransferenciaItens();

        if (!$pedidoTransferenciaItens->isEmpty()) {
            $pedidoTransferenciaItemModel = new PedidoTransferenciaItemModel($this->entityManager);

            /** @var Almoxarifado\PedidoTransferenciaItem $pedidoTransferenciaItem */
            foreach ($pedidoTransferenciaItens as $pedidoTransferenciaItem) {
                $pedidoTransferenciaItemModel->getSaldoOrigem($pedidoTransferenciaItem);
            }
        }

        return $pedidoTransferencia;
    }

    /**
     * @param ProxyQuery $proxyQuery
     * @param string $tipo
     * @return ProxyQuery
     */
    public function getPedidosTransferiencia(ProxyQuery $proxyQuery, $tipo)
    {
        $tipo = strtolower(substr($tipo, 0, 1));

        $pedidos = [];

        switch ($tipo) {
            case "e":
                $pedidos = $this->getPedidosEntradaPorTransferencia();
                break;
            case "s":
                $pedidos = $this->getPedidosSaidaPorTransferencia();
                break;
        }

        $alias = $proxyQuery->getRootAlias();
        $proxyQuery
            ->andWhere(
                $proxyQuery->expr()->in("{$alias}.codTransferencia", ':pedidos')
            )
            ->setParameter('pedidos', $pedidos);

        return $proxyQuery;
    }

    /**
     * @return array|null
     */
    public function getPedidosSaidaPorTransferencia()
    {
        $results = $this->repository->getPedidosSaidaPorTransferencia();

        $pedidos = [];
        foreach ($results as $result) {
            $pedidos[] = $result['cod_transferencia'];
        }

        if (false == empty($pedidos)) {
            return $pedidos;
        }

        return null;
    }

    /**
     * @return array|null
     */
    public function getPedidosEntradaPorTransferencia()
    {
        $results = $this->repository->getPedidosEntradaPorTransferencia();
        $pedidos = [];
        foreach ($results as $result) {
            $pedidos[] = $result['cod_transferencia'];
        }

        if (false == empty($pedidos)) {
            return $pedidos;
        }

        return null;
    }

    /**
     * @param string|array $compositeKey
     * @return null|Almoxarifado\PedidoTransferencia
     * @throws \Exception
     */
    public function find($compositeKey)
    {
        $pedidoTransferencia = null;

        switch (gettype($compositeKey)) {
            case 'string':
                if (preg_match('/([0-9]{4}\~[0-9]+)/', $compositeKey)) {

                    /** @var Almoxarifado\PedidoTransferencia $pedidoTransferencia */
                    $pedidoTransferencia = $this->repository->find([
                        'exercicio' => explode('~', $compositeKey)[0],
                        'codTransferencia' => explode('~', $compositeKey)[1]
                    ]);
                } else {
                    throw new \Exception('Invalid composite key.');
                }
                break;
            case 'array':
                /** @var Almoxarifado\PedidoTransferencia $pedidoTransferencia */
                $pedidoTransferencia = $this->repository->find($compositeKey);
                break;
        }

        return $pedidoTransferencia;
    }
}
