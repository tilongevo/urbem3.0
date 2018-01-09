<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\NivelServicoValor;

/**
 * Class NivelServicoValorModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class NivelServicoValorModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * NivelServicoValorModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(NivelServicoValor::class);
    }

    /**
     * @param $servico
     * @param $nivelServico
     */
    public function saveNivelServicoValor($servico, $nivelServico)
    {
        $nivelServicoValor = new NivelServicoValor();
        $nivelServicoValor->setValor($servico->getCodEstrutural());
        $nivelServicoValor->setFkEconomicoNivelServico($nivelServico);
        $nivelServicoValor->setFkEconomicoServico($servico);
        $this->entityManager->persist($nivelServicoValor);
        $this->entityManager->flush();
    }

    /**
     * @param $codServico
     * @param $valor
     * @return null|object
     */
    public function getNivelServicoValor($codServico, $valor)
    {
        return $this->repository->findOneBy(['codServico' => $codServico, 'valor' => $valor]);
    }

    /**
     * @param $codServico
     * @return mixed
     */
    public function getNivelServicoValorByCodServico($codServico)
    {
        return $this->repository->findOneByCodServico($codServico);
    }
}
