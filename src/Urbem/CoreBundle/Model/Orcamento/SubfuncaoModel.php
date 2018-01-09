<?php

namespace Urbem\CoreBundle\Model\Orcamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Orcamento\Subfuncao;

class SubfuncaoModel extends AbstractModel
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
     * SubfuncaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Orcamento\\Subfuncao");
    }

    public function canRemove($object)
    {
        $em = $this->entityManager;

        $acaoDados = $em->getRepository('CoreBundle:Ppa\AcaoDados')->findByCodSubfuncao($object->getCodSubfuncao());
        if (count($acaoDados)) {
            return false;
        }

        $despesas = $em->getRepository('CoreBundle:Orcamento\Despesa')->findByCodSubfuncao($object->getCodSubfuncao());
        if (count($despesas)) {
            return false;
        }

        return true;
    }

    /**
     * Salva Subfuncao por período do PPA
     * @param Subfuncao $object
     * @return \Exception|null
     */
    public function salvarSubfuncaoPorPeriodo(Subfuncao $object)
    {
        $exception = null;
        try {
            $em = $this->entityManager;
            $periodo = (new OrgaoModel($em))->getPpaByExercicio($object->getExercicio());

            for ($ano = (int) $object->getExercicio() + 1; $ano <= (int) $periodo->getAnoFinal(); $ano++) {
                $subfuncao = new Subfuncao();
                $subfuncao->setExercicio($ano);
                $subfuncao->setCodSubfuncao($object->getCodSubfuncao());
                $subfuncao->setDescricao($object->getDescricao());
                $em->persist($subfuncao);
            }
            $em->flush();
        } catch (\Exception $e) {
            $exception = $e;
        }
        return $exception;
    }

    /**
     * Editar Subfuncao por período do PPA
     * @param Subfuncao $object
     * @return \Exception|null
     */
    public function editarSubfuncaoPorPeriodo(Subfuncao $object)
    {
        $exception = null;
        try {
            $em = $this->entityManager;
            $periodo = (new OrgaoModel($em))->getPpaByExercicio($object->getExercicio());

            $query = $em->createQuery('update Urbem\CoreBundle\Entity\Orcamento\Subfuncao f set f.descricao = ?1 where f.codSubfuncao = ?2 and f.exercicio != ?3 and f.exercicio between ?4 and ?5');
            $query->setParameter(1, $object->getDescricao());
            $query->setParameter(2, $object->getCodSubfuncao());
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
     * Remover Subfuncao por período do PPA
     * @param Subfuncao $object
     * @return \Exception|null
     */
    public function removerSubfuncaoPorPeriodo(Subfuncao $object)
    {
        $exception = null;
        try {
            $em = $this->entityManager;
            $periodo = (new OrgaoModel($em))->getPpaByExercicio($object->getExercicio());

            $query = $em->createQuery('delete from Urbem\CoreBundle\Entity\Orcamento\Subfuncao f where f.codSubfuncao = ?1 and f.exercicio != ?2 and f.exercicio between ?3 and ?4');
            $query->setParameter(1, $object->getCodSubfuncao());
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
