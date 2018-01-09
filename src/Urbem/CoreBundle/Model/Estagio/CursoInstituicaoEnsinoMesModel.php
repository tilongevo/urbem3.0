<?php

namespace Urbem\CoreBundle\Model\Estagio;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Mes;
use Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsino;
use Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsinoMes;
use Urbem\CoreBundle\Model;

class CursoInstituicaoEnsinoMesModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Estagio\\CursoInstituicaoEnsinoMes");
    }

    public function canRemove($object)
    {
    }

    public function save($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    /**
     * @param CursoInstituicaoEnsino $cursoInstituicaoEnsino
     * @param Mes                    $mes
     *
     * @return CursoInstituicaoEnsinoMes
     */
    public function buildOneBasedCursoInstituicaoEnsino(CursoInstituicaoEnsino $cursoInstituicaoEnsino, Mes $mes)
    {
        /** @var CursoInstituicaoEnsinoMes $cursoInstituicaoEnsinoMes */
        $cursoInstituicaoEnsinoMes = new CursoInstituicaoEnsinoMes();
        $cursoInstituicaoEnsinoMes->setFkAdministracaoMes($mes);
        $cursoInstituicaoEnsinoMes->setFkEstagioCursoInstituicaoEnsino($cursoInstituicaoEnsino);
        $this->save($cursoInstituicaoEnsinoMes);

        return $cursoInstituicaoEnsinoMes;
    }

    /**
     * @param CursoInstituicaoEnsinoMes $cursoInstituicaoEnsinoMes
     */
    public function removeCursoInstituicaoEnsinoMes(CursoInstituicaoEnsinoMes $cursoInstituicaoEnsinoMes)
    {
        $this->remove($cursoInstituicaoEnsinoMes);
    }
}
