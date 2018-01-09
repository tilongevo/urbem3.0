<?php

namespace Urbem\CoreBundle\Model\Calendario;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;

class FeriadoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * FeriadoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Calendario\\Feriado");
    }

    /**
     * @param $object
     * @return bool
     */
    public function canRemove($object)
    {

        $codFeriado = $object->getCodFeriado();


        $sql = "
            SELECT calendario_feriado_variavel.cod_feriado
            FROM   calendario.calendario_feriado_variavel
            WHERE calendario_feriado_variavel.cod_feriado = $codFeriado;
        ";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->execute();
        $checkData = $query->fetch();

        return empty($checkData);
    }

    /**
     * @param $codCalendar
     * @param $date
     * @param $mode
     * @return mixed
     */
    public function getFeriadoPorAno($codCalendar, $date, $mode)
    {
        return $this->repository->getFeriadoPorAno($codCalendar, $date, $mode);
    }
}
