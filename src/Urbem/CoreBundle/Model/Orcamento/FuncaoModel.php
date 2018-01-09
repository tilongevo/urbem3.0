<?php

namespace Urbem\CoreBundle\Model\Orcamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Orcamento\Funcao;

class FuncaoModel extends AbstractModel
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
     * FuncaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Orcamento\\Funcao");
    }

    /**
     * @param Funcao $object
     * @return bool
     */
    public function canRemove(Funcao $object)
    {
        $em = $this->entityManager;

        $ppa = (new OrgaoModel($em))->getPpaByExercicio($object->getExercicio());

        $qb = $em->getRepository('CoreBundle:Ppa\AcaoDados')->createQueryBuilder('o');
        $qb->select('count(o)');
        $qb->where('o.codFuncao = :codFuncao');
        $qb->andWhere('o.exercicio >= :anoInicio');
        $qb->andWhere('o.exercicio <= :anoFinal');
        $qb->setParameters(
            array(
                'codFuncao' => $object->getCodFuncao(),
                'anoInicio' => $ppa->getAnoInicio(),
                'anoFinal' => $ppa->getAnoFinal()
            )
        );
        $acaoDados = $qb->getQuery()->getSingleScalarResult();
        if ($acaoDados) {
            return false;
        }

        $qb = $em->getRepository('CoreBundle:Orcamento\Despesa')->createQueryBuilder('o');
        $qb->select('count(o)');
        $qb->where('o.codFuncao = :codFuncao');
        $qb->andWhere('o.exercicio >= :anoInicio');
        $qb->andWhere('o.exercicio <= :anoFinal');
        $qb->setParameters(
            array(
                'codFuncao' => $object->getCodFuncao(),
                'anoInicio' => $ppa->getAnoInicio(),
                'anoFinal' => $ppa->getAnoFinal()
            )
        );
        $despesas = $qb->getQuery()->getSingleScalarResult();
        if ($despesas) {
            return false;
        }

        return true;
    }

    /**
     * Salva Funcao por período do PPA
     * @param Funcao $object
     * @return \Exception|null
     */
    public function salvarFuncaoPorPeriodo(Funcao $object)
    {
        $exception = null;
        try {
            $em = $this->entityManager;
            $periodo = (new OrgaoModel($em))->getPpaByExercicio($object->getExercicio());

            for ($ano = (int) $object->getExercicio() + 1; $ano <= (int) $periodo->getAnoFinal(); $ano++) {
                $funcao = new Funcao();
                $funcao->setExercicio($ano);
                $funcao->setCodFuncao($object->getCodFuncao());
                $funcao->setDescricao($object->getDescricao());
                $em->persist($funcao);
            }
            $em->flush();
        } catch (\Exception $e) {
            $exception = $e;
        }
        return $exception;
    }

    /**
     * Editar Funcao por período do PPA
     * @param Funcao $object
     * @return \Exception|null
     */
    public function editarFuncaoPorPeriodo(Funcao $object)
    {
        $exception = null;
        try {
            $em = $this->entityManager;
            $periodo = (new OrgaoModel($em))->getPpaByExercicio($object->getExercicio());

            $query = $em->createQuery('update Urbem\CoreBundle\Entity\Orcamento\Funcao f set f.descricao = ?1 where f.codFuncao = ?2 and f.exercicio != ?3 and f.exercicio between ?4 and ?5');
            $query->setParameter(1, $object->getDescricao());
            $query->setParameter(2, $object->getCodFuncao());
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
     * Remover Funcao por período do PPA
     * @param Funcao $object
     * @return \Exception|null
     */
    public function removerFuncaoPorPeriodo(Funcao $object)
    {
        $exception = null;
        try {
            $em = $this->entityManager;
            $periodo = (new OrgaoModel($em))->getPpaByExercicio($object->getExercicio());

            $query = $em->createQuery('delete from Urbem\CoreBundle\Entity\Orcamento\Funcao f where f.codFuncao = ?1 and f.exercicio != ?2 and f.exercicio between ?3 and ?4');
            $query->setParameter(1, $object->getCodFuncao());
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
