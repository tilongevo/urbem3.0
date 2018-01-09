<?php

namespace Urbem\CoreBundle\Model\Ldo;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository;
use Symfony\Component\Validator\Validator;

class TipoIndicadoresModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Ldo\TipoIndicadores");
    }

    public function getIdsFiltro($unidadeArray)
    {
        $sql = "
        SELECT
            t0.cod_tipo_indicador
        FROM ldo.tipo_indicadores t0
        WHERE t0.cod_unidade = :cod_unidade
        AND t0.cod_grandeza = :cod_grandeza";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindValue('cod_unidade', $unidadeArray[0]);
        $query->bindValue('cod_grandeza', $unidadeArray[1]);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function canRemove($object)
    {
        $indicadores = $this->entityManager->getRepository("CoreBundle:Ldo\Indicadores")
        ->findByCodTipoIndicador($object->getCodTipoIndicador());

        if (count($indicadores) > 0) {
            return false;
        }

        return true;
    }
}
