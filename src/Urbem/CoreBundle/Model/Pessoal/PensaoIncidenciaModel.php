<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Pessoal\Incidencia;
use Urbem\CoreBundle\Entity\Pessoal\Pensao;
use Urbem\CoreBundle\Entity\Pessoal\PensaoIncidencia;

class PensaoIncidenciaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\Pensao");
    }

    public function savePensaoIncidencia(Pensao $pensao, Incidencia $incidencia)
    {
        $pensaoIncidencia = new PensaoIncidencia();
        $pensaoIncidencia
            ->setFkPessoalIncidencia($incidencia)
            ->setFkPessoalPensao($pensao);

        $this->save($pensaoIncidencia);

        return $pensaoIncidencia;
    }
}
