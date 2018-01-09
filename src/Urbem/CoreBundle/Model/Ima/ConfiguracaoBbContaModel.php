<?php

namespace Urbem\CoreBundle\Model\Ima;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository;
use Symfony\Component\Validator\Validator;

class ConfiguracaoBbContaModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var Repository\RecursosHumanos\Ima\ConfiguracaoBbContaRepository|null  */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Ima\\ConfiguracaoBbConta");
    }

    /**
     * @param $stFiltro
     * @param $stOrdem
     *
     * @return mixed
     */
    public function recuperaVigencias($stFiltro, $stOrdem)
    {
        return $this->repository->recuperaVigencias($stFiltro, $stOrdem);
    }

    /**
     * @param $params
     *
     * @return mixed
     */
    public function recuperaRelacionamento($params)
    {
        return $this->repository->recuperaRelacionamento($params);
    }
}
