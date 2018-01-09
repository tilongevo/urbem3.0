<?php

namespace Urbem\CoreBundle\Model\Arrecadacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Arrecadacao\Carne;

/**
 * Class CarneModel
 * @package Urbem\CoreBundle\Model\Arrecadacao
 */
class CarneModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * CarneModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Carne::class);
    }

    /**
     * @param array $params
     * @return int
     */
    public function calculaValores($params)
    {
        return $this->repository->calculaValores($params);
    }

    /**
     * @param $numeracao
     * @return mixed
     */
    public function getCodLote($numeracao)
    {
        return $this->repository->getCodLote($numeracao);
    }

    /**
     * @return mixed
     */
    public function getCnpj()
    {
        return $this->repository->getCnpj();
    }

    /*
     * @param int $codCredito
     * @param int $codEspecie
     * @param int $codGenero
     * @param int $codNatureza
     * @return bool|string
     */
    public function getCodConvenio($codCredito, $codEspecie, $codGenero, $codNatureza)
    {
        return $this->repository->getCodConvenio($codCredito, $codEspecie, $codGenero, $codNatureza);
    }

    /**
     * @param int $codConvenio
     * @return bool|string
     */
    public function getCodCarteira($codConvenio)
    {
        return $this->repository->getCodCarteira($codConvenio);
    }

    /**
     * @param int $codConvenio
     * @param int $codCarteira
     * @return bool|string
     */
    public function getNumeracao($codConvenio, $codCarteira)
    {
        return $this->repository->getNumeracao($codConvenio, $codCarteira);
    }
}
