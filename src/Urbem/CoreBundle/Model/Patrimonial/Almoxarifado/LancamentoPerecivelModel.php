<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoPerecivel;
use Urbem\CoreBundle\Entity\Almoxarifado\Perecivel;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\CatalogoItemRepository;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\LancamentoPerecivelRepository;

/**
 * Class LancamentoPerecivelModel
 *
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class LancamentoPerecivelModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var LancamentoPerecivelRepository $repository */
    protected $repository = null;

    /**
     * LancamentoPerecivelModel constructor.
     *
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(LancamentoPerecivel::class);
    }

    /**
     * @param LancamentoMaterial $lancamentoMaterial
     * @param Perecivel          $perecivel
     * @return LancamentoPerecivel
     */
    public function findOrCreateLancamentoPerecivel(LancamentoMaterial $lancamentoMaterial, Perecivel $perecivel)
    {
        $lancamentoPerecivel = $this->repository->findOneBy([
            'fkAlmoxarifadoLancamentoMaterial' => $lancamentoMaterial,
            'fkAlmoxarifadoPerecivel' => $perecivel
        ]);

        if (true == is_null($lancamentoPerecivel)) {
            $lancamentoPerecivel = new LancamentoPerecivel();
            $lancamentoPerecivel->setFkAlmoxarifadoLancamentoMaterial($lancamentoMaterial);
            $lancamentoPerecivel->setFkAlmoxarifadoPerecivel($perecivel);

            $this->save($lancamentoPerecivel);
        }

        return $lancamentoPerecivel;
    }

    /**
     * @deprecated
     * @trigger_error('Deprecated method, change to findOrCreateLancamentoPerecivel')
     * @param Perecivel          $perecivel
     * @param array              $params
     * @param LancamentoMaterial $lancamentoMaterial
     * @return LancamentoPerecivel
     */
    public function saveLancamentoPerecivel(Perecivel $perecivel, array $params, LancamentoMaterial $lancamentoMaterial)
    {
        return $this->findOrCreateLancamentoPerecivel($lancamentoMaterial, $perecivel);
    }

    /**
     * @param Perecivel $perecivel
     * @return string
     */
    public function getSaldoLote(Perecivel $perecivel)
    {
        $queryBuilder = $this->repository->createQueryBuilder('lancamentoPerecivel');
        $queryBuilder
            ->select('SUM(lancamentoMaterial.quantidade)')
            ->join('lancamentoPerecivel.fkAlmoxarifadoLancamentoMaterial', 'lancamentoMaterial')
            ->where('lancamentoPerecivel.lote = :lote')
            ->andWhere('lancamentoMaterial.codItem = :cod_item')
            ->andWhere('lancamentoMaterial.codMarca = :cod_marca')
            ->andWhere('lancamentoMaterial.codAlmoxarifado = :cod_almoxarifado')
            ->andWhere('lancamentoMaterial.codCentro = :cod_centro')
            ->setParameters([
                'lote' => $perecivel->getLote(),
                'cod_item' => $perecivel->getCodItem(),
                'cod_marca' => $perecivel->getCodMarca(),
                'cod_almoxarifado' => $perecivel->getCodAlmoxarifado(),
                'cod_centro' => $perecivel->getCodCentro(),
            ])
        ;

        return $queryBuilder->getQuery()->getResult(ORM\AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }
}
