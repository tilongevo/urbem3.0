<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Patrimonio;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetoraConsistencia;
use Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetoraDados;
use Urbem\CoreBundle\Repository\Patrimonio\Patrimonio\InventarioRepository;

/**
 * Class ArquivoColetoraConsistenciaModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Patrimonio
 */
class ArquivoColetoraConsistenciaModel extends AbstractModel
{
    /** @var ORM\EntityManager|null $entityManager */
    protected $entityManager = null;
    /** @var InventarioRepository $repository */
    protected $repository = null;

    /**
     * InventarioModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Patrimonio\\ArquivoColetoraConsistencia");
    }

    /**
     * @param object $object
     */
    public function canRemove($object)
    {
        // TODO: Implement canRemove() method.
    }

    /**
     * @param $status
     * @param $orientacao
     * @param ArquivoColetoraDados $arquivoColetoraDados
     * @return ArquivoColetoraConsistencia
     */
    public function saveOneOrBasedArquivoColetora($status, $orientacao, ArquivoColetoraDados $arquivoColetoraDados)
    {
        /** @var ArquivoColetoraConsistencia $arquivoColetoraConsistencia */
        $arquivoColetoraConsistencia = new ArquivoColetoraConsistencia();
        $arquivoColetoraConsistencia->setStatus($status);
        $arquivoColetoraConsistencia->setOrientacao($orientacao);
        $arquivoColetoraConsistencia->setFkPatrimonioArquivoColetoraDados($arquivoColetoraDados);

        $this->save($arquivoColetoraConsistencia);

        return $arquivoColetoraConsistencia;
    }
}
