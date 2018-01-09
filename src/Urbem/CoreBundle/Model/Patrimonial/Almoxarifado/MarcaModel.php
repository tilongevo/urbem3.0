<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\Marca;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem;
use Urbem\CoreBundle\Entity\Frota\Modelo;
use Urbem\CoreBundle\Entity\Frota\Veiculo;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\RequisicaoItemRepository;

/**
 * Class MarcaModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class MarcaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * MarcaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Marca::class);
    }

    /**
     * @param Marca $marca
     * @return bool
     */
    public function canRemove($marca)
    {
        // Verifica Modelo
        $modeloRepository = $this->entityManager->getRepository(Modelo::class);
        $resModelo = $modeloRepository->findOneByCodMarca($marca->getCodMarca());

        // Verifica Veículo
        $veiculoRepository = $this->entityManager->getRepository(Veiculo::class);
        $resVeiculo = $veiculoRepository->findOneByCodMarca($marca->getCodMarca());

        return empty($resModelo) && empty($resVeiculo);
    }

    /**
     * @param $codMarca
     * @return null|object
     */
    public function getOneByCodMarca($codMarca)
    {
        return $this->repository->findOneBy([
            'codMarca' => $codMarca
        ]);
    }

    /**
     * @param string $q
     * @return array
     */
    public function searchByDescricao($q)
    {
        $queryBuilder = $this->repository->createQueryBuilder('marca');
        $queryBuilder
            ->where('LOWER(marca.descricao) LIKE LOWER(:descricao)')
            ->setParameter('descricao', "%{$q}%")
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param $descricao
     * @return null|object
     */
    public function getOneByDescricao($descricao)
    {
        return $this->repository->findOneBy([
            'descricao' => $descricao
        ]);
    }

    /**
     * @param CatalogoItem $catalogoItem
     * @param Almoxarifado|null $almoxarifado
     * @return ORM\QueryBuilder
     */
    public function getMarcasInLancamentoMaterialQuery(CatalogoItem $catalogoItem, Almoxarifado $almoxarifado = null)
    {
        /** @var RequisicaoItemRepository $requisicaoRepository */
        $requisicaoRepository = $this->entityManager->getRepository(RequisicaoItem::class);

        $result = [];

        if (true == is_null($almoxarifado)) {
            $results = $requisicaoRepository
                ->getMarcaCatalogo($catalogoItem->getCodItem());
        } else {
            $results = $requisicaoRepository
                ->getMarcaCatalogo($catalogoItem->getCodItem(), $almoxarifado->getCodAlmoxarifado());
        }

        $codMarcaArray = [];
        foreach ($results as $result) {
            $codMarcaArray[] = $result['cod_marca'];
        }

        $codMarcaArray = true == empty($codMarcaArray) ? 0 : $codMarcaArray ;

        $queryBuilder = $this->repository->createQueryBuilder('marca');
        $queryBuilder
            ->where(
                $queryBuilder->expr()->in('marca.codMarca', $codMarcaArray)
            )
        ;

        return $queryBuilder;
    }
}
