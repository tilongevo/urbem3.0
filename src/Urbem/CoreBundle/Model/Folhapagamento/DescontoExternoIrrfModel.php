<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrfAnulado;

class DescontoExternoIrrfModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\DescontoExternoIrrf");
    }

    /**
     * @param ProxyQuery $proxyQuery
     * @return ProxyQuery
     */
    public function getDescontoExternoNotInAnulado(ProxyQuery $proxyQuery)
    {
        $queryDescontoIrrfAnulado = $this->entityManager->createQueryBuilder();

        $queryDescontoIrrfAnulado
            ->select("(CONCAT(deia.codContrato,'~',deia.timestamp))")
            ->from(DescontoExternoIrrfAnulado::class, 'deia');

        $proxyQuery->andWhere($proxyQuery->expr()->notIn("CONCAT({$proxyQuery->getRootAliases()[0]}.codContrato,'~',{$proxyQuery->getRootAliases()[0]}.timestamp)", $queryDescontoIrrfAnulado->getDQL()));

        return $proxyQuery;
    }
}
