<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use GuzzleHttp\Psr7\Request;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Pessoal\Aposentadoria;
use Urbem\CoreBundle\Repository\Pessoal\AssentamentoMovSefipSaidaRepository;

class AssentamentoMovSefipSaidaModel extends AbstractModel
{

    protected $entityManager = null;
    /** @var AssentamentoMovSefipSaidaRepository|null  */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\\AssentamentoMovSefipSaida");
    }

    /**
     * @param bool $filtro
     *
     * @return array
     */
    public function recuperaRelacionamento($filtro = false)
    {
        return $this->repository->recuperaRelacionamento($filtro);
    }

    /**
     * @param bool $filtro
     *
     * @return array
     */
    public function recuperaAfastamentoTemporarioSefip($filtro = false)
    {
        return $this->repository->recuperaAfastamentoTemporarioSefip($filtro);
    }
}
