<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Frota;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository;
use Symfony\Component\Validator\Validator;

/**
 * Class VeiculoDocumentoModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Frota
 */
class VeiculoDocumentoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * VeiculoDocumentoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        /** @var ORM\EntityManager entityManager */
        $this->entityManager = $entityManager;
        /** @var Repository\Patrimonio\Frota\VeiculoDocumentoRepository repository */
        $this->repository = $this->entityManager->getRepository("CoreBundle:Frota\VeiculoDocumento");
    }

    /**
     * @param Entity\Frota\VeiculoDocumento $object
     * @return bool
     */
    public function canRemove($object)
    {
        return true;
    }

    /**
     * @param array $params['codVeiculo', 'codDocumento', 'exercicio']
     * @return Entity\Frota\VeiculoDocumento
     */
    public function getVeiculoDocumento($params)
    {
        return $this->repository
            ->findOneBy([
                    'codVeiculo' => $params['codVeiculo'],
                    'codDocumento' => $params['codDocumento'],
                    'exercicio' => $params['exercicio']
            ]);
    }

    /**
     * @param $params
     * @return ORM\QueryBuilder
     */
    public function getDocumentosLivres($params)
    {
        return $this->repository
            ->getDocumentosLivres($params);
    }
}
