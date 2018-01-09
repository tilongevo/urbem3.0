<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\ORM\EntityManager;

use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\SwCepLogradouro;
use Urbem\CoreBundle\Entity\SwLogradouro;
use Urbem\CoreBundle\Repository\SwLogradouroRepository;

/**
 * Class SwLogradouroModel
 *
 * @package Urbem\CoreBundle\Model
 */
class SwLogradouroModel extends AbstractModel implements InterfaceModel
{
    /**
     * @var SwLogradouroRepository
     */
    protected $repository;

    /**
     * SwLogradouroModel constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(SwLogradouro::class);
    }

    /**
     * @param SwLogradouro $swLogradouro
     *
     * @return bool
     */
    public function canRemove($swLogradouro)
    {
        if (!$swLogradouro->getFkEconomicoDomicilioInformados()->isEmpty()) {
            return false;
        }

        /** @var SwCepLogradouro $swCepLogradouro */
        foreach ($swLogradouro->getFkSwCepLogradouros() as $swCepLogradouro) {
            if (!$swCepLogradouro->getFkSwCgmLogradouros()->isEmpty()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return int
     */
    public function getNextCodLogradouro()
    {
        return $this->repository->nextVal('cod_logradouro');
    }

    /**
     * @param $params
     * @return array
     */
    public function filtraLogradouro($params)
    {
        return $this->repository->filtraLogradouro($params);
    }
}
