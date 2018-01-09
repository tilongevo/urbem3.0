<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Frota;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Frota;
use Urbem\CoreBundle\Repository;
use Symfony\Component\Validator\Validator;

class ItemModel extends AbstractModel
{
    protected $entityManager = null;

    /**
     * @var Repository\Patrimonio\Frota\ItemRepository $repository
     */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Frota\Item::class);
    }

    public function canRemove($object)
    {
        $autorizacaoRepository = $this->entityManager->getRepository("CoreBundle:Frota\\Autorizacao");
        $resAu = $autorizacaoRepository->findOneByCodItem($object->getCodItem());

        $ManutencaoItemRepository = $this->entityManager->getRepository("CoreBundle:Frota\\ManutencaoItem");
        $resMi = $ManutencaoItemRepository->findOneByCodItem($object->getCodItem());

        return is_null($resAu) && is_null($resMi);
    }

    public function getCombustivelItem($id)
    {
        return $this->repository->getCombustivelItem($id);
    }

    public function removeCombustivelItem($id)
    {
        return $this->repository->removeCombustivelItem($id);
    }

    public function getClassificacaoCatalogo($info)
    {
        return $this->repository->getClassificacaoCatalogo($info);
    }

    public function processaItens($info)
    {
        return $this->repository->processaItens($info);
    }

    public function getByCatalogoItem(Almoxarifado\CatalogoItem $catalogoItem)
    {
        return $this->repository->findOneByCodItem($catalogoItem);
    }

    /**
     * Retorna a Itens Disponiveis
     *
     * @param  arr params['codItem', 'codManutencao', 'exercicio']
     * @return obj Item
     */
    public function getItensDisponiveis($params)
    {
        $subqb = $this->entityManager->getRepository('CoreBundle:Frota\ManutencaoItem')
            ->createQueryBuilder('mi')
            ->select('mi.codItem')
            ->where('mi.codManutencao = '.$params['codManutencao'])
            ->andWhere("mi.exercicio = '".$params['exercicio']."'");

        if (!empty($params['codItem'])) {
            $subqb
                ->andWhere("mi.codItem <> '".$params['codItem']."'");
        }

        $qb = $this->repository
            ->createQueryBuilder('i');
        $qb->where($qb->expr()->notIn('i.codItem', $subqb->getDQL()));

        return $qb;
    }

    /**
     * @param $q
     * @return ORM\QueryBuilder
     */
    public function carregaFrotaItemQuery($q)
    {
        $queryBuilder = $this->repository->createQueryBuilder('item');
        $queryBuilder->join(Almoxarifado\CatalogoItem::class, 'catalogoItem', 'WITH', 'catalogoItem.codItem = item.codItem');

        if (is_numeric($q)) {
            $queryBuilder->where(sprintf("item.codItem = %s", $q));
        } else {
            $queryBuilder
                ->where('LOWER(catalogoItem.descricao) LIKE :descricao')
                ->orWhere('LOWER(catalogoItem.descricaoResumida) LIKE :descricao')
                ->setParameter('descricao', "%{$q}%");
        }

        return $queryBuilder;
    }
}
