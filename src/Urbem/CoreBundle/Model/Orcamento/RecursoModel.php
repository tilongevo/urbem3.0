<?php

namespace Urbem\CoreBundle\Model\Orcamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;

class RecursoModel extends AbstractModel
{
    /**
     * @var ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var ORM\EntityRepository
     */
    protected $repository;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Orcamento\Recurso");
    }

    /**
     * @param $object
     * @return bool
     */
    public function canRemove($object)
    {
        $em = $this->entityManager;
        $periodo = (new OrgaoModel($em))->getPpaByExercicio($object->getExercicio());

        $acaoRecurso = $em
            ->getRepository('CoreBundle:Ppa\AcaoRecurso')
            ->createQueryBuilder('o')
            ->select('COUNT(o)')
            ->where('o.codRecurso = :codRecurso')
            ->andWhere('o.exercicioRecurso >= :anoInicio')
            ->andWhere('o.exercicioRecurso <= :anoFinal')
            ->setParameters(
                array(
                    'codRecurso' => $object->getCodRecurso(),
                    'anoInicio' => $periodo->getAnoInicio(),
                    'anoFinal' => $periodo->getAnoFinal()
                )
            )
            ->getQuery()
            ->getSingleScalarResult();

        $recursoDestinacao = $em
            ->getRepository('CoreBundle:Orcamento\RecursoDestinacao')
            ->createQueryBuilder('o')
            ->select('COUNT(o)')
            ->where('o.codRecurso = :codRecurso')
            ->andWhere('o.exercicio >= :anoInicio')
            ->andWhere('o.exercicio <= :anoFinal')
            ->setParameters(
                array(
                    'codRecurso' => $object->getCodRecurso(),
                    'anoInicio' => $periodo->getAnoInicio(),
                    'anoFinal' => $periodo->getAnoFinal()
                )
            )
            ->getQuery()
            ->getSingleScalarResult();

        $reciboExtraRecurso = $em
            ->getRepository('CoreBundle:Tesouraria\ReciboExtraRecurso')
            ->createQueryBuilder('o')
            ->select('COUNT(o)')
            ->where('o.codRecurso = :codRecurso')
            ->andWhere('o.exercicio >= :anoInicio')
            ->andWhere('o.exercicio <= :anoFinal')
            ->setParameters(
                array(
                    'codRecurso' => $object->getCodRecurso(),
                    'anoInicio' => $periodo->getAnoInicio(),
                    'anoFinal' => $periodo->getAnoFinal()
                )
            )
            ->getQuery()
            ->getSingleScalarResult();

        $transferenciaRecurso = $em
            ->getRepository('CoreBundle:Tesouraria\TransferenciaRecurso')
            ->createQueryBuilder('o')
            ->select('COUNT(o)')
            ->where('o.codRecurso = :codRecurso')
            ->andWhere('o.exercicio >= :anoInicio')
            ->andWhere('o.exercicio <= :anoFinal')
            ->setParameters(
                array(
                    'codRecurso' => $object->getCodRecurso(),
                    'anoInicio' => $periodo->getAnoInicio(),
                    'anoFinal' => $periodo->getAnoFinal()
                )
            )
            ->getQuery()
            ->getSingleScalarResult();

        $valorLancamentoRecurso = $em
            ->getRepository('CoreBundle:Contabilidade\ValorLancamentoRecurso')
            ->createQueryBuilder('o')
            ->innerJoin('o.fkOrcamentoRecurso', 'r')
            ->select('COUNT(o)')
            ->where('o.codRecurso = :codRecurso')
            ->andWhere('r.exercicio >= :anoInicio')
            ->andWhere('r.exercicio <= :anoFinal')
            ->setParameters(
                array(
                    'codRecurso' => $object->getCodRecurso(),
                    'anoInicio' => $periodo->getAnoInicio(),
                    'anoFinal' => $periodo->getAnoFinal()
                )
            )
            ->getQuery()
            ->getSingleScalarResult();

        $planoRecurso = $em
            ->getRepository('CoreBundle:Contabilidade\PlanoRecurso')
            ->createQueryBuilder('o')
            ->select('COUNT(o)')
            ->where('o.codRecurso = :codRecurso')
            ->andWhere('o.exercicio >= :anoInicio')
            ->andWhere('o.exercicio <= :anoFinal')
            ->setParameters(
                array(
                    'codRecurso' => $object->getCodRecurso(),
                    'anoInicio' => $periodo->getAnoInicio(),
                    'anoFinal' => $periodo->getAnoFinal()
                )
            )
            ->getQuery()
            ->getSingleScalarResult();

        $receita = $em
            ->getRepository('CoreBundle:Orcamento\Receita')
            ->createQueryBuilder('o')
            ->select('COUNT(o)')
            ->where('o.codRecurso = :codRecurso')
            ->andWhere('o.exercicio >= :anoInicio')
            ->andWhere('o.exercicio <= :anoFinal')
            ->setParameters(
                array(
                    'codRecurso' => $object->getCodRecurso(),
                    'anoInicio' => $periodo->getAnoInicio(),
                    'anoFinal' => $periodo->getAnoFinal()
                )
            )
            ->getQuery()
            ->getSingleScalarResult();

        $despesa = $em
            ->getRepository('CoreBundle:Orcamento\Despesa')
            ->createQueryBuilder('o')
            ->select('COUNT(o)')
            ->where('o.codRecurso = :codRecurso')
            ->andWhere('o.exercicio >= :anoInicio')
            ->andWhere('o.exercicio <= :anoFinal')
            ->setParameters(
                array(
                    'codRecurso' => $object->getCodRecurso(),
                    'anoInicio' => $periodo->getAnoInicio(),
                    'anoFinal' => $periodo->getAnoFinal()
                )
            )
            ->getQuery()
            ->getSingleScalarResult();

        if ($acaoRecurso > 0 || $recursoDestinacao > 0 || $reciboExtraRecurso > 0 || $transferenciaRecurso > 0 || $valorLancamentoRecurso > 0 || $transferenciaRecurso > 0 || $planoRecurso > 0 || $receita > 0 || $despesa > 0) {
            return false;
        }
        return true;
    }

    /**
     * @param $object
     * @return int
     */
    public function verificaCodRecursoExiste($object)
    {
        $return = array();

        if (is_callable([$object, 'getCodRecurso'])) {
            $sql = "select r.cod_recurso from orcamento.recurso r where cod_recurso = :cod_recurso;";

            $query = $this->entityManager->getConnection()->prepare($sql);
            $query->bindValue('cod_recurso', $object->getCodRecurso());
            $query->execute();

            $return['count'] = $query->rowCount();

            $sql = "select max(r.cod_recurso) as disponivel from orcamento.recurso r";
            $query = $this->entityManager->getConnection()->prepare($sql);
            $query->execute();
            $result = $query->fetch(\PDO::FETCH_OBJ);

            $return['disponivel'] = $result->disponivel + 1;
        } else {
            $return['count'] = 0;
        }
        return $return['count'];
    }

    /**
     * @param $object
     * @param $exercicio
     */
    public function manualSaveRecursoDireto($object, $exercicio)
    {
        $sql = "
        INSERT INTO orcamento.recurso_direto
        (cod_recurso_direto, cod_tipo_esfera, cod_fonte, exercicio, cod_recurso, nom_recurso, finalidade, tipo, codigo_tc)
        VALUES(nextval('orcamento.recurso_cod_recurso_direto_seq'::regclass), :cod_tipo_esfera, :cod_fonte, :exercicio, :cod_recurso, :nom_recurso, :finalidade, :tipo, :codigo_tc);";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindValue('cod_tipo_esfera', $object->getCodRecursoDireto()->getCodTipoEsfera()->getCodEsfera());
        $query->bindValue('cod_fonte', $object->getCodRecursoDireto()->getCodFonte()->getCodFonte());
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('cod_recurso', $object->getCodRecurso());
        $query->bindValue('nom_recurso', $object->getNomRecurso());
        $query->bindValue('finalidade', $object->getCodRecursoDireto()->getFinalidade());
        $query->bindValue('tipo', $object->getCodRecursoDireto()->getTipo());
        $query->bindValue('codigo_tc', $object->getCodRecursoDireto()->getCodigoTc());
        $query->execute();
    }

    /**
     * @param $paramsWhere
     * @return mixed
     */
    public function getRecursos($paramsWhere)
    {
        return $this->repository->findRecurso($paramsWhere);
    }

    /**
     * @param $object
     */
    public function salvaRecursosPeriodo($object)
    {
        $entityManager = $this->entityManager;
        $periodo = (new OrgaoModel($entityManager))->getPpaByExercicio($object->getExercicio());

        for ($i = (int) $periodo->getAnoInicio(); $i <= $periodo->getAnoFinal(); $i++) {
            if ($i != $object->getExercicio()) {
                $recurso = new Entity\Orcamento\Recurso();
                $recurso->setCodRecurso($object->getCodRecurso());
                $recurso->setExercicio($i);
                $recurso->setCodFonte(str_pad($object->getCodRecurso(), 4, "0", STR_PAD_LEFT));
                $recurso->setNomRecurso($object->getNomRecurso());

                $recursoDireto = clone $object->getFkOrcamentoRecursoDireto();
                $recursoDireto->setFkOrcamentoRecurso($recurso);
                $recursoDireto->setNomRecurso($recurso->getNomRecurso());

                $recurso->setFkOrcamentoRecursoDireto($recursoDireto);

                $entityManager->persist($recurso);
            }
        }

        $entityManager->flush();
    }

    /**
     * @param $object
     */
    public function atualizaRecursosPeriodo($object)
    {
        $entityManager = $this->entityManager;
        $periodo = (new OrgaoModel($entityManager))->getPpaByExercicio($object->getExercicio());

        for ($i = (int) $periodo->getAnoInicio(); $i <= $periodo->getAnoFinal(); $i++) {
            if ($i != $object->getExercicio()) {
                $recurso = $entityManager->getRepository('CoreBundle:Orcamento\Recurso')
                    ->findOneBy([
                        'exercicio' => $i,
                        'codRecurso' => $object->getCodRecurso()
                    ]);

                $recurso->setNomRecurso($object->getNomRecurso());

                $recursoDireto = $recurso->getFkOrcamentoRecursoDireto();
                $recursoDireto->setFkOrcamentoRecurso($recurso);
                $recursoDireto->setNomRecurso($object->getNomRecurso());
                $recursoDireto->setTipo($object->getFkOrcamentoRecursoDireto()->getTipo());
                $recursoDireto->setCodigoTc($object->getFkOrcamentoRecursoDireto()->getCodigoTc());
                $recursoDireto->setFkOrcamentoFonteRecurso($object->getFkOrcamentoRecursoDireto()->getFkOrcamentoFonteRecurso());
                $recursoDireto->setFkAdministracaoEsfera($object->getFkOrcamentoRecursoDireto()->getFkAdministracaoEsfera());
                $recursoDireto->setFinalidade($object->getFkOrcamentoRecursoDireto()->getFinalidade());

                $entityManager->persist($recurso);
            }
        }

        $entityManager->flush();
    }

    /**
     * @param $object
     */
    public function apagaRecursosPeriodo($object)
    {
        $entityManager = $this->entityManager;
        $periodo = (new OrgaoModel($entityManager))->getPpaByExercicio($object->getExercicio());

        for ($i = (int) $periodo->getAnoInicio(); $i <= $periodo->getAnoFinal(); $i++) {
            if ($i != $object->getExercicio()) {
                $recurso = $entityManager->getRepository('CoreBundle:Orcamento\Recurso')
                    ->findOneBy([
                        'exercicio' => $i,
                        'codRecurso' => $object->getCodRecurso()
                    ]);

                $entityManager->remove($recurso);
            }
        }

        $entityManager->flush();
    }

    /**
     * @param $codRecurso
     * @param $exercicio
     * @return null|object
     */
    public function findOneByCodRecursoAndExercicio($codRecurso, $exercicio)
    {
        return $this->repository->findOneBy(['codRecurso' => $codRecurso, 'exercicio' => $exercicio]);
    }
}
