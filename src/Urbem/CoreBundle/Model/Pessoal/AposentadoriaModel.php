<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use GuzzleHttp\Psr7\Request;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Pessoal\Aposentadoria;
use Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal\AposentadoriaRepository;

class AposentadoriaModel extends AbstractModel
{

    protected $entityManager = null;
    /** @var AposentadoriaRepository|null  */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\\Aposentadoria");
    }

    public function getEnquadramentosCodClassificacao($codClassificacao)
    {
        return $this->repository->getEnquadramentosCodClassificacao($codClassificacao);
    }

    /**
     * @param ProxyQuery $proxyQuery
     * @return ProxyQuery
     */
    public function getListAposentadoria(ProxyQuery $proxyQuery)
    {
        $queryAposentadoria = $this->entityManager->createQueryBuilder();

        return $proxyQuery;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getAposentadoriaValida($request)
    {
        return $this->repository->getAposentadoriaValida($request);
    }

    /**
     * @return array
     */
    public function getMaxAposentadorias()
    {
        return $this->repository->getMaxAposentadorias();
    }
}
