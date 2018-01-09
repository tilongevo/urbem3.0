<?php

namespace Urbem\CoreBundle\Model\Orcamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Orcamento\DetalhamentoDestinacaoRecurso;

class DetalhamentoDestinacaoRecursoModel extends AbstractModel
{
    /**
     * @var ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var ORM\EntityRepository
     */
    protected $repository;

    /**
     * DetalhamentoDestinacaoRecursoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Orcamento\\DetalhamentoDestinacaoRecurso");
    }

    /**
     * Salva DetalhamentoDestinacaoRecurso por período do PPA
     * @param DetalhamentoDestinacaoRecurso $object
     * @return \Exception|null
     */
    public function salvarPorPeriodo(DetalhamentoDestinacaoRecurso $object)
    {
        $exception = null;
        try {
            $em = $this->entityManager;
            $periodo = (new OrgaoModel($em))->getPpaByExercicio($object->getExercicio());

            for ($ano = (int) $object->getExercicio() + 1; $ano <= (int) $periodo->getAnoFinal(); $ano++) {
                $dtlDestRecurso = new DetalhamentoDestinacaoRecurso();
                $dtlDestRecurso->setExercicio($ano);
                $dtlDestRecurso->setCodDetalhamento($object->getCodDetalhamento());
                $dtlDestRecurso->setDescricao($object->getDescricao());
                $em->persist($dtlDestRecurso);
            }
            $em->flush();
        } catch (\Exception $e) {
            $exception = $e;
        }
        return $exception;
    }

    /**
     * Editar DetalhamentoDestinacaoRecurso por período do PPA
     * @param DetalhamentoDestinacaoRecurso $object
     * @return \Exception|null
     */
    public function editarPorPeriodo(DetalhamentoDestinacaoRecurso $object)
    {
        $exception = null;
        try {
            $em = $this->entityManager;
            $periodo = (new OrgaoModel($em))->getPpaByExercicio($object->getExercicio());

            $query = $em->createQuery('update Urbem\CoreBundle\Entity\Orcamento\DetalhamentoDestinacaoRecurso ddr set ddr.descricao = ?1 where ddr.codDetalhamento = ?2 and ddr.exercicio != ?3 and ddr.exercicio between ?4 and ?5');
            $query->setParameter(1, $object->getDescricao());
            $query->setParameter(2, $object->getCodDetalhamento());
            $query->setParameter(3, $object->getExercicio());
            $query->setParameter(4, $periodo->getAnoInicio());
            $query->setParameter(5, $periodo->getAnoFinal());
            $query->execute();
        } catch (\Exception $e) {
            $exception = $e;
        }
        return $exception;
    }

    /**
     * Remover DetalhamentoDestinacaoRecurso por período do PPA
     * @param DetalhamentoDestinacaoRecurso $object
     * @return \Exception|null
     */
    public function removerPorPeriodo(DetalhamentoDestinacaoRecurso $object)
    {
        $exception = null;
        try {
            $em = $this->entityManager;
            $periodo = (new OrgaoModel($em))->getPpaByExercicio($object->getExercicio());

            $query = $em->createQuery('delete from Urbem\CoreBundle\Entity\Orcamento\DetalhamentoDestinacaoRecurso ddr where ddr.codDetalhamento = ?1 and ddr.exercicio != ?2 and ddr.exercicio between ?3 and ?4');
            $query->setParameter(1, $object->getCodDetalhamento());
            $query->setParameter(2, $object->getExercicio());
            $query->setParameter(3, $periodo->getAnoInicio());
            $query->setParameter(4, $periodo->getAnoFinal());
            $query->execute();
        } catch (\Exception $e) {
            $exception = $e;
        }
        return $exception;
    }
}
