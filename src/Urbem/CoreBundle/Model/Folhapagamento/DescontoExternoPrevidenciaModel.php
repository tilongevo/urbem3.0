<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidencia;
use Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidenciaAnulado;

class DescontoExternoPrevidenciaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\DescontoExternoPrevidencia");
    }

    public function saveDescExtPrevValor($vlrDesconto)
    {
        $this->save($vlrDesconto);
    }

    public function getValorDesconto($codContrato)
    {
        $repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\DescontoExternoPrevidenciaValor");
        $query = $repository->createQueryBuilder('p')
            ->select('p')
            ->where('p.codContrato = :cod_contrato')
            ->setParameter('cod_contrato', $codContrato);
        return $query->getQuery()->getSingleResult()->getValorPrevidencia();
    }

    public function getMatriculaCgm($codContrato)
    {
        return $this->repository->getMatriculaCgm($codContrato);
    }

    /**
     * @param ProxyQuery $proxyQuery
     * @return ProxyQuery
     */
    public function getDescontoExternoNotInAnulado(ProxyQuery $proxyQuery)
    {
        $queryDescontoExternoAnulado = $this->entityManager->createQueryBuilder();

        $queryDescontoExternoAnulado
            ->select("(CONCAT(depa.codContrato,'~',depa.timestamp))")
            ->from(DescontoExternoPrevidenciaAnulado::class, 'depa');

        $proxyQuery->andWhere($proxyQuery->expr()->notIn("CONCAT({$proxyQuery->getRootAliases()[0]}.codContrato,'~',{$proxyQuery->getRootAliases()[0]}.timestamp)", $queryDescontoExternoAnulado->getDQL()));

        return $proxyQuery;
    }

    /**
     * @param $params
     * @param $stFiltro
     *
     * @return mixed
     */
    public function recuperaRelacionamento($params, $stFiltro)
    {
        return $this->repository->recuperaRelacionamento($params, $stFiltro);
    }
}
