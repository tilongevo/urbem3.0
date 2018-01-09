<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Empenho\Empenho;
use Urbem\CoreBundle\Entity\Empenho\PreEmpenho;
use Urbem\CoreBundle\Entity\Licitacao\Participante;
use Urbem\CoreBundle\Entity\SwCgm;

class FornecedorModel extends AbstractModel
{
    protected $entityManager = null;

    /**
     * @var ORM\EntityRepository $repository
     */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Compras\Fornecedor::class);
    }

    /**
     * @param $fornecedor
     * @return bool
     */
    public function canRemove($fornecedor)
    {
        $obTComprasCotacaoFornecedorItem = $empenho = $erro = '';

        /** @var Participante $obTLicitacaoParticipante */
        $obTLicitacaoParticipante = $this->entityManager->getRepository(Participante::class);
        $rsParticipante = $obTLicitacaoParticipante->findOneByCgmFornecedor($fornecedor->getCgmFornecedor());

        $obTComprasCotacaoFornecedorItem = $fornecedor->getFkComprasCotacaoFornecedorItens();

        $obTEmpenhoPreEmpenho = $this->entityManager->getRepository(PreEmpenho::class);
        /** @var Empenho $obTEmpenhoPreEmpenho */
        $empenho = $obTEmpenhoPreEmpenho->findByCgmBeneficiario($fornecedor->getCgmFornecedor());

        if (!empty($rsParticipante) || !empty($obTComprasCotacaoFornecedorItem->first()) || !empty($empenho)) {
            $erro = 'Error';
            return empty($erro);
        }

        return empty($erro);
    }

    public function getAllCgmLinkedWithFornecedorQuery()
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('cgm')
            ->from(SwCgm::class, 'cgm')
            ->join(Compras\Fornecedor::class, 'fornecedor', 'WITH', 'cgm.numcgm = fornecedor.cgmFornecedor')
        ;

        return $queryBuilder;
    }

    public function getAllCgmLinkedWithFornecedor()
    {
        return $this->getAllCgmLinkedWithFornecedorQuery()
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $cgmFornecedor
     * @return Compras\Fornecedor|null
     */
    public function getFornecedor($cgmFornecedor)
    {
        return $this->repository->find($cgmFornecedor);
    }

    /**
     * @param Compras\Fornecedor $fornecedor
     * @return Compras\Fornecedor
     */
    public function getTipo(Compras\Fornecedor $fornecedor)
    {
        switch ($fornecedor->getTipo()) {
            case 'N':
                $fornecedor->setTipo('Normal');
                break;
            case 'M':
                $fornecedor->setTipo('Microempresa');
                break;
            case 'P':
                $fornecedor->setTipo('Pequeno Porte');
                break;
        }

        return $fornecedor;
    }

    /**
     * @param string $q
     * @return array|null
     */
    public function searchByNomCgm($q)
    {
        $queryBuilder = $this->repository->createQueryBuilder('fornecedor');
        $queryBuilder
            ->join('fornecedor.fkSwCgm', 'cgm')
            ->where(
                $queryBuilder->expr()->like(
                    $queryBuilder->expr()->lower('cgm.nomCgm'),
                    $queryBuilder->expr()->lower(':query')
                )
            )
            ->setParameter('query', '%' . $q . '%')
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @return mixed
     */
    public function getFornecedoresAtivos()
    {
        return $this->repository->getFornecedoresAtivos();
    }
}
