<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\AliquotaServico;

/**
 * Class AliquotaServicoModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class AliquotaServicoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * AliquotaServicoModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(AliquotaServico::class);
    }

    /**
     * @param $codServico
     * @return mixed
     */
    public function getAliquota($codServico)
    {
        return $this->repository->findOneByCodServico($codServico);
    }

    /**
     * @param $entity
     * @param $valor
     */
    public function verifica($entity, $valor, $dtVigencia, $codServico)
    {
        if ($entity) {
            $entity->setValor($valor);
            $entity->setDtVigencia($dtVigencia);
            $this->save($entity);
        } elseif (!$entity) {
            $aliquota = new AliquotaServico();
            $aliquota->setCodServico($codServico);
            $aliquota->setValor($valor);
            $aliquota->setDtVigencia($dtVigencia);
            $this->save($aliquota);
        }
    }
}
