<?php

namespace Urbem\CoreBundle\Model\Orcamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Orcamento\Orgao;

class OrgaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Orcamento\Orgao");
    }

    /**
     * @param $exercicio
     * @return mixed
     */
    public function getPpaByExercicio($exercicio)
    {
        $em = $this->entityManager;
        $qb = $em->getRepository('CoreBundle:Ppa\Ppa')->createQueryBuilder('ppa');
        $qb->where('ppa.anoInicio <= :anoAtual');
        $qb->andWhere('ppa.anoFinal >= :anoAtual');
        $qb->setParameter('anoAtual', $exercicio);
        
        $ppa = $qb->getQuery()->getResult();
        
        if (is_array($ppa)) {
            return $ppa[0];
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getCurrentNumber()
    {
        $em = $this->entityManager;
        $query = $em->getRepository('CoreBundle:Orcamento\Orgao')->createQueryBuilder('org');
        $query->select('org.numOrgao');
        $query->where('org.exercicio = :anoAtual');
        $query->setParameter('anoAtual', date("Y"));
        $query->orderBy('org.numOrgao', 'DESC');
        $query->setMaxResults('1');
        $currentNumber = $query->getQuery()->getResult();
        $incNumber = array_shift($currentNumber)['numOrgao'] + 1;

        return $incNumber;
    }

    /**
     * @param $numOrgao
     * @return mixed
     */
    public function getOrgaosByNumOrgao($numOrgao)
    {
        $em = $this->entityManager;

        $orgaos = $em->getRepository('CoreBundle:Orcamento\Orgao')
            ->findByNumOrgao($numOrgao, ['exercicio' => 'ASC']);

        return $orgaos;
    }

    /**
     * @param $exercicio
     * @return array
     */
    public function getOrgaoByExercicioForChoiceType($exercicio)
    {
        $qb = $this->repository->getByExercicioAsQueryBuilder($exercicio);
        $orgaos = $qb->getQuery()->getArrayResult();
        $data = [];

        foreach ($orgaos as $orgao) {
            $key = $orgao['numOrgao'] . ' - ' . $orgao['nomOrgao'];
            $data[$key] = $orgao['numOrgao'];
        }

        return $data;
    }
}
